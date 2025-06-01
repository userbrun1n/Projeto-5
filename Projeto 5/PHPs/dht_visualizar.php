<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Leituras do Sensor DHT22</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Leituras do Sensor DHT22</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Temperatura (°C)</th>
            <th>Umidade (%)</th>
            <th>Data e Hora</th>
        </tr>
        <?php
        date_default_timezone_set('America/Sao_Paulo');
        $conn = new mysqli("www.thyagoquintas.com.br", "engenharia_31", "tamanduamirim", "engenharia_31");
        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM dht_logs ORDER BY id DESC";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['temperatura']}</td>";
            echo "<td>{$row['umidade']}</td>";
            echo "<td>{$row['data_hora']}</td>";
            echo "</tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
