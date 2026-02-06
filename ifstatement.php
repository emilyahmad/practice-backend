<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>If statement</title>
</head>
<body>
<?php
$a = 4;
$b = 3;

if ($a > $b) {
    echo "a is larger than b";
} else {
    echo "b is larger than a";
}
?>
<?php // only welcome new users
$new_user = true;
if ($new_user) {
    echo "<h1>Welcome</h1>"
    echo "<p>We are glad you decided to join us.</p>";
}
<br>
?>
<?php
$numerator = 20;
$denominator = 4;
$result = 0;
if ($denominator > 0) {
    $result = $numerator / $denominator;
    echo "Result: {$result}";
}
?>
<?php
$a = 3;
$b = 4;
if ($a > $b) {
    echo "a is larger than b";
} elseif ($a == $b) {
    
} else {
    echo "a is not larger than b";
}
</body>
</html>