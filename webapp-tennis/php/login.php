<?php
include 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM utenti WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Autenticazione avvenuta con successo
                session_start();
                $_SESSION['email'] = $user['email']; 
                $_SESSION['ruolo'] = $user['ruolo']; 
                $_SESSION['user_id'] = $user['id']; 
                header('Location: ../home.html'); 
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