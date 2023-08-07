<h5 class="heading noprint">Refresh View</h5>
<div class="col-md-8 text-right">
<a href="<?=ADMIN_PATH.'argold/refresh/'.$refresh['id']?>" class='btn bg_red white'>Delete</a>

</div>
<?php

  $this->load->view('refresh_details/viewlist');
?>