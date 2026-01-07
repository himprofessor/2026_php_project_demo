<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Database Connection</title>
</head>

<body>
    <h1>Crude Operation</h1>

    <?php
    // Database configuration
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DBNAME", "crud_operation");
    define("DB_SERVER", "localhost");

    try {
        $conn_state = "mysql:host=" . DB_SERVER . ";dbname=" . DBNAME;
        $conn = new PDO($conn_state, USERNAME, PASSWORD);
    } catch (Exception $error) {

        echo $error->getMessage();
    }


    ?>
</body>

</html>