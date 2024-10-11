<div class="row"> 
  <div class="col-md-12">
    <h6>
      Factory: 
  
      <?php if($_SESSION['all_details']==1){?>    
      <a class="ml-5 <?= ($site_name == '') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_same_purity_summary'>All</a>
      <a class="ml-5 <?= ($site_name == 'ARNA BANGLE ERP' || $site_name == 'ARNA BANGLE') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARNA BANGLE ERP'>ARNA BANGLE ERP</a>
      <a class="ml-5 <?= ($site_name == 'Rnd Erp Software') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=RND ERP'>RND ERP</a>
       <a class="ml-5 <?= ($site_name == 'Domestic Internal ERP' || $site_name == 'Domestic Internal ERP Software') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=Domestic Internal ERP'>Domestic Internal ERP</a>
    
      <?php  }?>
      <?php if($_SESSION['arg_details']==1){?>    
        <a class="ml-5 <?= ($site_name == 'AR Gold (Apr 2024)') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=AR Gold (Apr 2024)'>AR Gold (Apr 2024)</a>
           <a class="ml-5 <?= ($site_name == 'AR Gold ERP' || $site_name == 'ARG ERP Software') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=AR Gold ERP'>AR Gold ERP</a>
     
      <?php }?>
      <?php if($_SESSION['arf_details']==1){?> 
        <a class="ml-5 <?= ($site_name == 'ARF (Apr 2024)') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARF (Apr 2024)'>ARF (Apr 2024)</a>   
        <a class="ml-5 <?= ($site_name == 'ARF (Aug 2024)') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARF (Aug 2024)'>ARF (Aug 2024)</a>   
           <a class="ml-5 <?= ($site_name == 'ARF ERP' || $site_name == 'ARF ERP Software' || $site_name == 'Arf Erp Software') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARF ERP'>ARF ERP</a>
      
      <?php }?>   
      <?php if($_SESSION['arc_details']==1){?> 
        <a class="ml-5 <?= ($site_name == 'ARC (Apr 2024)') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARC (Apr 2024)'>ARC (Apr 2024)</a>   
           <a class="ml-5 <?= ($site_name == 'ARC ERP' || $site_name == 'ARC ERP Software'|| $site_name == 'Arc Erp Software') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARC ERP'>ARC ERP</a>
      
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
         href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by='>All</a>
       <a class="ml-5 <?= ($group_by == 'Date') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Date'>Date</a>
       <a class="ml-5 <?= ($group_by == 'Week') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Week'>Week</a>
       <a class="ml-5 <?= ($group_by == 'Month') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Month'>Month</a>
         <a class="ml-5 <?= ($group_by == 'Year') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Year'>Year</a>
    </h6>
  </div>
</div>
<br />
      