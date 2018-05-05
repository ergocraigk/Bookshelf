<?php

session_start();
error_reporting(E_ALL);
require_once 'controllers/bookShelfController.php';
require_once 'model/bookShelfModel.php';

$httpVerb = $_SERVER['REQUEST_METHOD'];

$page = 'add';

if(isset($_GET['page'])){
    $page = $_GET['page'];
}

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