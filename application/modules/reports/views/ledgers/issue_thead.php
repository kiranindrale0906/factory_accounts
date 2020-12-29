<thead class="bg_gray">
  <tr>
    <?php if ($report_type == 'Vadotar Report'): ?>
      <th>Type</th>
    <?php endif; ?>
    <?php if ($report_type != 'Account Ledger'): ?>
      <th>Account Name</th>
    <?php endif; ?>
    <th>Date</th>
    <th>Narration</th>
    <th class='text-right'>Gross Wt</th>
    <th class='text-right'>Factory Melting</th>
    <th class='text-right'>Factory Fine</th>
    <th class='text-right'>Issue Melting</th>
    <th class='text-right'>Issue Fine</th>
    <?php if ($report_type == 'Vadotar Report' || $report_type == 'Production Report'): ?>
      <th class='text-right'>Vadotar</th>
      <th class='text-right'>%</th>
    <?php elseif ($report_type == 'Account Ledger'): ?>
      <th class='text-right'>Issue Amount</th>
    <?php endif; ?>
  </tr>
</thead>