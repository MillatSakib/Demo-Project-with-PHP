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
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Total Customers</h5><h2>128</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>New This Month</h5><h2>25</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Active</h5><h2>110</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Inactive</h5><h2>18</h2></div></div>
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
            <tr><td>John Doe</td><td>45</td></tr>
            <tr><td>Mary Jane</td><td>32</td></tr>
            <tr><td>Michael Smith</td><td>27</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
new Chart(document.getElementById('customerChart'), {
  type: 'line',
  data: { labels: ['Jan','Feb','Mar','Apr','May','Jun'],
    datasets: [{ data:[5,10,15,20,25,30], label:"New Customers",
      borderColor:'#007bff', backgroundColor:'rgba(0,123,255,0.2)', fill:true, tension:.3 }]
  },
  options: { plugins:{legend:{display:false}} }
});
</script>
</body>
</html>
