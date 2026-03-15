<?php 
  if (isset($record['id']) && !empty($record['id'])):
    $this->load->view('editform');
  else:
    $this->load->view('newform');
 endif; 
?>     