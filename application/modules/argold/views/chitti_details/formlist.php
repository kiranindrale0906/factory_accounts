<h5 class="heading">Metal issue  voucher List</h5>
<table class="table table-sm table_blue" id="tblAddRow">
  <thead>
    <tr>
      <th><?php load_buttons('anchor', array('name'=>'Select All', 'class'=>'blue select_all')); ?></th>
      <th>Voucher No</th>
      <th>Narration</th>
      <th class="text-right">Weight</th>
      <th class="text-right">Factory Purity</th>
      <th class="text-right">Wastage</th>
      <th class="text-right">Issue Fine</th>
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
