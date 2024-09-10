<?php
// db.php

class Database {
    private $host = 'localhost';
    private $db_name = 'nazwa_twojej_bazy_danych';
    private $username = 'twoj_uzytkownik';
    private $password = 'twoje_haslo';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }

    public function insertNews($title, $link, $pubDate, $description, $imageUrl) {
        $query = "INSERT INTO news (title, link, pub_date, description, image_url) 
                  VALUES (:title, :link, :pub_date, :description, :image_url)";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':link', $link);
            $stmt->bindParam(':pub_date', $pubDate);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image_url', $imageUrl);

            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            echo 'Insert Error: ' . $e->getMessage();
            return false;
        }
    }
}

// Przykład użycia:
/*
$database = new Database();
$db = $database->connect();

$database->insertNews(
    'Tytuł artykułu',
    'https://przyklad.com/artykul',
    '2023-05-20 12:00:00',
    'Opis artykułu',
    'https://przyklad.com/obrazek.jpg'
);


$database = new Database();
$db = $database->connect();

foreach ($news as $item) {
    $database->insertNews(
        $item['title'],
        $item['link'],
        $item['pubDate'],
        $item['description'],
        $item['imageUrl']
    );
}
*/
/*

CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    link VARCHAR(255) NOT NULL,
    pub_date DATETIME,
    description TEXT,
    image_url VARCHAR(255)
);
require_once 'db.php';

*/