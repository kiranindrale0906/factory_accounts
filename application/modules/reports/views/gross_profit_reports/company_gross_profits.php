<div class="row">
  <div class="col-md-3">
    <div class="form-group container">
      <table class="table table-sm fixedthead table-default">
        <?php 
          foreach ($company_gross_profits as $index => $company_gross_profit) { ?>
            <tr>
              <td><b><?= ($company_gross_profit['site_name']=='') ? 'Internal Transfer' : $company_gross_profit['site_name']; ?></b></td>
              <td class="text-right"><?= four_decimal($company_gross_profit['vadotar'], '-') ?></td>
            </tr>
          <?php } 
        ?>
        <tr>
          <td><b>Total</b></td>
          <td class="text-right"><?= four_decimal($total_gross_profit['gross_profit'], '-') ?></td>
        </tr>
    </div>
  </div>
</div>