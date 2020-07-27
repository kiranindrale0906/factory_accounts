<form method="get" class="form-horizontal fields-group-sm" enctype="multipart/form-data"
      action="<?= $url ?>">

  <div class="row"> 
    <?php load_field('dropdown', array('field' => 'product_name', 'option' => $product_names)); ?> 
    <?php load_field('dropdown', array('field' => 'in_purity', 'option' => $in_purities)); ?> 
  </div>
  <div class="row"> 
    <?php load_field('dropdown', array('field' => 'category_one', 'option' => $category_ones)); ?> 
    <?php load_field('dropdown', array('field' => 'machine_size', 'option' => $machine_sizes)); ?> 
  </div>
  <div class="row"> 
    <?php load_field('dropdown', array('field' => 'design_code', 'option' => $design_codes)); ?> 
  </div>

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