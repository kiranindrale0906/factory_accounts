<?php 
  $data_variable_name = (isset($data['controller'])) ? $data['controller'] : 'record';
  $data = get_field_data($data, $this->router, @$$data_variable_name); 
?>

<div class="boxrow p-b-10">
  <a class="btn btn-link text-success pull-right" 
     href=<?= ADMIN_PATH.$controller.'/edit/'.$record['id'] ?>>
    Edit
  </a>
</div>