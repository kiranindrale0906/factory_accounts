<div class="col-md-4">
  <div class="form-group container">
    <h5 class="ml-2 pl-2">Stone Vatav</h5>
    <div class="table-responsive m-t-20">
      <table class="table table-sm fixedthead table-default">
        <thead>
          <tr>
            <th>Stock</th>
            <th class="text-right">Accounts</th>
            <th class="text-right">Factory</th>
            <th class="text-right">Total</th>
          </tr>
        </thead>
        <tr>
          <td>AR GOLD Jan 2021</td>
         <td class="text-right"><?= four_decimal($accounts_argold_jan2021_stone_vatav) ?></td>
          <td class="text-right"><?= four_decimal($live_argold_jan2021_stone_vatav) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_jan2021_stone_vatav-$live_argold_jan2021_stone_vatav) ?></td>
        </tr>
        <tr>
          <td>ARF Jan 2021</td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_stone_vatav) ?></td>
          <td class="text-right"><?= four_decimal($live_arf_jan2021_stone_vatav) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_stone_vatav-$live_arf_jan2021_stone_vatav) ?></td>
        </tr>
        <tr>
          <td>ARC Jan 2021</td>
         <td class="text-right"><?= four_decimal($accounts_arc_jan2021_stone_vatav) ?></td>
          <td class="text-right"><?= four_decimal($live_arc_jan2021_stone_vatav) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arc_jan2021_stone_vatav - $live_arc_jan2021_stone_vatav) ?></td>
        </tr>
        <tr>
          <td>Total</td>
           <td class="text-right"><?= four_decimal(($accounts_argold_jan2021_stone_vatav + $accounts_arf_jan2021_stone_vatav + $accounts_arc_jan2021_stone_vatav)) ?></td>
           <td class="text-right"><?= four_decimal(($live_argold_jan2021_stone_vatav + $live_arf_jan2021_stone_vatav + $live_arc_jan2021_stone_vatav)) ?>  </td>
          <td class="text-right"><b><?= four_decimal((($accounts_argold_jan2021_stone_vatav-$live_argold_jan2021_stone_vatav)
                                                           +  ($accounts_arf_jan2021_stone_vatav-$live_arf_jan2021_stone_vatav)
                                                           + ($accounts_arc_jan2021_stone_vatav-$live_arc_jan2021_stone_vatav)
                                                           )) ?></b></td>

        </tr>
      </table>
    </div>
  </div>
</div>