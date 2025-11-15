<h2>Suppliers</h2>

<form method="GET" action="index.php">
  <input type="hidden" name="act" value="/suppliers">
  <input type="text" name="q" placeholder="Search name..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
  <select name="stype">
    <option value="">All types</option>
    <option value="hotel">Hotel</option>
    <option value="transport">Transport</option>
    <option value="restaurant">Restaurant</option>
    <option value="ticket">Ticket</option>
    <option value="visa">Visa</option>
    <option value="insurance">Insurance</option>
  </select>
  <button>Search</button>
</form>

<a href="index.php?act=/supplier-add">+ Add supplier</a>

<table border="1" cellpadding="6">
  <tr>
    <th>ID</th><th>Name</th><th>Type</th><th>Contact</th><th>Actions</th>
  </tr>
  <?php foreach($suppliers as $s): ?>
  <tr>
    <td><?= $s['id'] ?></td>
    <td><?= htmlspecialchars($s['name']) ?></td>
    <td><?= $s['service_type'] ?></td>
    <td><?= htmlspecialchars($s['contact_name']." / ".$s['contact_phone']) ?></td>
    <td>
      <a href="index.php?act=/supplier-contracts&supplier_id=<?= $s['id'] ?>">Contracts</a> |
      <a href="index.php?act=/supplier-quotes&supplier_id=<?= $s['id'] ?>">Quotes</a> |
      <a href="index.php?act=/supplier-payments&supplier_id=<?= $s['id'] ?>">Payments</a> |
      <a href="index.php?act=/supplier-debts&supplier_id=<?= $s['id'] ?>">Debts</a> |
      <a href="index.php?act=/supplier-summary&supplier_id=<?= $s['id'] ?>">Summary</a> |
      <a href="index.php?act=/supplier-edit&id=<?= $s['id'] ?>">Edit</a> |
      <a onclick="return confirm('Delete?')" href="index.php?act=/supplier-delete&id=<?= $s['id'] ?>">Delete</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
