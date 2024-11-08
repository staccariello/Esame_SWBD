<?php 
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['prenotazione_id'])) {
    echo 'Errore: ID utente o prenotazione mancante.';
    exit();
}

$utenteId = $_SESSION['user_id'];
$prenotazioneId = $_POST['prenotazione_id'];

// Cambiato UPDATE con DELETE per eliminare la prenotazione
$sql = "DELETE FROM prenotazioni WHERE id_prenotazione = ? AND utente_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $prenotazioneId, $utenteId);

if ($stmt->execute()) {
    echo 'Prenotazione annullata con successo.';
} else {
    echo 'Errore durante l\'annullamento della prenotazione.';
}

$stmt->close();
$conn->close();

// Reindirizzamento in base al ruolo dell'utente
if (isset($_SESSION['ruolo']) && $_SESSION['ruolo'] === 'proprietario') {
    header("Location: ../profiloproprietario.html");
} else {
    header("Location: ../profilo.html");
}
exit();
?>
