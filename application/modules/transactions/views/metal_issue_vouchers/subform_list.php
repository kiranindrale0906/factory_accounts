<div>
  <h6 class="bold float-left mb-0">Metal Issue Voucher</h6>
  <?= getJsButton('Add More', 'javascript:void(0)', 'btn_purple float-right mb-1', '', 'add_form_metal_issue_voucher()'); ?>
</div>
<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th>Voucher Date</th>
        <th>Account Name</th>
        <th>Weight</th>
        <th>Purity</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="table_metal_issue_voucher">
      <?php 
        $this->load->view('transactions/metal_issue_vouchers/subform', array('index' =>'0')); ?>
    </tbody>
  </table>
</div> 
<hr/>
  <script>
    <?php $issue_voucher_form_html = $this->load->view('transactions/metal_issue_vouchers/subform',
                                                   array('index' => 'index_count'),TRUE);?>
    var issue_voucher_form_html = <?= json_encode(array('html' => $issue_voucher_form_html)); ?>;
    var fields_index_issue_voucher = 1;
    function add_form_metal_issue_voucher(){
      fields_index_issue_voucher += 1;
      var html_str = issue_voucher_form_html.html.replace(/\index_count/g, fields_index_issue_voucher);
      $('#table_metal_issue_voucher').append(html_str);
      return false;
    }
  </script>