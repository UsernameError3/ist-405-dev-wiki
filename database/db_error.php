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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Developer Wiki</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0; width=device-width">
</head>

<body>
    <main>
        <h1>Database Error</h1>
        <p>There waas an error connecting to the database.</p>
        <p>Error Message: <?php echo $error_message; ?></p>

        <span>
            <a id="nav-controls" href="index.php">Home Page</a>
        </span>
    </main>
</body>

</html>