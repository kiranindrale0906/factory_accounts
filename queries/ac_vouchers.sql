RENAME TABLE  `ac_voucher` TO  `ac_vouchers` ;
ALTER TABLE  `ac_vouchers` CHANGE  `date`  `voucher_date` DATE NULL DEFAULT NULL ;
ALTER TABLE  `ac_vouchers` CHANGE  `account_name_id`  `account_id` INT( 11 ) NULL DEFAULT NULL ;
ALTER TABLE  `ac_vouchers` CHANGE  `bank_name_id`  `bank_id` INT( 11 ) NULL DEFAULT NULL ;
ALTER TABLE `ac_vouchers` ADD `credit_weight` FLOAT(10,2) NOT NULL AFTER `document`, ADD `debit_weight` FLOAT(10,2) NOT NULL AFTER `credit_weight`, ADD `purity` FLOAT(10,2) NOT NULL AFTER `debit_weight`, ADD `purity_id` FLOAT(11) NOT NULL AFTER `purity`, ADD `pure_gold_credit` FLOAT(10,2) NOT NULL AFTER `purity_id`, ADD `pure_gold_debit` FLOAT(10,2) NOT NULL AFTER `pure_gold_credit`;

ALTER TABLE `ac_vouchers` ADD `from_account_name` VARCHAR(255) NOT NULL AFTER `bank_id`, ADD `from_account_id` INT(11) UNSIGNED NOT NULL AFTER `from_account_name`;
