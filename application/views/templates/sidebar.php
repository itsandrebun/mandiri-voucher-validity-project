<ul class="list-unstyled components">
    <?php for($b = 0; $b < count($sidebars); $b++){?>
        <li <?php echo $sidebar_id == $sidebars[$b]['id'] ? 'class="active"' : ''?>>
            <a href="<?php echo $sidebars[$b]['url'];?>"><?php echo $sidebars[$b]['name']?></a>
        </li>
    <?php }?>
</ul>