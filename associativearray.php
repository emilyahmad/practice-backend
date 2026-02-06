<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associative Array</title>
</head>
<body>
    <?php
    $assoc = array("first_name" => "Kevin", "last_name" => "Smith");
    echo assoc["first_name"]; ?>
    <?php echo $assoc["first_name"] , " " , $assoc["last_name"]; ?> <br>
    <br>
    echo assoc["first_name"] = "Larry"; ?>
    <?php echo $assoc["first_name"] , " " , $assoc["last_name"]; ?> <br>
    
    <?php echo $assoc[0]; ?><br>

    <?php $numbers = array(4,8,15,16,23,42); ?>
    <php $numbers = array(0 => 4, 1 => 8, 2 => 15, 3 => 16, 4 => 23, 5 => 42); ?>
    <br>
    <?php echo $numbers[0];

</body>
</html>