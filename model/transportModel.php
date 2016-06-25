<?php

Class transportModel Extends baseModel {
	protected $table = "transport";

	public function getAllTransport($data = null,$join = null) 
    {
        return $this->fetchAll($this->table,$data,$join);
    }

    public function createTransport($data) 
    {    
        
        return $this->insert($this->table,$data);
    }
    public function updateTransport($data,$id) 
    {    
        if ($this->getTransportByWhere($id)) {
        	
	        return $this->update($this->table,$data,$id);
        }
        
    }
    public function deleteTransport($id){
    	if ($this->getTransport($id)) {
    		return $this->delete($this->table,array('transport_id'=>$id));
    	}
    }
    public function getTransport($id){
    	return $this->getByID($this->table,$id);
    }
    public function getTransportByWhere($where){
        return $this->getByWhere($this->table,$where);
    }
    public function getLastTransport(){
        return $this->getLast($this->table);
    }
    public function getTransportByField($column,$where){
        return $this->query('SELECT '.$column.' FROM transport WHERE '.$where);
    }
}
?>