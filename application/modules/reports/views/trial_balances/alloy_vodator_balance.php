<div class="col-md-12">
  <div class="form-group container">
    <h5 class="ml-2 pl-2">Alloy Vodator</h5>
    <div class="table-responsive m-t-20">
      <table class="table table-sm fixedthead table-default">
        <thead>
          <tr>
            <th>Stock</th>
            <th class="text-right">Accounts</th>
            <th class="text-right">Accounts Fine</th>
            <th class="text-right">Factory</th>
            <th class="text-right">Factory Fine</th>
            <th class="text-right">Total</th>
            <th class="text-right">Total Fine</th>
          </tr>
        </thead>
        <tr>
          <td>AR GOLD</td>
         <td class="text-right"><?= four_decimal($accounts_argold_alloy_vodator) ?></td>
         <td class="text-right"><?= four_decimal($accounts_argold_alloy_vodator_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_argold_alloy_vodator) ?></td>
          <td class="text-right"><?= four_decimal($live_argold_alloy_vodator_fine) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_alloy_vodator-$live_argold_alloy_vodator) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_alloy_vodator_fine-$live_argold_alloy_vodator_fine) ?></td>
        </tr>
        <tr>
          <td>ARF</td>
          <td class="text-right"><?= four_decimal($accounts_arf_alloy_vodator) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arf_alloy_vodator_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_arf_alloy_vodator) ?>  </td>
          <td class="text-right"><?= four_decimal($live_arf_alloy_vodator_fine) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arf_alloy_vodator-$live_arf_alloy_vodator) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arf_alloy_vodator_fine-$live_arf_alloy_vodator_fine) ?></td>
        </tr>
        <tr>
          <td>ARC</td>
         <td class="text-right"><?= four_decimal($accounts_arc_alloy_vodator) ?></td>
         <td class="text-right"><?= four_decimal($accounts_arc_alloy_vodator_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_arc_alloy_vodator) ?>  </td>
          <td class="text-right"><?= four_decimal($live_arc_alloy_vodator_fine) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arc_alloy_vodator - $live_arc_alloy_vodator) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arc_alloy_vodator_fine - $live_arc_alloy_vodator_fine) ?></td>
        </tr>
        <tr>
          <td><b>Total</b></td>
           <td class="text-right"><b><?= four_decimal(($accounts_argold_alloy_vodator + $accounts_arf_alloy_vodator + $accounts_arc_alloy_vodator)) ?></b></td>
           <td class="text-right"><b><?= four_decimal(($accounts_argold_alloy_vodator_fine + $accounts_arf_alloy_vodator_fine + $accounts_arc_alloy_vodator_fine)) ?></b></td>
           <td class="text-right"><b><?= four_decimal(($live_argold_alloy_vodator + $live_arf_alloy_vodator + $live_arc_alloy_vodator)) ?>  </b></td>
           <td class="text-right"><b><?= four_decimal(($live_argold_alloy_vodator_fine + $live_arf_alloy_vodator_fine + $live_arc_alloy_vodator_fine)) ?>  </b></td>
          <td class="text-right"><b><?= four_decimal((($accounts_argold_alloy_vodator-$live_argold_alloy_vodator)
                                                           +  ($accounts_arf_alloy_vodator-$live_arf_alloy_vodator)
                                                           + ($accounts_arc_alloy_vodator-$live_arc_alloy_vodator)
                                                           )) ?></b></td>
          <td class="text-right"><b><?= four_decimal((($accounts_argold_alloy_vodator_fine-$live_argold_alloy_vodator_fine)
                                                           +  ($accounts_arf_alloy_vodator_fine-$live_arf_alloy_vodator_fine)
                                                           + ($accounts_arc_alloy_vodator_fine-$live_arc_alloy_vodator_fine)
                                                           )) ?></b></td>

        </tr>
      </table>
    </div>
  </div>
</div>