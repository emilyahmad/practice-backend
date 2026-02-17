<?php include('admin/partials-front/menu.php');
include('config/constants.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <br><br>

        <!-- add category from starts -->
         <from action="" method="POST" enctype="multipart/form-data">
            <table class="tb1-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="yes">Yes
                        <input type="radio" name="featured" value="no">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td> <!-- yes, no or no selection -->
                        <input type="radio" name="active" checked="checked" value="yes">Yes
                        <input type="radio" name="active" value="no">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" values="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>    
</form>
<!-- end of category form -->
 <?php
// check for click
if (isset($_POST['submit'])) {
    $title = $_POST["title"];
    // for radio input check feature button selected
    if(isset($_POST['featured'])) {
        $featured = $_POST['featured'];
    } else {
        $featured = "no";
    }
}

if (isasset($_POST['active'])) {
    $active = $_POST['active'];
} else {
    $active = "no";
}

if ($image_name != " ") {
    // upload image if selected

    // auto rename image
    // get extension
    $ext = end(explode('.', $image_name));

    // rename image
    $image_name = $_FILES['image']['tmp_name'];

    $destination_path = "../images/category/".$image_name;

    // finally upload image
    $upload = move_uploaded_file($source_path, $destination_path);

    // check whether image is uploaded or not
    // if image is not uploaded, stop process & redirect error message

    if ($upload == false) {
        // set message
        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";

        // redirect to add category page
        header('locatoin: '.SITEURL.'admin/add-category.php');

        // stop process
        die();
    }

} // image is not blank

} // additional end bracket for if file is not set
else {
    // dont upload image & set value blank
    $image_name = "";
}

// create SQL query to insert category to database
$sql = "INSERT INTO tbl_category SET title='$title', image_name='$image_name',
featured='$featured',
active='$active'";

// execute query & save  in database
$res = mysqli_query($conn, $sql);

// check whether the query executed or not & data added or not
if ($res == true) {
    // query executed & category added
    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
    // redirect to manage category page
    header('location:' .SITEURL.'admin/add-category.php');
} else {
    // failed
    $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";

    // redirect to manage category page
    header('location:' .SITEURL.'admin/add-category.php');
} // should have additional end bracket
}
?>
</div>
</div>
<?php include('partials-front/footer.php');
