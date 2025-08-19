<?php
// Show nice errors during dev
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Use 127.0.0.1 to avoid socket issues
    $conn = new mysqli('127.0.0.1', 'root', '', 'Canteen_Management_System', 3306);
    $conn->set_charset('utf8mb4');

    // ---- STATS ----
    $totalCustomers = (int)$conn->query("SELECT COUNT(*) AS c FROM Customers")->fetch_assoc()['c'];

    $newThisMonth = (int)$conn->query("
        SELECT COUNT(*) AS c
        FROM Customers
        WHERE YEAR(created_at) = YEAR(CURDATE())
          AND MONTH(created_at) = MONTH(CURDATE())
    ")->fetch_assoc()['c'];

    // Active = customers who have at least one non-cancelled order
    $activeCustomers = (int)$conn->query("
        SELECT COUNT(DISTINCT o.customer_id) AS c
        FROM Orders o
        WHERE o.order_status IN ('pending','completed')
    ")->fetch_assoc()['c'];

    $inactiveCustomers = max(0, $totalCustomers - $activeCustomers);

    // ---- TOP CUSTOMERS ----
    $topRows = [];
    $res = $conn->query("
        SELECT c.customer_name, COUNT(o.order_id) AS purchases
        FROM Orders o
        JOIN Customers c ON c.customer_id = o.customer_id
        WHERE o.order_status IN ('pending','completed')
        GROUP BY c.customer_id, c.customer_name
        ORDER BY purchases DESC
        LIMIT 5
    ");
    while ($r = $res->fetch_assoc()) {
        $topRows[] = $r;
    }

    // ---- CUSTOMER GROWTH (last 6 months) ----
    // Build month keys for last 6 months (YYYY-MM) and labels (Jan, Feb, ...)
    $monthKeys = [];
    $labels = [];
    for ($i = 5; $i >= 0; $i--) {
        $ts = strtotime(date('Y-m-01') . " -$i months");
        $monthKeys[] = date('Y-m', $ts);
        $labels[] = date('M', $ts);
    }

    // Get counts per month from DB and fill missing months with 0
    $map = array_fill_keys($monthKeys, 0);
    $growthRes = $conn->query("
        SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, COUNT(*) AS cnt
        FROM Customers
        WHERE created_at >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01')
        GROUP BY ym
        ORDER BY ym
    ");
    while ($row = $growthRes->fetch_assoc()) {
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
  <title>Customers Dashboard</title>
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
  <h2 class="dashboard-header">👥 Customers Dashboard</h2>

  <!-- Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Total Customers</h5><h2><?= $totalCustomers ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>New This Month</h5><h2><?= $newThisMonth ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Active</h5><h2><?= $activeCustomers ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Inactive</h5><h2><?= $inactiveCustomers ?></h2></div></div>
  </div>

  <!-- Charts + Table -->
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Customer Growth</h5>
        <canvas id="customerChart"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Top Customers</h5>
        <table class="table table-striped">
          <thead><tr><th>Name</th><th>Purchases</th></tr></thead>
          <tbody>
            <?php foreach ($topRows as $row): ?>
              <tr>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <td><?= (int)$row['purchases'] ?></td>
              </tr>
            <?php endforeach; ?>
            <?php if (empty($topRows)): ?>
              <tr><td colspan="2" class="text-muted">No orders yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
new Chart(document.getElementById('customerChart'), {
  type: 'line',
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [{
      data: <?= json_encode($counts) ?>,
      label: "New Customers",
      borderColor: '#007bff',
      backgroundColor: 'rgba(0,123,255,0.2)',
      fill: true,
      tension: .3
    }]
  },
  options: { plugins: { legend: { display: false } } }
});
</script>
</body>
</html>
