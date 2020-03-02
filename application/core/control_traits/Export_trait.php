<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once APPPATH . "core/control_traits/Record_list_trait.php";
trait Export_trait {
  //use record_list_trait;
  private function _export() {
    makedirs('uploads');
    $file='export';
    $records = $this->_getAllRecords($this->where);
    $data=$records['html'];
    if(!empty($records['master_name']))
      $file= $this->router->fetch_class();
    $headerTitle=array_keys($data[0]);
    $cellAlphabtes=range('A', 'Z');
    $cellAlphabtesAfter=range('a', 'z');
    $cellAlphabtesAfterSmall=range('Aa', 'Zz');
    $fileName = $file.'_'.time().'.'.(isset($_GET['format'])?$_GET['format']:'xlsx');
    if(isset($_GET['format']) AND $_GET['format'] == 'csv'):
      $fp = fopen('php://output', 'w');
      if(!empty($records['master_name']))$file= $this->router->fetch_class();
        $fileName = $file.'_'.time().'.'.(isset($_GET['format'])?$_GET['format']:'xlsx');
      foreach ($data[0] as $key => $value): $header[] = $key;endforeach;
      header('Content-Type: application/vnd.ms.exel');
      header('Content-Disposition: attachment; filename='.$fileName);
      fputcsv($fp, array_reverse($header));
      foreach ($data as $key => $sheet_data):fputcsv($fp, array_reverse($sheet_data));endforeach;
      exit;
    endif;
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    if(count($headerTitle) > 26){
      $cellAlphabtes = array_merge($cellAlphabtes,$cellAlphabtesAfter);
      $cellAlphabtes = array_merge($cellAlphabtes,$cellAlphabtesAfterSmall);
    }
    for ($i=0; $i <count($headerTitle) ; $i++):
      $objPHPExcel->getActiveSheet()->SetCellValue($cellAlphabtes[$i].'1', $headerTitle[$i]);
      $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
      $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($cellAlphabtes[$i])->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension($cellAlphabtes[$i])->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($cellAlphabtes[$i].'1')->getAlignment()->setWrapText(true);
      $objPHPExcel->getActiveSheet()->getStyle($cellAlphabtes[$i].'1' , $headerTitle[$i])->applyFromArray(
        array('type' => PHPExcel_Style_Fill::FILL_SOLID,
              'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                   'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
              )));
    endfor;
    //Write the ROWS
    $rowCount = 2;
    foreach ($data as $dataArray):
      $excelData=array_values($dataArray);
      for ($i=0; $i <count($headerTitle) ; $i++):
        $objPHPExcel->getActiveSheet()->SetCellValue($cellAlphabtes[$i].$rowCount,$excelData[$i]);
      endfor;
      $rowCount++;
    endforeach;
      $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
      $objWriter->save(FCPATH.'uploads/'.$fileName);
      header('Content-Type: application/vnd.ms.exel');
    redirect(base_url().'uploads/'.$fileName);  
    die;
  }

  private function _export_popup_html(){
    $records = $this->_getAllRecords($this->where);
    $data['count'] = $this->_getAllRecords($this->where,true);
    $data['title'] = 'Export Links';
    $data['master_name'] = $this->router->module.'/'.$this->router->class;
    echo json_encode(array('title'=>'Export Links',
                           'status' => 'success',
                           'open_modal'=> $this->data['open_modal'],
                           'data'=>$this->load->view('sys/export/export',$data,true)));
  }

}
