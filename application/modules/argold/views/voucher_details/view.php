<h5 class="heading noprint">Metal Voucher View</h5>
<?php if($record['chitti_id']==0){?>
<?= getHttpButton('DELETE', base_url().'argold/voucher_details/delete/'.$record['id'], 'float-right btn-danger ml-5'); ?>
<?php }?>
<div class="row">
  <div class="col-md-6 ">
    <div class="form-group container">
      <p><h6>AC Name: <?=$record['account_name']?> </h6></p>
      <p><h6>Voucher No: <?=$record['voucher_number']?> </h6></p>
      <p><h6>Item Name: <?=$record['narration']?> </h6></p>
      <p><h6>Receipt Type: <?=$record['receipt_type']?></h6></p>
      <?php if (!empty($record['sale_type'])) { ?>
        <p><h6>Sale Type: <?=$record['sale_type']?></h6></p>
      <?php }?>
      <?php if($record['receipt_type']=='Daily Drawer'){?>
        <p><h6>Daily Drawer Type: <?=$record['dd_type']?></h6></p>
      <?php }?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group container">
      <p><h6>Debit Weight :<?=$record['debit_weight']?></h6></p>
      <p><h6>Purity :<?=$record['purity']?></h6></p>
      <p><h6>Fine :<?=$record['fine']?></h6></p>
      <p><h6>Factory Purity :<?=$record['factory_purity']?></h6></p>
      <p><h6>Factory Fine :<?=$record['factory_fine']?></h6></p>
      <p><h6>Date : <?=date('d-m-Y',strtotime($record['created_at']))?></h6></p>
    </div>
  </div>
</div>

<hr class="">
<h6 class="heading ">Metal Issue Voucher Details</h6>
<?php 
  $this->load->view('voucher_details/viewlist'); 
  
  if(!empty($refresh_details)) { ?>
    <hr class="">
    <h6 class="heading ">Refresh Details</h6>
    <?php $this->load->view('voucher_details/refresh_viewlist'); 
  }
?>

<?php 
  if ($record['gold_rate'] > 0) { 
    $tax_fields = get_tax_fields($record['factory_fine'], $record['fine'], $record['sale_type'], $record['gold_rate'], $record['gold_rate_purity']);
    ?>
    <div class="row">
      <div class="col-md-6">
      </div>
      <div class="col-md-6">
        <div class="form-group container">
          <table class="table table-sm">
            <tr>
              <td>Weight</td><td class="text-right"><h6><?=four_decimal($tax_fields['weight'])?></h6></td>
            </tr><tr>
              <td>Rate (<?= four_decimal($tax_fields['gold_rate_purity']) ?>%)</td><td class="text-right"><h6><?=four_decimal($tax_fields['gold_rate'])?></h6></td>
            </tr><tr>
              <td>Taxable Amount</td><td class="text-right"><h6><?=four_decimal($tax_fields['taxable_amount'])?></h6></td>
            </tr><tr>
              <td>CGST Amount</td><td class="text-right"><h6><?=four_decimal($tax_fields['cgst_amount'])?></h6></td>
            </tr><tr>
              <td>SGST Amount</td><td class="text-right"><h6><?=four_decimal($tax_fields['sgst_amount'])?></h6></td>
            </tr><tr>
              <td>Total Amount</td><td class="text-right"><h6><?=four_decimal($tax_fields['total_amount'])?></h6></td>
            </tr><tr>
              <td>TCS</td><td class="text-right"><h6><?=four_decimal($tax_fields['tcs_amount']) ?></h6></td>
            </tr><tr>
              <td>Grand Total</td><td class="text-right"><h6><?=four_decimal($tax_fields['grand_total'])?></h6></td>
            </tr>

          </table>
        </div>
      </div>
    </div>
  <?php } 
?>