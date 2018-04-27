<?php
/**
 * This file receives input from visitors about books
 * It receives Title, whether the book is fiction or non fiction,
 * whom the publisher is, Page count, and a summary of the book.
 *
 * @author Craig Koch
 * @version GIT: TBD
 */
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
    <div class="container">
        <form action="viewBooks.php" method="post" class="">
            <div>
                <!-- book title -->
                <div class="form-group row justify content center">
                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-8">
                        <input type="text" name="title" class="form-control">
                    </div>
                </div>

                <!-- fiction or not? -->
                <fieldset class="form-group">
                    <div class="row">
                        <label for="fiction" class="col-sm-2 form-check-label">Fiction</label>
                        <div class="col-sm-8">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="fiction" class="custom-control-input" id="radioYes" value="Yes">
                                <label for="radioYes" class="custom-control-label"> Yes </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="fiction" class="custom-control-input" id="radioNo" value="No">
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
                            <option disabled selected value></option>
                            <option>Harper Collins</option>
                            <option>Pearson</option>
                            <option>Scholastic Press</option>
                            <option>Penguin Classics</option>
                            <option>Bantam</option>
                            <option>Delacorte Press</option>
                        </select>
                    </div>
                </div>

                <!-- # of pages -->
                <div class="form-group row">
                    <label for="pages" class="col-sm-2 col-form-label">Pages</label>
                    <div class="col-sm-8">
                        <input type="text" name="pages" placeholder="546" class="form-control">
                    </div>
                </div>

                <!-- summary -->
                <div class="form-group row">
                    <label for="summary" class="col-sm-2 col-form-label">Summary</label>
                    <div class="col-sm-8">
                        <textarea rows="7" name="summary" class="form-control"></textarea>
                    </div>
                </div>

                <!-- submit the form -->
                <div class="form-group row justify-content-center">
                    <button type="submit" class="btn btn-primary col-md-2 btn-block">Add!</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>