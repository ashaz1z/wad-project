<?php
require 'db.php';

$rows = $db->query("SELECT * FROM transactions ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
</head>
<body>
<h2>Transaction History</h2>
<a href="index.php">⬅ Back</a>

<hr>

<?php if (!$rows): ?>
    No transactions yet.
<?php else: ?>
    <?php foreach ($rows as $r): ?>
        <p>
            <strong>#<?= $r['id'] ?></strong><br>
            Items: <?= $r['items'] ?><br>
            Total: $<?= $r['total'] ?><br>
            Date: <?= $r['created_at'] ?>
        </p>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
