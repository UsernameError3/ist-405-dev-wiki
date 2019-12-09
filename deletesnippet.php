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
function delete_snippet($pinStatus, $deleteSnippet) {

    // Validate Pin Status
    if ($pinStatus == true) {
        $query_delete_snippet = 'DELETE FROM pinned
                                 WHERE snippet_id = :snippet_id';

    } elseif ($pinStatus == false) {
        $query_delete_snippet = 'DELETE FROM snippets
                                 WHERE snippet_id = :snippet_id';
    } else {
        $error_message = "Invalid snippet status. Delete Failed.";
        include('../database/db_error.php');
    }

    // Validate inputs
    if ($deleteSnippet == null || $deleteSnippet == false  ) {
            $error_message = "Missing Snippet ID.";
            include('../database/db_error.php');
    } else {
        require_once('../database/db_conn.php');

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

// Delete Unpinned Snippet
if ( isset($_POST['delete_unpinned']) ) {
    $pinned = false;
    list_snippet($pinned);
}

// Delete Pinned Snippet
if ( isset($_POST['delete_pinned']) ) {
    $pinned = true;
    list_snippet($pinned);
}

// Delete Pinned Snippet
if ( isset($_POST['delete']) ) {
    $deleteSnippet = filter_input(INPUT_POST, 'snippet_id', FILTER_VALIDATE_INT);
    delete_snippet($pinned, $deleteSnippet);
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
            <form action="deletesnippet.php" id="add_snippet" method="post">    
                <div class="form-inputs">
                    <label>Delete Snippet?</label><br>
                    <input type="checkbox" id="delete" name="delete">
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
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>