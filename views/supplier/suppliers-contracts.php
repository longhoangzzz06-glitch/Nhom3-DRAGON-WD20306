<h2>Contracts for <?= htmlspecialchars($supplier['name']) ?></h2>

<table border="1">
  <tr><th>ID</th><th>Title</th><th>Start</th><th>End</th><th>Total</th><th>File</th></tr>
  <?php foreach($contracts as $c): ?>
    <tr>
      <td><?= $c['id'] ?></td>
      <td><?= htmlspecialchars($c['title']) ?></td>
      <td><?= $c['start_date'] ?></td>
      <td><?= $c['end_date'] ?></td>
      <td><?= $c['total_value'] ?></td>
      <td><?php if($c['contract_file']): ?><a target="_blank" href="<?= $c['contract_file'] ?>">View</a><?php endif; ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<h3>Add contract</h3>
<form action="index.php?act=/supplier-contract-store" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="supplier_id" value="<?= $supplier['id'] ?>">
  <label>Title</label><input name="title"><br>
  <label>Start</label><input type="date" name="start_date"><br>
  <label>End</label><input type="date" name="end_date"><br>
  <label>Total value</label><input name="total_value" type="number" step="0.01"><br>
  <label>File</label><input type="file" name="contract_file"><br>
  <label>Terms</label><textarea name="terms"></textarea><br>
  <button>Save contract</button>
</form>
