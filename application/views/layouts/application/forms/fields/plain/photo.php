<?php 
  if (isset($data['data']))
  $data = $data['data'];
  $data = get_field_data($data, $this->router, $record);
  //print_r($data); die();
?>

<div class="avatar">

  <div class="m-0" data-module="ui/Demo" data-conditions="element:{was visible}">
    <div class="avatar m-0">
      <div class="slim show_image_croper"
          data-ratio="3:2"
          data-size="600,400"
          data-max-file-size="2">
          <?php if(isset($data['image']) AND !empty($data['image'])){?> 
            <img src="<?php echo $data['image']?>" alt=""/>
          <?php }?>
          <input type="file" name="<?= $data['name'] ?>"/>
      </div>
    </div>
  </div>

  <button class="btn btn-sm btn_radius btn_green save_image submit_with_image"><i class="far fa-check font20"></i></button>   
</div>

<?php load_field('plain/field_error', array('data' => $data)); ?>


<!-- <input type="file" id="myCropper"/> -->
<script type="text/javascript">
  // Slim.parse(document.getElementById('my-snippet'));
  new Slim(document.getElementByClassName('myCropper'));


</script>