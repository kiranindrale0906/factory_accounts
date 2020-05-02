<tr>
    <td><?= date('d-m-y', strtotime($voucher_date)) ?></td>
    <td><?= $voucher_number ?></td>
    <td><?= $account_name ?></td>
    <td class="text-right"><?= overwrite_number_format($credit_weight, 3) ?></td>
    <td class="text-right"><?= overwrite_number_format($debit_weight, 3) ?></td>
    <td><?= (!empty($narration)) ? $narration : '' ?></td>
</tr>