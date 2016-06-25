<?php

Class staffdebtModel Extends baseModel {
	protected $table = "staff_debt";

	public function getAllCost($data = null,$join = null) 
    {
        return $this->fetchAll($this->table,$data,$join);
    }

    public function createCost($data) 
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
    public function createCost2($data) 
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

        return $this->insert2($this->table,$data);
    }
    public function createCost3($data) 
    {    
        $this->createCost4($data);
        $id_last = $this->getLastCost4()->staff_debt_id;
        $data['staff_debt_id'] = $id_last;

        return $this->insert3($this->table,$data);
    }
    public function createCost4($data) 
    {    
        $data = array(
            'staff' => null,
            'source' => null,
            'money' => null,
            'staff_debt_date' => null,
            'comment' => null,
            'week' => null,
            'year' => null,
            'status' => null,
        );

        return $this->insert4($this->table,$data);
    }
    public function updateCost($data,$where) 
    {    
        if ($this->getCostByWhere($where)) {
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
    public function updateCost2($data,$where) 
    {    
        if ($this->getCostByWhere2($where)) {
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
            return $this->update2($this->table,$data,$where);
        }
        
    }
    public function updateCost3($data,$where) 
    {    
        if ($this->getCostByWhere3($where)) {
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
            return $this->update3($this->table,$data,$where);
        }
        
    }
    public function updateCost4($data,$where) 
    {    
        if ($this->getCostByWhere4($where)) {
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
            return $this->update4($this->table,$data,$where);
        }
        
    }
    public function deleteCost($id){
    	if ($this->getCost($id)) {
    		return $this->delete($this->table,array('staff_debt_id'=>$id));
    	}
    }
    public function deleteCost2($id){
        if ($this->getCost2($id)) {
            return $this->delete2($this->table,array('staff_debt_id'=>$id));
        }
    }
    public function deleteCost3($id){
        $this->deleteCost4($id);
        if ($this->getCost3($id)) {
            return $this->delete3($this->table,array('staff_debt_id'=>$id));
        }
    }
    public function deleteCost4($id){
        if ($this->getCost4($id)) {
            return $this->delete4($this->table,array('staff_debt_id'=>$id));
        }
    }
    public function getCost($id){
        return $this->getByID($this->table,$id);
    }
    public function getCost2($id){
        return $this->getByID2($this->table,$id);
    }
    public function getCost3($id){
        return $this->getByID3($this->table,$id);
    }
    public function getCost4($id){
        return $this->getByID4($this->table,$id);
    }
    public function getCostByWhere($where){
    	return $this->getByWhere($this->table,$where);
    }
    public function getCostByWhere2($where){
        return $this->getByWhere2($this->table,$where);
    }
    public function getCostByWhere3($where){
        return $this->getByWhere3($this->table,$where);
    }
    public function getCostByWhere4($where){
        return $this->getByWhere4($this->table,$where);
    }
    public function getAllCostByWhere($id){
        return $this->query('SELECT * FROM staff_debt WHERE staff_debt_id != '.$id);
    }
    public function getLastCost(){
        return $this->getLast($this->table);
    }
    public function getLastCost2(){
        return $this->getLast2($this->table);
    }
    public function getLastCost3(){
        return $this->getLast3($this->table);
    }
    public function getLastCost4(){
        return $this->getLast2($this->table);
    }
    public function queryCost($sql){
        return $this->query($sql);
    }
    public function queryCost2($sql){
        return $this->query2($sql);
    }
    public function queryCost3($sql){
        return $this->query3($sql);
    }
    public function queryCost4($sql){
        return $this->query4($sql);
    }
}
?>