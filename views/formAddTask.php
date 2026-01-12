<?php require_once("../partials/head.php") ?>
<h1>Form add new task</h1>
<a href="../index.php">Back</a>
<form action="../controllers/addTask.controller.php" method="POST">
    <label for="title">Task title</label>
    <input type="text" name="title" id="title" placeholder="Enter Task Title">
    <label for="desc">Task Description:</label>
    <textarea name="desc" id="desc"></textarea>
    <label for="deadline">Deadline:</label>
    <input type="date" name="date" id="deadline">
    <input type="time" name="time" id="deadline">

    <button type="submit">Save task</button>
</form>
<?php require_once("../partials/footer.php") ?>