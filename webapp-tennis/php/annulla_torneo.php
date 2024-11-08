<?php
include 'config.php';
session_start();

if (!isset($_POST['torneo_id']) || !isset($_SESSION['user_id'])) {
    echo 'ID torneo o utente non trovato.';
    exit();
}

$torneoId = $_POST['torneo_id'];
$proprietarioId = $_SESSION['user_id'];

// Aggiorna lo stato del torneo in "annullato"
$sql = "UPDATE tornei SET stato = 'annullato' WHERE id_torneo = ? AND proprietario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $torneoId, $proprietarioId);

if ($stmt->execute()) {
    // Recupera le date di inizio e fine del torneo e il tipo di campo
    $queryDate = "SELECT data_inizio, data_fine, tipo_campo FROM tornei WHERE id_torneo = ?";
    $stmtDate = $conn->prepare($queryDate);
    $stmtDate->bind_param("i", $torneoId);
    $stmtDate->execute();
    $stmtDate->bind_result($dataInizio, $dataFine, $campoId);

    if ($stmtDate->fetch()) { // Se le date sono recuperate con successo
        $stmtDate->close();

        // Elimina le prenotazioni associate a questo torneo e campo nelle date del torneo
        $deletePrenotazioni = "DELETE FROM prenotazioni WHERE campo_id = ? AND data_prenotazione BETWEEN ? AND ?";
        $stmtDelete = $conn->prepare($deletePrenotazioni);
        $stmtDelete->bind_param("sss", $campoId, $dataInizio, $dataFine);

        if ($stmtDelete->execute()) {
            echo 'Torneo e relative prenotazioni annullati con successo.';
        } else {
            echo 'Errore durante l\'eliminazione delle prenotazioni: ' . $stmtDelete->error;
        }

        $stmtDelete->close();
    } else {
        echo 'Errore durante il recupero delle date del torneo.';
    }
} else {
    echo 'Errore durante l\'annullamento del torneo: ' . $stmt->error;
}

$stmt->close();
$conn->close();

// Reindirizza alla pagina del profilo
header("Location: ../profiloproprietario.html");
exit();
?>
