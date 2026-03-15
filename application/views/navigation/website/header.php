<header class="d-flex justify-content-between align-items-center fixed-top main_header_js main_header">
  <div class="container">     
    <span class="slide_menu_icon slide_menu_left_js d-lg-none d-sm-inline-block"><i class="fal fa-bars cyan"></i></span> 

    <div class="headerlogo navbar-brand">
      <a href="<?= BASE_URL ?>index.php">
        <img src="<?= CORE_PATH() ?>images/common/logo.png">
      </a>   
    </div>  
    <div class="header_menu d-flex flex-wrap align-items-lg-center justify-content-lg-end align-content-start float-right header_main_menu_js">
      <ul class="main_menus">
    <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){ ?>
        <li class="user_profile d-lg-none d-sm-inline-block">          
          <a href="home" class="users_name">  
            <span><i class="fas fa-user img_profile"></i></span>
            <span class="user_name white white pt-3 font15"><?php if(isset($_SESSION['name'])){echo 'Hi '.$_SESSION['name'];}?></span>
          </a> 
        </li>
    <?php  } else { ?>
        <li class="user_profile d-lg-none d-sm-inline-block">          
          <a href="home" class="users_name">  
            <span><i class="fas fa-user img_profile"></i></span>
            <span class="user_name white pt-3 font15">Login | Register</span>
          </a> 
        </li>

        <?php }
          $this->load->view('navigation/website/sidebar_item', 
            array('url' => BASE_URL.'home',
            'active' => ("dfds"=='professionals') ? 'active' : '',
            'title' => 'Our Services',
            'menu_icon'=>'fas fa-home'
          )); 
        ?>     
        <?php
          $this->load->view('navigation/website/sidebar_item', 
            array('url' => BASE_URL.'professionals/storefronts/view',
            'active' => ("dfds"=='professionals') ? 'active' : '',
            'title' => 'How It Works',
            'menu_icon'=>'fab fa-black-tie'
        ));
          $this->load->view('navigation/website/sidebar_item', 
            array('url' => BASE_URL.'customers/storefronts/view',
            'active' => ("dfds"=='professionals') ? 'active' : '',
            'title' => 'DNA Report',
            'menu_icon'=>'fas fa-users'
          )); 
          $this->load->view('navigation/website/sidebar_item', 
            array('url' => BASE_URL.'dashboard/Professionals',
            'active' => ("dfds"=='professionals') ? 'active' : '',
            'title' => 'Collaborate With Us',
            'menu_icon'=>'fas fa-newspaper'
          )); 
          $this->load->view('navigation/website/sidebar_item', 
            array('url' => BASE_URL.'dashboard/Professionals',
            'active' => ("dfds"=='professionals') ? 'active' : '',
            'title' => 'Contact Us',
            'menu_icon'=>'fas fa-newspaper'
          ));
          $this->load->view('navigation/website/sidebar_item', 
            array('url' => BASE_URL.'dashboard/Professionals',
            'active' => ("dfds"=='professionals') ? 'active' : '',
            'title' => 'Blog',
            'menu_icon'=>'fas fa-newspaper'
          )); 

          if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
            $this->load->view('navigation/website/sidebar_item', 
              array('url' => BASE_URL.'admin',
              'active' => ("dfds"=='professionals') ? 'active' : '',
              'title' => (!empty($_SESSION['name'])?'<black>Hi</black> '.$_SESSION['name']:''),
              'class'=>'d-none d-lg-inline-block'            
            )); 

          } else {
            $this->load->view('navigation/website/sidebar_item', 
              array('url' => BASE_URL.'users/logout',
              'active' => ("dfds"=='professionals') ? 'active' : '',
              'title' => 'Login',
              'class'=>'login_btn d-none d-lg-inline-block'
            ));

          }

        ?>
      </ul>
    </div>
  </div>
</header>

