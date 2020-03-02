<div class="panel-footer sticky_bottom bg_white mt-2 d-flex align-items-center justify-content-center mCustomScrollbar_x_js">
	<div class="d-inline-block mr-2">	
		<ul class="pagination pagination_blue pagination-sm m-0">
			<?php if($pagination['page_no']!=1){?>
				<li class="page-item previous" aria-controls="datatable" tabindex="0" id="datatable_previous">
					<a class="page-link" href="<?php echo $pagination['order_url'];?>&page_no=<?php echo $pagination['prev_page_id']?>">Previous</a>
				</li>
			<?php }?>

			<?php for($i=1;$i<=$pagination['pages'];$i++) {
				($i==$pagination['page_no']) ? $class = 'active' : $class = '';?>
				<li class="page-item <?php echo $class; ?>" aria-controls="datatable" tabindex="0">
					<a class="page-link"  href="<?php echo $pagination['order_url']?>&page_no=<?=$i;?>">
						<?=$i;?>
					</a>
				</li>
			<?php } ?>

			<?php if($pagination['pages']!=$pagination['page_no'] && $pagination['pages']!=0){?>
				<li class="page-item next" aria-controls="datatable" tabindex="0" id="datatable_next">
					<a class="page-link" href="<?php echo $pagination['order_url']?>&page_no=<?php echo $pagination['next_page_id']?>">Next</a>
				</li>
			<?php }?>
		</ul>
	</div>
</div>