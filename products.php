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

  <!-- Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Total Products</h5><h2>350</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>In Stock</h5><h2>300</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Out of Stock</h5><h2>50</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Categories</h5><h2>12</h2></div></div>
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
            <tr><td>Laptop</td><td>150</td></tr>
            <tr><td>Smartphone</td><td>120</td></tr>
            <tr><td>Headphones</td><td>80</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
new Chart(document.getElementById('stockChart'), {
  type:'pie',
  data:{ labels:['Electronics','Clothing','Food','Other'],
    datasets:[{ data:[120,90,80,60], backgroundColor:['#007bff','#28a745','#ffc107','#dc3545'] }] }
});
</script>
</body>
</html>
