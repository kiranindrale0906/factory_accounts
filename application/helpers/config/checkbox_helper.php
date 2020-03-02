<?php
function force_update_checkbox(){
  return array(array('chk_id' => 'true',
                     'value' => '1',
                     'label' => 'True',
                     'checked' => 'checked'),
               array('chk_id' => 'false',
                     'value' => '0',
                     'label' => 'False'));
}

function device_type_radio()
{
  return array(array('chk_id' => 'andriod',
                     'label_for' => 'andriod',
                     'value' => '1',
                     'label' => 'Andriod',
                     'checked' => 'checked'),
               array('chk_id' => 'ios',
                    'label_for' => 'ios',
                    'value' => '2',
                    'label' => 'IOS'));
}

function status_radio()
{
  return array(array('chk_id' => 'active',
                     'label_for' => 'active',
                     'value' => '1',
                     'label' => 'Active',
                     'checked' => 'checked'),
               array('chk_id' => 'inactive',
                     'label_for' => 'inactive',
                     'value' => '0',
                     'label' => 'Inactive'));
}

function disabled_radio()
{
  return array(array('chk_id' => 'yes',
                     'label_for' => 'yes',
                     'value' => '1',
                     'label' => 'Yes',
                     'checked' => 'checked'),
               array('chk_id' => 'no',
                     'label_for' => 'no',
                     'value' => '0',
                     'label' => 'No'));
}

function disabled_radio_solitaire()
{
  return array(array('chk_id' => 'yes',
                     'label_for' => 'yes',
                     'value' => '1',
                     'label' => 'Yes',
                     'checked' => 'checked'),
               array('chk_id' => 'no',
                     'label_for' => 'no',
                     'value' => '0',
                     'label' => 'No'));
}

function alignment_radio()
{
  return array(array('chk_id' => 'right',
                     'label_for' => 'right',
                     'value' => '1',
                     'label' => 'Right',
                     'checked' => 'checked'),
               array('chk_id' => 'left',
                     'label_for' => 'left',
                     'value' => '0',
                     'label' => 'Left'));
}

function is_set()
{
  return array(array('chk_id' => 'yes1',
                     'label_for' => 'yes1',
                     'value' => '1',
                     'label' => 'Yes',
                     'checked' => 'checked'),
               array('chk_id' => 'no1',
                     'label_for' => 'no1',
                     'value' => '0',
                     'label' => 'No'));
}


function rhodium_radio() {
  return array(array('value' => '0', 
                     'label' => 'No'),
               array('value' => '1', 
                     'label' => 'Yes'));
}

function gender_radio(){
  return array(array('value' => 'Female', 
                     'label' => 'Female'),
               array('value' => 'Male', 
                     'label' => 'Male'));
}

function visited_done_radio(){
  return array(array('value' => '1',
                     'checked' =>'checked', 
                     'label' => 'Visit Done'),
               array('value' => '0', 
                     'label' => 'Appointment'));
}


