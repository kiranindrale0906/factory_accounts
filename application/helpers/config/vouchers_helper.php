<?php

function get_tax_fields($factory_fine, $fine, $sale_type, $gold_rate, $gold_rate_purity, $created_at) {
  $tcs_rate=0;
  if (strtotime($created_at) > strtotime('2021-03-30')) 
    $tcs_rate=0.1;
  elseif (strtotime($created_at) <= strtotime('2021-03-30'))
    $tcs_rate=0.075;
  
  $fields = array('sale_type' => $sale_type,
                  'gst_rate'  => ($sale_type == 'Labour') ? 2.50 : 1.50,
                  'tcs_rate'  => ($sale_type == 'Sale') ?  $tcs_rate : 0,
                  'gold_rate' => $gold_rate,
                  'gold_rate_purity' => $gold_rate_purity);

  if ($fields['sale_type'] == 'Labour') 
    $fields['weight'] = ($factory_fine > $fine) ? ($factory_fine - $fine) : ($fine - $factory_fine);
  else {
    $fields['weight'] = ($factory_fine > $fine) ? $factory_fine : $fine;
    if ($fields['weight']==0) $fields['weight'] = $factory_fine;
  }
  $fields['taxable_amount'] = $fields['weight'] * $gold_rate * $gold_rate_purity / 100;
  $fields['cgst_amount']    = $fields['taxable_amount'] * $fields['gst_rate'] / 100;
  $fields['sgst_amount']    = $fields['taxable_amount'] * $fields['gst_rate'] / 100;
  $fields['total_amount']   = $fields['taxable_amount'] + $fields['cgst_amount'] + $fields['sgst_amount'];
  $fields['tcs_amount']     = $fields['total_amount'] * $fields['tcs_rate'] / 100;
  $fields['grand_total']    = round($fields['total_amount'] + $fields['tcs_amount']);
  return $fields;
}

function parent_id_exist($parent_id){
    $ci=&get_instance();
    $ci->load->model('ac_vouchers/voucher_model');
    $parent_id = $ci->voucher_model->find('parent_id',array('parent_id'=>$parent_id))['parent_id'];
    return $parent_id;
}