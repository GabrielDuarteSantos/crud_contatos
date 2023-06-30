<?php

require_once 'Database.php';

class Occupation {

    private $name;

    public function __construct($occupation) {

        $this->name = $occupation['name'];

    }

    public function create() {

        $db = Database::getConnection();

        $query = 'INSERT INTO occupations (`name`) VALUES (?)';

        $statement = $db->prepare($query);

        $statement->bindValue(1, $this->name);
        $statement->execute();

        return ['id' => $db->lastInsertId()];

    }

    public static function getByName($name) {

        $db = Database::getConnection();

        $query = 'SELECT * FROM occupations WHERE `name` = ?';

        $statement = $db->prepare($query);

        $statement->bindValue(1, $name);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

    }

}