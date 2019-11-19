<?php
	declare(strict_types=1);
	set_time_limit(0);
	ini_set('error_log', 'log/php.error.log');
	/**
	 * @author		BOT-TS3
	 * @email		admin@bot-ts3.com
	 * @copyright	© bot-ts3.com
	 * @version		1.0
	 **/
	spl_autoload_register(function ($class_name) {
		require_once 'class/'.mb_strtolower($class_name).'.class.php';
	});
	$inst = getopt("i:");
	if(!empty($inst)){
		try {
			$bot = new Bot($inst['i']);
		} catch (Exception $e) {
			echo $e->getMessage(), "\n";
		}
	}
?>
