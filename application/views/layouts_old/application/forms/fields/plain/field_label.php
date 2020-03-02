<?php
 if(!empty($data['data']['label'])): ?>   
  <label class="<?= @$data['label_class']?> <?= @$data['class']?>">
    <?= $data['data']['label'] ?> <?= $data['data']['mandatory'] ? '<span class="red">*</span>' : '' ?>
  </label>
<?php endif ?>