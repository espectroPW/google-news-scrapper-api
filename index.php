<?php
// Wczytaj dane z pliku JSON
$jsonData = file_get_contents('news_data.json');
$news = json_decode($jsonData, true);

// Wyświetl dane
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Najnowsze wiadomości</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        h1 { color: #333; }
        .news-item { border-bottom: 1px solid #ccc; padding: 10px 0; display: flex; }
        .news-item h2 { margin: 0; }
        .news-item p { margin: 5px 0; }
        .news-item a { color: #1a0dab; text-decoration: none; }
        .news-item a:hover { text-decoration: underline; }
        .news-image { width: 100px; height: 100px; object-fit: cover; margin-right: 15px; }
    </style>
</head>
<body>
    <h1>Najnowsze wiadomości</h1>
    <?php foreach ($news as $item): ?>
        <div class="news-item">
            <?php if (!empty($item['imageUrl'])): ?>
                <img src="<?php echo htmlspecialchars($item['imageUrl']); ?>" alt="News thumbnail" class="news-image">
            <?php endif; ?>
            <div>
                <h2><a href="<?php echo htmlspecialchars($item['link']); ?>" target="_blank"><?php echo htmlspecialchars($item['title']); ?></a></h2>
                <p><?php echo htmlspecialchars(strip_tags($item['description'])); ?></p>
                <p><small>Data publikacji: <?php echo htmlspecialchars($item['pubDate']); ?></small></p>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>