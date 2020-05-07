<tr>
    <td><?= date('d-m-y', strtotime($voucher_date)) ?></td>
    <td><?= $voucher_number ?></td>
    <td><?= $account_name ?></td>
    <td class="text-right"><?= decimal_number_format($credit_weight) ?></td>
    <td class="text-right"><?= decimal_number_format($debit_weight) ?></td>
    <td><?= (!empty($narration)) ? $narration : '' ?></td>
</tr>