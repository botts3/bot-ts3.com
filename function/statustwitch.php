<?php

	class StatusTwitch extends Command {

		public static $statusTwitch_time = 0;

		public function execute(): void
		{
			if(self::$statusTwitch_time <= time()){
				foreach($this->config['functions_StatusTwitch']['cid_name'] as $cid => $value){
					$jdc = json_decode($this->bot->file_get_contents_curl('https://api.twitch.tv/kraken/streams/'.$value['users'].'?client_id=56o6gfj3nakgeaaqpku3cugkf7lgzk'));
					if((!isset($jdc->stream)) || (isset($jdc->stream) && $jdc->stream == null)){
						$statusTwitch_name = self::$l->sprintf($value['channel_name'], '[Offline]');
						$jdc2 = json_decode($this->bot->file_get_contents_curl('https://api.twitch.tv/kraken/users/'.$value['users'].'?client_id=56o6gfj3nakgeaaqpku3cugkf7lgzk'));
						if(!isset($jdc2->error)){
							$channel_description = self::$l->sprintf(self::$l->offline_StatusTwitch, $value['users'], $jdc2->logo ?? '');
							$channelinfo = self::$tsAdmin->getElement('data', self::$tsAdmin->channelInfo($cid));
							if($channelinfo['channel_description'] != $channel_description){
								$channelEdit = self::$tsAdmin->channelEdit($cid, [ 'channel_description' => $channel_description, 'channel_name' => $statusTwitch_name ]);
								if(!empty($channelEdit['errors'][0]) && $channelEdit['errors'][0] != 'ErrorID: 771 | Message: channel name is already in use'){
									$this->bot->log(1, 'Kanał o ID:'.$cid.' nie istnieje Funkcja: statusTwitch()');
								}
							}
						}
					}else{
						$statusTwitch_name = self::$l->sprintf($value['channel_name'], '[Online]');
						$channel_description = self::$l->sprintf(self::$l->online_StatusTwitch, $jdc->stream->channel->url, $value['users'], $jdc->stream->game, $jdc->stream->channel->status, $jdc->stream->viewers, $jdc->stream->channel->logo);
						$channelEdit = self::$tsAdmin->channelEdit($cid, [ 'channel_description' => $channel_description, 'channel_name' => $statusTwitch_name ]);
						if(!empty($channelEdit['errors'][0]) && $channelEdit['errors'][0] != 'ErrorID: 771 | Message: channel name is already in use'){
							$this->bot->log(1, 'Kanał o ID:'.$cid.' nie istnieje Funkcja: statusTwitch()');
						}
					}
				}
				self::$statusTwitch_time = time()+60;
			}
		}
	}

?>