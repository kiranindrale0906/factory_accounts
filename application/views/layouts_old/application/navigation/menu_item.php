<?php //if(in_array(str_replace(ADMIN_PATH, '', $url), $this->session->userdata("permissions"))): ?>

  <li class="nav-item">
    <a class="nav-link <?= $active ?>"
       href="<?= $url ?>">
       <?php if(!empty($menu_icon)){?>   
		    <span class="icon"><i class="<?= $menu_icon ?>"></i></span>
		   <?php }?>

     	<?= $title ?>
    </a>
  </li>
<?php //endif; ?>