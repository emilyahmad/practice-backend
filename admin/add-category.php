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