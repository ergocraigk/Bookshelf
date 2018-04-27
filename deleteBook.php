<?php
/**
 * This file creates a page which gives users the opportunity to undo a delete
 * if they regret their most recent life choice.
 *
 * @author Craig Koch
 * @version GIT: TBD
 */

    //track the users session data
    session_start();
    //pull in the database connection data
    require_once('../../DBbooks.php');

    //error_reporting(E_ALL);
    //attempt a database connection, display error message if fail
    try{
        $dbh = new PDO("mysql:host=$hostname;
                                    dbname=ckochgre_Books", $username, $password);
    }catch (PDOException $e){
        echo $e->getMessage();
    }

    //pull the selected id out of the url for query
    $id = $_GET['id'];

    //flag if undo delete fails
    $errorUpdate = null;
    if($_SERVER['REQUEST_METHOD'] == "POST"){

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
        $insertCheck = $preparedInsert->execute();
        if($insertCheck == true){
            header("Location: viewBooks.php");
        } else {
            $errorUpdate = "yes";
        }

    } else {
        //do nothing
    }

    //pull the selected id to populate fields for editing later
    $sqlPullSelected = "SELECT * FROM Books WHERE id=:id";
    $preparedSelect = $dbh->prepare($sqlPullSelected);
    $preparedSelect->bindParam(':id', $id);
    $preparedSelect->execute();
    $result = $preparedSelect->fetch();

    //save the entry to be deleted into session so they can undo it if they screwed up
    $_SESSION['resultsInSession'] = $result;

    //delete from Books table the selected entry
    $sqlDelete = "DELETE FROM Books WHERE id=:id";
    $preparedDelete = $dbh->prepare($sqlDelete);
    $preparedDelete->bindParam(':id', $id);
    $deleteStatus = $preparedDelete->execute();

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
</head>

<body>
    <ul class="nav">
        <li class="nav-item"><h3>Book Shelf</h3></li>
        <li class="nav-link active"><a href="viewBooks.php">View Books</a></li>
        <li class="nav-link active"><a href="insertBook.php">Add Book</a></li>
    </ul>
    <div class="container">
        <?php
            //display error notification if delete fails
            if ($deleteStatus != 1) {
                echo "<div class='alert alert-danger' role='alert' style='text-align: center'>
                                            <b>Error!</b> Delete Failed! Please return and try again!
                                        </div>";
            } else {
                //do nothing
            }
        //display error notification if undo delete fails
        if ($errorUpdate == "yes") {
            echo "<div class='alert alert-danger' role='alert' style='text-align: center'>
                                            <b>Error!</b> Undo Delete Failed!
                                        </div>";
        } else {
            //do nothing
        }

            echo "<form action='deleteBook.php?id=" . $id . "' method='POST' class=''>";


            echo "<div class='form-group row'>
                    <button type='submit' class='btn btn-primary col-md-2 btn-block'>Undo Delete!</button>
                  </div>";
        ?>
    </div>

</body>
