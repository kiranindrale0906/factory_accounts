<?php
	
class Ledgers extends BaseController {
	public function __construct() {
  	parent::__construct();
	}

  protected function get_datewise_ledger_records($period = 'date') {
    $this->data['period'] = $period;
    if ($period == 'date') $period_select = 'date_format(voucher_date,"%Y-%m-%d")';
    elseif ($period == 'month') $period_select = 'date_format(voucher_date,"%Y-%m")';
    elseif ($period == 'week') {
      $period_from_date = 'DATE_SUB(
                                DATE_ADD(MAKEDATE(date_format(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK),
                                INTERVAL WEEKDAY(
                                   DATE_ADD(MAKEDATE(date_format(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK)
                                ) -1 DAY)';
      $period_to_date = 'DATE_SUB(
                                DATE_ADD(MAKEDATE(date_format(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK),
                                INTERVAL WEEKDAY(
                                   DATE_ADD(MAKEDATE(date_format(voucher_date,"%Y"), 1), INTERVAL week(voucher_date) WEEK)
                                ) -7 DAY)';
      $period_select = 'CONCAT('.$period_from_date.' , " - ", '.$period_to_date.')';
      //$week_start_date = 'MAKEDATE(date_format(voucher_date,"%Y"), week(voucher_date))';
      //$week_end_date = 'DATE_ADD(MAKEDATE(date_format(voucher_date,"%Y"), week(voucher_date)), INTERVAL 1 WEEK)';
      //$period_select = 'CONCAT("Week: ", ' .$week_start_date . ')';
      // /$period_select = 'week(voucher_date)';
    };

    $account_id = (!empty($_GET[$this->router->class]['account_id'])) ? $_GET[$this->router->class]['account_id'] : 0;
    $where = array();
    if(!empty($account_id)) {
      $where['account_id'] = $account_id;
      $this->data['record']['account_id'] = $account_id;
    }

    if ($this->router->class == 'vadotar_reports') {
      $where['purity != factory_purity'] = NULL;
      if (!empty($this->data['site_name']) && $this->data['site_name'] != 'All') 
        $where['site_name'] = $this->data['site_name'];
      // if ($this->data['company_name'] == 'AR Gold') {
      //   $where['where_not_in'] = array('receipt_type' => array("'ARF Finished Goods'", "'ARC Finished Goods'", 
      //                                                          "'ARF Refresh'", "'ARC Refresh'", 
      //                                                          "'ARF Software Finished Goods'"));
      // } elseif ($this->data['company_name'] == 'ARF') {
      //    $where['where_in'] = array('receipt_type' => array("'ARF Finished Goods'", "'ARF Refresh'", "'ARF Software Finished Goods'"));
      // } elseif ($this->data['company_name'] == 'ARC') {
      //   $where['where_in'] = array('receipt_type' => array("'ARC Finished Goods'", "'ARC Refresh'"));
      // }
    } 

    if (!isset($this->data['group']) || $this->data['group']=='') {
      $this->data['group']='';
      $receipt_select = 'receipt_type, '.$period_select.' as voucher_date, 
                 date_format(voucher_date,"%Y-%m-%d") as str_voucher_date,
                 account_name, voucher_type, voucher_number, 
                 0 as credit_amount, (debit_amount - credit_amount) as debit_amount, 
                 0  as credit_weight, (debit_weight - credit_weight) as debit_weight, 
                 purity_margin, purity, factory_purity, narration, description';
      $issue_select = 'receipt_type, '.$period_select.' as voucher_date, 
                 date_format(voucher_date,"%Y-%m-%d") as str_voucher_date,
                 account_name, voucher_type, voucher_number, 
                 (credit_amount - debit_amount) as credit_amount, 0 as debit_amount,
                 (credit_weight - debit_weight) as credit_weight, 0 as debit_weight, 
                 purity_margin, purity, factory_purity, narration, description';           
    } else {
      $this->data['group'] = 'voucher_date';
      $receipt_select = '"" as receipt_type, '.$period_select.' as voucher_date, 
                 date_format(voucher_date,"%Y-%m-%d") as str_voucher_date, "" as voucher_number,
                 "" as account_name, "" as voucher_type, "" as voucher_number, 
                 sum(credit_amount) as credit_amount, sum(debit_amount) as debit_amount, 
                 sum(credit_weight) as credit_weight, sum(debit_weight) as debit_weight, 
                 0 as purity_margin, 
                 sum((credit_weight+debit_weight) * purity) /  sum(credit_weight+debit_weight)  as purity, 
                 sum((credit_weight+debit_weight) * factory_purity) /  sum(credit_weight+debit_weight)  as factory_purity, ""  as narration, "" as description';
      $issue_select = $receipt_select;          
    }

    $where_issue = array_merge($where, array('(credit_weight != 0 or credit_amount != 0)' => NULL));
    $where_receipt = array_merge($where, array('(debit_weight != 0 or debit_amount != 0)' => NULL));

    if (isset($this->data['report_type']) && $this->data['report_type'] == 'production') {
      $where_issue = array_merge($where_issue, array('account_name != ' => 'VADOTAR'));
      $where_receipt = array_merge($where_receipt, array('account_name != ' => 'VADOTAR'));
    }

    $issues = $this->model->get($issue_select, $where_issue ,array(), array('order_by'=>'str_voucher_date asc', 'group_by' => $this->data['group']));
    $receipts = $this->model->get($receipt_select, $where_receipt ,array(), array('order_by'=>'str_voucher_date asc', 'group_by' => $this->data['group']));
    $issue_voucher_dates = array_column($issues, 'voucher_date');
    $receipt_voucher_dates = array_column($receipts, 'voucher_date');
    
    $this->data['voucher_dates'] = array_values(array_unique(array_merge($issue_voucher_dates, $receipt_voucher_dates)));
    asort($this->data['voucher_dates']);
  
    $this->data['issues'] = $this->get_records_by_created_date($issues);
    $this->data['receipts'] = $this->get_records_by_created_date($receipts);
    $total_issue = $this->get_total_by_created_date($this->data['issues'], 'issue', array());
    $total_receipt_issue = $this->get_total_by_created_date($this->data['receipts'], 'receipt', $total_issue);      
    //pd($total_receipt_issue);
    $this->data['total'] = $this->set_index_for_dates($total_receipt_issue);

    if (isset($this->data['report_type']) && $this->data['report_type'] == 'production') {
      //do not compute opening / balance
    }
    else
      $this->get_balance_by_created_date();
  }

  private function get_records_by_created_date($records) {
    $records_by_created_date = array();
    foreach($records as $record) {
      if (!isset($records_by_created_date[$record['voucher_date']])) $records_by_created_date[$record['voucher_date']] = array();
      $records_by_created_date[$record['voucher_date']][] = $record;
    }
    return $records_by_created_date;
  }

  private function set_index_for_dates($total) {
    foreach($this->data['voucher_dates'] as $created_date) {
      if (!isset($total[$created_date])) {
        $total[$created_date] = array();
        $total[$created_date]['issue'] = array();
        $total[$created_date]['issue']['weight'] = 0;
        $total[$created_date]['issue']['weight_difference'] = 0;
        $total[$created_date]['issue']['fine'] = 0;
        $total[$created_date]['issue']['factory_fine'] = 0;
        $total[$created_date]['issue']['amount'] = 0;
        $total[$created_date]['receipt'] = array();
        $total[$created_date]['receipt']['weight'] = 0;
        $total[$created_date]['receipt']['weight_difference'] = 0;
        $total[$created_date]['receipt']['fine'] = 0;
        $total[$created_date]['receipt']['factory_fine'] = 0;
        $total[$created_date]['receipt']['amount'] = 0;
      }
    }
    return $total;
  }

  private function get_total_by_created_date($records, $type, $total) {
    foreach($this->data['voucher_dates'] as $created_date) {
      if (!isset($records[$created_date])) continue;
      foreach($records[$created_date] as $account_name => $record) {
          if (!isset($total[$record['voucher_date']])
              || !isset($total[$record['voucher_date']]['issue'])) {
            $total[$record['voucher_date']]['issue'] = array();
            $total[$record['voucher_date']]['issue']['weight'] = 0;
            $total[$record['voucher_date']]['issue']['weight_difference'] = 0;
            $total[$record['voucher_date']]['issue']['fine'] = 0;
            $total[$record['voucher_date']]['issue']['factory_fine'] = 0;
            $total[$record['voucher_date']]['issue']['amount'] = 0;
          }

          if (!isset($total[$record['voucher_date']]['receipt'])) {
            $total[$record['voucher_date']]['receipt'] = array();
            $total[$record['voucher_date']]['receipt']['weight'] = 0;
            $total[$record['voucher_date']]['receipt']['weight_difference'] = 0;
            $total[$record['voucher_date']]['receipt']['fine'] = 0;
            $total[$record['voucher_date']]['receipt']['factory_fine'] = 0;
            $total[$record['voucher_date']]['receipt']['amount'] = 0;
          }
          
          if($type=='issue'){
            $total[$record['voucher_date']][$type]['weight'] += $record['credit_weight'];
            $purity_margin=($record['purity']-$record['factory_purity'])*$record['credit_weight']/100;
            $total[$record['voucher_date']][$type]['weight_difference'] += $purity_margin;
            $fine=($record['credit_weight']*$record['purity'])/100;
            $total[$record['voucher_date']][$type]['fine'] += $fine;
            $factory_fine=($record['credit_weight']*$record['factory_purity'])/100;
            $total[$record['voucher_date']][$type]['factory_fine'] += $factory_fine;
            $total[$record['voucher_date']][$type]['amount'] += $record['credit_amount'];
          }

          if($type=='receipt') {
            $total[$record['voucher_date']][$type]['weight'] += $record['debit_weight'];
            $purity_margin = ($record['factory_purity']-$record['purity']) * $record['debit_weight'] /100; 
            $total[$record['voucher_date']][$type]['weight_difference'] += $purity_margin;
            $fine=($record['debit_weight']*$record['purity'])/100;
            $total[$record['voucher_date']][$type]['fine'] += $fine;
            $factory_fine=($record['debit_weight']*$record['factory_purity'])/100;
            $total[$record['voucher_date']][$type]['factory_fine'] += $factory_fine;
            $total[$record['voucher_date']][$type]['amount'] += $record['debit_amount'];
          }
      }
    }
    return $total;     
  }

  private function get_balance_by_created_date() {
    //foreach($this->data['total'] as $account_name => $total_record)  {
    $total_record = $this->data['total'];
      $previous_date = '';
      $previous_type = '';
      foreach($this->data['voucher_dates'] as $created_date) {
        if ($previous_type != '') {
          $this->data['total'][$created_date][$previous_type]['weight'] += $this->data['balance'][$previous_date][$previous_type]['weight'];
          $this->data['total'][$created_date][$previous_type]['weight_difference'] += $this->data['balance'][$previous_date][$previous_type]['weight_difference'];

          $this->data['total'][$created_date][$previous_type]['fine'] += $this->data['balance'][$previous_date][$previous_type]['fine'];

          $this->data['total'][$created_date][$previous_type]['factory_fine'] += $this->data['balance'][$previous_date][$previous_type]['factory_fine'];

          $this->data['total'][$created_date][$previous_type]['amount'] += $this->data['balance'][$previous_date][$previous_type]['amount'];
        }
        
        if ($this->data['total'][$created_date]['receipt']['weight'] >= $this->data['total'][$created_date]['issue']['weight']) {

          $this->data['balance'][$created_date]['receipt']['weight'] = 
                                                          $this->data['total'][$created_date]['receipt']['weight']
                                                          - $this->data['total'][$created_date]['issue']['weight'];

          $this->data['balance'][$created_date]['receipt']['weight_difference'] = 
                                                          $this->data['total'][$created_date]['receipt']['weight_difference']
                                                          - $this->data['total'][$created_date]['issue']['weight_difference']; 


          $this->data['balance'][$created_date]['receipt']['fine'] = 
                                                          $this->data['total'][$created_date]['receipt']['fine']
                                                          - $this->data['total'][$created_date]['issue']['factory_fine'];

          $this->data['balance'][$created_date]['receipt']['factory_fine'] = 
                                                          $this->data['total'][$created_date]['receipt']['factory_fine']
                                                          - $this->data['total'][$created_date]['issue']['fine'];      

          $this->data['balance'][$created_date]['receipt']['amount'] = 
                                                          $this->data['total'][$created_date]['receipt']['amount']
                                                          - $this->data['total'][$created_date]['issue']['amount'];                                                          
          $type = 'receipt';
        } else {
          $this->data['balance'][$created_date]['issue']['weight'] = 
                                                          $this->data['total'][$created_date]['issue']['weight']
                                                          - $this->data['total'][$created_date]['receipt']['weight'];
          $this->data['balance'][$created_date]['issue']['weight_difference'] = 
                                                          $this->data['total'][$created_date]['issue']['weight_difference'] 
                                                          - $this->data['total'][$created_date]['receipt']['weight_difference'];

          $this->data['balance'][$created_date]['issue']['fine'] = 
                                                          $this->data['total'][$created_date]['issue']['fine']
                                                          - $this->data['total'][$created_date]['receipt']['factory_fine'];
          $this->data['balance'][$created_date]['issue']['factory_fine'] = 
                                                          $this->data['total'][$created_date]['issue']['factory_fine']
                                                          - $this->data['total'][$created_date]['receipt']['fine'];
          $this->data['balance'][$created_date]['issue']['amount'] = 
                                                          $this->data['total'][$created_date]['issue']['amount']
                                                          - $this->data['total'][$created_date]['receipt']['amount'];                                                                        
          $type = 'issue';
        }
        
        $previous_date = $created_date;
        $previous_type = $type;
      }
   //}     
  }
}
?>