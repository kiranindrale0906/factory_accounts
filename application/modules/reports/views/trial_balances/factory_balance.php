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
          <td>AR GOLD</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_argold_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_argold_balance) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_balance - $live_argold_balance) ?></td>
        </tr>
        <tr>
          <td>ARF</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_arf_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_arf_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arf_balance - $live_arf_balance) ?></td>
        </tr>
        <tr>
          <td>ARC</td>
          <td class="text-right"><?= four_decimal(-1 * $accounts_arc_balance) ?></td>
          <td class="text-right"><?= four_decimal(-1 * $live_arc_balance) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arc_balance - $live_arc_balance) ?></td>
        </tr>
        <tr>
          <td>Total</td>
          <td class="text-right"><?= four_decimal(-1 * ($accounts_argold_balance + $accounts_arf_balance + $accounts_arc_balance)) ?></td>
          <td class="text-right"><?= four_decimal(-1 * ($live_argold_balance + $live_arf_balance + $live_arc_balance)) ?>  </td>
          <td class="text-right"><b><?= four_decimal(-1 * (  $accounts_argold_balance  - $live_argold_balance
                                                           + $accounts_arf_balance - $live_arf_balance
                                                           + $accounts_arc_balance - $live_arc_balance)) ?></b></td>
        </tr>
      </table>
    </div>
  </div>
</div>