<?php

class Tree {
 
    private $db = null;
    private $filesArr = array();	//массив для структуры файлов
	const DBNAME = 'tst_vio';	//при необходимости измените название базы
	const HOST = 'localhost';	//при необходимости измените host
	const USER = 'root';	//укажите пользователя для подключения к бд
	const PASWD = '';	//укажите пароль пользователя

    public function __construct() {
        $this->db = new PDO("mysql:dbname=".self::DBNAME."; host=".self::HOST, self::USER, self::PASWD);	//при создании объекта Tree инициализируем подключение к базе
        $this->filesArr = $this->getAllFiles();	//создаем массив структуры файлов для последующей работы с ним
    }

	//метод вовзращающий двумерный массив в котором первый ключ id директории
    private function getAllFiles()
	{
        $query = $this->db->prepare("SELECT * FROM `files`");	//вытаскиваем все файлы и директории из таблицы
        $query->execute();
		$result = $query->fetchAll(PDO::FETCH_OBJ);
        $return = array();
        foreach ($result as $file) { //Обходим массив
            $return[$file->parent_id][] = $file;	//создаем двумерный массив в котором, элементы массива включают в себя массивы у которых одинаковые parent_id
        }
        return $return;
    }
 
	//вывод на экран сутруктуры файлов
    public function buildTree($parent_id, $indent=1) {	//передаем в функцию parent_id и отступ, по умолчанию установлен 1
	
		if (isset($this->filesArr[$parent_id])) {	//если в подготовленном многомерном массиве $this->filesArr существует ключ(и) со значением $parent_id
		
            foreach ($this->filesArr[$parent_id] as $file) { //тогда обходим по элементам в под массиве
                echo "<div style='margin-left:" . ($indent * 30) . "px;'>" . $file->name ."</div>"; //выводим name, $ident используется для оформления отступа вложенности директорий и файлов          
				$indent++; //Увеличиваем уровень вложености
                $this->buildTree($file->id, $indent);	//рекурсивно вызываем функцию, если $id директории нету в массиве $this->filesArr, то функция не выполнится
                $indent--; //Уменьшаем уровень вложености
            }
        }
    }
	
	public function getId($name)	// метод по названию папки достает её ид
	{
		$query = $this->db->prepare("SELECT (id) FROM `files` WHERE type='dir' AND name like '". $name ."'"); //достаем только из dir
        $query->execute();
		$res = $query->fetchAll(PDO::FETCH_COLUMN);
		if ($res){
			return $res[0];	//возвращаем id папки
		}else{
			return false;
		}
	}

}

$tree = new Tree();	//создаем объект
$dir = 'c:';	//указываем папку
$dirId = $tree->getId($dir);
if ($dirId){
	$tree->buildTree($dirId); //выводим структуру файлов, $dirId = 0; выведет список полностью
}else{
	echo 'Указанной папки не существует.';
}