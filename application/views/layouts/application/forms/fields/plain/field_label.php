 <?php 
  if (isset($data['data'])) $data = $data['data'];
  if(!empty($data['label'])): ?>   
    <label class="<?= @$data['label_class']?> <?= @$data['label_col']?>">
      <?= $data['label'] ?> <?= $data['mandatory'] ? '<span class="red">*</span>' : '' ?>
    </label>
  <?php endif;
?>