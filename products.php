<?php
// products.php
$host = "127.0.0.1";
$user = "root";       // change if needed
$pass = "";           // change if needed
$db   = "Canteen_Management_System"; // change to your DB name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ===== KPI Cards =====
$totalProducts   = $conn->query("SELECT COUNT(*) as total FROM Products")->fetch_assoc()['total'];
$inStock         = $conn->query("SELECT COUNT(*) as instock FROM Inventory WHERE stock_quantity > 0")->fetch_assoc()['instock'];
$outStock        = $conn->query("SELECT COUNT(*) as outstock FROM Inventory WHERE stock_quantity = 0")->fetch_assoc()['outstock'];
$totalCategories = $conn->query("SELECT COUNT(*) as total FROM Categories")->fetch_assoc()['total'];

// ===== Stock Distribution (Query for Chart) =====
$stockLabels = [];
$stockValues = [];
$res = $conn->query("
    SELECT c.category_name, COALESCE(SUM(i.stock_quantity),0) as stock
    FROM Categories c
    LEFT JOIN Products p ON c.category_id = p.category_id
    LEFT JOIN Inventory i ON p.product_id = i.product_id
    GROUP BY c.category_id
");
while ($row = $res->fetch_assoc()) {
    $stockLabels[] = $row['category_name'];
    $stockValues[] = $row['stock'];
}

// ===== Top Products (Query for Table) =====
$topProducts = [];
$res2 = $conn->query("
    SELECT p.product_name, SUM(oi.quantity) as sales
    FROM Order_Items oi
    JOIN Products p ON oi.product_id = p.product_id
    JOIN Orders o ON oi.order_id = o.order_id
    WHERE o.order_status='completed'
    GROUP BY p.product_id
    ORDER BY sales DESC
    LIMIT 5
");
while ($row = $res2->fetch_assoc()) {
    $topProducts[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Products Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { background: #f8f9fa; }
    .card { border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .dashboard-header { text-align: center; margin: 30px 0; }
  </style>
</head>
<body>
<div class="container my-4">
  <h2 class="dashboard-header">📦 Products Dashboard</h2>

  <!-- KPI Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Total Products</h5><h2><?= $totalProducts ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>In Stock</h5><h2><?= $inStock ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Out of Stock</h5><h2><?= $outStock ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Categories</h5><h2><?= $totalCategories ?></h2></div></div>
  </div>

  <!-- Charts + Table -->
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Stock Distribution</h5>
        <canvas id="stockChart"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Top Products</h5>
        <table class="table table-striped">
          <thead><tr><th>Product</th><th>Sales</th></tr></thead>
          <tbody>
            <?php foreach ($topProducts as $tp): ?>
              <tr><td><?= htmlspecialchars($tp['product_name']) ?></td><td><?= $tp['sales'] ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
new Chart(document.getElementById('stockChart'), {
  type:'pie',
  data:{
    labels: <?= json_encode($stockLabels) ?>,
    datasets:[{
      data: <?= json_encode($stockValues) ?>,
      backgroundColor:['#007bff','#28a745','#ffc107','#dc3545','#6f42c1','#20c997','#fd7e14']
    }]
  }
});
</script>
</body>
</html>
