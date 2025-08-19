<!DOCTYPE html>
<html>
<head>
  <title>Canteen Dashboard</title>
  <style>
    *{ box-sizing:border-box; }

    body {
        background:#f0f2f5;
        font-family:'Segoe UI',Arial,sans-serif;
        margin:0;
        display:flex;
        justify-content:center;
        align-items:center;
        min-height:100vh;
    }

    .grid {
        width:90%;
        max-width:1100px;
        display:grid;
        gap:25px;
        grid-template-columns:1fr;          /* Mobile = single column  */
    }

    @media (min-width: 768px){
        .grid {
            grid-template-columns:repeat(3, 1fr);   /* Desktop = 3 cards side-by-side  */
        }
    }

    .card {
        height:180px;
        background:#fff;
        border-radius:15px;
        box-shadow:0 6px 14px rgba(0,0,0,0.1);
        display:flex;
        align-items:center;
        justify-content:center;
        text-align:center;
        text-decoration:none;
        color:#333;
        font-weight:600;
        transition:.2s;
    }

    .card:hover {
        transform:translateY(-6px);
        box-shadow:0 10px 20px rgba(0,0,0,0.15);
    }
  </style>
</head>
<body>

<div class="grid">
    <a href="query-execution.php" class="card">SQL Query Executor</a>
    <a href="customers.php"   class="card">Customers</a>
    <a href="products.php"    class="card">Products</a>
    <a href="orders.php"      class="card">Orders</a>
    <a href="reports.php"     class="card">Reports</a>
</div>

</body>
</html>
