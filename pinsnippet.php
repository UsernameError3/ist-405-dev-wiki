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

$pinned = false;

// Load Snippet From Database
function list_snippet($pinStatus) {

    $snippetID = filter_input(INPUT_POST, 'snippet_id', FILTER_VALIDATE_INT);

    if ($pinStatus == true) {
        // List all snippets
        $query_snippets = 'SELECT * FROM pinned
                           WHERE snippet_id = :snippetID';

    } elseif ($pinStatus == false) {
        // List all unpinned snippets
        $query_snippets = 'SELECT * FROM snippets
                           WHERE snippet_id = :snippetID';

    } else {
        $error_message = "Invalid snippet status.";
        include('../database/db_error.php');
    }

    $db_list_snippets = $db->prepare($query_snippets);
    $db_list_snippets->bindValue(':snippetID', $snippet_id);
    $db_list_snippets->execute();
    $snippet = $db_list_snippets->fetchAll();
    $db_list_snippets->closeCursor();
}

// Send Snippet Update to Database
function update_pinstatus($pinStatus) {

    // Collect Inputs
    $current_snippet_id = filter_input(INPUT_POST, 'snippet_id', FILTER_VALIDATE_INT);
    $new_snippet_title = filter_input(INPUT_POST, 'snippet_title');
    $new_snippet_body = filter_input(INPUT_POST, 'snippet_body');
    $new_snippet_source = filter_input(INPUT_POST, 'snippet_source');
    $new_snippet_date = date("Y-m-d h:i:s");

    // Validate Pin Status
    if ($pinStatus == true) {
        $query_update_snippet = 'INSERT INTO pinned
                                 (snippet_title, snippet_body, snippet_source, snippet_date)
                                 VALUES
                                 (:snippet_title, :snippet_body, :snippet_source, :snippet_date)';

        $query_delete_snippet = 'DELETE FROM snippets
                                 WHERE snippet_id = :snippet_id';

    } elseif ($pinStatus == false) {
        $query_update_snippet = 'INSERT INTO snippets
                                 (snippet_title, snippet_body, snippet_source, snippet_date)
                                 VALUES
                                 (:snippet_title, :snippet_body, :snippet_source, :snippet_date)';

        $query_delete_snippet = 'DELETE FROM pinned
                                 WHERE snippet_id = :snippet_id';

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

        $db_update_snippet = $db->prepare($query_update_snippet);
        $db_update_snippet->bindValue(':snippet_title', $new_snippet_title);
        $db_update_snippet->bindValue(':snippet_body', $new_snippet_body);
        $db_update_snippet->bindValue(':snippet_source', $new_snippet_source);
        $db_update_snippet->bindValue(':snippet_date', $new_snippet_date);
        $success = $db_update_snippet->execute();
        $db_update_snippet->closeCursor();

        $db_delete_snippet = $db->prepare($query_delete_snippet);
        $db_delete_snippet->bindValue(':snippet_id', $deleteSnippet);
        $success = $db_delete_snippet->execute();
        $db_delete_snippet->closeCursor();

        if ($pinned == true) {
            include('pinned.php');
        } elseif ($pinned == false) {
            include('snippets.php');
        } else {
            include('index.php');
        }
    }
    
}

// Display Unpinned Snippet when edited from snippets.php on Form Submit.
if ( isset($_POST['pinstatus_unpin']) ) {
    $pinned = true;
    list_snippet($pinned);
    $pinned = false;
}

// Display Pinned Snippet when edited from pinned.php on Form Submit.
if ( isset($_POST['pinstatus_pin']) ) {
    $pinned = false;
    list_snippet($pinned);
    $pinned = true;
}

// Edit Record On Form Submit
if ( isset($_POST['pinstatus']) ) {    
    update_pinstatus($pinned);
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
    </div>

    <div id="content">
        <div id="form" class="container">
            <form action="editsnippet.php" id="edit_snippet" method="post">    
                <div class="form-inputs">
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
                            <p class="item-title"><?php echo $snippet['snippet_title'];?></p>
                            <p class="item-body"><?php echo $snippet['snippet_body'];?></p>
                            <p class="item-link"><?php echo $snippet['snippet_source'];?></p>
                        </td>
                        <td>
                            <input type="hidden" name="snippet_id" value="<?php echo $snippet['snippet_id'];?>">
                            <p> </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>