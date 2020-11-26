<div class="row">
  <div class="col-md-3">
    <div class="form-group container">
      <table class="table table-sm fixedthead table-default">
        <?php 
          foreach ($company_vadotars as $index => $company_vadotar) { ?>
            <tr>
              <td><b><?= $company_vadotar['site_name']; ?></b></td>
              <td class="text-right"><?= four_decimal($company_vadotar['vadotar'], '-') ?></td>
            </tr>
          <?php } 
        ?>
        <tr>
          <td><b>Total</b></td>
          <td class="text-right"><?= four_decimal($total_vadotar['vodator'], '-') ?></td>
        </tr>
    </div>
  </div>
</div>