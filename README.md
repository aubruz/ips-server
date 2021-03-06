# IPS SERVER
This project is the server side of the IPS project located [here](https://github.com/aubruz/ips).
But technically one could create its own client that connects to the server.

The server was developed with [laravel](https://laravel.com/) 6.0.


## Concept
See the client side [here](https://github.com/aubruz/ips).

## How does the server works
The server runs with php > 7.2. It includes an admin part and a few API endpoints to communicate.
A database is needed to store the fingerprints and buildings info. This project uses MySQL but other DBMS can be used. 
The doc to make this change is [here](https://laravel.com/docs/6.x/database).

### Admin
With the admin you can create buildings and add floors to them. Then
 you can upload maps of the floors you created.
 
### API
The API communicates with the Android app to send buildings and floors info (names and maps url) and 
to receive the fingerprints taken.
The API is in charge of finding the localisation with a fingerprint given.

## Search Algorithm
A simple KNN algorithm is used to find the closest point in the database.

## Install
First clone the repository, then install the dependencies with [composer](https://getcomposer.org/):
`composer install`
Then install the node dependencies with [yarn](https://yarnpkg.com/): `yarn install`

To try the server localy you can launch a php server through `php serve`. It will spin up a local web server.



I'll add more information when I get the time to do it.
