<section class="slides">
        <h2>Slides</h2>

    <div class="center">
    <?php 
        foreach (DButils::flexSelectAll('tb_site.slide', 'order_id DESC ') as $key => $value) {
    ?>
        <div class="card">
            <ul class="card-ul">
                <li><i class="fa-solid fa-location-dot"></i></li>
                <li><i class="fa-solid fa-caret-down"></i></li>
            </ul>
            <img src="./painel/uploads/<?php echo $value['path'] ?>" alt="<?php echo $value['name'] ?>">
            <div class="con-text">
                <h2><?php echo $value['name']?></h2>
                <p><?php echo $value['description']?></p>
                <button>See more.</button>
            </div>
        </div>
        <?php } ?>
        <!-- <div class="card">
            <ul class="card-ul">
                <li><i class="fa-solid fa-location-dot"></i></li>
                <li><i class="fa-solid fa-caret-down"></i></li>
            </ul>
            <img src="./painel/uploads/62ee1b1ce3190.jpg" alt="<?php ?>">
            <div class="con-text">
                <h2><?php ?>Paris</h2>
                <p><?php ?>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam doloremque dolor et consectetur quam deserunt! Neque incidunt quis, ab accusantium id aut saepe nulla deserunt dicta doloremque libero pariatur ex.</p>
                <button>See more.</button>
            </div>
        </div>
        <div class="card">
            <ul class="card-ul">
                <li><i class="fa-solid fa-location-dot"></i></li>
                <li><i class="fa-solid fa-caret-down"></i></li>
            </ul>
            <img src="./painel/uploads/62ee1b1ce3190.jpg" alt="<?php ?>">
            <div class="con-text">
                <h2><?php ?>Paris</h2>
                <p><?php ?>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam doloremque dolor et consectetur quam deserunt! Neque incidunt quis, ab accusantium id aut saepe nulla deserunt dicta doloremque libero pariatur ex.</p>
                <button>See more.</button>
            </div>
        </div> -->

    </div>
</section>

<style>
    section.slides .center {
        display: flex;
        /* align-items: center; */
        /* justify-content: space-evenly; */
        flex-wrap: nowrap;
        overflow-x: auto;
    }
    section.slides .card {
        width: 300px;
        height: 400px;
        background: #000;
        border-radius: 30px;
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .25s ease;
        backface-visibility: hidden;

        margin: 0 10px;
        flex-shrink: 0;
    }
    section.slides .card:hover{
        transform: scale (.9);
    }
    section.slides .card:hover:after{
        height: 288px;
    }
    section.slides .card:hover .con-text p {
        margin-bottom: 0px;
        opacity: 1;
    }
    section.slides .card:hover img {
        transform: scale(1.25);
    }
    section.slides .card:hover .card-ul{
        transform: translate(0);
        opacity: 1;
    }
    section.slides .card:after {
        width: 100%;
        content: '';
        left: 0px;
        bottom: 0px;
        height: 150px;
        position: absolute;
        background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 100%);
        z-index: 20;
        transition: all .25s ease;
    }
    section.slides .card img {
        height: 100%;
        z-index: 10;
        transition: all .25s ease;
    }
    section.slides .card .con-text {
        z-index: 30;
        position: absolute;
        bottom: 0px;
        color: #fff;
        padding: 20px;
        padding-bottom: 30px;
    }
    section.slides .card .con-text p {
        font-size: 0.8rem;
        opacity: 0;
        margin-bottom: -170px;
        transition: all .25s ease;
        
        flex-direction : column;
    }
    section.slides .card .con-text button{
        padding: 7px 17px;
        border-radius: 12px;
        background: transparent;
        border: 2px solid #fff;
        color: #fff;
        margin-top: 10px;
        margin-left: auto;
        cursor: pointer;
        transition: all .25s ease;
        font-size: .75rem;
        outline: none;
        opacity: 0;
    }
    section.slides .card .con-text button:hover {
        background: #fff;
        color: #000;
        opacity: 1;
    }
    section.slides .card .card-ul{
        position: absolute;
        right: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        z-index: 40;
        border-radius: 14px;
        padding-left: 0;
        padding-top: 8px;
        padding-bottom: 8px;
        top: 0px;
        opacity: 0;
        transform: translate(100%);
        transition: all .25s ease;
    }
    section.slides .card .card-ul li {
        background: #fff;
        list-style: none;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity:.7;
        transition: all .25s ease;
        backface-visibility: hidden;
        
    }
    section.slides .card .card-ul li:last-child {
        border-radius: 0px 0px 12px 12px;
    }
    section.slides .card .card-ul li:first-child {
        border-radius: 12px 12px 0px 0px;
    }
    section.slides .card .card-ul li:hover {
        opacity: 1;
        transform: translate(-7px, -4px);
        border-radius: 6px;
    }
    section.slides .card .card-ul li i {
        font-size: 1.4rem;
        color: #000;
    }
</style>