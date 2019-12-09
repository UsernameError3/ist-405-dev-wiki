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

// List all snippets
$query_unpinned = 'SELECT * FROM snippets
                 ORDER BY snippet_id';

$db_list_query = $db->prepare($query_unpinned);
$db_list_query->execute();
$snippets = $db_list_query->fetchAll();
$db_list_query->closeCursor();


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
            <a id="nav-controls" href="addsnippet.php">Add Snippet</a>
        </span>
        <span>
            <a id="nav-controls" href="pinsnippet.php">Pin Snippet</a>
        </span>
    </div>

    <div id="content">
        <div id="form" class="container">
            <div class="form-inputs">
                <h3>Select a Navigation Item</h3>
            </div>

            <button id="form-controls">Clear</button>
            <button id="form-controls">Save</button>

        </div>
        
        <div id="snippets" class="container">
            <!-- List Snippets -->
            <?php foreach ($snippets as $snippet) : ?>
                <div class="item">
                    <form action="editsnippet.php" method="post">    
                        <table>
                            <tr>
                                <td>
                                    <p class="item-title"><?php echo $snippet['snippet_title'];?></p>
                                    <p class="item-body"><?php echo $snippet['snippet_body'];?></p>
                                    <p class="item-link"><?php echo $snippet['snippet_source'];?></p>
                                    <input type="hidden" name="snippet_id" value="<?php echo $snippet['snippet_id'];?>">
                                </td>
                                <td>
                                    <input class="item-selection" type="submit" name="edit_unpinned" value="Edit">
                                </td>
                                <td>
                                    <input class="item-selection" type="submit" name="delete_unpinned" value="Delete">
                                </td>
                                <td>
                                    <input class="item-selection" type="submit" name="pinstatus_pin" value="Pin">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            <?php endforeach; ?>            
        </div>
    </div>
</body>

</html>