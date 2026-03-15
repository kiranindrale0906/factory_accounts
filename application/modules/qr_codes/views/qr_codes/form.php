<form method="post" class="form-horizontal fields-group-sm form_radius_none" 
      enctype="multipart/form-data" 
      action=<?= get_form_action($controller,$action, @$record) ?>>
  
  <div class="row">
    <?php
      if ($action == 'edit' || $action == 'update' || $action == 'create' || $action == 'store'):
        load_field('hidden', array('field' => 'id'));
      endif;

      load_field('text', array('field' => 'purity'));
      load_field('text', array('field' => 'design_code'));
      load_field('dropdown', array('field' => 'percentage',
                                          'option'=>array(
                                                      array('id'=>00,'name'=>00),
                                                      array('id'=>50,'name'=>50),
                                                      array('id'=>60,'name'=>60),
                                                      array('id'=>70,'name'=>70),
                                                      array('id'=>75,'name'=>75),
                                                      array('id'=>80,'name'=>80),
                                                      array('id'=>100,'name'=>100)
                                                    ),
                                         'onchange'=>"change_value_on_select_percentage()")); 
    load_field('dropdown', array('field' => 'factory',
                                          'option'=>array(
                                                      array('id'=>'AR Gold','name'=>'AR Gold'),
                                                      array('id'=>'ARF','name'=>'ARF'),
                                                      array('id'=>'ARC','name'=>'ARC'),
                                                    ))); 
    if($this->router->method == 'create'||$this->router->method == 'store'){
      load_field('file', array('field' => 'import_files'));?>
    </div>
    <div class="col-md-4">
        <?php load_buttons('anchor',
                     array('href' => ADMIN_PATH."assets/export_sample/qr_codes.xlsx",
                           'name' => 'Download Sample',
                           'class' => 'blue')) ?>
      </div>
  <?php }
    ?>  
 
 <?php if($this->router->method == 'edit' || $this->router->method == 'update'){?>
  <div class="col-md-12">
    <div class="float-right">
        <?= getJsButton('Add More', 'javascript:void(0)', 'btn-sm underline text-blue float-right bold mb-1', '', 'add_qr_codes()'); ?>
    </div>
    <div class="table-responsive">
      <table border="0" class="table table-sm table-default">
        <th>Gross Weight</th>
        <th>HU ID</th>
        <th>Net Weight</th>
        <th>Less</th>
        <th>Total Stone</th>
        <th>Length</th>
        <th>Stone Count</th>
        <tbody id="qr_code">
        <?php 
        foreach ($qr_code_details as $index => $qr_code_detail) {
          $this->load->view('qr_codes/qr_codes/subform', array('index' =>$index)); 
         }?>
        </tbody>
      </table>
    </div>
  </div> 
 <?php }?>
  <div class="">
    <?php load_buttons('submit', array('name'=>'SAVE', 'class'=>'btn_blue'));?>
  </div>
</form>
<script>
  <?php 
  $qr_code_form_html = $this->load->view('../qr_codes/subform',
                                                array('index' => 'index_count',
                                                      'image_url'=>''),TRUE);?>
   var qr_code_form_html = <?= json_encode(array('html' => $qr_code_form_html)); ?>;
   //var fields_index_img = 1;
   var fields_index = <?= time() ?>;
  function add_qr_codes() {
    var html_str = qr_code_form_html.html.replace(/\index_count/g, fields_index);
    $('#qr_code').append(html_str);
    fields_index += 1;
    $('.selectpicker').selectpicker('refresh');
    return false;
  }
  function delete_qr_codes(index) {
    //$("input[name*='qr_code_details["+index+"][delete]']").val(1);
    $(".qr_codes_"+index).remove();
  }
</script>

