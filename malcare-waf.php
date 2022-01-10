<?php
// Please validate auto_prepend_file setting before removing this file

if (file_exists('/var/www/html/wp-content/plugins/blogvault-real-time-backup/protect/prepend/ignitor.php')) {
	define("MCDATAPATH", '/var/www/html/wp-content/mc_data/');
	define("MCCONFKEY", '27c6a1019444fdab6a94b1545eb311d6');
	include_once('/var/www/html/wp-content/plugins/blogvault-real-time-backup/protect/prepend/ignitor.php');
}
?>
