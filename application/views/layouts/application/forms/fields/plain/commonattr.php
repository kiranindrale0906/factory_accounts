<?php if (isset($data['data'])) $data = $data['data']; ?>
name="<?= $data['name'] ?>"
class="<?= $data['class'] ?>"
value="<?= $data['value'] ?>"  
<?= @$data['id'] ? 'id="'.$data['id'].'"' : ''; ?>   
onchange="<?= $data['onchange'] ?>"
placeholder="<?= $data['placeholder'] ?>"
<?= $data['autofocus'] ?>
<?= $data['readonly'] ?>
<?= $data['disabled'] ?>
<?php if($data['readonlyinput'] == 1){echo 'readonly';}?>
