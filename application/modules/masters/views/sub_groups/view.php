<?php
  if (!isset($record)) 
    $record = array();
?>

<h5 class="heading">Basic Details</h5>
<a href=<?= ADMIN_PATH.'users/users/edit/'.$record['id'] ?>>Edit</a>
<div class="row">    
  <?php load_field('label_with_value', array('field' => 'username')) ?>
  <?php load_field('label_with_value', array('field' => 'email')) ?>
  <?php load_field('label_with_value', array('field' => 'mobile_no')) ?>
</div>
<div class="row">    
  <?php load_field('label_with_value', array('field' => 'salutation')) ?>
  <?php load_field('label_with_value', array('field' => 'name')) ?>
  <?php load_field('label_with_value', array('field' => 'last_name')) ?>
</div>
<div class="row">    
  <?php load_field('label_with_value', array('field' => 'location')) ?>
  <?php load_field('label_with_value', array('field' => 'designation')) ?>
  <?php load_field('label_with_value', array('field' => 'parent_id')) ?>
</div>
<div class="row"> 
  <?php load_field('label_with_value', array('field' => 'status')) ?>   
  <?php load_field('label_with_value', array('field' => 'user_role_id')) ?>
</div>