<div>
  <h6 class="bold float-left mb-0">Refresh Details</h6>
  <?= getJsButton('Add More', 'javascript:void(0)', 'btn_blue float-right mb-1', '', 'add_form_refresh()'); ?>
</div>
<div class="table-responsive">
  <table class="table table-sm">
    <thead class="bg_gray">
      <tr>
        <th>Weight</th>
        <th>Purity</th>
        <th>Fine</th>
        <th>Factory Purity</th>
        <th>Factory Fine</th>
        <th>Item Name</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="table_refresh">
      <?php 
        $this->load->view('argold/refresh_details/subform', array('index' =>'1')); ?>
    </tbody>
  </table>
</div> 
<hr/>
  <script>
    <?php $refresh_form_html = $this->load->view('argold/refresh_details/subform',
                                                   array('index' => 'index_count'),TRUE);?>
    var refresh_form_html = <?= json_encode(array('html' => $refresh_form_html)); ?>;
    var fields_index_refresh = 1;
    function add_form_refresh() {
      fields_index_refresh += 1;
      var html_str = refresh_form_html.html.replace(/\index_count/g, fields_index_refresh);
      $('#table_refresh').append(html_str);
      return false;
    }
  </script>
