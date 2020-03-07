<?php
	
class Ledgers extends BaseController {
	public function __construct() {
  	parent::__construct();
	}

  protected function get_records_by_created_date($records) {
    $records_by_created_date = array();
    foreach($records as $record) {
      if (!isset($records_by_created_date[$record['voucher_date']])) $records_by_created_date[$record['voucher_date']] = array();
      $records_by_created_date[$record['voucher_date']][] = $record;
    }
    return $records_by_created_date;
  }

  protected function set_index_for_dates() {
    foreach($this->data['voucher_dates'] as $created_date) {
      if (!isset($this->data['total'][$created_date])) {
        $this->data['total'][$created_date] = array();
        $this->data['total'][$created_date]['issue'] = array();
        $this->data['total'][$created_date]['issue']['credit_weight'] = 0;
        $this->data['total'][$created_date]['issue']['purity'] = 0;
        $this->data['total'][$created_date]['receipt'] = array();
        $this->data['total'][$created_date]['receipt']['debit_weight'] = 0;
        $this->data['total'][$created_date]['receipt']['purity'] = 0;
      }
    }
  }

  protected function get_total_by_created_date($records, $type) {

    foreach($this->data['voucher_dates'] as $created_date) {
      if (!isset($records[$created_date])) continue;
      foreach($records[$created_date] as $record) {
        if (!isset($this->data['total'][$record['voucher_date']]['issue'])) {
          $this->data['total'][$record['voucher_date']]['issue'] = array();
          $this->data['total'][$record['voucher_date']]['issue']['credit_weight'] = 0;
          $this->data['total'][$record['voucher_date']]['issue']['weight_difference'] = 0;
        }

        if (!isset($this->data['total'][$record['voucher_date']]['receipt'])) {
          $this->data['total'][$record['voucher_date']]['receipt'] = array();
          $this->data['total'][$record['voucher_date']]['receipt']['debit_weight'] = 0;
          $this->data['total'][$record['voucher_date']]['receipt']['weight_difference'] = 0;
        }

        if($type=='issue'){
          $this->data['total'][$record['voucher_date']][$type]['credit_weight'] += $record['credit_weight'];
          $purity_margin=($record['factory_purity']-$record['purity'])*$record['credit_weight']/100;
          $this->data['total'][$record['voucher_date']][$type]['weight_difference'] += $purity_margin;       
        }

        if($type=='receipt') {
          $this->data['total'][$record['voucher_date']][$type]['debit_weight'] += $record['debit_weight'];
          $purity_margin = $record['debit_weight']*($record['purity']-$record['factory_purity'])/100; 
          $this->data['total'][$record['voucher_date']][$type]['weight_difference'] += $purity_margin;
        }
      }
    }     
  }

  protected function get_balance_by_created_date() {
    $previous_date = '';
    $previous_type = '';
    foreach($this->data['voucher_dates'] as $created_date) {
      if ($previous_type != '') {
        if(isset($this->data['balance'][$previous_date][$previous_type]['credit_weight']))
          $this->data['total'][$created_date][$previous_type]['credit_weight'] += $this->data['balance'][$previous_date][$previous_type]['credit_weight'];
        if(isset($this->data['balance'][$previous_date][$previous_type]['debit_weight']))
          $this->data['total'][$created_date][$previous_type]['debit_weight'] += $this->data['balance'][$previous_date][$previous_type]['debit_weight'];

          $this->data['total'][$created_date][$previous_type]['weight_difference'] += $this->data['balance'][$previous_date][$previous_type]['weight_difference'];
      }
    
      if ($this->data['total'][$created_date]['receipt']['debit_weight'] >= $this->data['total'][$created_date]['issue']['credit_weight']) {

        $this->data['balance'][$created_date]['receipt']['debit_weight'] = 
                                                        $this->data['total'][$created_date]['receipt']['debit_weight']
                                                        - $this->data['total'][$created_date]['issue']['credit_weight'];

        $this->data['balance'][$created_date]['receipt']['weight_difference'] = 
                                                        $this->data['total'][$created_date]['receipt']['weight_difference']
                                                        - $this->data['total'][$created_date]['issue']['weight_difference'];        
        $type = 'receipt';
      } else {
        $this->data['balance'][$created_date]['issue']['credit_weight'] = 
                                                        $this->data['total'][$created_date]['issue']['credit_weight']
                                                        - $this->data['total'][$created_date]['receipt']['debit_weight'];
        $this->data['balance'][$created_date]['issue']['weight_difference'] = 
                                                        $this->data['total'][$created_date]['issue']['weight_difference'] 
                                                        - $this->data['total'][$created_date]['receipt']['weight_difference'];
        $type = 'issue';
      }
      
      $previous_date = $created_date;
      $previous_type = $type;
    }     
  }
}
?>