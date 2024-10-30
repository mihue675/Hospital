<?php
class db_constants
{
    const servername = "localhost";
    const database = "hospital";
    const username = "root";
    const password = "";

    public static function Server()
    {
        return self::servername;
    }

    public static function DataBase()
    {
        return self::database;
    }

    public static function User()
    {
        return self::username;
    }

    public static function Password()
    {
        return self::password;
    }
}
