<h5 class="heading">Metal issue  voucher List</h5>
<div class="table-responsive">
<table class="table table-sm table_blue" id="tblAddRow">
  <thead>
    <tr>
      <th><?php load_buttons('anchor', array('name'=>'Select All', 'class'=>'blue select_all')); ?></th>
      <th>Date</th>
      <th>Narration</th>
      <th>Customer Name</th>
      <th class="text-right">Weight</th>
      <th class="text-right">Rate</th>
      <th class="text-right">Purity</th>
      <th class="text-right">Factory Purity</th>
      <th class="text-right">Fine</th>
      <th class="text-right">Factory Fine</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $weight = $issue_fine = $balance = 0;
      foreach ($metal_vouchers as $index => $vouchers) {
        $weight += $vouchers['credit_weight'];
        $issue_fine += $vouchers['credit_weight']*$vouchers['factory_purity']/100;
        $this->load->view('domestic_labour_chitti_details/subform',array('index'=> $index, 'vouchers' => $vouchers));
      }
    ?>
    <tr>
      <th>Total</th>
      <th></th>
      <th></th>
      <th></th>
      <th class="text-right"><?= four_decimal($weight) ?></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </tbody>

</table>
</div>