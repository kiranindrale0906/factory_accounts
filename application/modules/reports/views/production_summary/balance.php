<thead class="bg_gray bold">
  <tr>
    <td>Balance</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>    
    <td></td>
    <td></td>
    <td></td>
    <td class='text-right'><?= four_decimal(@$production_total[$group]['weight'] - @$refresh_total[$group]['weight']); ?></td>
    <td class='text-right'><?= four_decimal(@$production_total[$group]['vadotar'] - @$refresh_total[$group]['vadotar']); ?></td>
  </tr>
</thead>