<h1>Entrar</h1>
<?php if (!empty($error)): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post" action="?r=login">
  <div><label>E-mail<br><input type="email" name="email" required></label></div>
  <div><label>Senha<br><input type="password" name="password" required></label></div>
  <div><button type="submit">Entrar</button></div>
</form>
