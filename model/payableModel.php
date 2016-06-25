<?php

Class payableModel Extends baseModel {
	protected $table = "payable";

	public function getAllCosts($data = null,$join = null) 
    {
        return $this->fetchAll($this->table,$data,$join);
    }

    public function createCosts($data) 
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
            'Costs' => $data['Costs'],
            'account' => $data['account'],
        	);*/

        return $this->insert($this->table,$data);
    }
    public function createCosts2($data) 
    {    
        $this->createCosts4($data);
        $id_last = $this->getLastCosts4()->payable_id;
        $data['payable_id'] = $id_last;

        return $this->insert2($this->table,$data);
    }
    public function createCosts3($data) 
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
            'Costs' => $data['Costs'],
            'account' => $data['account'],
            );*/

        return $this->insert3($this->table,$data);
    }
    public function createCosts4($data) 
    {    
        $data = array(
            'costs' => $data['costs'],
        );

        return $this->insert4($this->table,$data);
    }
    public function updateCosts($data,$where) 
    {    
        if ($this->getCostsByWhere($where)) {
        	/*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Costs' => $data['Costs'],
            'account' => $data['account'],
            );*/
	        return $this->update($this->table,$data,$where);
        }
        
    }
    public function updateCosts2($data,$where) 
    {    
        if ($this->getCostsByWhere2($where)) {
            /*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Costs' => $data['Costs'],
            'account' => $data['account'],
            );*/
            return $this->update2($this->table,$data,$where);
        }
        
    }
    public function updateCosts3($data,$where) 
    {    
        if ($this->getCostsByWhere3($where)) {
            /*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Costs' => $data['Costs'],
            'account' => $data['account'],
            );*/
            return $this->update3($this->table,$data,$where);
        }
        
    }
    public function updateCosts4($data,$where) 
    {    
        if ($this->getCostsByWhere4($where)) {
            /*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Costs' => $data['Costs'],
            'account' => $data['account'],
            );*/
            return $this->update4($this->table,$data,$where);
        }
        
    }
    public function deleteCosts($id){
    	if ($this->getCosts($id)) {
    		return $this->delete($this->table,array('payable_id'=>$id));
    	}
    }
    public function deleteCosts2($id){
        $this->deleteCosts4($id);
        if ($this->getCosts2($id)) {
            return $this->delete2($this->table,array('payable_id'=>$id));
        }
    }
    public function deleteCosts3($id){
        if ($this->getCosts3($id)) {
            return $this->delete3($this->table,array('payable_id'=>$id));
        }
    }
    public function deleteCosts4($id){
        if ($this->getCosts4($id)) {
            return $this->delete4($this->table,array('payable_id'=>$id));
        }
    }
    public function getCosts($id){
        return $this->getByID($this->table,$id);
    }
    public function getCosts2($id){
        return $this->getByID2($this->table,$id);
    }
    public function getCosts3($id){
        return $this->getByID3($this->table,$id);
    }
    public function getCosts4($id){
        return $this->getByID4($this->table,$id);
    }
    public function getCostsByWhere($where){
    	return $this->getByWhere($this->table,$where);
    }
    public function getCostsByWhere2($where){
        return $this->getByWhere2($this->table,$where);
    }
    public function getCostsByWhere3($where){
        return $this->getByWhere3($this->table,$where);
    }
    public function getCostsByWhere4($where){
        return $this->getByWhere4($this->table,$where);
    }
    public function getAllCostsByWhere($id){
        return $this->query('SELECT * FROM payable WHERE payable_id != '.$id);
    }
    public function getLastCosts(){
        return $this->getLast($this->table);
    }
    public function getLastCosts2(){
        return $this->getLast2($this->table);
    }
    public function getLastCosts3(){
        return $this->getLast3($this->table);
    }
    public function getLastCosts4(){
        return $this->getLast2($this->table);
    }
    public function queryCosts($sql){
        return $this->query($sql);
    }
    public function queryCosts2($sql){
        return $this->query2($sql);
    }
    public function queryCosts3($sql){
        return $this->query3($sql);
    }
    public function queryCosts4($sql){
        return $this->query4($sql);
    }
}
?>