<h5 class="heading">Metal issue List</h5>
<table class="table table-sm table_blue" id="tblAddRow">
  <thead>
    <tr>
      <th><?php load_buttons('anchor', array('name'=>'Select All', 'class'=>'blue select_all')); ?></th>
      <th>Voucher No</th>
      <th>Voucher Date</th>
      <th>Credit weight</th>
      <th>Factory Purity</th>
      <th>Factory Fine</th>
      <th>Issue Purity</th>
      <th>Issue Fine</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($metal_vouchers as $index => $vouchers) {
        $this->load->view('chitti_details/subform',array('index'=> $index, 'vouchers' => $vouchers));
      }
    ?>
  </tbody>
</table>