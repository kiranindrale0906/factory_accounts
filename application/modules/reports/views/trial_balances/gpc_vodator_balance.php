<div class="col-md-12">
  <div class="form-group container">
    <h5 class="ml-2 pl-2">GPC Vodator</h5>
    <div class="table-responsive m-t-20">
      <table class="table table-sm fixedthead table-default">
        <thead>
          <tr> <th>Stock</th>
            <th class="text-right">Accounts</th>
            <th class="text-right">Accounts Fine</th>
            <th class="text-right">Factory</th>
            <th class="text-right">Factory Fine</th>
            <th class="text-right">Total</th>
            <th class="text-right">Total Fine</th>
          </tr>
        </thead>
        <tr>
          <td>AR GOLD Jan 2021</td>
          <td class="text-right"><?= four_decimal($accounts_argold_jan2021_gpc_vodator) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_jan2021_gpc_vodator_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_argold_jan2021_gpc_vodator) ?></td>
          <td class="text-right"><?= four_decimal($live_argold_jan2021_gpc_vodator_fine) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_jan2021_gpc_vodator-$live_argold_jan2021_gpc_vodator) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_jan2021_gpc_vodator_fine-$live_argold_jan2021_gpc_vodator_fine) ?></td>
        </tr>
        <tr>
          <td>ARF Jan 2021</td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_gpc_vodator) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_gpc_vodator_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_arf_jan2021_gpc_vodator) ?>  </td>
          <td class="text-right"><?= four_decimal($live_arf_jan2021_gpc_vodator_fine) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_gpc_vodator-$live_arf_jan2021_gpc_vodator) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_gpc_vodator_fine-$live_arf_jan2021_gpc_vodator_fine) ?></td>
        </tr>
        <tr>
          <td>ARC Jan 2021</td>
         <td class="text-right"><?= four_decimal($accounts_arc_jan2021_gpc_vodator) ?></td>
         <td class="text-right"><?= four_decimal($accounts_arc_jan2021_gpc_vodator_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_arc_jan2021_gpc_vodator) ?>  </td>
          <td class="text-right"><?= four_decimal($live_arc_jan2021_gpc_vodator_fine) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arc_jan2021_gpc_vodator - $live_arc_jan2021_gpc_vodator) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arc_jan2021_gpc_vodator_fine - $live_arc_jan2021_gpc_vodator_fine) ?></td>
        </tr>
        <tr>
          <td>Total</td>
           <td class="text-right"><?= four_decimal(($accounts_argold_jan2021_gpc_vodator + $accounts_arf_jan2021_gpc_vodator + $accounts_arc_jan2021_gpc_vodator )) ?></td>
           <td class="text-right"><?= four_decimal(($accounts_argold_jan2021_gpc_vodator_fine + $accounts_arf_jan2021_gpc_vodator_fine + $accounts_arc_jan2021_gpc_vodator_fine )) ?></td>
           <td class="text-right"><?= four_decimal(($live_argold_jan2021_gpc_vodator + $live_arf_jan2021_gpc_vodator + $live_arc_jan2021_gpc_vodator)) ?>  </td>
           <td class="text-right"><?= four_decimal(($live_argold_jan2021_gpc_vodator_fine + $live_arf_jan2021_gpc_vodator_fine + $live_arc_jan2021_gpc_vodator_fine)) ?>  </td>
          <td class="text-right"><b><?= four_decimal((($accounts_argold_jan2021_gpc_vodator-$live_argold_jan2021_gpc_vodator)
                                                           +  ($accounts_arf_jan2021_gpc_vodator-$live_arf_jan2021_gpc_vodator)
                                                           + ($accounts_arc_jan2021_gpc_vodator-$live_arc_jan2021_gpc_vodator))
                                                           ) ?></b></td>
          <td class="text-right"><b><?= four_decimal((($accounts_argold_jan2021_gpc_vodator_fine-$live_argold_jan2021_gpc_vodator_fine)
                                                           +  ($accounts_arf_jan2021_gpc_vodator_fine-$live_arf_jan2021_gpc_vodator_fine)
                                                           + ($accounts_arc_jan2021_gpc_vodator_fine-$live_arc_jan2021_gpc_vodator_fine)
                                                           + ($accounts_arc_jan2021_gpc_vodator_fine-$live_arc_jan2021_gpc_vodator_fine))
                                                           ) ?></b></td>
        </tr>
      </table>
    </div>
  </div>
</div>