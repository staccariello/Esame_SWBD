<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo 'Devi essere loggato.';
    exit();
}

$userId = $_SESSION['user_id'];

// Ottieni la data corrente
$dataCorrente = date('Y-m-d');

// Query per annullare le prenotazioni scadute
$updateSql = "DELETE FROM prenotazioni WHERE data_prenotazione < ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("s", $dataCorrente);
$updateStmt->execute();
$updateStmt->close();

// Query per ottenere le prenotazioni attive
$sql = "SELECT * FROM prenotazioni WHERE utente_id = ? AND stato = 'prenotata'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Stampa le informazioni sulla prenotazione
        echo '<div class="container">';
        echo '<form action="php/annulla_prenotazione.php" method="post">';
        echo '<p>Data: ' . $row['data_prenotazione'] . '</p>';
        echo '<p>Orario: ' . $row['orario'] . '</p>';
        echo '<p>Campo: ' . $row['campo_id'] . '</p>';
        echo '<input type="hidden" name="prenotazione_id" value="' . $row['id_prenotazione'] . '">';
        echo '<button type="submit" style="background-color: red; color: white; border: none; padding: 10px;">Annulla prenotazione</button>';
        echo '</form>';
        echo '</div>';
    }
} else {
    echo 'Non hai prenotazioni attive.';
}

$stmt->close();
$conn->close();
?>
