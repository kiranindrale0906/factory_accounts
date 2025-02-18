<div class="row"> 
  <div class="col-md-12">
    <h6>
      Factory: 
  
      <?php if($_SESSION['all_details']==1){?>    
      <a class="ml-5 <?= ($site_name == '') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_same_purity_summary&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>All</a>
      <a class="ml-5 <?= ($site_name == 'ARNA BANGLE ERP' || $site_name == 'ARNA BANGLE') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARNA BANGLE ERP&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>ARNA BANGLE ERP</a>
      <a class="ml-5 <?= ($site_name == 'Rnd Erp Software') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=RND ERP&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>RND ERP</a>
       <a class="ml-5 <?= ($site_name == 'Domestic Internal ERP' || $site_name == 'Domestic Internal ERP Software') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=Domestic Internal ERP&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>Domestic Internal ERP</a>
    
      <?php  }?>
      <?php if($_SESSION['arg_details']==1){?>    
        <a class="ml-5 <?= ($site_name == 'AR Gold (Apr 2024)') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=AR Gold (Apr 2024)&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>AR Gold (Apr 2024)</a>
           <a class="ml-5 <?= ($site_name == 'AR Gold ERP' || $site_name == 'ARG ERP Software') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=AR Gold ERP&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>AR Gold ERP</a>
     
      <?php }?>
      <?php if($_SESSION['arf_details']==1){?> 
        <a class="ml-5 <?= ($site_name == 'ARF (Apr 2024)') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARF (Apr 2024)&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>ARF (Apr 2024)</a>   
        <a class="ml-5 <?= ($site_name == 'ARF (Aug 2024)') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARF (Aug 2024)&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>ARF (Aug 2024)</a>   
           <a class="ml-5 <?= ($site_name == 'ARF ERP' || $site_name == 'ARF ERP Software' || $site_name == 'Arf Erp Software') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARF ERP&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>ARF ERP</a>
      
      <?php }?>   
      <?php if($_SESSION['arc_details']==1){?> 
        <a class="ml-5 <?= ($site_name == 'ARC (Apr 2024)') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARC (Apr 2024)&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>ARC (Apr 2024)</a>   
           <a class="ml-5 <?= ($site_name == 'ARC ERP' || $site_name == 'ARC ERP Software'|| $site_name == 'Arc Erp Software') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=ARC ERP&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>ARC ERP</a>
      
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
         href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>All</a>
       <a class="ml-5 <?= ($group_by == 'Date') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Date&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>Date</a>
       <a class="ml-5 <?= ($group_by == 'Week') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Week&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>Week</a>
       <a class="ml-5 <?= ($group_by == 'Month') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Month&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>Month</a>
         <a class="ml-5 <?= ($group_by == 'Year') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Year&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>Year</a>
    </h6>
  </div>
</div>
<div class="row">
  <div class="col-md-12">

  <h6>
       ERP Months (2024):
  <?php $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
      foreach ($months as $month_key => $month) { ?>
        <a class="ml-5 <?= ($filter_month == $month_key) ? 'bold black underline' : '' ?>"
               href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>&filter_month=<?= $month_key ?>&filter_year=2024'><?= $month ?></a>

          <?php } ?>
     </h6>
   </div>
   
      <div class="col-md-12">
  <h6>
       ERP Months (2025):
  <?php $new_months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
      foreach ($new_months as $new_month_key => $new_month) { ?>
        <a class="ml-5 <?= ($filter_month == $new_month_key) ? 'bold black underline' : '' ?>"
               href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>&filter_month=<?= $new_month_key ?>&filter_year=2025'><?= $new_month ?></a>

          <?php } ?>
     </h6>
   </div>
   </div>
  <div class="row"> 
<?php if (!empty($product_names)) { ?>
    <div class="col-md-12">
      <h6>
        Product Name: 
        <a class="ml-5 <?= ($product_name == '') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=&in_purity=<?= $in_purity ?>&group_by=<?= $group_by ?>&filter_month=<?=$filter_month ?>&filter_year=2024'>All</a>
          <?php foreach ($product_names as $product) { ?>
            <a class="ml-5 <?= ($product_name == $product) ? 'bold black underline' : '' ?>"
               href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&account_name=<?= $account_name ?>&product_name=<?= $product ?>&in_purity=<?= $in_purity ?>&group_by=<?= $group_by ?>&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'><?= $product ?></a>    
          <?php } ?>
      </h6>
    </div>
  <br />
<?php } ?>
  </div>
<br />
  <div class="row"> 
<?php if (!empty($category_ones)) { ?>
    <div class="col-md-12">
      <h6>
        Category One:
        <a class="ml-5 <?= ($category_one == '') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=&group_by=<?= $group_by ?>&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'>All</a>
        <?php foreach ($category_ones as $categoryone) { ?>
          <a class="ml-5 <?= ($category_one == $categoryone) ? 'bold black underline' : '' ?>" 
             href='<?= base_url() ?>reports/production_same_purity_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $categoryone ?>&group_by=<?= $group_by ?>&filter_month=<?=$filter_month ?>&filter_year=<?= $filter_year ?>'><?= $categoryone ?></a>
        <?php } ?>
      </h6>
    </div>
  <br />
<?php } ?>
  </div>
      