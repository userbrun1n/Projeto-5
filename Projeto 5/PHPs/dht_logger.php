<?php
date_default_timezone_set('America/Sao_Paulo'); 

$host = "www.thyagoquintas.com.br";
$user = "engenharia_31";
$password = "tamanduamirim";
$database = "engenharia_31";



$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$temperatura = $_POST['temperatura'] ?? null;
$umidade = $_POST['umidade'] ?? null;

if ($temperatura !== null && $umidade !== null) {
    $sql = "INSERT INTO dht_logs (temperatura, umidade, data_hora) VALUES (?, ?, ?)";
    $dataHora = date("Y-m-d H:i:s"); // Usa o fuso horário definido no PHP
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dds", $temperatura, $umidade, $dataHora);
    $stmt->execute();


    echo $stmt->affected_rows > 0 ? "OK" : "Erro ao inserir";
    $stmt->close();
} else {
    echo "Dados incompletos";
}

$conn->close();
?>
