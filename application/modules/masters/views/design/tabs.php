<?php $controller_name = $this->router->class;?>
<ul class="nav nav-tabs">
  <li>
    <a href="<?= ADMIN_PATH.'submissions/view/'.$assignment_id ?>" class="<?= ($controller_name == 'submissions') ? 'active' : '';?>">
      <i class="fa fa-folder-open"></i> 
      Basic Details
    </a>
  </li>
  <li>
    <a href="<?= ADMIN_PATH.'assignment_informations/create/'.$assignment_id ?>" class="<?= ($controller_name == 'assignment_informations') ? 'active' : '';?>">
      <i class="fa fa-folder-open"></i> 
      Information Submitted
    </a>
  </li>
  <li>
    <a href="<?= ADMIN_PATH.'assignment_actionables/create/'.$assignment_id ?>" class="<?= ($controller_name == 'assignment_actionables') ? 'active' : '';?>">
      <i class="fa fa-folder-open"></i> 
      Actionables
    </a>
  </li>
 </ul>