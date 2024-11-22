<?php
function connectDb()
{
    try {
        $connection = new PDO("mysql:host=localhost;dbname=devops", "arafath", "@arafath@");
        return $connection;
    } catch (Throwable $error) {
        echo $error->getMessage();
    }
}
