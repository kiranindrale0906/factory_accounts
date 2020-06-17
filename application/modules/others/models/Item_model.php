<?php

class Item_model extends BaseModel {

  protected $table_name = "ac_item";
  protected $id = "id";
  public $router_class = "items";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {

  return array(
            array('field' => 'items[name]', 'label' => 'Name', 'rules' => 'trim|required'),
            array('field' => 'items[item_code]', 'label' => 'items Code', 'rules' => 'trim|required'),
            array('field' => 'items[avg_melting]', 'label' => 'Avg. Melting', 'rules' => 'trim|required|numeric'),
            array('field' => 'items[melting_from]', 'label' => 'Melting From', 'rules' => 'trim|required|numeric|less_than_equal_to[100]'),
            array('field' => 'items[melting_to]', 'label' => 'Melting To', 'rules' => 'trim|required|numeric|less_than_equal_to[100]'),

          );
  }
  }
