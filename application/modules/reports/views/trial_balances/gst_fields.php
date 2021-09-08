<?php if ($gst['taxable_amount'] != 0) { ?>
  <tr>
    <td><?= $gst_voucher ?> TAXABLE</td>
    <td class="text-right"><?= four_decimal($gst['taxable_amount'], '-') ?></td>
  </tr>
<?php } ?>

<?php if ($gst['cgst_amount'] != 0) { ?>
  <tr>
    <td><?= $gst_voucher ?> CGST</td>
    <td class="text-right"><?= four_decimal($gst['cgst_amount'], '-') ?></td>
  </tr>
<?php } ?>

<?php if ($gst['sgst_amount'] != 0) { ?>
  <tr>
    <td><?= $gst_voucher ?> SGST</td>
    <td class="text-right"><?= four_decimal($gst['sgst_amount'], '-') ?></td>
  </tr>
<?php } ?>

<?php if ($gst['tcs_amount'] != 0) { ?>
  <tr>
    <td><?= $gst_voucher ?> TCS</td>
    <td class="text-right"><?= four_decimal($gst['tcs_amount'], '-') ?></td>
  </tr>
<?php } ?>