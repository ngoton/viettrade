<?php

Class salaryModel Extends baseModel {
	protected $table = "salary";

	public function getAllSalary($data = null,$join = null) 
    {
        return $this->fetchAll($this->table,$data,$join);
    }

    public function createSalary($data) 
    {    
        
        return $this->insert($this->table,$data);
    }
    public function updateSalary($data,$id) 
    {    
        if ($this->getSalaryByWhere($id)) {
        	
	        return $this->update($this->table,$data,$id);
        }
        
    }
    public function deleteSalary($id){
    	if ($this->getSalary($id)) {
    		return $this->delete($this->table,array('salary_id'=>$id));
    	}
    }
    public function getSalary($id){
    	return $this->getByID($this->table,$id);
    }
    public function getSalaryByWhere($where){
        return $this->getByWhere($this->table,$where);
    }
    public function getLastSalary(){
        return $this->getLast($this->table);
    }
}
?>