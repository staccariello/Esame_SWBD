<?php
include 'config.php';

if (isset($_POST['data'], $_POST['campo_id'])) {
    $data = $_POST['data'];
    $campo_id = $_POST['campo_id'];

    // Query per le ore prenotate
    $stmt = $conn->prepare("SELECT orario FROM prenotazioni WHERE data_prenotazione = ? AND campo_id = ?");
    $stmt->bind_param("ss", $data, $campo_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $orePrenotate = [];
    while ($row = $result->fetch_assoc()) {
        $orePrenotate[] = $row['orario'];
    }

    // Le ore disponibili (19:00, 20:00, 21:00, 22:00, 23:00)
    $oreDisponibili = ['19:00', '20:00', '21:00', '22:00', '23:00'];

    // Crea il form per tutte le ore
    foreach ($oreDisponibili as $orario) {
        if (in_array($orario, $orePrenotate)) {
            // Ora prenotata: disabilita il bottone
            echo '<div class="time-slot">';
            echo '<button class="btn-disabled" disabled>' . $orario . ' (Prenotata)</button>';
            echo '</div>';
        } else {
            // Ora disponibile
            echo '<div class="time-slot">';
            echo '<button class="btn-available" onclick="bookHour(\'' . $orario . '\')">' . $orario . '</button>';
            echo '</div>';
        }
    }
} else {
    echo 'Errore: dati mancanti.';
}
?>