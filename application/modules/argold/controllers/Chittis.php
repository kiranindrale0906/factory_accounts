<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chittis extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('chittis', 'date'));
    $this->redirect_after_save = 'view';
    $this->load->model(array('ac_vouchers/voucher_model','masters/account_model','masters/narration_model'));
  }
  
  public function view($id) {
    $this->data['layout'] = 'plain';
    parent::view($id);
  } 
  // public function index() {
  //     $show = (isset($_GET['show_all'])) ? $_GET['show_all'] : '';
  //     $account_names= $this->account_model->get('distinct(name) as name,name as id',array('group_code'=>"Domestic"));
  //     $account_name= array_column($account_names,'name');

  //     if($this->router->class == 'chitti_exports'){ 
  //       if($show=='yes') $this->where='account_name not in ("'.implode('", "', $account_name).'")';
  //       else $this->where='chitti_hide=0 and account_name not in ("'.implode('", "', $account_name).'")';
  //     }else{

  //       if($show=='yes') $this->where='account_name in ("'.implode('", "', $account_name).'")';
  //       else $this->where='chitti_hide=0 and account_name in ("'.implode('", "', $account_name).'")';
  //     }
  //       parent::index();
  // }

  public function _get_view_data() {
    $this->data['detail'] = isset($_GET['detail']) ? 1 : 0;
    $this->data['account_id']='';
    $this->data['metal_voucher_details'] = $this->voucher_model->get('', array('voucher_type' => 'metal issue voucher',
                                                                               'chitti_id' => $this->data['record']['id']));
    // $this->data['metal_voucher_details'] = $this->voucher_model->get('', array('voucher_type'=>'metal issue voucher',
    //                                                                            'chitti_id'=>$this->data['record']['id']));
    $packet_no = array_column($this->data['metal_voucher_details'], 'packet_no');
    $this->data['packet_nos']=array_unique($packet_no);

    $this->data['chittis_details'] = $this->chitti_model->find('account_name, date',
                                                               array('id'=>$this->data['record']['id']));

    // foreach ($this->data['metal_voucher_details'] as $index => $metal_voucher_detail) {
    //   $narration = $this->narration_model->find('chitti_purity', array('name' => $metal_voucher_detail['narration'],
    //                                                                    'chain_purity' => $metal_voucher_detail['purity']));
    //   if (!empty($narration))
    //     $this->data['metal_voucher_details'][$index]['chitti_purity'] = $narration['chitti_purity'];
    //   else
    //     $this->data['metal_voucher_details'][$index]['chitti_purity'] = 0;
    // }
  }

  public function _get_form_data() {
    if (!empty($_GET['account_name'])){
      $this->data['record']['account_name'] = $_GET['account_name'];
    }
    if (!empty($_GET['purity'])){
      $this->data['record']['purity'] = $_GET['purity'];
    }

    
    
    $this->data['record']['site_name'] = (!empty($_GET['site_name'])) ? $_GET['site_name'] : 'AR Gold Jan 2021';
    if($this->router->class == 'chitti_exports'){ 
     $this->data['account_name']= $this->account_model->get('distinct(name) as name,name as id',array('group_code'=>"Export"));
      $where=array('voucher_type' => 'metal issue voucher',
                   'chitti_id' => '',
                   'site_name' => $this->data['record']['site_name']);
      $account_name= array_column($this->data['account_name'],'name');
      $this->data['purity'] = $this->voucher_model->get('purity as name, purity as id', 
                                                       array('where'=>array(
                                                               'account_name in ("'.implode('", "', $account_name).'")' => NULL,
                                                               'voucher_type' => 'metal issue voucher',
                                                               'chitti_id' => 0,
                                                               'receipt_type in ("Finish Good","GPC Out")'=>NULL
                                                             )) ,
                                                       array(), array('group_by' => 'purity'));
    
    }else{
      $this->data['account_name']= $this->account_model->get('distinct(name) as name,name as id',array('group_code'=>"Domestic"));
      $where=array('voucher_type' => 'metal issue voucher',
                   'chitti_id' => '',
                   'packet_no!=' => 0,
                   'site_name' => $this->data['record']['site_name']);
      $account_name= array_column($this->data['account_name'],'name');
      $this->data['purity'] = $this->voucher_model->get('purity as name, purity as id', 
                                                       array('where'=>array(
                                                               'account_name in ("'.implode('", "', $account_name).'")' => NULL,
                                                               'voucher_type' => 'metal issue voucher',
                                                               'chitti_id' => 0,
                                                               'receipt_type in ("Finish Good","GPC Out")'=>NULL
                                                             )) ,
                                                       array(), array('group_by' => 'purity'));
    
    }
    if (!empty($_GET['purity'])){
     $where['purity'] = $_GET['purity'];
    }

    if(!empty($this->data['record']['account_name'])) { 
      $where['account_name']=$this->data['record']['account_name'];
      if($this->router->class == 'chitti_exports'){ 
      $this->data['metal_vouchers'] = $this->voucher_model->get('sum(credit_weight) as credit_weight,
                                                                  (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                                                                  (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                                                                  "" as voucher_number,
                                                                  packet_no,
                                                                  voucher_date,
                                                                  customer_name,
                                                                  usd_wastage_percentage,
                                                                  inr_wastage_percentage,
                                                                  group_concat(narration) as narration,
                                                                  argold_id as argold_id', 
                                                                  $where, 
                                                                  array(), 
                                                                  array('group_by'=>'packet_no,
                                                                                     voucher_date, 
                                                                                     usd_wastage_percentage,
                                                                                     inr_wastage_percentage,
                                                                                     argold_id,customer_name'));
    }else{
      $this->data['metal_vouchers'] = $this->voucher_model->get('sum(credit_weight) as credit_weight,
                                                                  (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                                                                  (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                                                                  "" as voucher_number,
                                                                  packet_no,
                                                                  voucher_date,
                                                                  customer_name,
                                                                  group_concat(narration) as narration,
                                                                  argold_id as argold_id', 
                                                                  $where, 
                                                                  array(), 
                                                                  array('group_by'=>'packet_no,
                                                                                     voucher_date, 
                                                                                     argold_id,customer_name'));

    }



  } else{
      $this->data['metal_vouchers'] = array();
    if($this->router->class == 'chitti_exports'){ 
      if ($this->router->method == 'store' || $this->router->method == 'update') {
        $this->data['record']['chitti_exports'] = $_POST['chitti_exports'];
        $this->data['chittis_details'] = @$_POST['chittis_details'];
      }
    }else{
      if ($this->router->method == 'store' || $this->router->method == 'update') {
      $this->data['record']['chittis'] = $_POST['chittis'];
      $this->data['chittis_details'] = @$_POST['chittis_details'];
      }
    }

  }
        
    $this->data['site_names'] = array(
                                      array('id' => 'AR Gold Jan 2021', 'name' => 'AR Gold Jan 2021'),
                                      array('id' => 'ARF Jan 2021', 'name' => 'ARF Jan 2021'),
                                      array('id' => 'ARC Jan 2021', 'name' => 'ARC Jan 2021')
                                     );
}

  public function store() {
    $this->data['redirect_url'] = '/argold/chittis';
    parent::store();
  }
  public function delete($id) {
    $voucher_id=!empty($_GET['voucher_id'])?$_GET['voucher_id']:0;
    if(!empty($voucher_id) && $voucher_id!=0){
      $voucher_details=$this->voucher_model->get('',array('chitti_id'=>$id,'id'=>$voucher_id));
      $this->chitti_model->update_chitti_ids($voucher_details);
      redirect(base_url().'argold/chittis/view/'.$id);
    }else{
      $voucher_details=$this->voucher_model->get('',array('chitti_id'=>$id));
      if(!empty($voucher_details)){
        $this->chitti_model->update_chitti_ids($voucher_details);
      }
      parent::delete($id);
    }
  }
  public function _after_save($formdata, $action){
    if($this->router->class == 'chitti_exports'){ 
     $this->data['redirect_url']= ADMIN_PATH.'argold/chitti_exports';
    }else{
     $this->data['redirect_url']= ADMIN_PATH.'argold/chittis';
    }
    return $formdata;
  }
}