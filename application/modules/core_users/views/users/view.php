<h5 class="heading">Basic Details</h5>
<a href=<?= BASE_URL.'users/users/edit/'.$record['id'] ?>>Edit</a>
<div class="row">    
  <?php load_field('label_with_value', array('field' => 'srno')) ?>
  <?php load_field('label_with_value', array('field' => 'id_no')) ?>
  <?php load_field('label_with_value', array('field' => 'name')) ?>
  <?php load_field('label_with_value', array('field' => 'contact_no')) ?>
  <?php load_field('label_with_value', array('field' => 'email')) ?>
  <?php load_field('label_with_value', array('field' => 'department_id')) ?> 
  <?php load_field('label_with_value', array('field' => 'user_role_id')) ?>  
</div>