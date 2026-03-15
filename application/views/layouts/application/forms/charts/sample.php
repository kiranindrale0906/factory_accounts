<div class="row">
  <?php load_card(array('view'=>'layouts/application/forms/charts/chart',
                        'card_style'=>'card-light_green',
                        'title'=>'My Chart',
                        'chart_id' => 'line1',  
                        'chart_type' => 'line',
                        'chart_height'=>'300',
                        'chart_data'=>array('12','13','14'),
                        'chart_labels'=>array('Jan', 'Feb', 'March'),                       
                        'y_axis'=>true,
                        'background_color'=>array('rgba(233, 30, 99, 0.6)', 'rgba(233, 30, 99, 0.6)', 'rgba(233, 30, 99, 0.6)'),
                        'border_color'=>array('#E91E63','#E91E63', '#E91E63'),
                        'chart_title'=>'Expenses'));?>

  <?php load_chart('chart', array('chart_id'=>'line2',
                                 'grid'=>'col-6',
                                 'chart_type' => 'line',
                                 'card_title'=>'My Bar Chart',
                                 'chart_height'=>'300',
                                 'chart_title'=>'Total Sale',
                                 'chart_data'=>array('55','60','70'),
                                 'chart_labels'=>array('abc', 'xyz', 'pqr'),
                                 'background_color'=>array('rgba(233, 30, 99, 0.6)', 'rgba(233, 30, 99, 0.6)', 'rgba(233, 30, 99, 0.6)'),
                                 'border_color'=>array('#E91E63','#E91E63', '#E91E63'),
                                 'y_axis'=>true
                                 )); ?>

<?php load_chart('chart', array('chart_id'=>'line3',
                                 'chart_type' => 'bar',
                                 'card_title'=>'My Bar Chart',
                                 'chart_height'=>'300',
                                 'chart_title'=>'Total Profit',
                                 'chart_data'=>array('55','60','70', '20'),
                                 'chart_labels'=>array('abc', 'xyz', 'pqr', 'fgd'),
                                 'background_color'=>array('rgba(233, 30, 99, 0.82)','rgba(156, 39, 176, 0.82)','rgba(255, 193, 7, 0.73)', 'rgba(3, 169, 244, 0.73)'),
                                 'border_color'=>array('#E91E63', '#9C27B0', '#FFC107', '#03A9F4'),
                                 'y_axis'=>true
                                 )); ?>

<?php load_chart('chart', array('chart_id'=>'line4',
                                 'chart_type' => 'pie',
                                 'card_title'=>'My Pie Chart',
                                 'chart_height'=>'300',                                 
                                 'chart_data'=>array('55','60','70'),
                                 'chart_labels'=>array('abc', 'xyz', 'pqr'),
                                 'background_color'=>array('rgba(233, 30, 99, 0.82)','rgba(156, 39, 176, 0.82)','rgba(255, 193, 7, 0.73)'),
                                 'border_color'=>array('#E91E63', '#9C27B0', '#FFC107'),
                                 'y_axis'=>false
                                 )); ?>
 
</div>

