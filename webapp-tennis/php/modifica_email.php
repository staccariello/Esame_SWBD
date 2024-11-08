<?php
include 'config.php'; // Include la connessione al database
session_start(); // Inizia la sessione

// Controlla se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    echo 'Devi essere loggato.';
    exit();
}

// Ottieni l'ID dell'utente dalla sessione
$userId = $_SESSION['user_id'];

// Controlla se l'email è stata inviata tramite POST
if (isset($_POST['email'])) {
    $newEmail = $_POST['email'];

    // Validazione dell'email
    if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        // Query per aggiornare l'email
        $sql = "UPDATE utenti SET email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $newEmail, $userId);

            // Esegui la query
            if ($stmt->execute()) {
                echo 'Email aggiornata con successo!';
            } else {
                echo 'Errore nell\'aggiornamento dell\'email.';
            }

            $stmt->close(); // Chiudi lo statement
        } else {
            echo 'Errore nella preparazione della query.';
        }
    } else {
        echo 'Formato email non valido.';
    }
} else {
    echo 'Nessuna email fornita.';
}

$conn->close(); // Chiudi la connessione al database
?>
