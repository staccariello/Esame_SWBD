<?php
include 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "SELECT * FROM utenti WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "L'email esiste già. Per favore, usa un'altra email.";
    } else {
        $sql = "INSERT INTO utenti (nome, cognome, email, password, ruolo) VALUES ('$nome', '$cognome', '$email', '$hashed_password', 'cliente')";
        if ($conn->query($sql) === TRUE) {
            echo "Registrazione avvenuta con successo!";
            header('Location: ../index.html'); 
            exit();
        } else {
            echo "Errore: " . $conn->error;
        }
    }
    $conn->close();
}
?>
