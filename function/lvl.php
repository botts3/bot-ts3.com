<?php

	class Lvl extends Command {

		public static $lvl_time = 0;
		
		public function execute(): void
		{
			$lvl_clientlist = [];
			foreach($this->bot->getClientList() as $cl){
				if(!in_array($cl['clid'], $lvl_clientlist)){
					if($cl['client_idle_time'] <= 1000){
						$expup = 0.024;
					}else{
						$exp = 0.047;
						$cit = round(pow($cl['client_idle_time']/1000, 1/1.89), 10);
						$expup = $exp/$cit;
					}
					try {
						$prepare = Bot::$db->prepare("UPDATE `users` SET `exp` = exp+:exp WHERE `cldbid` = :cldbid");
						$prepare->bindValue(':exp', $expup, PDO::PARAM_STR);
						$prepare->bindValue(':cldbid', $cl['client_database_id'], PDO::PARAM_INT);
						$prepare->execute();
						$prepare = Bot::$db->prepare("SELECT COUNT(id) AS `count`, `exp`, `lvl` FROM `users` WHERE `cldbid` = :cldbid");
						$prepare->bindValue(':cldbid', $cl['client_database_id'], PDO::PARAM_INT);
						$prepare->execute();
						while($row = $prepare->fetch()){
							$count = $row['count'];
							$lvl = $row['lvl'];
							$exp = $row['exp'];
						}
						if($count != 0){
							$nextLvl = $lvl+1;
							if($this->config['functions_Lvl']['lvl'][$nextLvl]['exp'] <= $exp){
								if($cl['client_type'] == 0) {
									$prepare = Bot::$db->prepare("UPDATE `users` SET `lvl` = :lvl WHERE `cldbid` = :cldbid");
									$prepare->bindValue(':lvl', $nextLvl, PDO::PARAM_INT);
									$prepare->bindValue(':cldbid', $cl['client_database_id'], PDO::PARAM_INT);
									$prepare->execute();
									self::$tsAdmin->sendMessage(1, $cl['clid'], self::$l->sprintf(self::$l->success_update_Lvl, $nextLvl));
									if($this->config['functions_Lvl']['group'] == true){
										self::$tsAdmin->serverGroupDeleteClient($this->config['functions_Lvl']['lvl'][$lvl]['gid'], $cl['client_database_id']);
										if(empty($this->config['functions_Lvl']['required_group']) || array_intersect(explode(',', $cl['client_servergroups']), $this->config['functions_Lvl']['required_group'])){
											$serverGroupAddClient = self::$tsAdmin->serverGroupAddClient($this->config['functions_Lvl']['lvl'][$nextLvl]['gid'], $cl['client_database_id']);
											if(!empty($serverGroupAddClient['errors'][0])){
												$this->bot->log(1, 'Grupa o ID:'.$this->config['functions_Lvl']['lvl'][$nextLvl]['gid'].' nie istnieje Funkcja: Lvl()');
											}
										}
									}
								}
							}
						}
					} catch (PDOException $e) {
						$this->bot->log(1, $e->getMessage());
					}
					$lvl_clientlist[] = $cl['clid'];
				}
			}
			if($this->config['functions_Lvl']['top_list'] && self::$lvl_time <= time()){
				if(!empty($this->config['functions_Lvl']['cldbid'])){
					$cldbid = implode(",", $this->config['functions_Lvl']['cldbid']);
				}
				$top = NULL;
				$s = 0;
				try {
					$query2 = self::$db->query("SELECT `client_nickname`, `cui`, `cldbid`, `lvl`, `exp`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid}) ORDER BY `exp` DESC");
					while($row2 = $query2->fetch()){
						if(!array_intersect(explode(',', $row2['gid']), $this->config['functions_Lvl']['gid'])){
							$s++;
							$lvl2 = $row2['lvl'];
							$nextlvl2 = $lvl2+1;
							$expnext = $this->config['functions_Lvl']['lvl'][$nextlvl2]['exp']-$this->config['functions_Lvl']['lvl'][$row2['lvl']]['exp'];
							$exp = round($row2['exp']-$this->config['functions_Lvl']['lvl'][$row2['lvl']]['exp'], 2);
							$nick = $this->bot->getUrlName($row2['cldbid'], $row2['cui'], $row2['client_nickname']);
							$top .= self::$l->sprintf(self::$l->row_Lvl, $s, $nick, $row2['lvl'], '('.$exp.'/'.$expnext.')');
						}
						if($s >= $this->config['functions_Lvl']['limit']){
							break;
						}
					}
					$channelEdit= self::$tsAdmin->channelEdit($this->config['functions_Lvl']['cid'], ['channel_description' => self::$l->sprintf(self::$l->list_Lvl, $top)]);
					if(!empty($channelEdit['errors'][0])){
						$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_Lvl']['cid'].' nie istnieje Funkcja: Lvl()');
					}
					self::$lvl_time = time()+60;
				} catch (PDOException $e) {
					$this->bot->log(1, $e->getMessage());
				}
			}

		}
	}

?>