<?php
  $page_details =  getTableSettings();
  $data['table_name'] = $page_details['primary_table'];
  $data['checkbox_option'] = (isset($page_details['checkbox_in_listing']) 
  && !empty($page_details['checkbox_in_listing']));


?>

<?php 
  $layout = (isset($this->_ci_cached_vars['index_layout'])?$this->_ci_cached_vars['index_layout']:'application');
  if(isset($page_details['custom_table_header']) && 
    $page_details['custom_table_header'] == true)
  $this->load->view($this->router->module."/".$this->router->class.'/table_header');
  $this->load->view('layouts/'.$layout.'/list/top_header');
  $this->load->view('layouts/'.$layout.'/list/table_setting');
  $this->load->view('sys/search/view');
?>

<div class="table-responsive tablefixedheader">
  <table class="table table-sm fixedthead table-default responsive_table">
    <?php if ($data['checkbox_option']) { 
      echo form_open_multipart($action_url); 
    } ?>
    <?php    
      $this->load->view('layouts/'.$layout.'/list/table');
    ?>
    <?php if ($data['checkbox_option']) {
      $this->load->view('forms/fields/button', array('type' =>'submit',
                                                     'displayName' => 'Submit',
                                                     'name'=> "<?= $table_name ?>",
                                                     'value' => '1',
                                                     'id' => 'selected_submit',
                                                     'grid' => 'col-md-1'
                                                    ));
      echo form_close();
    }
    ?>  
  </table>
</div>

<?php $this->load->view('layouts/'.$layout.'/list/table_pagination');
  if(isset($page_details['custom_table_footer']) && 
    $page_details['custom_table_footer'] == true)
    $this->load->view($this->router->module."/".$this->router->class.'/table_footer');
  

?>

