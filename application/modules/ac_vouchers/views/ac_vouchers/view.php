<?php
  if (!isset($record)) 
    $record = array();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php //$this->load->view('templates/title') ?>
    <style type="text/css">
      body {background: rgb(204,204,204);font-family: arial; font-size: 12px;text-align: left;}
      th {vertical-align: text-bottom;}
      page {background: white;display: block;margin: 0 auto;margin-bottom: 0.5cm;box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);}
      page[size="A4"] {width: 21cm;height: 29.7cm;padding: 3em; box-sizing: border-box;position: relative;}
      page[size="A4"][layout="portrait"] {width: 29.7cm;height: 21cm;}
      .btn-success{
          background-color: #28a745;
          border-color: #28a745;
          color: #fff;
      }
      @media print {
          body, page {margin: 0;box-shadow: 0;}
          .back_link{display: none;}
      }
      table tr td, table tr td{border:1px solid #ccc;}
      .printtable, .printtable th, .printtable td{border:1px solid #ccc;}
      a.back_link {background-color: #ddd;padding: 6px 10px;color: #000;border-radius: 2px;text-decoration: none;text-transform: uppercase;}
      div.fixedbtn{display: block;bottom: 5%;position: fixed;text-transform: uppercase;padding: 10px 20px;font-size: 15px;}
    </style>
  </head>
  <body>
    <page size="A4">
      <div style="width:50%; margin:0 auto;">
        <border style="display: block; height: 100%;margin-bottom: 30px;">
          <?php $class = $this->router->fetch_class(); ?>
          <table>
            <thead>
                <tr>
                    <?php if (!empty($company_data['logo'])): ?>
                        <td style="padding: 2px 10px;" width="50%">
                            <img src="<?= ADMIN_PATH . 'uploads/company/logo/' . $company_data['logo'] ?>" style="width: 50%;">
                        </td>
                    <?php endif; ?>
                    <td style="text-align: right;vertical-align: top" width="50%">
                        <div style="margin: 0 auto; padding: 5px; width: 75%; border-radius: 0 0 10px 10px;">    
                            <h4><?= ucwords(str_replace('_', ' ', $class)) ?></h4>
                        </div>
                    </td>

                </tr>
                <tr></tr>
            </thead>
          </table>
          <div style="clear:both"></div>
          <div style="float: left; border: 1px solid #DDD; padding: 0px 10px;">
              <h4>No: <?= $data[0]['voucher_number']; ?></h4>
          </div>
          <div style="float: right; border: 1px solid #DDD; padding: 0px 10px;">
              <h4>Date: <?= $data[0]['voucher_date']; ?></h4>
          </div>
          <div style="clear:both">&nbsp;</div>
            <center>
              <table class="printtable" style="border-collapse: collapse; width: 100%;">
                <thead>
                  <tr>
                    <th style="padding: 2px 10px; min-width: 72px; text-align: center">Particulars</th>
                    <th style="padding: 2px 10px; text-align: right;">Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="padding: 2px 10px; min-width: 72px; text-align: center">
                        <p><?= $data[0]['account_name'] ?></p>
                        <p><?= @$data[0]['narration'] ?></p>
                    </td>
                    <td style="padding: 2px 10px; text-align: right;">
                        <?= $data[0]['credit_amount'] ?>
                    </td>
                  </tr>                            
                  <tr>
                    <th style="padding: 2px 10px; text-align: right;">Total</th>
                    <th style="padding: 2px 10px; text-align: right;"><?= $data[0]['credit_amount'] ?></th>
                  </tr>
                </tbody>
              </table>
            </center>
        </border>
        <center>
          <b>
              <?= @$company_data['name'] ?>
              <br>
              <?= @($company_data['address_line1'] != '') ? $company_data['address_line1'] . '<br>' : '' ?>
              <?= @($company_data['address_line2'] != '') ? $company_data['address_line2'] . '<br>' : '' ?>
              <?= @($company_data['city'] != '') ? $company_data['city'] . '<br>' : '' ?>
              <?= @($company_data['state'] != '') ? $company_data['state'] . '<br>' : '' ?>
              <?= @$company_data['pincode'] ?> 
          </b>
        </center>
      </div>
        <?php $module = $this->router->fetch_module(); ?>
        <?php $controller = $this->router->fetch_class(); ?>

        <?php if (in_array($controller, array('cash_issue_voucher', 'cash_receipt_voucher', 'metal_issue_voucher', 'metal_receipt_voucher'))): ?>
            <div class="fixedbtn btn-success">
                <form method="post" class="form-horizontal" action="<?= base_url($module.'/'.$controller . '/uplaod_print_document/' . $data[0]['id']) ?>" enctype="multipart/formdata">
                   <!--  <input type="hidden" name="id" value="<?= $data[0]['id'] ?>">
                    <label class="btn">
                        Upload Document<input type="file" style="display: none;" id="document" name="<?= $name = $controller . '[document]' ?>">
                    </label> -->
                  <?php 
                    load_field('hidden', array('field' => 'id',
                                               'value'=>@$data[0]['id']));?>
                  <?php 
                    load_field('file', array('field' => 'document'));?>
                </form>
                <script src="<?= ADMIN_LAYOUTS_PATH ?>plugins/js/jquery-3.3.1.min.js"></script>
                <script>
                  $(document).ready(function () {
                    $(".custom-file-input").change(function () {
                        $(this).closest('form').submit();
                    })
                    $('body').on('submit', 'form', function (e) {
                      var form = $(this);
                      var method = form.attr('method');
                      var action = form.attr('action');
                      e.preventDefault();
                      $.ajax({
                        url: action,
                        type: method,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        cache: false,
                        data: new FormData(this),
                        success: function (data, textStatus, jqXHR) {
                          if (data.status == "success") {
                              alert('document updated successfully..');
                              window.location.href = data.redirect_url;
                          }
                        }
                      });
                    });
                  });
                </script>
            </div>
        <?php endif; ?>
    </page>
</body>
</html>