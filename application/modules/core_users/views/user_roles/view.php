<table class="table table-bordered table-md table-default table-striped premissions_users" id="customTableId">
  <thead>
    <tr>
      <th><span>Module Name</span></th>
      <th><span>List</span></th>
      <th><span>Create</span></th>
      <th><span>Update</span></th>
      <th><span>View</span></th>
      <th><span>Delete</span></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($user_role_permissions as $user_role_permission) { 
        if(@$user_role_permission['index'] == 1
            || @$user_role_permission['create'] == 1
              || @$user_role_permission['edit'] == 1
                || @$user_role_permission['view'] == 1
                  || @$user_role_permission['delete'] == 1){
     ?>
      <tr>
        <td>
          <?= $user_role_permission['module_name'] ?>
        </td>
        <td>
          <?php load_field('checkbox',
              array('name'=>'user_role_permissions['.$user_role_permission['module_name'].'][index]',
                    'field'=>'index',
                    'class' => 'readonly',
                    'value' => @$user_role_permission['index'],
                    'controller' => 'user_role_permissions',
                    'option'=> array(
                                array('chk_id' => @$user_role_permission['module_name'].'_index',
                                      'label_for' => @$user_role_permission['module_name'].'_index',
                                      'value' => 1,))))
          ?>
        <td>
          <?php load_field('checkbox',
              array('name'=>'user_role_permissions['.$user_role_permission['module_name'].'][create]',
                    'field'=>'create',
                    'class' => 'readonly',
                    'value' => @$user_role_permission['create'],
                    'controller' => 'user_role_permissions',
                    'option'=> array(
                                array('chk_id' => @$user_role_permission['module_name'].'_create',
                                      'label_for' => @$user_role_permission['module_name'].'_create',
                                      'value' => 1,))))
          ?>
        <td>
          <?php load_field('checkbox',
              array('name'=>'user_role_permissions['.$user_role_permission['module_name'].'][edit]',
                    'field'=>'edit',
                    'class' => 'readonly',
                    'value' => @$user_role_permission['edit'],
                    'controller' => 'user_role_permissions',
                    'option'=> array(
                                array('chk_id' => @$user_role_permission['module_name'].'_edit',
                                      'label_for' => @$user_role_permission['module_name'].'_edit',
                                      'value' => 1,))))
      ?>
        <td>
          <?php load_field('checkbox',
              array('name'=>'user_role_permissions['.$user_role_permission['module_name'].'][view]',
                    'field'=>'view',
                    'class' => 'readonly',
                    'value' => @$user_role_permission['view'],
                    'controller' => 'user_role_permissions',
                    'option'=> array(
                                array('chk_id' => @$user_role_permission['module_name'].'_view',
                                      'label_for' => @$user_role_permission['module_name'].'_view',
                                      'value' => 1)))) 
          ?>
        <td>
          <?php load_field('checkbox',
              array('name'=>'user_role_permissions['.$user_role_permission['module_name'].'][delete]',
                    'field'=>'delete',
                    'class' => 'readonly',
                    'value' => @$user_role_permission['delete'],
                    'controller' => 'user_role_permissions',
                    'option'=> array(
                                array('chk_id' => @$user_role_permission['module_name'].'_delete',
                                      'label_for' => @$user_role_permission['module_name'].'_delete',
                                      'value' => 1,)))) 
          ?>
        </td>
      </tr>
    <?php } } ?>
  </tbody>
</table>
