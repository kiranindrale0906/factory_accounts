
<thead class="nowrap">
	<?php if ($filter_columns != '' && $table_data != '') { ?>
    <tr>
      <?php if ($checkbox_option) { ?>
        <th>
          <?= 'Select Rows' ?>
        </th>
      <?php } ?>
      <?php foreach ($thead as $thkey => $thvalue) { ?>
          <th>
            <?php echo $thvalue[0] ?>
            <?php echo $thvalue[1] ?>
            <?php echo $thvalue[2] ?>
          </th>
      <?php } ?>
    </tr>
	<?php } ?>
</thead>