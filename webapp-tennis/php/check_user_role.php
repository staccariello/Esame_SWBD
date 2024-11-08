<?php
session_start();
if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'proprietario') {
    echo 'proprietario';
} else {
    echo 'cliente'; // O qualsiasi altro valore tu voglia restituire
}
?>
