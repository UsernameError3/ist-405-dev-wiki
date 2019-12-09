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

// Send Snippet Update to Database
function add_snippet($pinStatus) {

    // Collect Inputs
    $current_snippet_id = filter_input(INPUT_POST, 'snippet_id', FILTER_VALIDATE_INT);
    $new_snippet_title = filter_input(INPUT_POST, 'snippet_title');
    $new_snippet_body = filter_input(INPUT_POST, 'snippet_body');
    $new_snippet_source = filter_input(INPUT_POST, 'snippet_source');
    $new_snippet_date = date("Y-m-d h:i:s");

    // Validate Pin Status
    if ($pinStatus == true) {
        $query_add_snippet = 'INSERT INTO pinned
                              (snippet_title, snippet_body, snippet_source, snippet_date)
                              VALUES
                              (:snippet_title, :snippet_body, :snippet_source, :snippet_date)';

    } elseif ($pinStatus == false) {
        $query_add_snippet = 'INSERT INTO snippets
                              (snippet_title, snippet_body, snippet_source, snippet_date)
                              VALUES
                              (:snippet_title, :snippet_body, :snippet_source, :snippet_date)';
    } else {
        $error_message = "Invalid snippet status. Add Failed.";
        include('../database/db_error.php');
    }

    // Validate inputs
    if ($current_snippet_id == null || $current_snippet_id == false || 
        $new_snippet_title == null || $new_snippet_title == false || 
        $new_snippet_body == null || $new_snippet_body == false || 
        $new_snippet_source == null || $new_snippet_source == false ) {
            $error_message = "Invalid snippet data. Check all fields and try again.";
            include('../database/db_error.php');
    } else {
        require_once('../database/db_conn.php');

        $db_add_snippet = $db->prepare($query_add_snippet);
        $db_add_snippet->bindValue(':snippet_title', $new_snippet_title);
        $db_add_snippet->bindValue(':snippet_body', $new_snippet_body);
        $db_add_snippet->bindValue(':snippet_source', $new_snippet_source);
        $db_add_snippet->bindValue(':snippet_date', $new_snippet_date);
        $success = $db_add_snippet->execute();
        $db_add_snippet->closeCursor();

        if ($pinned == true) {
            include('pinned.php');
        } elseif ($pinned == false) {
            include('snippets.php');
        } else {
            include('index.php');
        }
    }
    
}

// Check Pin Status
if ( isset($_POST['pinstatus']) ) {    
    if ($_POST['pinstatus'] == true) {
        $pinned = true;
    } elseif ($_POST['pinstatus'] == true) {
        $pinned = false;
    }
}

// Edit Record On Form Submit
if ( isset($_POST['save']) ) {    
    add_snippet($pinned);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Developer Wiki</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0; width=device-width">
</head>

<body>
    <div id="nav">
        <span>
            <a id="nav-controls" href="index.php">Home Page</a>
        </span>
        <span>
            <a id="nav-controls" href="pinned.php">Pinned Page</a>
        </span>
        <span>
            <a id="nav-controls" href="snippets.php">Snippets Page</a>
        </span>
        </span>
    </div>

    <div id="content">
        <div id="form" class="container">
            <form action="addsnippet.php" id="add_snippet" method="post">    
                <div class="form-inputs">
                    <label>Snippet Title:</label><br>
                    <input type="text" value="" name="snippet_Title"><br>
                    <label>Snippet Body:</label><br>
                    <input type="text" value="" name="snippet_Body"><br>
                    <label>Snippet Source:</label><br>
                    <input type="text" value="" name="snippet_Source"><br>
                    <label>Pin Snippet?</label><br>
                    <input type="checkbox" id="pinstatus" name="pinstatus">
                    <!-- Snippet ID -->
                    <input type="hidden" name="snippet_id" value="">
                </div>

                <input type="reset" id="form-controls" name="reload" value="Clear">
                <input type="submit" id="form-controls" name="save" value="Save">
            </form>
        </div>
        
        <div id="snippets" class="container">
            <!-- List Snippets -->
            <div class="item">
                <table>
                    <tr>
                        <td>
                            <p class="item-title">Example Snippet</p>
                            <p class="item-body">Put anything here.</p>
                            <p class="item-link">https://www.google.com</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>