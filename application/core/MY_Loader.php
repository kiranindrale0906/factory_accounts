<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/*This setup is modified by Bhaskar Dutt Sharma
Version 1.0
dated : 08/06/2019
*/
/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

  public $current_site = "";
  private $page_title = '';

  public function __construct() {
    $this->current_site = $_SERVER['REQUEST_URI'];
    $this->page_title = $this->get_title();
  }

  public function render($view, $data = array()) {
    $data['view'] = $view;
    $data['title'] = $this->get_title();
    $this->view('layouts/'.$data['layout'].'/index', $data);
  }

  private function get_title() {
    $class = $this->router->fetch_class();
    $class = ucwords(str_replace('_', ' ', $class));
    $title = $class;
    return $title;
  }

}
