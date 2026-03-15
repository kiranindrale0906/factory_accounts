<div class="<?php echo isset($data['grid'])?$data['grid']:''; ?> chart">
  <div id="<?php echo $data['chart_id'];?>">          
    <canvas class="<?= @$data['class']; ?>" height="<?= @$data['chart_height'];?>"></canvas>       
  </div>
</div>

<script>
  chart['<?php echo $data['chart_id'];?>'] = <?php echo json_encode(
                                              array('type'=>$data['chart_type'],
                                                    'data'=>$data['chart_data'],
                                                    'label'=>$data['chart_labels'],
                                                    'chart_title'=>@$data['chart_title'],
                                                    'bg_color'=>$data['background_color'],
                                                    'border_color'=>$data['border_color'],
                                                    'y_axis'=>$data['y_axis']
                                              ));?>;

</script>