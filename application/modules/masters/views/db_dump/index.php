
	<div class="table-responsive tablefixedheader col-sm-6">
	<h5>Import In Backup Database</h5>
	  <table class="table table-sm fixedthead table-default" >
		<?php $this->load->view('table_header',array('headings'=>array('Database Backup Name')))?>
		<tbody>
			<?php 
			$db_full_name=$db_display_name='';
			foreach($scan_dir as $file_name){
				$db_name=explode('-', $file_name);
				$db_full_name=$db_name[0];
				$db_display_name=!empty($db_name[1])?$db_name[1]:'';
				$replace_db_name=str_replace("_", " ", $db_display_name);
				$db_display_name=explode('.sql', $replace_db_name)[0];
				if($file_name != "." && $file_name !='..' && $db_full_name=='accounts_nov2020_production'){?>
			<tr>
				<td><a href="<?php echo base_url('masters/mysqldump/create/?file_name=').$file_name?>"><?php echo $db_display_name?></a></td>
			</tr>
            <?php }}?>
		</tbody>
	  </table>
	</div>

