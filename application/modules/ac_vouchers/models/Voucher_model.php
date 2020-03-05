<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Voucher_model extends BaseModel {
  protected $table_name = "ac_vouchers";
  //protected $insert_to_ledger = true;
  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('masters/period_model'));
  }

  public function validation_rules($klass='') {
    $rules[] =array('field' => $this->router_class.'[voucher_date]', 'label' => 'Date',
                    'rules' => array('trim', 'required', 
                               array('validate_voucher_date', array($this, 'check_period_exists'))),
                    'errors'=>array('validate_voucher_date' => "Please set the Financial year from master."));
    $rules[] = array('field' => $this->router_class.'[account_name]', 'label' => 'Account Name',
                     'rules' => 'trim|required');


    $check_credit_debit_type=stripos($this->router_class,'issue');
    if($this->router->class=="cash_issue_vouchers" || $this->router->class=="cash_receipt_vouchers") {
      if($check_credit_debit_type==true) {
        $credit_rules[] = array('field' => $this->router_class.'[credit_amount]', 
                        'label' => 'Credit Amount',
                        'rules' => 'trim|required|numeric|greater_than[0]');
        $rules=array_merge($rules,$credit_rules);
      }
      else {
        $debit_rules[] = array('field' => $this->router_class.'[debit_amount]', 
                        'label' => 'Debit Amount',
                        'rules' => 'trim|required|numeric|greater_than[0]');
        $rules=array_merge($rules,$debit_rules);
      }
    }

    if($this->router->class=="metal_issue_vouchers" || $this->router->class=="metal_receipt_vouchers") {
      $rules[]=array('field' => $this->router_class.'[purity]', 
                    'label' => 'Purity',
                    'rules' => 'trim|required|numeric|less_than_equal_to[100]');
      $rules[]=array('field' => $this->router_class.'[factory_purity]', 
                    'label' => 'Factory Purity',
                    'rules' => 'trim|required|numeric|less_than_equal_to[100]');
      if($check_credit_debit_type==true) {
        $credit_rules[] = array('field' => $this->router_class.'[credit_weight]', 
                        'label' => 'Credit Weight',
                        'rules' => 'trim|required|numeric|greater_than[0]');
        $rules=array_merge($rules,$credit_rules);
      }
      else {
        $debit_rules[] = array('field' => $this->router_class.'[debit_weight]', 
                        'label' => 'Debit Weight',
                        'rules' => 'trim|required|numeric|greater_than[0]');
        $rules=array_merge($rules,$debit_rules);
      }
    }

    return $rules;
  }

  public function before_save($action) {
    $this->set_user_define_data();
  }

  public function check_period_exists($voucher_date) {
    $voucher_date=date('Y-m-d',strtotime($voucher_date));  
    $period_id = $this->period_model->get('id', array('where'=>
                                            array('"'.$voucher_date.'" between date_from and date_to'=>NULL)));
    if(!empty($period_id[0]['id']))
      return $period_id[0]['id'];
    else
      return false;
  }

  private function set_user_define_data() {
    $this->formdata[$this->router_class]['suffix'] = $this->prefix;
    $this->formdata[$this->router_class]['voucher_type'] = $this->voucher_type;
    $this->formdata[$this->router_class]['transaction_type'] = $this->account_type;

    $account = $this->account_model->find('id',array('name'=>$this->attributes['account_name']));
    $this->formdata[$this->router_class]['account_id'] = $account['id'];

    $period_id = $this->check_period_exists($this->attributes['voucher_date']);
    $this->formdata[$this->router_class]['period_id'] = $period_id;
    $voucher_serial_number = $this->create_voucher_serial_number($this->voucher_type,$period_id);
    $this->formdata[$this->router_class]['voucher_serial_number'] = $voucher_serial_number;

    $voucher_number = $this->create_voucher_number($this->prefix,$voucher_serial_number,
                                                   $this->attributes['voucher_date']);
    $this->formdata[$this->router_class]['voucher_number'] = $voucher_number;

  }

  public function create_voucher_serial_number($voucher_type,$period_id) {
    $voucher_serial_number = $this->get_serial_number($voucher_type,$period_id);
    $company_id = (!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):0);
    if(!empty($voucher_serial_number))
      $voucher_serial_number=$voucher_serial_number+1;
    else
      $voucher_serial_number=1;
    
    return $voucher_serial_number;
  }

  public function create_voucher_number($prefix,$voucher_serial_number,$date) {

    $voucher_number = $prefix . '/' . $voucher_serial_number . '/' . date('dmy', strtotime($date));
    return $voucher_number;
  }

  private function get_serial_number($voucher_type,$period_id='') {
    $company_id=(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):0);
    $result=$this->find('max(voucher_serial_number) as v_serial_number',array('period_id'=>$period_id,
                                                                                'company_id'=>$company_id,
                                                                                'voucher_type'=>$voucher_type));
    if(!empty($result['v_serial_number']))
      return $result['v_serial_number'];
    else
      return false;
  }

  public function after_save($action) {
    $company_id=(!empty($this->session->userdata('company_id'))?$this->session->userdata('company_id'):0);
    $voucher_number=true;
    if($action=="update")
      $voucher_number = $this->delete_ledger_voucher_record($this->attributes['id'],$company_id);

    if ($voucher_number) {
      $ledger_data=$this->set_ledger_data($this->attributes);
      $obj_ledeger = new ledger_model($ledger_data);
      $obj_ledeger->store(false);
      if(!empty($this->attributes['receipt_type'])) {
        $this->send_request_to_argold($this->attributes);  
      }
      
      // call_api('BASE_PATH'.$id, $data)
    } else {
        return;
    }
  }

  private function set_ledger_data($result) {
    $ledger_data = array();
    if (in_array($this->router->class, array('cash_issue_voucher', 'cash_receipt_voucher'))) {
      $ledger_data['cash_bill_type'] = 'cash';
    }
    if (in_array($this->router->class, array('bank_issue_voucher', 'bank_receipt_voucher'))) {
      $ledger_data['cash_bill_type'] = 'bill';
    }
    if (in_array($this->router->class, array('metal_issue_voucher', 'metal_receipt_voucher'))) {
      $ledger_data['cash_bill_type'] = 'metal';
    }
      
    $ledger_data['account_id'] =   $result['account_id'];
    $ledger_data['account_name'] = $result['account_name'];
    $ledger_data['voucher_type'] = $result['voucher_type'];
    $ledger_data['suffix'] = $this->prefix;
    $ledger_data['voucher_date'] = $result['voucher_date'];
    $ledger_data['credit_amount'] = !empty($result['credit_amount'])?$result['credit_amount']:0;
    $ledger_data['debit_amount'] = !empty($result['debit_amount']) ? $result['debit_amount'] :0;
    $ledger_data['credit_weight'] = !empty($result['credit_weight'])?$result['credit_weight']:0;
    $ledger_data['debit_weight'] = !empty($result['debit_weight'])?$result['debit_weight']:0; 
    $ledger_data['narration'] = !empty($result['narration'])?$result['narration']:''; 
    $ledger_data['table_name'] = $this->table_name;
    $ledger_data['table_id'] = $result['id'];
    $ledger_data['voucher_number'] = $result['voucher_number'];
    $ledger_data['company_id'] = $result['company_id'];
    $ledger_data['factory_purity'] = !empty($result['factory_purity'])?$result['factory_purity']:0;
    $ledger_data['purity_margin'] = !empty($result['purity_margin'])?$result['purity_margin']:0;
    $ledger_data['receipt_type'] = !empty($result['receipt_type'])?$result['receipt_type']:'';
    return $ledger_data;
  }

  private function delete_ledger_voucher_record($id,$company_id) {
    $obj_leger=new ledger_model();
    $obj_leger->delete('',array('table_id'=>$id),true);
    return true;
  }


  private function send_request_to_argold($data) {
    $send_data=array();
    $api_url="";

    if($data['receipt_type']=="Metal") {
      $send_data['receipt_departments']=array('type'=>'Pure',
                                            'account'=> $data['account_name'],
                                            'in_weight' => $data['debit_weight'],
                                            'in_lot_purity' => $data['factory_purity'],
                                            'description' =>$data['narration'],
                                            'process_name'=>'Receipt');
      $api_url=API_BASE_PATH."api/api_receipt_departments/store";   
    }
    else if($data['receipt_type']=="Refresh") {
      // refresh_departments[hook_kdm_purity]:90
      // refresh_departments[quantity]:2
      $send_data['refresh_departments']=array('type'=>'Pure',
                                            'account'=> $data['account_name'],
                                            'in_weight' => $data['debit_weight'],
                                            'in_lot_purity' => $data['factory_purity'],
                                            'description' =>$data['narration'],
                                            'process_name'=>'Refresh');
      $api_url=API_BASE_PATH."api/api_refresh_departments/store";   
    }
    else if($data['receipt_type']=="Daily Drawer") {
      $send_data['daily_drawer_receipts']=array('type'=>'Hook',
                                                'account'=> $data['account_name'],
                                                'in_weight' => $data['debit_weight'],
                                                'in_lot_purity' => $data['factory_purity'],
                                                'karigar'=> 'Factory',
                                                'description' =>$data['narration']);
      $api_url=API_BASE_PATH."api/api_daily_drawer_receipts/store";   
    }
    
    // if(is_callable('curl_init')) {
    //       pd("Enabled");
    //     }
    //     else
    //     {
    //        echo "Not enabled";
    //     }
        //die;
    if(!empty($api_url)) {
      //echo $api_url;die;
      $result=curl_post_request($api_url, $send_data);
      pd($result);die;
    }
  }

  //public function after_delete($id,$conditions) {
    // $ledger_id=$this->Ledger_model->get('id',
    //                                     array(
    //                                       array(
    //                                         'table_id'=>$id)));
    // if(!empty($ledger_id)) {
    //   foreach ($ledger_id as $k_ledger => $ledgerid) :
    //     if(!empty($ledgerid["id"])) 
    //       $this->Ledger_model->delete($ledgerid["id"]);
    //   endforeach;
    // }
  //}

  // public function get_max_voucher($date, $suffix) {
  //     $this->db->select('count(id) as count');
  //     $this->db->from($this->table_name);
  //     $this->db->where('date', $date);
  //     $this->db->where('suffix', $suffix);
  //     $query = $this->db->get()->row_array();
  //     return $query['count'];
  // }

  // public function get_cash_register_data($param) {
  //     $where = '(suffix="CI" or suffix = "CR")';
  //     $this->db->select('*');
  //     $this->db->from($this->table_name);
  //     $this->db->where($where);
  //     $this->db->where('month(date)', date('m'));
  //     $this->db->where('company_id', $this->session->userdata('company_id'));
  //     $this->get_date_filter($param);
  //     $this->db->order_by("date", "asc");
  //     return $this->db->get()->result_array();
  // }

  // public function get_bank_register_data($param) {
  //     $where = '(suffix="BI" or suffix = "BR")';
  //     $this->db->select('*');
  //     $this->db->from($this->table_name);
  //     $this->db->where($where);
  //     $this->db->where('month(date)', date('m'));
  //     $this->db->where('company_id', $this->session->userdata('company_id'));
  //     $this->get_date_filter($param);
  //     $this->get_current_date_data();
  //     $this->db->order_by("date", "asc");
  //     return $this->db->get()->result_array();
  // }

  // private function  delete_ledger_record($id){
  //     $this->db->select('voucher_number');
  //     $this->db->from($this->table_name);
  //     $this->db->where('id', $id);
  //     $this->db->where('company_id', $this->session->userdata('company_id'));
  //     $query = $this->db->get()->row_array();
  //     if($query){
  //       $this->db->where('voucher_number', $query['voucher_number']);
  //       $this->db->delete('ac_ledger'); 
  //       return true;
  //     }else{
  //         return false;
  //     }
  // }

  // private function get_date_filter($param) {
  //     if (!empty($param['from_date']) && !empty($param['to_date'])) {
  //         $this->db->where(''.$this->table_name.'.date between"' . date('Y-m-d', strtotime($param['from_date'])) . '  00:00:00" AND "' . date('Y-m-d', strtotime($param['to_date'])) . ' 23:59:59"');
  //     }
  // }

  // private function get_current_date_data() {
  //     if (empty($_GET['from_date']) && empty($_GET['to_date'])) {
  //         $this->db->where('date',date('Y-m-d'));
  //     }
  // }

  // private function get_bank_filter() {
  //     if (!empty($_GET['bank_name'])) {
  //         $this->db->where('bank_name',$_GET['bank_name']);
  //     }
  // }

  // public function calculate_currentdate_amount($amount_field, $suffix) {
  //     $total_amount = 0;
  //     $date = date('Y-m-d');
  //     $this->db->select('*');
  //     $this->db->from($this->table_name);
  //     $this->db->where('date', $date);
  //     $this->db->where('suffix', $suffix);
  //     $this->db->where('company_id', $this->session->userdata('company_id'));
  //     $query = $this->db->get();
  //     if ($query->num_rows() > 0) {
  //         foreach ($query->result_array() as $result) {
  //             $total_amount += $result[$amount_field];
  //         }
  //     }
  //     return $total_amount;
  // }

}

//class