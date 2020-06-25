<div class="row">
  <div class="col-md-3">
    <div class="form-group container">
      <table class="table table-sm fixedthead table-default">
        <?php 
          $vadotar = 0;
          foreach ($company_vadotars as $index => $company_vadotar) { 
            $vadotar = $vadotar + $company_vadotar['vadotar'] ?>
            <tr>
              <td><b><?= str_replace(' Finished Goods', '', $company_vadotar['receipt_type']); ?></b></td>
              <td class="text-right"><?= four_decimal($company_vadotar['vadotar'], '-') ?></td>
            </tr>
          <?php } 
        ?>
        <tr>
          <td><b>AR Gold</b></td>
          <td class="text-right"><?= four_decimal($total_vadotar['vodator'] - $vadotar, '-') ?></td>
        </tr>
        <tr>
          <td><b>Total</b></td>
          <td class="text-right"><?= four_decimal($total_vadotar['vodator'], '-') ?></td>
        </tr>
    </div>
  </div>
</div>