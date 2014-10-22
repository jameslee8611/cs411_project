<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Database extends PDO {

    function __construct() {
        parent::__construct("mysql:host=".Host.";dbname=".DBName, DBUser, DBPassword);
    }

    /**
     * update simple db attributes
     * @param string $dbname
     * @param array $updateAttrNames
     * @param array $updateAttrValues
     * @param array $attrNames
     * @param array $attrValues
     * @return result
     */
    public function update($dbname, $updateAttrNames, $updateAttrValues, $attrNames, $attrValues) {
        $updateAttrNum = count($updateAttrNames);
        if($updateAttrNum < 1 || $updateAttrNum != count($updateAttrValues))
            return NULL;

        $attrNum = count($attrNames);
        if($attrNum != count($attrValues))
            return NULL;
        
        $query = "update $dbname set"; 

        for ($x = 0; $x < $updateAttrNum; $x++) {
            $query .= " $updateAttrNames[$x] = '$updateAttrValues[$x]'";
            if($x < $updateAttrNum - 1)
                $query .= ", ";
        } 

        if($attrNum > 0){
            $query .= " where ";
            for ($x = 0; $x < $attrNum; $x++) {
                $query .= "$attrNames[$x] = '$attrValues[$x]'";
                if($x < $attrNum - 1){
                    $query .= " and ";
                }
            } 
        }            
        
        $statement = $this->prepare($query);
        $success = $statement->execute();
        if($success)
            return $statement;     
        else return NULL;   
        
    }

    /**
     * 
     * @param type $dbname      Database name
     * @param type $attrNames   array type- attribute names
     * @param type $attrValues  array type- attribute values
     * @return null
     */
    public function insert($dbname, $attrNames, $attrValues) {
        $attrNum = count($attrNames);
        if($attrNum < 1 || $attrNum != count($attrValues))
            return NULL;

        $query = "insert into $dbname (";
        for ($x = 0; $x < $attrNum; $x++) {
            $query .= "$attrNames[$x]";
            if($x < $attrNum - 1)
                $query .= ", ";
            else $query .= ")";
        } 

        $query .= " values (";
        for ($x = 0; $x < $attrNum; $x++) {
            $query .= "'$attrValues[$x]'";
            if($x < $attrNum - 1)
                $query .= ", ";
            else $query .= ")";
        } 

        $statement = $this->prepare($query);
        $success = $statement->execute();
        
        if($success)
            return $statement;     
        else 
            return NULL;   
    }

    public function delete($dbname, $attrNames, $attrValues) {
        $attrNum = count($attrNames);
        if($attrNum < 1 && $attrNum != count($attrValues))
            return NULL;

        $query = "delete from $dbname"; 
        $query .= " where ";
        for ($x = 0; $x < $attrNum; $x++) {
            $query .= "$attrNames[$x] = '$attrValues[$x]'";
            if($x < $attrNum - 1){
                $query .= " and ";
            }
        }        
                
        $statement = $this->prepare($query);
        $success = $statement->execute();
        if($success)
            return $statement;     
        else return NULL;   
    }

    /**
     * 
     * @param array $colNames    
     * @param string $dbname      Database name
     * @param array $attrNames   Attribute name
     * @param array $attrValues  Attribute values
     * @param string $operator
     * @return null
     */
    public function select($colNames, $dbname, $attrNames, $attrValues, $operator = "and") {
        $attrNum = count($attrNames);
        if($attrNum != count($attrValues))
            return NULL;

        $query = "select "; 
        $colNum = count($colNames);
        if($colNum == 0){
            $query .= "*";
        }
        else{
            for ($x = 0; $x < $colNum; $x++) {
                $query .= "$colNames[$x]";
                if($x < $colNum - 1){
                    $query .= ", ";
                }
            } 
        }
        $query .= " from $dbname";

        if($attrNum > 0){
            $query .= " where ";
            for ($x = 0; $x < $attrNum; $x++) {
                $query .= "$attrNames[$x] = '$attrValues[$x]'";
                if($x < $attrNum - 1){
                    $query .= " $operator ";
                }
            } 
        }        

        $statement = $this->prepare($query);
        $success = $statement->execute();
        if($success)
            return $statement;     
        else return NULL;   
    }

}

?>