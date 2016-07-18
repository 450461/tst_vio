<?php

 class User {
	private $db;
    private static $_instance;
	private static $id;
	const ERR = 'Неверный параметр входных данных, ошибка ';
	const ERRSET = 'Действие для set не задано или указано неверно.';
	const DBNAME = 'tst_vio';	//ghb необходимости измените название базы
	const HOST = 'localhost';	//по умиолчанию localhost
	const USER = 'root';	//укажите пользователь для подключения к бд
	const PASWD = '';	//укажите пароль пользователя

    private function __construct() {
		$this->db = new Mysqli(self::HOST, self::USER, self::PASWD, self::DBNAME) or die(mysql_error());	//подключаемся к базе
    }

    public static function getInstance($id=0) {
		self::$id = (int)$id;	//приводим входящий $id к integer
        if (self::$_instance === null) {	//если объект не существует, то
            self::$_instance = new self;  		//	создаем новый объект
        }
        return self::$_instance;	//иначе возвращаем который уже есть
    }
 
    private function __clone() {
    }

    private function __wakeup() {
    }

	private function getFromDb(){	//метод для выборки данных из базы
		return  $this->db->query("SELECT * FROM users where id=".self::$id)->fetch_assoc();
	}
	
	private function setToDb(array $arr){	//метод для записи данных в базу
		$serialData = $this->serial($arr);
		$serialData = $this->db->real_escape_string($serialData);
		$this->db->query("UPDATE users SET storage='".$serialData."' where id=".self::$id."") ;
	}

	public function  addNewUser(array $dataUser){	//метод для занесения нового юзера в базу
		$serialData = $this->db->real_escape_string(	$this->serial($dataUser)	);
		$this->db->query("INSERT INTO users (storage) VALUES('".$serialData."')");
	}
	
	public function get($params){	//достаем данные из базы
		$query = $this-> getFromDb();
		if ($query ){
			$arParam = $this-> parseParam($params);	//приводим к нужному виду запрос от пользователя, что именно достаем
			$arr = self:: unSerial($query);		//приводим к "нормальному виду" данные из базы
			return $this-> displayQuery($arr, $arParam); //получаем данные и возвращаем их
		}else{
			return "Пользователь с таким id в базе не существует";
		}
	}

	public function set( $section, array $setParams){	//передаем строку 'секцию/раздел/действие' и массив с новыми параметрами
		$sectionArr = ( explode('/', $section));	//разбираем строку
		$action = ( array_pop ($sectionArr)  );		//определяем что нужно сделать
		switch ($action){
			case 'new':		// задан new, так по условию в задании
						$query = $this-> getFromDb();	//достаем данные из базы 
						$arr = self:: unSerial($query);		//приводим к читаемому виду	
						$section = $sectionArr['0'];
						if (empty($sectionArr[1])){		//если раздел не указан
							$arr[$section] = array_replace_recursive( $arr[$section], $setParams );	//заменяем значения в массиве на новые
							$this->setToDb($arr);	//сохраняем в базе
						}else{	//если второго параметра нету		
							$item = $sectionArr['1'];
							$arr[$section][$item] = array_replace_recursive( $arr[$section][$item], $setParams );
							$this->setToDb($arr);
						}
						return 'Данные обновлены';
						break;
			case 'newUser':		//если задан этот параметр то добавляем нового юзера в базу
						$this->addNewUser($setParams);
						return 'Пользователь добавлен';
						break;
			default: throw new Exception(self::ERRSET);
		}
	}

	private static function serial($data){
		return serialize($data);
	}

	private static function unSerial($data){
		return  unserialize($data['storage']);
	}

	private function parseParam($params){
		return explode('/',$params);	//обрабатываем пользовательский запрос
	}

	private function displayQuery($arr, $params){
		$param0 = $params[0];	//первый парметр
		$param1 = $params[1];	//второй
		if( array_key_exists($param0, $arr)){	//если первый параметр существует в массиве как ключ, то
			if( empty($param1)){	//если второй параметр пустой
				return  $arr[$param0];	//возвращаем данные по первому параметру
			} elseif (!array_key_exists($param1, $arr[$param0])){	//если несущ. такой ключ в массиве
				throw new Exception(self::ERR.'во втором параметре.'); 				// то выдаем ошибку
			}else{
				return $arr[$param0][$param1] ;	//иначе выводим запрошенные данные
			}
		}elseif (empty($param0)){	//если параметр того что хотим увидеть не передан, тоесть пуст то
			return $arr;	//	выводим весь массив данных по юзеру
		}else{
			throw new Exception(self::ERR.'в первом параметре.');	//если ошибка в первом параметре то выводим ошибку
		}
	}
}

echo'<pre>';
$id = 21;	//задаем id юзера в базе
$user = User::getInstance($id);	//создем объект User

/*-------
вывод юзер данных:
	например пустое значение
		или 'home'
			или 'home/city',	'home/location'
				или 'work/hobby' и т.д., список всех значенией для проверки можно увидет оставив передаваемый параметр пустым
*/
//print_r($user->get("work/hobby"));
print_r($user->get(""));	

/*-------
обновление юзер данных:
	аналогично чтению данных, только в метод передается раздел который будем обновлять и непосредственно данные
		('home/', ['city'=>'spb','house' => '23']);
			или например 
				('work/hobby/new', ['location'=>'ClubRally','post' => 'RallyDriver'])
					обратите внимание, в конце строки 'work/hobby/new' необходимо указать что хотим делать.
*/
//$user -> set('work/hobby/new', ['location'=>'sportClub','post' => 'yoga']);
//print_r($user -> set('home/location/new', ['lat'=>'44','long' => '55']));
//print_r($user->get(""));	//сразу увидим обновления

/*------
добавление нового юзера:
*/
/*
$arrUserData = [	//создаем массив с данными для нового пользователя
			'home' => [
						'city' =>'valday',
						'street' =>'ozerskay',
						'house' =>'9',
						'location' => [
										'lat' => '44',
										'long' => '55'
									],
					],
			'work' => [
						'main' =>[
									'organization' => 'recreationСenter',
									'post' => 'manager'
								],
						'hobby' => [
									'location' => 'sportClub',
									'post' => 'yoga',
						
								],			
					],
			'age' => '31'		
		];	
print_r($user -> set('newUser', $arrUserData));	//передаем в метод указание создать нового пользователя и массив со значениями
*/