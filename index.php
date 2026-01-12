<?php require_once("database/connection.php");?>
<?php require_once("partials/head.php")?>
    <h1>Todo list app</h1>
    <a href="views/formAddTask.php">Add tasks</a>
    <?php
    // get all data from table tasks
    $sql = "SELECT * FROM tasks";
    // prepare query to select data 
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<?php require_once("partials/footer.php");?>