<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metal_registers extends BaseController {  
  public function __construct(){
    //$this->_model='Bank_register_model';
    parent::__construct();
    $this->redirect_after_save = 'view';
    $this->load->model(array('reports/bank_register_model',
                             'ac_vouchers/voucher_model'));
  } 

  public function index() { 
    $this->calculation_data();
    $this->load->render('registers/metal_registers/index',$this->data); 
  } 

  
  private function calculation_data() {

    $this->start_date = (!empty($_GET['start_date'])) ? date('Y-m-d',strtotime($_GET['start_date'])) : date('Y-m-d');
    $this->end_date = (!empty($_GET['end_date'])) ? date('Y-m-d',strtotime($_GET['end_date'])) : date('Y-m-d');
    $this->data['start_date'] = $this->start_date;
    $this->data['end_date'] = $this->end_date;
    $where=array();
    if (!empty($_GET['start_date'])) {
            $where['created_at>='] = $this->start_date;
        }
        if (!empty($_GET['end_date'])) {
            $where['created_at<='] = $this->end_date;
        }
        // if (!empty($_GET['bank_name'])) {
        //     $where['bank_name']= $_GET['bank_name'];
        // }

      

      $purities = $this->get_purity();
  }

  private function get_purity() {
    $purity_list = array();
    $where['where']='(suffix="RCPPRV" OR suffix="RCPWRV" OR suffix="RCPWIV" OR suffix = "RCBPRV" OR suffix="RCBWRV" OR suffix = "RCBWIV" OR suffix = "RCPPIV" OR suffix = "RCBPIV")';
    $where['company_id']=$this->session->userdata('company_id');
    $metal_purities = $this->metal_register_model->get('distinct(purity) purity' , 
                                                         array('(suffix="MI" or suffix="MR")'=>NULL));
    $rate_cut_purities = $this->metal_register_model->get('distinct(gold_weight_purity) as purity' , $where);
    $sales_purities = $this->metal_register_model->get('distinct(gold_purity) as purity' , array('suffix'=>'SV'));    
    $purity_list= array_merge($metal_purities,$rate_cut_purities,$sales_purities);
    $purity_list = array_unique($purity_list, SORT_REGULAR);
    return $purity_list;
  }

  public function index() {

        // $param = $this->getParams();
        // $metal_purities = $this->metal_voucher_model->get_all_purity();
        // $all_purities = array_merge($rate_cut_purities, $metal_purities);
        // $sales_purities = $this->sales_purchase_voucher_model->get_all_purity();
        // $all_purities = array_merge($all_purities, $sales_purities);
        // $all_purities = array_unique($all_purities, SORT_REGULAR);
        // $opening_param['to_date'] = date('Y-m-d', strtotime('-1 day', strtotime($param['from_date'])));
        // $opening_param['from_date'] = date('1990-04-01');
        foreach ($all_purities as $key => $purity) {
            $param['purity'] = $purity['purity'];
            $opening_param['purity'] = $purity['purity'];
            $metal_register = $rate_cut_register = $new_array = $all_vouchers = array();
            $pre_metal_register = $pre_rate_cut_register = $pre_array = $all_pre_vouchers = array();
            $metal_register = $this->metal_voucher_model->get_metal_register_data($param);
            $pre_metal_register = $this->metal_voucher_model->get_metal_register_data($opening_param);
            $param['gold_weight_purity'] = $purity['purity'];
            $opening_param['gold_weight_purity'] = $purity['purity'];
            $rate_cut_register = $this->rate_cut_voucher_model->get_rate_cut_purchase_register_data($param);
            $pre_rate_cut_register = $this->rate_cut_voucher_model->get_rate_cut_purchase_register_data($opening_param);
            foreach ($rate_cut_register as $k => $rcr) {
                $new_array[$k] = $rcr;
                switch ($rcr['voucher_type']) {
                    case 'rate cut purchase price issue voucher':
                        $new_array[$k]['debit_weight'] = $rcr['gold_weight'];
                        break;
                    case 'rate cut purchase price receipt voucher':
                        $new_array[$k]['credit_weight'] = $rcr['gold_weight'];
                        break;
                    case 'rate cut purchase weight issue voucher':
                        $new_array[$k]['credit_weight'] = $rcr['credit_weight'];
                        break;
                    case 'rate cut purchase weight receipt voucher':
                        $new_array[$k]['debit_weight'] = $rcr['debit_weight'];
                        break;
                }
            }
            foreach ($pre_rate_cut_register as $pk => $prcr) {
                $pre_array[$pk] = $prcr;
                switch ($prcr['voucher_type']) {
                    case 'rate cut purchase price issue voucher':
                        $pre_array[$pk]['debit_weight'] = $prcr['gold_weight'];
                        break;
                    case 'rate cut purchase price receipt voucher':
                        $pre_array[$pk]['credit_weight'] = $prcr['gold_weight'];
                        break;
                    case 'rate cut purchase weight issue voucher':
                        $pre_array[$pk]['credit_weight'] = $prcr['credit_weight'];
                        break;
                    case 'rate cut purchase weight receipt voucher':
                        $pre_array[$pk]['debit_weight'] = $prcr['debit_weight'];
                        break;
                }
            }
           
            $all_vouchers = array_merge($metal_register, $new_array);
            $all_pre_vouchers = array_merge($pre_metal_register, $pre_array);
            unset($param['gold_weight_purity']);
            unset($opening_param['gold_weight_purity']);
            $dispatch_vouchers = $this->sales_purchase_voucher_model->get_cash_dispatch_voucher($param);
            $pre_dispatch_vouchers = $this->sales_purchase_voucher_model->get_cash_dispatch_voucher($opening_param);
            foreach ($dispatch_vouchers as $dk => $dv) {
                $new_array[$key] = $dv;

                $dispatch_vouchers[$dk]['credit_weight'] = $dispatch_vouchers[$dk]['debit_weight'] = 0;
                if ($dv['cash_amount'] < 0) {
                    $dispatch_vouchers[$dk]['debit_weight'] = abs($dv['fine_wt']);
                } else {
                    $dispatch_vouchers[$dk]['credit_weight'] = abs($dv['fine_wt']);
                }
            }

            foreach ($pre_dispatch_vouchers as $pdk => $pdv) {
                $pre_array[$key] = $pdv;

                $pre_dispatch_vouchers[$pdk]['credit_weight'] = $pre_dispatch_vouchers[$pdk]['debit_weight'] = 0;
                if ($pdv['cash_amount'] < 0) {
                    $pre_dispatch_vouchers[$pdk]['debit_weight'] = abs($pdv['fine_wt']);
                } else {
                    $pre_dispatch_vouchers[$pdk]['credit_weight'] = abs($pdv['fine_wt']);
                }
            }

            $all_vouchers = array_merge($all_vouchers, $dispatch_vouchers);
            $all_pre_vouchers = array_merge($all_pre_vouchers, $pre_dispatch_vouchers);
            
            if (empty($all_vouchers)) {
                unset($all_purities[$key]);
                continue;
            }
            $total_opening_credit = $total_opening_debit = 0;
            $total_debit = $total_credit = 0;
            foreach ($all_vouchers as $cr) {
                $total_credit = $total_credit + $cr['credit_weight'];
                $total_debit = $total_debit + $cr['debit_weight'];
            }

            foreach ($all_pre_vouchers as $pcr) {
                $total_opening_credit = $total_opening_credit + $pcr['credit_weight'];
                $total_opening_debit = $total_opening_debit + $pcr['debit_weight'];
            }
            $all_purities[$key]['metal_register'] = $all_vouchers;

            $all_purities[$key]['total_debit'] = $total_debit;
            $all_purities[$key]['total_credit'] = $total_credit;
            $all_purities[$key]['total_opening_credit'] = $total_opening_credit;
            $all_purities[$key]['total_opening_debit'] = $total_opening_debit;
            $all_purities[$key]['balance'] = ($total_debit - $total_credit);
        }
        $data['opening_balance'] = $this->calculate_opening_balance($param);
        $data['all_purities'] = array_values($all_purities);
        $data['company_data'] = $this->company_model->get_company_data();

        $data['from_date'] = $param['from_date'];
        $data['to_date'] = $param['to_date'];
        $print = $this->input->get('print');
        if (isset($print) && $print == 'true') {
            $this->view->print_page('reports/metal_register/print', $data);
        } else {
            $this->view->render('reports/metal_register/index', $data);
        }
    }

    private function array_sum_weight_field($array, $field) {
      $sum = 0;
      foreach ($array as $item) {
        $sum += $item[$field];
      }
      return $sum;
    }

    // private function getParams() {
    //     $param = array(
    //         'from_date' => date('Y-m-01'),
    //         'to_date' => date('Y-m-d'),
    //     );

    //     if (!empty($_GET['from_date'])) {
    //         $param['from_date'] = $_GET['from_date'];
    //     }
    //     if (!empty($_GET['to_date'])) {
    //         $param['to_date'] = $_GET['to_date'];
    //     }

    //     if (isset($_GET['order_column']) && $_GET['order_by'] && !empty($_GET['order_column']) && !empty($_GET['order_by'])) {
    //         $param['order_column'] = $_GET['order_column'];
    //         $param['order_by'] = $_GET['order_by'];
    //     }
    //     $role = $this->session->userdata('accounting_role');
    //     if (isset($role) && $role != 1) {

    //         $param['from_date'] = date('Y-m-d');
    //         $param['to_date'] = date('Y-m-d');
    //         if (!empty($_GET['from_date'])) {
    //             $param['from_date'] = $_GET['from_date'];
    //         }
    //         if (!empty($_GET['to_date'])) {
    //             $param['to_date'] = $_GET['to_date'];
    //         }
    //     }

    //     return $param;
    // }

    

    private function calculate_opening_balance($param) {

        $param['to_date'] = date('Y-m-d', strtotime('-1 day', strtotime($param['from_date'])));
        $param['from_date'] = date('1990-04-01');
        $rate_cut_purities = $this->rate_cut_voucher_model->get_all_purity();
        $metal_purities = $this->metal_voucher_model->get_all_purity();
        $all_purities = array_merge($rate_cut_purities, $metal_purities);
        $sales_purities = $this->sales_purchase_voucher_model->get_all_purity();
        $all_purities = array_merge($all_purities, $sales_purities);
        $all_purities = array_unique($all_purities, SORT_REGULAR);
        foreach ($all_purities as $key => $purity) {
            $param['purity'] = $purity['purity'];
            $metal_register = $rate_cut_register = $new_array = $all_vouchers = array();
            $metal_register = $this->metal_voucher_model->get_metal_register_data($param);
            $param['gold_weight_purity'] = $purity['purity'];
            $rate_cut_register = $this->rate_cut_voucher_model->get_rate_cut_purchase_register_data($param);

            foreach ($rate_cut_register as $k => $rcr) {
                $new_array[$k] = $rcr;
                switch ($rcr['voucher_type']) {
                    case 'rate cut purchase price issue voucher':
                        $new_array[$k]['debit_weight'] = $rcr['gold_weight'];
                        break;
                    case 'rate cut purchase price receipt voucher':
                        $new_array[$k]['credit_weight'] = $rcr['gold_weight'];
                        break;
                    case 'rate cut purchase weight issue voucher':
                        $new_array[$k]['credit_weight'] = $rcr['credit_weight'];
                        break;
                    case 'rate cut purchase weight receipt voucher':
                        $new_array[$k]['debit_weight'] = $rcr['debit_weight'];
                        break;
                }
            }
            $all_vouchers = array_merge($metal_register, $new_array);

            unset($param['gold_weight_purity']);
            $dispatch_vouchers = $this->sales_purchase_voucher_model->get_cash_dispatch_voucher($param);
            foreach ($dispatch_vouchers as $dk => $dv) {
                $new_array[$key] = $dv;

                $dispatch_vouchers[$dk]['credit_weight'] = $dispatch_vouchers[$dk]['debit_weight'] = 0;
                if ($dv['cash_amount'] < 0) {
                    $dispatch_vouchers[$dk]['debit_weight'] = abs($dv['fine_wt']);
                } else {
                    $dispatch_vouchers[$dk]['credit_weight'] = abs($dv['fine_wt']);
                }
            }

            $all_vouchers = array_merge($all_vouchers, $dispatch_vouchers);
            
            if (empty($all_vouchers)) {
                unset($all_purities[$key]);
                continue;
            }
            
            $total_opening_debit_weight = $total_opening_credit_weight = 0;
            foreach ($all_vouchers as $cr) {
                $total_opening_credit_weight = $total_opening_credit_weight + $cr['credit_weight'];
                $total_opening_debit_weight = $total_opening_debit_weight + $cr['debit_weight'];
            }
            

            $all_purities[$key]['total_opening_debit_weight'] = $total_opening_debit_weight;
            $all_purities[$key]['total_opening_credit_weight'] = $total_opening_credit_weight;
            // $all_purities[$key]['balance'] = ($total_debit - $total_credit);
        }
        return $all_purities;
    }
}
