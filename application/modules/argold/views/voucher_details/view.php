<h5 class="heading noprint">Voucher View</h5>
<?php
  $voucher_type=str_replace(' ', '_', $record['voucher_type']).'s';
  ?>
<?= getHttpButton('DELETE', base_url().'argold/voucher_details/delete/'.$record['id'].'?type='.$voucher_type, 'float-right btn-danger ml-5'); ?>
<div class="row">
  <div class="col-md-6 ">
    <div class="form-group container">
      <p><h6>Chitti: <?=$record['chitti_id']?> </h6></p>
      <p><h6>Packet no: <?=$record['packet_no']?> </h6></p>
      <p><h6>IS EXPORT: <?=$record['is_export']?> </h6></p>
      <p><h6>AC Name: <?=$record['account_name']?> </h6></p>
      <p><h6>Voucher Type: <?=$record['voucher_type']?> </h6></p>
      <p><h6>Voucher No: <?=$record['voucher_number']?> </h6></p>
      <?php if(in_array($record['voucher_type'], array('rate cut receipt voucher','rate cut issue voucher','metal receipt voucher','metal issue voucher'))){?>
      <p><h6>Item Name: <?=$record['narration']?> </h6></p>
      <?php }?>
      <?php if(in_array($record['voucher_type'], array('rate cut receipt voucher','rate cut issue voucher','metal receipt voucher','metal issue voucher'))){?>
     
      <p><h6>Receipt Type: <?=$record['receipt_type']?></h6></p>
      <?php }?>
      <p><h6>Description: <?=$record['description']?></h6></p>
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

    <?php if(in_array($record['voucher_type'], array('rate cut receipt voucher','metal receipt voucher','opening stock voucher'))){?>
      <p><h6>Debit Weight :<?=$record['debit_weight']?></h6></p>
    <?php }if(in_array($record['voucher_type'], array('rate cut receipt voucher','cash issue voucher'))){?> 
      <p><h6>Credit Amount :<?=$record['credit_amount']?></h6></p>
    <?php }if(in_array($record['voucher_type'], array('rate cut issue voucher','cash receipt voucher'))){?> 
      <p><h6>Debit Amount :<?=$record['debit_amount']?></h6></p>
    <?php } if(in_array($record['voucher_type'], array('rate cut issue voucher','opening stock voucher'))){?>  
      <p><h6>Credit Weight :<?=$record['credit_weight']?></h6></p>
    <?php } if(in_array($record['voucher_type'], array('rate cut receipt voucher','rate cut issue voucher','metal receipt voucher'))){?>  
      <p><h6>Gold Amount :<?=$record['gold_rate']?></h6></p>
    <?php } if(in_array($record['voucher_type'], array('metal issue voucher'))){?>  
      <p><h6>Credit Weight :<?=$record['credit_weight']?></h6></p>
    <?php } if(in_array($record['voucher_type'], array('rate cut receipt voucher','rate cut issue voucher'))){?>  
      <p><h6>Gold Rate Purity :<?=$record['gold_rate_purity']?></h6></p>
    <?php }?> 
    <?php if(in_array($record['voucher_type'], array('rate cut receipt voucher','rate cut issue voucher','metal receipt voucher','metal issue voucher'))){?>  
      <p><h6>Purity :<?=$record['purity']?></h6></p>
    <?php }?>
    <?php if(in_array($record['voucher_type'], array('rate cut receipt voucher','rate cut issue voucher','metal receipt voucher','metal issue voucher'))){?>
      <p><h6>Fine :<?=$record['fine']?></h6></p>
    <?php } ?>
    <?php if(in_array($record['voucher_type'], array('rate cut receipt voucher','rate cut issue voucher','metal receipt voucher','metal issue voucher'))){?>
      <p><h6>Factory Purity :<?=$record['factory_purity']?></h6></p>
    <?php }?>
    <?php if(in_array($record['voucher_type'], array('rate cut receipt voucher','rate cut issue voucher','metal receipt voucher','metal issue voucher'))){?>
      <p><h6>Factory Fine :<?=$record['factory_fine']?></h6></p>
    <?php }?>
    <?php if(in_array($record['voucher_type'], array('cash receipt voucher','cash issue voucher'))){?>
      <p><h6>Taxable Amount:<?=$record['taxable_amount']?></h6></p>
      <p><h6>CGST Amount :<?=$record['cgst_amount']?></h6></p>
      <p><h6>SGST Amount :<?=$record['sgst_amount']?></h6></p>
      <p><h6>TCS Amount :<?=$record['tcs_amount']?></h6></p>
    <?php }?>
      <p><h6>Date : <?=date('d-m-Y',strtotime($record['created_at']))?></h6></p>
    </div>
  </div>
</div>
<?php if(in_array($record['voucher_type'], array('metal receipt voucher'))){?>
<hr class="">
<h6 class="heading ">Metal Issue Voucher Details</h6>
<?php 
  $this->load->view('voucher_details/viewlist'); 
  
  if(!empty($refresh_details)) { ?>
    <hr class="">
    <h6 class="heading ">Refresh Details</h6>
    <?php $this->load->view('voucher_details/refresh_viewlist'); 
  }}
?>

<?php
if(in_array($record['voucher_type'], array('metal receipt voucher','metal issue voucher','rate cut issue voucher','rate cut receipt voucher'))){
  if ($record['gold_rate'] > 0) { 
    $tax_fields = get_tax_fields($record['factory_fine'], $record['fine'], $record['sale_type'], $record['gold_rate'], $record['gold_rate_purity'],$record['created_at'],$record['is_export']);
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
  <?php } }
?>
