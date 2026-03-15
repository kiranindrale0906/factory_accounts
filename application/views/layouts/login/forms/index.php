<?php
  $namespace = $this->router->module;
  $controller = $this->router->class;
  $action = $this->router->method;
  $ci = &get_instance();
  $id = $ci->uri->segment(3);  
  $create_title = get_form_title($controller, $action);
?>


<div class="<?=$controller?>">
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
</div>

