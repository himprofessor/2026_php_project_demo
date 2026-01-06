<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo list app</title>
</head>
<body>
    <h1>Todo list app</h1>

    <?php
    try{
        define("USERNAME", "root");
        define("DBNAME", "todo_list");
        define("DB_PWD", "");
        define("DB_SERVER", "localhost");

        $conn_state = "mysql:host=" . DB_SERVER . ";dbname=" . DBNAME;
        $conn = new PDO($conn_state, USERNAME, "");
        echo "Database connected success fully.";
    }catch(PDOException $error){
        echo "Connection fialed: " . $error->getMessage();
    }
    ?>
</body>
</html>