<?php

Class assetsModel Extends baseModel {
	protected $table = "assets";

	public function getAllAssets($data = null,$join = null) 
    {
        return $this->fetchAll($this->table,$data,$join);
    }

    public function createAssets($data) 
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
            'Assets' => $data['Assets'],
            'account' => $data['account'],
        	);*/

        return $this->insert($this->table,$data);
    }
    public function createAssets2($data) 
    {    
        $this->createAssets4($data);
        $id_last = $this->getLastAssets4()->assets_id;
        $data['assets_id'] = $id_last;

        return $this->insert2($this->table,$data);
    }
    public function createAssets3($data) 
    {    

        $id_last = $this->getLastAssets4()->assets_id;
        $data['assets_id'] = $id_last;
        
        return $this->insert3($this->table,$data);
    }
    public function createAssets4($data) 
    {    
        $data = array(
            'bank' => null,
            'total' => null,
            'assets_date' => null,
            'costs' => null,
            'week' => null,
            'year' => null,
        );

        return $this->insert4($this->table,$data);
    }
    public function updateAssets($data,$where) 
    {    
        if ($this->getAssetsByWhere($where)) {
        	/*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Assets' => $data['Assets'],
            'account' => $data['account'],
            );*/
	        return $this->update($this->table,$data,$where);
        }
        
    }
    public function updateAssets2($data,$where) 
    {    

        if ($this->getAssetsByWhere2($where)) {
            /*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Assets' => $data['Assets'],
            'account' => $data['account'],
            );*/
            return $this->update2($this->table,$data,$where);
        }
        
    }
    public function updateAssets3($data,$where) 
    {    
        if ($this->getAssetsByWhere3($where)) {
            /*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Assets' => $data['Assets'],
            'account' => $data['account'],
            );*/
            return $this->update3($this->table,$data,$where);
        }
        
    }
    public function updateAssets4($data,$where) 
    {    
        if ($this->getAssetsByWhere4($where)) {
            /*$data = array(
            'staff_id' => $data['staff_id'],
            'staff_name' => $data['staff_name'],
            'staff_birth' => $data['staff_birth'],
            'staff_gender' => $data['staff_gender'],
            'staff_address' => $data['staff_address'],
            'staff_phone' => $data['staff_phone'],
            'staff_email' => $data['staff_email'],
            'cmnd' => $data['cmnd'],
            'Assets' => $data['Assets'],
            'account' => $data['account'],
            );*/
            return $this->update4($this->table,$data,$where);
        }
        
    }
    public function deleteAssets($id){
    	if ($this->getAssets($id)) {
    		return $this->delete($this->table,array('assets_id'=>$id));
    	}
    }
    public function deleteAssets2($id){
        $this->deleteAssets4($id);
        if ($this->getAssets2($id)) {
            return $this->delete2($this->table,array('assets_id'=>$id));
        }
    }
    public function deleteAssets3($id){
        if ($this->getAssets3($id)) {
            return $this->delete3($this->table,array('assets_id'=>$id));
        }
    }
    public function deleteAssets4($id){
        if ($this->getAssets4($id)) {
            return $this->delete4($this->table,array('assets_id'=>$id));
        }
    }
    public function getAssets($id){
        return $this->getByID($this->table,$id);
    }
    public function getAssets2($id){
        return $this->getByID2($this->table,$id);
    }
    public function getAssets3($id){
        return $this->getByID3($this->table,$id);
    }
    public function getAssets4($id){
        return $this->getByID4($this->table,$id);
    }
    public function getAssetsByWhere($where){
    	return $this->getByWhere($this->table,$where);
    }
    public function getAssetsByWhere2($where){
        return $this->getByWhere2($this->table,$where);
    }
    public function getAssetsByWhere3($where){
        return $this->getByWhere3($this->table,$where);
    }
    public function getAssetsByWhere4($where){
        return $this->getByWhere4($this->table,$where);
    }
    public function getAllAssetsByWhere($id){
        return $this->query('SELECT * FROM assets WHERE assets_id != '.$id);
    }
    public function getLastAssets(){
        return $this->getLast($this->table);
    }
    public function getLastAssets2(){
        return $this->getLast2($this->table);
    }
    public function getLastAssets3(){
        return $this->getLast3($this->table);
    }
    public function getLastAssets4(){
        return $this->getLast2($this->table);
    }
    public function queryAssets($sql){
        return $this->query($sql);
    }
    public function queryAssets2($sql){
        return $this->query2($sql);
    }
    public function queryAssets3($sql){
        return $this->query3($sql);
    }
    public function queryAssets4($sql){
        return $this->query4($sql);
    }
}
?>