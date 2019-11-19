<?php
	set_time_limit(0);

	 // Version: 4.1.0

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
	$db2 = new PDO('sqlite:ts3bot.sqlitedb');
	echo "Tworzenie tabeli `channel`\n";
	$db->query("CREATE TABLE `channel` (
		`id` int(255) NOT NULL AUTO_INCREMENT,
		`cldbid` int(255) NOT NULL DEFAULT '0',
		`cid` int(255) NOT NULL DEFAULT '0',
		`connection_client_ip` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`pin` varchar(25) NOT NULL,
		PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
	echo "Tabela `channel` została utworzona\n";
	sleep(1);
	echo "Przenoszenie danych z tabeli channel\n";
	$query = $db2->query("SELECT * FROM `channel`");
	if($query){
		while($row = $query->fetch()){
			$db->query("INSERT INTO `channel` (`id`, `cldbid`, `cid`, `connection_client_ip`, `pin`) VALUES (NULL, {$row['cldbid']}, {$row['cid']}, '{$row['connection_client_ip']}', '{$row['pin']}')");
		}
	}
	echo "Dane zostały przeniesione\n";
	sleep(1);
	echo "Tworzenie tabeli `command`\n";
	$db->query("CREATE TABLE `command` (
		`id` int(255) NOT NULL AUTO_INCREMENT,
		`cmd` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`alias` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`staff` int(10) NOT NULL DEFAULT '0',
		`group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`description` varchar(5000) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`syntax` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
	echo "Tabela `command` została utworzona\n";
	sleep(1);
	echo "Przenoszenie danych z tabeli `command`\n";
	$query = $db2->query("SELECT * FROM `command`");
	if($query){
		while($row = $query->fetch()){
			$db->query("INSERT INTO `command` (`id`, `cmd`, `alias`, `staff`, `group`, `description`, `syntax`) VALUES (NULL, '{$row['cmd']}', '{$row['alias']}', {$row['staff']}, '{$row['group']}', '{$row['description']}', '{$row['syntax']}')");
		}
	}
	echo "Dane zostały przeniesione\n";
	sleep(1);
	echo "Tworzenie tabeli `command_txt`\n";
	$db->query("CREATE TABLE `command_txt` (
		`id` int(255) NOT NULL AUTO_INCREMENT,
		`cmd` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`alias` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`text` varchar(5000) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`staff` int(10) NOT NULL DEFAULT '0',
		`group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`description` varchar(5000) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`syntax` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
	echo "Tabela `command_txt` została utworzona\n";
	sleep(1);
	echo "Przenoszenie danych z tabeli `command_txt`\n";
	$query = $db2->query("SELECT * FROM `command_txt`");
	if($query){
		while($row = $query->fetch()){
			$db->query("INSERT INTO `command_txt` (`id`, `cmd`, `alias`, `text` `staff`, `group`, `description`, `syntax`) VALUES (NULL, '{$row['cmd']}', '{$row['alias']}', '{$row['text']}', {$row['staff']}, '{$row['group']}', '{$row['description']}', '{$row['syntax']}')");
		}
	}
	echo "Dane zostały przeniesione\n";
	sleep(1);
	echo "Tworzenie tabeli `ip`\n";
	$db->query("CREATE TABLE `ip` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`ip` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`proxy` int(1) NOT NULL DEFAULT '0',
		`time` int(255) NOT NULL DEFAULT '0',
		PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
	echo "Tabela `ip` została utworzona\n";
	sleep(1);
	echo "Przenoszenie danych z tabeli `ip`\n";
	$query = $db2->query("SELECT * FROM `ip`");
	if($query){
		while($row = $query->fetch()){
			$db->query("INSERT INTO `ip` (`id`, `ip`, `proxy`, `time`) VALUES (NULL, '{$row['ip']}', {$row['proxy']}, {$row['time']})");
		}
	}
	echo "Dane zostały przeniesione\n";
	sleep(1);
	echo "Tworzenie tabeli `users`\n";
	$db->query("CREATE TABLE `users` (
		`id` int(255) NOT NULL AUTO_INCREMENT,
		`cldbid` int(255) NOT NULL DEFAULT '0',
		`client_nickname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`cui` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`longest_connection` int(255) NOT NULL DEFAULT '0',
		`connections` int(255) NOT NULL DEFAULT '0',
		`time_activity` int(255) NOT NULL DEFAULT '0',
		`last_activity` int(255) NOT NULL DEFAULT '0',
		`regdate` int(25) NOT NULL DEFAULT '0',
		`gid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
		`staff` int(25) NOT NULL DEFAULT '0',
		PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
	echo "Tabela `users` została utworzona\n";
	sleep(1);
	echo "Przenoszenie danych z tabeli `users`\n";
	$query = $db2->query("SELECT * FROM `users`");
	if($query){
		while($row = $query->fetch()){
			$db->query("INSERT INTO `users` (`id`, `cldbid`, `client_nickname`, `cui`, `longest_connection`, `connections`, `time_activity`, `last_activity`, `regdate`, `gid`, `staff`) VALUES (NULL, {$row['cldbid']}, '{$row['client_nickname']}', '{$row['cui']}', {$row['longest_connection']}, {$row['connections']}, {$row['time_activity']}, {$row['last_activity']}, {$row['regdate']}, '{$row['gid']}', {$row['staff']})");
		}
	}
	echo "Dane zostały przeniesione\n";
	$db->rollBack();
?>