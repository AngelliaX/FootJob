# FootJob
[![](https://poggit.pmmp.io/shield.state/FootJob)](https://poggit.pmmp.io/p/FootJob)
[![](https://poggit.pmmp.io/shield.dl.total/FootJob)](https://poggit.pmmp.io/p/FootJob)
[![Discord](https://img.shields.io/badge/chat-on+discord-7289da.svg)](https://discord.gg/5CpFadd)
<a href="https://discord.gg/5CpFadd"><img src="https://discordapp.com/api/guilds/472786873492832256/embed.png" alt="Discord server"/></a>
 ### What is this plugin for
  - With this plugin,you can **create** a **invisible portal** that will **execute command** as **player** and **console** when someone **colliding it**
 ### How does this work
  - The portal is just a coordination,you can place any block there or leave it empty (air)
  - And when someone collide this coordination, they will trigger the portal to excute commands
 ### How to create portals
  - Use `/fj aa` to create portal
  - Use `/fj ra` to remove the portal (with all the settings)
  - How to add commands,and mores, go to [Commands](#commands)
  - There is also a video you can watch in the [Introduce](#introduce)
 ### Why is it named footjob
  - Because you need to walk into the portal to help the plugin work
  - And you walk on foot
<a align="center"><img src="https://raw.githubusercontent.com/TungstenVn/FootJob/master/icon2.png"></a>
## Permisson
  - Who has **footjob.permission** permission can use the commands only
## Commands
 ### Type ``/fj help`` to see lists of commands
 ### SubCommands:
  - ``/fj list`` to see lists of area
  
  **`(name)` under is stand for area name.**
  - `/fj aa (name)` (aka /fj addarea) to create a area by breaking 2 block,and area will have a name you named
  - `/fj acc (name) (text)` (/fj addconsolecommand) to add a command that'll be executed by console
    > use extractly this word `{name}` as player name when the command excuted
    
	> Ex: /fj acc randomAreaName give {name} apple 1
  - `/fj apc (name) (text)` (/fj addplayercommand) to add a command that'll be executed by the player walked in the portal
    > Ex: /fj apc randomAreaName hub
  - `/fj ra (name)` (/fj removearea) to delete an area
## Config.yml
  - Go to config.yml to see all the area,commands on its area, easy editting her
## Features
  - [x] Create a portal that execute command as console and player when someone walks in
  - [x] Simple sound effect
  - [x] Update checker
  - [ ] Particle
  - [x] 100% perfect
## Introduce
 - A video about the plugin:
   
   [![Youtube Introduce](https://img.youtube.com/vi/PN9MyWWC1Dg/0.jpg)](https://www.youtube.com/watch?v=PN9MyWWC1Dg)
