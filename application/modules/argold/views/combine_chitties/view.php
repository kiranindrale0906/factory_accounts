<style>
@media print {    
  .no-print, .no-print * {
    display: none !important;
  }
}
</style>
<div class="row ">
  <div class="col-md-3">
   <h4 style="margin-left:45%" class="heading">Combine Chitti #<?= $record['id']; ?></h4>
  </div>
</div>
<div style="max-width:45%; margin-left:10%">
  <table class="table table-sm">
    <tr>
      <td><h6>Empty Bag Total Weight</h6></td><td class="text-right"><h6><?=($record['empty_bag_weight']*$record['empty_bag_qty'])+$chittis_details['expected_weight']?></h6></td>
    </tr>
  </table>
</div> 
<?php 
$expected_weight=0;
foreach ($combine_chitti_details as $index => $value) { 
   ?>
<div class="row ">
  <div class="col-md-3">
   <h4 style="margin-left:45%" class="heading">Chitti #<?= $value['chittis_details']['id']; ?></h4>
  </div>
  <div class="col-md-8 text-right">
  <!-- <a  href="<?//=ADMIN_PATH.'argold/metal_issue_chitties/edit/'. $value['chittis_details']['id']?>" class='btn bg_blue white no-print'>create metal receipt</a> -->
  </div>
  <div class="col-md-1 text-right">
  <?php /*if($value['chittis_details']['chitti_hide'] == 0) {  
        echo getHttpButton('HIDE', base_url().'argold/chitti_hides/update/'.$value['chittis_details']['id'].'?from=view', 'btn bg_blue white no-print');
      } elseif($value['chittis_details']['chitti_hide'] == 1) {
        echo getHttpButton('SHOW', base_url().'argold/chitti_hides/update/'.$value['chittis_details']['id'].'?from=view', 'btn bg_blue white no-print');
      }*/
  ?>
  
  </div>
</div>

<div style="max-width:45%; margin-left:10%">
  <table class="table table-sm">
    <tr>
      <td><h6><?=$value['chittis_details']['account_name']?></h6></td><td class="text-right"><h6><?= date('d-m-Y',strtotime($value['chittis_details']['date']))?></h6></td>
    </tr><tr>
      <td>Sale Type</td><td class="text-right"><h6><?= $value['chittis_details']['sale_type'] ?></h6></td>
    </tr>
    <?php 

    if (!empty($value['chittis_details']['no_of_packets']) && $value['chittis_details']['no_of_packets'] > 0) { ?>
      <tr>
        <td>No of Packets</td><td class="text-right"><h6><?=round($value['chittis_details']['no_of_packets'])?></h6></td>
      </tr>
    <?php } ?>
    <?php if (!empty($value['chittis_details']['packet_gross_weight']) && $value['chittis_details']['packet_gross_weight'] > 0) { ?>
      <tr>
        <td>Packet Gross Weight</td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['packet_gross_weight'])?></h6></td>
      </tr>
    <?php } ?>
  </table>
</div>

<div style="max-width:45%; margin-left:10%">
  <?php $this->load->view('combine_chitti_details/viewlist',array('metal_voucher_details'=>$value['metal_voucher_details'])); ?>
</div>

<?php 
  if ($value['chittis_details']['sale_type'] == 'Labour')
    $gst_rate = 2.5;
  else
    $gst_rate = 1.5;
?>

