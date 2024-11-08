<?php
include 'config.php';
session_start();

// Verifica se l'utente è loggato e se è un proprietario
if (!isset($_SESSION['user_id'])) {
    echo 'ID utente non trovato.';
    exit();
}

$proprietarioId = $_SESSION['user_id'];

// Query per ottenere i tornei creati dal proprietario
$sql = "SELECT id_torneo, nome_torneo, data_inizio, data_fine 
        FROM tornei 
        WHERE proprietario_id = ? AND stato = 'in corso'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $proprietarioId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="banner">';
        echo '<h3>' . htmlspecialchars($row['nome_torneo']) . '</h3>';
        echo '<p>Data Inizio: ' . htmlspecialchars($row['data_inizio']) . '</p>';
        echo '<p>Data Fine: ' . htmlspecialchars($row['data_fine']) . '</p>';
        echo '<form action="php/annulla_torneo.php" method="post">';
        echo '<input type="hidden" name="torneo_id" value="' . $row['id_torneo'] . '">';
        echo '<button type="submit" class="button button-red">Annulla</button>';
        echo '</form>';
        echo '</div>';
    }
} else {
    echo '<p>Non hai tornei in corso.</p>';
}

$stmt->close();
$conn->close();
?>
