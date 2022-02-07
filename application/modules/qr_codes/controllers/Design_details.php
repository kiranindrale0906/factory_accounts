<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Design_details extends BaseController { 
  public function __construct(){
    parent::__construct();
    $this->load->model(array('qr_codes/qr_code_model'));
  }
   
  public function index() {
    if(!empty($_POST['access_token']) && $_POST['access_token']==API_ACCESS_TOKEN){
      $qr_code_details=(!empty($_POST['access_token']))?$_POST['designs']:array();
      $nov_argold=$nov_arc=$nov_arf=$arf=$argold=$arc=$details=array();
      $qr_codes=array();
      if(!empty($qr_code_details)){
      foreach ($qr_code_details as $index => $detail) {
        if(!empty($detail['factory']) && !empty($detail['version'])){
          if(!empty($detail['id']) && !empty($detail['design_code'])){
            $details[$index]= $this->get_qr_code_records($detail['id'],$detail['design_code'],$detail['factory'],$detail['version']);
           } 
        }else{

          if(!empty($detail['id']) && !empty($detail['design_code'])){
           $argold[$index]=$this->get_qr_code_records($detail['id'],$detail['design_code'],'AR Gold','JAN21');
           $arc[$index]=$this->get_qr_code_records($detail['id'],$detail['design_code'],'ARC','JAN21');
           $arf[$index]=$this->get_qr_code_records($detail['id'],$detail['design_code'],'ARF','JAN21');
          }
        }
      $qr_codes= array_filter(array_merge($arf,$argold,$arc,$details));
      }
    }
    $qr_code_details = []; 
    foreach ($qr_codes as $index =>  $qr_code_record) 
        { 
        $qr_code_details[$index]['id'] = $qr_code_record['id']; 
        $qr_code_details[$index]['gross_weight'] = $qr_code_record['weight']; 
        $qr_code_details[$index]['length'] = $qr_code_record['length']; 
        $qr_code_details[$index]['net_weight'] = $qr_code_record['net_weight']; 
        $qr_code_details[$index]['total_stone'] = $qr_code_record['total_stone']; 
        $qr_code_details[$index]['less'] = $qr_code_record['less']; 
        $qr_code_details[$index]['purity'] = $qr_code_record['purity']; 
        $qr_code_details[$index]['design_code'] = $qr_code_record['design_code']; 
        $qr_code_details[$index]['stone_count'] = $qr_code_record['stone_count']; 
        $path=$qr_code_record['path'];
          if(!empty($qr_code_record['image'])){
            $qr_code_details[$index]['image']='https://'.$path.$qr_code_record['image'];
          }
         
    }
    echo json_encode(array('data'    =>$qr_code_details,
                         'status'      => 'success',
                         'open_modal'  => FALSE));die;
  }else{
    echo json_encode(array('status'      => 'error',
                         'open_modal'  => FALSE));die;
  }
}

  private function get_qr_code_records($id,$design_code,$factory,$version){
    $db_name=get_database_name_from_factory_and_version($factory.' '.$version)['database'];
    $url=get_database_name_from_factory_and_version($factory.' '.$version)['url'];
    $path=$url."/uploads/original/original/";
    $records=$this->db->query("select id,weight,length,net_weight,total_stone,less,percentage,purity,design_code,stone_count,image,'".$path."' as path from  ".$db_name.". qr_code_details where id = ".$id." and design_code = '".$design_code."'");
    $qr_details= $records->row_array();
    return  $qr_details;    
  }
}
