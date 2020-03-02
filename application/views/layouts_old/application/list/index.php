<?php 
  $page_data = getTableSettings();
  $this->load->view('layouts/application/list/table_title');
  if(isset($page_data['custom_table_header']) && $page_data['custom_table_header'] == true){
    $this->load->view($this->router->module."/".$this->router->class.'/table_header');
  }
?>

<?php $module = $this->router->module;
  if (!isset($blank_content) || $blank_content==FALSE): ?>
      <div class="boxrow mb-2">
        <div class="float-right">
        <?php
          $page_details = getTableSettings();
          if (empty($type))
          $type = 'index';
          if ($page_details['add_title'] != ''):
        ?>
        <div class="float-right">
          <?php 
            if ($master_name != '') : ?>
              <?php $base_url = base_url();
                $this->_module = $this->router->fetch_module();
                $create_url = $base_url.$this->_module.'/'.$this->router->class."/create"; 
                if (!empty($page_details['create_id']))
                  $create_url .= '/'.@$_GET[$page_details['create_id']];
                  $query_string = $_SERVER['QUERY_STRING']; 
                if (!empty($query_string)) 
                  $query_string = "?".$query_string;
                  $export_url = $base_url.$master_name."/export".$query_string;
                if (!empty($page_details['export_title'])) {
                   load_buttons('anchor', array(
                    'name'=> $page_details['export_title'],
                    'class'=>'fal fa-file-export', 'data-toggle'=>'modal', 'href'=>$export_url,'modal-size'=>'xl'
                    ));
                 } ?>
                <?php if (!empty($page_details['import_title'])) {
                   load_buttons('anchor', array(
                    'name'=> $page_details['import_title'],
                    'class'=>'fal fa-file-import', 'data-toggle'=>'modal', 'href'=>$base_url.$master_name."/create?import=1",'modal-size'=>'xl'
                    ));
                 } ?>
                <?php 
                  if (!empty($page_details['add_method'])) {
                    load_buttons('anchor', array(
                    'name'=> $page_details['add_title'],
                    'class'=>'btn-sm btn_purple medium ajax', 'data-toggle'=>'modal', 'href'=>ADMIN_PATH.$this->router->module.'/'.$this->router->class.'/'.'create','modal-size'=>'xl'
                    ));
                  } else {
                    load_buttons('anchor', array(
                    'name'=> $page_details['add_title'],
                    'class'=>'btn-sm btn_purple medium', 'href'=>ADMIN_PATH.$this->router->module.'/'.$this->router->class.'/'.'create','modal-size'=>'xl'
                    ));
                  } 
          endif; ?>
        </div>
        <?php endif; ?>
        <?php if ($master_name == 'account') : ?>
          <div class="float-right-right mb-10">
            <?php if ($master_name != '') : ?>
                <a href="<?= base_url($master_name) ?>/import" type="button"
                   class="btn btn-sm btn-primary">Import</a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        
        </div>
      </div>
      <?php $this->load->view('layouts/application/list/table_setting'); ?>
        <?= @$searched_html ?>
        <div class="table-responsive tablefixedheader">
          <?php $this->load->view('layouts/application/list/table'); ?>
        </div>
      <?php
        if ($filter_columns != '') :
          $this->load->view('layouts/application/list/pagination');
        endif;
      ?>
  <?php else: ?>
    <?php $this->load->view($controller . '/index', array('controller' => $controller, 'action' => $action)) ?>
  <?php endif; ?>
<?= @$filter_html ?>
