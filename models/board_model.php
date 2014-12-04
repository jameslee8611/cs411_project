<?php

/**
 * Description of jobboard_model
 *
 * @author jameslee8611
 */
class board_model extends Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_applied_job()
    {
        $studentId = Session::get('userId');
        
        $query = "SELECT *
                  FROM Job, (
                    SELECT jobId, status, process, postedDate
                    FROM RelationJobStudent 
                    WHERE studentId = $studentId
                  ) QStduent 
                  WHERE QStduent.jobId = Job.jobID";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $jobs = $statement->fetchAll();
        $result = Array();
        foreach ($jobs as $job) {
            array_push($result, json_decode('{"title": "'.$job['title'].'",
                                              "jobId": "'.$job['jobId'].'",
                                              "date": "'.$job['postedDate'].'",
                                              "status": "'.$this->statusCode_to_status($job['status']).'"}', true));
        }
        return $result;
    }
    
    public function getJob()
    {
        $username = Session::get('username');

        $statement = $this->db->prepare("
            SELECT userID FROM Student WHERE email = '$username'
        ");
        $success = $statement->execute();
        $uID = $statement->fetch()['userID'];
        
        if (!$success) {
            echo 'Error occurred while getting userID!<br />';
            echo '- in getjob() at board_model from board_controller<br />';
            exit;
        }

        $statement = $this->db->prepare("
            SELECT * FROM PREFERENCE WHERE uID = '$uID'
        ");
        $success = $statement->execute();
        $preference = $statement->fetch();
        
        if (!$success) {
            echo 'Error occurred while getting userID from PREFERENCE!<br />';
            echo '- in getjob() at board_model from board_controller<br />';
            exit;
        }

        $category = array('salary', 'requiredSkill', 'area', 'level', 'type','seekerVisaType');
        $query = $this->createFilterQuery($preference, $category);
        $statement = $this->db->prepare($query);
        $success = $statement->execute();
        
        $result = array();
        
        if ($success) {
            $query = $statement->fetchAll();

            foreach ($query as $row) 
            {
                array_push($result, $this->formatter($row['jobID'], $row['title'], $row['companyName'], $row['description'], $row['location'], $row['postedDate']));
            }
        } 
        else 
        {
            $query = "SELECT jobID, title, companyName, location, description, postedDate FROM Job";
            $statement = $this->db->prepare($query);
            $statement->execute();
            $jobs = $statement->fetchAll();

            foreach ($jobs as $row) 
            {
                array_push($result, $this->formatter($row['jobID'], $row['title'], $row['companyName'], $row['description'], $row['location'], $row['postedDate']));
            }

            /*echo 'Error occurred while getting createFilterQuery!<br />';
            echo '- in getjob() at board_model from board_controller<br /><br />';
            echo 'Possible error detail: <br />';
            echo '1. query statement<br />';
            echo $this->createFilterQuery($preference, $category) . '<br />';
            exit;*/
        }

        return $result;
    }
    
    public function getJobRecruiter()
    {
        $recruiterId = Session::get('userId');
        
        $statement = $this->db->prepare("SELECT * FROM Job WHERE recruiterID = $recruiterId");
        $success = $statement->execute();
        
        if (!$success) {
            echo 'Error occurred while getting job query for recruiter!<br />';
            echo '- in getJobRecruiter() at board_model from board_controller<br /><br />';
            echo 'Possible error detail: <br />';
            echo '1. query statement<br />';
            echo 'SELECT * FROM Job WHERE jobID = $recruiterId <br />';
            exit;
        }
        
        $query = $statement->fetchAll();
        $result = Array();
        foreach ($query as $row) 
        {
            array_push($result, $this->formatter($row['jobID'], $row['title'], $row['companyName'], $row['description'], $row['location'], $row['postedDate']));
        }
        
        return $result;
    }
    
    public function getUserInfo()
    {
        $status = (Session::get('isStudent')) ? 'Student' : 'Recruiter';
        $email = Session::get('userId');
        $statement = $this->db->prepare("
                        SELECT *
                        FROM $status
                        WHERE userId = '$email';
                    ");
        $success = $statement->execute();
        $user = $statement->fetchAll();
        
        if (!$success || empty($user)) {
            echo "Error Occurs while query user data\r\n"
                ."\t getUserInfo() in Board Model\r\n"
                ."\t\t recruiterBoard() or jobBoard() in Board Controller";
            exit;
        }
        
        $result = '{}';
        if (!Session::get('isStudent')) {
            $result = '{"firstname": "'. $user[0]['firstname'] .'", "lastname": "'. $user[0]['lastname'] .'", "email": "'. $user[0]['email'] .'", "personalLink": "'. $user[0]['personalLink'] .'"}';
        }
        else {
            
        }
        
        return json_decode($result, true);
    }
    
    public function findJobById()
    {
        $jobID = $_POST['jobID'];
        $query = "SELECT * FROM JOB WHERE jobID = $jobID";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $job = $statement->fetch();

        return $job;
    }
    
    public function getJobById($jobId)
    {
        $query = "SELECT *
                  FROM Student, (
                    SELECT studentId, status, process
                    FROM RelationJobStudent 
                    WHERE jobID = $jobId
                  ) QStduent 
                  WHERE QStduent.studentId = Student.userID AND QStduent.status <> '222222'";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $students = $statement->fetchAll();
        $result = Array();
        foreach ($students as $student) {
            array_push($result, json_decode('{"userId": "'.$student['userID'].'",
                                              "firstname": "'.$student['firstname'].'",
                                              "lastname": "'.$student['lastname'].'",
                                              "email": "'.$student['email'].'",
                                              "personalLink": "'.$student['personalLink'].'",
                                              "phoneNumber": "'.$student['phoneNumber'].'",
                                              "school": "'.$student['school'].'",
                                              "resume": "'.$student['resume'].'",
                                              "process": '.$this->solve_process_code($student['process']).',
                                              "status": "'.$student['status'].'"}', true));
        }
        return $result;
    }
    
    public function getHistoryJobById($jobId)
    {
        $query = "SELECT *
                  FROM Student, (
                    SELECT studentId, status, process
                    FROM RelationJobStudent 
                    WHERE jobID = $jobId
                  ) QStduent 
                  WHERE QStduent.studentId = Student.userID AND QStduent.status = '222222'";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $students = $statement->fetchAll();
        $result = Array();
        foreach ($students as $student) {
            array_push($result, json_decode('{"userId": "'.$student['userID'].'",
                                              "firstname": "'.$student['firstname'].'",
                                              "lastname": "'.$student['lastname'].'",
                                              "email": "'.$student['email'].'",
                                              "personalLink": "'.$student['personalLink'].'",
                                              "phoneNumber": "'.$student['phoneNumber'].'",
                                              "school": "'.$student['school'].'",
                                              "resume": "'.$student['resume'].'",
                                              "process": '.$this->solve_process_code($student['process']).',
                                              "status": "'.$student['status'].'"}', true));
        }
        return $result;
    }
    
    public function getCompanyInfo()
    {
        $status = (Session::get('isStudent')) ? 'Student' : 'Recruiter';
        
        if(strcmp($status, 'Recruiter') != 0) {
            echo "Error Occurs while query user data\r\n"
                ."\t status Var contains wrong value\r\n"
                ."\t\t getCompanyInfo() in Board Model";

            exit;
        }
        
        $userId = Session::get('userId');

        $statement = $this->db->prepare("
                SELECT companyId
                FROM RelationCompanyRecruiter
                WHERE recruiterId = '$userId';
            ");
        $success = $statement->execute();
        $companyInfo = $statement->fetch();
        
        if(!$success) {
            echo "Error Occurs while query company ID\r\n"
                ."\t getCompanyInfo() in Board Model\r\n"
                ."\t\t recruiterBoard() in Board Controller";
            exit;
        }

        if(empty($companyInfo)){
            return '';
        }
        
        
        $statement = $this->db->prepare("
                SELECT name
                FROM Company
                WHERE companyId = '$companyInfo[0]';
            ");
        $success = $statement->execute();
        $companyName = $statement->fetchAll();
        
        if(!$success) {
            echo "Error Occurs while query company's name\r\n"
                ."\t getUserInfo() in Board Model\r\n"
                ."\t\t recruiterBoard() in Board Controller";
            exit;
        }
        if(empty($companyName)) {
            return '';
        }

        return $companyName[0]['name'];
    }
    
    public function updateProgressStatus($jobId, $studentId, $status) {
        $statement = $this->db->prepare("
            UPDATE RelationJobStudent
            SET status = $status
            WHERE jobId = $jobId AND studentId = $studentId
        ");
        $statement->execute();
        
        if ($statement) {
            return null;
        }
        else {
            return "Error occurs while updating job status.";
        }
    }
    
    public function addJobPost()
    {
        
        $company = $_POST['jobcompany'];
        $title = $_POST['jobtitle'];
        $type = $_POST['jobtype'];
        $area = $_POST['jobarea'];
        $experience = $_POST['joblevel'];
        $location = $_POST['joblocation'];
        $skill = $_POST['jobskill'];
        $salary = $_POST['jobsalary'];
        $visa = $_POST['jobvisa'];
        $description = $_POST['jobdescription'];
        $userId = Session::get('userId');

        $result;
        $query = "SELECT title FROM Job WHERE companyName = '$company' AND title = '$title' AND location = '$location'";
        $queryFindDup = $this->db->prepare($query);
        $queryFindDupSuccess = $queryFindDup->execute();

        if($queryFindDupSuccess && !empty($queryFindDup->fetchAll())){
            $result = '{"error_msg": "Duplicate Posting"}';
        }
        else {
            $query = "INSERT INTO Job (recruiterID,title,companyName,type,area,level,description,location,requredSkill,salary,seekerVisaType)
                VALUES (:userId,:title,:company,:type,:area,:experience,:description,:location,:skill,:salary,:visa)";
            $queryJobPost = $this->db->prepare($query);
            $queryJobPost->execute(array(':userId'=>$userId, ':title'=>$title, ':company'=>$company, ':type'=>$type, ':area'=>$area, 
                ':experience'=>$experience, ':description'=>$description, ':location'=>$location, ':skill'=>$skill, ':salary'=>$salary, ':visa'=>$visa));
            $jobId = $this->db->lastInsertId();

            $query = "SELECT * FROM Job WHERE recruiterID = '$userId' AND title = '$title' AND companyName = '$company' AND description = '$description'";
            $queryPostedDate = $this->db->prepare($query);
            $queryPostedDateSuccess = $queryPostedDate->execute();
            $postedDate = $queryPostedDate->fetchAll();
            $postedDate = $postedDate[0]['postedDate'];

            if(!$queryPostedDateSuccess) {
                echo "Error Occurs while query posted date\r\n"
                    ."\t addJobPost() in Board Model\r\n";
                exit;
            }

            if(!$queryJobPost){
                $result = '{"error_msg": "Error occurred while inserting Job Post into db"}';
            }
            else {
                $result = '{"error_msg": "","recruiterId": "'.$userId.'", "company": "'.$company.'", "title": "'.$title.'",
                    "type": "'.$type.'", "area": "'.$area.'", "level": "'.$experience.'", "location": "'.$location.'", "skill": "'.$skill.'",
                    "salary": "'.$salary.'", "description": "'.$description.'", "visa": "'.$visa.'", "jobId": "'.$jobId.'", "postedDate": "'.$postedDate.'"}';
            }

        }
        return $result;
    }

    public function applyJob()
    {
        $jobId = $_POST['jobId'];
        $userId = Session::get('userId');

        $query = "SELECT * FROM RELATIONJOBSTUDENT WHERE studentId = $userId AND jobId = $jobId";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        if(sizeof($result) != 0){
            return "You have already applied for this Job!";
        }else{
            $query = "INSERT INTO RELATIONJOBSTUDENT (studentId, jobId) VALUES ($userId, $jobId)";
            $statement = $this->db->prepare($query);
            $success = $statement->execute();
            if($success){
                return "Applied!";
            }
            else{
                echo "Failed to apply!";
                exit;
            }
        }
    }
    
    public function change_job_process()
    {
        $jobId = $_POST['jobId'];
        $oncampus = (isset($_POST['on_campus']) && !empty($_POST['on_campus'])) ? $_POST['on_campus'] : 0;
        $phone1 = (isset($_POST['phonescreen1']) && !empty($_POST['phonescreen1'])) ? $_POST['phonescreen1'] : 0;
        $phone2 = (isset($_POST['phonescreen2']) && !empty($_POST['phonescreen2'])) ? $_POST['phonescreen2'] : 0;
        $phone3 = (isset($_POST['phonescreen3']) && !empty($_POST['phonescreen3'])) ? $_POST['phonescreen3'] : 0;
        $phone4 = (isset($_POST['phonescreen4']) && !empty($_POST['phonescreen4'])) ? $_POST['phonescreen4'] : 0;
        $onsite = (isset($_POST['on_site']) && !empty($_POST['on_site'])) ? $_POST['on_site'] : 0;
        
        $combination = (string)($oncampus + $phone1 + $phone2 + $phone3 + $phone4 + $onsite);
        $combination = $this->fill_zeros_front($combination);
        
        $statement = $this->db->prepare("
            UPDATE RelationJobStudent
            SET process = '$combination'
            WHERE jobId = $jobId
        ");
        $statement->execute();
        
        $query = "SELECT studentId, status 
                  FROM RelationJobStudent
                  WHERE jobId = $jobId";
        $status_statement = $this->db->prepare($query);
        $status_statement->execute();
        $status = $status_statement->fetchAll();
        
        $data = '[';
        foreach ($status as $row) 
        {
            $data .= '{ "studentId": "' . $row['studentId'] . '", "status": "' . $row['status'] . '" },';
        }
        $data = substr($data, 0, -1);
        $data .= ']';
        
        if (!$statement) {
            return '{"error_message": "Error occurs while updating job status."}';
        }
        else {
            $result = $this->solve_process_code($combination);
            if (strcmp($result, '{}') != 0) {
                $result = substr($result, 0, -1);
                $result .= ', "user_info": ' . $data . ' }';
            }
            return $result;
        }
    }
    
    public function delete_job_student_relation($jobId, $studentId)
    {
        $statement = $this->db->prepare("Delete
                                        From RelationJobStudent
                                        Where jobId = $jobId AND studentId = $studentId
                                        ");
        $success = $statement->execute();
        
        if (!$success) {
            return "Error occured while deleting information!";
        }
    }

    // private functions
    private function fill_zeros_front($string)
    {
        $len = strlen($string);
        for ($i=$len; $i<6; $i++) {
            $string = '0'. $string;
        }
        return $string;
    }
    
    private function statusCode_to_status($code)
    {
        if (strcmp($code, "000000") == 0) { return "New"; }
        else if (strcmp($code, "100000") == 0) { return "On Campus"; }
        else if (strcmp($code, "100000") == 0) { return "PhoneInterviewI"; }
        else if (strcmp($code, "100000") == 0) { return "PhoneInterviewII"; }
        else if (strcmp($code, "100000") == 0) { return "PhoneInterviewIII"; }
        else if (strcmp($code, "100000") == 0) { return "PhoneInterviewIV"; }
        else if (strcmp($code, "100000") == 0) { return "OnSite"; }
        else if (strcmp($code, "222222") == 0) { return "Done"; }
        else { return "N/A"; }
    }
    
    private function solve_process_code($string)
    {
        if (strlen($string) == 0) {
            return '{}';
        }
        
        $e = strlen($string)-1;
        $result = ' }';
        $first = true;
        
        $status[0] = 'On Campus';
        $status[1] = 'Phone Interview I';
        $status[2] = 'Phone Interview II';
        $status[3] = 'Phone Interview III';
        $status[4] = 'Phone Interview IV';
        $status[5] = 'On Site';
        $value['OnCampus'] =          '100000';
        $value['PhoneInterviewI'] =   '010000';
        $value['PhoneInterviewII'] =  '001000';
        $value['PhoneInterviewIII'] = '000100';
        $value['PhoneInterviewIV'] =  '000010';
        $value['OnSite'] =            '000001';
        
        while ($e >= 0) {
            $bit = $string[$e];
            if ($bit) {
                $key = str_replace(' ', '', $status[$e]);
                if ($first) {
                    $result = '"'.$value[$key].'": "'.$status[$e].'"' . $result;
                    $first = false;
                }
                else {
                    $result = '"'.$value[$key].'": "'.$status[$e].'", ' . $result;
                }
            }
            $e = $e-1;
        }
        
        $result = '{ ' . $result;
        
        //return json_encode(json_decode($result, true));
        //return json_decode($result, true);
        return $result;
    }
    
    private function formatter($jobID, $title, $companyName, $description, $location, $postedDate) 
    {
        $result = '{
                        "jobID": "' . $jobID . '",
                        "title": "' . $title . '",
                        "companyName": "'. $companyName . '",
                        "description": "'. $description . '",
                        "location": "' . $location . '",
                        "postedDate": "' . $postedDate . '"';
        $result .=  ' }';
        
        return json_decode($result, true);
    }

    private function createFilterQuery($preference, $category)
    {
        $studentId = Session::get('userId');
        $length = count($category);
        $query = "SELECT Job.jobID, Job.title, Job.companyName, Job.location, Job.description, Job.postedDate
                  FROM (
                        SELECT jobId
                        FROM RelationJobStudent
                        WHERE studentId = $studentId
                       ) matchedJobs
                  RIGHT JOIN Job
                  ON matchedJobs.jobId = Job.jobID
                  WHERE matchedJobs.jobId IS NULL AND salary >= $preference[0]";

        for($i=1; $i<$length; $i++){
            if($preference[$i] != NULL or $preference[$i] != ''){
                $query = $query . " AND $category[$i] = '$preference[$i]'";
            }
        }

        return $query;
    }
}
