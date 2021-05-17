1. The script will only run on stashes that starts with `D` and followed by a number. So rename your stashes with `D1`, `D2`, `D3`, and so on
2. ```cp .env .env.local```
3. update `.env.local`, get `POESESSID` from the cookie after logging in on a browser
4. ```composer install```
5. ```php bin/console app:poe-stash-dev```