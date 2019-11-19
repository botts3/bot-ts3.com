#!/bin/bash

	COL_GREEN="\x1b[32;01m"
	COL_RED="\x1b[31;02m"
	function text {
		echo -e "\x1b[$1 $2\e[0m"
	}

	function start {
		if ! screen -list | grep -q "botphp1"; then
			screen -AdmS botphp1 php bot.php -i 1
			text "32;01m" "Successfully launched bot 1!"
		else
			text "31;02m" "Bot 1 is already running!"
		fi
		if ! screen -list | grep -q "botphp2"; then
			screen -AdmS botphp2 php bot.php -i 2
			text "32;01m" "Bot 2 started successfully!"
		else
			text "31;02m" "Bot 2 is already running!"
		fi
	}

	function stop {
		if ! screen -list | grep -q "botphp1"; then
			text "31;02m" "Bot 1 was not running so it was not stopped"
		else
			text "32;01m" "Bot # 1 was successfully stopped!"
			screen -X -S botphp1 stuff "^C"
		fi
		if ! screen -list | grep -q "botphp2"; then
			text "31;02m" "Bot No. 2 was not running so it was not stopped"
		else
			text "32;01m" "Bot bot has been stopped successfully 2!"
			screen -X -S botphp2 stuff "^C"
		fi
	}

	function restart {
		if ! screen -list | grep -q "botphp1"; then
			text "31;02m" "Bot 1 was not running"
		else
			text "32;01m" "Bot bot has been stopped successfully1!"
			screen -X -S botphp1 stuff "^C"
		fi
		if ! screen -list | grep -q "botphp2"; then
			text "31;02m" "Bot No. 2 was not running"
		else
			text "32;01m" "Bot bot has been stopped successfully 2!"
			screen -X -S botphp2 stuff "^C"
		fi
		screen -AdmS botphp1 php bot.php -i 1
		text "32;01m" "Successfully launched bot no 1!"
		screen -AdmS botphp2 php bot.php -i 2
		text "32;01m" "Successfully launched bot no 2!"
	}

	function update {
		php install/upgrade.php
	}

	clear
	text "32;01m" "BOT-TS3.COM"
	text "32;01m" ""
	
	case "$1" in
		"start")
			start
		;;

		"stop")
			stop
		;;

		"restart")
			restart
		;;

		"update")
			update
		;;

		*)
			echo -e 'Use start | stop | restart'
		;; 
	esac

