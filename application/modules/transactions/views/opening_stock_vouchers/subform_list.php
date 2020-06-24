<!-- <div>
  <h6 class="bold float-left mb-0">Opening Stock Voucher</h6>
  <?= getJsButton('Add More', 'javascript:void(0)', 'btn_blue float-right mb-1', '', 'add_form_opening_stock_voucher()'); ?>
</div>
<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th>Category</th>
        <th>Gross Wt</th>
        <th>Moti Wt</th>
        <th>Net Wt</th>
        <th>Melting%</th>
        <th>Wastage%</th>
        <th>Other crg</th>
        <th>Narration</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="table_opening_stock_voucher">
      <?php 
        $this->load->view('transactions/opening_stock_vouchers/subform', array('index' =>'1')); ?>
    </tbody>
  </table>
</div> 
<hr/>
  <script>
    <?php $issue_voucher_form_html = $this->load->view('transactions/opening_stock_vouchers/subform',
                                                   array('index' => 'index_count'),TRUE);?>
    var issue_voucher_form_html = <?= json_encode(array('html' => $issue_voucher_form_html)); ?>;
    var fields_index_issue_voucher = 1;
  function add_form_opening_stock_voucher() {
    fields_index_issue_voucher += 1;
    var html_str = issue_voucher_form_html.html.replace(/\index_count/g, fields_index_issue_voucher);
    $('#table_opening_stock_voucher').append(html_str);
    return false;
  }

  </script> -->