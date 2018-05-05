<?php
/**
 * This file receives all inbound page requests at
 * this domain and retrieves the appropriate information
 * for each page requested based on logic in the controller.
 *
 * @author Craig Koch
 * @version TBD
 */

session_start();
error_reporting(E_ALL);
require_once 'controllers/bookShelfController.php';
require_once 'model/bookShelfModel.php';

//used later to identify get vs post
$httpVerb = $_SERVER['REQUEST_METHOD'];

//default page to load if no other page is requested
$page = 'add';

//if page get variable available use that one
if(isset($_GET['page'])){
    $page = $_GET['page'];
}

//based on page requested call appropriate controller function
switch ($page){
    case 'add':
            handleAddBooks();
        break;
    case 'view':
        if($httpVerb == 'GET'){
            handleViewBooksGet();
        }else{ //POST
            handleViewBooksPost();
        }
        break;
    case 'edit':
        if($httpVerb == 'GET'){
            handleEditBooksGet();
        }else{ //POST
            handleEditBooksPost();
        }
        break;
    case 'delete':
        if($httpVerb == 'GET'){
            handleDeleteBooksGet();
        }else{ //POST
            handleDeleteBooksPost();
        }
        break;
}
?>