<?php
$base = '/';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>LoteSmart</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;max-width:900px;margin:20px auto;padding:10px}
    .nav{margin-bottom:20px}
    .nav a{margin-right:10px}
    .error{color:#b00}
  </style>
 </head>
<body>
  <div class="nav">
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="?r=dashboard">Dashboard</a>
      <a href="?r=lotes">Lotes</a>
      <a href="?r=logout">Sair</a>
    <?php else: ?>
      <a href="?r=login">Entrar</a>
      <a href="?r=register">Registrar</a>
    <?php endif; ?>
  </div>

  <div class="content">
    <?php include __DIR__ . '/' . $template . '.php'; ?>
  </div>
</body>
</html>
