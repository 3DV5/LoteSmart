<?php $isEdit = !empty($lote); ?>
<h1><?= $isEdit ? 'Editar Lote' : 'Novo Lote' ?></h1>
<form method="post" action="?r=<?= $isEdit ? 'lote_edit&id='.$lote['id'] : 'lote_create' ?>">
  <div><label>Código<br><input type="text" name="codigo" required value="<?= htmlspecialchars($lote['codigo'] ?? '') ?>"></label></div>
  <div><label>Descrição<br><input type="text" name="descricao" value="<?= htmlspecialchars($lote['descricao'] ?? '') ?>"></label></div>
  <div><label>Quantidade<br><input type="number" name="quantidade" value="<?= htmlspecialchars($lote['quantidade'] ?? 0) ?>"></label></div>
  <div><label>Data Fabricação<br><input type="date" name="data_fabricacao" value="<?= htmlspecialchars($lote['data_fabricacao'] ?? '') ?>"></label></div>
  <div><label>Data Validade<br><input type="date" name="data_validade" value="<?= htmlspecialchars($lote['data_validade'] ?? '') ?>"></label></div>
  <div><label>Status<br>
    <select name="status">
      <option value="ativo" <?= (isset($lote['status']) && $lote['status']=='ativo') ? 'selected' : '' ?>>Ativo</option>
      <option value="bloqueado" <?= (isset($lote['status']) && $lote['status']=='bloqueado') ? 'selected' : '' ?>>Bloqueado</option>
      <option value="expirado" <?= (isset($lote['status']) && $lote['status']=='expirado') ? 'selected' : '' ?>>Expirado</option>
    </select>
  </label></div>
  <div><button type="submit">Salvar</button></div>
</form>
