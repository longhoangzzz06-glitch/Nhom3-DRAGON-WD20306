<h1>Feedback List</h1>
<a href="index.php?controller=feedback&action=add">Add Feedback</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Tour</th>
        <th>Customer</th>
        <th>Supplier</th>
        <th>Rating</th>
        <th>Comment</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($feedbacks as $f): ?>
    <tr>
        <td><?= $f['id'] ?></td>
        <td><?= $f['tour_name'] ?></td>
        <td><?= $f['customer_name'] ?></td>
        <td><?= $f['supplier_name'] ?? '' ?></td>
        <td><?= $f['rating'] ?></td>
        <td><?= $f['comment'] ?></td>
        <td><?= $f['created_at'] ?></td>
        <td>
            <a href="index.php?controller=feedback&action=edit&id=<?= $f['id'] ?>">Edit</a> |
            <a href="index.php?controller=feedback&action=delete&id=<?= $f['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
