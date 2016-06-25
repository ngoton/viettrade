<?php

Class oweModel Extends baseModel {
	protected $table = "owe";

	public function getAllOwe($data = null,$join = null) 
    {
        return $this->fetchAll($this->table,$data,$join);
    }

    public function createOwe($data) 
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
            'Owe' => $data['Owe'],
            'account' => $data['account'],
        	);*/

        return $this->insert($this->table,$data);
    }
    public function createOwe2($data) 
    {    
        $this->createOwe4($data);
        $id_last = $this->getLastOwe4()->owe_id;
        $data['owe_id'] = $id_last;

        return $this->insert2($this->table,$data);
    }
    public function createOwe3($data) 
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
            'Owe' => $data['Owe'],
            'account' => $data['account'],
            );*/

        return $this->insert3($this->table,$data);
    }
    public function createOwe4($data) 
    {    
        $data = array(
            'owe_date' => null,
            'vendor' => null,
            'money' => null,
            'week' => null,
            'year' => null,
            'costs' => $data['costs'],
        );

        return $this->insert4($this->table,$data);
    }
    public function updateOwe($data,$where) 
    {    
        if ($this->getOweByWhere($where)) {
        	/*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Owe' => $data['Owe'],
            'account' => $data['account'],
            );*/
	        return $this->update($this->table,$data,$where);
        }
        
    }
    public function updateOwe2($data,$where) 
    {    
        if ($this->getOweByWhere2($where)) {
            /*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Owe' => $data['Owe'],
            'account' => $data['account'],
            );*/
            return $this->update2($this->table,$data,$where);
        }
        
    }
    public function updateOwe3($data,$where) 
    {    
        if ($this->getOweByWhere3($where)) {
            /*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Owe' => $data['Owe'],
            'account' => $data['account'],
            );*/
            return $this->update3($this->table,$data,$where);
        }
        
    }
    public function updateOwe4($data,$where) 
    {    
        if ($this->getOweByWhere4($where)) {
            /*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Owe' => $data['Owe'],
            'account' => $data['account'],
            );*/
            return $this->update4($this->table,$data,$where);
        }
        
    }
    public function deleteOwe($id){
    	if ($this->getOwe($id)) {
    		return $this->delete($this->table,array('owe_id'=>$id));
    	}
    }
    public function deleteOwe2($id){
        $this->deleteOwe4($id);
        if ($this->getOwe2($id)) {
            return $this->delete2($this->table,array('owe_id'=>$id));
        }
    }
    public function deleteOwe3($id){
        if ($this->getOwe3($id)) {
            return $this->delete3($this->table,array('owe_id'=>$id));
        }
    }
    public function deleteOwe4($id){
        if ($this->getOwe4($id)) {
            return $this->delete4($this->table,array('owe_id'=>$id));
        }
    }
    public function getOwe($id){
        return $this->getByID($this->table,$id);
    }
    public function getOwe2($id){
        return $this->getByID2($this->table,$id);
    }
    public function getOwe3($id){
        return $this->getByID3($this->table,$id);
    }
    public function getOwe4($id){
        return $this->getByID4($this->table,$id);
    }
    public function getOweByWhere($where){
    	return $this->getByWhere($this->table,$where);
    }
    public function getOweByWhere2($where){
        return $this->getByWhere2($this->table,$where);
    }
    public function getOweByWhere3($where){
        return $this->getByWhere3($this->table,$where);
    }
    public function getOweByWhere4($where){
        return $this->getByWhere4($this->table,$where);
    }
    public function getAllOweByWhere($id){
        return $this->query('SELECT * FROM owe WHERE owe_id != '.$id);
    }
    public function getLastOwe(){
        return $this->getLast($this->table);
    }
    public function getLastOwe2(){
        return $this->getLast2($this->table);
    }
    public function getLastOwe3(){
        return $this->getLast3($this->table);
    }
    public function getLastOwe4(){
        return $this->getLast2($this->table);
    }
    public function queryOwe($sql){
        return $this->query($sql);
    }
    public function queryOwe2($sql){
        return $this->query2($sql);
    }
    public function queryOwe3($sql){
        return $this->query3($sql);
    }
    public function queryOwe4($sql){
        return $this->query4($sql);
    }
}
?>