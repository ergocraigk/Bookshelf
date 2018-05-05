<?php

//loads the addBooks.php page
function handleAddBooks() {
    require 'views/insertBook.php';
}

//retrieves all books from the DB and loads the viewBooks.php page
function handleViewBooksGet() {

    include_once 'model/bookShelfModel.php';

    //grab assoc array from db of all books
    $result = getBooksForDisplay();

    require 'views/viewBooks.php';

    $booksGetArray = array($result);

    return $booksGetArray;
}

/* inserts a new book into the DB using data from the form on addBooks.php. Afterward retrieves all books from the DB and loads the viewBooks.php page. */
function handleViewBooksPost() {
    include_once 'model/bookShelfModel.php';

    $insertCheck = null;
    //catches the post data from insertBook.php and sends it to the database
    if($_POST){
        $insertCheck = insertBook();
    }

    //grab assoc array from db of all books
    $result = getBooksForDisplay();

    require 'views/viewBooks.php';

    $booksGetArray = array($insertCheck, $result);

    return $booksGetArray;
}

//loads a new book into the editBooks.php page
function handleEditBooksGet() {
    include_once 'model/bookShelfModel.php';

    //pull the selected id out of the url for query
    $id = $_GET['id'];

    //get data for the book to be edited
    $result = getSpecificBook($id);

    require 'views/editBook.php';

    return $result;
}

/* updates a record from the editBooks.php page form and then redirects to the viewBooks.php page. */
function handleEditBooksPost() {
    include_once 'model/bookShelfModel.php';

    //pull the selected id out of the url for query
    $id = $_GET['id'];

    //get data for the book to be edited
    $result = getSpecificBook($id);

    //flag for if update fails
    $errorUpdate = null;

    //if page receives post data prepare a PDO statement to update data in the database
    $errorUpdate = updateBook($id);

    require 'views/editBook.php';

    $postedBooksArray = array($result, $errorUpdate);

    return $postedBooksArray;
}

//deletes a book with the given id and displays the deleteBooks.php page
function handleDeleteBooksGet() {

    require_once 'model/bookShelfModel.php';

    //pull the selected id out of the url for query
    $id = $_GET['id'];

    //flag if undo delete fails
    $errorUpdate = null;

    //save the entry to be deleted into session so they can undo it if they screwed up
    $_SESSION['resultsInSession'] = getSpecificBook($id);

    //delete the selected book
    $deleteStatus = deleteBook($id);

    require 'views/deleteBook.php';

    $getDeleteBooksArray = array($errorUpdate, $deleteStatus);

    return $getDeleteBooksArray;
}

/* handles the undo button press and uses session to insert the previously deleted book back into the DB. Afterwards the user is redirected to viewBooks.php. */
function handleDeleteBooksPost() {
    require_once 'model/bookShelfModel.php';

    //pull the selected id out of the url for query
    $id = $_GET['id'];

    //flag if undo delete fails
    $errorUpdate = null;

    //perform undo delete and set flag if update fails
    $insertCheck = reinsertBook();

    if($insertCheck == true){
        header("Location: index.php?page=view");
    } else {
        $errorUpdate = "yes";
        return $errorUpdate;

        require 'views/delete.php';
    }
}








?>