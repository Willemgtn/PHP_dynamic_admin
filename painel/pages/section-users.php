<section class="center" id="panelUsers">
    <h2>
        <i class="fa-solid fa-users"></i>
            Panel Users
    </h2>
    
    <div class="header all-flex-table">
        <div>
            <h3>Usernames:</h3>
            <h3>Roles:</h3>
        </div>
        <?php 
            $sql = Sql::connect() -> prepare ('SELECT user, role FROM `tb_admin.users`');
            $sql -> execute();
            $sql = $sql -> fetchAll();
            foreach ($sql as $key => $value) {  

        ?>
        <div class="">
            <p><?php echo $value['user'] ?></p>
            <p><?php echo UsersMod::nameRole($value['role']) ?></p>
        </div>
        <?php
            }
        ?>
    </div>

</section>