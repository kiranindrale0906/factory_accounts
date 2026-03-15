
	<div class="table-responsive tablefixedheader col-sm-6">
	<h5>Import In Backup Database</h5>
	  <table class="table table-sm fixedthead table-default" >
		<?php $this->load->view('table_header',array('headings'=>array('Database Backup Name')))?>
		<tbody>
			<?php foreach($scan_dir as $file_name){
				if($file_name != "." && $file_name !='..'){?>
			<tr>
				<td><a href="<?php echo base_url('sys/mysql_dump/create/?file_name=').$file_name?>"><?php echo $file_name?></a></td>
			</tr>
		<?php }}?>
		</tbody>
	  </table>
	</div>
</div>
