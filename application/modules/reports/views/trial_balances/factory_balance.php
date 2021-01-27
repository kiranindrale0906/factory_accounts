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
        <tr>
          <td>AR GOLD Jan 2021</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_argold_jan2021_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_argold_jan2021_balance) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_jan2021_balance - $live_argold_jan2021_balance) ?></td>
        </tr>
        <tr>
          <td>ARF Jan 2021</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_arf_jan2021_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_arf_jan2021_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arf_jan2021_balance - $live_arf_jan2021_balance) ?></td>
        </tr>
        <tr>
          <td>ARC Jan 2021</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_arc_jan2021_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_arc_jan2021_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arc_jan2021_balance - $live_arc_jan2021_balance) ?></td>
        </tr>
        <tr>
          <td>AR GOLD Nov 2020</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_argold_nov2020_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_argold_nov2020_balance) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_nov2020_balance - $live_argold_nov2020_balance) ?></td>
        </tr>
        <tr>
          <td>ARF Nov 2020</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_arf_nov2020_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_arf_nov2020_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arf_nov2020_balance - $live_arf_nov2020_balance) ?></td>
        </tr>
        <tr>
          <td>ARC Nov 2020</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_arc_nov2020_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_arc_nov2020_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arc_nov2020_balance - $live_arc_nov2020_balance) ?></td>
        </tr>

        <tr>
          <td>Total</td>
          <td class="text-right"><?= four_decimal(-1 * ($accounts_argold_jan2021_balance + $accounts_arf_jan2021_balance + $accounts_arc_jan2021_balance 
                                                      + $accounts_argold_nov2020_balance + $accounts_arf_nov2020_balance + $accounts_arc_nov2020_balance)) ?></td>
          <td class="text-right"><?= four_decimal(-1 * ($live_argold_jan2021_balance + $live_arf_jan2021_balance + $live_arc_jan2021_balance
                                                      + $live_argold_nov2020_balance + $live_arf_nov2020_balance + $live_arc_nov2020_balance)) ?>  </td>
          <td class="text-right"><b><?= four_decimal(-1 * (  $accounts_argold_jan2021_balance  - $live_argold_jan2021_balance
                                                           + $accounts_arf_jan2021_balance - $live_arf_jan2021_balance
                                                           + $accounts_arc_jan2021_balance - $live_arc_jan2021_balance
                                                           + $accounts_argold_nov2020_balance  - $live_argold_nov2020_balance
                                                           + $accounts_arf_nov2020_balance - $live_arf_nov2020_balance
                                                           + $accounts_arc_nov2020_balance - $live_arc_nov2020_balance)) ?></b></td>
        </tr>
      </table>
    </div>
  </div>
</div>