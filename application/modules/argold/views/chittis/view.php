<style>
@media print {    
  .no-print, .no-print * {
    display: none !important;
  }
}
</style>
<div class="row ">
  <div class="col-md-3">
   <h4 style="margin-left:45%" class="heading">Chitti #<?= $record['id']; ?></h4>
  </div>
  <div class="col-md-8 text-right">
  <a  href="<?=ADMIN_PATH.'argold/metal_issue_chitties/edit/'. $record['id']?>" class='btn bg_blue white no-print'>create metal receipt</a>
  <!-- <a  href="<?//=ADMIN_PATH.'argold/chittis/view/'. $record['id'].'?group_by=1'?>" class='btn bg_blue white no-print'>Melting Detail In Group</a> -->
  <a  href="<?=ADMIN_PATH.'argold/chittis/view/'. $record['id'].'?group_by=1&item_code=1'?>" class='btn bg_blue white no-print'>Melting Detail In Group with Item code</a>
  </div>
  <div class="col-md-1 text-right">
  <?php if($record['chitti_hide'] == 0) {  
        echo getHttpButton('HIDE', base_url().'argold/chitti_hides/update/'.$record['id'].'?from=view', 'btn bg_blue white no-print');
      } elseif($record['chitti_hide'] == 1) {
        echo getHttpButton('SHOW', base_url().'argold/chitti_hides/update/'.$record['id'].'?from=view', 'btn bg_blue white no-print');
      }
  ?>
  
  </div>
</div>
<div style="max-width:45%; margin-left:10%">
  <table class="table table-sm">
    <tr>
      <td><h6><?=$chittis_details['account_name']?></h6></td>
      <td class=""><h6><?= date('d-m-Y',strtotime($record['date']))?></h6></td>
      <td rowspan="3" style="text-align: center">
        <?php 
             $string=$record['id'];      
             $qr_code = generate_qrcode($string,'72');
             echo $qr_code;
        ?>
      </td>
    </tr><tr>
      <td>Sale Type</td><td class=""><h6><?= $record['sale_type'] ?></h6></td>
    </tr>
    <?php 

    if (!empty($record['no_of_packets']) && $record['no_of_packets'] > 0) { ?>
      <tr>
        <td>No of Packets</td><td class=""><h6><?=round($record['no_of_packets'])?></h6></td>
      </tr>
    <?php } ?>
    <?php if (!empty($record['packet_gross_weight']) && $record['packet_gross_weight'] > 0) { ?>
      <tr>
        <td>Packet Gross Weight</td><td class=""><h6><?=four_decimal($record['packet_gross_weight'])?></h6></td>
      </tr>
    <?php } ?>
  </table>
  
  </div>      
        

<div style="max-width:45%; margin-left:10%">
  <?php $this->load->view('chitti_details/viewlist'); ?>
</div>
</div>

<?php 
  if ($record['sale_type'] == 'Labour'){
    // if($record['account_name']=='MALABAR GOLD'){
    // $gst_rate = 9;
    // }else{
    $gst_rate = 2.5;
    // }
  }
  else{
    // if($record['account_name']=='MALABAR GOLD'){
    // $gst_rate = 9;
    // }else{
    $gst_rate = 1.5;
    // }
  }

?>

