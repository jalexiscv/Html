<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Log</title>
</head>
<body>
<h1>Query Log</h1>
<table border="1">
    <thead>
    <tr>
        <th>Query</th>
        <th>Duration</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($queries as $query): ?>
        <tr>
            <td><?= $query['query'] ?></td>
            <td><?= number_format($query['duration'], 4) ?> ms</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>