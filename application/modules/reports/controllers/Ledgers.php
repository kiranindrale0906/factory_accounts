<?php
	
class Ledgers extends BaseController {
	public function __construct() {
  	parent::__construct();
	}

  protected function get_datewise_ledger_records() {
    $account_id = (!empty($_GET[$this->router->class]['account_id'])) ? $_GET[$this->router->class]['account_id'] : 0;
    $where = array();
    if(!empty($account_id)) {
      $where['account_id'] = $account_id;
      $this->data['record']['account_id'] = $account_id;
    }

    if ($this->router->class == 'vadotar_reports') $where['purity != factory_purity'] = NULL;

    $select = 'date_format(voucher_date,"%d-%m-%Y") as voucher_date, voucher_number,
               account_name, voucher_type, voucher_number, credit_amount, debit_amount, 
               credit_weight, debit_weight, purity_margin, purity, factory_purity, narration';
    $where_issue = array_merge($where, array('(credit_weight > 0 or credit_amount > 0)' => NULL));
    $where_receipt = array_merge($where, array('(debit_weight > 0 or debit_amount > 0)' => NULL));

    $issues = $this->model->get($select, $where_issue ,array(), array('order_by'=>'voucher_date asc'));
    $receipts = $this->model->get($select, $where_receipt ,array(), array('order_by'=>'voucher_date asc'));
    
    $issue_voucher_dates = array_column($issues, 'voucher_date');
    $receipt_voucher_dates = array_column($receipts, 'voucher_date');
    $this->data['voucher_dates'] = array_values(array_unique(array_merge($issue_voucher_dates, $receipt_voucher_dates)));
    asort($this->data['voucher_dates']);
  
    $this->data['issues'] = $this->get_records_by_created_date($issues);
    $this->data['receipts'] = $this->get_records_by_created_date($receipts);

    $total_issue = $this->get_total_by_created_date($this->data['issues'], 'issue', array());
    $total_receipt_issue = $this->get_total_by_created_date($this->data['receipts'], 'receipt', $total_issue);      
    $this->data['total'] = $this->set_index_for_dates($total_receipt_issue);

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
        $total[$created_date]['receipt'] = array();
        $total[$created_date]['receipt']['weight'] = 0;
        $total[$created_date]['receipt']['weight_difference'] = 0;
        $total[$created_date]['receipt']['fine'] = 0;
        $total[$created_date]['receipt']['factory_fine'] = 0;
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
          }

          if (!isset($total[$record['voucher_date']]['receipt'])) {
            $total[$record['voucher_date']]['receipt'] = array();
            $total[$record['voucher_date']]['receipt']['weight'] = 0;
            $total[$record['voucher_date']]['receipt']['weight_difference'] = 0;
            $total[$record['voucher_date']]['receipt']['fine'] = 0;
            $total[$record['voucher_date']]['receipt']['factory_fine'] = 0;
          }
          
          if($type=='issue'){
            $total[$record['voucher_date']][$type]['weight'] += $record['credit_weight'];
            $purity_margin=($record['purity']-$record['factory_purity'])*$record['credit_weight']/100;
            $total[$record['voucher_date']][$type]['weight_difference'] += $purity_margin;
            $fine=($record['credit_weight']*$record['purity'])/100;
            $total[$record['voucher_date']][$type]['fine'] += $fine;
            $factory_fine=($record['credit_weight']*$record['factory_purity'])/100;
            $total[$record['voucher_date']][$type]['factory_fine'] += $factory_fine;

          }

          if($type=='receipt') {
            $total[$record['voucher_date']][$type]['weight'] += $record['debit_weight'];
            $purity_margin = $record['debit_weight']*($record['purity']-$record['factory_purity'])/100; 
            $total[$record['voucher_date']][$type]['weight_difference'] += $purity_margin;
            $fine=($record['debit_weight']*$record['purity'])/100;
            $total[$record['voucher_date']][$type]['fine'] += $fine;
            $factory_fine=($record['debit_weight']*$record['factory_purity'])/100;
            $total[$record['voucher_date']][$type]['factory_fine'] += $factory_fine;
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
                                                          - $this->data['total'][$created_date]['issue']['fine'];

          $this->data['balance'][$created_date]['receipt']['factory_fine'] = 
                                                          $this->data['total'][$created_date]['receipt']['factory_fine']
                                                          - $this->data['total'][$created_date]['issue']['factory_fine'];      
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
                                                          - $this->data['total'][$created_date]['receipt']['fine'];
          $this->data['balance'][$created_date]['issue']['factory_fine'] = 
                                                          $this->data['total'][$created_date]['issue']['factory_fine']
                                                          - $this->data['total'][$created_date]['receipt']['factory_fine'];
          $type = 'issue';
        }
        
        $previous_date = $created_date;
        $previous_type = $type;
      }
   //}     
  }
}
?>