<?php
include 'config.php'; // Include la connessione al database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Controlla se email e password sono presenti
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // Verifica se l'email esiste nel database
        $sql = "SELECT * FROM utenti WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Controlla se la password è corretta
            if (password_verify($password, $user['password'])) {
                // Autenticazione avvenuta con successo
                session_start();
                $_SESSION['email'] = $user['email']; // Salva l'email in sessione
                $_SESSION['ruolo'] = $user['ruolo']; // Salva il ruolo in sessione
                $_SESSION['user_id'] = $user['id']; // Salva l'ID utente in sessione
                header('Location: ../home.html'); // Reindirizza alla home
                exit();
            } else {
                echo "Email o password errati.";
            }
        } else {
            echo "Email o password errati.";
        }
    } else {
        echo "Compila tutti i campi.";
    }
}
?>