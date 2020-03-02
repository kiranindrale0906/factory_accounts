<aside class="sidenavbar sidenavbar_js expand">
  <div class="sidenav_scroll_js sidenav_scroll">
    <ul>
      <?php 
      if(!empty($_SESSION['controller_list'])) {
        // pd($main_menu,0);
        // pd($_SESSION['controller_list']);
        foreach ($main_menu as $main_menu_title => $sub_menus) {
          if(!empty($sub_menus ) && is_array($sub_menus)){ 
            if (!empty(array_intersect(array_keys($sub_menus), $_SESSION['controller_list']))){ ?> 
            <li class="submenu submenu_js">
              <a href="javascript:void(0);" class="dropicon fa-chevron-right">
                <span class="icon text-center">
                  <i class="<?php echo @$menu_icons[$main_menu_title];?>"></i>
                </span>
                <span ><?=$main_menu_title;?></span>
              </a>
              <ul>
               <?php 
                foreach ($sub_menus as $sub_menu_url => $sub_menu_title) { 
                  $active =($this->router->module.'/'.$this->router->class==$sub_menu_url) ? 'active':''; 
                  $this->load->view('navigation/application/sidebar_item', 
                                  array('url' => BASE_URL.$sub_menu_url,
                                        'active' => $active,
                                        'title' => $sub_menu_title,
                                  )); 
                } ?>
              </ul>
            </li>
          <?php } }
          else {  
            if(!empty(in_array($main_menu[$main_menu_title], $_SESSION['controller_list']))){ ?>
              <li class="">
                <a href=<?= BASE_URL.$main_menu[$main_menu_title]?>>
                  <span class="icon text-center">
                    <i class="<?php echo $menu_icons[$main_menu_title];?>"></i>
                  </span>
                  <span ><?=$main_menu_title;?></span>
                </a>
              </li>
            <?php } 
          }
        }
      } ?>
    </ul>
  </div>
</aside>
