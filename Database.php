<?php

class Database {

    protected static $dbConnection;

    private function __construct() {

        $dbHost = '';
        $dbName = '';
        $dbUser = '';
        $dbPass = '';

        $pdoOptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $pdoConnectionStr = 'mysql:host='.$dbHost.'; dbname='.$dbName.'; charset=utf8';

        try {

            self::$dbConnection = new PDO($pdoConnectionStr, $dbUser, $dbPass, $pdoOptions);

        } catch (PDOException $err) {

            die('Database connection error: '.$err->getMessage());

        }

    }

    public static function getConnection() {

        if (!self::$dbConnection) {

            new Database();

        }

        return self::$dbConnection;

    }

}