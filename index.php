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
        body { font-family: Arial, sans-serif; margin: 20px; }
        input[type=text] { width: 600px; padding: 5px; }
        button { padding: 6px 12px; }
        table { border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Run SQL Query on hospital-management-system</h2>
    <form method="POST">
        <input type="text" name="query" placeholder="Enter SQL query">
        <button type="submit">Run</button>
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = trim($_POST['query']);

    if (empty($query)) {
        echo "<p style='color:red;'>Please enter a query.</p>";
    } else {

        // ✅ Database Connection
        $servername = "127.0.0.1";
        $username   = "root";
        $password   = "";
        $dbname     = "Canteen_Management_System";

        $conn = new mysqli($servername, $username, $password, $dbname, 3306);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query($query);

        if ($result === TRUE) {
            echo "<p style='color:green;'>Query executed successfully.</p>";
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
            echo "<p>No rows found.</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }

        $conn->close();
    }
}
?>
</body>
</html>
