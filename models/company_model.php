<?php

class company_model extends Model {
    
    function __construct() {
        parent::__construct();
    }

    public function getCompany()
    {
        $userId = Session::get('userId');
        $query = "SELECT * FROM COMPANY WHERE companyId NOT IN (SELECT companyId FROM RELATIONLIKECOMPANY WHERE studentId = $userId)";
        $statement = $this->db->prepare($query);
        $success = $statement->execute();
        $company = $statement->fetchAll();

        return $company; 
    }
    
    public function getLikedCompany()
    {
        $userId = Session::get("userId");

        $query = "SELECT * FROM COMPANY WHERE companyId IN 
        (SELECT companyId FROM RELATIONLIKECOMPANY WHERE studentId = $userId)";

        $statement = $this->db->prepare($query);
        $statement->execute();
        $company = $statement->fetchAll();

        return $company;
    }

    public function findCompanyById()
    {
        $companyId = $_POST['companyId'];

        $query = "SELECT * FROM COMPANY WHERE companyId = $companyId";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $company = $statement->fetch();

        return $company;
    }

    public function likeCompany()
    {
        $companyId = $_POST['companyId'];
        $userId = Session::get('userId');

        $query = "INSERT INTO RELATIONLIKECOMPANY (studentId, companyId) VALUES ($userId, $companyId)";
        $statement = $this->db->prepare($query);
        $statement->execute();
    }

    public function dislikeCompany()
    {
        $companyId = $_POST['companyId'];
        $userId = Session::get('userId');

        $query = "DELETE FROM RELATIONLIKECOMPANY WHERE studentId = $userId AND companyId = $companyId";
        $statement = $this->db->prepare($query);
        $statement->execute();
    }

}

?>