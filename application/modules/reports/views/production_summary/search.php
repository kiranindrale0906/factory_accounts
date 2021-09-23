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
         href='<?= base_url() ?>reports/production_summary?site_name=AR Gold Nov 2020'>AR Gold Nov 2020</a>
      <a class="ml-5 <?= ($site_name == 'AR Gold') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=AR Gold Jan 2021'>AR Gold Jan 2021</a>
      <?php }?>
      <?php if($_SESSION['arf_details']==1){?> 
      <a class="ml-5 <?= ($site_name == 'ARF') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=ARF Nov 2020'>ARF Nov 2020</a>
      <a class="ml-5 <?= ($site_name == 'ARF') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=ARF Jan 2021'>ARF Jan 2021</a>   
      <?php }?>   
      <?php if($_SESSION['arc_details']==1){?> 
      <a class="ml-5 <?= ($site_name == 'ARC') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=ARC Nov 2020'>ARC Nov 2020</a>
      <a class="ml-5 <?= ($site_name == 'ARC') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?site_name=ARC Jan 2021'>ARC Jan 2021</a>   
      <?php }?>
    </h6>
  </div>
</div>
<br />

<?php if (!empty($account_names)) { ?>
  <div class="row"> 
    <div class="col-md-12">
      <h6>
        Account Name: 
        <a class="ml-5 <?= ($account_name == '') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'>All</a>
          <?php foreach ($account_names as $account) { ?>
            <a class="ml-5 <?= ($account_name == $account) ? 'bold black underline' : '' ?>"
               href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'><?= $account ?></a>    
          <?php } ?>
      </h6>
    </div>
  </div>
  <br /> 
<?php } ?>

<?php if (!empty($product_names)) { ?>
  <div class="row"> 
    <div class="col-md-12">
      <h6>
        Product Name: 
        <a class="ml-5 <?= ($product_name == '') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=&in_purity=<?= $in_purity ?>&group_by=<?= $group_by ?>'>All</a>
          <?php foreach ($product_names as $product) { ?>
            <a class="ml-5 <?= ($product_name == $product) ? 'bold black underline' : '' ?>"
               href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&account_name=<?= $account_name ?>&product_name=<?= $product ?>&in_purity=<?= $in_purity ?>&group_by=<?= $group_by ?>'><?= $product ?></a>    
          <?php } ?>
      </h6>
    </div>
  </div>
  <br />
<?php } ?>

<?php if (!empty($in_purities)) { ?>
  <div class="row"> 
    <div class="col-md-12">
      <h6>
        In Purity: 
          <a class="ml-5 <?= ($in_purity == '') ? 'bold black underline' : '' ?>" 
             href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'>All</a>
        <?php foreach ($in_purities as $purity) { ?>
          <a class="ml-5 <?= ($in_purity == $purity) ? 'bold black underline' : '' ?>" 
             href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'><?= $purity ?></a>
        <?php } ?>
      </h6>
    </div>
  </div>
  <br />
<?php } ?>

<?php if (!empty($category_ones)) { ?>
  <div class="row"> 
    <div class="col-md-12">
      <h6>
        Category One:
        <a class="ml-5 <?= ($category_one == '') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=&group_by=<?= $group_by ?>'>All</a>
        <?php foreach ($category_ones as $categoryone) { ?>
          <a class="ml-5 <?= ($category_one == $categoryone) ? 'bold black underline' : '' ?>" 
             href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $categoryone ?>&group_by=<?= $group_by ?>'><?= $categoryone ?></a>
        <?php } ?>
      </h6>
    </div>
  </div>
  <br />
<?php } ?>

<?php if (!empty($machine_sizes)) { ?>
  <div class="row"> 
    <div class="col-md-12">
      <h6>
        Machine Size:
        <a class="ml-5 <?= ($machine_size == '') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'>All</a>
        <?php foreach ($machine_sizes as $machinesize) { ?>
          <a class="ml-5 <?= ($machine_size == $machinesize) ? 'bold black underline' : '' ?>" 
             href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machinesize ?>&design_code=<?= $design_code ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'><?= $machinesize ?></a>
        <?php } ?>
      </h6>
    </div>
  </div>
  <br />
<?php } ?>

<?php if (!empty($design_codes)) { ?>
  <div class="row"> 
    <div class="col-md-12">
      <h6>
        Design Codes:
        <a class="ml-5 <?= ($design_code == '') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'>All</a>
        <?php foreach ($design_codes as $designcode) { ?>
          <a class="ml-5 <?= ($design_code == $designcode) ? 'bold black underline' : '' ?>" 
             href='<?= base_url() ?>reports/production_summary?site_name=<?= $site_name ?>&machine_size=<?= $machine_size ?>&design_code=<?= $designcode ?>&account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'><?= $designcode ?></a>
        <?php } ?>
      </h6>
    </div>
  </div>
  <br />
<?php } ?>

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