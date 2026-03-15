<a   
  <?php 
    if(!isset($data['href']))
      echo 'href'.'='.'"javascript:void(0);"';

    if(!isset($data['class']))
      echo 'class'.'='.'"btn btn-sm link"';

    foreach ($data as $key => $value) {
      if($key == 'class')
        echo $key.'='."'".'btn '.$value."'";

      if($key !='icon')
        echo $key.'='."'".$value."'";
    }   
  ?>
>
  <i class="<?= @$data['icon'];?>"></i>  <?= @$data['name'];?>
</a>