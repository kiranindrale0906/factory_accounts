<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Voucher_model extends BaseModel {
  protected $table_name = "ac_vouchers";
  function __construct($data=array()) {
    parent::__construct($data);
    $this->load->model(array('masters/period_model','masters/setting_model','transactions/Receipt_not_sent_argold_model'));
  }

  public function validation_rules($klass='') {
    $rules[] =array('field' => $this->router_class.'[voucher_date]',
                    'label' => 'Date',
                    'rules' => array('trim', 'required', 
                               array('validate_voucher_date', array($this, 'check_period_exists'))),
                    'errors'=>array('validate_voucher_date' => "Please set the Financial year from master."));
    $rules[] = array('field' => $this->router_class.'[account_name]',
                     'label' => 'Account Name','rules' => 'trim|required');
    if($this->router->class=="bank_issue_vouchers" || $this->router->class=="bank_receipt_vouchers") {
    $rules[] = array('field' => $this->router_class.'[bank_name]', 'label' => 'Bank Name','rules' => 'trim|required');
    }

    if($this->router->class=="expense_vouchers") {
    $rules[] = array('field' => $this->router_class.'[to_group_name]',
                     'label' => 'To Group Name',
                     'rules'  =>array('trim','required',
                                array('group_name_error_msg',array($this,'check_group_name_exist'))),
                     'errors' => array('group_name_error_msg'=>'Group name not exist in group master.'));
    $rules[] = array('field' => $this->router_class.'[debit_amount]', 'label' => 'Amount','rules' => 'trim|required');
    }

    $check_credit_debit_type=stripos($this->router_class,'issue');
    if($this->router->class=="cash_issue_vouchers" || $this->router->class=="cash_receipt_vouchers" || $this->router->class=="bank_issue_vouchers" || $this->router->class=="bank_receipt_vouchers") {
      if($check_credit_debit_type==true) {
        $debit_rules[] = array('field' => $this->router_class.'[credit_amount]', 
                        'label' => 'credit Amount',
                        'rules' => 'trim|required|numeric|greater_than[0]');
        $rules=array_merge($rules,$debit_rules);
      
       }
      else {
         $credit_rules[] = array('field' => $this->router_class.'[debit_amount]', 
                        'label' => 'Debit Amount',
                        'rules' => 'trim|required|numeric|greater_than[0]');
        $rules=array_merge($rules,$credit_rules);
      
        }
    }

    if($this->router->class=="metal_issue_vouchers" || $this->router->class=="metal_receipt_vouchers") {
      $rules[]=array('field' => $this->router_class.'[purity]', 
                    'label' => 'Purity',
                    'rules'  =>array('trim','required','numeric','less_than_equal_to[100]',
                     array('purity_error_msg',array($this,'check_purity_exist'))),
                     'errors' => array('purity_error_msg'=>'Purity not exist in Purity master.'));
      
      if($check_credit_debit_type==true) {
        $debit_rules[] = array('field' => $this->router_class.'[debit_weight]', 
                        'label' => 'Debit Weight',
                        'rules' => 'trim|required|numeric|greater_than[0]');
        $rules=array_merge($rules,$debit_rules);
      
        }
      else {
        $credit_rules[] = array('field' => $this->router_class.'[credit_weight]', 
                        'label' => 'Credit Weight',
                        'rules' => 'trim|required|numeric|greater_than[0]');
        $rules=array_merge($rules,$credit_rules);
      
        }
    }

    return $rules;
  }

  public function check_group_name_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $groups=$this->group_model->find('id as id',array('name'=>$name));
    return (empty($groups)) ? false : true;
  }
  public function check_narration_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $narration=$this->narration_model->find('id as id',array('name'=>$name));
    return (empty($narration)) ? false : true;
  } 
  public function check_purity_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $purity=$this->purity_model->find('id as id',array('purity'=>$name));
    return (empty($purity)) ? false : true;
  }
  public function check_department_exist($name) {
    if($name=="" && !isset($name))
      return true;
    else
    $department=$this->department_model->find('id as id',array('name'=>$name));
    return (empty($department)) ? false : true;
  }

  public function before_save($action) {
    unset($this->attributes['arg_weight']);
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
    if($this->router_class=="metal_issue_vouchers") {
      if(!is_numeric($this->attributes['company_id'])) {
        $company_detail=$this->company_model->find('id',array('name'=>$this->attributes['company_id']));
        $this->attributes['company_id']=$company_detail['id'];
      }
    }

    $this->formdata[$this->router_class]['suffix'] = $this->prefix;
    $this->formdata[$this->router_class]['voucher_type'] = $this->voucher_type;
    // $this->formdata[$this->router_class]['transaction_type'] = $this->account_type;

    $account = $this->account_model->find('id,group_id,route_group,sub_group_id',array('name'=>$this->attributes['account_name']));
    if(!empty($account['id'])) {    
      $this->formdata[$this->router_class]['group_id'] =!empty($account['group_id'])?$account['group_id']:0;
      $this->formdata[$this->router_class]['sub_group_id'] =!empty($account['sub_group_id'])?$account['sub_group_id']:0;
      $this->formdata[$this->router_class]['route_group'] =!empty($account['route_group'])?$account['route_group']:'';
      }
    if(empty($account['id'])) {
      $sub_groups=$this->setting_model->find('id,value',array('name'=>'Sub Group'));
      $account_detail['name']=$this->attributes['account_name'];
      $account_detail['sub_group_code']=!empty($sub_groups['value'])?$sub_groups['value']:'';
      $account_detail['sub_group_id']=!empty($sub_groups['id'])?$sub_groups['id']:0;
      $obj_account = new account_model($account_detail);
      $account_details=$obj_account->store(false);
      $account['id']=$account_details['id'];      
    }

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
    } 
