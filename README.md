# BOT-TS3.COM

This is a open-source TeamSpeak3 bot.  

- **Got questions?** Check out our [Wiki](bot-ts3.com)
- **Something's broken or it's complicated?** [Open an issue](https://github.com/botts3/bot-ts3.com/issues)
  - Please use and fill out one of the templates we provide unless they are not applicable or you have a good reason not to.  
    This helps us getting through the technical stuff faster
  - Please keep issues in english, this makes it easier for everyone to participate and keeps issues relevant to link to.
- **Want to support this Project?**
  - You can discuss and suggest features. However the [backlog](https://github.com/botts3/bot-ts3.com) is large and feature requests will probably take time
  - You can contribute code. This is always appreciated, please open an issue or contact a maintainer to discuss *before* you start.

## Features
* Checking usernames for profanity and defined words. Rule can be set
* Anti recording, thanks to this plugin we will block recording on designated channels or the entire server
* Banning after giving the appropriate groups (Possibility to set time, group id, ban reason)
* Protection of server groups, protect groups from unwanted people
* Automatic transfer to AFK channel when status is turned on. When the user stops being inactive, the application will automatically move him to the previous channel
* Move users from one channel to another (Requirements: specify which channel to transfer, which group to own, and to which channel to transfer)
* Automatic channel checking (Updating the date when the owner / helper is on the channel, checking the correctness of the channel names, creating free channels, checking if any of the channels should not be deleted / informed about the old date.)
* Detecting whether the user is currently using the program to mask the IP address with the option of informing the administration
* Automatic registration when the user meets the requirements
* Online administration on the channel with basic information
* Download information about what is being played from SinusBot, connect a thumbnail and create a link to YouTube

To see what's planned and in progress take a look into our [Roadmap](https://github.com/botts3/bot-ts3.com/projects/2).

## Bot Commands
The bot is fully operable via chat.  
To get started write `!help` to the bot.  

## Install

### Download
Download either one of the latest builds

#### Linux
Install PHP 7.2
PHP Modules needed:
*curl
*GD
*mysql
*mbstring
*bz2
*xml

##### Start
Simply start via command
start.sh start
