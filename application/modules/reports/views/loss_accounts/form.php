<div class="table-responsive">
  <table class="table table-sm table-default">
    <thead>
      <tr>
        <th class="">Type of Loss Out</th>
        <th class="text-right">Fine</th>
        </tr>
    </thead>
    <tbody>
    <?php 
      $sum_weight=$sum_fine=0;
     foreach ($loss_categories as $index => $loss_category) {
      $sum_fine+=$loss_category['fine'];
      ?>
      <tr>
        <td class=""><a href="<?=base_url()?>reports/loss_account_details?category=<?=$index ?>"><?=$index?></a></td>
        <td class="text-right"><?=$loss_category['fine'] ?></td>
      </tr>

    <?php }?>
      <tr class="bg_gray bold">
    <td>Total</td>
    <td class="text-right"><?=$sum_fine?></td>
  </tr>
    </tbody>
  </table>
</div>