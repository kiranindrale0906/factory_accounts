<?php

class Category_model extends BaseModel {

  protected $table_name = "ac_category";
  protected $id = "id";
  public $router_class = "categories";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
      return array(
            array('field' => 'categories[name]', 'label' => 'Name', 'rules' => 'trim|required'),
            array('field' => 'categories[category_code]', 'label' => 'Category Code', 'rules' => 'trim|required'),
            array('field' => 'categories[avg_melting]', 'label' => 'Avg. Melting', 'rules' => 'trim|required|numeric')
          );
    }
  }