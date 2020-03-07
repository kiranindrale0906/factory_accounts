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
          }

          if (!isset($total[$record['voucher_date']]['receipt'])) {
            $total[$record['voucher_date']]['receipt'] = array();
            $total[$record['voucher_date']]['receipt']['weight'] = 0;
            $total[$record['voucher_date']]['receipt']['weight_difference'] = 0;
          }
          
          if($type=='issue'){
            $total[$record['voucher_date']][$type]['weight'] += $record['credit_weight'];
            $purity_margin=($record['factory_purity']-$record['purity'])*$record['credit_weight']/100;
            $total[$record['voucher_date']][$type]['weight_difference'] += $purity_margin;       
          }

          if($type=='receipt') {
            $total[$record['voucher_date']][$type]['weight'] += $record['debit_weight'];
            $purity_margin = $record['debit_weight']*($record['purity']-$record['factory_purity'])/100; 
            $total[$record['voucher_date']][$type]['weight_difference'] += $purity_margin;
          }
        }
      }
    }
    return $total;     
  }

  // protected function get_account_total_by_created_date($records, $type) {
  //   foreach($records as $account_name => $account_records) {
  //     foreach($this->data['voucher_dates'] as $created_date) {
  //       if (!isset($records[$account_name][$created_date])) continue;
  //       foreach($records[$account_name][$created_date] as $index => $record) {
          
  //         if (!isset($this->data['total'][$account_name])
  //             || !isset($this->data['total'][$account_name][$record['voucher_date']])
  //             || !isset($this->data['total'][$account_name][$record['voucher_date']]['issue'])) {
  //           $this->data['total'][$account_name][$record['voucher_date']]['issue'] = array();
  //           $this->data['total'][$account_name][$record['voucher_date']]['issue']['weight'] = 0;
  //           $this->data['total'][$account_name][$record['voucher_date']]['issue']['weight_difference'] = 0;
  //         }

  //         if (!isset($this->data['total'][$account_name])
  //             || !isset($this->data['total'][$account_name][$record['voucher_date']])
  //             || !isset($this->data['total'][$account_name][$record['voucher_date']]['receipt'])) {
  //           $this->data['total'][$account_name][$record['voucher_date']]['receipt'] = array();
  //           $this->data['total'][$account_name][$record['voucher_date']]['receipt']['weight'] = 0;
  //           $this->data['total'][$account_name][$record['voucher_date']]['receipt']['weight_difference'] = 0;
  //         }
          
  //         if($type=='issue'){
  //           $this->data['total'][$account_name][$record['voucher_date']][$type]['weight'] += $record['credit_weight'];
  //           $purity_margin=($record['factory_purity']-$record['purity'])*$record['credit_weight']/100;
  //           $this->data['total'][$account_name][$record['voucher_date']][$type]['weight_difference'] += $purity_margin;       
  //         }

  //         if($type=='receipt') {
  //           $this->data['total'][$account_name][$record['voucher_date']][$type]['weight'] += $record['debit_weight'];
  //           $purity_margin = $record['debit_weight']*($record['purity']-$record['factory_purity'])/100; 
  //           $this->data['total'][$account_name][$record['voucher_date']][$type]['weight_difference'] += $purity_margin;
  //         }
  //       }
  //     }
  //   }
  // }

  protected function get_balance_by_created_date() {
    foreach($this->data['total'] as $account_name => $total_record) {

      $previous_date = '';
      $previous_type = '';
      foreach($this->data['voucher_dates'] as $created_date) {
        if ($previous_type != '') {
          $this->data['total'][$account_name][$created_date][$previous_type]['weight'] += @$this->data['balance'][$account_name][$previous_date][$previous_type]['weight'];
          $this->data['total'][$account_name][$created_date][$previous_type]['weight_difference'] += @$this->data['balance'][$account_name][$previous_date][$previous_type]['weight_difference'];
        }
        //pd($this->data['total'][$created_date][$account_name]);
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

  protected function get_balance_by_created_date_new_modified($account_name) {
    //pd($this->data['total']);
    //pd($this->data['total'][$account_name]);
    foreach($this->data['total'][$account_name] as $voucher_date => $total_record) {
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