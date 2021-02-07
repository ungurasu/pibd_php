<?php

class DBConnection
{
    // Hold the class instance.
    private static $instance = null;

    private static $database = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        // The expensive process (e.g.,db connection) goes here.
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DBConnection();

            $logged_in = isset($_SESSION['is_logged_in']);
            if (!$logged_in)
                throw new Exception("Nu pot crea o conexiune la baza de date daca utilizatorul nu s-a conectat!");

            self::$database = new mysqli(
                $_SESSION['db_hostname'],
                $_SESSION['db_username'],
                $_SESSION['db_password'],
                $_SESSION['db_database'],
            );

            if (self::$database->connect_errno)
                throw new Exception("Conectarea la baza de date a esuat: " . self::$database->connect_error);
        }

        return self::$instance;
    }

    /***
     * @return mysqli
     */
    public static function getDB() {
        return self::$database;
    }
}