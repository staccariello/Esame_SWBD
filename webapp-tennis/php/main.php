<?php
include 'config.php';

session_start(); 

if (isset($_SESSION['email']) && isset($_SESSION['ruolo'])) {
    $ruolo = $_SESSION['ruolo'];
    
    if ($ruolo == 'proprietario') {
        $profileUrl = 'profiloproprietario.html';
    } else {
        $profileUrl = 'profilo.html';
    }

    header("Location: /webapp-tennis/" . $profileUrl);
    exit();
} else {
    header('Location: /webapp-tennis/index.html'); 
    exit();
}
?>
