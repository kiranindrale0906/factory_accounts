<h5 class="heading noprint">Refresh View</h5>

<div class="row text-right">
<div class="col-md-12">
<a href="<?=ADMIN_PATH.'argold/refresh/delete/'.$refresh['id']?>" class='btn bg_red white'>Delete</a>
</div>
</div>
<?php

  $this->load->view('refresh_details/viewlist');
?>
