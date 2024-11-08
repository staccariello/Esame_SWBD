<?php
session_start();
if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'proprietario') {
    echo 'proprietario';
} else {
    echo 'cliente'; 
}
?>
