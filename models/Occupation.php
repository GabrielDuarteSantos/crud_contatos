<?php

require_once 'Database.php';

class Occupation {

    private $name;

    public function __construct($occupation) {

        $this->name = $occupation['name'];

    }

    public function create() {

        $db = Database::getConnection();
        $statement = $db->prepare('INSERT INTO occupations (`name`) VALUES (?)');

        $statement->bindValue(1, $this->name);
        $statement->execute();

        return ['id' => $db->lastInsertId()];

    }

    public static function getByName($name) {

        $db = Database::getConnection();
        $statement = $db->prepare('SELECT * FROM occupations WHERE `name` = ?');

        $statement->bindValue(1, $name);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

    }

}