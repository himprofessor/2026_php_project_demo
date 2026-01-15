<?php
require_once("../database/connection.php");

$title = $_POST["title"];
$desc = $_POST["desc"];
$deadlineDate = $_POST["date"];
$deadlineTime = $_POST["time"];
$deadline = $deadlineDate . $deadlineTime;
$currentDateTime = date('Y-m-d H:i:s');
$is_completed = 0;
try {

    $sql = "INSERT INTO tasks (title, description, is_completed, created_date, deadline)
VALUES (:title,:description, :is_completed, :created_date, :deadline)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':description', $desc);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':is_completed', $is_completed);
    $stmt->bindParam(':created_date', $currentDateTime);
    $stmt->bindParam(':deadline', $deadline);

    $stmt->execute();
    header("Location: ../index.php");
    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}
