<div class="col-md-12">
  <div class="form-group container">
    <h5 class="ml-2 pl-2">Tounch Loss Fine</h5>
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
         <td class="text-right"><?= four_decimal($accounts_argold_tounch_loss_fine) ?></td>
         <td class="text-right"><?= four_decimal($accounts_argold_tounch_loss_fine_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_argold_tounch_loss_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_argold_tounch_loss_fine_fine) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_tounch_loss_fine-$live_argold_tounch_loss_fine) ?></td>
          <td class="text-right"><?= four_decimal($accounts_argold_tounch_loss_fine_fine-$live_argold_tounch_loss_fine_fine) ?></td>
        </tr>
        <tr>
          <td>ARF</td>
          <td class="text-right"><?= four_decimal($accounts_arf_tounch_loss_fine) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arf_tounch_loss_fine_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_arf_tounch_loss_fine) ?>  </td>
          <td class="text-right"><?= four_decimal($live_arf_tounch_loss_fine_fine) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arf_tounch_loss_fine-$live_arf_tounch_loss_fine) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arf_tounch_loss_fine_fine-$live_arf_tounch_loss_fine_fine) ?></td>
        </tr>
        <tr>
          <td>ARC</td>
         <td class="text-right"><?= four_decimal($accounts_arc_tounch_loss_fine) ?></td>
         <td class="text-right"><?= four_decimal($accounts_arc_tounch_loss_fine_fine) ?></td>
          <td class="text-right"><?= four_decimal($live_arc_tounch_loss_fine) ?>  </td>
          <td class="text-right"><?= four_decimal($live_arc_tounch_loss_fine_fine) ?>  </td>
          <td class="text-right"><?= four_decimal($accounts_arc_tounch_loss_fine - $live_arc_tounch_loss_fine) ?></td>
          <td class="text-right"><?= four_decimal($accounts_arc_tounch_loss_fine_fine - $live_arc_tounch_loss_fine_fine) ?></td>
        </tr>
        <tr>
          <td><b>Total</b></td>
           <td class="text-right"><b><?= four_decimal(($accounts_argold_tounch_loss_fine + $accounts_arf_tounch_loss_fine + $accounts_arc_tounch_loss_fine)) ?></b></td>
           <td class="text-right"><b><?= four_decimal(($accounts_argold_tounch_loss_fine_fine + $accounts_arf_tounch_loss_fine_fine + $accounts_arc_tounch_loss_fine_fine)) ?></b></td>
           <td class="text-right"><b><?= four_decimal(($live_argold_tounch_loss_fine + $live_arf_tounch_loss_fine + $live_arc_tounch_loss_fine)) ?>  </b></td>
           <td class="text-right"><b><?= four_decimal(($live_argold_tounch_loss_fine_fine + $live_arf_tounch_loss_fine_fine + $live_arc_tounch_loss_fine_fine)) ?>  </b></td>
          <td class="text-right"><b><?= four_decimal((($accounts_argold_tounch_loss_fine-$live_argold_tounch_loss_fine)
                                                           +  ($accounts_arf_tounch_loss_fine-$live_arf_tounch_loss_fine)
                                                           + ($accounts_arc_tounch_loss_fine-$live_arc_tounch_loss_fine)
                                                           )) ?></b></td>
          <td class="text-right"><b><?= four_decimal((($accounts_argold_tounch_loss_fine_fine-$live_argold_tounch_loss_fine_fine)
                                                           +  ($accounts_arf_tounch_loss_fine_fine-$live_arf_tounch_loss_fine_fine)
                                                           + ($accounts_arc_tounch_loss_fine_fine-$live_arc_tounch_loss_fine_fine)
                                                           )) ?></b></td>

        </tr>
      </table>
    </div>
  </div>
</div>