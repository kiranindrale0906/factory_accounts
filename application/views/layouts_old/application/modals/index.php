<div class="modal" id="ajax-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <?= @$this->data['add_title'] ?>
        </h4>
        <?php load_buttons('button', array('icon'=> 'fal fa-times font20', 
                                           'class'=> 'btn btn-lg btn_blue btn_icon', 
                                           'data-dismiss'=> 'modal' )); ?>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
      </div>

      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>