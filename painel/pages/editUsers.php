<?php
UsersMod::verifyPermission(2);
$pageTable = 'tb_admin.users';
function pageUrl($next = null)
{
    $baseUrl = './?url=editUsers';
    return $next ? $baseUrl . $next : $baseUrl;
}
?>

<?php if (isset($_GET['add'])) { ?>

    <section class="">
        <?php
        if (isset($_POST["addUser"])) {
            if (strlen($_POST['user']) < 6 && UsersMod::userExists($_POST['user'])) {
                Painel::htmlPopUp('error', ' Username exists or Username too short');
            } else if (strlen($_POST['password']) < 8) {
                Painel::htmlPopUp('error', ' Password should have at least 8 characters');
            } else if (strlen($_POST['name']) < 6) {
                Painel::htmlPopUp('error', ' Name should have at least 6 characters');
            } else {
                if ($_FILES['avatar']['name'] != "") {
                    $imgName = FileUpload::uploadImage('avatar');
                    // echo "<hr>imgName: " . $imgName . 'isTrue?' . $imgName == true;
                    if ($imgName) {
                        UsersMod::addUser($_POST['user'], $_POST['name'], $_POST['password'], $imgName, $_POST['role']);
                    } else {
                        Painel::htmlPopUp('error', 'Invalid image format.');
                    }
                } else {
                    UsersMod::addUser($_POST['user'], $_POST['name'], $_POST['password'], '', $_POST['role']);
                }
            }
        } ?>

        <h2>
            <i class="fa-solid fa-pencil"></i>
            Add User

        </h2>
        <form action="" method="post" enctype="multipart/form-data">

            <div class="d-flex">
                <label for="name">Name:</label>
                <input type="text" name="name" id="" value="">
            </div>

            <div class="d-flex">
                <label for="user">User:</label>
                <input type="text" name="user" id="" value="">
            </div>

            <div class="d-flex">
                <label for="password">Password:</label>
                <input type="password" name="password" id="" value="">
            </div>
            <div class="d-flex">
                <select name="role" id="">
                    <?php
                    foreach (UsersMod::$nameRole as $key => $value) {
                        if ($key < $_SESSION['role']) echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="d-flex">
                <label for="avatar">Image: </label>
                <input type="file" name="avatar" id="">
            </div>

            <div class="d-flex">
                <input type="submit" name="addUser" value="Create User">

            </div>

        </form>
    </section>

<?php } ?>


<section class="center" id="panelUsers">
    <?php
    if (isset($_GET['delete'])) {
        if (DButils::deleteWhereId($pageTable, $_GET['delete'])) {
            Painel::htmlPopUp('ok', 'Deleted Successfully');
            Painel::redirect(pageUrl());
        } else {
            Painel::htmlPopUp('error', 'Something went wrong ');
        }
    }
    ?>
    <h2>
        <i class="fa-solid fa-users"></i>
        Panel Users
        <a style="float: right;" class="btn green" href="<?php echo pageUrl('&add'); ?>"><i class="fa-solid fa-plus"></i>Add New </a>

    </h2>

    <div class="header all-flex-table">
        <div>
            <h3>Usernames:</h3>
            <h3>Roles:</h3>
            <h4 class="min-flex">control</h4>

        </div>
        <?php
        $sql = Sql::connect()->prepare('SELECT id, user, role FROM `tb_admin.users`');
        $sql->execute();
        $sql = $sql->fetchAll();
        foreach ($sql as $key => $value) {

        ?>
            <div class="">
                <p><?php echo $value['user'] ?></p>
                <p><?php echo UsersMod::nameRole($value['role']) ?></p>
                <div class="min-flex f-space mob-btn">
                    <a class="edit-btn" href="<?php echo pageUrl('&edit=' . $value['id']) ?>"><i class="fa-solid fa-pencil"></i>Edit</a>
                    <a class="delete-btn" actionBtn="delete" href="<?php echo pageUrl('&delete=' . $value['id']) ?>"><i class="fa-solid fa-xmark"></i>Delete</a>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

</section>

<?php
if (isset($_GET['edit'])) {

    $sql = Sql::connect()->prepare("SELECT * FROM `$pageTable` WHERE id = ?");
    $sql->execute(array($_GET['edit']));
    $sql = $sql->fetch();
    // print_r($sql);
    // foreach ($sql as $key => $value) {  
    // SQL::connect() -> execute("SELECT id FROM `$pageTable` ORDER BY id DESC LIMIT 1") -> fetch()['id']
?>
    <section>
        <?php
        if (isset($_POST['submit'])) {
            if (strlen($_POST['user']) < 6 && UsersMod::userExists($_POST['user'])) {
                Painel::htmlPopUp('error', ' Username exists or Username too short');
            } else if (strlen($_POST['password']) < 8) {
                Painel::htmlPopUp('error', ' Password should have at least 8 characters');
            } else if (strlen($_POST['name']) < 6) {
                Painel::htmlPopUp('error', ' Name should have at least 6 characters');
            } else {
                $imgName;
                if ($_FILES['avatar']['name'] != "") {
                    $imgName = FileUpload::uploadImage('avatar');
                    // echo "<hr>imgName: " . $imgName . 'isTrue?' . $imgName == true;
                    if (!$imgName) {
                        Painel::htmlPopUp('error', 'Invalid image format.');
                        return false;
                        UsersMod::addUser($_POST['user'], $_POST['name'], $_POST['password'], $imgName, $_POST['role']);
                    }
                }
                UsersMod::updateUsers([
                    'user' => $_POST['user'],
                    'password' => $_POST['password'],
                    'name' => $_POST['name'],
                    'avatar' => isset($imgName) ? $imgName : false,
                    'role' => $_POST['role'],
                    'id' => $_POST['id'],
                ]);
            }
        }
        ?>
        <h2>
            <i class="fa-solid fa-pencil"></i>
            Edit User
        </h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="d-flex">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="" value="<?php echo $sql['name'] ?>">
            </div>

            <div class="d-flex">
                <label for="user">User:</label>
                <input type="text" name="user" id="" value="<?php echo $sql['user'] ?>">
            </div>

            <div class="d-flex">
                <label for="password">Password:</label>
                <input type="password" name="password" id="" value="<?php echo $sql['password'] ?>">
            </div>

            <div class="d-flex">
                <label for="role">Select the role: </label>
                <select name="role" id="">
                    <?php
                    foreach (UsersMod::$nameRole as $key => $value) {
                        if ($key < $_SESSION['role']) echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="d-flex">
                <label for="avatar">Image: </label>
                <input type="file" name="avatar" id="">
            </div>


            <input type="hidden" name="id" value="<?php echo $sql['id'] ?>">

            <div class="d-flex">
                <input type="submit" name="submit" value="Update User">
            </div>

        </form>
    </section>
<?php }
// }

?>
</section>