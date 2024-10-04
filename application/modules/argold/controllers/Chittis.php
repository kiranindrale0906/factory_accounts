<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chittis extends BaseController {
  public function __construct() {
    parent::__construct();
    $this->date_fields = array(array('chittis', 'date'));
    $this->redirect_after_save = 'view';
    $this->load->model(array('users/user_model','ac_vouchers/voucher_model','masters/account_model','argold/chitti_empty_packet_detail_model','masters/narration_model','masters/empty_packet_model'));
  }
  
  public function view($id) {
    $this->data['layout'] = 'plain';
    parent::view($id);
  } 
  
  public function index() {
      $show = (isset($_GET['show_all'])) ? $_GET['show_all'] : '';
      $account_names= $this->account_model->get('distinct(name) as name,name as id',array('group_code'=>"Domestic",'sub_group_code!='=>"Domestic Labour Account"));
      $account_name= array_column($account_names,'name');
      $account_chitti_domestic_names= $this->account_model->get('distinct(name) as name,name as id',array('sub_group_code'=>"Domestic Labour Account"));
      $account_chitti_domestic_name= array_column($account_chitti_domestic_names,'name');

      if($this->router->class == 'chitti_exports'){ 
        if($show=='yes') $this->where='account_name not in ("'.implode('", "', $account_name).'")';
        else $this->where='chitti_hide=0 and account_name not in ("'.implode('", "', $account_name).'")';
      }elseif($this->router->class == 'chitti_erps'){ 
        if($show=='yes') $this->where='site_name in ("AR Gold ERP","ARF ERP","ARC ERP","ARNA BANGLE ERP")';
        else $this->where='chitti_hide=0 and site_name in ("AR Gold ERP","ARF ERP","ARC ERP","ARNA BANGLE ERP")';
      }elseif($this->router->class == 'chitti_domestics'){ 
        if($show=='yes') $this->where='account_name in ("'.implode('", "', $account_chitti_domestic_name).'")';
        else $this->where='chitti_hide=0 and account_name in ("'.implode('", "', $account_chitti_domestic_name).'")';      }else{

        if($show=='yes') $this->where='account_name in ("'.implode('", "', $account_name).'")';
        else $this->where='chitti_hide=0 and account_name in ("'.implode('", "', $account_name).'")';
      }
        parent::index();
  }

  public function _get_view_data() {
    $this->data['detail'] = isset($_GET['detail']) ? 1 : 0;
    $this->data['group_by'] = isset($_GET['group_by']) ? 1 : 0;
    $this->data['item_code'] = isset($_GET['item_code']) ? 1 : 0;
    $this->data['account_id']='';

    if($this->data['group_by']==1) {
      if($this->data['item_code']==1){
        $select='sum(fine) as fine,sum(rate) as rate,sum(factory_fine) as factory_fine,sum(credit_weight) as credit_weight,group_concat(DISTINCT(narration)) as narration,purity,chitti_purity,factory_purity,customer_name,group_concat(DISTINCT(item_code)) as item_code';
        $group_by = 'chitti_purity,(factory_purity-chitti_purity),item_code';
      }else{
        $select='sum(fine) as fine,sum(rate) as rate,sum(factory_fine) as factory_fine,sum(credit_weight) as credit_weight,group_concat(DISTINCT(narration)) as narration,purity,chitti_purity,factory_purity,customer_name,item_code';
        $group_by = 'customer_name,chitti_purity,(factory_purity-chitti_purity)';
      }
      $this->data['metal_voucher_details'] = $this->voucher_model->get($select, array('voucher_type' => 'metal issue voucher',
                                                                                 'chitti_id' => $this->data['record']['id']),array(), array('group_by' => $group_by, 'order_by' => 'item_code'));
    }else{
    $this->data['metal_voucher_details'] = $this->voucher_model->get('', array('voucher_type' => 'metal issue voucher',
                                                                               'chitti_id' => $this->data['record']['id']));
    }
    $this->data['empty_packet_details'] = $this->chitti_empty_packet_detail_model->get('', array('chitti_id' => $this->data['record']['id']));
    // $this->data['metal_voucher_details'] = $this->voucher_model->get('', array('voucher_type'=>'metal issue voucher',
    //                                                                            'chitti_id'=>$this->data['record']['id']));
    $packet_no = array_column($this->data['metal_voucher_details'], 'packet_no');
    $this->data['packet_nos']=array_unique($packet_no);

    $this->data['record']['user_name'] = $this->user_model->find('name',array('id'=>$this->data['record']['created_by']))['name'];


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
    // pd($this->data['metal_voucher_details']);
  }

  public function _get_form_data() {
    if (!empty($_GET['account_name'])) $this->data['record']['account_name'] = $_GET['account_name'];
    if (!empty($_GET['purity'])) $this->data['record']['purity'] = $_GET['purity'];
    if (!empty($_GET['factory_user'])) $this->data['record']['factory_user'] = $_GET['factory_user'];
    
//    $this->data['record']['site_name'] = (!empty($this->data['record']['site_name'])) ? $this->data['record']['site_name']: 'AR Gold (Apr 2024)';
    if($this->router->method == 'edit'){
        $this->data['record']['site_name'] = (!empty($this->data['record']['site_name'])) ? $this->data['record']['site_name']: 'AR Gold (Apr 2024)';
    }else{
	$this->data['record']['site_name'] = (!empty($_GET['site_name'])) ? trim($_GET['site_name']) : 'ARF (Apr 2024)';
    }  
  $this->data['site_names'] = get_site_names();
  $this->data['factory_user']=$this->voucher_model->get('factory_user as name,factory_user as id',array('factory_user!='=>""),array(),array('group_by'=>'factory_user'));
    if($this->router->class == 'chitti_exports'){ 
      $this->data['site_names'] = get_site_names(1);
      $this->data['account_name']= $this->account_model->get('distinct(name) as name,name as id',
                                                              array('group_code'=>"Export"));
      $where=array('voucher_type' => 'metal issue voucher',
                   'chitti_id' => '',
                   'site_name' => $this->data['record']['site_name']);
      $account_name= array_column($this->data['account_name'],'name');
      $this->data['purity'] = $this->voucher_model->get('purity as name, purity as id', 
                                 array('where'=>array(
                                       'account_name in ("'.implode('", "', $account_name).'")' => NULL,
                                       'voucher_type' => 'metal issue voucher',
                                       'chitti_id' => 0,
                                       'receipt_type in ("Finish Good","Finished Goods","GPC Out","GPC","Packing Slip","Melting Wastage")'=>NULL)),
                                 array(), array('group_by' => 'purity'));
    } elseif($this->router->class == 'chitti_domestics'){ 
      $this->data['site_names'] = get_site_names(2);
      $this->data['account_name']= $this->account_model->get('distinct(name) as name,name as id',
                                                              array('sub_group_code'=>"Domestic Labour Account"));
      // pd($this->data['account_name']);
      $where=array('voucher_type' => 'metal issue voucher',
                   'chitti_id' => '',
                   'date(voucher_date) > "2022-11-12"' => NULL,
                   'site_name' => $this->data['record']['site_name']);
      $account_name= array_column($this->data['account_name'],'name');

      $this->data['purity'] = $this->voucher_model->get('purity as name, purity as id', 
                                 array('where'=>array(
                                       'account_name in ("'.implode('", "', $account_name).'")' => NULL,
                                       'voucher_type' => 'metal issue voucher',
                                       'chitti_id' => 0,
                                       'receipt_type in ("QC Out")'=>NULL)),
                                 array(), array('group_by' => 'purity'));
//pd($this->data['purity']);
    
    } else {
      $this->data['account_name']= $this->account_model->get('distinct(name) as name,name as id',
                                                              array('group_code'=>"Domestic"));
      $where=array('voucher_type' => 'metal issue voucher',
                   'chitti_id' => '',
                   //'packet_no!=' => 0,
                   'site_name' => $this->data['record']['site_name']);
      $account_name = array_column($this->data['account_name'],'name');
      $this->data['purity'] = $this->voucher_model->get('purity as name, purity as id', 
                              array('where'=>array(
                                    'account_name in ("'.implode('", "', $account_name).'")' => NULL,
                                    'voucher_type' => 'metal issue voucher',
                                    'chitti_id' => 0,
                                    'receipt_type in ("Finish Good","Finished Goods", "GPC Out","GPC","Melting Wastage")'=>NULL)),
                              array(), array('group_by' => 'purity'));
    }

    if (!empty($_GET['purity'])) $where['purity'] = $_GET['purity'];
    if (!empty($_GET['factory_user'])) $where['factory_user'] = $_GET['factory_user'];
    if(!empty($this->data['record']['account_name'])) { 
      $where['account_name']=$this->data['record']['account_name'];
      if($this->router->class == 'chitti_exports'){ 
      $this->data['metal_vouchers'] = $this->voucher_model->get('sum(credit_weight) as credit_weight,
        sum(quantity) as quantity,
                            (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                            (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                            "" as voucher_number,
                            packet_no,
                            voucher_date,
                            item_code,
                            customer_name,
                            usd_wastage_percentage,
                            inr_wastage_percentage,
                            group_concat(DISTINCT(narration)) as narration,
                            argold_id as argold_id', 
                            $where, 
                            array(), 
                            array('group_by'=>'packet_no, voucher_date, usd_wastage_percentage,
                                               inr_wastage_percentage, argold_id,customer_name'));
    }elseif($this->router->class == 'chitti_erps'){ 
    $where['erp_argold_id!=']="";  
    $this->data['metal_vouchers'] = $this->voucher_model->get('sum(credit_weight) as credit_weight,
        sum(quantity) as quantity,
                            (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                            (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                            "" as voucher_number,
                            packet_no,
                            voucher_date,
                            item_code,
                            customer_name,
                            usd_wastage_percentage,
                            inr_wastage_percentage,
                            group_concat(DISTINCT(narration)) as narration,
                            erp_argold_id as argold_id', 
                            $where, 
                            array(), 
                            array('group_by'=>'item_code, voucher_date, usd_wastage_percentage,
                                               inr_wastage_percentage, erp_argold_id,customer_name','order_by'=>"date_format(ac_vouchers.created_at,'%H:%i:%s') asc"));

//pd($this->data['metal_vouchers']);
    }else{
      $this->data['metal_vouchers'] = $this->voucher_model->get('sum(credit_weight) as credit_weight,sum(quantity) as quantity,
                            (sum(credit_weight*purity) / sum(credit_weight)) as purity,
                            (sum(credit_weight*factory_purity) / sum(credit_weight)) as factory_purity,
                            "" as voucher_number,
                            packet_no,
                            voucher_date,
                            customer_name,
                            item_code,
                            rate,
                            group_concat(DISTINCT(narration)) as narration,
                            argold_id as argold_id', 
                            $where, 
                            array(), 
                            array('group_by'=>'packet_no, voucher_date, argold_id, customer_name'));
    }
} else {
      $this->data['metal_vouchers'] = array();
    if($this->router->class == 'chitti_exports'){ 
      if ($this->router->method == 'store' || $this->router->method == 'update') {
        $this->data['record']['chitti_exports'] = $_POST['chitti_exports'];
        $this->data['chittis_details'] = @$_POST['chittis_details'];
      }
    }elseif($this->router->class == 'chitti_erps'){ 
      if ($this->router->method == 'store' || $this->router->method == 'update') {
        $this->data['record']['chitti_erps'] = $_POST['chitti_erps'];
        $this->data['chittis_details'] = @$_POST['chittis_details'];
      }
    }elseif($this->router->class == 'chitti_domestics'){ 
      if ($this->router->method == 'store' || $this->router->method == 'update') {
        $this->data['record']['chitti_domestics'] = $_POST['chitti_domestics'];
        $this->data['chittis_details'] = @$_POST['chittis_details'];
      }
    }else{
      if ($this->router->method == 'store' || $this->router->method == 'update') {
        $this->data['record']['chittis'] = $_POST['chittis'];
        $this->data['chittis_details'] = @$_POST['chittis_details'];
      }
    }
  }

  
    // if($this->router->class == 'chitti_exports'){ 
    //   $this->data['site_names'] = array(
    //                                   array('id' => 'AR Gold', 'name' => 'AR Gold'),
    //                                   array('id' => 'ARF', 'name' => 'ARF'),
    //                                   array('id' => 'ARC', 'name' => 'ARC'),
    //                                   array('id' => 'AR Gold (Aug 2022)', 'name' => 'AR Gold (Aug 2022)'),
    //                                   array('id' => 'ARF (Aug 2022)', 'name' => 'ARF (Aug 2022)'),
    //                                   array('id' => 'ARC (Aug 2022)', 'name' => 'ARC (Aug 2022)'),
    //                                   array('id' => 'Export', 'name' => 'Export'),
    //                                  );
    // }else{
    //   $this->data['site_names'] = array(
    //                                     array('id' => 'AR Gold', 'name' => 'AR Gold'),
    //                                     array('id' => 'ARF', 'name' => 'ARF'),
    //                                     array('id' => 'ARC', 'name' => 'ARC'),
    //                                     array('id' => 'AR Gold (Aug 2022)', 'name' => 'AR Gold (Aug 2022)'),
    //                                     array('id' => 'ARF (Aug 2022)', 'name' => 'ARF (Aug 2022)'),
    //                                     array('id' => 'ARC (Aug 2022)', 'name' => 'ARC (Aug 2022)')
    //                                    );
    // }

    $this->data['empty_packet_weights'] = $this->empty_packet_model->get('distinct(weight) as name, 
                                                                          weight as id',array('weight!='=>''));
    $this->data['empty_packet_quantities'] = $this->empty_packet_model->get('distinct(qty) as name,
                                                                             qty as id',array('qty!='=>''));
    $this->data['purity']=array_merge($this->data['purity'],array(array('id'=>88.322,'name'=>88.322),array('id'=>91.70,'name'=>91.70)));  }

  public function store() {
    $this->data['redirect_url'] = '/argold/chittis';
    parent::store();
  }

  public function delete($id) {
    $voucher_id=!empty($_GET['voucher_id'])?$_GET['voucher_id']:0;
    if (!empty($voucher_id) && $voucher_id!=0) {
      $voucher_details=$this->voucher_model->get('',array('chitti_id'=>$id,'id'=>$voucher_id));
      $this->chitti_model->update_chitti_ids($voucher_details);
      redirect(base_url().'argold/chittis/view/'.$id);
    } else {
      $voucher_details=$this->voucher_model->get('',array('chitti_id'=>$id));
      if(!empty($voucher_details))
        $this->chitti_model->update_chitti_ids($voucher_details);
      parent::delete($id);
    }
  }

  public function _after_save($formdata, $action) {
    if ($this->router->class == 'chitti_exports')
      $this->data['redirect_url']= ADMIN_PATH.'argold/chitti_exports';
    elseif ($this->router->class == 'chitti_erps')
      $this->data['redirect_url']= ADMIN_PATH.'argold/chitti_erps';
    elseif ($this->router->class == 'chitti_domestics')
      $this->data['redirect_url']= ADMIN_PATH.'argold/chitti_domestics';
    else
      $this->data['redirect_url']= ADMIN_PATH.'argold/chittis';
    
    return $formdata;
  }
}
