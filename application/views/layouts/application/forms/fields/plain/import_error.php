<div class="col-12 mt-3">
  <?php foreach(get_import_file_validation_errors() as $error) { ?>
    <div class="red font11 mb-2 medium">
      <?php echo ($error); ?>
    </div>  
  <?php } ?>
</div>