<div style="max-width:45%; margin-left:10%; page-break-after:avoid">
  <table class="table table-sm">
    <?php if($this->router->class != 'chitti_domestics'){ ?>
    <tr>
      <td>Weight</td><td class="text-right"><h6><?=four_decimal($record['credit_weight'])?></h6></td>
    </tr><tr>
      <td>Actual Weight</td><td class="text-right"><h6><?=four_decimal($record['actual_weight'])?></h6></td>
    </tr><tr>
      <td>Expected Weight</td><td class="text-right"><h6><?=four_decimal($record['expected_weight'])?></h6></td>
    </tr><tr>
      <td>Diff Weight</td><td class="text-right"><h6><?=four_decimal($record['diff_weight'])?></h6></td>
    </tr><tr>
      <td>Rate</td><td class="text-right"><h6><?=four_decimal($record['rate'])?></h6></td>
    </tr>
    <tr class=<?=($record['stone_amount']!=0)?'':'no-print'?>>
      <td class=<?=($record['stone_amount']!=0)?'':'no-print'?>>Stone Amount</td>
      <td class=<?=($record['stone_amount']!=0)?'text-right':'text-right no-print'?>><h6><?=four_decimal($record['stone_amount'])?></h6></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">Taxable Amount</td>
      <td class="text-right no-print"><h6><?=four_decimal($record['taxable_amount'])?></h6></td>
    </tr>
    <?php if(!empty($record['hallmark_amount']) && $record['hallmark_amount']!=0){ ?>
    <tr class="">
      <td class="">Hallmark rate</td>
      <td class="text-right "><?=four_decimal($record['hallmark_rate'])?></td>
    </tr>
    <tr class="">
      <td class="">Hallmark Quantity</td>
      <td class="text-right "><?=four_decimal($record['hallmark_quantity'])?></td>
    </tr>
    <tr class="">
      <td class="">Hallmark Amount</td>
      <td class="text-right "><?=four_decimal($record['hallmark_amount'])?></td>
    </tr>
    <tr class="">
      <td class="">Hallmark Taxable Amount </td>
      <td class="text-right "><?=four_decimal($record['hallmark_taxable_amount'])?></td>
    </tr>
  <?php }?>
    <tr class="no-print">
      <td class="no-print">CGST Amount (<?= $gst_rate ?>%)</td>
      <td class="text-right no-print"><?=four_decimal($record['cgst_amount'])?></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">SGST Amount (<?= $gst_rate ?>%)</td>
      <td class="text-right no-print"><?=four_decimal($record['sgst_amount'])?></td>
    </tr>
    <?php if ($record['sale_type'] != 'Labour') { 

      $tcs_rate=0;
      if(strtotime($record['created_at'])>strtotime('2021-03-30') && strtotime($record['created_at'])<strtotime('2021-07-301')){
        $tcs_rate=0.1;
      }elseif(strtotime($record['created_at'])<=strtotime('2021-03-30')){
        $tcs_rate=0.075;
      } else
        $tcs_rate = 0;

      ?>
      <tr class="no-print">
        <td class="no-print">Total Amount</td>
        <td class="text-right no-print"><?php if(!empty($record['hallmark_taxable_amount'])){
          echo four_decimal(  $record['hallmark_taxable_amount'] + $record['cgst_amount']+ $record['sgst_amount']);
        }else{
          echo four_decimal($record['hallmark_taxable_amount'] + $record['cgst_amount']+ $record['sgst_amount']);
        }?></td>
      </tr>
      
      <tr class="no-print">
        <td class="no-print">TCS</td>
        <td class="text-right no-print"><?=four_decimal(($record['taxable_amount']
                                                               + $record['cgst_amount']
                                                               + $record['sgst_amount']) * $tcs_rate / 100)?></td>
      </tr>
    <?php } ?>
    <?php if($this->router->class == 'chitti_exports'){ ?>
     <tr>
      <td>USD Rate </td><td class="text-right"><h6><?=four_decimal($record['usd_rate'])?></h6>
      </td>
    </tr>
    <tr>
      <td>Ounce rate </td><td class="text-right"><h6><?=four_decimal($record['ounce_rate'])?></h6>
      </td>
    </tr>
    <tr>
      <td>Taxable USD Amount </td><td class="text-right"><h6><?=four_decimal($record['taxable_usd_amount'])?></h6>
      </td>
    </tr>
    <tr>
      <td>Premium USD Amount </td><td class="text-right"><h6><?=four_decimal($record['premium_usd_amount'])?></h6>
      </td>
    </tr>
    <tr>
      <td>Labour USD Amount </td><td class="text-right"><h6><?=four_decimal($record['labour_usd_amount'])?></h6>
      </td>
    </tr>
    <tr>
      <td>Freight USD Amount </td><td class="text-right"><h6><?=four_decimal($record['freight_usd_amount'])?></h6>
      </td>
    </tr> 
    <tr>
      <td>Grand Total</td><td class="text-right"><h6><?=four_decimal(($record['taxable_usd_amount']+$record['premium_usd_amount']+$record['labour_usd_amount']+$record['freight_usd_amount'])*$record['usd_rate'])?></h6></td>
    </tr>
  <?php }else{?>
    <tr>
      <td>Grand Total</td><td class="text-right"><h6><?=four_decimal($record['debit_amount'])?></h6></td>
    </tr>
  <?php }}else{
    $sum_rate=$sum_rate_amount=0;
    foreach ($metal_voucher_details as $index => $metal_voucher_detail) {
      $sum_rate += $metal_voucher_detail['rate'];
      $sum_rate_amount += ($metal_voucher_detail['rate']*$metal_voucher_detail['credit_weight']);
       
    }

    ?>
    <tr>
      <td>Taxable Amount</td><td class="text-right"><h6><?=four_decimal($sum_rate_amount)?></h6></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">CGST Amount (<?= $gst_rate ?>%)</td>
      <td class="text-right no-print"><?=four_decimal($sum_rate_amount*$gst_rate/100)?></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">SGST Amount (<?= $gst_rate ?>%)</td>
      <td class="text-right no-print"><?=four_decimal($sum_rate_amount*$gst_rate/100)?></td>
    </tr>
  <?php }?>
  </table>
  <div class="col-md-3">
   <h4 style="margin-left:45%" class="heading"><?= @$record['narration']; ?></h4>
  </div>
  <?php $this->load->view('chitti_details/empty_packet_view'); ?>
</div>

<style type="text/css">

  @page { 
    margin: 0mm; 
    size: 4cm 6cm ;
    size: landscape;
  }
</style>


