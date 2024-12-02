<?php
const DB_SERVER = "LOCALHOST";
const DB_USERNAME = "db_user";
const DB_PASSWORD = "Password123";
const DB_NAME = "finalProject";

function getDB(){
    try{
        $pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    catch(PDOException $e){
       die("Error: Could not connect to the database." . $e-> getMessage());
    }

}