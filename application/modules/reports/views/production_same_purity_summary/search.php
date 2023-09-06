<div class="row"> 
  <div class="col-md-12">
    <h6>
      Factory: 
  
      <?php if($_SESSION['all_details']==1){?>    
      <a class="ml-5 <?= ($site_name == '') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary'>All</a>
      <?php }?>
      <?php if($_SESSION['arg_details']==1){?>    
      
       <a class="ml-5 <?= ($site_name == 'AR Gold') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=AR Gold'>AR Gold</a>
      <?php }?>
      <?php if($_SESSION['arf_details']==1){?> 
      
      <a class="ml-5 <?= ($site_name == 'ARF') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=ARF'>ARF</a>   
      <?php }?>   
      <?php if($_SESSION['arc_details']==1){?> 
      
      <a class="ml-5 <?= ($site_name == 'ARC') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=ARC'>ARC</a>   
      <?php }?>
    </h6>
  </div>

 </div> 
</br>
 <div class="row"> 
  <div class="col-md-12">
    <h6>
      Group By:
      <a class="ml-5 <?= ($group_by == '') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by='>All</a>
       <a class="ml-5 <?= ($group_by == 'Date') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Date'>Date</a>
       <a class="ml-5 <?= ($group_by == 'Week') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Week'>Week</a>
       <a class="ml-5 <?= ($group_by == 'Month') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Month'>Month</a>
         <a class="ml-5 <?= ($group_by == 'Year') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Year'>Year</a>
    </h6>
  </div>
</div>
<br />
      