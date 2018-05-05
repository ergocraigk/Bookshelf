<?php
/**
 * This file handles all database communications
 * for the bookshelf application. Functions are called
 * from the controller.
 *
 * @author Craig Koch
 * @version TBD
 */

/**
 * tests the database connection, sets the database connection variables,
 * & returns error information if it errors out
 */
    function testConnection(){
        require '../../DBbooks.php';
        //error_reporting(E_ALL);
        //attempt a database connection, display error message if fail
        try{
            $dbh = new PDO("mysql:host=$hostname;
                            dbname=ckochgre_Books", $username, $password);
            return $dbh;
        }catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

/**
 * Insert a new book into the database.
 * Uses posted data and PDO's for security.
 */
    function insertBook(){
        //test connection and set db connection fields
        $dbh = testConnection();

        $title = $_POST['title'];
        $fiction = $_POST['fiction'];
        $publisher = $_POST['publisher'];
        $pages = $_POST['pages'];
        $summary = $_POST['summary'];
        //check the post data an convert it to boolean values for database compatability
        if($fiction == "Yes"){
            $fiction = 1;
        }elseif ($fiction == "No"){
            $fiction = 0;
        }else{
            //do nothing
        }

        //prepare a PDO statement to insert data into the database
        $sqlInsert = "INSERT INTO `Books` (title, fiction, publisher, summary, pages) 
                                   VALUES (:title, :fiction, :publisher, :summary, :pages)";
        $preparedInsert = $dbh->prepare($sqlInsert);

        $preparedInsert->bindParam(':title', $title);
        $preparedInsert->bindParam(':fiction', $fiction);
        $preparedInsert->bindParam(':publisher', $publisher);
        $preparedInsert->bindParam(':summary', $summary);
        $preparedInsert->bindParam(':pages', $pages);

        return $preparedInsert->execute();
    }
/**
 * Pulls all books from the database to be displayed
 */
    function getBooksForDisplay(){
        //test connection and set db connection fields
        $dbh = testConnection();

        //prepares a sql statement with PDO's to return all entries in the
        //Books table, executes the PDO, and saves the returned data for later use
        $sqlSelect = "SELECT * FROM Books";
        $preparedSelect = $dbh->prepare($sqlSelect);
        $preparedSelect->execute();
        return $preparedSelect->fetchAll();
    }
/**
 * Pulls data from session variables to reenter a book into the database
 */
    function reinsertBook(){
        //test connection and set db connection fields
        $dbh = testConnection();

        //prepare a PDO statement to insert the book data back into the database
        $sqlInsert = "INSERT INTO `Books` (title, fiction, publisher, summary, pages) 
                                       VALUES (:title, :fiction, :publisher, :summary, :pages)";
        $preparedInsert = $dbh->prepare($sqlInsert);

        $preparedInsert->bindParam(':title', $_SESSION['resultsInSession']['title']);
        $preparedInsert->bindParam(':fiction', $_SESSION['resultsInSession']['fiction']);
        $preparedInsert->bindParam(':publisher', $_SESSION['resultsInSession']['publisher']);
        $preparedInsert->bindParam(':summary', $_SESSION['resultsInSession']['summary']);
        $preparedInsert->bindParam(':pages', $_SESSION['resultsInSession']['pages']);

        //perform undo delete and set flag if update fails
        return $preparedInsert->execute();
    }
/**
 * Pulls specific book's data from the database based
 * on id paramter
 *
 * @param int $id usually pulled from get variable to identify a particular book
 */
    function getSpecificBook($id){
        //test connection and set db connection fields
        $dbh = testConnection();

        //pull the selected id to populate fields for editing later
        $sqlPullSelected = "SELECT * FROM Books WHERE id=:id";
        $preparedSelect = $dbh->prepare($sqlPullSelected);
        $preparedSelect->bindParam(':id', $id);
        $preparedSelect->execute();
        return $preparedSelect->fetch();
    }
/**
 * Deletes a book from the database based on the provided id
 *
 * @param int $id usually pulled from get variable to identify a particular book
 */
    function deleteBook($id){
        //test connection and set db connection fields
        $dbh = testConnection();

        //delete from Books table the selected entry
        $sqlDelete = "DELETE FROM Books WHERE id=:id";
        $preparedDelete = $dbh->prepare($sqlDelete);
        $preparedDelete->bindParam(':id', $id);
        return $preparedDelete->execute();
    }
/**
 * edits a books data based on the provided id
 *
 * @param int $id usually pulled from get variable to identify a particular book
 */
    function updateBook($id){
        //test connection and set db connection fields
        $dbh = testConnection();

        //prepare a PDO statement to update data in the database
        $sqlUpdate = "UPDATE `Books` SET `title` = :title, `fiction` = :fiction, `publisher` = :publisher, `summary` = :summary, `pages` = :pages WHERE `Books`.`id`=:id";
        $preparedUpdate = $dbh->prepare($sqlUpdate);

        $preparedUpdate->bindParam(':id', $id);
        $preparedUpdate->bindParam(':title', $_POST['title']);
        $preparedUpdate->bindParam(':fiction', $_POST['fiction']);
        $preparedUpdate->bindParam(':publisher', $_POST['publisher']);
        $preparedUpdate->bindParam(':summary', $_POST['summary']);
        $preparedUpdate->bindParam(':pages', $_POST['pages']);

        //perform update and set flag if update fails
        $updateCheck = $preparedUpdate->execute();
        if($updateCheck == true){
            header("Location: index.php?page=view");
        } else {
            return "yes";
        }
    }
?>