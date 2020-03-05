<header class="d-flex justify-content-between align-items-center fixed-top">
  <div>
    <a href="index.php">
      <img src="<?= CORE_PATH() ?>images/common/logo.png"> 
      <!-- Your Logo Here -->
    </a> 

    <button class="btn btn-lg btn_icon btn_slide_sidemenu btn_slide_sidemenu_js">
      <i class="fal fa-align-justify"></i>
    </button>    
  </div>  
  <div class="m-3">
    <select class="form-control" name="set_company_id" id="set_company_id" onchange="set_company_session()">
      <?php 
        $company_list=get_company_list();
        if(!empty($company_list)) { ?>
          <option value="">Select Company</option>
          <?php foreach ($company_list as $key => $value) { 
             $sel="";
             if(!empty($_SESSION['company_id']) && $_SESSION['company_id']==$value['id'])
              $sel="selected";
             // if(empty($_SESSION['company_id']) && $key==0){
             //    $_SESSION['company_id'] =$key;
             //    $sel="selected";  
             // } 
               
          ?>
            <option value="<?=$value['id']?>" <?=$sel?>>
              <?=$value['name']?>
            </option>  
          <?php 
          }
        }
        else { ?>
          <option value="">No Company Found</option>
        <?php 
        }
      ?>  
    </select>
  </div>
  <div class="d-flex align-items-center justify-content-end float-right">

        
    
    <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])):
        //$this->load->view('communications/inapp_notifications/inapp_view');
    ?>
    <ul class="nav">   
      <li class="nav-item">
        <div class="dropdown">
          <a href="#" 
             class="nav-link btn btn-lg blue selectnotification select_offset" 
             data-offset='0' 
             data-toggle="dropdown">
           <i class="far fa-bell font18"></i>
           <?php if(!empty($_SESSION['inapp_count'])){?>
            <span class="badge badge-pill badge-danger animated fadeIn count count_inapp">
              <?=$_SESSION['inapp_count'];?>
            </span>
            <?php }?>
          </a>
          <div class="dropdown-menu animated slideIn notification_dropdown shadow" >
            <div class="dropdown-header bg_blue">
              <h5 class="white bold m-0 text-center">Notifications</h5>
            </div>
            <div class="dropdown-divider"></div>
            <ul class="list-unstyled menu-list more-list show_notifications" id="myList">
              
            </ul>
             <div class="dropdown-divider"></div>
              <div class="text-center bottom_btn">
                  <a href="javascript:void(0);" class="btn btn-sm blue underline morelink">See All</a>
              </div> 
          </div>
        </div>       
      </li> 
    </ul>
    
    <ul class="nav">          
      <li class="nav-item usermenu">
        <div class="dropdown">
          <a href="#" class="nav-link btn btn-lg cyan" data-toggle="dropdown">
           <i class="fas fa-user blue"></i>
          </a>
          <div class="dropdown-menu animated slideIn">            
            <ul class="list-unstyled menu-list">
              <li><a href="#" class="btn link-black"><i class="fas fa-user font30 gray align-middle"></i></i> <span class="d-inline-block text-left pl-2 align-middle"><?= (isset($_SESSION['name'])?$_SESSION['name']:''); ?> <br><?= (isset($_SESSION['email'])?$_SESSION['email']:''); ?></span></a></li>                     
              <div class="dropdown-divider"></div>
              <li>
                <a href="<?= BASE_URL.'users/logout' ?>" class="btn cyan">
                <i class="fa fa-power-off blue"></i> <span class="blue">Logout</span></a>
              </li>
            </ul>
            <?php $session = $this->session->userdata(); ?>            
          </div>
        </div>       
      </li>      
    </ul>     
    <?php else:?>
      <a href="<?= base_url().'users/login/create'?>" class="">Login</a>
    <?php endif;?>  
  </div>
</header>