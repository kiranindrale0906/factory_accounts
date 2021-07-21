<h5 class="heading">Metal issue  voucher List</h5>
<table class="table table-sm table_blue" id="tblAddRow">
  <thead>
    <tr>
      <th><?php load_buttons('anchor', array('name'=>'Select All', 'class'=>'blue select_all')); ?></th>
      <th>Date</th>
      <th>Narration</th>
      <th>Customer Name</th>
      <th class="text-right">Weight</th>
      <th class="text-right">Balance</th>
      <th class="text-right">Purity</th>
      <th class="text-right">Gross weight</th>
      <th class="text-right">Qauntity</th>
      <th class="text-right">Stone</th>
      <th class="text-right">Making Charge</th>
      <th class="text-right">Colour</th>
      <th class="text-right">Code</th>
      <th class="text-right">Description</th>
      <th class="text-right">Factory Purity</th>
      <th class="text-right">Wastage</th>
      <th class="text-right">Issue Fine</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $weight = $issue_fine = $balance = 0;
      foreach ($metal_vouchers as $index => $vouchers) {
        $weight += $vouchers['credit_weight'];
        $balance += $vouchers['packing_slip_balance'];
        $issue_fine += $vouchers['credit_weight']*$vouchers['factory_purity']/100;
        $this->load->view('packing_slip_details/subform',array('index'=> $index, 'vouchers' => $vouchers));
      }
    ?>
    <tr>
      <th>Total</th>
      <th></th>
      <th></th>
      <th></th>
      <th class="text-right"><?= four_decimal($weight) ?></th>
      <th class="text-right"><?= four_decimal($balance) ?></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th class="text-right"><?= four_decimal($issue_fine) ?></th>
    </tr>
  </tbody>

</table>