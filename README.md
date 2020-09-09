Multi purpose web app that can be used for tracking user records, saving report files, displaying user data inside a table, etc. It can be modified and more functionalities can be added.


Usage

Before running this project create the database with the posts table and upload to your host:

CREATE TABLE employees (
    id int NOT NULL,
    first_name varchar(255),
    last_name varchar(255),
    username varchar(255),
    password varchar(255),
    monthly_ranking int(11),
    daily_ranking int(11),
    summary text,
    email varchar(255),
    daily_sales int(11),
    monthly_sales int(11),
    items_in_store int(11),
    new_report_sales_number int(11),
    PRIMARY KEY (id)
);