if($this->router->class=="metal_receipt_vouchers") {
      $this->load->model('transactions/metal_issue_voucher_model');
      if(!empty($this->formdata['metal_issue_vouchers'])) {
        foreach ($this->formdata['metal_issue_vouchers'] as $voucher_record) {
          $metal_issue_data = array();
          $metal_issue_data=$voucher_record;

          $account = $this->account_model->find('id',array('name'=>$metal_issue_data['account_name']));
          if(empty($account['id'])) {
            $account_detail['name']=$metal_issue_data['account_name'];
            $obj_account = new account_model($account_detail);
            $account_details=$obj_account->store(false);
            $account['id']=$account_details['id'];      
          }

          $metal_issue_data['company_id']  = $this->attributes['company_id'];
          $metal_issue_data['metal_receipt_voucher_reference_id']  = $this->attributes['id'];
          $metal_issue_data['voucher_date'] = $this->attributes['voucher_date'];
          $metal_issue_data['account_id']=$account['id'];
          $metal_issue_data['receipt_type'] = $this->attributes['receipt_type'];
          $metal_issue_data['purity'] = $this->attributes['purity'];
          $metal_issue_data['fine'] = $voucher_record['credit_weight']*$this->attributes['purity']/100;
          $metal_issue_data['narration'] = $this->attributes['narration'];
          $metal_issue_data['suffix'] = "MI";
          $metal_issue_data['voucher_type'] = "metal issue voucher";
          $metal_issue_data['transaction_type'] = 'account';
          $period_id = $this->attributes['period_id'];
          $voucher_serial_number = $this->create_voucher_serial_number($metal_issue_data['voucher_type'],
                                                                       $period_id);
          $metal_issue_data['voucher_serial_number'] = $voucher_serial_number;

          $voucher_number = $this->create_voucher_number($metal_issue_data['suffix'],$voucher_serial_number,
                                                         $this->attributes['voucher_date']);
          $metal_issue_data['voucher_number'] = $voucher_number;

          $purity_margin=($metal_issue_data['purity']-$metal_issue_data['factory_purity'])*$metal_issue_data['credit_weight']/100;
          $metal_issue_data['purity_margin'] = $purity_margin;
          //pd($data);
          $obj_metal_issue_voucher=new metal_issue_voucher_model($metal_issue_data);
          $obj_metal_issue_voucher->store(false);
          
          $metal_issue_data['id']=$obj_metal_issue_voucher->attributes['id'];
          $ledger_data=$this->set_ledger_data($metal_issue_data);
          $obj_ledeger = new ledger_model($ledger_data);
          $obj_ledeger->store(false);
        }
      }
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
    $dump_data_on_error=array();
    $result['status']='';
    $credit_weight=0;
    $in_weight=0;
    foreach ($this->formdata['metal_issue_vouchers'] as $metal_issue_voucher) {
      pd($metal_issue_voucher);
        // $credit_weight += $metal_issue_voucher['credit_weight'];
    }
    $in_weight=$data['credit_weight']-$credit_weight;
    if($this->router->class=="metal_receipt_vouchers" && $in_weight!=0) {
      if($data['receipt_type']=="Metal") {
        $send_data['receipt_departments']=array('type'=>'Pure',
                                              'account'=> $data['account_name'],
                                              'in_weight' => $in_weight,
                                              'in_lot_purity' => $data['factory_purity'],
                                              'description' =>$data['narration'],
                                              'process_name'=>'Receipt',
                                              'argold_account_id'=>$data['id']);
        
        $dump_data_on_error=$send_data['receipt_departments'];
        $api_url=API_BASE_PATH."api/api_receipt_departments/store";   
      }
      else if($data['receipt_type']=="Refresh") {
        $send_data['refresh_departments']=array('type'=>'Pure',
                                              'account'=> $data['account_name'],
                                              'in_weight' => $in_weight,
                                              'in_lot_purity' => $data['factory_purity'],
                                              'description' =>$data['narration'],
                                              'hook_kdm_purity' => $data['hook_kdm_purity'],
                                              'quantity' => $data['quantity'],
                                              'process_name'=>'Refresh',
                                              'argold_account_id'=>$data['id']);
        $dump_data_on_error=$send_data['refresh_departments'];
        $api_url=API_BASE_PATH."api/api_refresh_departments/store";   
      }
      else if($data['receipt_type']=="Daily Drawer") {
        $send_data['daily_drawer_receipts']=array('type'=>$data['type'],
                                                  'account'=> $data['account_name'],
                                                  'in_weight' => $in_weight,
                                                  'in_lot_purity' => $data['factory_purity'],
                                                  'karigar'=> 'Factory',
                                                  'description' =>$data['narration'],
                                                  'argold_account_id'=>$data['id']);
        $dump_data_on_error=$send_data['daily_drawer_receipts'];
        $api_url=API_BASE_PATH."api/api_daily_drawer_receipts/store";   
      }
      if(!empty($api_url)) {
        $result=curl_post_request($api_url, $send_data);
        if(empty($result) || (!empty($result['status']) && $result['status']=="error")) {
          $dump_data_on_error=array_merge($dump_data_on_error,array('api_url'=>$api_url));
          $obj_receipt_not_sent=new Receipt_not_sent_argold_model($dump_data_on_error);
          $obj_receipt_not_sent->store(false);
        }
      }
    }
  }
  }

//class