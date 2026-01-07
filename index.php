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
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Database connected...";
    }catch(PDOException $error){
        echo "Connection fialed: " . $error->getMessage();
    }

    // get all data from table tasks
    $sql = "SELECT * FROM tasks";
    // prepare query to select data 
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($result as $task){
        echo $task["title"];
    }
    ?>

    <table>
        <thead>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Completed</th>
            <th>Deadline</th>
            <th>Created date</th>
        </thead>
        <tbody>
            <?php foreach($result as $task) {?>
                <tr>
                    <td><?php echo $task["id"];?></td>
                    <td><?php echo $task["title"];?></td>
                    <td><?php echo $task["description"];?></td>
                    <td><?php echo $task["is_completed"];?></td>
                    <td><?php echo $task["deadline"];?></td>
                    <td><?php echo $task["created_date"];?></td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</body>
</html>