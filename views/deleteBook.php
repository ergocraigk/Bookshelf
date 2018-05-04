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

    require_once '../model/bookShelfModel.php';

    testConnection();

    //pull the selected id out of the url for query
    $id = $_GET['id'];

    //flag if undo delete fails
    $errorUpdate = null;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //perform undo delete and set flag if update fails
        $insertCheck = reinsertBook();
        if($insertCheck == true){
            header("Location: viewBooks.php");
        } else {
            $errorUpdate = "yes";
        }

    } else {
        //do nothing
    }

    //save the entry to be deleted into session so they can undo it if they screwed up
    $_SESSION['resultsInSession'] = getSpecificBook($id);

    //delete the selected book
    $deleteStatus = deleteBook($id);

?>

<?php include 'header.php'; ?>
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
<?php include 'footer.php'; ?>
