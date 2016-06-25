<?php

Class districtModel Extends baseModel {
	protected $table = "district";

	public function getAllDistrict($data = null,$join = null) 
    {
        return $this->fetchAll($this->table,$data,$join);
    }

    public function createDistrict($data) 
    {    
        /*$data = array(
        	'staff_id' => $data['staff_id'],
        	'staff_name' => $data['staff_name'],
        	'staff_birth' => $data['staff_birth'],
        	'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'bank' => $data['bank'],
            'account' => $data['account'],
        	);*/

        return $this->insert($this->table,$data);
    }
    public function updateDistrict($data,$where) 
    {    
        if ($this->getDistrictByWhere($where)) {
        	/*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'bank' => $data['bank'],
            'account' => $data['account'],
            );*/
	        return $this->update($this->table,$data,$where);
        }
        
    }
    public function deleteDistrict($id){
    	if ($this->getDistrict($id)) {
    		return $this->delete($this->table,array('district_id'=>$id));
    	}
    }
    public function getDistrict($id){
        return $this->getByID($this->table,$id);
    }
    public function getDistrictByWhere($where){
    	return $this->getByWhere($this->table,$where);
    }
    public function getAllDistrictByWhere($id){
        return $this->query('SELECT * FROM district WHERE district_id != '.$id);
    }
}
?>