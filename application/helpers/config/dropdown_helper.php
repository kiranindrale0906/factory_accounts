<?php

  function get_company_list() {
    $ci=&get_instance();
    $ci->load->model('masters/company_model');
    $result = $ci->company_model->get('id,name');
    return $result;
  }

  function get_logo() {
    $ci=&get_instance();
    $ci->load->model('masters/company_model');
    $logo = $ci->company_model->find('logo',array('id'=>!empty($ci->session->userdata('company_id'))?$ci->session->userdata('company_id'):1))['logo'];
    return $logo;
  }

  function get_receipt_type() {
    return array( array('id' => 'Metal', 'name' => 'Metal'),
                  array('id' => 'AR Gold Refresh', 'name' => 'AR Gold Refresh'),
                  array('id' => 'ARC Refresh', 'name' => 'ARC Refresh'),
                  array('id' => 'ARF Refresh', 'name' => 'ARF Refresh'),
                  array('id' => 'Daily Drawer', 'name' => 'Daily Drawer'),
                  array('id' => 'ARC Finished Goods', 'name' => 'ARC Finished Goods'),
                  array('id' => 'ARF Finished Goods', 'name' => 'ARF Finished Goods'),
                );
  }
  function get_issue_type() {
    return array( array('id' => 'Metal', 'name' => 'Metal'),
                  array('id' => 'AR Gold Finished Goods', 'name' => 'AR Gold Finished Goods'),
                  array('id' => 'ARC Finished Goods', 'name' => 'ARC Finished Goods'),
                  array('id' => 'ARF Finished Goods', 'name' => 'ARF Finished Goods'),
                );
  }

  function get_transaction_type() {
    return array( array('id' => 'Cash', 'name' => 'Cash'),
                  array('id' => 'Bill', 'name' => 'Bill'));
  }

  function get_daily_drawer_receipt_type(){
    return array(array('id'=>'Hook','name'=>'Hook'),
                 array('id'=>'KDM','name'=>'KDM'),
                 array('id'=>'Lobster','name'=>'Lobster'),
                 array('id'=>'Ball','name'=>'Ball'),
                 array('id'=>'Solid Pipe','name'=>'Solid Pipe'),
                 array('id'=>'Hollow Pipe','name'=>'Hollow Pipe'),
                 array('id'=>'Solid Wire','name'=>'Solid Wire'),
                 array('id'=>'Cutting Wire','name'=>'Cutting Wire'),
                 array('id'=>'Hard Wire','name'=>'Hard Wire'),
                 array('id'=>'Cutting Pipe','name'=>'Cutting Pipe'),
                 array('id'=>'Para','name'=>'Para'),
                 array('id'=>'I/O Pic','name'=>'I/O Pic'),
                 array('id'=>'Pipe','name'=>'Pipe'),
                 array('id'=>'Anc Chain','name'=>'Anc Chain'),
                 array('id'=>'Stone','name'=>'Stone'),
                 array('id'=>'Sisma Pic','name'=>'Sisma Pic'),
                 array('id'=>'1.8 pipe','name'=>'1.8 pipe'),
                 array('id'=>'1.8mm kajol','name'=>'1.8mm kajol'),
                 array('id'=>'1.8mm clipping','name'=>'1.8mm clipping'),
                 array('id'=>'3mm clipping','name'=>'3mm clipping'),
                 array('id'=>'2mm ball chain','name'=>'2mm ball chain'),
                 array('id'=>'30 anchor','name'=>'30 anchor'),
                 array('id'=>'30 pipe','name'=>'30 pipe'),
                 array('id'=>'4gm fancy box','name'=>'4gm fancy box'),
                 array('id'=>'Box pipe clipping','name'=>'Box pipe clipping'),
                 array('id'=>'Cutting wire 0.5','name'=>'Cutting wire 0.5'),
                 array('id'=>'Cutting wire 0.8','name'=>'Cutting wire 0.8'),
                 array('id'=>'Cutting wire 1.1','name'=>'Cutting wire 1.1'),
                 array('id'=>'Para 2mm','name'=>'Para 2mm'),
                 array('id'=>'Para 3mm','name'=>'Para 3mm'),
                 array('id'=>'Para 4mm','name'=>'Para 4mm'),
                 array('id'=>'Plain Wire 0.4','name'=>'Plain Wire 0.4'),
                 array('id'=>'Plain Wire 0.8','name'=>'Plain Wire 0.8'),
                 array('id'=>'Tibki','name'=>'Tibki'),
                 array('id'=>'Shook','name'=>'S'),
                 array('id'=>'ARF KDM','name'=>'ARF KDM'),
                 array('id'=>'Cap','name'=>'Cap'),
                 array('id'=>'GPC Powder','name'=>'GPC Powder'));
  }

  function get_melting_purity(){
    return array(
             array('id'=>'70.00','name'=>'70.00'),
             array('id'=>'75.15','name'=>'75.15'),
             array('id'=>'83.50','name'=>'83.50'),
             array('id'=>'83.65','name'=>'83.65'),
             array('id'=>'87.65','name'=>'87.65'),
             array('id'=>'92.00','name'=>'92.00'));
  }

  function get_has_hallmark(){
    return array( array('id' => 'Yes', 'name' => 'Yes'),
                  array('id' => 'No', 'name' => 'No'));

  }

