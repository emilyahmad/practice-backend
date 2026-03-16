<php
    include ('partials/menu.php');
    require_once ('../config/constants.php');


// check whether id & image_name is set/not
if(isset($_GET['id']) AND isset($_GET['image_name'])) {
    // get value & delete (& echo)
    $id = $_GET['id'] ? (int)$_GET['id'] : 0;
    $image_name = $_GET['image_name'] ? basename ($_GET['image_name']) : "";

    // validate
    if ($id <= 0) {
        $_SESSION['delete'] = "<div class='error'>Invalid category ID</div>
        header('location:'.SITEURL.'admin/manage-category.php');
        die();
    }

    // remove physical image file

}

// remove image from file
if ($image_name != "") {
    $path = "../images/category/".$image_name;
    // check file exists b4 attempting to delete
    if (file_exists($path)) {
        if (!unlink($path)) {
            $_SESSION['delete'] = "<div class='error'>Failed to remove category image</div>
            header('location:'.SITEURL.'admin/manage-category.php');
            die();
        }
    }
}

// delete data from db using prepared statements
$sql = "DELETE FROM tbl_category WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);

if (!stmt) {
    $_SESSION['delete'] = "<div class='error'>Database error occurred</div>
    header('location:'.SITEURL.'admin/manage-category.php');
    die();
}

mysqli_stmt_bind_param($stmt, "i", $id);
$res = mysqli_stmt_execute($stmt);

// check whether data was deleted from db/not
if ($res == true) {
    $_SESSION['delete'] = "<div class='sucess'>Category deleted successfully</div>
} else {
    $_SESSION['delete'] = "<div class='error'>Failed to delete category.</div>
}

mysqli_stmt_close($stmt);
header('location:'.SITEURL.'admin/manage-category.php');
die();

} else {
    // redirect to manage category page if parameters are missing 
}