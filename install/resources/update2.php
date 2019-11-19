<?php
	set_time_limit(0);

	 // Version: 4.1.1

	if(!file_exists("./includes/config.php") == true) {
		die("Plik config.php nie istnieje!");
	}else{
		$config = require './includes/config.php';
	}
	try{
		$db = new PDO('mysql:host='.$config['mysql']['host'].';dbname='.$config['mysql']['database'].';port='.$config['mysql']['port'], $config['mysql']['username'], $config['mysql']['password']);
	}catch(PDOException $e){
		echo 'Połączenie nie mogło zostać utworzone: '.$e->getMessage();
	}
	$db->query("SET NAMES utf8mb4");
	$db->beginTransaction();
	echo "Tworzenie tabeli `banhistory`\n";
	$db->query("CREATE TABLE `banhistory` (
		`id` int(255) NOT NULL AUTO_INCREMENT,
		`banid` int(255) NOT NULL DEFAULT '0',
		`ip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`uid` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`cldbid` int(255) NOT NULL DEFAULT '0',
		`lastnickname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`created` int(100) NOT NULL DEFAULT '0',
		`duration` int(100) NOT NULL DEFAULT '0',
		`invokername` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`invokercldbid` int(255) NOT NULL DEFAULT '0',
		`invokeruid` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`reason` varchar(5000) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
	echo "Tabela `banhistory` została utworzona\n";
	sleep(1);
	echo "Dodawanie nowych komend\n";
	$db->query("INSERT INTO `command` (`id`, `cmd`, `alias`, `staff`, `group`, `description`, `syntax`) VALUES (NULL, 'banhistory', 'bh', '10', '', 'Komenda wyświetla historię banów', '!banhistory ip/uid/cldbid')");
	$db->query("INSERT INTO `command` (`id`, `cmd`, `alias`, `staff`, `group`, `description`, `syntax`) VALUES (NULL, 'gamble', 'gb', '0', '', 'Komenda pozwala obstawić punkty', '!gamble ilość_pkt|all')");
	$db->query("INSERT INTO `command` (`id`, `cmd`, `alias`, `staff`, `group`, `description`, `syntax`) VALUES (NULL, 'punkty', 'pkt', '0', '', 'Komenda pozwala sprawdzić ilość punktów', '!punkty')");
	echo "Komendy zostały dodane\n";
	sleep(1);
	echo "Dodawanie brakujących kolumn\n";
	$db->query("ALTER TABLE `users` ADD `lvl` INT(10) NOT NULL DEFAULT '1' AFTER `last_activity`");
	$db->query("ALTER TABLE `users` ADD `exp` FLOAT NOT NULL DEFAULT '0' AFTER `lvl`");
	$db->query("ALTER TABLE `users` ADD `pkt` INT(255) NOT NULL DEFAULT '0' AFTER `exp`");
	echo "Kolumny zostały dodane";
	$db->rollBack();
?>