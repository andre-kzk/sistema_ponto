<?php
$id = $_GET["id"];
$data_inicial = $_GET["data_inicial"];
$data_inicial_m = DateTime::createFromFormat('d/m/Y', $data_inicial);
$data_final = $_GET["data_final"];
$data_final_m = DateTime::createFromFormat('d/m/Y', $data_final);

if (empty($data_inicial) || empty($data_final)) {
    echo "<h3 class='text-danger'>Por favor selecione um intervalo de datas</h3>";
    die();
}

$link = mysqli_connect("localhost", "root", "", "database");
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    die();
}

$query = "
    SELECT
    	nome 
    FROM
    	funcionarios 
    WHERE TRUE 
    	AND id = '{$id}' 
    ORDER BY
    	nome ASC
";

if ($result = mysqli_query($link, $query)) {
    $row = mysqli_fetch_assoc($result);
}

$nome = $row['nome'];

$query = "
    SELECT
    	status_ponto,
    	hora
    FROM
    	registro_ponto
    WHERE TRUE 
    	AND fk_usuario = '{$id}'
        AND hora BETWEEN '{$data_inicial_m->format('Y-m-d')} 00:00:01' AND '{$data_final_m->format('Y-m-d')} 23:59:59'
    ORDER BY
    	hora ASC 
";

$results = mysqli_query($link, $query);
$pontos = array();
while ($row = mysqli_fetch_assoc($results)) {
    $pontos[] = $row;
}

$hora_entrada = null;
$tempo_trabalhado = 0;
?>

<div class="card">
    <div class="card-header">Usuário: <?php echo $nome; ?> | Período: <?php echo $data_inicial . " - " . $data_final; ?> </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Ação</th>
                    <th>Horário</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pontos as $ponto) { ?>
                    <tr>
                        <td><?php if ($ponto['status_ponto'] == '1') {
                                echo "entrada";
                            } else {
                                echo "saida";
                            }; ?></td>
                        <td>
                            <?php
                            $hora_x    = substr($ponto['hora'], 11, 2);
                            $minuto_x  = substr($ponto['hora'], 14, 2);
                            $segundo_x = substr($ponto['hora'], 17, 2);
                            $horario  = "$hora_x:$minuto_x:$segundo_x";
                            $dia = date("d/m/Y", strtotime($ponto['hora'])); ?>
                            <?php echo $horario . ' - ' . $dia; ?>
                        </td>
                    </tr>

                    <?php if ($ponto['status_ponto'] == '1') {
                        $hora_entrada = strtotime($ponto['hora']);
                    } else if ($ponto['status_ponto'] == '0' && $hora_entrada !== null) {
                        $hora_saida = strtotime($ponto['hora']);
                        $tempo_trabalhado += $hora_saida - $hora_entrada;
                        $hora_entrada = null;
                    } ?>
                <?php } ?>
            </tbody>
            <?php
            $horas = $tempo_trabalhado / 3600;
            $horas = number_format($horas, 2);
            ?>
            <tfoot>
                <tr class="font-weight-bold">
                    <td>Total</td>
                    <td>
                        <?php echo $horas; ?> horas
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>