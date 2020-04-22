
<?php if (isset($data['data'])) $data = $data['data']; ?>
name="<?= $data['name'] ?>"
class="<?= $data['class'] ?>"
value="<?= $data['value'] ?>"  
<?= @$data['id'] ? 'id="'.$data['id'].'"' : ''; ?>   
onchange="<?= $data['onchange'] ?>"
onkeyup="<?= @$data['onkeyup'] ?>"
placeholder="<?= $data['placeholder'] ?>"
<?= $data['autofocus'] ?>
<?= $data['readonly'] ?>
<?= $data['disabled'] ?>
<?php if(!empty($data['data-table'])){echo 'data-table="'.$data['data-table'].'"';}?>
<?php if(!empty($data['data-column'])){echo 'data-column="'.$data['data-column'].'"';}?>
<?php if(!empty($data['data-list-title'])){echo 'data-list-title="'.$data['data-list-title'].'"';}?>
<?php if(!empty($data['data-where_condition'])){echo 'data-where_condition="'.$data['data-where_condition'].'"';}?>
<?php if($data['readonlyinput'] == 1){echo 'readonly';}?>
