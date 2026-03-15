<?php

class Book_model extends BaseModel {

  protected $table_name = "ac_book";
  protected $id = "id";
  public $router_class = "books";
  function __construct($data=array()) {
      parent::__construct($data);
  }

  public function validation_rules($klass='') {
    return array(
      array(
        'field' => 'books[name]', 
        'label' => 'Name', 
        'rules' => 'trim|required'),
      array(
        'field' => 'books[book_code]', 
        'label' => 'books Code', 
        'rules' => 'trim|required'),
      array(
        'field' => 'books[pcs]', 
        'label' => 'Pcs', 
        'rules' => 'trim|required|numeric'),
      array(
        'field' => 'books[gross_wt]', 
        'label' => 'Gross Weight', 
        'rules' => 'trim|required|numeric'),
      array(
        'field' => 'books[melting]', 
        'label' => 'Melting', 
        'rules' => 'trim|required|numeric|less_than_equal_to[100]'),
      array(
        'field' => 'books[wastage]', 
        'label' => 'Wastage', 
        'rules' => 'trim|required|numeric|less_than_equal_to[100]'),
      array(
        'field' => 'books[fine_wt]', 
        'label' => 'Fine Weight', 
        'rules' => 'trim|required|numeric'),
      array(
        'field' => 'books[amount]', 
        'label' => 'Amount', 
        'rules' => 'trim|required|numeric'),
    );
  }
  }
