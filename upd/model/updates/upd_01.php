<?php

class upd_01 extends upd\BaseUpdate
{
    public function execute()
    {
        $aQueries = [
            "CREATE TABLE USERS (
    id SERIAL PRIMARY KEY,
    created timestamp, 
    updated timestamp null , 
    fullname varchar (255), 
    email varchar(255), 
    password varchar(255), 
    address varchar(255),
    telephone varchar(255),
    login varchar(255),
    worker_status int,
    role_id int);",

            "CREATE TABLE CLIENT_REQUESTS (
    id SERIAL PRIMARY KEY, 
    open_date timestamp, 
    close_date timestamp null, 
    description TEXT, 
    user_id int, 
    worker_id int, 
    operator_id int,
    request_type_id int,
    status_id int);",


            "    CREATE TABLE REQUEST_TYPE (
    id int PRIMARY KEY, 
    name varchar(255)
    );",

            "    INSERT INTO request_type (id, name) VALUES
    (1, 'Вывезти мусор'),
    (2, 'Установить экобокс'),
    (3, 'Демонтировать экобокс');",

            "    CREATE TABLE USER_ROLE (
    id int PRIMARY KEY,
    name varchar(255)
    );",

            "    INSERT INTO USER_ROLE (id, name) VALUES
    (1, 'Admin'),
    (2, 'Worker'),
    (3, 'Client');",


            "    CREATE TABLE STATUS_TYPE (
    id int PRIMARY KEY,
    name varchar(255),
    description TEXT
    );",

            "    INSERT INTO STATUS_TYPE (id, name, description) VALUES
    (1, 'New', 'New Request from Client'),
    (2, 'In Progress by Admin', 'The administrator has determined the team that will carry out the application'),
    (3, 'In Progress by Worker', 'The worker accept request'),
    (4, 'Сanceled by Worker', 'The worker refuses the application'),
    (5, 'Done by Worker', 'The worker submitted their job'),
    (6, 'Сanceled by Client', 'The client refuses the application'),
    (7, 'Done', 'The client accept request'),
    (8, 'Closed', 'The admin accept request');"
        ];
        foreach ($aQueries as $sQuery) {
            $this->oDb->add($sQuery)->execute([]);
        }
    }
}