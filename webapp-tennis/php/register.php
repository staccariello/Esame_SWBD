<?php
include 'config.php'; // Include la connessione al database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Riceve e sanifica i dati dal form
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Cripta la password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Controlla se l'email esiste già
    $sql = "SELECT * FROM utenti WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "L'email esiste già. Per favore, usa un'altra email.";
    } else {
        // Inserisce il nuovo utente nel database con ruolo predefinito "cliente"
        $sql = "INSERT INTO utenti (nome, cognome, email, password, ruolo) VALUES ('$nome', '$cognome', '$email', '$hashed_password', 'cliente')";
        if ($conn->query($sql) === TRUE) {
            echo "Registrazione avvenuta con successo!";
            header('Location: ../index.html'); // Reindirizza al login
            exit();
        } else {
            echo "Errore: " . $conn->error;
        }
    }
    $conn->close();
}
?>
