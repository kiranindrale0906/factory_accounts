<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once ('vendor/autoload.php');
use mikehaertl\wkhtmlto\Pdf;
trait Respond_to_trait {
  private function _respond_to_index($data) {
    if ($this->is_ajax() || @$data['ajax'] || $this->is_api_request()) {
      if(!isset($_GET['get_html']) && !isset($_GET['table_body']))
        $response = array('status' => 'success',
                        'data' => $data['html'],
                        'pagination' => @$data['pagination']);
      else if(isset($_GET['get_html']))
        $response = array('html'=>$this->load->view('layouts/application/list/index', $data,true)); 
      else if(isset($_GET['table_body']))
        $response = array('html'=>$this->load->view('layouts/application/list/table', $data,true));
      echo json_encode($response);
    } else
      $this->load->render('layouts/application/list/index', $data);
  }

  private function _respond_to_load_form($data) {

    if ($this->is_ajax() || @$data['ajax']) 
      $this->show_ajax_modal('success', 'form');
    else if ($this->is_api_request()) {
      $response = array('status' => 'failure',
                        'errors' => array('invalid' => 'URL is invalid for API calls'));
      echo json_encode($response); exit;
    } else
      $this->load->render('layouts/'.$data['layout'].'/forms/index', $data);
  }

  private function _respond_to_success_on_save($model_obj) {
    if ($this->is_ajax() || @$this->data['ajax']) {
      $ajax_response = array('status'=>'success',
                             'message' => $this->data['message'],
                             'js_function'=> @$this->data['ajax_success_function'],
                             'csrf_name'=>get_csrf_token()['name'],
                             'csrf_value'=>get_csrf_token()['hash'],
                             'data'=>$this->get_ajax_success_data($model_obj, $this->router->method));
      echo json_encode($ajax_response);
      exit();
    } else if ($this->is_api_request()) {
      $ajax_response = array('status'=>'success',
                             'data'=> $model_obj->attributes);
      echo json_encode($ajax_response);
      exit();
    } else {
      if (empty($this->data['redirect_url'])){
        $view_url = $this->router->module.'/'.$this->router->class.'/view/'.$model_obj->attributes['id'];
        $this->data['redirect_url'] = base_url($view_url.'?http_referer='.$model_obj->formdata['http_referer']);
      }
      $this->session->set_flashdata('success', 'Data saved successfully');
      redirect($this->data['redirect_url']);
    }
  }

  private function _respond_to_error_on_save($model_obj) {
  
    $status = 'error';
    $message = "Record could not be saved";
    if ($this->is_ajax() && $this->data['open_modal']) $this->show_ajax_modal($status, 'form');
    if ($this->is_ajax() && !($this->data['open_modal'])) {
      $ajax_response = array('status'=>$status,
                             'message' => $message,
                             'errors' => $this->form_validation->error_array(),
                             'js_function'=> @$this->data['ajax_failure_function'],
                             'data'=>$this->get_ajax_failure_data($model_obj, $this->router->method));
      echo json_encode($ajax_response);
      exit();
    }
    if ($this->is_api_request()) {
      $ajax_response = array('status'=>$status,
                             'errors'=> $this->form_validation->error_array());
      echo json_encode($ajax_response);
      exit;
    }
    if ((empty($this->data['record']) || $this->data['record'] === FALSE) && empty($this->data['import'])):
      $this->load->view('errors/404_not_found');
    else: 
      if (isset($model_obj->formdata['http_referer'])) $this->data['http_referer'] = $model_obj->formdata['http_referer'];
      $this->load->render('layouts/'.$this->data['layout'].'/forms/index', $this->data);
    endif;
  }

  private function _respond_to_success_on_view($data) {
    if ($this->is_ajax()) 
      $this->show_ajax_modal('success', 'view');
    else if ($this->is_api_request()) {
      $response = array('status' => 'success',
                        'data' => $data['record']);
      echo json_encode($response);
      exit;
    } else {
      $this->load->render($this->router->module.'/'.$this->router->class.'/'.'view', $data);
    }
  }

  private function _respond_to_success_on_delete($record) {
    if ($this->is_ajax() || @$this->data['ajax']) {
      $ajax_response = array('status'=>'success',
                             'message' => 'Record deleted successfully',
                             'js_function'=> @$this->data['ajax_delete_function'],
                             'data'=>$this->get_ajax_delete_data($record));
      echo json_encode($ajax_response);
      exit();
    } else if ($this->is_api_request()) {
      $ajax_response = array('status'=>'success',
                             'data'=> $record);
      echo json_encode($ajax_response);
      exit();
    } else 
      redirect(base_url($this->router->module.'/'.$this->router->class));
  }
  private function _respond_to_failure_on_delete($record) {
    if ($this->is_ajax() || @$this->data['ajax']) {
      $ajax_response = array('status'=>'error',
                             'message' => 'Record could not be deleted',
                             'js_function'=> @$this->data['ajax_delete_failure_function'],
                             'data'=>$this->get_ajax_delete_data($record));
      echo json_encode($ajax_response);
      exit();
    } else if ($this->is_api_request()) {
      $ajax_response = array('status'=>'failure',
                             'data'=> $record);
      echo json_encode($ajax_response);
      exit();
    } else {
      if (empty($this->data['redirect_url']))
        redirect(base_url($this->router->module.'/'.$this->router->class));
      else
        redirect($this->data['redirect_url']);
    }
  }

  public function _respond_to_record_not_found($data) {
    if ($this->is_ajax() || @$data['ajax'] || $this->is_api_request()) {
      $ajax_response = array('status'=>'failure',
                             'errors'=>'Record not found');
      echo json_encode($ajax_response);
    } else
      $this->load->view('errors/404_not_found');
  }

  protected function get_ajax_success_data($model_obj, $action) {
    return $model_obj->attributes;
  }

  protected function get_ajax_failure_data($model_obj, $action) {
    return $model_obj->attributes;
  }

  protected function get_ajax_delete_data($id) {
    return $id;
  }

  private function _get_pdf($pdf_html) {
    $pdf = new Pdf;
    $html = $pdf_html;
    $pdf->addPage($html);
    $pdf->send();
  }

  private function show_ajax_modal($status, $view_file) {
    $this->data['controller'] = $this->router->module.'/'.$this->router->class;
    $this->data['action'] = $this->router->method;
    $view_file = ($this->data['import'] == 1) ? 'import' : $view_file;
    $dialog_html = $this->load->view($this->router->module.'/'.$this->router->class.'/'.$view_file, $this->data, TRUE);
    echo (json_encode(array('status' => $status,
                            'open_modal'=> $this->data['open_modal'],
                            'ajax_success_function' => @$this->data['ajax_success_function'],
                            'data' => $dialog_html,
                            'message'=> ($status=='failure') ? validation_errors() : '')));
    die();
  }
}
