<?php
  $controller = $this->router->directory.$this->router->class;
  $sessionData = $this->session->userdata();
?>

<aside class="sidenavbar sidenavbar_js expand">
	<div class="sidenav_scroll_js sidenav_scroll">	
	  <ul>       
		  <li class="py-3 border-bottom border-secondary">
		    <a href="">
		      <span class="icon align-middle"><i class="fas fa-user-circle font25"></i></span>
		      <span class="hide-menu pl-3">Admin</span>
		    </a>
		  </li>    
			<li class="submenu submenu_js">
				<a href="javascript:void()" class="dropicon fa-chevron-right">
					<span class="icon">
						<i class="material-icons">account_box</i>
					</span>
					<span>User</span>
				</a>
				<ul> 			
					<?php $this->load->view('layouts/application/navigation/menu_item', 
	      										array('url' => ADMIN_PATH.'user',
																	'active' => ($controller=='user') ? 'active' : '',
																	'title' => 'User',)); 
					?>            
				</ul>
			</li> 
			<li class="submenu submenu_js">
				<a href="javascript:void()" class="dropicon fa-chevron-right">
					<span class="icon">
						<i class="far fa-bullseye"></i>
					</span>
					<span>Rojmel</span>
				</a>
				<ul> 			
					<?php $this->load->view('layouts/application/navigation/menu_item', 
	      										array('url' => ADMIN_PATH.'rojmel',
																	'active' => ($controller=='rojmel') ? 'active' : '',
																	'title' => 'Rojmel',)); 
					?>            
				</ul>
			</li>		
			<li class="submenu submenu_js">
				<a href="javascript:void()" class="dropicon fa-chevron-right">
					<span class="icon">
						<i class="fab fa-black-tie"></i>
					</span>
					<span>Master</span> 
				</a>	
				<ul>
					<?php $this->load->view('layouts/application/navigation/menu_item', 
							          		array('url' => ADMIN_PATH.'master/groups',
									                'active' => ($controller=='master/groups') ? 'active' : '',
									                'title' => 'Account Groups',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
							          		array('url' => ADMIN_PATH.'master/account',
									                'active' => ($controller=='master/account') ? 'active' : '',
									                'title' => 'Account',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
	    											array('url' => ADMIN_PATH.'master/purity',
						                    	'active' => ($controller=='master/purity') ? 'active' : '',
						                    	'title' => 'Purity',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
							          		array('url' => ADMIN_PATH.'master/product_category',
									                'active' => ($controller=='master/product_category') ? 'active' : '',
									                'title' => 'Product Category',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
							          		array('url' => ADMIN_PATH.'master/company',
									                'active' => ($controller=='master/company') ? 'active' : '',
									                'title' => 'Company',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
			          						array('url' => ADMIN_PATH.'master/payment_terms',
					                    		'active' => ($controller=='master/payment_terms') ? 'active' : '',
					                    		'title' => 'Payment Terms',)); ?> 
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
							          		array('url' => ADMIN_PATH.'master/department',
									                'active' => ($controller=='master/department') ? 'active' : '',
									                'title' => 'Department',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
							          		array('url' => ADMIN_PATH.'master/department_category',
									                'active' => ($controller=='master/department_category') ? 'active' : '',
									                 'title' => 'Department Category',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
							          		array('url' => ADMIN_PATH.'master/customer_category',
									                'active' => ($controller=='master/customer_category') ? 'active' : '',
									                'title' => 'Customer Category',)); ?>                
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
							          		array('url' => ADMIN_PATH.'master/design',
									                'active' => ($controller=='master/design') ? 'active' : '',
									                'title' => 'Designs',)); ?>
					<?php $this->load->view('layouts/application/navigation/menu_item', 
							          		array('url' => ADMIN_PATH.'master/periods',
									                'active' => ($controller=='master/periods') ? 'active' : '',
									                'title' => 'Period',)); ?>					                
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
							          		array('url' => ADMIN_PATH.'master/opening_balance',
									                'active' => ($controller=='master/opening_balance') ? 'active' : '',
									                'title' => 'Opening Balance',)); ?>	
				</ul>			
			</li>
			<li class="submenu submenu_js">
				<a href="javascript:void()" class="dropicon fa-chevron-right">
					<span class="icon">
						<i class="far fa-exchange"></i>
					</span>
					<span>Transaction</span> 
				</a>	
				<ul>
					<?php $this->load->view('layouts/application/navigation/menu_item', 
											          	array(
											          		'url' => ADMIN_PATH.'transaction/cash_issue_voucher',
											              'active' => ($controller=='transaction/cash_issue_voucher') ? 'active' : '',
											              'title' => 'Cash Issue Voucher',)); ?>
		      <?php $this->load->view('layouts/application/navigation/menu_item', 
										          		array(
										          			'url' => ADMIN_PATH.'transaction/bank_issue_voucher',
										                'active' => ($controller=='transaction/bank_issue_voucher') ? 'active' : '',
										                'title' => 'Bank Issue Voucher',)); ?>
		      <?php $this->load->view('layouts/application/navigation/menu_item', 
										          		array(
										          			'url' => ADMIN_PATH.'transaction/metal_issue_voucher',
										                'active' => ($controller=='transaction/metal_issue_voucher') ? 'active' : '',
										                'title' => 'Metal Issue Voucher',)); ?>
		      <?php $this->load->view('layouts/application/navigation/menu_item', 
										          		array(
										          			'url' => ADMIN_PATH.'transaction/sales_voucher',
										                'active' => ($controller=='transaction/sales_voucher') ? 'active' : '',
										                'title' => 'Sales Voucher',)); ?>
		      <?php $this->load->view('layouts/application/navigation/menu_item', 
										          		array(
										          			'url' => ADMIN_PATH.'transaction/purchase_voucher',
										                'active' => ($controller=='transaction/purchase_voucher') ? 'active' : '',
										                'title' => 'Purchase Voucher',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/sales_return_voucher',
												            'active' => ($controller=='transaction/sales_return_voucher') ? 'active' : '',
												            'title' => 'Sales Return Voucher',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/opening_stock_voucher',
												            'active' => ($controller=='transaction/opening_stock_voucher') ? 'active' : '',
												            'title' => 'Opening Stock Voucher',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/dispatch_voucher',
												            'active' => ($controller=='transaction/dispatch_voucher') ? 'active' : '',
												            'title' => 'Dispatch Voucher',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/journal_voucher',
												            'active' => ($controller=='transaction/journal_voucher') ? 'active' : '',
												            'title' => 'Journal/Contra Voucher',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/rate_cut_purchase_price_issue_voucher',
												            'active' => ($controller=='transaction/rate_cut_purchase_price_issue_voucher') ? 'active' : '',
												            'title' => 'Rate Cut Purchase',)); ?> 
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/rate_cut_booking_price_issue_voucher',
												            'active' => ($controller=='transaction/rate_cut_booking_price_issue_voucher') ? 'active' : '',
												            'title' => 'Rate Cut Booking',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/transfer_voucher',
												            'active' => ($controller=='transaction/transfer_voucher') ? 'active' : '',
												            'title' => 'Transfer Voucher',)); ?> 
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/expense_voucher',
												            'active' => ($controller=='transaction/expense_voucher') ? 'active' : '',
												            'title' => 'Expense Voucher',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/repair_voucher',
												            'active' => ($controller=='transaction/repair_voucher') ? 'active' : '',
												            'title' => 'Repair Voucher',)); ?>
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/repair_voucher_out',
												            'active' => ($controller=='transaction/repair_voucher_out') ? 'active' : '',
												            'title' => 'Repair Out Voucher',)); ?>  
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/approval_voucher',
												            'active' => ($controller=='transaction/approval_voucher') ? 'active' : '',
												            'title' => 'Approval Voucher',)); ?>   
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/approval_in_voucher',
												            'active' => ($controller=='transaction/approval_in_voucher') ? 'active' : '',
												            'title' => 'Approval In Voucher',)); ?>  
	        <?php $this->load->view('layouts/application/navigation/menu_item', 
												      		array(
												      			'url' => ADMIN_PATH.'transaction/sales_items',
												            'active' => ($controller=='transaction/sales_items') ? 'active' : '',
												            'title' => 'Sales Items',)); ?>                       	
				</ul>			
			</li>
			<li class="submenu submenu_js">
				<a href="javascript:void()" class="dropicon fa-chevron-right">
					<span class="icon">
						<i class="fas fa-file-alt"></i>
					</span>
					<span>MIS Report</span>
				</a>
				<ul> 			
					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'mis_report',
																		'active' => ($controller=='mis_report') ? 'active' : '',
																		'title' => 'MIS Report',)); ?>            
				</ul>
			</li>
			<li class="submenu submenu_js">
				<a href="javascript:void()" class="dropicon fa-chevron-right">
					<span class="icon">
						<i class="far fa-chart-line"></i>
					</span>
					<span>Stock Report</span>
				</a>
				<ul> 			
					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'stock_report',
																		'active' => ($controller=='stock_report') ? 'active' : '',
																		'title' => 'Stock Report',)); ?>            
				</ul>
			</li>
			<li class="submenu submenu_js">
				<a href="javascript:void()" class="dropicon fa-chevron-right">
					<span class="icon">
						<i class="far fa-chart-line"></i>
					</span>
					<span>Order Report</span>
				</a>
				<ul> 			
					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'order_report',
																		'active' => ($controller=='order_report') ? 'active' : '',
																		'title' => 'Order Report',)); ?>            
				</ul>
			</li>
			<li class="submenu submenu_js">
				<a href="javascript:void()" class="dropicon fa-chevron-right">
					<span class="icon">
						<i class="fas fa-percent"></i>
					</span>
					<span>Interest</span>
				</a>
				<ul> 			
					<?php $this->load->view('layouts/application/navigation/menu_item', 
													        array(
													        	'url' => ADMIN_PATH.'interest_issue_voucher',
																		'active' => ($controller=='interest_issue_voucher') ? 'active' : '',
																		'title' => 'Interest Issue Voucher',)); ?>            
				</ul>
			</li>
			<li class="submenu submenu_js">
				<a href="javascript:void()" class="dropicon fa-chevron-right">
					<span class="icon">
						<i class="fas fa-question-circle"></i>
					</span>
					<span>Other</span>
				</a>
				<ul> 			
					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'other/account_wise_details',
																		'active' => ($controller=='other/account_wise_details') ? 'active' : '',
																		'title' => 'Account Wise Detail',)); ?>
					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'other/category',
																		'active' => ($controller=='other/category') ? 'active' : '',
																		'title' => 'Category',)); ?>	

					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'other/item',
																		'active' => ($controller=='other/item') ? 'active' : '',
																		'title' => 'Item',)); ?>

					<?php $this->load->view('layouts/application/navigation/menu_item', 
			        										array(
			        											'url' => ADMIN_PATH.'other/city',
																		'active' => ($controller=='other/city') ? 'active' : '',
																		'title' => 'City',)); ?>
					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'other/state',
																		'active' => ($controller=='other/state') ? 'active' : '',
																		'title' => 'State',)); ?>
					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'other/salesman',
																		'active' => ($controller=='other/salesman') ? 'active' : '',
																		'title' => 'Salesman',)); ?>
					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'other/narration',
																		'active' => ($controller=='other/narration') ? 'active' : '',
																		'title' => 'Narration',)); ?>	
					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'other/book',
																		'active' => ($controller=='other/book') ? 'active' : '',
																		'title' => 'Book',)); ?>	
					<?php $this->load->view('layouts/application/navigation/menu_item', 
												        	array(
												        		'url' => ADMIN_PATH.'other/sms',
																		'active' => ($controller=='other/sms') ? 'active' : '',
																		'title' => 'SMS',)); ?>	

				</ul>
			</li>
	  </ul>
  </div>
</aside>