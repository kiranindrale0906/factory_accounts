<?php

  if (!isset($record)) 
    $record = array();

  // $controller=$this->router->module."/".$this->router->class;
  // $action="store";
  // $record=array();

?>
<?php $this->load->view('tabs') ?> 
<div class="tbl_header_frm">
  <?php $this->load->view('form') ?> 
</div>
