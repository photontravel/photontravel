<?php
$host = "sql97.lh.pl";  // Adres serwera bazy danych
$dbname = "'serwer194309_crm";  // Nazwa bazy danych
$username = "serwer194309_crm";  // Użytkownik bazy danych
$password = "Polska09!";  // Hasło do bazy danych

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
