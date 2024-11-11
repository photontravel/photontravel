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

// Sprawdzenie, czy przekazano ID klienta
if (isset($_GET['id'])) {
    $klient_id = $_GET['id'];

    // Zapytanie do bazy danych o dane klienta
    try {
        $sql = "SELECT * FROM klienci WHERE klient_id = :klient_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':klient_id', $klient_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $klient = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($klient) {
            // Pobranie zdarzeń powiązanych z klientem
            $sql_zdarzenia = "SELECT * FROM zdarzenia WHERE klient_id = :klient_id ORDER BY data_zdarzenia DESC";
            $stmt_zdarzenia = $pdo->prepare($sql_zdarzenia);
            $stmt_zdarzenia->bindParam(':klient_id', $klient_id, PDO::PARAM_INT);
            $stmt_zdarzenia->execute();
            
            $zdarzenia = $stmt_zdarzenia->fetchAll(PDO::FETCH_ASSOC);

            // Zwrócenie danych klienta i zdarzeń w formacie JSON
            echo json_encode([
                "success" => true,
                "imie" => $klient['imie'],
                "nazwisko" => $klient['nazwisko'],
                "telefon" => $klient['telefon'],
                "email" => $klient['email'],
                "adres" => $klient['adres'],
                "kod_pocztowy" => $klient['kod_pocztowy'],
                "miasto" => $klient['miasto'],
                "zdarzenia" => $zdarzenia // Zwracamy zdarzenia związane z klientem
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "Nie znaleziono klienta"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Brak ID klienta"]);
}
?>
