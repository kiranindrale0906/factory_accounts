CREATE TABLE IF NOT EXISTS `change_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `table_name` varchar(600) NOT NULL,
  `old_attributes` text NOT NULL,
  `new_attributes` text NOT NULL,
  `table_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

alter table change_logs change table_name model_name varchar(255); 
alter table change_logs change table_id table_id int(11); 
ALTER TABLE  `change_logs` ADD  `record_id` INT( 11 ) NOT NULL AFTER  `table_id` ;
