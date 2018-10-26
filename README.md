# IPS SERVER
This project is the server side of the IPS project located [here](https://github.com/aubruz/ips).

The server was developed with laravel 5.3 initialy and needs to be updated to work with laravel 5.7

## How does it work
The server side has an admin and a little API
### Admin
With the admin you can create buildings and add floors to them. And then
 you can upload maps of the floors you created.
 
### API
The API communicates with the Android app to send buildings and floors info and 
to receive the fingerprints that need to be stored.
The API is in charge of finding the localisation thanks to the fingerprints database
with a fingerprint given.


