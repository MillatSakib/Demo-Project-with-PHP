<?php
// Show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQL Query Executor</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Helvetica, Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            display: flex;
            justify-content: center;    /* horizontal center */
            align-items: center;        /* vertical center   */
            min-height: 100vh;
        }
        .card {
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            max-width: 800px;
            width: 100%;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
            resize: vertical;
        }
        button {
            margin-top: 8px;
            padding: 8px 18px;
            border: none;
            background: #4c8bfd;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        a{
            text-decoration:none;
            color: #fff;
        }
        a:hover{
            text-decoration:none;
        }
        button:hover {
            background: #3a74d9;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #e2e7ff;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Run SQL Query on hospital-management-system</h2>

    <form method="POST">
        <textarea name="query" rows="4" placeholder="Enter your SQL query here"></textarea>
        <br>
        <button type="submit">Run</button>
        <button type="submit"><a href="./">Go To Home</a></button>

    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = trim($_POST['query']);

    if (empty($query)) {
        echo "<p style='color:red;'>Please enter a query.</p>";
    } else {
        $servername = "127.0.0.1";
        $username   = "root";
        $password   = "";
        $dbname     = "Canteen_Management_System";

        $conn = new mysqli($servername, $username, $password, $dbname, 3306);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query($query);

        if ($result === true) {
            echo "<p style='color:green;'>✅ Query executed successfully.</p>";
        } elseif ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<tr>";
            while ($field = $result->fetch_field()) {
                echo "<th>" . htmlspecialchars($field->name) . "</th>";
            }
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $col) {
                    echo "<td>" . htmlspecialchars($col) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } elseif ($result && $result->num_rows == 0) {
            echo "<p>0 rows returned.</p>";
        } else {
            echo "<p style='color:red;'>❌ Error: " . $conn->error . "</p>";
        }
        $conn->close();
    }
}
?>
</div>

</body>
</html>