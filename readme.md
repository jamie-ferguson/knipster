```text
ABOUT
======
This application creates 6 endpoints which can be used to POST parameters in JSON formant and returns valid JSON based on whether the request was successful or not.
The endpoints are
add-user
update-user
delete-user
deposit
withdraw
report

PLATFORM
=========
During development the software was tested on a mac (macOS Sierra 10.12.2) running
php 7.1
apache 2.4.23
mysql 5.6.34
The application is based on Laravel 5.4.6


INSTALL
=======
CODE
# git clone https://github.com/jamie-ferguson/knipster.git knipster
# cd knipster
# composer update

DATABASE
The software expects a mysql DB called knipster on localhost
username root
password root
These credentials can be changed in config/database.php

1. The database has to be created manually
mysql> create database knipster

2. Run Laravel migrations to create the 2 tables required in the knipster DB
# php artisan migrate
If for some reason artisan doesn’t run correctly the tables can be created manually by running the following 4 statements in an sql query browser
create table `users` (`id` int unsigned not null auto_increment primary key, `first_name` varchar(32) not null, `last_name` varchar(32) not null, `country_code` varchar(2) not null, `gender` char(1) not null, `email` varchar(255) not null, `cash_value` decimal(6, 2) not null default '0', `bonus_value` decimal(6, 2) not null default '0', `bonus_parameter` int not null default '0', `no_deposits` int not null default '0', `no_withdrawals` int not null default '0', `created_at` timestamp default CURRENT_TIMESTAMP not null) default character set utf8 collate utf8_unicode_ci

alter table `users` add unique `users_email_unique`(`email`)

create table `transactions` (`id` int unsigned not null auto_increment primary key, `user_id` int unsigned not null, `type` enum('deposit', 'withdraw', 'bonus') not null, `value` decimal(6, 2) not null default '0', `created_at` timestamp default CURRENT_TIMESTAMP not null) default character set utf8 collate utf8_unicode_ci

alter table `transactions` add constraint `transactions_user_id_foreign` foreign key (`user_id`) references `users` (`id`)

TEST
====
The integration tests are stored at 
tests/Feature/UserTest.php

and can be run as follows
# vendor/bin/phpunit


EXAMPLES
=========
I tested all code using curl commands
NOTE: THESE SHOULD RETURN SUCCESS
Add some users, then deposit money, then withdraw money, then publish report, then update a user.
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha01","last_name":"Beta","gender":"M","country":"UK","email":"test01@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha02","last_name":"Beta","gender":"M","country":"UK","email":"test02@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha03","last_name":"Beta","gender":"M","country":"UK","email":"test03@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha04","last_name":"Beta","gender":"M","country":"UK","email":"test04@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha05","last_name":"Beta","gender":"M","country":"IE","email":"test05@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha06","last_name":"Beta","gender":"M","country":"IE","email":"test06@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha07","last_name":"Beta","gender":"M","country":"IE","email":"test07@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha08","last_name":"Beta","gender":"M","country":"FR","email":"test08@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha09","last_name":"Beta","gender":"M","country":"FR","email":"test09@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha10","last_name":"Beta","gender":"M","country":"FR","email":"test10@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha11","last_name":"Beta","gender":"M","country":"FR","email":"test11@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha12","last_name":"Beta","gender":"M","country":"FR","email":"test12@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha13","last_name":"Beta","gender":"M","country":"DE","email":"test13@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha14","last_name":"Beta","gender":"M","country":"DE","email":"test14@gmail.com"}' http://localhost:8888/knipster/public/add-user
curl -X POST -H 'Content-Type: application/json' -d '{"first_name":"Alpha15","last_name":"Beta","gender":"M","country":"DE","email":"test15@gmail.com"}' http://localhost:8888/knipster/public/add-user

curl -X POST -H 'Content-Type: application/json' -d '{"user_id":2,"amount":17.34}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":2,"amount":20.11}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":2,"amount":100.00}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":4,"amount":10.10}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":4,"amount":10.00}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":8,"amount":50}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":9,"amount":50}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":9,"amount":50}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":9,"amount":50}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":10,"amount":50}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":11,"amount":50}' http://localhost:8888/knipster/public/deposit
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":12,"amount":50}' http://localhost:8888/knipster/public/deposit

curl -X POST -H 'Content-Type: application/json' -d '{"user_id":2,"amount":15}' http://localhost:8888/knipster/public/withdraw
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":2,"amount":10}' http://localhost:8888/knipster/public/withdraw
curl -X POST -H 'Content-Type: application/json' -d '{"user_id":8,"amount":50}' http://localhost:8888/knipster/public/withdraw

After these calls are made the tables should look like
mysql> select * from users;
+----+------------+-----------+--------------+--------+------------------+------------+-------------+-----------------+-------------+----------------+---------------------+
| id | first_name | last_name | country_code | gender | email            | cash_value | bonus_value | bonus_parameter | no_deposits | no_withdrawals | created_at          |
+----+------------+-----------+--------------+--------+------------------+------------+-------------+-----------------+-------------+----------------+---------------------+
|  1 | Alpha01    | Beta      | UK           | M      | test01@gmail.com |       0.00 |        0.00 |              10 |           0 |              0 | 2017-02-05 16:11:14 |
|  2 | Alpha02    | Beta      | UK           | M      | test02@gmail.com |     137.45 |       20.00 |              20 |           3 |              0 | 2017-02-05 16:11:15 |
|  3 | Alpha03    | Beta      | UK           | M      | test03@gmail.com |       0.00 |        0.00 |               8 |           0 |              0 | 2017-02-05 16:11:15 |
|  4 | Alpha04    | Beta      | UK           | M      | test04@gmail.com |      20.10 |        0.00 |              12 |           2 |              0 | 2017-02-05 16:11:15 |
|  5 | Alpha05    | Beta      | IE           | M      | test05@gmail.com |       0.00 |        0.00 |               5 |           0 |              0 | 2017-02-05 16:11:15 |
|  6 | Alpha06    | Beta      | IE           | M      | test06@gmail.com |       0.00 |        0.00 |              15 |           0 |              0 | 2017-02-05 16:11:15 |
|  7 | Alpha07    | Beta      | IE           | M      | test07@gmail.com |       0.00 |        0.00 |               5 |           0 |              0 | 2017-02-05 16:11:15 |
|  8 | Alpha08    | Beta      | FR           | M      | test08@gmail.com |      50.00 |        0.00 |              11 |           1 |              0 | 2017-02-05 16:11:17 |
|  9 | Alpha09    | Beta      | FR           | M      | test09@gmail.com |     150.00 |        5.00 |              10 |           3 |              0 | 2017-02-05 16:11:30 |
| 10 | Alpha10    | Beta      | FR           | M      | test10@gmail.com |      50.00 |        0.00 |               6 |           1 |              0 | 2017-02-05 16:11:30 |
| 11 | Alpha11    | Beta      | FR           | M      | test11@gmail.com |      50.00 |        0.00 |              10 |           1 |              0 | 2017-02-05 16:11:30 |
| 12 | Alpha12    | Beta      | FR           | M      | test12@gmail.com |      50.00 |        0.00 |              18 |           1 |              0 | 2017-02-05 16:11:30 |
| 13 | Alpha13    | Beta      | DE           | M      | test13@gmail.com |       0.00 |        0.00 |               9 |           0 |              0 | 2017-02-05 16:11:30 |
| 14 | Alpha14    | Beta      | DE           | M      | test14@gmail.com |       0.00 |        0.00 |               5 |           0 |              0 | 2017-02-05 16:11:30 |
| 15 | Alpha15    | Beta      | DE           | M      | test15@gmail.com |       0.00 |        0.00 |               8 |           0 |              0 | 2017-02-05 16:11:31 |
+----+------------+-----------+--------------+--------+------------------+------------+-------------+-----------------+-------------+----------------+---------------------+

mysql> select * from transactions;
+----+---------+----------+--------+---------------------+
| id | user_id | type     | value  | created_at          |
+----+---------+----------+--------+---------------------+
|  1 |       2 | deposit  |  17.34 | 2017-02-05 16:11:47 |
|  2 |       2 | deposit  |  20.11 | 2017-02-05 16:11:47 |
|  3 |       2 | deposit  | 100.00 | 2017-02-05 16:11:47 |
|  4 |       2 | bonus    |  20.00 | 2017-02-05 16:11:47 |
|  5 |       4 | deposit  |  10.10 | 2017-02-05 16:11:47 |
|  6 |       4 | deposit  |  10.00 | 2017-02-05 16:11:48 |
|  7 |       8 | deposit  |  50.00 | 2017-02-05 16:11:48 |
|  8 |       9 | deposit  |  50.00 | 2017-02-05 16:11:48 |
|  9 |       9 | deposit  |  50.00 | 2017-02-05 16:11:48 |
| 10 |       9 | deposit  |  50.00 | 2017-02-05 16:11:48 |
| 11 |       9 | bonus    |   5.00 | 2017-02-05 16:11:48 |
| 12 |      10 | deposit  |  50.00 | 2017-02-05 16:11:48 |
| 13 |      11 | deposit  |  50.00 | 2017-02-05 16:11:48 |
| 14 |      12 | deposit  |  50.00 | 2017-02-05 16:11:54 |
| 15 |       2 | withdraw | -15.00 | 2017-02-05 16:13:04 |
| 16 |       2 | withdraw | -10.00 | 2017-02-05 16:13:05 |
| 17 |       8 | withdraw | -50.00 | 2017-02-05 16:13:06 |
+----+---------+----------+--------+---------------------+

And the report endpoint should effectively return
mysql> SELECT u.country_code AS 'Country', COUNT(DISTINCT(u.email)) AS 'Unique Customers', COUNT(CASE WHEN t.type = 'deposit' THEN u.id ELSE NULL END) AS 'No. of Deposits', SUM(CASE WHEN t.type = 'deposit' THEN t.value ELSE 0 END) AS 'Total Deposit Amount', COUNT(CASE WHEN t.type = 'withdraw' THEN u.id ELSE NULL END) AS 'No. of Withdrawals', SUM(CASE WHEN t.type = 'withdraw' THEN t.value ELSE 0 END) AS 'Total Withdraw Amount' FROM Users u JOIN transactions t ON u.id = t.user_id WHERE t.type = 'deposit' OR t.type = 'withdraw' GROUP BY u.country_code;
+---------+------------------+-----------------+----------------------+--------------------+-----------------------+
| Country | Unique Customers | No. of Deposits | Total Deposit Amount | No. of Withdrawals | Total Withdraw Amount |
+---------+------------------+-----------------+----------------------+--------------------+-----------------------+
| FR      |                5 |               7 |               350.00 |                  1 |                -50.00 |
| UK      |                2 |               5 |               157.55 |                  2 |                -25.00 |
+---------+------------------+-----------------+----------------------+--------------------+-----------------------+


# curl -X POST -H 'Content-Type: application/json' -d '{"from":"2017-01-01","to":"2017-02-05"}' http://localhost:8888/knipster/public/report
[{"Country":"FR","Unique Customers":5,"No. of Deposits":7,"Total Deposit Amount":"350.00","No. of Withdrawals":1,"Total Withdraw Amount":"-50.00"},
{"Country":"UK","Unique Customers":2,"No. of Deposits":5,"Total Deposit Amount":"157.55","No. of Withdrawals":2,"Total Withdraw Amount":"-25.00"}]

And an example of a successful ‘update’ user call
# curl -X POST -H 'Content-Type: application/json' -d '{"id":"4","first_name":"Alpha044","last_name":"Beta4","gender":"F","country":"IT","email":"test20@gmail.com"}' http://localhost:8888/knipster/public/update-user


NOTE: THESE SHOULD RETURN ERROR MESSAGES
# curl -X POST -H 'Content-Type: application/json' -d '{"user_id":2,"amount":200}' http://localhost:8888/knipster/public/withdraw
{"error":"Not enough cash funds."}

# curl -X POST -H 'Content-Type: application/json' -d '{"id":"4","first_name":"Alpha044","last_name":"Beta4","gender":"F","country":"IT","email":"test12@gmail.com"}' http://localhost:8888/knipster/public/update-user
{"error":"Email address already exists."}

# curl -X POST -H 'Content-Type: application/json' -d '{"id":"44","first_name":"Alpha044","last_name":"Beta4","gender":"F","country":"IT","email":"test20@gmail.com"}' http://localhost:8888/knipster/public/update-user
{"error":"User does not exist."}
```
