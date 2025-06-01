<?php
header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');

$host = "www.thyagoquintas.com.br"; // ou 127.0.0.1 se estiver rodando localmente
$user = "engenharia_31";
$password = "tamanduamirim";
$database = "engenharia_31";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    echo json_encode(["erro" => "Erro na conexão"]);
    exit;
}

$sql = "SELECT temperatura, umidade, data_hora FROM dht_logs ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["erro" => "Sem dados"]);
}

$conn->close();
?>
