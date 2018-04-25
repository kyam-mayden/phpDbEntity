<?php

interface nameable {
    public function setName(string $name);
}

class User implements nameable{
    private $id;
    private $name;
    private $DOB;
    private $f_color;
    private $db;

    function __construct() {
        $this->db = $this->createDB();
        echo "$this->name object created, sick bruv, born on $this->DOB</br></br>";
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function createDB():PDO {
        $db = new PDO('mysql:host=127.0.0.1; dbname=exercises', 'root');
        return $db;
    }

    function __destruct() {
        $query=$this->db->prepare("UPDATE `children` SET `name`=:name, `DOB`=:DOB ,`f_color`=:f_color
                          WHERE `id`=:id");
        $query->bindParam(':id', $this->id);
        $query->bindParam(':name', $this->name);
        $query->bindParam(':DOB', $this->DOB);
        $query->bindParam(':f_color', $this->f_color);
        $query->execute();
        echo "$this->name object saved to database, NICE</br></br>";
    }
}

function connectDatabase() {
    $db = new PDO('mysql:host=127.0.0.1; dbname=exercises', 'root');
    return $db;
}

$db = connectDatabase();

function createObjects($db) {
    $query=$db->prepare("SELECT `id`, `name`, `DOB`, `f_color` FROM `children` LIMIT 3;");
    $query->setFetchMode(PDO::FETCH_CLASS, 'User');
    $query->execute();

    return $query->fetchAll();
}

$users = createObjects($db);

list($user1, $user2, $user3) = $users;




$user1->setName('Mike Oram');
$user2->setName('Karim Kefi');
$user3->setName('Osama Tahboub');