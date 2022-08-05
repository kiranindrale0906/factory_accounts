<div class="row">
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>Liabilities</th>
              <th class="text-right">Amount</th>
              <th class="text-right">Usd Amount</th>
              <th class="text-right">Fine</th>
              <th class="text-right">Vadotar</th>
            </tr>
          </thead>
          <?php
              $liabilities_fine = 0; 
              $liabilities_vadotar = 0;  
              $liabilities_amount = 0;
              $liabilities_usd_amount = 0;
              if(!empty($trial_balance_records)) {
                foreach ($trial_balance_records as $record) {
                  if (   ($record['account_name'] != 'VADOTAR')
                      || ($record['account_name'] == 'Tounch Loss Fine')) continue;

                  if ($record['account_name'] == 'PURCHASE ACCOUNT') $profit_and_loss['purchase_account'] = $record;
                  if ($record['account_name'] == 'MAIN VADOTAR')     $profit_and_loss['main_vadotar'] = $record;

                  $liabilities_vadotar = $liabilities_vadotar + $record['vadotar'];
                  $liabilities_fine = $liabilities_fine + $record['fine']; 
                  $liabilities_amount = $liabilities_amount + $record['amount']; 
                  $liabilities_usd_amount = $liabilities_usd_amount + @$record['usd_amount']; 
                  if(round($record['fine'],2)!=0){
                    if($record['account_name']!="MAIN VADOTAR"){
                  ?>

                  <tr>
                    <td><?=$record['account_name']; ?>
                      
                      <?php if ($loss_account==1 && !empty($loss_date)){
                        ?>
                        <a href=<?= base_url()."argold/unrecovarable_account_records/store?from=view&account_name=".urlencode($record['unrecoverable_account_name'])."&credit_weight=".four_decimal($record['fine'])."&narration=Unrecovarable&factory=".urlencode($record['account_name'])."&parent_id=".$record['id']."&voucher_date=".$loss_date ?> target='_blank' onclick="return confirm('Do you want to add this in Unrecovarable?')" ><?=$record['unrecoverable_account_name']?></a><?php echo'('.four_decimal($record['fine'], '-').')'; ?>
                      <?php }?>  
                    </td>
                    <td class="text-right"><?= four_decimal(($record['amount']), '-') ?>  </td>
                    <td class="text-right"><?= four_decimal((@$record['usd_amount']), '-') ?>  </td>
                    <td class="text-right"><?= four_decimal(($record['fine']), '-'); ?></td>
                    <td class="text-right"><?= four_decimal(($record['vadotar']), '-') ?>  </td>
                  </tr>
                <?php }}}
              } 
          ?>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal($liabilities_amount, '-'); ?></th>
            <th class="text-right"><?= four_decimal($liabilities_usd_amount, '-'); ?></th>
            <th class="text-right"><?= four_decimal($liabilities_fine, '-'); ?></th>          
            <th class="text-right"><?= four_decimal($liabilities_vadotar, '-'); ?></th>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <div class="table-responsive m-t-20">
        <table class="table table-sm fixedthead table-default">
          <thead>
            <tr>
              <th>Assets</th>
              <th class="text-right">Amount</th>
              <th class="text-right">Usd Amount</th>
              <th class="text-right">Fine</th>
              <th class="text-right">Vadotar</th>
            </tr>
          </thead>
          <?php 
              $assets_fine = 0;  
              $assets_vadotar = 0;  
              $assets_amount = 0;  
              $assets_usd_amount = 0;  
              if(!empty($trial_balance_records)) {
                foreach ($trial_balance_records as $record) {
                  if (  ($record['account_name'] != 'Tounch Loss Fine')
                      || ($record['account_name'] == 'VADOTAR')) continue;

                  if ($record['account_name'] == 'SALES ACCOUNT') $profit_and_loss['sales_account'] = $record;
                if (!empty($sales_accounts)) $profit_and_loss['sale_gst_accounts'] = $sales_accounts;
                    
                  $assets_vadotar = $assets_vadotar + $record['vadotar'];
                  $assets_fine = $assets_fine + $record['fine'];
                  $assets_amount= $assets_amount + $record['amount'];
                  $assets_usd_amount= $assets_usd_amount + @$record['usd_amount'];
                  if(round($record['fine'],2)!=0){
                   ?>

                  <tr>
                    <td><?= $record['account_name']; ?>
                      <?php if ($loss_account==1 && !empty($loss_date)) { ?>
                        <a href=<?= base_url()."argold/unrecovarable_account_records/store?from=view&account_name=".urlencode($record['account_name'])."&credit_weight=".four_decimal(-1 * $record['fine'])."&narration=".urlencode($record['account_name'])."&factory=".urlencode($record['unrecoverable_account_name'])."&parent_id=".$record['id']."&voucher_date=".$loss_date ?> 
                          target='_blank' onclick="return confirm('Do you want to add this in Unrecovarable?')" ><?=@$record['unrecoverable_account_name']?></a><?php echo'('.four_decimal(-1 * $record['fine'], '-').')'; ?>
                      <?php } ?>  
                    </td>
                    <td class="text-right"><?= four_decimal(-1 * $record['amount'], '-') ?>  </td>
                    <td class="text-right"><?= four_decimal(-1 * @$record['usd_amount'], '-') ?>  </td>
                    <td class="text-right"><?= four_decimal(-1 * $record['fine'], '-') ?></td>
                    <td class="text-right"><?= four_decimal(-1 * $record['vadotar'], '-') ?>  </td>
                  </tr>
                <?php }
                }
              } 
          ?>
          <tr>
            <th>Total</th>
            <th class="text-right"><?= four_decimal(-1 * $assets_amount, '-'); ?></th>          
            <th class="text-right"><?= four_decimal(-1 * $assets_usd_amount, '-'); ?></th>          
            <th class="text-right"><?= four_decimal(-1 * $assets_fine, '-'); ?></th>          
            <th class="text-right"><?= four_decimal(-1 * $assets_vadotar, '-'); ?></th>
          </tr>
          <?php if ($loss_account==1): ?>
            <tr>
              <th>Balance</th>
              <th class="text-right"><?= four_decimal(-1 * $assets_amount - $liabilities_amount, '-'); ?></th>          
              <th class="text-right"><?= four_decimal(-1 * $assets_usd_amount - $liabilities_usd_amount, '-'); ?></th>          
              <th class="text-right"><?= four_decimal(-1 * $assets_fine - $liabilities_fine, '-'); ?></th>          
              <th class="text-right"><?= four_decimal(-1 * $assets_vadotar - $liabilities_vadotar, '-'); ?></th>
            </tr>
          <?php endif; ?>
        </table>
        <?php $profit_and_loss['pending_vadotar'] = ($liabilities_vadotar + $assets_vadotar); ?>
      </div>      
    </div>
  </div>  
