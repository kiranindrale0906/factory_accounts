<?php
if(!isset($log_from)){
  echo form_open('',array('method'=>'get'));
  load_buttons('submit', array(
                     'name'=> 'Show',
                     'class'=>'btn-md btn_blue float-right ml-2 update-mogration', 
                     'href'=> BASE_URL.'sys/php_logs/view',
                     'modal-size'=>'lg'
                    ));
  echo '<div class="col-sm-4 pull-right">
          <input type="text" name="date" placeholder="Date" class="form-control get_module" value="'.(isset($_GET['date'])?$_GET['date']:"").'">
        </div>';
   
   echo form_close();
}
?>
<div id="content_logs">
  <div class="col-sm-6 pull-right">
    </div>
    <div class="container-fluid">
        <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $heading;?><i class="fa fa-exclamation-triangle"></i></h3>
        </div>
        <div class="panel-body text-justify">
          <table class="table table-sm fixedthead table-default">
            <thead>
              <th>
                Serial No.  
              </th>
              <th>
                Error
              </th> 
            </thead>
           <?php
           $i = 1; 
          foreach($logs as $log_key => $log_value){
            if(!empty($log_value)){?>
              <tbody>
                <tr>
                  <td>
                    <?php echo $i;?>
                  </td>
                  <td><?php echo $log_value;?></td>
                </tr>
              </tbody> 
            <?php $i++;}
          }?>
        </table>  
        </div>
        </div>
    </div>
</div>
<?php if(!isset($log_from)){
 $this->load->view('sys/php_logs/log_paginations');

}?>
