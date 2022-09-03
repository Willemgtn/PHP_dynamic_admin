<?php
UsersMod::verifyPermission(2);

$pageTable = 'tb_site.slide';
function pageUrl($next = null)
{
    $baseUrl = './editSlide';
    return $next ? $baseUrl . $next : $baseUrl;
}
?>
<?php if (isset($_GET['add'])) { ?>
    <section class="">

        <?php
        UsersMod::verifyPermission(2);

        if (isset($_POST['submit'])) {
            if ($_FILES['path']['name'] != "") {
                $imgName = FileUpload::uploadImage('path');
                $uploadedFileName = $_FILES['path']['name'];
                // echo "<hr>imgName: " . $imgName . 'isTrue?' . $imgName == true;

                // TODO : Fields verification should be done before img upload.

                if ($imgName) {
                    if (DButils::flexInsert($pageTable, [
                        "name" => $_POST['name'],
                        "path" => $imgName,
                        "description" => $_POST['description'],
                        "order_id" => $_POST['order_id']
                    ])) {
                        Painel::htmlPopUp("ok", "$uploadedFileName Has been uploaded.");
                    } else {
                        Painel::htmlPopUp("error", 'One or more fields were empty.');
                    }
                } else {
                    Painel::htmlPopUp('error', 'Invalid image format.');
                }
            }

            // if(DButils::flexInsert($pageTable,$_POST)){
            //     Painel::htmlPopUp("ok", "Added.");
            // } else {
            //     Painel::htmlPopUp("error", 'One or more fields were empty.');
            // }
        }
        ?>


        <h2>
            <i class="fa-solid fa-images"></i>
            Add Photo to the Slide
        </h2>
        <form action="" method="post" enctype="multipart/form-data">

            <div class="d-flex">
                <label for="name">Name:</label>
                <input type="text" name="name" id="" value="">
            </div>

            <div class="d-flex">
                <label for="description">Description:</label>
                <textarea name="description" id=""></textarea>
            </div>

            <?php
            $orderIdNum =  DButils::select($pageTable, [], 'ORDER BY order_id DESC LIMIT 1')['order_id'];
            // echo $orderIdNum;
            $orderIdNum = $orderIdNum ? $orderIdNum + 1 : 1;
            // echo $orderIdNum;
            ?>


            <div class="d-flex file">
                <input type="hidden" name="order_id" value="<?php echo $orderIdNum ?>">
                <label for="path">
                    Image:
                    <input type="file" name="path" id="">

                </label>
            </div>

            <div class="d-flex">
                <input type="submit" name="submit" value="Add Image">
            </div>
        </form>

        <?php
        if (isset($_POST["submit"])) {
        }
        echo "<hr>";
        // print_r( $_GET);
        // include('./pages/section-users.php');
        ?>
    </section>


<?php } ?>

<section>
    <?php

    if (isset($_GET['delete'])) {
        $imgPath = DButils::select($pageTable, array((int)$_GET['delete']), 'WHERE id = ?');
        if (DButils::deleteWhereId($pageTable, $_GET['delete'])) {
            Painel::htmlPopUp('ok', 'Deleted Successfully');
            FileUpload::deleteFIle($imgPath['path']);
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
        Registered img for the slides
        <a style="float: right;" class="btn green" href="<?php echo pageUrl('?add'); ?>"><i class="fa-solid fa-plus"></i>Add New </a>

    </h3>
    <div class="header all-flex-table">
        <div>
            <h3>Photo name:</h3>
            <h4 class="min-flex">control</h4>
            <h4 class="min-flex">order</h4>
        </div>
        <?php
        $curPage = isset($_GET['pages']) ? (int) $_GET['pages'] : 1;
        $maxItems = 3;
        $sql = DButils::flexSelectAll($pageTable, 'order_id DESC LIMIT ' . ($curPage - 1) * $maxItems . ', ' .  $maxItems);
        foreach ($sql as $key => $value) {

        ?>
            <div class="listSlide">

                <p>
                    <img src="./uploads/<?php echo $value['path'] ?>" alt="<?php echo $value['name'] ?>">
                    <?php echo $value['name'] ?>
                </p>
                <div class="min-flex f-space mob-btn">
                    <a class="edit-btn" href="<?php echo pageUrl('?edit=' . $value['id']) ?>"><i class="fa-solid fa-pencil"></i>Edit</a>
                    <a class="delete-btn" actionBtn="delete" href="<?php echo pageUrl('?delete=' . $value['id']) ?>"><i class="fa-solid fa-xmark"></i>Delete</a>
                </div>
                <div class="min-flex f-space  mob-btn">
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
            for ($i = 1; $i < $totalPaginas + 1; $i++) {
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
        // Should the picture be updated? or just the metadata?
        if ($_FILES['path']['name'] != "") {
            $imgName = FileUpload::uploadImage('path');

            $oldImgPath = DButils::select($pageTable, array($_POST['id']), 'WHERE id = ?');

            if ($imgName) {
                // Update succesfull.
                if (DButils::flexUpdate($pageTable, array(
                    "name" => $_POST['name'],
                    'description' => $_POST['description'],
                    'path' => $imgName,
                    'id' => $_POST['id']
                ))) {
                    FileUpload::deleteFIle($oldImgPath['path']);
                    // delete the old image.
                    Painel::htmlPopUp('ok', 'Updated Successfully');
                }
            } else {
                // wrong format
                Painel::htmlPopUp('error', 'Wrong Image format or too big.');
            }
        } else {
            if (DButils::flexUpdate($pageTable, array(
                "name" => $_POST['name'],
                'description' => $_POST['description'],
                'id' => $_POST['id']
            ))) {
                // Metadata updates
                Painel::htmlPopUp('ok', 'Updated Successfully');
                Painel::redirect(pageUrl());
            } else {
                // metadata not updated
                Painel::htmlPopUp('error', 'Something went wrong ');
            }
        }
    }
    $sql = Sql::connect()->prepare("SELECT * FROM `$pageTable` WHERE id = ?");
    $sql->execute(array($_GET['edit']));
    $sql = $sql->fetch();
    // print_r($sql);
    // foreach ($sql as $key => $value) {  
    // SQL::connect() -> execute("SELECT id FROM `$pageTable` ORDER BY id DESC LIMIT 1") -> fetch()['id']
?>
    <section>
        <h2>
            <i class="fa-solid fa-images"></i>
            Edit Photo
        </h2>
        <form action="" method="post" enctype="multipart/form-data">


            <div class="d-flex">
                <label for="name">Name:</label>
                <input type="text" name="name" id="" value="<?php echo $sql['name'] ?>">
            </div>

            <div class="d-flex">
                <label for="description">Description:</label>
                <textarea name="description" id=""><?php echo $sql['description'] ?></textarea>
            </div>

            <div class="d-flex file">
                <input type="hidden" name="order_id" value="<?php echo $sql['order_id'] ?>">
                <label for="path">
                    Image:
                    <input type="file" name="path" id="">

                </label>
            </div>
            <input type="hidden" name="id" value="<?php echo $sql['id'] ?>">

            <div class="d-flex">
                <input type="submit" name="submit" value="Edit Slide">
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