<?php $yesNo = array() ?></tr>
    <form class="form-horizontal" id="searchFrom">
      <?php 
      foreach ($heading as $k => $val) {
      if( isset($param['key']) && $val[3] == $search_param) {  ?>
          <div class="form-group">
            <label class="control-label m-b-10"><?=$val[0]?></label>
            <?php if (isset($select_data) && isset($val[9]) && $val[9] == 'dynamic_dropdown') { ?>
              <div class="col-sm-12">
                <select name="<?='where['.$val[3].'=]' ?>" class="form-control selectpicker_js">
                  <option value="" selected="selected" disabled="disabled">Select Status</option>
                <?php foreach ($select_data as $option) { ?>
                  <option value="<?= $option; ?>" <?php if(@$values[$val[3].'='] && $option == @$values[$val[3].'=']){echo 'selected="selected"';}?>><?= strtoupper($option); ?></option>
                <?php } ?>
                </select>
              </div>
            <?php } 
            elseif(isset($val[9]) && $val[9] == 'static_dropdown'){?>
              <div class="col-sm-12">
                <select name="<?='where['.$val[3].'=]'; ?>" class="form-control selectpicker_js">
                  <option value="" selected="selected" disabled="disabled">Select Status</option>
                <?php foreach ($val[10] as $option) { ?>
                  <option value="<?= $option; ?>" <?php if(@$values[$val[3].'='] && $option == @$values[$val[3].'=']){echo 'selected="selected"';}?>><?= $option ?></option>
                <?php } ?>
                </select>
              </div>
            <?php 
            }else if (isset($param['key']) && isset($val[9]) && $val[9] == 'daterange') {?>
              <div class="row">
                <div class="col-sm-6">
                  <input type="text"
                         placeholder="MM-DD-YYYY" class="form-control datepicker_js daterange" 
                         name="<?='date['.$val[3].'>=]';?>"
                         value="<?= @$values[$val[3]][0]?>">
                </div>
                <div class="col-sm-6">
                  <input type="text"
                         placeholder="MM-DD-YYYY" class="form-control datepicker_js daterange" 
                         name="<?='date['.$val[3].'<=]';?>"
                         value="<?= @$values[$val[3]][1]?>">
                </div>         
              </div>
            <?php }
            else if (isset($param['key']) && isset($val[9]) && $val[9] == 'range') { ?>
              <div class="row">
                <div class="col-sm-6">
                  <input type="text"
                         placeholder="Starting Range" class="form-control " 
                         name="<?='where['.$val[3].'>=]' ?>"
                         value="<?= @$values[$val[3].'>=']?>" >
                </div>
                <div class="col-sm-6">
                  <input type="text"
                         placeholder="End Range" class="form-control " 
                         name="<?='where['.$val[3].'<=]' ?>"
                         value="<?= @$values[$val[3].'<=']?>" >
                </div>                    
              </div>
            <?php }
             else if (isset($select_data) 
                      && isset($val[9]) 
                      && $val[9] == 'dynamic_multiselect') { ?>
              <div class="col-sm-12">

                <select name="or_where[<?= $val[3].'=][]' ?>" class="form-control selectpicker_js"
                      data-style="btn-sm btn-default"
                      data-none-selected-text="Please Select"
                      data-container="body"
                      data-live-search="true"
                      data-size="10"
                      multiple>
                <?php $dm= 0;foreach ($select_data as $option) { ?>                      
                  <option value="<?= $option ?>" <?php if(@$values[$val[3]] && in_array($option,@$values[$val[3]])){echo 'selected="selected"';}?>><?= $option ?></option>
                <?php  $dm++;} ?>
                </select>
              </div>
            <?php } else if (isset($param['key']) 
                             && isset($val[9]) 
                             && $val[9] == 'static_multiselect') { ?>
              <div class="col-sm-12">
                <select name="or_where[<?= $val[3].'=][]' ?>" class="form-control selectpicker_js" multiple>
                <?php $sm = 0;foreach ($val[10] as $option) { ?>                      
                  <option value="<?= $option ?>"
                          <?php 
                            if(@$values[$val[3]] && in_array($option, @$values[$val[3]])){
                              echo 'selected="selected"';
                            }?>>
                    <?= $option ?>
                  </option>
                <?php $sm++;} ?>
                </select>
              </div>
            <?php } else if (isset($param['key']) && isset($val[9]) && $val[9] == 'date') { ?>
              <div class="ui-front">
                <input type="text" placeholder="DD-MM-YYYY" 
                      class="form-control datepicker_js" 
                      name="date[<?=$val[3] ?>=]"
                      value="<?= @$values[$val[3]][0]?>">
              </div>
            <?php } elseif(isset($val[9]) && $val[9] == 'autocomplete' AND isset($val[10]) AND is_array($val[10])) { ?>
              <div class="ui-front">
                <input type="text" placeholder="<?=$val[0] ?>" 
                      class="form-control autocomplete like[<?=$val[3] ?>]"
                      name="like[<?=$val[3] ?>]" 
                      data-table="<?= $val[10][0]?>" 
                      data-column= "<?= $val[10][1]?>"
                      value="<?= @$values[$val[3]]?>">
                <div id="suggesstions"></div>
              </div>
            <?php }else { ?>
              <div class="ui-front">
                <input type="text" placeholder="<?=$val[0] ?>" 
                      class="form-control" 
                      name="like[<?=$val[3]; ?>]"
                      value="<?= @$values[$val[3]]?>">
              </div>
            <?php } ?>
          </div>
      <?php  }}
    if(isset($_SESSION['query_string_filter']) AND 
                                              !empty($_SESSION['query_string_filter'])):
      $get_array = $_SESSION['query_string_filter'];
      $param['search_param'] = str_replace("having%", "", $param['search_param']);

      ?>
      <div class="form-group row">
        <?php 
        foreach($get_array as $key_end_array => $end_value){
          foreach($heading as $heading_value){
            $heading_value[9] = isset($heading_value[9])?$heading_value[9]:"";
            $heading_value_replace = str_replace("having%", "", $heading_value[3]);
            if(in_array($heading_value[9],array("date","dynamic_dropdown","static_dropdown","range"))){
              if(remove_operators($key_end_array) == $heading_value[3]  
                 AND $param['search_param'] != $heading_value_replace){ 
                $heading_set = $heading_value[0];?>
                 <div class="form-group divInput col-sm-12">
                   <label class="control-label"><?php echo $heading_set;?></label>
                    <div class="input-group">
                      <input readonly type="text" placeholder="<?= $heading_set; ?>" value="<?=$end_value ?>"
                             class="form-control" name="where[<?= $key_end_array; ?>]">
                      <div class="input-group-append">    
                        <button class="btn btn-danger removeInput" type="button"><i class="fa fa-trash"></i></button> 
                      </div>
                  </div>
                </div> </br>
             <?php }
            }else{
             if(remove_operators($key_end_array) == $heading_value[3]  
                 AND $param['search_param'] != $heading_value_replace 
               && (in_array($heading_value[9],array("dynamic_multiselect","static_multiselect")))){ 
              $heading_set = $heading_value[0];?>
               <div class="form-group col-sm-12">
               <label class="control-label"><?php echo $heading_set;?></label>
                <?php foreach($end_value as $multiselect_values){?>
                  <div class="input-group divInput">
                    <input readonly type="text" placeholder="<?= $heading_set; ?>" value="<?=$multiselect_values ?>"
                           class="form-control" name="or_where[<?= $key_end_array.'][]'; ?>">
                      <div class="input-group-append">    
                        <button class="btn btn-danger removeInput" type="button"><i class="fa fa-trash"></i>
                      </button> 
                    </div>
                </div></br> 
                <?php }?>
              </div>   
            <?php 
              }
              else if(remove_operators($key_end_array) == $heading_value[3]  
                 AND $param['search_param'] != $heading_value_replace && 
                 $heading_value[9] == 'daterange' ){ 
              $heading_set = $heading_value[0];?>
              <div class="form-group divInput col-sm-6">
              <label class="control-label"><?php echo $heading_set;?></label>
                <!-- <div class="row"> -->
                    <div>  
                      <div class="input-group">
                      <input readonly type="text" placeholder="<?= $heading_set; ?>" value="<?=$end_value ?>"
                               class="form-control" name="date[<?= $key_end_array; ?>]">
                          <div class="input-group-append">    
                            <button class="btn btn-danger removeInput" type="button"><i class="fa fa-trash"></i>
                          </button> 
                        </div>
                    </div>
                  </div>
                <!-- </div>  -->
              </div>     
              <?php 
              }
              else if(remove_operators($key_end_array) == $heading_value[3]  
                 AND $param['search_param'] != $heading_value_replace 
                 && $heading_value[9] != 'range' && $heading_value[9] != 'daterange' ){ 
              $heading_set = $heading_value[0];?>
              <div class="form-group divInput col-sm-12">
              <label class="control-label"><?php echo $heading_set;?></label>
                      <div class="input-group">
                        <input readonly type="text" value="<?=$end_value ?>"
                               class="form-control" name="like[<?= $key_end_array; ?>]">
                          <div class="input-group-append">    
                            <button class="btn btn-danger removeInput" type="button"><i class="fa fa-trash"></i>
                          </button> 
                        </div>
                    </div> 
              </div>     
              <?php 
              }
            }  
          }?>
        <?php 
        }?>  
      </div>
      <?php endif;?>      
      <input type="hidden" value="<?= @$param['search_url'] ?>" id="filter_url">
    </form>
    <div class="modal-footer">
      <?php
       if($this->input->is_ajax_request() == true)$set_header = 'get_html=1';
      else $set_header = '';
      ?>
       <a href="#" type="button" onclick="filterTableData('<?= $current_url.@$param['search_url'] ?>','<?php echo $param['search_url'];?>','<?php echo $set_header;?>','<?=(isset($param['is_ajax'])?$param['is_ajax']:'')?>','<?= add_inbuilt_url_parameters_form();?>');" class="btn btn_blue submit_filter_form">Search
        </a>
    </div>
  