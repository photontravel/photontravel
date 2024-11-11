<?php
$host = "localhost";  // Adres serwera bazy danych
$dbname = "biuro_podrozy";  // Nazwa bazy danych
$username = "root";  // Użytkownik bazy danych
$password = "";  // Hasło do bazy danych

try {
    // Tworzymy połączenie z bazą danych
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Obsługa błędów połączenia
    echo "Błąd połączenia: " . $e->getMessage();
    exit();
}
?>
