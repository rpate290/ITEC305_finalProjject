# ITEC305_finalProjject

Clone this repo to your local repo using this command 
```bash
git clone https://github.com/rpate290/ITEC305_finalProjject.git
```

before running the sql queries, you first need your database set up

We will use the same db user that we used in class for the login demo "db_user"

to make the database to access as the user you must first open the terminal
Connect to MySQL login with your system username/password or vm username/password if needed
```bash
sudo mysql
```

Show exisiting databases to check if its in there
```bash
show databases;
```

Create the new database
```bash
create database finalProject;
```

grant permission for the db_user to use the db in pycharm
```bash
GRANT ALL PRIVILEGES ON finalProject.* TO 'db_user'@'localhost';
```
Make sure privileges go thru
```bash
show grants for 'db_user'@'localhost';
```
# You should see this
 Grants for db_user@localhost                                      
 GRANT USAGE ON *.* TO `db_user`@`localhost`                       
 
 GRANT ALL PRIVILEGES ON `finalproject`.* TO `db_user`@`localhost` 




