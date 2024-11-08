<?php
include 'config.php'; // Include la connessione al database
session_start(); // Inizia la sessione per usare $_SESSION['user_id']

if (isset($_POST['torneo_id']) && isset($_POST['utente_id'])) {
    $torneo_id = $_POST['torneo_id'];
    $utente_id = $_POST['utente_id'];

    // Aggiungi queste righe per la debug
    if (empty($torneo_id) || empty($utente_id)) {
        echo "Dati mancanti: torneo_id = " . $torneo_id . ", utente_id = " . $utente_id;
        exit();
    }

    // Inserisci nella tabella partecipazioni_tornei
    $sql = "INSERT INTO partecipanti_torneo (utente_id, torneo_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $utente_id, $torneo_id);

if ($stmt->execute()) {
    // Partecipazione registrata con successo
    header('Location: ../tornei.html'); // Assicurati di usare 'Location:' e il percorso corretto
    exit(); // Termina lo script dopo il reindirizzamento
} else {
        // Errore nell'inserimento
        echo "Errore: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Dati mancanti per la registrazione della partecipazione.";
}

$conn->close();
?>
