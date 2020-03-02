<?php
  $namespace = $this->router->module;
  $controller = $this->router->class;
  $action = $this->router->method;
  $ci = &get_instance();
  $id = $ci->uri->segment(3);
  
  $create_title = get_form_title($controller, $action);
?>

<div class="<?=$controller?>">
  <!-- <div class="container-fluid"> -->
    <div class="boxrow">
      <div class="float-left">
        <h6 class="heading"><?= ucwords(str_replace("_", " ", $create_title)); ?></h6>     
      </div>
    <?php if($controller=='productions'):?>   
      <div class="float-right">
        <button class="btn btn-xs btn_blue btn_radius" data-toggle="modal" data-target="#inputCompany" href="javascript:void(0)">Company Input Information</button>
      </div>
    <?php endif; ?>
    <?php if($controller=='templates' && $action=='edit'):?>   
      <div class="float-right">
        <a  href="<?=ADMIN_PATH?>Template_custom_dropdowns/index/<?=$id?>" class="btn btn-xs btn_blue btn_radius">Custom Dropdown</a>
      </div>
    <?php endif; ?>
    </div>
        <?php
          if (@$import == 1)
            $this->load->view($namespace."/".$controller.'/import',
                                    array('controller' => $namespace.'/'.$controller,
                                          'action' => $action));
          else
            $this->load->view($namespace."/".$controller . '/form',
                                    array('controller' => $namespace.'/'.$controller,
                                          'action' => $action))
        ?>    
    
  <!-- </div> -->
</div>