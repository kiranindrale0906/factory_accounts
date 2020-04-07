<?php
class Webserver_analytics extends CI_Controller {
  protected $load_helper = false;
  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->load->view('webserver_analytics/index.html');
  }
}

?>
