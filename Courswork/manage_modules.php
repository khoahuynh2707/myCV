<?php
// manage_modules.php
include 'db_connect.php'; // Ensure db_connect.php connects to your database

try {
    // Fetch all modules from the database
    $stmt = $pdo->query("SELECT id, name FROM modules ORDER BY id ASC");
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle exception (optional)
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Modules</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: top;
            width: 100%;
            height: 100%;
            font-family: Arial, Helvetica;
            letter-spacing: 0.02em;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            background-color: hsla(200,40%,30%,4);
            background-image:   
            url('https://78.media.tumblr.com/8cd0a12b7d9d5ba2c7d26f42c25de99f/tumblr_p7n8kqHMuD1uy4lhuo2_1280.png'),
            url('https://78.media.tumblr.com/5ecb41b654f4e8878f59445b948ede50/tumblr_p7n8on19cV1uy4lhuo1_1280.png'),
            url('https://78.media.tumblr.com/28bd9a2522fbf8981d680317ccbf4282/tumblr_p7n8kqHMuD1uy4lhuo3_1280.png');
            background-repeat: repeat-x;
            background-position: 0 20%, 0 100%, 0 50%, 0 100%, 0 0;
            background-size: 2500px, 800px, 500px 200px, 1000px, 400px 260px;
            animation: 50s para infinite linear;
        }
        @keyframes para {
            100% {
                background-position: -5000px 20%, -800px 95%, 500px 50%, 1000px 100%, 400px 0;
            }
        }
        h1 {
            text-align: center;
        }
        .button-container {
            text-align: center;
            margin: 20px 0;
        }
        .btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 10px;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .module-list {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }
        .module-list li {
            margin: 10px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .module-list label {
            margin-left: 10px;
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete the selected modules?');
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Manage Modules</h1>
        
        <!-- Button Container -->
        <div class="button-container">
            <a href="add_newmodules.php" class="btn">Add New Module</a>
            <button type="submit" class="btn">Delete Selected Modules</button>
        </div>
        
        <!-- Form for Deleting Multiple Modules -->
        <form method="POST" action="delete_modules.php" onsubmit="return confirmDelete();">
            <ul class="module-list">
                <!-- Display each module with checkboxes for deletion -->
                <?php
                    foreach ($modules as $module) {
                        echo "<li>
                                <input type='checkbox' name='module_ids[]' value='{$module['id']}'>
                                <label>{$module['name']}</label>
                                <a href='edit_modules.php?id={$module['id']}' class='btn'>Edit</a>
                              </li>";
                    }
                ?>
            </ul>
            <br>
            <a href="admin_dashboard.php" class="btn">Back to Admin Dashboard</a>
        </form>
    </div>
    <?php include 'templates/headercontent.php'; ?>
</body>
</html>
