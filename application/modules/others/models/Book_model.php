<?php

class Book_model extends BaseModel {
  protected $table_name = "ac_book";
  protected $id = "id";

  function __construct() {
      parent::__construct();
  }

  public function validation_rules($klass='') {
  	return array(
  		array(
        'field' => 'book[name]', 
        'label' => 'Name', 
        'rules' => 'trim|required'),
  		array(
        'field' => 'book[book_code]', 
        'label' => 'Book Code', 
        'rules' => 'trim|required'),
      array(
        'field' => 'book[pcs]', 
        'label' => 'Pcs', 
        'rules' => 'trim|required|numeric'),
      array(
        'field' => 'book[gross_wt]', 
        'label' => 'Gross Weight', 
        'rules' => 'trim|required|numeric'),
      array(
        'field' => 'book[melting]', 
        'label' => 'Melting', 
        'rules' => 'trim|required|numeric|less_than_equal_to[100]'),
      array(
        'field' => 'book[wastage]', 
        'label' => 'Wastage', 
        'rules' => 'trim|required|numeric|less_than_equal_to[100]'),
      array(
        'field' => 'book[fine_wt]', 
        'label' => 'Fine Weight', 
        'rules' => 'trim|required|numeric'),
      array(
        'field' => 'book[amount]', 
        'label' => 'Amount', 
        'rules' => 'trim|required|numeric'),
  	);
  }

}

//class

