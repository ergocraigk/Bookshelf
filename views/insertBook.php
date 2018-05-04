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

<?php include 'header.php'; ?>
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
<?php include 'footer.php'; ?>