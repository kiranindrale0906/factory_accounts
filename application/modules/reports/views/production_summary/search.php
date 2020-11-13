<div class="row"> 
  <div class="col-md-12">
    <h6>
      Product Name: 
      <a class="ml-5 <?= ($product_name == '') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?account_name=<?= $account_name ?>&product_name=&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'>All</a>
        <?php foreach ($product_names as $product) { ?>
            <a class="ml-5 <?= ($product_name == $product) ? 'bold black underline' : '' ?>"
             href='<?= base_url() ?>reports/production_summary?account_name=<?= $account_name ?>&product_name=<?= $product ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'><?= $product ?></a>    
        <?php } ?>
    </h6>
  </div>
</div>

<br />

<div class="row"> 
  <div class="col-md-12">
    <h6>
      Account Name: 
      <a class="ml-5 <?= ($account_name == '') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?account_name=&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'>All</a>
        <?php foreach ($account_names as $account) { ?>
            <a class="ml-5 <?= ($account_name == $account) ? 'bold black underline' : '' ?>"
             href='<?= base_url() ?>reports/production_summary?account_name=<?= $account ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'><?= $account ?></a>    
        <?php } ?>
    </h6>
  </div>
</div>

<br /> 

<div class="row"> 
  <div class="col-md-12">
    <h6>
      In Purity: 
        <a class="ml-5 <?= ($in_purity == '') ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_summary?account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'>All</a>
      <?php foreach ($in_purities as $purity) { ?>
        <a class="ml-5 <?= ($product_name == $product) ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_summary?account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $purity ?>&category_one=<?= $category_one ?>&group_by=<?= $group_by ?>'><?= $purity ?></a>
      <?php } ?>
    </h6>
  </div>
</div>

<br />

<!-- <div class="row"> 
  <div class="col-md-12">
    <h6>
      Category One:
      <a class="ml-5 <?= ($category_one == '') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?account_name=<?= $account_name ?>&product_name=<?= $product ?>&in_purity=<?= $in_purity ?>&product_name=&category_one=&group_by=<?= $group_by ?>'>All</a>
      <?php foreach ($category_ones as $categoryone) { ?>
        <a class="ml-5 <?= ($category_one == $categoryone) ? 'bold black underline' : '' ?>" 
           href='<?= base_url() ?>reports/production_summary?account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $categoryone ?>&group_by=<?= $group_by ?>'><?= $categoryone ?></a>
      <?php } ?>
    </h6>
  </div>
</div> -->

<br />

<div class="row"> 
  <div class="col-md-12">
    <h6>
      Group By:
      <a class="ml-5 <?= ($group_by == '') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by='>All</a>
       <a class="ml-5 <?= ($group_by == 'Date') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Date'>Date</a>
       <a class="ml-5 <?= ($group_by == 'Month') ? 'bold black underline' : '' ?>" 
         href='<?= base_url() ?>reports/production_summary?account_name=<?= $account_name ?>&product_name=<?= $product_name ?>&in_purity=<?= $in_purity ?>&category_one=<?= $category_one ?>&group_by=Month'>Month</a>
    </h6>
  </div>
</div>


<br />