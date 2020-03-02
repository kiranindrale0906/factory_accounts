<header class="d-flex justify-content-between align-items-center fixed-top">
  <div>
    <a href="<?=ADMIN_PATH."users"?>">
      <img src="<?= ADMIN_IMAGES_PATH ?>common/logo.png" height="40px" alt="user" class="dark-logo">
    </a> 
    <button class="btn btn-lg btn_icon btn_slide_sidemenu btn_slide_sidemenu_js">
      <i class="fal fa-align-justify white"></i>
    </button>    
  </div>  
  <div class="d-flex align-items-center justify-content-end float-right">   
    <ul class="nav">      
      <li class="nav-item usermenu">
        <div class="dropdown">
          <a href="#" class="nav-link btn btn-lg cyan" data-toggle="dropdown">
           <i class="fas fa-user"></i>
          </a>
          <div class="dropdown-menu animated flipInY">            
            <ul class="list-unstyled menu-list">
              <li><a href="#" class="btn link-black"><i class="fas fa-user font30 gray align-middle"></i></i> <span class="d-inline-block text-left pl-2 align-middle">Admin User <br>admin@gmail.com</span></a></li>                     
              <div class="dropdown-divider"></div>
              <li>
                <a href="<?= ADMIN_IMAGES_PATH ?>" class="btn cyan">
                <i class="fa fa-power-off"></i> Logout</a>
              </li>
            </ul>
            <?php $session = $this->session->userdata(); ?>            
          </div>
        </div>       
      </li>      
    </ul>   
  </div>
</header>