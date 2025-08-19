<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reports Dashboard</title>
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
  <h2 class="dashboard-header">📊 Reports Dashboard</h2>

  <!-- Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Total Revenue</h5><h2>$25K</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Profit</h5><h2>$7K</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Expenses</h5><h2>$18K</h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><h5>Growth</h5><h2>15%</h2></div></div>
  </div>

  <!-- Charts -->
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Revenue vs Expenses</h5>
        <canvas id="financeChart"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Sales Breakdown</h5>
        <canvas id="salesChart"></canvas>
      </div>
    </div>
  </div>
</div>

<script>
new Chart(document.getElementById('financeChart'), {
  type:'line',
  data:{ labels:['Jan','Feb','Mar','Apr','May','Jun'],
    datasets:[{ label:'Revenue', data:[5000,6000,4500,7000,6500,8000], borderColor:'#28a745' },
              { label:'Expenses', data:[3000,3500,4000,3200,3600,4000], borderColor:'#dc3545' }] }
});
new Chart(document.getElementById('salesChart'), {
  type:'doughnut',
  data:{ labels:['Electronics','Clothing','Food','Other'],
    datasets:[{ data:[40,25,20,15], backgroundColor:['#007bff','#28a745','#ffc107','#dc3545'] }] }
});
</script>
</body>
</html>
