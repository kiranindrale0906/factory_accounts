<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th></th>
        <th class="text-right">Account Name</th>
        <th class="text-right">Voucher No</th>
        <th class="text-right">Voucher Date</th>
        <th class="text-right">Amount</th>
        <th class="text-right">Voucher Check</th>
        <th class="text-right">Document</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if(!empty($income_expense_account_details)) {
        $sum_amount=0;
        foreach ($income_expense_account_details as $index => $income_expense_voucher_detail) {
          $sum_amount+=$income_expense_voucher_detail['amount'];
          ?>
          <tr>
            <td><?=$index+1?></td>
            <td class="text-right"><?= $income_expense_voucher_detail['account_name']; ?></td>
            <td class="text-right"><?= $income_expense_voucher_detail['voucher_no']; ?></td>
            <td class="text-right"><?= $income_expense_voucher_detail['voucher_date']; ?></td>
            <td class="text-right"><?=four_decimal($income_expense_voucher_detail['amount']); ?></td>
            <td class="text-right"><?=($income_expense_voucher_detail['voucher_check']==1)?"Checked":"-"; ?></td>
            <td class="text-right"><a target="_blank" href=<?= BASE_URL.'uploads/invoices/original/'.$income_expense_voucher_detail['document']?>>View Document</a></td>
          </tr>
        <?php } ?>
        <tr class="bg_gray bold">
          <td>Total</td>
          <td class="text-right"></td>
          <td class="text-right"></td>
          <td class="text-right"></td>
          <td class="text-right"><?=four_decimal($sum_amount);?></td>
          <td class="text-right"></td>
          <td class="text-right"></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
