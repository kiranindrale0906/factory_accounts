<tr>
  <td class="text-right"><?php echo $ledger['voucher_date']; ?></td>
  <td class="text-right"><?php echo $ledger['voucher_type']; ?></td>
  <td class="text-right"><?php echo $ledger['voucher_number']; ?></td>
  <td class="text-right"><?php echo $ledger['purity']; ?></td>
  <td class="text-right"><?php echo $ledger['factory_purity']; ?></td>
  <td class="text-right">
    <?php echo !empty($ledger['credit_amount'])?$ledger['credit_amount']:''; ?>      
  </td>
  <td class="text-right">
    <?php echo !empty($ledger['debit_amount'])?$ledger['debit_amount']:''; ?>    
  </td>
  <td class="text-right">
    <?php echo !($ledger['credit_weight']=="0.00")?$ledger['credit_weight']:''; ?>    
  </td>
  <td class="text-right"><?php echo !($ledger['debit_weight']=="0.00")?$ledger['debit_weight']:''; ?></td>
  <td class="text-right"><?php echo !($purity_margin=="0.00")?$purity_margin:''; ?></td>
</tr>