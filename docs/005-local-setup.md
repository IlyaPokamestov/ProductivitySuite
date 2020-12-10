## Local Installation

*NOTE: Tested on macOS only!*

This project is utilizing Docker containers.
In the root of the project, you can find ```docker-compose.yaml``` file responsible for the spin-up local environment.

To do that, you need to execute the next command in your terminal:
```
docker-compose up -d
```

This project is using Nginx proxy to allow the managing of multiple projects on the same 80 port.
It will require to update /etc/hosts with next values:
```
127.0.0.1 productivity.suite.local
127.0.0.1 database
```

The first line is required to open API with the domain name "productivity.suite.local".
The second line is to be able to execute DB related commands from the host machine.
