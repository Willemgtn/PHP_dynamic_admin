<?php
UsersMod::verifyPermission(2);

$pageTable = 'tb_site.home';
function pageUrl($next = null)
{
    $baseUrl = './editHomePage';
    return $next ? $baseUrl . $next : $baseUrl;
}

// print_r($sql);
if (isset($_POST['submit'])) {
    // page text content
    if ($_POST['submit'] == 'update') {
        DButils::flexUpdate($pageTable, $_POST);
    }
    // Page image upload
    // single or double image upload
}
$sql = DButils2::selectWhere('*', $pageTable, 'id = 1');
$sql = $sql[0];
?>

<section class="" id="editPage">
    <h2>Edit Page Details.</h2>
    <form action="" method="post">
        <div class="d-flex">
            <label for="pagetitle">Page title:</label>
            <input type="text" name="pagetitle" id="" value="<?php echo $sql['pagetitle'] ?>">
        </div>
        <div class="d-flex">
            <label for="pagedescription">Page Description:</label>
            <textarea class="tiny" name="pagedescription" id="" rows="5"><?php echo $sql['pagedescription'] ?></textarea>
        </div>
        <div class="d-flex">
            <label for="logotitle">Logo's title:</label>
            <input type="text" name="logotitle" id="" value="<?php echo $sql['logotitle'] ?>">
        </div>
        <div class="d-flex">
            <label for="mailtitle">Mail's Title:</label>
            <input type="text" name="mailtitle" id="" value="<?php echo $sql['mailtitle'] ?>">
        </div>
        <div class="d-flex">
            <label for="authorname">Author's Name:</label>
            <input type="text" name="authorname" id="" value="<?php echo $sql['authorname'] ?>">
        </div>
        <div class="d-flex">
            <label for="authordescription">Author's Description</label>
            <textarea class="tiny" name="authordescription" id="" cols="" rows="5"><?php echo $sql['authordescription'] ?></textarea>
        </div>
        <input type="hidden" name="id" value="<?php echo $sql['id'] ?>">
        <div class="d-flex">
            <input type="submit" name="submit" value="update">
        </div>
    </form> <br>
</section>
<section>
    <h2>Todo</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="d-flex file">
            <label for="mailimgpath">
                Mail Banner Img:
                <input type="file" name="mailimgpath" id="">
            </label>
        </div>
        <div class="d-flex file">
            <label for="authorimgpath">
                Author Profile Img:
                <input type="file" name="authorimgpath" id="">
            </label>
        </div>
        <div class="d-flex">
            <input type="submit" value="upload image">
        </div>
    </form>



</section>

<section id="editEspecialidades">
    <h2>List current "Especialidades"</h2>

    <form action="" method="post">
        <div class="d-flex">
            <label for="icon">Icon:</label>
            <input type="text" name="icon" id="" placeholder="">
        </div>

        <div class="d-flex">
            <label for="title">Title:</label>
            <input type="text" name="title" id="" placeholder="">
        </div>

        <div class="d-flex">
            <label for="description">Description:</label>
            <textarea class="tiny" name="description" id="" rows="5">

            </textarea>
        </div>
        <div class="d-flex">
            <input type="submit" name="" value="update">
        </div>
    </form>
</section>