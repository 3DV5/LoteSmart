<h1>Lotes</h1>
<p><a href="?r=lote_create">Novo Lote</a></p>
<?php if (empty($lotes)): ?>
  <p>Sem lotes cadastrados.</p>
<?php else: ?>
  <table border="1" cellpadding="6" cellspacing="0">
    <tr><th>ID</th><th>Código</th><th>Descrição</th><th>Quantidade</th></tr>
    <?php foreach ($lotes as $lt): ?>
      <tr>
        <td><?=htmlspecialchars($lt['id'])?></td>
        <td><?=htmlspecialchars($lt['codigo'])?></td>
        <td><?=htmlspecialchars($lt['descricao'])?></td>
        <td><?=htmlspecialchars($lt['quantidade'])?></td>
        <td>
          <a href="?r=lote_edit&id=<?= $lt['id'] ?>">Editar</a>
          <form method="post" action="?r=lote_delete&id=<?= $lt['id'] ?>" style="display:inline" onsubmit="return confirm('Confirma exclusão?');">
            <button type="submit">Excluir</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
