<?php
include 'config.php'; 
session_start(); 

if (isset($_POST['torneo_id']) && isset($_POST['utente_id'])) {
    $torneo_id = $_POST['torneo_id'];
    $utente_id = $_POST['utente_id'];

    if (empty($torneo_id) || empty($utente_id)) {
        echo "Dati mancanti: torneo_id = " . $torneo_id . ", utente_id = " . $utente_id;
        exit();
    }

    $sql = "DELETE FROM partecipanti_torneo WHERE utente_id = ? AND torneo_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $utente_id, $torneo_id);

if ($stmt->execute()) {
    header('Location: ../tornei.html'); 
    exit(); 
} else {
        echo "Errore: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Dati mancanti per la registrazione della partecipazione.";
}

$conn->close();
?>

