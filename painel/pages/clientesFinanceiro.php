<?php
$pageTable = 'tb_admin.clientes';
$pageTableFin = 'tb_admin.clientes-financeiro';
function pageUrl($next = null)
{
    $baseUrl = './clientesFinanceiro';
    // echo $baseUrl . $next;
    // return $baseUrl . $next;
    return $next ? $baseUrl . $next : $baseUrl;
}
$maxItemsPerPage = 6;

?>
<section>
    <?php
    if (isset($_GET['pago'])) {
        $sql = Sql::connect()->prepare("UPDATE `$pageTableFin` SET status = 1 WHERE ID = ?");
        $sql->execute([$_GET['pago']]);
    }
    if (isset($_GET['email'])) {
        $parcela_id = $_GET['parcela'];
        $cliente_id = $_GET['email'];
        if (isset($_COOKIE['email_cliente_' . $cliente_id])) {
            Painel::htmlPopUp('error', 'E-mail lembrete já foi enviado');
        } else {
            // podemos enviar o e-mail;
            Painel::htmlPopUp('ok', 'E-mail lembrete foi enviado');
            setcookie('email_cliente_' . $cliente_id, 'true', time() + 30, '/');
            // 
            /* Warning: Cannot modify header information - headers already sent by (output started at path/main.php:127) in path/painel/pages/clientesFinanceiro.php on line 28
            * It is what it is, for this cookie to be set, it should be included in the response header before the html content, as such, it would require a new blank page where the headers could be send first including the cookie, or the whole painel should be refactored to accomodate this e-mail request.
            * in my opinion it would be easier to make a ajax request to an page or using a redirect page that would trigger the e-mail and then redirect back.
            *
            * ob_start AND ob_end_flush() at the core of the websites does the trick
            */
            // $info cliente = sql:$pageTable
            // $info financeiro = sql:$pageTable
            // $emailBody = '...'
            // $email = new Email ...
            // $email->addRecipient(info[email])
            // $email->formatMail(array)
        }
    }
    ?>
    <br><!-- Visualizar pagamentos pendentes -->
    <h2>
        <i class="fa-solid fa-pencil"></i>
        Pagamentos Pendentes
    </h2>
    <a href="./gerarPdf?pagamento=pendente" target="_blank" rel="noopener noreferrer" class="btn red">Gerar pdf</a>
    <table>
        <thead>
            <tr>
                <!-- <td>Cliente id</td> -->
                <td>Cliente</td>
                <td>Descrição</td>
                <td>Valor</td>
                <td>qt. Parcelas</td>
                <td>Vencimento</td>
                <!-- <td>status</td> -->

            </tr>
        </thead>
        <tbody>
            <!-- SQL Template here -->
            <?php
            $pag_pend = Sql::connect()->prepare(
                "SELECT  
                        `$pageTableFin`.id as id,
                        `$pageTableFin`.cliente_id as cliente_id,
                        `$pageTable`.nome as cliente_nome,
                        `$pageTableFin`.nome as nome,
                        `$pageTableFin`.valor,
                        `$pageTableFin`.parcelas,
                        `$pageTableFin`.vencimento as vencimento
                FROM `$pageTableFin` 
                LEFT JOIN `$pageTable`
                ON `$pageTableFin`.cliente_id = `$pageTable`.id 
                WHERE status = 0 ORDER BY vencimento ASC"
            );
            $pag_pend->execute();
            // $pag_pend->debugDumpParams();
            // echo "<br>";

            $pag_pend = $pag_pend->fetchAll(PDO::FETCH_ASSOC);
            if ($pag_pend) {
                foreach ($pag_pend as $key => $value) {
                    // print_r($value);
                    // echo "<br>";
                    echo (time() >= strtotime($value['vencimento'])) ? '<tr style="background:lightcoral;">' : '<tr>';
                    foreach ($value as $key2 => $value2) {
                        if ($key2 == 'id') continue;
                        if ($key2 == 'cliente_id') continue;
                        echo "<td>$value2</td>";
                    }
                    // Reminder mail

                    echo "<td><a class='btn' href='./clientesFinanceiro?email=$value[cliente_id]&parcela=$value[id]'>Remind</a></td>";
                    echo "<td><a class='btn' href='./clientesFinanceiro?pago=$value[id]'>Pago</a>";
                    echo "<td><a confirm href=''>confirm</a></td>";

                    // Paid button $value['id'];
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <br><!-- Visualizar pagamentos Concluidos -->
    <h2>
        <i class="fa-solid fa-pencil"></i>
        Pagamentos Concluidos
    </h2>
    <a href="./gerarPdf?pagamento=concluido" target="_blank" rel="noopener noreferrer" class="btn red">Gerar pdf</a>

    <br>
    <table>
        <thead>
            <tr>
                <!-- <td>Cliente id</td> -->
                <td>Cliente</td>
                <td>Descrição</td>
                <td>Valor</td>
                <td>qt. Parcelas</td>
                <td>Vencimento</td>
                <!-- <td>status</td> -->

            </tr>
        </thead>
        <tbody>
            <!-- SQL Template here -->
            <?php
            $pag_pend = Sql::connect()->prepare(
                "SELECT  
                        `$pageTableFin`.id as id,
                        `$pageTableFin`.cliente_id as cliente_id,
                        `$pageTable`.nome as cliente_nome,
                        `$pageTableFin`.nome as nome,
                        `$pageTableFin`.valor,
                        `$pageTableFin`.parcelas,
                        `$pageTableFin`.vencimento as vencimento
                FROM `$pageTableFin` 
                LEFT JOIN `$pageTable`
                ON `$pageTableFin`.cliente_id = `$pageTable`.id 
                WHERE status = 1 ORDER BY vencimento ASC"
            );
            $pag_pend->execute();
            // $pag_pend->debugDumpParams();
            $pag_pend = $pag_pend->fetchAll(PDO::FETCH_ASSOC);
            if ($pag_pend) {
                foreach ($pag_pend as $key => $value) {
                    // echo (time() >= strtotime($value['vencimento'])) ? '<tr style="background:lightcoral;">' : '<tr>';
                    echo "<tr>";
                    foreach ($value as $key2 => $value2) {
                        if ($key2 == 'id') continue;
                        if ($key2 == 'cliente_id') continue;
                        echo "<td>$value2</td>";
                    }
                    // Reminder mail
                    // if ($value['status']) {
                    //     echo "<td>Remind</td><td>Pago</td>";
                    // } else {
                    //     echo "<td><a class='btn' href='./clientes?edit=$value[cliente_id]&remind=$value[id]'>Remind</a></td>";
                    //     echo "<td><a class='btn' href='./clientes?edit=$_GET[edit]&pago=$value[id]'>Pago</a>";
                    //     echo "<td><a confirm href=''>confirm</a></td>";
                    // }
                    // Paid button $value['id'];
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</section>