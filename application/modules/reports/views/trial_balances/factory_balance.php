<div class="col-md-6">
  <div class="form-group container">
    <div class="table-responsive m-t-20">
      <table class="table table-sm fixedthead table-default">
        <thead>
          <tr>
            <th>Factory Closing Stock</th>
            <th class="text-right">Accounts</th>
            <th class="text-right">Factory</th>
            <th class="text-right">Total</th>
          </tr>
        </thead>
        <!-- <tr>
          <td>AR GOLD (May 2022)</td>
          <td class="text-right"><?//= four_decimal(-1 * $accounts_argold_balance) ?></td>
          <td class="text-right"><?//= four_decimal(-1 * $live_argold_balance) ?></td>
          <td class="text-right"><?//= four_decimal($accounts_argold_balance - $live_argold_balance) ?></td>
        </tr>
        <tr>
          <td>ARF (May 2022)</td>
          <td class="text-right"><?//= four_decimal(-1 * $accounts_arf_balance) ?></td>
          <td class="text-right"><?//= four_decimal(-1 * $live_arf_balance) ?>  </td>
          <td class="text-right"><?//= four_decimal($accounts_arf_balance - $live_arf_balance) ?></td>
        </tr>
        <tr>
          <td>ARC (May 2022)</td>
          <td class="text-right"><?//= four_decimal(-1 * $accounts_arc_balance) ?></td>
          <td class="text-right"><?//= four_decimal(-1 * $live_arc_balance) ?>  </td>
          <td class="text-right"><?//= four_decimal($accounts_arc_balance - $live_arc_balance) ?></td>
        </tr> -->
        <!--< tr>
          <td>AR GOLD (Aug 2022)</td>
          <td class="text-right"><?//= four_decimal(-1 * $accounts_aug2022_argold_balance) ?></td>
          <td class="text-right"><?//= four_decimal(-1 * $live_aug2022_argold_balance) ?></td>
          <td class="text-right"><?//= four_decimal($accounts_aug2022_argold_balance - $live_aug2022_argold_balance) ?></td>
        </tr> -->
        <!-- <tr>
          <td>ARF (Aug 2022)</td>
          <td class="text-right"><?//= four_decimal(-1 * $accounts_aug2022_arf_balance) ?></td>
          <td class="text-right"><?//= four_decimal(-1 * $live_aug2022_arf_balance) ?>  </td>
          <td class="text-right"><?//= four_decimal($accounts_aug2022_arf_balance - $live_aug2022_arf_balance) ?></td>
        </tr> -->
        <!-- <tr>
          <td>ARC</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_apr2023_arc_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_apr2023_arc_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_apr2023_arc_balance - $live_apr2023_arc_balance) ?></td>
        </tr> -->

       <!-- <tr>
          <td>AR GOLD (Apr 2024)</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_apr2024_argold_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_apr2024_argold_balance) ?></td>
          <td class="text-right"><?= four_decimal($accounts_apr2024_argold_balance - $live_apr2024_argold_balance) ?></td>
        </tr> -->
<!--        <tr>
          <td>ARF (Apr 2024)</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_apr2024_arf_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_apr2024_arf_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_apr2024_arf_balance - $live_apr2024_arf_balance) ?></td>
        </tr>
        <tr>
          <td>ARF (Aug 2024)</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_aug2024_arf_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_aug2024_arf_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_aug2024_arf_balance - $live_aug2024_arf_balance) ?></td>
        </tr>
        <tr>
          <td>ARC (Apr 2024)</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_apr2024_arc_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_apr2024_arc_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_apr2024_arc_balance - $live_apr2024_arc_balance) ?></td>
        </tr> 
-->
        <tr>
          <td>Export</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_apr2024_export_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_apr2024_export_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_apr2024_export_balance - $live_apr2024_export_balance) ?></td>
        </tr>

        <tr>
          <td>Domestic</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_apr2024_domestic_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_apr2024_domestic_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_apr2024_domestic_balance - $live_apr2024_domestic_balance) ?></td>
        </tr>

        <tr>
          <td>Total</td>
          <td class="text-right"><?= four_decimal(-1 * (@$accounts_apr2024_arf_balance+@$accounts_aug2024_arf_balance+@$accounts_apr2024_arc_balance+$accounts_apr2024_export_balance+$accounts_apr2024_domestic_balance)) ?></td>
          <td class="text-right"><?= four_decimal(-1 * ($live_apr2024_arf_balance+$live_aug2024_arf_balance+$live_apr2024_arc_balance+$live_apr2024_export_balance+$live_apr2024_domestic_balance)) ?>  </td>
          <td class="text-right"><b><?= four_decimal(-1 * (
                                                           @$accounts_apr2024_arc_balance - $live_apr2024_arc_balance
                                                           +@$accounts_apr2024_arf_balance - $live_apr2024_arf_balance
                                                          +@$accounts_aug2024_arf_balance - $live_aug2024_arf_balance
                                                           +$accounts_apr2024_export_balance - $live_apr2024_export_balance
                                                           +$accounts_apr2024_domestic_balance - $live_apr2024_domestic_balance)) ?></b></td>
        </tr>
      </table>
    </div>
  </div>
</div>
