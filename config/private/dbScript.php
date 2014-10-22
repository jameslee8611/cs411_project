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
"CREATE TABLE Student
(
	userID int(11) NOT NULL AUTO_INCREMENT,
	password varchar(25) NOT NULL,
	profilePicture varchar(32) DEFAULT NULL,
	name varchar(32) NOT NULL,
	email varchar(32) NOT NULL,
        personalLink varchar(50) DEFAULT NULL,
        phoneNumber varchar(32) NOT NULL,
        address varchar(32) DEFAULT NULL,
        visaStatus varchar(11) DEFAULT NULL,
        school varchar(32) DEFAULT NULL,
        resume varchar(32) NOT NULL,
        
	PRIMARY KEY (userID)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'Student table has been successfully created.<br />';
}
else 
{
    echo 'Creating Student table failed or it\'s been already made.<br />';
}


$query = 
"CREATE TABLE Recruiter
(
	userID int(11) NOT NULL AUTO_INCREMENT,
	password varchar(25) NOT NULL,
	profilePicture varchar(32) DEFAULT NULL,
	name varchar(32) NOT NULL,
	email varchar(32) NOT NULL,
        personalLink varchar(50) DEFAULT NULL,

	PRIMARY KEY (userID)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'Recruiter table has been successfully created.<br />';
}
else 
{
    echo 'Creating Recruiter table failed or it\'s been already made.<br />'; 
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

?>