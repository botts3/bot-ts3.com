<?php

	class WelcomeMessege extends Command {

		private static $welcome_messege_list = [];

		public function execute(): void
		{
			$listOfUser = [];
			foreach($this->bot->getClientList() as $cl) {
				if($cl['client_type'] == 0) {
					$listOfUser[] = $cl['clid'];
				}
			}
			$nowi = array_diff($listOfUser, self::$welcome_messege_list);
			if(!empty($nowi)){
				$serverinfo = $this->bot->getServerInfo();
				foreach($nowi as $n) {
					$wmtxt = $this->config['functions_WelcomeMessege']['txt'];
					$clientInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientInfo($n));
					$grupy =  explode(',', $clientInfo['client_servergroups']);
					if(in_array($this->config['functions_WelcomeMessege']['gid'], $grupy)){
						$wmtxt = $this->config['functions_WelcomeMessege']['txt_new'];
					}
					$data = $this->bot->przelicz_czas($serverinfo['virtualserver_uptime']);
					$txt_time = $this->bot->wyswietl_czas($data, 1, 1, 1, 0, 0);
					$search = [
						'%CLIENT_IP%', '%CLIENT_UNIQUE_ID%', '%CLIENT_DATABASE_ID%', '%CLIENT_ID%', '%CLIENT_CREATED%', '%CLIENT_COUNTRY%', '%CLIENT_VERSION%', '%CLIENT_PLATFORM%', '%CLIENT_NICKNAME%', '%CLIENT_TOTALCONNECTIONS%', '%CLIENT_LASTCONNECTED%', '%CLIENTONLINE%', '%MAXCLIENT%', '%SERVER_UPTIME%', '%HOUR%', '%DATE%'			
					];
					$replace = [
						$clientInfo['connection_client_ip'], $clientInfo['client_unique_identifier'], $clientInfo['client_database_id'], $n, date("H:i d.m.Y", $clientInfo['client_created']), $clientInfo['client_country'], $clientInfo['client_version'], $clientInfo['client_platform'], $clientInfo['client_nickname'], $clientInfo['client_totalconnections'], date("H:i d.m.Y",$clientInfo['client_lastconnected']), $serverinfo['virtualserver_clientsonline'] - $serverinfo['virtualserver_queryclientsonline'], $serverinfo['virtualserver_maxclients'], $txt_time, date('H:i'), date('d.m.Y')
					];
					$wmtxt = str_replace($search, $replace, $wmtxt);
					self::$tsAdmin->sendMessage(1, $n, $wmtxt);
				}
				self::$welcome_messege_list = $listOfUser;
			}
		}
	}

?>