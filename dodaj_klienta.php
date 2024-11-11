<?php
header('Content-Type: application/json');

// Konfiguracja połączenia z bazą danych
$host = "localhost";
$dbname = "biuro_podrozy";
$username = "root";
$password = "";

// Połączenie z bazą danych
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "Błąd połączenia z bazą danych"]);
    exit();
}

// Sprawdzenie, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobranie danych z formularza
    $imie = $_POST["imie"];
    $nazwisko = $_POST["nazwisko"];
    $telefon = $_POST["telefon"];
    $email = $_POST["email"];
    $adres = $_POST["adres"];
    $kod_pocztowy = $_POST["kod_pocztowy"];
    $miasto = $_POST["miasto"];

    // Dodanie klienta do bazy danych
    try {
        // Przygotowanie zapytania
        $sql = "INSERT INTO klienci (imie, nazwisko, telefon, email, adres, kod_pocztowy, miasto) 
                VALUES (:imie, :nazwisko, :telefon, :email, :adres, :kod_pocztowy, :miasto)";
        $stmt = $pdo->prepare($sql);
        
        // Przypisanie wartości
        $stmt->bindParam(':imie', $imie);
        $stmt->bindParam(':nazwisko', $nazwisko);
        $stmt->bindParam(':telefon', $telefon);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':adres', $adres);
        $stmt->bindParam(':kod_pocztowy', $kod_pocztowy);
        $stmt->bindParam(':miasto', $miasto);

        // Wykonanie zapytania
        $stmt->execute();

        // Pobranie ID nowego klienta
        $klient_id = $pdo->lastInsertId();

        // Zwrócenie wyniku w formacie JSON
        echo json_encode(["success" => true, "klient_id" => $klient_id]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => "Błąd podczas dodawania klienta: " . $e->getMessage()]);
    }
}
