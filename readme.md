## Installation ##

- Install Docker with Docker Compose
- Run commands below:
  - ```docker compose build```
  - ```docker compose up -d```

- Rename .env.example to .env.

- Generate CA and cert for ssl with /keys/genkeys.sh or generate cert only /keys/genwebcert.sh for SSL  


The site available on https://localhost




## XDebug ##

#### You can use xdebug with phpstorm: ####

- Install xdebug helper plugin to your browser and enable it for debug
- Enable PHP Debug Connection Listener in your PHPStorm

#### Profiling: ####

You can use xdebug profiler with adding "profiler" to "xdebug.mode" line of docker/php/xdebug.ini.

The location of profiler's output is <THIS_PROJECT>/tmp dir.