</div>

<?php if ($loss_account==0): ?>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group container">
        <table class="table table-sm fixedthead table-default">
          <tr>
            <td><b>Liabilities: </b></td>
            <td class="text-right"><?= four_decimal($liabilities_fine, '-') ?></td>
            </tr>
          <tr>
            <td><b>Vadotar: </b></td>
            <td class="text-right"><?= four_decimal(-1 * ($liabilities_vadotar + $assets_vadotar));  ?></td>
          </tr>
          <tr>
            <td><b>Assets: </b></td>
            <td class="text-right"><?= four_decimal(-1 * $assets_fine, '-');  ?></td>
          </tr>
          <tr>
            <td><b>Total: </b></td>
            <td class="text-right"><?= four_decimal(-1 * ($liabilities_fine + $assets_fine - $liabilities_vadotar - $assets_vadotar), '-');  ?></td>
          </tr>
          <tr>
            <td><b>Closing Stock: </b></td>
            <td class="text-right"><b><?= four_decimal($assets_fine + $liabilities_fine - $liabilities_vadotar - $assets_vadotar, '-');  ?></b></td>
          </tr>
        </table>
      </div>
    </div>
    <?php $this->load->view('trial_balances/factory_balance'); ?>
  </div>
<?php endif; ?>

<?php 
  if ($_SESSION['all_details']==1) { 
    $this->load->view('trial_balances/profit_and_loss', array('profit_and_loss' => $profit_and_loss));
    $this->load->view('trial_balances/rhodium');
    
    // if (!empty($purchase_account_export)) $profit_and_loss['purchase_account_export_Sale'] = $purchase_account_export_Sale;
    // if (!empty($purchase_account_domestic)) $profit_and_loss['purchase_account_domestic'] = $purchase_account_domestic;
    //$this->load->view('trial_balances/profit_and_loss_gst', array('profit_and_loss' => $profit_and_loss));
  } 
?>