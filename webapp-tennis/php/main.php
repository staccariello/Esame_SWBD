<?php
include 'config.php'; // Include la connessione al database

session_start(); // Assicurati di avviare la sessione

// Controlla se l'email e il ruolo sono salvati nella sessione
if (isset($_SESSION['email']) && isset($_SESSION['ruolo'])) {
    $ruolo = $_SESSION['ruolo'];
    
    // Determina l'URL del profilo basato sul ruolo
    if ($ruolo == 'proprietario') {
        $profileUrl = 'profiloproprietario.html';
    } else {
        $profileUrl = 'profilo.html';
    }

    // Reindirizza all'URL del profilo (senza "php")
    header("Location: /webapp-tennis/" . $profileUrl);
    exit();
} else {
    // Se l'utente non è loggato
    header('Location: /webapp-tennis/index.html'); // Reindirizza alla pagina di login
    exit();
}
?>
