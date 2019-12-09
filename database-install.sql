/*****************************************************************************
Title:  	Developer Wiki
Use:     	Final Project - Store useful snippets related to development
Author:  	Alex Fleming
School:  	Southern Illinois University
Term:    	Fall 2019
Developed:  11/30/19
Tested:     12/08/19
******************************************************************************/


/* 
---------------------------
Create Database Scripts 
---------------------------
*/

/* Create Database Itself */
CREATE DATABASE devwiki;

/* Create Tables */
CREATE TABLE snippets
(
    snippet_id int NOT NULL AUTO_INCREMENT,
    snippet_title TEXT,
    snippet_body MEDIUMTEXT,
    snippet_source TEXT,
    snippet_date DATETIME,
    PRIMARY KEY (snippet_id)
);

CREATE TABLE pinned
(
    snippet_id int NOT NULL AUTO_INCREMENT,
    snippet_title TEXT,
    snippet_body MEDIUMTEXT,
    snippet_source TEXT,
    snippet_date DATETIME,
    PRIMARY KEY (snippet_id)
);

/* Insert data into Table */
INSERT INTO snippets (snippet_title, snippet_body, snippet_source, snippet_date)
VALUES 
    ('This is a test', 'Snippet Body', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',''),
    ('This is a test2', 'Snippet Body2', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',''),
    ('This is a test3', 'Snippet Body3', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ','');

INSERT INTO pinned (snippet_title, snippet_body, snippet_source, snippet_date)
VALUES 
    ('This is a pinned test', 'Snippet Body', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',''),
    ('This is a pinned test2', 'Snippet Body2', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',''),
    ('This is a pinned test3', 'Snippet Body3', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ','');










/* 
------------------------------
Queries used in PHP Files:
------------------------------
*/


/* 

1. Snippet Display Queries 
------------------------------
*/

/* List Pinned Snippets */
SELECT * FROM snippets
ORDER BY snippet_id;

/* List Snippets */
SELECT * FROM snippets
ORDER BY snippet_id;



/* 

2. Add Snippet Queries 
------------------------------
*/

/* Add to Pinned Snippets */
INSERT INTO pinned
(snippet_title, snippet_body, snippet_source, snippet_date)
VALUES
(:snippet_title, :snippet_body, :snippet_source, :snippet_date);

/* Add to Snippets */
INSERT INTO snippets
(snippet_title, snippet_body, snippet_source, snippet_date)
VALUES
(:snippet_title, :snippet_body, :snippet_source, :snippet_date);



/* 

3. Edit Snippet Queries 
------------------------------
*/

/* List Specific Pinned Snippet */
SELECT * FROM pinned
WHERE snippet_id = :snippetID;

/* List Specific Snippet */
SELECT * FROM snippets
WHERE snippet_id = :snippetID;
    
/* Update Specific Pinned Snippet */
UPDATE pinned
SET
snippet_title = :snippet_title,
snippet_body = :snippet_body,
snippet_source = :snippet_source,
snippet_date = :snippet_date,
WHERE
snippet_id = :snippet_id;

/* Update Specific Snippet */
UPDATE snippets
SET
snippet_title = :snippet_title,
snippet_body = :snippet_body,
snippet_source = :snippet_source,
snippet_date = :snippet_date,
WHERE
snippet_id = :snippet_id;



/* 

4. Delete Snippet Queries 
------------------------------
*/

/* List Specific Pinned Snippet */
SELECT * FROM pinned
WHERE snippet_id = :snippetID;

/* List Specific Snippet */
SELECT * FROM snippets
WHERE snippet_id = :snippetID;

/* Delete from Pinned Snippets */
DELETE FROM pinned
WHERE snippet_id = :snippet_id;

/* Delete from Snippets */
DELETE FROM snippets
WHERE snippet_id = :snippet_id;



/* 

5. Snippet Pin Status Queries 
------------------------------
*/

/* List Specific Pinned Snippet */
SELECT * FROM pinned
WHERE snippet_id = :snippetID;

/* List Specific Snippet */
SELECT * FROM snippets
WHERE snippet_id = :snippetID;


/* Pin a Snippet */
/* Add to Pinned Snippets */
INSERT INTO pinned
(snippet_title, snippet_body, snippet_source, snippet_date)
VALUES
(:snippet_title, :snippet_body, :snippet_source, :snippet_date);

/* Delete from Snippets */
DELETE FROM snippets
WHERE snippet_id = :snippet_id;


/* Unpin a Snippet */
/* Add to Snippets */
INSERT INTO snippets
(snippet_title, snippet_body, snippet_source, snippet_date)
VALUES
(:snippet_title, :snippet_body, :snippet_source, :snippet_date);

/* Delete from Pinned Snippets */
DELETE FROM pinned
WHERE snippet_id = :snippet_id;

