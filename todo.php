<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List App</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-size: 2.5rem;
            position: relative;
        }
        
        h1:after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 10px auto;
            border-radius: 2px;
        }
        
        .input-group {
            display: flex;
            margin-bottom: 30px;
        }
        
        #taskInput {
            flex: 1;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 50px 0 0 50px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }
        
        #taskInput:focus {
            border-color: #6a11cb;
        }
        
        #addBtn {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 0 50px 50px 0;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        #addBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .task-list {
            list-style-type: none;
        }
        
        .task-item {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.3s;
            transition: transform 0.2s;
        }
        
        .task-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .task-item.completed {
            background-color: #e8f4e1;
        }
        
        .task-item.completed .task-text {
            text-decoration: line-through;
            color: #777;
        }
        
        .task-checkbox {
            margin-right: 15px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .task-text {
            flex: 1;
            font-size: 1.1rem;
            color: #333;
            word-break: break-word;
            padding-right: 15px;
        }
        
        .delete-btn {
            background: #ff4757;
            color: white;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .delete-btn:hover {
            background: #ff2e43;
        }
        
        .stats {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 0.9rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #777;
        }
        
        .empty-state p {
            margin-top: 10px;
            font-size: 1.1rem;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .input-group {
                flex-direction: column;
            }
            
            #taskInput {
                border-radius: 50px;
                margin-bottom: 10px;
            }
            
            #addBtn {
                border-radius: 50px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Todo List</h1>
        
        <?php
        // Database configuration
        define("USERNAME", "root");
        define("DBNAME", "todo_list");
        define("DB_PWD", "");
        define("DB_SERVER", "localhost");

        try {
           
            $conn_state = "mysql:host=" . DB_SERVER . ";dbname=" . DBNAME;
            $conn = new PDO($conn_state, USERNAME, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create tasks table if it doesn't exist
            $createTable = "CREATE TABLE IF NOT EXISTS tasks (
                id INT AUTO_INCREMENT PRIMARY KEY,
                task VARCHAR(255) NOT NULL,
                completed BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $conn->exec($createTable);
            
            // Handle form submissions
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['add_task'])) {
                    // Add new task
                    $task = trim($_POST['task']);
                    if (!empty($task)) {
                        $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (:task)");
                        $stmt->bindParam(':task', $task);
                        $stmt->execute();
                    }
                } elseif (isset($_POST['toggle_task'])) {
                    // Toggle task completion
                    $id = $_POST['task_id'];
                    $stmt = $conn->prepare("UPDATE tasks SET completed = NOT completed WHERE id = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                } elseif (isset($_POST['delete_task'])) {
                    // Delete task
                    $id = $_POST['task_id'];
                    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                }
            }
            
            // Fetch all tasks
            $stmt = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Calculate statistics
            $totalTasks = count($tasks);
            $completedTasks = array_filter($tasks, function($task) {
                return $task['completed'] == 1;
            });
            $completedCount = count($completedTasks);
            $pendingCount = $totalTasks - $completedCount;
            
        } catch(PDOException $error) {
            echo "<div style='color: #ff4757; padding: 15px; background: #ffecec; border-radius: 8px; margin-bottom: 20px;'>";
            echo "Connection failed: " . $error->getMessage();
            echo "</div>";
            exit;
        }
        ?>
        
        <form method="POST" class="input-group">
            <input type="text" id="taskInput" name="task" placeholder="Enter a new task..." required>
            <button type="submit" id="addBtn" name="add_task">Add Task</button>
        </form>
        
        <?php if ($totalTasks > 0): ?>
            <ul class="task-list">
                <?php foreach ($tasks as $task): ?>
                    <li class="task-item <?= $task['completed'] ? 'completed' : '' ?>">
                        <form method="POST" style="display: flex; width: 100%;">
                            <input type="checkbox" class="task-checkbox" name="toggle_task" 
                                   <?= $task['completed'] ? 'checked' : '' ?> 
                                   onchange="this.form.submit()">
                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                            <span class="task-text"><?= htmlspecialchars($task['task']) ?></span>
                            <button type="submit" class="delete-btn" name="delete_task">×</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <div class="stats">
                <span>Total: <?= $totalTasks ?></span>
                <span>Completed: <?= $completedCount ?></span>
                <span>Pending: <?= $pendingCount ?></span>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>No tasks yet</h3>
                <p>Add your first task using the input above!</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
