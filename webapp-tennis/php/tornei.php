<?php
include 'config.php'; 
session_start();

if (isset($_SESSION['user_id'])) {
    $utente = $_SESSION['user_id'];
    $ruolo = $_SESSION['ruolo']; 
} else {
    echo 'Devi essere loggato per partecipare ai tornei.';
    exit();
}

$deleteSql = "DELETE FROM tornei WHERE data_fine < NOW()";
$conn->query($deleteSql);

if ($ruolo === 'proprietario') {
    echo '<div style="margin-bottom: 20px;">';
    echo '<a href="aggiungi_torneo.html" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Crea Torneo</a>';
    echo '</div>';
}

$sql = "SELECT id_torneo, nome_torneo, data_inizio, data_fine, stato, proprietario_id FROM tornei WHERE stato = 'in corso'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $torneo_id = $row['id_torneo'];
        $checkSql = "SELECT * FROM partecipanti_torneo WHERE utente_id = ? AND torneo_id = ?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param("ii", $utente, $torneo_id);
        $stmt->execute();
        $checkResult = $stmt->get_result();

        echo '<div class="banner" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; border: 1px solid #ccc; margin-bottom: 20px;">';
        echo '<div>';
        echo '<h2>' . $row['nome_torneo'] . '</h2>';
        echo '<p>Data Inizio: ' . $row['data_inizio'] . '</p>';
        echo '<p>Data Fine: ' . $row['data_fine'] . '</p>';
        echo '<p>Stato: ' . $row['stato'] . '</p>';
        echo '</div>';
        
        echo '<div>';
        if ($checkResult->num_rows > 0) {
            echo '<span>Sei già iscritto a questo torneo!</span>';
            // Pulsante per annullare l'iscrizione
            echo '<form action="php/annulla_partecipazione.php" method="post" onsubmit="return partecipaTorneo(' . $row['id_torneo'] . ', ' . $utente . ', this);">';
            echo '<input type="hidden" name="torneo_id" value="' . $row['id_torneo'] . '">';
            echo '<input type="hidden" name="utente_id" value="' . $utente . '">'; // Aggiungi l'ID utente
            echo '<button type="submit" style="background-color: red; color: white; border: none; padding: 10px 20px; cursor: pointer;">Annulla iscrizione</button>';
            echo '</form>';
        } else {
            // Modulo per partecipare al torneo
            echo '<form action="php/partecipa_torneo.php" method="post" onsubmit="return annullaTorneo(' . $row['id_torneo'] . ', ' . $utente . ', this);">';
            echo '<input type="hidden" name="torneo_id" value="' . $row['id_torneo'] . '">';
            echo '<input type="hidden" name="utente_id" value="' . $utente . '">'; // Aggiungi l'ID utente
            echo '<input type="button" value="Partecipa ora!" onclick="this.form.submit(); this.style.display=\'none\';">';
            echo '</form>';
        }
        echo '</div>';
        
        echo '</div>';
    }
} else {
    echo '<p>Non ci sono tornei attivi al momento.</p>';
}

$conn->close();
?>
