<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $number = array(4,8,15,16,23,42);
    echo $number[0]; ?><br>
    <?php $mixed = array(6, "fox", "dog", array("x", "y", "z")); ?>
    <?php echo $mixed[2];?><br>
    <?php echo $mixed[3];?><br>
    <pre>
    <?php echo print_r($mixed); ?>
    <pre>

    <?php echo $mixed[3][1]; ?><br>
    <?php $mixed[2] = "cat"; ?>
    <?php $mixed[4] = "mouse"; ?>
    <?php $mixed[] = "horse"; ?>

    <pre>
    <?php echo print_r($mixed); ?>
    <pre>
</body>
</html>