<div style="max-width:45%; margin-left:10%; page-break-after:avoid">
  <table class="table table-sm">
    <tr>
      <td>Weight</td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['credit_weight'])?></h6></td>
    </tr><tr>
      <td>Actual Weight</td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['actual_weight'])?></h6></td>
    </tr><tr>
      <td>Expected Weight</td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['expected_weight'])?></h6></td>
    </tr><tr>
      <td>Diff Weight</td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['diff_weight'])?></h6></td>
    </tr><tr>
      <td>Rate</td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['rate'])?></h6></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">Stone Amount</td>
      <td class="text-right no-print"><h6><?=four_decimal($value['chittis_details']['stone_amount'])?></h6></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">Taxable Amount</td>
      <td class="text-right no-print"><h6><?=four_decimal($value['chittis_details']['taxable_amount'])?></h6></td>
    </tr>
    <?php if(!empty($value['chittis_details']['hallmark_amount']) && $value['chittis_details']['hallmark_amount']!=0){ ?>
    <tr class="">
      <td class="">Hallmark rate</td>
      <td class="text-right "><?=four_decimal($value['chittis_details']['hallmark_rate'])?></td>
    </tr>
    <tr class="">
      <td class="">Hallmark Quantity</td>
      <td class="text-right "><?=four_decimal($value['chittis_details']['hallmark_quantity'])?></td>
    </tr>
    <tr class="">
      <td class="">Hallmark Amount</td>
      <td class="text-right "><?=four_decimal($value['chittis_details']['hallmark_amount'])?></td>
    </tr>
    <tr class="">
      <td class="">Hallmark Taxable Amount </td>
      <td class="text-right "><?=four_decimal($value['chittis_details']['hallmark_taxable_amount'])?></td>
    </tr>
  <?php }?>
    <tr class="no-print">
      <td class="no-print">CGST Amount (<?= $gst_rate ?>%)</td>
      <td class="text-right no-print"><?=four_decimal($value['chittis_details']['cgst_amount'])?></td>
    </tr>
    <tr class="no-print">
      <td class="no-print">SGST Amount (<?= $gst_rate ?>%)</td>
      <td class="text-right no-print"><?=four_decimal($value['chittis_details']['sgst_amount'])?></td>
    </tr>
    <?php if ($value['chittis_details']['sale_type'] != 'Labour') { 

      $tcs_rate=0;
      if(strtotime($value['chittis_details']['created_at'])>strtotime('2021-03-30') && strtotime($value['chittis_details']['created_at'])<strtotime('2021-07-301')){
        $tcs_rate=0.1;
      }elseif(strtotime($value['chittis_details']['created_at'])<=strtotime('2021-03-30')){
        $tcs_rate=0.075;
      } else
        $tcs_rate = 0;

      ?>
      <tr class="no-print">
        <td class="no-print">Total Amount</td>
        <td class="text-right no-print"><?php if(!empty($value['chittis_details']['hallmark_taxable_amount'])){
          echo four_decimal(  $value['chittis_details']['hallmark_taxable_amount'] + $value['chittis_details']['cgst_amount']+ $value['chittis_details']['sgst_amount']);
        }else{
          echo four_decimal($value['chittis_details']['hallmark_taxable_amount'] + $value['chittis_details']['cgst_amount']+ $value['chittis_details']['sgst_amount']);
        }?></td>
      </tr>
      
      <tr class="no-print">
        <td class="no-print">TCS</td>
        <td class="text-right no-print"><?=four_decimal(($value['chittis_details']['taxable_amount']
                                                               + $value['chittis_details']['cgst_amount']
                                                               + $value['chittis_details']['sgst_amount']) * $tcs_rate / 100)?></td>
      </tr>
    <?php } ?>
    <?php if($this->router->class == 'chitti_exports'){ ?>
     <tr>
      <td>USD Rate </td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['usd_rate'])?></h6>
      </td>
    </tr>
    <tr>
      <td>Ounce rate </td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['ounce_rate'])?></h6>
      </td>
    </tr>
    <tr>
      <td>Taxable USD Amount </td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['taxable_usd_amount'])?></h6>
      </td>
    </tr>
    <tr>
      <td>Premium USD Amount </td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['premium_usd_amount'])?></h6>
      </td>
    </tr>
    <tr>
      <td>Labour USD Amount </td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['labour_usd_amount'])?></h6>
      </td>
    </tr>
    <tr>
      <td>Freight USD Amount </td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['freight_usd_amount'])?></h6>
      </td>
    </tr> 
  <?php }?>
    <tr>
      <td>Grand Total</td><td class="text-right"><h6><?=four_decimal($value['chittis_details']['debit_amount'])?></h6></td>
    </tr>
  </table>
</div>
<?php } ?>

<style type="text/css">

  @page { 
    margin: 0mm; 
    size: 4cm 6cm ;
    size: landscape;
  }
</style>


