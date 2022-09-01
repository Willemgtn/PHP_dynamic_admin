<section id="viewMetrics" class="center f-column">
    <h2>
    <i class="fa-solid fa-rocket"></i>
        View Metrics Longs
    </h2>
    
    <div class="header all-flex-table">
        <div>
            <h3>IP Address:</h3>
            <h3>Last Visited:</h3>
        </div>
        <?php 
            $usersOnline = Painel::listOnlineUsers();
            foreach($usersOnline as $key => $value){

        ?>
        <div class="ipaddresses">
            <p class="ip"><?php echo $value['ip'] ?></p>
            <p><?php echo $value['ultima_acao'] ?></p>
        </div>
        <?php
            }
        ?>
    </div>

</section>

        