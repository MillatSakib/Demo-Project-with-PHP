<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("127.0.0.1", "root", "", "Canteen_Management_System", 3306);
    $conn->set_charset("utf8mb4");

    // ---- SUMMARY COUNTS ----
    $totalOrders = (int)$conn->query("SELECT COUNT(*) AS c FROM Orders")->fetch_assoc()['c'];
    $pendingOrders = (int)$conn->query("SELECT COUNT(*) AS c FROM Orders WHERE order_status='pending'")->fetch_assoc()['c'];
    $completedOrders = (int)$conn->query("SELECT COUNT(*) AS c FROM Orders WHERE order_status='completed'")->fetch_assoc()['c'];
    $canceledOrders = (int)$conn->query("SELECT COUNT(*) AS c FROM Orders WHERE order_status='canceled'")->fetch_assoc()['c'];

    // ---- RECENT ORDERS ----
    $recentOrders = [];
    $res = $conn->query("
        SELECT o.order_id, c.customer_name, o.order_status
        FROM Orders o
        JOIN Customers c ON c.customer_id = o.customer_id
        ORDER BY o.order_date DESC
        LIMIT 5
    ");
    while ($row = $res->fetch_assoc()) {
        $recentOrders[] = $row;
    }

    // ---- MONTHLY ORDERS (last 6 months) ----
    $monthKeys = [];
    $labels = [];
    for ($i = 5; $i >= 0; $i--) {
        $ts = strtotime(date('Y-m-01') . " -$i months");
        $monthKeys[] = date('Y-m', $ts);
        $labels[] = date('M', $ts);
    }
    $map = array_fill_keys($monthKeys, 0);

    $res = $conn->query("
        SELECT DATE_FORMAT(order_date, '%Y-%m') AS ym, COUNT(*) AS cnt
        FROM Orders
        WHERE order_date >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01')
        GROUP BY ym
        ORDER BY ym
    ");
    while ($row = $res->fetch_assoc()) {
        if (isset($map[$row['ym']])) {
            $map[$row['ym']] = (int)$row['cnt'];
        }
    }
    $counts = array_values($map);

} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo "<pre style='padding:16px; background:#fff3f3; border:1px solid #f5c2c7; color:#842029; border-radius:8px;'>
    Database error: " . htmlspecialchars($e->getMessage()) . "
    </pre>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Orders Dashboard</title>
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
  <h2 class="dashboard-header">🛒 Orders Dashboard</h2>

  <!-- Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Total Orders</h5><h2><?= $totalOrders ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Pending</h5><h2><?= $pendingOrders ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Completed</h5><h2><?= $completedOrders ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Canceled</h5><h2><?= $canceledOrders ?></h2></div></div>
  </div>

  <!-- Charts + Table -->
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Monthly Orders</h5>
        <canvas id="orderChart"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Recent Orders</h5>
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>Customer</th><th>Status</th></tr></thead>
          <tbody>
            <?php foreach ($recentOrders as $r): ?>
              <tr>
                <td>#<?= htmlspecialchars($r['order_id']) ?></td>
                <td><?= htmlspecialchars($r['customer_name']) ?></td>
                <td><?= ucfirst($r['order_status']) ?></td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($recentOrders)): ?>
              <tr><td colspan="3" class="text-muted">No orders yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
new Chart(document.getElementById('orderChart'), {
  type:'bar',
  data:{
    labels: <?= json_encode($labels) ?>,
    datasets:[{
      label:'Orders',
      data: <?= json_encode($counts) ?>,
      backgroundColor:'#007bff'
    }]
  }
});
</script>
</body>
</html>
