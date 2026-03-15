
<?php
  if (!isset($record)) 
    $record = array();
?>
<form method="post" class="form-horizontal fields-group-sm form_radius_none" enctype="multipart/form-data"
      action="<?= get_form_action($controller, $action, $record) ?>">
  <?php if ($action == 'edit' || $action == 'update'): ?>
    <?php load_field('hidden', array('field' => 'id')); ?>
  <?php endif; ?>     
 
  <div>
    <h6 class="bold float-left mb-0">Empty Packet Details</h6>
    <?= getJsButton('Add More', 'javascript:void(0)', 'btn_blue float-right mb-1', '', 'add_form_chitti_empty_packet()'); ?>
  </div>
  <div class="table-responsive">
    <?php load_field('hidden', array('field' => 'chitti_id','value'=>$chitti_id)); ?>

   
    <table class="table table-sm">
      <thead class="bg_gray">
        <tr>
          <th>Weight</th>
          <th>Quantity</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="table_chitti_empty_packet_details">
        <?php 
          $this->load->view('argold/chitti_empty_packet_details/subform', array('index' =>'1')); ?>
      </tbody>
    </table>
  </div> 
   <?php load_buttons('submit', array('controller' => $controller, 'name' => 'SAVE' , 'class' => 'btn_blue')) ?>
</form>

<hr/>
  <script>
    <?php $refresh_form_html = $this->load->view('argold/chitti_empty_packet_details/subform',
                                                   array('index' => 'index_count'),TRUE);?>
    var refresh_form_html = <?= json_encode(array('html' => $refresh_form_html)); ?>;
    var fields_index_refresh = 1;
    function add_form_chitti_empty_packet() {
      fields_index_refresh += 1;
      var html_str = refresh_form_html.html.replace(/\index_count/g, fields_index_refresh);
      $('#table_chitti_empty_packet_details').append(html_str);
      return false;
    }
  </script>
