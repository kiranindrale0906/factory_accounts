<?php 
  $this->load->view('layouts/application/navigation/headnav');
  $page_details = getTableSettings(); //get_page_title($master_name, @$type, @$type_id);
?>
<div class="panel-heading actionheader">
  <div class="title_btn d-flex align-items-center justify-content-between">
    <div class="float-left">
      <h5 class="heading"><?= $page_details['page_title']; ?> Summary</h5>
    </div>
    <?php
      //$master_name = !isset($master_name) ? '' : $master_name;
      $page_details = getTableSettings();
      if (empty($type))
        $type = 'index';
    ?>
    <?php
      $role = $this->session->userdata('role');
      if ($page_details['add_title'] != ''):
    ?>
    <div class="float-right">
      <?php if ($master_name != '') : ?>
        <?php $base_url = base_url();
          $this->_module = $this->router->fetch_module();
          $create_url = $base_url.$this->_module.'/'.$this->router->class."/create"; 
          if (!empty($page_details['create_id']))
            $create_url .= '/'.@$_GET[$page_details['create_id']];
          $query_string = $_SERVER['QUERY_STRING']; 
          if (!empty($query_string)) 
            $query_string = "?".$query_string;
          $export_url = $base_url.$master_name."/export".$query_string; ?>
        <?php if (!empty($page_details['export_title'])) { ?>
          <a href="<?= $export_url ?>"
            class="btn btn-sm btn_blue btn_radius"><i class="fal fa-file-export"></i> <?= $page_details['export_title'] ?></a>    
        <?php } ?>
        <?php if (!empty($page_details['import_title'])) { ?>
          <a href="<?= $base_url.$master_name."/create?import=1" ?>" type="button"
            class="btn btn-sm btn-primary"><i class="fal fa-file-import"></i> <?= $page_details['import_title'] ?></a>
        <?php } ?>
        <?php if (!empty($page_details['add_method'])) { ?>
          <a href="javascript:void(0);"
            class="btn btn-sm btn_purple" data-toggle="modal" data-target="#myModal" onclick="create_entry('<?= $create_url ?>')"><i class="fas fa-plus"></i>  <?= $page_details['add_title'] ?> </a>          
        <?php } else { ?>
          <a href="<?= $create_url ?>"
              class="btn btn-sm btn_purple"><i class="fas fa-plus"></i>  <?= $page_details['add_title'] ?> </a>
        <?php } ?>
      <?php endif; ?>
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

<?= $searched_html ?>

<?php $this->load->view('layouts/application/table/add_data_modal', $this->data['add_title'] = $page_details['add_title']) ?>
