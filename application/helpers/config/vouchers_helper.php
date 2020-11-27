<?php

function get_tax_fields($factory_fine, $fine, $sale_type, $gold_rate) {
  $fields = array('sale_type' => $sale_type,
                  'gst_rate'  => ($sale_type == 'Labour') ? 2.50 : 1.50,
                  'tcs_rate'  => ($sale_type == 'Sale') ? 0.075 : 0,
                  'gold_rate' => $gold_rate);
  if ($fields['sale_type'] == 'Labour') 
    $fields['weight'] = ($factory_fine > $fine) ? ($factory_fine - $fine) : ($fine - $factory_fine);
  else {
    $fields['weight'] = ($factory_fine > $fine) ? $factory_fine : $fine;
    if ($fields['weight']==0) $fields['weight'] = $factory_fine;
  }

  $fields['taxable_amount'] = $fields['weight'] * $gold_rate;
  $fields['cgst_amount']    = $fields['taxable_amount'] * $fields['gst_rate'] / 100;
  $fields['sgst_amount']    = $fields['taxable_amount'] * $fields['gst_rate'] / 100;
  $fields['total_amount']   = $fields['taxable_amount'] + $fields['cgst_amount'] + $fields['sgst_amount'];
  $fields['tcs_amount']     = $fields['total_amount'] * $fields['tcs_rate'] / 100;
  $fields['grand_total']    = round($fields['total_amount'] + $fields['tcs_amount']);
  return $fields;
}