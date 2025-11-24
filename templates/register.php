<h1>Registrar</h1>
<?php if (!empty($error)): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post" action="?r=register">
  <div><label>Nome<br><input type="text" name="name" required></label></div>
  <div><label>E-mail<br><input type="email" name="email" required></label></div>
  <div><label>Senha<br><input type="password" name="password" required></label></div>
  <div><button type="submit">Registrar</button></div>
</form>
