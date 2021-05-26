<h5 class="heading">Metal issue  voucher List</h5>
<table class="table table-sm table_blue" id="tblAddRow">
  <thead>
    <tr>
      <th><?php load_buttons('anchor', array('name'=>'Select All', 'class'=>'blue select_all')); ?></th>
      <th>Packet No</th>
      <th>Date</th>
      <th>Narration</th>
      <th>Customer Name</th>
      <th class="text-right">Weight</th>
      <th class="text-right">Factory Purity</th>
      <th class="text-right">Wastage</th>
      <th class="text-right">Issue Fine</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $weight = $issue_fine = 0;
      foreach ($metal_vouchers as $index => $vouchers) {
        $weight += $vouchers['credit_weight'];
        $issue_fine += $vouchers['credit_weight']*$vouchers['factory_purity']/100;
        $this->load->view('chitti_details/subform',array('index'=> $index, 'vouchers' => $vouchers));
      }
    ?>
    <tr>
      <th>Total</th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th class="text-right"><?= four_decimal($weight) ?></th>
      <th></th>
      <th></th>
      <th class="text-right"><?= four_decimal($issue_fine) ?></th>
    </tr>
  </tbody>

</table>