<?php
$base = dirname($_SERVER['SCRIPT_NAME']);
if ($base === '/' || $base === '\\' || $base === '.') {
    $base = '';
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>LoteSmart</title>
  <link rel="stylesheet" href="<?= $base ?>/assets/css/base.css">
  <?php
  $pageCss = __DIR__ . '/../assets/css/' . $template . '.css';
  if (isset($template) && file_exists($pageCss)) {
      $href = $base . '/assets/css/' . $template . '.css';
      echo '<link rel="stylesheet" href="' . $href . '">';
  }
  ?>
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
