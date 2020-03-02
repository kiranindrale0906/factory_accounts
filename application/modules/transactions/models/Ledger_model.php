<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger_model extends BaseModel {

  protected $table_name = "ac_ledger";
  //protected $insert_to_ledger = true;
  protected $id = "id";

  function __construct() {
      parent::__construct();
  }

  

}

//class