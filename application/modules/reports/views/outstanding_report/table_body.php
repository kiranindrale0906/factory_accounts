<tbody>
<?php 
    if(!empty($outstanding_reports)){
    foreach ($outstanding_reports as $index => $outstanding_report){ ?>
	   <tr>
                                        <td><?= ++$index; ?></td>
                                        <td ><?= $outstanding_report['account_name'] ?></td>
                                        
                                        <?php if($outstanding_report['transaction_type'] == 'Value & Weight') : ?>
                                            <td class="text-right"></td>
                                        <?php else: ?>
                                            <td class="text-right"><?= ($outstanding_report['closing_cash_debit_amount']) ?></td>
                                        <?php endif; ?>

                                        <?php if($outstanding_report['transaction_type'] == 'Value & Weight') : ?>
                                            <td class="text-right"><?= (($outstanding_report['total_debit_amount'] - $outstanding_report['closing_cash_debit_amount'])) ?></td>
                                        <?php else: ?>
                                            <td class="text-right"><?= ($outstanding_report['closing_cash_credit_amount']) ?></td>
                                        <?php endif; ?>
                                        
                                        <td class="text-right"><?= ($outstanding_report['closing_bank_debit_amount']) ?></td>
                                        <td class="text-right"><?= ($outstanding_report['closing_bank_credit_amount']) ?></td>
                                        <td class="text-right"><?= ($outstanding_report['closing_debit_weight']) ?></td>
                                        <td class="text-right"><?= ($outstanding_report['closing_credit_weight']) ?></td>
                                    </tr>

       <?php }}?>
</tbody> 