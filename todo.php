<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php

$servername = "localhost:3308"; 
$username = "root"; 
$password = ""; 
$dbname = "todo_app"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted to add a task
if(isset($_POST["submit"])) {
    $task = $_POST["task"];
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    if ($conn->query($sql) === TRUE) {
        echo "New task added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if the form is submitted to delete a task
if(isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $sql = "DELETE FROM tasks WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Task deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch tasks
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    <h1>To-Do List</h1>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Task</label>
                            <input type="text" name="task" class="form-control" placeholder="Enter task">
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Add Task</button>
                    </form>
                </div>
            </div>
            <div class="mt-4">
                <h2>Task List</h2>
                <ul class="list-group">
                    <?php if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $row["task"]; ?>
                                <a href="?delete=<?php echo $row["id"]; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </li>
                        <?php } 
                    } else { ?>
                        <li class="list-group-item">No tasks found</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>
</body>
</html>
