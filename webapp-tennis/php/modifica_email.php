<?php
include 'config.php'; 
session_start(); 

if (!isset($_SESSION['user_id'])) {
    echo 'Devi essere loggato.';
    exit();
}

$userId = $_SESSION['user_id'];

if (isset($_POST['email'])) {
    $newEmail = $_POST['email'];

    if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $sql = "UPDATE utenti SET email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $newEmail, $userId);

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

$conn->close(); 
?>
