<?php

require_once "src/bootstrap.php";

use PhpApi\Db\Database;

$sql = <<<EOS

DROP TABLE IF EXISTS  comment;
DROP TABLE IF EXISTS  mentor;
DROP TABLE IF EXISTS  intern;
DROP TABLE IF EXISTS  groupQ;
CREATE TABLE groupQ(
    id INT NOT NULL AUTO_INCREMENT,
    group_name VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);


insert into groupQ (group_name) values ('pboneham0');
insert into groupQ (group_name) values ('ahellicar1');
insert into groupQ (group_name) values ('kvelten2');
insert into groupQ (group_name) values ('pleagas3');
insert into groupQ (group_name) values ('dkitcher4');
insert into groupQ (group_name) values ('lguppey5');
insert into groupQ (group_name) values ('mforgan6');
insert into groupQ (group_name) values ('vpidgley7');
insert into groupQ (group_name) values ('nkroon8');
insert into groupQ (group_name) values ('lkiehne9');





CREATE TABLE mentor(
    id INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    years_of_experience INT(11) NOT NULL,
    group_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (group_id) REFERENCES groupQ(id)
);

insert into mentor (first_name, last_name, years_of_experience, group_id) values ('Nigel', 'Kik', 1, 1);
insert into mentor (first_name, last_name, years_of_experience, group_id) values ('Ellary', 'Wilshaw', 2, 2);
insert into mentor (first_name, last_name, years_of_experience, group_id) values ('Celestina', 'Fritzer', 3, 3);
insert into mentor (first_name, last_name, years_of_experience, group_id) values ('Mohandis', 'Clell', 4, 4);
insert into mentor (first_name, last_name, years_of_experience, group_id) values ('Ruby', 'Whyley', 5, 5);
insert into mentor (first_name, last_name, years_of_experience, group_id) values ('Sindee', 'Zambonini', 6, 6);
insert into mentor (first_name, last_name, years_of_experience, group_id) values ('Cissy', 'Eplate', 7, 7);
insert into mentor (first_name, last_name, years_of_experience, group_id) values ('Ximenes', 'Hards', 8, 8);
insert into mentor (first_name, last_name, years_of_experience, group_id) values ('Nathaniel', 'Rosander', 9, 9);
insert into mentor (first_name, last_name, years_of_experience, group_id) values ('Gardner', 'Sapauton', 10, 10);



CREATE TABLE intern(
    id INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    group_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (group_id) REFERENCES groupQ(id)
);

insert into intern (first_name, last_name, group_id) values ('Marina', 'Lazovic', 1);
insert into intern (first_name, last_name, group_id) values ('Melodie', 'Cumo', 2);
insert into intern (first_name, last_name, group_id) values ('Charline', 'Finney', 3);
insert into intern (first_name, last_name, group_id) values ('Suki', 'Sara', 4);
insert into intern (first_name, last_name, group_id) values ('Heywood', 'Murrey', 5);
insert into intern (first_name, last_name, group_id) values ('Markos', 'Gerrelt', 6);
insert into intern (first_name, last_name, group_id) values ('Zelig', 'Trase', 7);
insert into intern (first_name, last_name, group_id) values ('Elie', 'Akehurst', 8);
insert into intern (first_name, last_name, group_id) values ('Nicola', 'Brolan', 9);
insert into intern (first_name, last_name, group_id) values ('Noam', 'Adamiec', 10);



CREATE TABLE comment(
    id INT NOT NULL AUTO_INCREMENT,
    text TEXT NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    intern_id int(11) NOT NULL,
    mentor_id int(11) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (intern_id) REFERENCES intern(id),
    FOREIGN KEY (mentor_id) REFERENCES mentor(id)
);
EOS;


try{
    $result=(new Database())->getConnection()->exec($sql);
    echo "Seeding done".PHP_EOL;
} catch (PDOException $e) {
    exit($e->getMessage().PHP_EOL);
}