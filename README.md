# Advanced newcomer test task

Developed an task management sample application

## Pre-Request

* Install Docker
* Install Docker Compose
* Docker installation installation details https://docs.docker.com/install/
* Install Postman


## Installation

* Extract the zip file anywhere in your server or PC. Go to the extracted source directory.
* For Linux OS execute bellow commands

```bash
sudo chown -R $USER:docker .
sudo chmod -R 0755 .
sudo chmod -R 0777 ./www/storage/*
```

* Run Docker container. Execute following command from project root directory where docker-compose.yml file contains

```bash
docker-compose up -d
```
wait for while being installed. First may it will take few more times based on internet speed.


## Usage

* To load users from external source https://gitlab.iterato.lt/snippets/3/raw use this end point http://localhost/api/loaduser . Just hit the url in the browser or in the postman with GET request
* For visual output http://localhost/
* To create new record use this endpoint with POST request http://localhost/api/task . Request sample data given bellow
```bash
{
 "parent_id":"6",
 "user_id":2,
 "title":"Task Task 1.2.2",
 "points":3,
 "is_done":"0",
 "email":"john.toe@email.com"
}
```
* To update existing record use this endpoint with PUT request http://localhost/api/task/{id} . Replace {id} as task id. Request sample data given bellow

```bash
{
 "parent_id":"1",
 "user_id":1,
 "title":"Task 1.2",
 "points":3,
 "is_done":"0",
 "email":"john.boe@email.com"
}
```
