<?php
$servername = "localhost";
$username = "root";  // Sostituisci con il tuo username MySQL
$password = "";      // Sostituisci con la tua password MySQL
$dbname = "tennisbooking"; // Nome del tuo database

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>
