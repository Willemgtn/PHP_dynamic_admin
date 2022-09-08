<?php
$pageTable = 'tb_admin.clientes';
$pageTableFin = 'tb_admin.clientes-financeiro';

if (isset($_GET['pagamento'])) {
    if ($_GET['pagamento'] == 'concluido') {
        $pagamento = 1;
    } else if ($_GET['pagamento'] == 'pendente') {
        $pagamento = 0;
    } else {
        die('Invalid option');
    }
}
?>
<!-- Create and overlay container that will fill the screen
    and host all of the table content -->


<section class="printer">
    <h2>
        <!-- <i class="fa-solid fa-pencil"></i> -->
        Pagamentos <?php echo $_GET['pagamento'] ?>
    </h2>
    <table>
        <thead>
            <tr>
                <td>Cliente </td>
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
                        `$pageTableFin`.vencimento as vencimento,
                        `$pageTableFin`.status
                FROM `$pageTableFin` 
                LEFT JOIN `$pageTable`
                ON `$pageTableFin`.cliente_id = `$pageTable`.id 
                WHERE status = $pagamento ORDER BY vencimento ASC"
            );
            $pag_pend->execute();
            // $pag_pend->debugDumpParams();
            // echo "<br>";

            $pag_pend = $pag_pend->fetchAll(PDO::FETCH_ASSOC);
            if ($pag_pend) {
                foreach ($pag_pend as $key => $value) {
                    // print_r($value);
                    // echo "<br>";
                    echo (!$value['status'] && (time() >= strtotime($value['vencimento']))) ? '<tr style="background:lightcoral;">' : '<tr>';
                    foreach ($value as $key2 => $value2) {
                        if ($key2 == 'id') continue;
                        if ($key2 == 'cliente_id') continue;
                        if ($key2 == 'status') continue;
                        if ($key2 == 'vencimento') {
                            echo "<td>" . date_format(date_create($value2), 'd/m/Y') . "</td>";
                            continue;
                        }

                        echo "<td>$value2</td>";
                    }
                    // Reminder mail

                    // echo "<td><a class='btn' href='./clientesFinanceiro?remind=$value[id]'>Remind</a></td>";
                    // echo "<td><a class='btn' href='./clientesFinanceiro?pago=$value[id]'>Pago</a>";
                    // echo "<td><a confirm href=''>confirm</a></td>";

                    // Paid button $value['id'];
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</section>

<style>
    section.printer {
        position: absolute;
        top: -10px;
        left: -10px;
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
        /* justify-content: center; */
        align-items: center;
        overflow-y: auto;
        overflow-x: hidden;
    }

    section.printer h2 {
        text-align: center;
        margin: 20px;
    }

    section.printer table thead tr td {
        font-weight: bold;
        font-size: 1em;
    }

    section.printer table {
        width: 1280px;
    }

    @media screen and (max-width: 1280px) {
        section.printer table {
            width: unset;
        }
    }
</style>