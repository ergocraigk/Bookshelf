<?php
/**
 * This page displays a list of book entries that have been saved to a database.
 * This page also receives post data from "insertBook.php" and saves it to the
 * database.
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

    //catches the post data from insertBook.php and sends it to the database
     if($_POST){
        
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

    <div class="container-fluid">
        <ul class="nav">
            <li class="nav-item"><h3>Book Shelf</h3></li>
            <li class="nav-link active"><a href="viewBooks.php">View Books</a></li>
            <li class="nav-link active"><a href="insertBook.php">Add Book</a></li>
        </ul>
        <br>

        <div class="" style="margin-left: 5%">
            <?php
                //notify with alert if insert was successful or failed
                if($_POST) {
                    $insertCheck = $preparedInsert->execute();
                    if ($insertCheck == true) {
                        echo "<div class='alert alert-success col-sm-4' role='alert' style='text-align: center'>
                                        <b>Success!</b> New book inserted.
                                    </div>";
                    } elseif ($insertCheck == false) {
                        echo "<div class='alert alert-danger col-sm-4' role='alert' style='text-align: center'>
                                        <b>Error!</b> Book not inserted.
                                    </div>";
                    } else {
                        //do nothing
                    }
                } else {
                    //do nothing
                }
                //prepares a sql statement with PDO's to return all entries in the
                //Books table, executes the PDO, and saves the returned data for later use
                $sqlSelect = "SELECT * FROM Books";
                $preparedSelect = $dbh->prepare($sqlSelect);
                $preparedSelect->execute();
                $result = $preparedSelect->fetchAll();

            ?>
            <h2>Books Added</h2>
                <ul class="list-group">
                    <?php
                        //loop through the Books database data and display it on the webpage in a human readable format
                        foreach($result as $row){
                            echo "<li class='list-group-item'>";
                                echo "<h3>" . $row['title'] . "</h3>";

                                echo "<span>Publisher: " . $row['publisher'] . ", Pages: " . $row['pages'];
                                if ($row['fiction'] == 1){
                                    echo " (fiction)</span>";
                                }else if($row['fiction'] == 0){
                                    echo " (non fiction)</span>";
                                }else{

                                }
                                echo "<br><br>";
                                echo "<p>" . $row['summary'] . "</p>";

                                //provide edit and delete links so users can modify the books list
                                echo "<div>
                                        <span><a href='editBook.php?id=" . $row['id'] . "'><i class='far fa-edit'> Edit</i></a></span>
                                        <span><a href='deleteBook.php?id=" . $row['id'] . "'><i class='far fa-trash-alt'> Delete</i></a></span>
                                      </div>";



                            echo "</li>";
                        }

                    ?>
                </ul>
        </div>
    </div>

</body>
</html>
