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
    try {
        define("USERNAME", "root");
        define("DBNAME", "todo_list");
        define("DB_PWD", "");
        define("DB_SERVER", "localhost");

        $conn_state = "mysql:host=" . DB_SERVER . ";dbname=" . DBNAME;
        $conn = new PDO($conn_state, USERNAME, "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Database connected success fully.";
    } catch (PDOException $error) {
        echo "Connection fialed: " . $error->getMessage();
    }


    $sql = "SELECT * FROM tasks";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // alternative way to print array
    // var_dump($tasks);
    echo "<pre>";
    print_r($tasks);
    echo "</pre>";


    ?>
</body>

</html>