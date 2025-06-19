<?php
class Database {
    public static function Conectar() {
        $dbUser = getenv('DB_USER');
        $dbPass = getenv('DB_PASS');
        $dbName = getenv('DB_NAME');
        // $timezone = "America/Bogota";
        $pdo = new PDO("mysql:host=mysql;dbname=$dbName;charset=utf8", "$dbUser", "$dbPass");
        // $pdo->exec("SET time_zone = '{$timezone}'");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}