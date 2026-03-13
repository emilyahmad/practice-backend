<?php
include ('partials/menu.php');
require_once "../config/constants.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="styles/add-category.css">
</head>
<body>
    <div class="main-content">
        <div class="wrapper">
            <h1>Add Category</h1>
            <br><br>
            <?php

            if (isset($_SESSION['add']))
                {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
                }
            if (isset($_SESION['upload']))
                {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
                }
            ?>
            <br><br>
            <!-- Add Category Form Starts -->
             <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Category Title" required maxlength="100">
                        </td>
                    </tr>
                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image" accept="image/*">
                            <div class="file-info">Supported formats: JPG, JPEG, PNG, GIF (Max: 5mb)</div>
                        </td>
                    </tr>
                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes" id="featured_yes">
                            <label for="featured_yes">Yes</label>
                            <input type="radio" name="featured" value="No" id="featured_no">
                            <label for="featured_no">No</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="active" value="Yes" id="active_yes">
                            <label for="active_yes">Yes</label>
                            <input type="radio" name="active" value="No" id="active_no">
                            <label for="active_no">No</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
            <!-- Add Category Form ends -->
            <?php {
                $_SESSION['upload'] = "<div class='error'>{$error_message}</div>";
                                header('location:' .SITEURL.'admin/add-category.php');
                                die();
            }

            // create SQL query to insert category into database using prepared statements
            $sql = "INSERT INTO tbl_category(title, image_name, featured, active) VALUES (?,?,?,?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $title, $image_name, $featured, $active);
                $res = mysqli_stmt_execute($stmt);

                if ($res) {
                    $_SESSION['add'] = "<div class='success'>Category added successfully.</div>";
                            header('location: ' .SITEURL.'admin/manage-category.php');
                            die();
                } else {
                    // if database insert fails and we upload an image, delete if
                    if($image_name != "" & file_exists("../images/category/".$image_name)) {
                        unlink("../images/category/".image_name);

                    }

                    $_SESSION['add'] = "<div class='success'>Failed to add category (database error).</div>";
                            header('location: ' .SITEURL.'admin/add-category.php');
                            die();
                }
                mysqli_stmt_close($stmt);
            } else {
                // if database insert fails and we upload an image, delete if
                if($image_name != "" & file_exists("../images/category/".$image_name)) {
                        unlink("../images/category/".image_name);
                    }

                    $_SESSION['add'] = "<div class='success'>Failed to add category (database error).</div>";
                    header('location: ' .SITEURL.'admin/add-category.php');
                    die();
            }
            ?>

             <?php
                //Check whther the Submit button is clicked or not
                if(isset($_POST['submit']))
                    {
                        //Sanitize and validate input
                        $title = mysqli_real_escape_string($conn, trim($_POST['title']));

                        //Validate title
                        if (empty($title)){
                            $_SESSION['add'] = "<div class='error'>Category title is required.</div>";
                            header('location: ' .SITEURL.'admin/add-category.php');
                            die();
                        }
                        // For radio input, we need to check whether the button is selected or not
                        $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
                        $$active = isset($_POST['active']) ? $_POST['active'] : "No";

                        //Handle image upload
                        $image_name = "";

                        $file_info = $FILES['image'];
                        $orginal_name = $file_info['name'];
                        $file_size = $file_info['size'];
                        $file_tmp = $file_info['tmp_name'];
                        $file_error = $file_info['error'];

                        //Check if file was actually uploaded
                        if($original_name !="" && $file_size > 0)
                            {
                            //Validate file type
                            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
                            $file_extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

                            if(in_array($file_extension, $allowed_extensions)){
                                //Check file size (limit to 5MB)
                                if($file_size <= 5000000){
                                    //Generate unique filename
                                    $image_name = "Food_Category_".time().'_'.rand(1000,9999).'.'.$file_extension
                                    $upload_dir = "../images/category/";
                                    $destination_path = $upload_dir . $image_name;

                                    //Create directory if it doesn't exist
                                    if(!is_dir($upload_dir)){
                                        if(!mkdir($upload_dir, 0755, true)){
                                            $_SESSION['upload'] = "<div class='error'>Failed to create upload directory</div>";
                                            header('location:'.SITEURL.'admin/add-category.php');
                                            die();
                                        }
                                    }
                                    //Check if directory is writable
                                    if(!iswritable($upload_dir)){
                                            $_SESSION['upload'] = "<div class='error'>Upload directory is not writable</div>";
                                            header('location:'.SITEURL.'admin/add-category.php');
                                            die();
                                        }

                                    //Move uploaded file
                                    if(move_uploaded_file($file_tmp, $destination_path)){
                                        //File uploaded successfully
                                        chmod($destination_path, 0644);
                                        error_log("Category image uploaded successfull: " . $image_name);
                                    }else{
                                        $_SESSION['upload'] = "<div class='error'>Failed to move uploaded file, check directory permissions.</div>";
                                            header('location:'.SITEURL.'admin/add-category.php');
                                            die();
                                    }else{
                                        $_SESSION['upload'] = "<div class='error'>File size too large, max is 5MB.</div>";
                                            header('location:'.SITEURL.'admin/add-category.php');
                                            die();
                                    }else{
                                        $_SESSION['upload'] = "<div class='error'>Inavlid file type, only JPG, JPEG, PNG, and GIF allowed.</div>";
                                            header('location:'.SITEURL.'admin/add-category.php');
                                            die();
                                    }
                                }
                            }else if(isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE){
                                $error_message = "Upload failed: ";
                                switch($_FILES['image']['error']){
                                    case UPLOAD_ERR_INI_SIZE;
                                    case UPLOAD_ERR_FORM_SIZE;
                                        $error_message . = "File too large";
                                        break;
                                    case UPLOAD_ERR_PARTIAL;
                                        $error_message . = "File partially uploaded";
                                        break;
                                    case UPLOAD_ERR_No_TMP_DIR;
                                        $error_message . = "No temporary directory";
                                        break;
                                    case UPLOAD_ERR_CANT_WRITE;
                                        $error_message . = "Cannot write to disc";
                                        break;
                                    case UPLOAD_ERR_EXTENSION;
                                        $error_message . = "Upload stopped by extension";
                                        break;
                                    default:
                                        $error_message . = "Unkown error";
                                }
                                $_SESSION['upload'] = "<div class='error'>{$error_message}</div>";
                                            header('location:'.SITEURL.'admin/add-category.php');
                                            die();
                            }
                            //Create SQL Query to INsert Category into Database using prepared statements
                            }
                    }
                    ?>

    <!-- include('partials/footer.php');  -->
    </body>
</html>
