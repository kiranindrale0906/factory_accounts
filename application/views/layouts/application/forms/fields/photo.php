<?php $data = get_field_data($data, $this->router, $record); ?>

<?php if(isset($data['col']) && $data['col']!=''){?>
  <div class="<?= $data['col'] ?>">
<?php }?>

<div class="form-group row justify-content-between"> 
  <?php load_field('plain/field_label', array('data' => $data, 'label_class'=>'col-sm-3 col-form-label')); ?>

    <div class="col-md-9">
      <?php load_field('plain/photo', array('data' => $data)); ?> 
    </div>
  
</div>

<?php if(isset($data['col']) && $data['col']!=''){?>
  </div>
<?php }?>