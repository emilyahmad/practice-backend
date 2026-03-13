<?php
require_once "../config/constants.php";
include ('partials/menu.php');
include ('partials/footer.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Category</title>
</head>
<body>
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Category</h1>
            <br><br>
            <?php
            if (isset($SESSION['add'])) {
                echo "<div class='success'>" . $_SESSION['add'] . "</div>";
                unset($_SESSION['add']);

            }
            ?>
            <br><br>

            <!-- Button to category -->
            <a href="<?php echo SITEURL;?>admin/add-category.php" class="btn-primary">Add Category</a>
            <br><br><br>

            <table class="tbl-full">
                <tr>
                    <th>Number</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Feature</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
                <?php

                // Query to get all categories from database
                $sql = "SELECT * FROM tbl_category";
                
                // Execute query
                $res = mysqli_query($conn, $sql);

                // Count rows returned
                $count = mysqli_num_rows($res);

                // Create serial #
                $sn = 1;

                // check for data
                if ($count > 0) {
                    while ($row == mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        ?>

                        <tr>
                            <td><?php echo $sn++; ?>. </td>
                            <td><?php echo $title; ?></td>

                        <?php
                        // check if image name is available
                        if ($image_name != "") {
                            // display image
                            ?>
                            <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name; ?>" width="100px">
                            <?php
                        } else {
                            // display message
                            echo "<div class='error'>Image not Added</div>";
                        }
                        ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>

                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>"class="btn-secondary">Delete Category</a>
                        </td>
                        </tr>
                        <?php
                    }
                } else {
                    // we don't have data -> display message. in table
                    ?>
                    <tr>
                        <td colspan="6"><div class="error">No Category Added.</div></td>
                    </tr>
                    <?php
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>