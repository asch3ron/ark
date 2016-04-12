# ARK - server management [WIP]

Todo

## How to install

Run
```
composer install
```

Create the database
```
mysql -u root -e "create database ark;" -proot
```

Copy & Edit your .env:
```
cp .env.example .env
```

```
php artisan ark:install
```

Cron configurations:
```
php artisan ark:cron
```

Recap of all commands:
```
composer install
create database ark;
mysql -u root -e "create database ark;" -proot
cp .env.example .env
php artisan ark:install
php artisan ark:cron
```

# Todo

* Add how to install (this site + dedicated server)
* Finishing first configuration
* Manage Survival of the Fittest Server. https://survivetheark.com/index.php?/forums/topic/45162-host-your-own-ark-survival-of-the-fittest-server/

FFA Example:
```
Launch Commandline:

ShooterGame/Binaries/Win64/ShooterGameServer.exe TheIsland?SessionName=YourFFAServerName?MaxPlayers=85?listen?MaxTribeSizeAllowed=1?RingStartTime=6300.0?EvoEventInterval=0.3?StartTimeOfDay=540?StructureResistanceMult=5.0?KillXPMult=1.0 -server -UseBattlEye -culture=en -log -KickDeadTribes -EnableDeathTeamSpectator -nobosses -giveengrams -NoSuperCrates -Crates1P -UseSmallRing -PauseTimeOfDay -DisableDeathSpectator

Game.ini:
http://pastebin.com/VpK5L3H9

GameUserSettings.ini:
http://pastebin.com/ShrJurTs
```
* Get players informations
* Get tribes informations
* Manage multiple servers
