
## about runing the project
to run this project you need to have docker in you computer,
Otherwise you need php8, composer, mysql, to be installed on your computer,
And you can run the project like any other laravel projects

## Run the project using docker
- Open the terminal in the project path and run this command `docker-compose build --no-cache --force-rm`.
- When the composer finish setup the env, run this command `docker-compose up -d`.
- The composer should create 3 containers for you, apache server, Mysql and phpmyadmin and all the containers should be running.
- Open the phpmyadmin using this url=`http://localhost:9001/` 
- Use these credentials to enter to the phpmyadmin `Server`:`mysql_db`, `Username`:`root`, `Password`:`root`
- Make sure the DB `laravel_posts` exist 
- Open the project folder -> go to .env.example file and duplicate it, then rename the duplicated file as .env
- Open the terminal in the project path, and write this command to enter the server `docker exec -it laravel-apache /bin/bash`
- then Run this command to update the composer `composer update`
- after the composer update finish, run this command to generate the tables in the database `php artisan migrate`
- any time, you can run this command `php artisan test` to run the unit test 
