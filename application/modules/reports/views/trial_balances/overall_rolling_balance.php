<div class="col-md-12">
  <div class="form-group container">
    <h5 class="ml-2 pl-2">Overall Rolling</h5>
    <div class="table-responsive m-t-20">
      <table class="table table-sm fixedthead table-default">
        <thead>
          <tr> <th>Stock</th>
            <th class="text-right">Balance</th>
            <th class="text-right">GPC Balance</th>
            <th class="text-right">Rolling</th>
          </tr>
        </thead>
        <tr>
          <td>AR GOLD Jan 2021</td>
          <td class="text-right"><?= $arg_balance=four_decimal($live_argold_jan2021_rolling_balance) ?></td>
          <td class="text-right"><?= $arg_gpc_balance=four_decimal($live_argold_jan2021_rolling_gpc_balance) ?></td>
          <td class="text-right"><?= $arg_rolling=!empty($arg_balance)?four_decimal($arg_gpc_balance/$arg_balance):0 ?></td>
        </tr>
        <tr>
          <td>ARF Jan 2021</td>
          <td class="text-right"><?= $arf_balance=four_decimal($live_arf_jan2021_rolling_balance) ?></td>
          <td class="text-right"><?= $arf_gpc_balance=four_decimal($live_arf_jan2021_rolling_gpc_balance) ?></td>
          <td class="text-right"><?= $arf_rolling=!empty($arf_balance)?four_decimal($arf_gpc_balance/$arf_balance):0 ?></td>
        </tr>
        <tr>
          <td>ARC Jan 2021</td>
          <td class="text-right"><?= $arc_balance=four_decimal($live_arc_jan2021_rolling_balance) ?></td>
          <td class="text-right"><?= $arc_gpc_balance=four_decimal($live_arc_jan2021_rolling_gpc_balance) ?></td>
          <td class="text-right"><?= $arc_rolling=!empty($arc_balance)?four_decimal($arc_gpc_balance/$arc_balance):0 ?></td>
        </tr>
        <tr>
          <td><b>Total</b></td>
           <td class="text-right"><b><?= four_decimal(($arg_balance + $arf_balance + $arc_balance )) ?></b></td>
           <td class="text-right"><b><?= four_decimal(($arg_gpc_balance + $arf_gpc_balance + $arc_gpc_balance )) ?></b></td>
           <td class="text-right"><b><?= four_decimal(($arg_rolling + $arf_rolling + $arc_rolling )) ?>  </b></td>
           </tr>
      </table>
    </div>
  </div>
</div>