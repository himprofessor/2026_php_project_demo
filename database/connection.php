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
?>