<?php

/*****************************************************************************
Title:  	Developer Wiki
Use:     	Final Project - Store useful snippets related to development
Author:  	Alex Fleming
School:  	Southern Illinois University
Term:    	Fall 2019
Developed:  11/30/19
Tested:     12/08/19
******************************************************************************/

$dsn = 'mysql:host=localhost;db_name=devwiki';
$username = 'root';
$password = 'P@ssword1';

try {
    $db = new PDO ($dsn, $username, $password);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include('db_error.php');
    exit();
}
?>