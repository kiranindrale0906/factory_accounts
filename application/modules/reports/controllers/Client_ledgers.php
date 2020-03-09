<?php
	
class Client_ledgers extends BaseController {
	public function __construct() {
  	parent::__construct();
	}

  protected function get_records_by_created_date($records,$account_name) {
    $records_by_created_date = array();
    foreach($records as $record) {
      if (!isset($records_by_created_date[$record['voucher_date']])) $records_by_created_date[$record['voucher_date']] = array();
      $records_by_created_date[$record['voucher_date']][$account_name][] = $record;
    }
    return $records_by_created_date;
  }

  protected function total_get_records_by_created_date($records) {
    $records_by_created_date = array();
    foreach($records as $record) {
      if (!isset($records_by_created_date[$record['voucher_date']])) $records_by_created_date[$record['voucher_date']] = array();
      $records_by_created_date[$record['voucher_date']][] = $record;
    }

    return $records_by_created_date;
  }

  protected function set_index_for_dates($total) {
    foreach($this->data['voucher_dates'] as $created_date) {
      if (!isset($total[$created_date])) {
        $total[$created_date] = array();
        $total[$created_date]['issue'] = array();
        $total[$created_date]['issue']['weight'] = 0;
        $total[$created_date]['issue']['weight_difference'] = 0;
        $total[$created_date]['receipt'] = array();
        $total[$created_date]['receipt']['weight'] = 0;
        $total[$created_date]['receipt']['weight_difference'] = 0;
      }
    }
    return $total;
  }

  protected function get_total_by_created_date($records, $type, $total) {
    foreach($this->data['voucher_dates'] as $created_date) {
      if (!isset($records[$created_date])) continue;
      foreach($records[$created_date] as $account_name => $account_records) {
        foreach($account_records as $index => $record) {
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
            $purity_margin = $record['debit_weight']*($record['factory_purity']-$record['purity'])/100; 
            $total[$record['voucher_date']][$type]['weight_difference'] += $purity_margin;
            $fine=($record['debit_weight']*$record['purity'])/100;
            $total[$record['voucher_date']][$type]['fine'] += $fine;
            $factory_fine=($record['debit_weight']*$record['factory_purity'])/100;
            $total[$record['voucher_date']][$type]['factory_fine'] += $factory_fine;
          }
        }
      }
    }
    return $total;     
  }

  protected function get_balance_by_created_date() {
    foreach($this->data['total'] as $account_name => $total_record) {

      $previous_date = '';
      $previous_type = '';
      foreach($this->data['voucher_dates'] as $created_date) {
        if ($previous_type != '') {
          $this->data['total'][$account_name][$created_date][$previous_type]['weight'] += @$this->data['balance'][$account_name][$previous_date][$previous_type]['weight'];
          $this->data['total'][$account_name][$created_date][$previous_type]['weight_difference'] += @$this->data['balance'][$account_name][$previous_date][$previous_type]['weight_difference'];
        }
        
        if ($this->data['total'][$account_name][$created_date]['receipt']['weight'] >= $this->data['total'][$account_name][$created_date]['issue']['weight']) {

          $this->data['balance'][$account_name][$created_date]['receipt']['weight'] = 
                                                          $this->data['total'][$account_name][$created_date]['receipt']['weight']
                                                          - $this->data['total'][$account_name][$created_date]['issue']['weight'];

          $this->data['balance'][$account_name][$created_date]['receipt']['weight_difference'] = 
                                                          $this->data['total'][$account_name][$created_date]['receipt']['weight_difference']
                                                          - $this->data['total'][$account_name][$created_date]['issue']['weight_difference'];        
          $type = 'receipt';
        } else {
          $this->data['balance'][$account_name][$created_date]['issue']['weight'] = 
                                                          $this->data['total'][$account_name][$created_date]['issue']['weight']
                                                          - $this->data['total'][$account_name][$created_date]['receipt']['weight'];
          $this->data['balance'][$account_name][$created_date]['issue']['weight_difference'] = 
                                                          $this->data['total'][$account_name][$created_date]['issue']['weight_difference'] 
                                                          - $this->data['total'][$account_name][$created_date]['receipt']['weight_difference'];
          $type = 'issue';
        }
        
        $previous_date = $created_date;
        $previous_type = $type;
      }
    }     
  }
}
?>