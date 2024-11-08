<?php
include 'config.php'; 
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['ruolo'] !== 'proprietario') {
    echo 'Accesso non autorizzato.';
    exit();
}

$nome_torneo = $_POST['nome_torneo'];
$data_inizio = $_POST['data_inizio'];
$data_fine = $_POST['data_fine'];
$campo_id = $_POST['campo_id'];
$proprietario_id = $_SESSION['user_id'];
$stato = 'in corso'; 

$sql = "INSERT INTO tornei (nome_torneo, data_inizio, data_fine, stato, proprietario_id, tipo_campo) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $nome_torneo, $data_inizio, $data_fine, $stato, $proprietario_id, $campo_id);

if ($stmt->execute()) {
    $orari = ['19:00', '20:00', '21:00', '22:00', '23:00']; 
    $currentDate = $data_inizio;
    $date = new DateTime($data_inizio);
    $data_fine_dt = new DateTime($data_fine);
    
    while (strtotime($currentDate) <= strtotime($data_fine)) {
    foreach ($orari as $orario) {
        $sqlPrenotazione = "INSERT INTO prenotazioni (utente_id, campo_id, orario, data_prenotazione, stato)
                            VALUES (?, ?, ?, ?, 'prenotata')";
        $stmtPrenotazione = $conn->prepare($sqlPrenotazione);
        $stmtPrenotazione->bind_param("isss", $proprietario_id, $campo_id, $orario, $currentDate);
        $stmtPrenotazione->execute();
    }
    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
}
    header('Location: ../tornei.html');
} else {
    echo 'Errore durante la creazione del torneo: ' . $stmt->error;
}

$stmt->close();
$conn->close();
?>
