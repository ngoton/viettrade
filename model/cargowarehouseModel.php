<?php

Class cargowarehouseModel Extends baseModel {
	protected $table = "cargo_warehouse";

	public function getAllCargo($data = null,$join = null) 
    {
        return $this->fetchAll($this->table,$data,$join);
    }

    public function createCargo($data) 
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
            'Cargo' => $data['Cargo'],
            'account' => $data['account'],
        	);*/

        return $this->insert($this->table,$data);
    }
    public function updateCargo($data,$where) 
    {    
        if ($this->getCargoByWhere($where)) {
        	/*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Cargo' => $data['Cargo'],
            'account' => $data['account'],
            );*/
	        return $this->update($this->table,$data,$where);
        }
        
    }
    public function deleteCargo($id){
    	if ($this->getCargo($id)) {
    		return $this->delete($this->table,array('cargo_warehouse_id'=>$id));
    	}
    }
    public function getCargo($id){
        return $this->getByID($this->table,$id);
    }
    public function getCargoByWhere($where){
    	return $this->getByWhere($this->table,$where);
    }
    public function getAllCargoByWhere($id){
        return $this->query('SELECT * FROM cargo_warehouse WHERE cargo_warehouse_id != '.$id);
    }
    public function getLastCargo(){
        return $this->getLast($this->table);
    }
    public function queryCargo($sql){
        return $this->query($sql);
    }
}
?>