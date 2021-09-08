<?php 
  if(empty($_GET)) {
    load_buttons('anchor',
                array('name'=>'Show All',
                    'href'=>base_url()."argold/chitti_exports?show_all=yes",
                    'class'=>'btn btn-sm btn_green mb-2 ml-2 float-right'
                )); 
  }