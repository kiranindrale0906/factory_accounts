 <div class="dropdown inline dropdown_btn">
  <button type="button" class="btn btn-lg btn_icon" data-toggle="dropdown">
    <i class="far fa-ellipsis-v"></i>
  </button>
  <div class="dropdown-menu">
    <?= getActions($value, $table_name, $url, $select_url, $filter_details); ?>
  </div>
</div>