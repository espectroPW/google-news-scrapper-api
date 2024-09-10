<?php
function scrapeGoogleNews() {
    $url = 'https://news.google.com/rss?hl=pl&gl=PL&ceid=PL:pl';
    $xml = simplexml_load_file($url);
    $news = [];

    foreach ($xml->channel->item as $item) {
        $description = (string)$item->description;
        
        // Próba wyodrębnienia URL obrazka z opisu
        $imgUrl = '';
        if (preg_match('/<img[^>]+src="([^">]+)"/', $description, $match)) {
            $imgUrl = $match[1];
        }

        $news[] = [
            'title' => cleanText($item->title),
            'link' => (string)$item->link,
            'pubDate' => (string)$item->pubDate,
            'description' => cleanText($description),
            'imageUrl' => $imgUrl
        ];
    }

    // Zapisz dane do pliku JSON
    $jsonData = json_encode($news, JSON_PRETTY_PRINT);
    file_put_contents('news_data.json', $jsonData);

    return $news;
}
function cleanText($text) {
    // Zamienia encje HTML na odpowiednie znaki
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    
    // Usuwa tagi HTML
    $text = strip_tags($text);
    
    // Usuwa zbędne białe znaki
    $text = preg_replace('/\s+/', ' ', $text);
    
    // Trim spaces at the beginning and end
    $text = trim($text);
    
    return $text;
}

// Uruchom scrapowanie
scrapeGoogleNews();
?>