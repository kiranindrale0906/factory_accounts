<form method="get" class="form-horizontal fields-group-sm" enctype="multipart/form-data"
      action="<?= $url ?>">
        
  <?php load_field('dropdown', array('field' => 'account_id', 
                                     'option' => @$account_names,
                                     'value' => @$account_id)); ?> 

  <div class="row"> 
    <div class="col-md-6">
      <div class="form-group container"> 
        <?php
            $add_attr=array('controller' => $this->router->class, 'name' => 'Submit' , 'class' => 'btn_blue');
            load_buttons('submit', $add_attr); 
            load_buttons('anchor', array('href'=> $url,
                                         'name' => 'Clear Filter' , 
                                         'class' => 'btn_blue')); 
        ?>
      </div> 
    </div>
  </div>  
</form>