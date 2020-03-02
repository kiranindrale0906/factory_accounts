<?php //if(in_array(str_replace(BASE_URL, '', $url), $this->session->userdata("permissions"))): ?>

  <li class="<?= @$class ?>">
    <a class="nav-link <?= $active ?>"
       href="<?= $url ?>">
       <?php if(!empty($menu_icon) && $menu_icon!=''){?>   
        <span class="icon"><i class="<?= $menu_icon ?> "></i></span>
       <?php }?>

      <span class="menuname"><?= $title ?></span>
    </a>
  </li>
<?php //endif; ?>