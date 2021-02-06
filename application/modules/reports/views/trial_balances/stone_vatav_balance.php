<div class="col-md-12">
  <div class="form-group container">
    <h5 class="ml-2 pl-2">Stone Vatav</h5>
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
          <td>AR GOLD Jan 2021</td>
         <td class="text-right"><?= four_decimal($accounts_argold_jan2021_stone_vatav) ?></td>
         <td class="text-right"><?= four_decimal($accounts_argold_jan2021_stone_vatav_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_argold_jan2021_stone_vatav) ?></td>
          <td class="text-right"><?= four_decimal($live_argold_jan2021_stone_vatav_fine) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_jan2021_stone_vatav-$live_argold_jan2021_stone_vatav) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_jan2021_stone_vatav_fine-$live_argold_jan2021_stone_vatav_fine) ?></td>
        </tr>
        <tr>
          <td>ARF Jan 2021</td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_stone_vatav) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_stone_vatav_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_arf_jan2021_stone_vatav) ?>  </td>
          <td class="text-right"><?= four_decimal($live_arf_jan2021_stone_vatav_fine) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_stone_vatav-$live_arf_jan2021_stone_vatav) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_stone_vatav_fine-$live_arf_jan2021_stone_vatav_fine) ?></td>
        </tr>
        <tr>
          <td>ARC Jan 2021</td>
         <td class="text-right"><?= four_decimal($accounts_arc_jan2021_stone_vatav) ?></td>
         <td class="text-right"><?= four_decimal($accounts_arc_jan2021_stone_vatav_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_arc_jan2021_stone_vatav) ?>  </td>
          <td class="text-right"><?= four_decimal($live_arc_jan2021_stone_vatav_fine) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arc_jan2021_stone_vatav - $live_arc_jan2021_stone_vatav) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arc_jan2021_stone_vatav_fine - $live_arc_jan2021_stone_vatav_fine) ?></td>
        </tr>
        <tr>
          <td><b>Total</b></td>
           <td class="text-right"><b><?= four_decimal(($accounts_argold_jan2021_stone_vatav + $accounts_arf_jan2021_stone_vatav + $accounts_arc_jan2021_stone_vatav)) ?></b></td>
           <td class="text-right"><b><?= four_decimal(($accounts_argold_jan2021_stone_vatav_fine + $accounts_arf_jan2021_stone_vatav_fine + $accounts_arc_jan2021_stone_vatav_fine)) ?></b></td>
           <td class="text-right"><b><?= four_decimal(($live_argold_jan2021_stone_vatav + $live_arf_jan2021_stone_vatav + $live_arc_jan2021_stone_vatav)) ?></b>  </td>
           <td class="text-right"><b><?= four_decimal(($live_argold_jan2021_stone_vatav_fine + $live_arf_jan2021_stone_vatav_fine + $live_arc_jan2021_stone_vatav_fine)) ?> </b> </td>
          <td class="text-right"><b><?= four_decimal((($accounts_argold_jan2021_stone_vatav-$live_argold_jan2021_stone_vatav)
                                                           +  ($accounts_arf_jan2021_stone_vatav-$live_arf_jan2021_stone_vatav)
                                                           + ($accounts_arc_jan2021_stone_vatav-$live_arc_jan2021_stone_vatav)
                                                           )) ?></b></td>
          <td class="text-right"><b><?= four_decimal((($accounts_argold_jan2021_stone_vatav_fine-$live_argold_jan2021_stone_vatav_fine)
                                                           +  ($accounts_arf_jan2021_stone_vatav_fine-$live_arf_jan2021_stone_vatav_fine)
                                                           + ($accounts_arc_jan2021_stone_vatav_fine-$live_arc_jan2021_stone_vatav_fine)
                                                           )) ?></b></td>

        </tr>
      </table>
    </div>
  </div>
</div>