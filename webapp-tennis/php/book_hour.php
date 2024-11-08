<?php
include 'config.php';
session_start();

if (isset($_POST['data'], $_POST['orario'], $_POST['campo_id']) && isset($_SESSION['user_id'])) {
    $data = $_POST['data'];
    $orario = $_POST['orario'];
    $campo_id = $_POST['campo_id'];
    $utente_id = $_SESSION['user_id'];

    // Verifica se l'orario è già prenotato per quella data e quel campo
    $stmt = $conn->prepare("SELECT * FROM prenotazioni WHERE data_prenotazione = ? AND orario = ? AND campo_id = ?");
    $stmt->bind_param("sss", $data, $orario, $campo_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Inserisci la prenotazione
        $stmt = $conn->prepare("INSERT INTO prenotazioni (utente_id, campo_id, orario, data_prenotazione, stato) VALUES (?, ?, ?, ?, 'prenotata')");
        $stmt->bind_param("isss", $utente_id, $campo_id, $orario, $data);

        if ($stmt->execute()) {
            echo 'Prenotazione avvenuta con successo!';
        } else {
            echo 'Errore nella prenotazione.';
        }
    } else {
        echo 'Orario non disponibile.';
    }
} else {
    echo 'Errore: dati mancanti.';
}
?>
