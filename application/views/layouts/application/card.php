<?php
$collapse = @$data['collapse'];
$card_title = @$data['card_title'];
$count = isset($data['count'])?$data['count']:null;
preg_match("/[^\/]+$/", @$data['action'], $matches);
$last_word = @$matches[0]; // test
$card_style = @$data['card_style']? @$data['card_style'] : 'card-blue';
if(@$last_word == 'create'){
  $icon = 'fal fa-plus font20';
}elseif(@$last_word == 'edit'){
  $icon = 'fas fa-pen';
}else{
  $icon = '';
}

?>
  <div class="<?php echo @$data['col']; ?> mb-3">
    <div class="card <?=$card_style?>">
      <?php if(!empty($icon) || !empty($data['title'])){?>
        <div class="card-header">          
          <div class="float-left">
            <a class="d-flex white" data-toggle="collapse" href="#<?=$collapse ?>">
              <h5 class="text-uppercase heading m-0 tooltip_js"><?php echo @$data['title'];?></h5>
              <?php if($count>=0){?>
                <span class="count_tag"><?=$count ?></span>
              <?php }?>
            </a>
          </div>
          <?php if(!empty($icon)){?>
            <div class="float-right">
              <?php load_buttons('anchor', array(            
                'icon'=> $icon . " white",  
                'class'=>'btn_icon ajax',
                'data-toggle'=>"modal",
                'data-title'=>($last_word == 'create')?'Add '.$data['title']:'Edit '.$data['title'],
                'href' => BASE_URL.'/'.$this->router->module.'/'.@$data['action'].'/'.(isset($data['id'])?encoding($data['id']):encoding($record['id'])),
                'modal-size'=>'lg'
              )); ?>    
            </div>
          <?php }?>
        </div>
      <?php }?>
      <?php if (isset($collapse)) {?>
        <div class="p-3">
          <span><?php echo $card_title ?> </span>
<!--           <?php if (@$data['title']=='MY PROFESSIONALS') { ?>
            <button type="button" class="btn btn_blue float-right">Add professionals to my team</button>
          <?php } ?>
 -->        
        </div>
        <div id="<?=$collapse ?>" class="collapse">      
      <?php } ?>
        <div class="card-body">
          <?php $this->load->view($data['view']);?>
        </div>      
      <?php if (isset($collapse)) {?>
        </div>
      <?php } ?>
    </div>
  </div>
