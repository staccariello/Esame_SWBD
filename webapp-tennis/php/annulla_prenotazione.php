<?php 
include 'config.php';
session_start();

// Verifica che l'utente sia loggato e che ci sia un ID prenotazione
if (!isset($_SESSION['user_id']) || !isset($_POST['prenotazione_id'])) {
    echo 'Errore: ID utente o prenotazione mancante.';
    exit();
}

$utenteId = $_SESSION['user_id'];
$prenotazioneId = $_POST['prenotazione_id'];

// Aggiorna lo stato della prenotazione in "annullata"
$sql = "UPDATE prenotazioni SET stato = 'annullata' WHERE id_prenotazione = ? AND utente_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $prenotazioneId, $utenteId);

if ($stmt->execute()) {
    echo 'Prenotazione annullata con successo.';
} else {
    echo 'Errore durante l\'annullamento della prenotazione.';
}

$stmt->close();
$conn->close();

// Verifica il ruolo dell'utente nella sessione e reindirizza alla pagina corretta
if (isset($_SESSION['ruolo']) && $_SESSION['ruolo'] === 'proprietario') {
    header("Location: ../profiloproprietario.html");
} else {
    header("Location: ../profilo.html");
}
exit();
?>

