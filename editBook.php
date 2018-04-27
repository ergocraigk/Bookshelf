<?php
/**
 * This page allows users to edit a book that has been added to the database.
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

    //pull the selected id to populate fields for editing later
    $sqlPullSelected = "SELECT * FROM Books WHERE id=:id";
    $preparedSelect = $dbh->prepare($sqlPullSelected);
    $preparedSelect->bindParam(':id', $id);
    $preparedSelect->execute();
    $result = $preparedSelect->fetch();

    //flag for if update fails
    $errorUpdate = null;

    //if page receives post data prepare a PDO statement to update data in the database
    if($_POST){
        //prepare a PDO statement to update data in the database
        $sqlUpdate = "UPDATE `Books` SET `title` = :title, `fiction` = :fiction, `publisher` = :publisher, `summary` = :summary, `pages` = :pages WHERE `Books`.`id`=:id";
        $preparedUpdate = $dbh->prepare($sqlUpdate);

        $preparedUpdate->bindParam(':id', $result['id']);
        $preparedUpdate->bindParam(':title', $_POST['title']);
        $preparedUpdate->bindParam(':fiction', $_POST['fiction']);
        $preparedUpdate->bindParam(':publisher', $_POST['publisher']);
        $preparedUpdate->bindParam(':summary', $_POST['summary']);
        $preparedUpdate->bindParam(':pages', $_POST['pages']);

        //perform update and set flag if update fails
        $updateCheck = $preparedUpdate->execute();
        if($updateCheck == true){
            header("Location: viewBooks.php");
        } else {
            $errorUpdate = "yes";
        }
    } else {
        //do nothing
    }
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
<br>
<?php
    if($errorUpdate == "yes"){
        echo "<div class='alert alert-danger col-sm-4' role='alert' style='text-align: center'>
                                        <b>Error!</b> Book not Updated!
                                    </div>";
    }else{
        //do nothing
    }
?>
<div class="container">
    <form action="<?php echo "editBook.php?id=" . $id; ?>" method="post" class="">
        <div>
            <!-- book title -->
            <div class="form-group row justify content center">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-8">
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($result['title']); ?>">
                </div>
            </div>

            <!-- fiction or not? -->
            <fieldset class="form-group">
                <div class="row">
                    <label for="fiction" class="col-sm-2 form-check-label">Fiction</label>
                    <div class="col-sm-8">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="fiction" class="custom-control-input" id="radioYes" value="Yes"
                                <?php
                                    if($result['fiction'] == 1){
                                        echo "checked";
                                    } else {
                                        //do nothing
                                    }
                                ?>>
                            <label for="radioYes" class="custom-control-label"> Yes </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" name="fiction" class="custom-control-input" id="radioNo" value="No"
                                <?php
                                if($result['fiction'] == 0){
                                    echo "checked";
                                } else {
                                    //do nothing
                                }
                                ?>>
                            <label for="radioNo" class="custom-control-label"> No</label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- publisher -->
            <div class="form-group row">
                <label for="publisher" class="col-sm-2 col-form-label">Publisher</label>
                <div class="col-sm-8">
                    <select name="publisher" class="form-control">
                    <?php
                        //display an array of available publishers. Add to that array a publisher that may have been
                        // outside the constraints of our preapproved dropdown box and remove and duplicates
                        $publisherArray = array("Harper Collins", "Pearson", "Scholastic Press", "Penguin Classics", "Bantam", "Delacorte Press");
                        array_push($publisherArray, $result['publisher']);
                        $publisherArray = array_unique($publisherArray);

                        foreach ($publisherArray as $publisher){
                            if($publisher == $result['publisher']){
                                echo "<option selected>" . $publisher . "</option>";
                            } else {
                                echo "<option>" . $publisher . "</option>";
                            }
                        }
                    ?>
                    </select>
                </div>
            </div>

            <!-- # of pages -->
            <div class="form-group row">
                <label for="pages" class="col-sm-2 col-form-label">Pages</label>
                <div class="col-sm-8">
                    <input type="text" name="pages" class="form-control" value="<?php echo $result['pages']; ?>">
                </div>
            </div>

            <!-- summary -->
            <div class="form-group row">
                <label for="summary" class="col-sm-2 col-form-label">Summary</label>
                <div class="col-sm-8">
                    <textarea rows="7" name="summary" class="form-control"><?php echo $result['summary']; ?></textarea>
                </div>
            </div>

            <!-- submit the form -->
            <div class="form-group row justify-content-center">
                <button type="submit" class="btn btn-primary col-md-2 btn-block">Save Changes!</button>
            </div>
        </div>
    </form>
</div>
</body>
