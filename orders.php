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
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Total Orders</h5><h2>920</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Pending</h5><h2>45</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Completed</h5><h2>850</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Canceled</h5><h2>25</h2></div></div>
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
            <tr><td>#1001</td><td>John Doe</td><td>Completed</td></tr>
            <tr><td>#1002</td><td>Mary Jane</td><td>Pending</td></tr>
            <tr><td>#1003</td><td>Michael Smith</td><td>Canceled</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
new Chart(document.getElementById('orderChart'), {
  type:'bar',
  data:{ labels:['Jan','Feb','Mar','Apr','May','Jun'],
    datasets:[{ label:'Orders', data:[120,150,180,200,170,100], backgroundColor:'#007bff' }] }
});
</script>
</body>
</html>
