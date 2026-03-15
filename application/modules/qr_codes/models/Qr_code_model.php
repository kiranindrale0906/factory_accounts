<?php 
class Qr_code_model extends BaseModel{
	public $router_class = 'qr_codes';
	protected $table_name= 'qr_codes';
	public function __construct($data = array()){
		parent::__construct($data);
	}
 public function before_validate() {
    $data = array();
    if($this->router->method == 'store'){
      $this->load->library('excel_lib');
      if (!empty($this->filedata['name']['import_files']))
        $this->formdata['qr_code_details'] = @$this->excel_lib->get_records($this->filedata, 'import_files', array(),1);
    }
  }
 // public function validate($validation_klass='') {
 //    $rules = $this->validation_rules();
 //    if(!isset($this->formdata['qr_code_details'])){
 //      $this->formdata['qr_code_details'] = array(array());
 //    }
 //    if(isset($this->formdata['qr_code_details'])){
 //      foreach($this->formdata['qr_code_details'] as $index => $qr_code_detail) {
 //        $qr_code_detail_rules = $this->qr_code_detail_model->validation_rules('', $index);
 //        $rules = array_merge($rules, $qr_code_detail_rules);
 //      }
 //    }
    
 //    $this->form_validation->set_rules($rules);
 //    $this->form_validation->set_data($this->formdata);
 //    return $this->form_validation->run();
 //  }

  public function validation_rules($validation_klass="") {
    $rules = array(
              array('field' => 'qr_codes[purity]','label' => 'Purity',
                    'rules' => 'trim|required'),
              array('field' => 'qr_codes[design_code]','label' => 'Design Code',
                    'rules' => 'trim|required'),
              array('field' => 'qr_codes[percentage]','label' => 'Percentage',
                    'rules' => 'trim|required'),
              array('field' => 'qr_codes[factory]','label' => 'Factory',
                    'rules' => 'trim|required')
            );      

   if ($this->router->method == 'store' && $validation_klass=='import_file') {
      $import_file = array(
      array('field'  => 'qr_codes[import_files]', 'label' => 'Upload File',
            'rules'  => array('trim',
                              array('validate_file_required',array($this,'check_import_file_is_attached')),
                              array('validate_file_extension',array($this,'check_import_file_extension')),
                              array('validate_excel_headers',array($this,'check_import_file_headers'))),
            'errors' => array('validate_file_required' => 'Please Upload required file',
            'validate_file_extension' => "Please provide valid file of extension xls or xlsx")));
      return $rules=array_merge($rules,$import_file);
    } else
      return $rules;
  }

  public function check_import_file_is_attached($field_value) {
    return parent::check_file_is_attached('import_files');
  }

  public function check_import_file_extension($field_value) {
    return parent::check_file_extension('import_files', array('CSV','XLSX','XLS'));
  } 

  public function check_import_file_headers($field_value) {
    if(function_exists('import_headers')) {
      $table_headers=$this->excel_lib->format_import_headers(import_headers());
      $excel_headers=$this->excel_lib->get_records($this->filedata,'import_files','',1,TRUE);
      if(!empty($table_headers)) {
        $difference=array_diff($excel_headers,$table_headers);
        if(!empty($difference)) {
          $this->form_validation->set_message('validate_excel_headers','Import file is not valid. Please check headers in excel.');
          return false;
        }
        else 
          return true;
      }
      else{
        $this->form_validation->set_message('validate_excel_headers','Import file is not valid. Please check headers in excel.');
        return false;
      }
    }
    else
    {
      $this->form_validation->set_message('validate_excel_headers','Please set headers in helper');
      return false;
    }
  }

  function after_save($action) {
    if (isset($this->formdata['qr_code_details'])) {
      $this->qr_code_detail_model->delete('', array('qr_code_id' => $this->attributes['id']));
      foreach ($this->formdata['qr_code_details'] as $index => $qr_code_detail) {
       if(!empty($qr_code_detail['gross_weight'])){
          $qr_code_detail_obj = new qr_code_detail_model($qr_code_detail);
          $qr_code_detail_obj->attributes['purity'] = $this->attributes['purity'];
          $qr_code_detail_obj->attributes['design_code'] = $this->attributes['design_code'];
          $qr_code_detail_obj->attributes['percentage'] = $this->attributes['percentage'];
          $qr_code_detail_obj->attributes['qr_code_id'] = $this->attributes['id'];
          $qr_code_detail_obj->attributes['less'] = 
            four_decimal(($qr_code_detail['total_stone'] * $this->attributes['percentage']) /100);
          $qr_code_detail_obj->attributes['net_weight'] = 
            four_decimal($qr_code_detail['gross_weight'] - $qr_code_detail_obj->attributes['less']);
          $qr_code_detail_obj->save();
        }
      }
    }
  }
}