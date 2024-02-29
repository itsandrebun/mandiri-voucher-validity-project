

<nav id="sidebar">
    <div class="sidebar-header">
        <img style="width:10rem;display:block;margin:auto" src="<?php echo base_url() . 'assets/img/BMRI.JK.D-57128c9b.png';?>" alt="">
        <h3 class="text-center mt-2">Mandiri Voucher Validity</h3>
    </div>

    <ul class="list-unstyled components">
        <?php for($b = 0; $b < count($sidebars); $b++){?>
            <li <?php echo $sidebar_id == $sidebars[$b]['id'] ? 'class="active"' : ''?>>
                <a href="<?php echo $sidebars[$b]['url'];?>"><?php echo $sidebars[$b]['name']?></a>
            </li>
        <?php }?>
    </ul>
</nav>