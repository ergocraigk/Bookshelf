<?php
/**
 * This file creates a page which gives users the opportunity to undo a delete
 * if they regret their most recent life choice.
 *
 * @author Craig Koch
 * @version GIT: TBD
 */

include 'header.php';

?>

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

            echo "<form action='index.php?page=delete&id=" . $id . "' method='POST' class=''>";


            echo "<div class='form-group row'>
                    <button type='submit' class='btn btn-primary col-md-2 btn-block'>Undo Delete!</button>
                  </div>";
        ?>
    </div>
<?php include 'footer.php'; ?>
