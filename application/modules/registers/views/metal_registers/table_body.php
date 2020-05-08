<tr>
    <td><?= date('d-m-y', strtotime($voucher_date)) ?></td>
    <td><?= $voucher_number ?></td>
    <td><?= $account_name ?></td>
    <td class="text-right"><?= (!empty($debit_weight)) ? decimal_number_format($credit_weight):"0.0000"; ?></td>
    <td class="text-right"><?= (!empty($debit_weight)) ? decimal_number_format($debit_weight) : "0.0000"; ?></td>
    <td><?= (!empty($narration)) ? $narration : '' ?></td>
</tr>