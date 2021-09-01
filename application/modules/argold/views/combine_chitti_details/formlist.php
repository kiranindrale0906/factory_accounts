<h5 class="heading">Chitti List</h5>
<div class="table-responsive">
<table class="table table-sm table_blue" id="tblAddRow">
  <thead>
    <tr>
      <th><?php load_buttons('anchor', array('name'=>'Select All', 'class'=>'blue select_all')); ?></th>
      <th class="text-right">Weight</th>
      <th class="text-right">Purity</th>
      <th class="text-right">CGST</th>
      <th class="text-right">SGST</th>
      <th class="text-right">Taxable Amount</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $weight = $issue_fine = $balance = 0;
      foreach ($chitti_details as $index => $chittis) {
        $weight += $chittis['weight'];
        $issue_fine += $chittis['weight']*$chittis['purity']/100;
        $this->load->view('combine_chitti_details/subform',array('index'=> $index, 'chittis' => $chittis));
      }
    ?>
    <tr>
      <th>Total</th>
      <th class="text-right"><?= four_decimal($weight) ?></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </tbody>

</table>
</div>