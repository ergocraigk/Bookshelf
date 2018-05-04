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

<?php include 'views/header.php'; ?>
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
<?php include 'views/footer.php'; ?>
