<?php

/* 
 * @author  Seungchul Lee, Jiwwong Yoon
 * @Date    July 23, 2014
 */

require '../../libs/Router.php';
require '../../libs/Controller.php';
require '../../libs/View.php';
require '../../libs/Model.php';

//Library
require '../../libs/Database.php';
require '../../libs/Session.php';

require '../constant.php';
require '../database.php';

$db = new Database();
$query = 
"CREATE TABLE users
(
	id int(11) NOT NULL AUTO_INCREMENT,
	login varchar(25) NOT NULL,
	email varchar(32) NOT NULL,
	password varchar(32) NOT NULL,
	reset varchar(32) default NULL,
        session_id varchar(40) DEFAULT '0' NOT NULL,
        Profile_pic varchar(100) DEFAULT NULL,
        
	PRIMARY KEY (id)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'User table has been successfully created.<br />';
}
else 
{
    echo 'Creating User table failed or it\'s been already made.<br />';
}


$query = 
"CREATE TABLE status
(
	Id int(32) NOT NULL AUTO_INCREMENT,
	UId int(11) NOT NULL,
        Privacy int(1) NOT NULL,
	Status varchar(500) DEFAULT NULL,
        Date timestamp DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY (Id)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'Status table has been successfully created.<br />';
}
else 
{
    echo 'Creating Status table failed or it\'s been already made.<br />'; 
}


$query = 
"CREATE TABLE wall
(
	Id int(32) NOT NULL AUTO_INCREMENT,
	WhereId int(25) DEFAULT 0,
	Type varchar(10) NOT NULL,
	ContentId int(32) DEFAULT 0,
        PId int(32) DEFAULT 0,
        
	PRIMARY KEY (Id)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'Wall table has been successfully created.<br />';
}
else 
{
    echo 'Creating Wall table failed or it\'s been already made.<br />'; 
}

$query = 
"CREATE TABLE comment
(
	Id int(32) NOT NULL AUTO_INCREMENT,
	UId int(11) NOT NULL,
	Comment varchar(500) DEFAULT NULL,
        Date timestamp DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY (Id)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'Comment table has been successfully created.<br />';
}
else 
{
    echo 'Creating Comment table failed or it\'s been already made.<br />'; 
}

$query = 
"CREATE TABLE image
(
	Id int(32) NOT NULL AUTO_INCREMENT,
	UId int(11) NOT NULL,
        Privacy int(1) NOT NULL,
	URL varchar(1500) DEFAULT NULL,
        Date timestamp DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY (Id)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'Image table has been successfully created<br />';
}
else 
{
    echo 'Creating Status table failed or it\'s been already made.<br />'; 
}
?>