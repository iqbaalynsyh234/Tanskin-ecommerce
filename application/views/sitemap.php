<!DOCTYPE html>
<html>
<head>
    <title>Site Map</title>
</head>
<body>
    <h1>Site Map</h1>
    <ul>
        <?php foreach ($urls as $url): ?>
            <li><a href="<?= $url ?>"><?= $url ?></a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
