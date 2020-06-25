<thead class="bg_gray">
  <tr>
    <?php if ($report != 'account ledger'): ?>
      <th>Account Name</th>
    <?php endif; ?>
    <th>Date</th>
    <th>Narration</th>
    <th class='text-right'>Gross Wt</th>
    <th class='text-right'>Factory Melting</th>
    <th class='text-right'>Factory Fine</th>
    <th class='text-right'>Melting</th>
    <th class='text-right'>Fine</th>
    <?php if ($report != 'account ledger'): ?>
      <th class='text-right'>Vadotar</th>
    <?php endif; ?>
  </tr>
</thead>