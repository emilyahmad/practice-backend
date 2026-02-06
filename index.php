<?php include ('admin/partials-front/menu.php') ?>
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Hamburger Joe's Food</h2>
        <?php// create sql query to display categories from database
        $sql = "SLECT * FROM tbl_category WHERE active="yes" AND feature="yes" LIMIT 3";
        $res = mysqli_query($conn, $sql);
        // count rows to check if category is available
        $count = mysqli_num_rows($res);
        if ($count>0) {
            // get categories available
            while($row=mysqli_fetch_assoc($res));
            $id = $row('id');
            $title = $row['title'];
            $image_name = $row['image_name'];
            ?>
            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                <div class="box-3 font-container">
                    <?php
                        // check if image is available or not
                        if($image_name=="") {
                            // display message
                            echo "<div class='error'>Image not available</div>";
                        } else {
                            // image is available
                            ?>
                            <img src="<?phpecho SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                        <h3 class="float-text text-white"><?php echo $title1 ?></h3>
                </div>
            </a>
            <?php
        }
    </div>
</section>

<?php include ('admin/partials-front/footer.php')
