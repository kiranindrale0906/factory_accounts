
<?php 

if($this->router->method == 'index'){
  $page_details = getTableSettings();
} 
?>
<div class="modal" id="core-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg_blue white">
        <h4 class="modal-title">
          <input type="hidden" id="current_module">
          <?php echo isset($_GET['export'])?$page_details['export_title']:ucfirst($this->router->class); ?>
        </h4>
        <?php load_buttons('button', array('icon'=> 'fal fa-times font20', 
                                           'class'=> 'btn btn-md btn_blue btn_icon', 
                                           'data-dismiss'=> 'modal' )); ?>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>