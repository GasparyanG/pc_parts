<?php


namespace App\Database;


class PlainConnection
{
    public static function connection(): \mysqli
    {
        $databaseCredentials = json_decode(file_get_contents(__DIR__ . "/../../config/database.json"), true);

        $serverName = Connection::getDatabaseHost($databaseCredentials);
        $databaseName = Connection::getDatabaseName($databaseCredentials);
        $user = Connection::getDatabaseUser($databaseCredentials);
        $password = Connection::getDatabasePassword($databaseCredentials);

        $conn = new \mysqli(
            $serverName,
            $user,
            $password,
            $databaseName
        );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected successfully\n";

        return $conn;
    }
}