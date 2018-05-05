<?php
/**
 * This page displays a list of book entries that have been saved to a database.
 * This page also receives post data from "insertBook.php" and saves it to the
 * database.
 *
 * @author Craig Koch
 * @version GIT: TBD
 */

?>
<?php include 'header.php'; ?>

        <div class="" style="margin-left: 5%">
            <?php
                //notify with alert if insert was successful or failed
                if($_POST) {
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
                }

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
                                        <span><a href='index.php?page=edit&id=" . $row['id'] . "'><i class='far fa-edit'> Edit</i></a></span>
                                        <span><a href='index.php?page=delete&id=" . $row['id'] . "'><i class='far fa-trash-alt'> Delete</i></a></span>
                                      </div>";



                            echo "</li>";
                        }

                    ?>
                </ul>
        </div>
    </div>
<?php include 'footer.php'; ?>