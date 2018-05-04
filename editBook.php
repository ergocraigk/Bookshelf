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
<?php include 'views/header.php'; ?>
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
<?php include 'views/footer.php'; ?>