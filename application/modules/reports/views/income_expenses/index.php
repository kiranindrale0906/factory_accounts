<?php
  $this->load->view('reports/ledgers/report_header', array('header' => 'Income Expense Report'));
//  $this->load->view('reports/ledgers/search', array('url' => BASE_URL.'reports/income_expenses'));
?>
<div class="form-group container">

  <h5>
    Months:
  <?php $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
     $year=date('Y');
      foreach ($months as $month_key => $month) { ?>
        <a class="ml-5 <?= ($filter_month == $month_key) ? 'bold black underline' : '' ?>"
               href='<?= base_url() ?>reports/income_expenses?filter_month=<?= $month_key ?>&filter_year=<?=$year?>'><?= $month ?></a>

          <?php } ?>
     </h5>
   </div>

<div class="row">
  <?php 
//pd($dates);
    foreach ($dates as $index => $date) {$i = $index; ?>
      <div class="col-md-6">
        <div class="form-group container">
          <div class="table-responsive m-t-20">
            <table class="table table-sm fixedthead table-default">
              <h5>Income <?= ($date != 0) ? $date : '' ?></h5>
              <thead>
                <tr>
                  <th colspan="2">Income</th>
                  <th class="text-right">Amount (INR)</th>
                  <th class="text-right">Amount (USD)</th>
                  <th class="text-right">Amount (EURO)</th>
                </tr>
              </thead>
              <?php
                $income_amount_inr  = 0;
                $income_amount_usd  = 0;
                $income_amount_euro = 0;

                if(!empty($income[$date])) {
                  foreach ($income[$date] as $expense_account_name => $expense_accounts) {
                    $index = 0;
                    $total = $expense_accounts['total'];
                    unset($expense_accounts['total']);
                    foreach ($expense_accounts as $account_name => $amount) {
                      if (($amount['inr'] > 0) || ($amount['usd'] > 0) || ($amount['euro'] > 0)) continue;
                      $ind1 = rand();
                      $income_amount_inr = $income_amount_inr + $amount['inr'];
                      $income_amount_usd = $income_amount_usd + $amount['usd'];
                      $income_amount_euro = $income_amount_usd + $amount['euro'];

                      if(round($amount['inr'],2) != 0 || round($amount['usd'],2) != 0 || round($amount['euro'],2) != 0) {
                        if($index == 0) { ?>
                          <tbody class="toggle_div" >
                            <tr class="toggle_row" data-target-id=<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($expense_account_name.'income'.$i))));?>>
                              <td colspan="2" class="font-weight-bold"><?= $expense_account_name; ?>(<?= @$hod_name_expense_account[$expense_account_name]; ?>)</td>
                              <td class="text-right"><?php echo four_decimal(-1 * $total['inr'], '-'); ?></td>
                              <td class="text-right"><?php echo four_decimal(-1 * $total['usd'], '-'); ?></td>
                              <td class="text-right"><?php echo four_decimal(-1 * $total['euro'], '-'); ?></td>
                            </tr>
                          <?php } ?>
                          <tr class="sub_toggle_row toggle_content sub_toggle_id_<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($expense_account_name.'income'.$i))));?>" data-target-id="<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($account_name.'income'.$i))));?>" toggle-status=0>
                           <!--  <td><a href="<?= BASE_URL.'reports/account_ledgers/index?account_ledgers%5Bexpense_account%5D=&account_ledgers%5Baccount_id%5D='.$amount['account_id'].'&account_ledgers%5Bdate_from%5D=&account_ledgers%5Bdate_to%5D=&http_referer=&Submit=' ?>"><?= $account_name; ?></a></td> -->
                            <td colspan="2" class="td-click"><?= $account_name; ?></td>
                            <td class="text-right td-click"><?= four_decimal(-1 * $amount['inr'], '-') ?>  </td>
                            <td class="text-right td-click"><?= four_decimal(-1 * $amount['usd'], '-') ?>  </td>
                            <td class="text-right td-click"><?= four_decimal(-1 * $amount['euro'], '-') ?>  </td>
                          </tr>
                          <tr class="toggle_content sub_toggle_content_<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($account_name.'income'.$i))));?> closed_row_<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($expense_account_name.'income'.$i))));?>">
                            <!-- <th class="text-right">Date</th> -->
                            <th colspan="2" class="text-right">Voucher No</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                          </tr>
                          <?php foreach ($amount['vouchers'] as $index => $voucher) { ?>
                            <tr class="toggle_content sub_toggle_content_<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($account_name.'income'.$i))));?> closed_row_<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($expense_account_name.'income'.$i))));?>">
                              <td colspan="2" class="text-right"><?php echo @date("d-m-Y", strtotime($voucher['voucher_date'])); ?>&nbsp&nbsp&nbsp&nbsp<?php echo $voucher['voucher_number']; ?></td>
                              <td class="text-right"><?php echo four_decimal($voucher['amount']); ?></td>
                              <td class="text-right">
                                <?php if(!empty($voucher['document'])){ ?>
                                  <a target="_blank" href=<?= BASE_URL.'uploads/invoices/original/'.$voucher['document']?>>View Document
                                  </a>
                                <?php } ?>
                              </td>
                              <td class="text-right"></td>
                            </tr>
                          <?php }?>
                        <?php
                        $index++;
                        if($index == count($expense_accounts)) {?>
                          </tbody>
                        <?php }
                      }
                    }
                  }
                }
              ?> 
              <tr>
                <th colspan="2">Total</th>
                <th class="text-right"><?= four_decimal(-1 * $income_amount_inr, '-'); ?></th>
                <th class="text-right"><?= four_decimal(-1 * $income_amount_usd, '-'); ?></th>
                <th class="text-right"><?= four_decimal(-1 * $income_amount_euro, '-'); ?></th>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group container">
          <div class="table-responsive m-t-20">
            <table class="table table-sm fixedthead table-default">
              <h5 class="bold">Expense</h5>
              <thead>
                <tr>
                  <th colspan="2">Expense</th>
                  <th class="text-right">Amount (INR)</th>
                  <th class="text-right">Budget Amount</th>
                  <th class="text-right">Total Amount</th>
                </tr>
              </thead>
              <?php
                $expense_amount_inr  = 0;
                $expense_amount_usd  = 0;
                $expense_amount_euro = 0;

                if(!empty($expense[$date])) {
                  foreach ($expense[$date] as $expense_account_name => $expense_accounts) {
                    $index = 0;
                    $total = $expense_accounts['total'];
                    unset($expense_accounts['total']);
                    foreach ($expense_accounts as $account_name => $amount) {
                      // if (($amount['inr'] < 0) || ($amount['usd'] < 0) || ($amount['euro'] < 0)) continue;
                      if($amount['total_budget']<0){
                        $style_color="color:red";
                      }else{
                        $style_color="color:green";
                      }
                      $ind = rand();
                      $expense_amount_inr = $expense_amount_inr + $amount['inr'];
                      $expense_amount_usd = $expense_amount_usd + $amount['budget'];
                      $expense_amount_euro = $expense_amount_usd + $amount['total_budget'];

                      if(round($amount['inr'],2) != 0 || round($amount['usd'],2) != 0 || round($amount['euro'],2) != 0) {
                        if($index == 0) { ?>
                          <tbody class="toggle_div" >
                            <tr class="toggle_row" data-target-id=<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($expense_account_name.'expense'.$i))));?>>
                              <td colspan="2" class="font-weight-bold"><?= $expense_account_name; ?> <p style="color: #ff0000;"></p></td>
                              <td class="text-right"><?php echo four_decimal($total['inr'], '-'); ?></td>
                              <td class="text-right"><?php echo four_decimal($total['budget'], '-'); ?></td>
                              <td class="text-right" style="<?=$style_color;?>"><?php echo four_decimal($total['total_budget'], '-'); ?></td>
                            </tr>
                            <?php } ?>
                            <tr class="sub_toggle_row toggle_content sub_toggle_id_<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($expense_account_name.'expense'.$i))));?>" data-target-id="<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($account_name.'expense'.$i))));?>" toggle-status=0>
                           <!--    <td><a href="<?= BASE_URL.'reports/account_ledgers/index?account_ledgers%5Bexpense_account%5D=&account_ledgers%5Baccount_id%5D='.$amount['account_id'].'&account_ledgers%5Bdate_from%5D=&account_ledgers%5Bdate_to%5D=&http_referer=&Submit=' ?>"><?= $account_name; ?></a></td> -->
                              <td colspan="2" class="td-click"><?= $account_name; ?></td>
                              <td class="text-right td-click"><?= four_decimal($amount['inr'], '-'); ?></td>
                              <td class="text-right td-click"><?= four_decimal($amount['budget'], '-'); ?></td>
                              <td class="text-right td-click" style="<?=$style_color;?>"><?= four_decimal($amount['total_budget'], '-'); ?></td>
                            </tr>
                            <tr class="toggle_content sub_toggle_content_<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($account_name.'expense'.$i))));?> closed_row_<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($expense_account_name.'expense'.$i))));?>">
                              <!-- <th class="text-right">Date</th> -->
                            <th colspan="2" class="text-right">Account Name</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                            </tr>
                            <?php foreach ($amount['vouchers'] as $index => $voucher) { ?>
                              <tr class="toggle_content sub_toggle_content_<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($account_name.'expense'.$i))));?> closed_row_<?php echo strtolower(preg_replace("/[\s.,&()']+/", '', trim(strtolower($expense_account_name.'expense'.$i))));?>">
                               <td colspan="2" class="text-right"><?php //echo @date("d-m-Y", strtotime($voucher['voucher_date'])); ?>
							         &nbsp&nbsp&nbsp&nbsp
								<?php //echo $voucher['voucher_number']; ?>
    								 &nbsp&nbsp&nbsp&nbsp
								<?php echo $voucher['account_name']; ?>
		               </td>
                                <td class="text-right"><?php echo four_decimal($voucher['amount']); ?></td>
                                <td class="text-right">
                                  <?php //if(!empty($voucher['document'])){ ?>
                                   <!-- <a target="_blank" href=<?//= BASE_URL.'uploads/invoices/original/'.$voucher['document']?>>View Document-->
                                    <a target="_blank" href=<?='https://apr2024-expenses.ar-gold.in/reports/income_expenses/view/1?account_name='.rawurlencode($voucher['account_name']).'&hod='.rawurlencode($expense_account_name).'&expenses_account='.rawurlencode($account_name).'&account_id='.$amount['account_id'].'&voucher_date='.$voucher['voucher_date'].'&period='.$period?>>View</a>
                                  <?php //} ?>
                                </td>
                                <td class="text-right"></td>
                              </tr>
                            <?php }?>
                        <?php
                        $index++;
                        if($index == count($expense_accounts)) {?>
                          </tbody>
                        <?php }
                      }
                    }
                  }
                }
              ?>
              <tr>
                <th colspan="2">Total</th>
                <th class="text-right"><?= four_decimal($expense_amount_inr, '-'); ?></th>
                <th class="text-right"><?= four_decimal($expense_amount_usd, '-'); ?></th>
                <th class="text-right"><?= four_decimal($expense_amount_euro, '-'); ?></th>
              </tr>
            </table>
          </div>
        </div>
      </div>
    <?php
    }
  ?>
</div>
