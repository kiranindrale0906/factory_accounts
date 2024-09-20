<thead class="bg_gray">
  <tr>
    <?php if ($report_type == 'Vadotar Report'): ?>
      <th>Type</th>
    <?php endif; ?>
    <?php if ($report_type != 'Account Ledger' || $report_type!="Purchase Sales Ledger"): ?>
      <th>Account Name</th>
    <?php endif; ?>
    <th>Date</th>
    <?php if (!in_array($report_type, array("Export Purchase Ledger","Domestic Purchase Ledger","Domestic Sale Ledger","Export Sale Ledger"))): ?>
    <th>Narration</th>
    <?php endif; ?>
    <th class='text-right'>Gross Wt</th>
    
    <th class='text-right'>Factory Melting</th>
    <th class='text-right'>Factory Fine</th>
    <?php if (!in_array($report_type, array("Export Purchase Ledger","Domestic Purchase Ledger","Domestic Sale Ledger","Export Sale Ledger"))): ?>
    <th>Melting</th>
    <?php endif; ?>
    <th class='text-right'>Fine</th>
    <?php if ($report_type == 'Gross Profit Report'): ?>
      <th class='text-right'>Amount</th>
    <?php endif; ?>
    <?php if ($report_type == 'Vadotar Report' || $report_type == 'Production Report'|| $report_type == 'Summary Report'): ?>
      <th class='text-right'>Vadotar</th>
      <th class='text-right'>%</th>
    <?php endif; ?>  
    <?php if ($report_type == 'Domestic Labour Ledger' || $report_type == 'Export Labour Ledger' ||$report_type == 'Account Ledger' ||$report_type == 'Purchase Labour Ledger' || $report_type == 'Vadotar Report' || $report_type == 'Purchase Sales Ledger'): ?>
      <th class='text-right'>Amount</th>
      <th class='text-right'>Usd Amount</th>
      <?php if($report_type == 'Purchase Sales Ledger'){ ?>
        <th class="text-right">Gross Weight</td>
        <th class="text-right">Chitti Account Name</td>
      <?php } ?>
      <?php if($report_type == 'Account Ledger'){ ?>
        <th class="text-right">Chitti Account Name</td>
      <?php } ?>
    
    <?php endif; ?>
  </tr>
</thead>