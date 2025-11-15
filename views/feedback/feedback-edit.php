<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Feedback</title>
</head>
<body>
    <h2>📝 Edit Feedback</h2>
    <form action="index.php?controller=Feedback&action=update" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label>Feedback Content:</label><br>
        <textarea name="content" rows="4" cols="50"><?= htmlspecialchars($data['content']) ?></textarea><br><br>

        <label>Rating (1–5):</label>
        <input type="number" name="rating" value="<?= $data['rating'] ?>" min="1" max="5"><br><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
