<?php
include "./app/init.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>

<body>
    <h1>Welcome Home, <?php
                        if (!isset($_SESSION['name'])) {
                            echo "User";
                        } else {
                            echo substr($user['name'], 0, 18);
                        }
                        ?></h1>
</body>

</html>