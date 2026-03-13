<php
    include ('partials/menu.php');
    require_once ('../config/constants.php');
?>

<div class="main-content">
    <div class="register_container">
        <div class="register_box">
            <h1>Update Category</h1>
            <p>Modify Category details and settings</p>
        </div>
        <?php
        // check if id set or not
        if(isset($_GET['id'])) {
            $id = $_GET['id'] 
            $sql = "SELECT * FROM tbl_category WHERE id=$id":
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $title = $row["title"];
                $current_image = $row['image_name']
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                $_SESSION['no-category-found'] = "<div class='error_box'>Category not found.</div>";
                header('location: '.SITEURL.'admin/manage-category.php');
            }
        } else {
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        ?>
        <form action="" method="POST" encytype="mutipart/form-data">
            <div class="form_group">
                <label for="title">Category Title</label>
                <input type="text" id="title" name="title" value="<?php echo $title;?>" required>
            </div> <!-- end of 1st form group -->
            <div class="form_group">
                <label>Current Image</label>
                <?php
                    if ($current_image != "") {
                        ?>
                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                        <?php
                    } else {
                        echo "<div class='error_box'>Image not added.</div>";
                    }
                    ?>
            </div> <!-- end of form group -->
            <div class="form_group">
                <label for="image">Upload new image</label>
                <label type="file" id="image" name="image" accept="image/*">
            </div> <!-- end of form group -->
            <div class="form_group">
                <label>Featured category</label>
                <div class="radio_group">
                    <label>
                        <input type="radio" name="featured" value="Yes" <?php if($featured=="Yes"){echo "checked";} ?>>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="featured" value="No" <?php if($featured=="No"){echo "checked";} ?>>
                        No
                    </label>
                </div> <!-- end of radio group -->
            </div> <!-- end of form group -->
            <div class="form_group">
                <label>Active Status</label>
                <div class="radio_group">
                    <label>
                        <input type="radio" name="active" value="Yes" <?php if($featured=="Yes"){echo "checked";} ?>>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="active" value="No" <?php if($featured=="No"){echo "checked";} ?>>
                        No
                    </label>
                </div> <!-- end of radio group -->
            </div> <!-- end of form group -->

            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" name="submit" class="register_btn">Update Category</button>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['featured'];

            if (isset($_FILES['image']['name'];)) {
                $image_name = $_FILES['image']['name'];
                if($image_name != "") {
                    $ext = end(explode('.', $image_name));
                    $image_name = "Food_Category_".rand(000,999).".".$ext;
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    $upload = move_uploaded_file($source_path, $destination_path);

                    if($upload==false) {
                        $_SESSION['upload'] = "<div class='error_box'>Failed to upload image</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                        die();
                    }

                    if ($current_image != "") {
                        $remove_path = "..images/category"
                        $remove = unlink($remove_path);
                        if ($remove = false) {
                            $_SESSION['failed-remove'] = "<div class='error_box'>Failed to remove image</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die();
                        }
                    } else {
                        $image_name = $current_image;
                    }
                } else {
                    $image_name = $current_image;
                }

                $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active',
                WHERE id=$id
                ";

                $res2 = mysqli_query($conn, sql2);
                if ($res2 == true) {
                    $_SESSION['upudate'] = "<Div class='success_box'>Category updated successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                } else {
                    $_SESSION['update'] = "<div class='error_box'>Failed to upload/div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
        }
        ?>
</div>
</div>
<?php include('partials/footer'); ?>