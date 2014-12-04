<?php

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
	password varchar(50) NOT NULL,
	firstname varchar(32) NOT NULL,
	lastname varchar(32) NOT NULL,
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
	password varchar(50) NOT NULL,
	lastname varchar(32) DEFAULT NULL,
        firstname varchar(32) DEFAULT NULL,
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
"CREATE TABLE Job
(
	jobID int(11) NOT NULL AUTO_INCREMENT,
        recruiterID int(11) NOT NULL,
	postedDate timestamp DEFAULT CURRENT_TIMESTAMP,
	title varchar(32) NOT NULL,
	companyName varchar(50) NOT NULL,
	type varchar(32) NOT NULL,
	area varchar(32) NOT NULL,
	level varchar(32) NOT NULL,
	description varchar(10000) NOT NULL,
	location varchar(32) NOT NULL,
	requredSkill varchar(100) NOT NULL,
	salary varchar(32) DEFAULT NULL,
	seekerVisaType varchar(32) DEFAULT NULL,

	PRIMARY KEY (jobID)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'Job table has been successfully created.<br />';
}
else 
{
    echo 'Creating Job table failed or it\'s been already made.<br />'; 
}


$query =
"CREATE TABLE Company
(
        companyId int(11) NOT NULL AUTO_INCREMENT,
	name varchar(50) NOT NULL,
	numberOfEmployees int(11) NOT NULL,
	description varchar(10000) NOT NULL,
	url varchar(500) DEFAULT NULL,

	PRIMARY KEY (companyId)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'Company table has been successfully created.<br />';
}
else 
{
    echo 'Creating Company table failed or it\'s been already made.<br />'; 
}

$query =
"CREATE TABLE RelationCompanyRecruiter
(
	id int(11) NOT NULL AUTO_INCREMENT,
	recruiterId int(11) NOT NULL,
	companyId int(11) NOT NULL,

	PRIMARY KEY (id)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'RelationCompanyRecruiter table has been successfully created.<br />';
}
else 
{
    echo 'Creating RelationCompanyRecruiter table failed or it\'s been already made.<br />'; 
}

$query =
"CREATE TABLE RelationJobStudent
(
	id int(11) NOT NULL AUTO_INCREMENT,
	studentId int(11) NOT NULL,
	jobId int(11) NOT NULL,
        postedDate timestamp DEFAULT CURRENT_TIMESTAMP,
        status int(3) DEFAULT 1,

	PRIMARY KEY (id)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'RelationJobStudent table has been successfully created.<br />';
}
else 
{
    echo 'Creating RelationJobStudent table failed or it\'s been already made.<br />'; 
}

$query =
"CREATE TABLE RelationLikeCompany
(
	id int(11) NOT NULL AUTO_INCREMENT,
	studentId int(11) NOT NULL,
	companyId int(11) NOT NULL,

	PRIMARY KEY (id)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'RelationLikeCompany table has been successfully created.<br />';
}
else 
{
    echo 'Creating RelationLikeCompany table failed or it\'s been already made.<br />'; 
}

$query =
"CREATE TABLE Preference
(
	minSalary int(50) DEFAULT 0,
	primarySkill varchar(50) DEFAULT NULL,
	area varchar(50) DEFAULT NULL,
	level varchar(50) DEFAULT NULL,
	position varchar(50) DEFAULT NULL,
	visa varchar(10) DEFAULT NULL,
	uID int(50),

	FOREIGN KEY (uID) REFERENCES Student(userID)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
{
    echo 'Preference table has been successfully created.<br />';
}
else 
{
    echo 'Creating Preference table failed or it\'s been already made.<br />'; 
}

?>