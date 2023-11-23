<?php
$pageTable = 'tb_site.service';
function pageUrl($next = null)
{
    $baseUrl = './editService';
    return $next ? $baseUrl . $next : $baseUrl;
}
?>
<?php if (isset($_GET['add'])) { ?>
    <section class="new-form">
        <?php
        if (isset($_POST['submit'])) {
            if (DButils::flexInsert($pageTable, $_POST)) {
                Painel::htmlPopUp("ok", "Added.");
            } else {
                Painel::htmlPopUp("error", 'One or more fields were empty.');
            }
        }
        ?>
        <h2>
            <i class="fa-solid fa-plus"></i>
            Add Service Description.
        </h2>
        <form action="" method="post" enctype="multipart/form-data">

            <div class="d-flex">
                <label for="conteudo">Service Description:</label>
                <textarea class="tiny" type="text" name="conteudo" value=""></textarea>
            </div>


            <?php
            $orderIdNum =  DButils::select($pageTable, [], 'ORDER BY order_id DESC LIMIT 1')['order_id'];
            // echo $orderIdNum;
            $orderIdNum = $orderIdNum ? $orderIdNum + 1 : 1;
            // echo $orderIdNum;
            ?>

            <input type="hidden" name="order_id" value="<?php echo $orderIdNum ?>">

            <div class="d-flex">
                <input type="submit" name="submit" value="ADD service">
            </div>


        </form>
    </section>
<?php } ?>


<section class="new-form">
    <?php
    if (isset($_GET['delete'])) {
        if (DButils::deleteWhereId($pageTable, $_GET['delete'])) {
            Painel::htmlPopUp('ok', 'Deleted Successfully');
            Painel::redirect(pageUrl());
        } else {
            Painel::htmlPopUp('error', 'Something went wrong ');
        }
    } else if (isset($_GET['order'])) {
        // echo"order found; ";
        if (isset($_GET['id'])) {
            // echo "id found; ";
            if ($_GET['order'] == 'down') {
                // echo"down we go; <br> ";
                DButils::orderItem($pageTable, 'down', (int)$_GET['id']);
            } else if ($_GET['order'] == 'up') {
                // echo"up we go; <br> ";
                DButils::orderItem($pageTable, 'up', (int)$_GET['id']);
            }
        }
    }
    ?>
    <h3>
        <i class="fa-solid fa-address-card"></i>
        Registered Services
        <a style="float: right;" class="btn green" href="<?php echo pageUrl('?add'); ?>"><i class="fa-solid fa-plus"></i>Add New </a>
    </h3>
    <div class="header all-flex-table">
        <div>
            <h3>Service Description:</h3>
            <h4 class="min-flex">control</h4>
            <h4 class="min-flex">order</h4>
        </div>
        <?php
        $curPage = isset($_GET['pages']) ? (int) $_GET['pages'] : 1;
        $maxItems = 3;
        $sql = DButils::flexSelectAll($pageTable, 'order_id DESC LIMIT ' . ($curPage - 1) * $maxItems . ', ' .  $maxItems);
        foreach ($sql as $key => $value) {

        ?>
            <div class="">

                <div><?php echo $value['service'] ?></div>
                <div class="f-space mob-btn">
                    <a class="edit-btn" href="<?php echo pageUrl('?edit=' . $value['id']) ?>"><i class="fa-solid fa-pencil"></i>Edit</a>
                    <a class="delete-btn" actionBtn="delete" href="<?php echo pageUrl('?delete=' . $value['id']) ?>"><i class="fa-solid fa-xmark"></i>Delete</a>
                </div>
                <div class="f-space  mob-btn">
                    <a href="<?php echo pageUrl('?order=down&id=' . $value['id']) ?>"><i class="fa-solid fa-angle-down"></i></a>
                    <a href="<?php echo pageUrl('?order=up&id=' . $value['id']) ?>"><i class="fa-solid fa-angle-up"></i></a>
                </div>

            </div>
        <?php
        }
        ?>
        <div class="pagination f-space mob-btn">
            <?php
            $totalPaginas = ceil(count(DButils::flexSelectAll($pageTable,  'order_id'))) / $maxItems;
            // echo $totalPaginas;
            for ($i = 1; $i <= $totalPaginas + 1; $i++) {
                if ($i == $curPage) {
            ?>
                    <a class="active" href="<?php echo pageUrl('?pages=' . $i) ?> ">
                        <?php echo $i ?></a>
                <?php } else { ?>
                    <a href="<?php echo pageUrl('?pages=' . $i) ?> ">
                        <?php echo $i ?></a>
            <?php }
            }
            ?>
        </div>
    </div>
</section>

<?php
if (isset($_GET['edit'])) {
    if (isset($_POST['submit'])) {
        // $sql = Sql::connect() -> prepare("UPDATE `$pageTable` SET autor = ?, conteudo = ? WHERE id = ?");
        // if($sql -> execute(array($_POST['autor'], $_POST['depo'], $_POST['id']))){
        //     Painel::htmlPopUp('success', 'Updated Successfully');
        // } else {
        //     Painel::htmlPopUp('error', 'Something went wrong ');
        // }
        if (DButils::flexUpdate($pageTable, $_POST)) {
            Painel::htmlPopUp('ok', 'Updated Successfully');
            Painel::redirect(pageUrl());
        } else {
            Painel::htmlPopUp('error', 'Something went wrong ');
        }
    }
    $sql = Sql::connect()->prepare("SELECT * FROM `$pageTable` WHERE id = ?");
    $sql->execute(array($_GET['edit']));
    $sql = $sql->fetch();
    // print_r($sql);
    // foreach ($sql as $key => $value) {  
    // SQL::connect() -> execute("SELECT id FROM `$pageTable` ORDER BY id DESC LIMIT 1") -> fetch()['id']
?>
    <section class="new-form">
        <h2>
            <i class="fa-solid fa-pencil"></i>
            Edit Testimony
        </h2>
        <form action=<?php echo pageUrl('?edit=' . $value['id']) ?>" method="post" enctype="multipart/form-data">


            <div class="d-flex">
                <label for="service">Service Description:</label>
                <textarea class="tiny" type="text" name="service"><?php echo $sql['service'] ?></textarea>
            </div>



            <!-- <div class="d-flex"> -->
            <!-- <label for="order">Order_id:</label>
                            <input type="number" name="order_id" id="" value="<?php //echo $sql['order_id']
                                                                                ?>">
                        </div> -->
            <input type="hidden" name="order_id" value="<?php echo $sql['order_id']; ?>">
            <input type="hidden" name="id" value="<?php echo $sql['id'] ?>">

            <div class="d-flex">
                <input type="submit" name="submit" value="EDIT Testimony">
            </div>

        </form>
        <footer id="slideTo"></footer>
        <script>
            // window.scrollTo(0, document.body.scrollHeight);

            $('html, main').animate({
                scrollTop: $('section section footer#slideTo').offset().top
            }, 2000)
        </script>
    </section>
<?php }
// }

?>
</section>