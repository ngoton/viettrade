<?php
Class customertireController Extends baseController {
    public function index() {
        $this->view->setLayout('admin');
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Quản lý thông tin khách hàng';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;
            $order = isset($_POST['order']) ? $_POST['order'] : null;
            $page = isset($_POST['page']) ? $_POST['page'] : null;
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;
            $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;
            $ngaytao = isset($_POST['ngaytao']) ? $_POST['ngaytao'] : null;
            $ngaytaobatdau = isset($_POST['ngaytaobatdau']) ? $_POST['ngaytaobatdau'] : null;
            $batdau = isset($_POST['batdau']) ? $_POST['batdau'] : null;
            $ketthuc = isset($_POST['ketthuc']) ? $_POST['ketthuc'] : null;
            $trangthai = isset($_POST['trangthai']) ? $_POST['trangthai'] : null;
        }
        else{
            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'customer_tire_date';
            $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'DESC';
            $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;
            $keyword = "";
            $limit = 50;
            $ngaytao = date('m-Y');
            $ngaytaobatdau = date('m-Y');
            $batdau = '01-'.date('m-Y');
            $ketthuc = date('t-m-Y');
            $trangthai = "";
        }

        $vehicle_type = $this->model->get('vehicletypeModel');
        $tire_brand = $this->model->get('tirebrandModel');
        $tire_size = $this->model->get('tiresizeModel');

        $vehicle_types = $vehicle_type->getAllVehicle();
        $data_vehicle = array();
        foreach ($vehicle_types as $vehicle) {
            $data_vehicle['name'][$vehicle->vehicle_type_id] = $vehicle->vehicle_type_name;
        }

        $tire_brands = $tire_brand->getAllTire();
        $data_brand = array();
        foreach ($tire_brands as $tire) {
            $data_brand['name'][$tire->tire_brand_id] = $tire->tire_brand_name;
        }

        $tire_sizes = $tire_size->getAllTire();
        $data_size = array();
        foreach ($tire_sizes as $tire) {
            $data_size['name'][$tire->tire_size_id] = $tire->tire_size_number;
        }

        $this->view->data['tire_brand'] = $data_brand;
        $this->view->data['tire_size'] = $data_size;
        $this->view->data['vehicle_type'] = $data_vehicle;

        $id = $this->registry->router->param_id;

        $join = array('table'=>'user','where'=>'user.user_id = customer_tire.customer_tire_sale');

        $customer_model = $this->model->get('customertireModel');

        $list_customers = $customer_model->queryCustomer('SELECT customer_tire_company FROM customer_tire ORDER BY customer_tire_company ASC');
        if ($_SESSION['role_logined'] == 4) {
            $list_customers = $customer_model->queryCustomer('SELECT customer_tire_company FROM customer_tire WHERE customer_tire_sale = '.$_SESSION['userid_logined'].' ORDER BY customer_tire_company ASC');
        }
        $this->view->data['list_customers'] = $list_customers;

        $sonews = $limit;
        $x = ($page-1) * $sonews;
        $pagination_stages = 2;

        $data = array(
            'where' => 'customer_tire_date >= '.strtotime($batdau).' AND customer_tire_date <= '.strtotime($ketthuc),
        );

        if ($trangthai != "") {
            $data['where'] = 'customer_tire_company LIKE "%'.$trangthai.'%"';
        }

        if (isset($id) && $id > 0) {
            $data['where'] .= ' AND customer_tire_id = '.$id;
        }

        if ($_SESSION['role_logined'] == 4) {
            $data['where'] .= ' AND customer_tire_sale = '.$_SESSION['userid_logined'];
        }

        

        
        $tongsodong = count($customer_model->getAllCustomer($data,$join));
        $tongsotrang = ceil($tongsodong / $sonews);
        

        $this->view->data['page'] = $page;
        $this->view->data['order_by'] = $order_by;
        $this->view->data['order'] = $order;
        $this->view->data['keyword'] = $keyword;
        $this->view->data['pagination_stages'] = $pagination_stages;
        $this->view->data['tongsotrang'] = $tongsotrang;
        $this->view->data['sonews'] = $sonews;
        $this->view->data['limit'] = $limit;
        $this->view->data['ngaytao'] = $ngaytao;
        $this->view->data['ngaytaobatdau'] = $ngaytaobatdau;
        $this->view->data['batdau'] = $batdau;
        $this->view->data['ketthuc'] = $ketthuc;
        $this->view->data['trangthai'] = $trangthai;

        $data = array(
            'order_by'=>$order_by,
            'order'=>$order,
            'limit'=>$x.','.$sonews,
            'where' => 'customer_tire_date >= '.strtotime($batdau).' AND customer_tire_date <= '.strtotime($ketthuc),
            );

        if ($trangthai != "") {
            $data['where'] = 'customer_tire_company LIKE "%'.$trangthai.'%"';
        }

        if (isset($id) && $id > 0) {
            $data['where'] .= ' AND customer_tire_id = '.$id;
        }

        if ($_SESSION['role_logined'] == 4) {
            $data['where'] .= ' AND customer_tire_sale = '.$_SESSION['userid_logined'];
        }
        
        if ($keyword != '') {
            $search = ' AND ( customer_tire_company LIKE "%'.$keyword.'%" 
                OR customer_tire_contact LIKE "%'.$keyword.'%" 
                OR customer_tire_email LIKE "%'.$keyword.'%" 
                OR vehicle_type IN (SELECT vehicle_type_id FROM vehicle_type WHERE vehicle_type_name LIKE "%'.$keyword.'%") 
                OR tire_brand IN (SELECT tire_brand_id FROM tire_brand WHERE tire_brand_name LIKE "%'.$keyword.'%") 
                OR tire_size IN (SELECT tire_size_id FROM tire_size WHERE tire_size_number LIKE "%'.$keyword.'%")
                OR username LIKE "%'.$keyword.'%"
                )';
            $data['where'] .= $search;
        }
        
        $customers = $customer_model->getAllCustomer($data,$join);
        
        $this->view->data['customers'] = $customers;

        $customer_type_model = $this->model->get('customertiretypeModel');

        $check_null = array();

        foreach ($customers as $cus) {
            $check_null[$cus->customer_tire_id] = 'null';
            $types = $customer_type_model->getCustomerByWhere(array('customer_tire'=>$cus->customer_tire_id));

            if ($cus->customer_tire_contact == "") {
                $check_null[$cus->customer_tire_id] = 'error';
            }
            if ($cus->customer_tire_email == "") {
                $check_null[$cus->customer_tire_id] = 'error';
            }
            if ($cus->customer_tire_phone == "") {
                $check_null[$cus->customer_tire_id] = 'error';
            }

            if (!$types) {
                $check_null[$cus->customer_tire_id] = 'error';
            }
        }

        $this->view->data['check_null'] = $check_null;

        $this->view->data['lastID'] = isset($customer_model->getLastCustomer()->customer_tire_id)?$customer_model->getLastCustomer()->customer_tire_id:0;
        
        $this->view->show('customertire/index');
    }

    public function getvehicle(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vehicle_model = $this->model->get('vehicletypeModel');
            

            if ($_POST['keyword'] == "*") {

                $list = $vehicle_model->getAllVehicle();
            }
            else{
                $data = array(
                'where'=>'( vehicle_type_name LIKE "%'.$_POST['keyword'].'%") ',
                );
                $list = $vehicle_model->getAllVehicle($data);
            }
            
            foreach ($list as $rs) {
                // put in bold the written text
                $vehicle_name = $rs->vehicle_type_name;
                if ($_POST['keyword'] != "*") {
                    $vehicle_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs->vehicle_type_name);
                }
                
                // add new option
                echo '<li onclick="set_item_vehicle(\''.$rs->vehicle_type_name.'\',\''.$rs->vehicle_type_id.'\')">'.$vehicle_name.'</li>';
            }
        }
    }
    public function getbrand(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tire_model = $this->model->get('tirebrandModel');
            

            if ($_POST['keyword'] == "*") {

                $list = $tire_model->getAllTire();
            }
            else{
                $data = array(
                'where'=>'( tire_brand_name LIKE "%'.$_POST['keyword'].'%") ',
                );
                $list = $tire_model->getAllTire($data);
            }
            
            foreach ($list as $rs) {
                // put in bold the written text
                $tire_name = $rs->tire_brand_name;
                if ($_POST['keyword'] != "*") {
                    $tire_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs->tire_brand_name);
                }
                
                // add new option
                echo '<li onclick="set_item_brand(\''.$rs->tire_brand_name.'\',\''.$rs->tire_brand_id.'\',\''.$_POST['offset'].'\')">'.$tire_name.'</li>';
            }
        }
    }
    public function getsize(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tire_model = $this->model->get('tiresizeModel');
            

            if ($_POST['keyword'] == "*") {

                $list = $tire_model->getAllTire();
            }
            else{
                $data = array(
                'where'=>'( tire_size_number LIKE "%'.$_POST['keyword'].'%") ',
                );
                $list = $tire_model->getAllTire($data);
            }
            
            foreach ($list as $rs) {
                // put in bold the written text
                $tire_name = $rs->tire_size_number;
                if ($_POST['keyword'] != "*") {
                    $tire_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs->tire_size_number);
                }
                
                // add new option
                echo '<li onclick="set_item_size(\''.$rs->tire_size_number.'\',\''.$rs->tire_size_id.'\',\''.$_POST['offset'].'\')">'.$tire_name.'</li>';
            }
        }
    }
    public function getpattern(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tire_model = $this->model->get('tirepatternModel');
            

            if ($_POST['keyword'] == "*") {

                $list = $tire_model->getAllTire();
            }
            else{
                $data = array(
                'where'=>'( tire_pattern_name LIKE "%'.$_POST['keyword'].'%") ',
                );
                $list = $tire_model->getAllTire($data);
            }
            
            foreach ($list as $rs) {
                // put in bold the written text
                $tire_name = $rs->tire_pattern_name;
                if ($_POST['keyword'] != "*") {
                    $tire_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs->tire_pattern_name);
                }
                
                // add new option
                echo '<li onclick="set_item_tire(\''.$rs->tire_pattern_name.'\',\''.$rs->tire_pattern_id.'\',\''.$_POST['offset'].'\')">'.$tire_name.'</li>';
            }
        }
    }

    public function add(){
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        if (isset($_POST['yes'])) {
            $customer = $this->model->get('customertireModel');
            /**************/
            $tire_type = $_POST['tire_type'];
            /**************/
            $customer_tire_type = $this->model->get('customertiretypeModel');

            $data = array(
                        
                        'customer_tire_company' => trim($_POST['customer_tire_company']),
                        'customer_tire_contact' => trim($_POST['customer_tire_contact']),
                        'customer_tire_phone' => trim($_POST['customer_tire_phone']),
                        'customer_tire_email' => trim($_POST['customer_tire_email']),
                        'vehicle_number' => trim($_POST['vehicle_number']),
                        'expect_date' => strtotime(trim($_POST['expect_date'])),
                        
                        
                        );

            if (trim($_POST['vehicle_type']) != "") {
                $data['vehicle_type'] = trim($_POST['vehicle_type']);
            }
            else{
                if (trim($_POST['vehicle_type_name']) != "") {
                    $vehicle_type = $this->model->get('vehicletypeModel');
                    $vehicle_type->createVehicle(array('vehicle_type_name' => trim($_POST['vehicle_type_name'])));
                    $vehicle_type_id = $vehicle_type->getLastVehicle()->vehicle_type_id;
                    $data['vehicle_type'] = $vehicle_type_id;
                }
            }

            


            if ($_POST['yes'] != "") {
                $customer->updateCustomer($data,array('customer_tire_id' => $_POST['yes']));

                $id_customer_tire = $_POST['yes'];
                        echo "Cập nhật thành công";

                        date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|customer_tire|".implode("-",$data)."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                
            }
            else{
                $data['customer_tire_sale'] = $_SESSION['userid_logined'];
                $data['customer_tire_date'] = strtotime(date('d-m-Y'));

                if($customer->getCustomerByWhere(array('customer_tire_email'=>$data['customer_tire_email']))){
                    echo 'Khách hàng đã tồn tại';
                    return false;
                }
                else{
                    $customer->createCustomer($data);
                    echo "Thêm thành công";

                $id_customer_tire = $customer->getLastCustomer()->customer_tire_id;

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$customer->getLastCustomer()->customer_tire_id."|customer_tire|".implode("-",$data)."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                }
                    
                
            }

            $tire_brand = $this->model->get('tirebrandModel');
            $tire_size = $this->model->get('tiresizeModel');
            $tire_pattern = $this->model->get('tirepatternModel');

            foreach ($tire_type as $v) {
                $data_tire_type = array(
                    'tire_brand' => $v['tire_brand'],
                    'tire_size' => $v['tire_size'],
                    'tire_pattern' => $v['tire_pattern'],
                    'tire_number' => str_replace(',','',$v['tire_number']),
                    'tire_price' => str_replace(',','',$v['tire_price']),
                    'tire_commission' => str_replace(',','',$v['tire_commission']),
                    'customer_tire' => $id_customer_tire,
                    'check_vat' => $v['check_vat'],
                    'comment' => trim($v['comment']),
                );

                if ($data_tire_type['tire_brand'] != "") {
                    $data_tire_type['tire_brand'] = $data_tire_type['tire_brand'];
                }
                else{
                    if (trim($v['tire_brand_name']) != "") {
                        if ($tire_brand->getTireByWhere(array('tire_brand_name' => trim($v['tire_brand_name'])))) {
                            $data_tire_type['tire_brand'] = $tire_brand->getTireByWhere(array('tire_brand_name' => trim($v['tire_brand_name'])))->tire_brand_id;
                        }
                        else{
                            $tire_brand->createTire(array('tire_brand_name' => trim($v['tire_brand_name'])));
                            $tire_brand_id = $tire_brand->getLastTire()->tire_brand_id;
                            $data_tire_type['tire_brand'] = $tire_brand_id;
                        }
                        
                    }
                }

                if ($data_tire_type['tire_size'] != "") {
                    $data_tire_type['tire_size'] = $data_tire_type['tire_size'];
                }
                else{
                    if (trim($v['tire_size_number']) != "") {
                        if ($tire_size->getTireByWhere(array('tire_size_number' => trim($v['tire_size_number'])))) {
                            $data_tire_type['tire_size'] = $tire_size->getTireByWhere(array('tire_size_number' => trim($v['tire_size_number'])))->tire_size_id;
                        }
                        else{
                            $tire_size->createTire(array('tire_size_number' => trim($v['tire_size_number'])));
                            $tire_size_id = $tire_size->getLastTire()->tire_size_id;
                            $data_tire_type['tire_size'] = $tire_size_id;
                        }
                        
                    }
                }

                if ($data_tire_type['tire_pattern'] != "") {
                    $data_tire_type['tire_pattern'] = $data_tire_type['tire_pattern'];
                }
                else{
                    if (trim($v['tire_pattern_name']) != "") {
                        if($tire_pattern->getTireByWhere(array('tire_pattern_name' => trim($v['tire_pattern_name'])))){
                            $data_tire_type['tire_pattern'] = $tire_pattern->getTireByWhere(array('tire_pattern_name' => trim($v['tire_pattern_name'])))->tire_pattern_id;
                        }
                        else{
                            $tire_pattern->createTire(array('tire_pattern_name' => trim($v['tire_pattern_name'])));
                            $tire_pattern_id = $tire_pattern->getLastTire()->tire_pattern_id;
                            $data_tire_type['tire_pattern'] = $tire_pattern_id;
                        }
                        
                    }
                }

                if ($customer_tire_type->getCustomerByWhere(array('tire_size'=>$data_tire_type['tire_size'],'tire_brand'=>$data_tire_type['tire_brand'],'tire_pattern'=>$data_tire_type['tire_pattern'],'customer_tire'=>$id_customer_tire))) {
                    $id_customer_tire_type = $customer_tire_type->getCustomerByWhere(array('tire_size'=>$data_tire_type['tire_size'],'tire_brand'=>$data_tire_type['tire_brand'],'tire_pattern'=>$data_tire_type['tire_pattern'],'customer_tire'=>$id_customer_tire))->customer_tire_type_id;
                    $customer_tire_type->updateCustomer($data_tire_type,array('customer_tire_type_id'=>$id_customer_tire_type));
                }
                else if (!$customer_tire_type->getCustomerByWhere(array('tire_size'=>$data_tire_type['tire_size'],'tire_brand'=>$data_tire_type['tire_brand'],'tire_pattern'=>$data_tire_type['tire_pattern'],'customer_tire'=>$id_customer_tire))) {
                    $customer_tire_type->createCustomer($data_tire_type);
                }
            }
                    
        }
    }

    public function getcustomertire(){
        if(isset($_POST['customer_tire'])){
            $tire_brand = $this->model->get('tirebrandModel');
            $tire_size = $this->model->get('tiresizeModel');
            $tire_pattern = $this->model->get('tirepatternModel');

            $tire_brands = $tire_brand->getAllTire();
            $tire_sizes = $tire_size->getAllTire();
            $tire_patterns = $tire_pattern->getAllTire();

            $brand[0]['name'] = null;
            $size[0]['name'] = null;
            $pattern[0]['name'] = null;

            foreach ($tire_brands as $tire) {
                $brand[$tire->tire_brand_id]['name'] = $tire->tire_brand_name;
            }
            foreach ($tire_sizes as $tire) {
                $size[$tire->tire_size_id]['name'] = $tire->tire_size_number;
            }
            foreach ($tire_patterns as $tire) {
                $pattern[$tire->tire_pattern_id]['name'] = $tire->tire_pattern_name;
            }

            $customer_tire_type = $this->model->get('customertiretypeModel');
           
            $customer_types = $customer_tire_type->getAllCustomer(array('where'=>'customer_tire='.$_POST['customer_tire']));
            

            $str = "";

            if(!$customer_types){

                $str .= '<tr class="'.$_POST['customer_tire'].'">';
                    $str .= '<td><input type="checkbox"  name="chk"></td>';
                    $str .= '<td><table style="width: 100%">';
                    $str .= '<tr class="'.$_POST['customer_tire'] .'">';
                    $str .= '<td>Thương hiệu</td>';
                    $str .= '<td><input type="text" class="tire_brand" name="tire_brand[]" autocomplete="false" tabindex="8" >';
                    $str .= '<ul class="brand_list_id"></ul></td>';
                    $str .= '<td>Size</td>';
                    $str .= '<td><input type="text" class="tire_size" name="tire_size[]" autocomplete="false" tabindex="9" >';
                    $str .= '<ul class="size_list_id"></ul></td>';
                    $str .= '<td>Mã gai</td>';
                    $str .= '<td><input type="text" class="numbers tire_pattern" name="tire_pattern[]" autocomplete="false" tabindex="10" >';
                    $str .= '<ul class="tire_list_id"></ul></td>';
                    $str .= '<td>Số lượng</td>';
                    $str .= '<td><input  type="text" class="numbers tire_number"  name="tire_number[]" tabindex="11" ></td></tr>';
                    $str .= '<tr class="'.$_POST['customer_tire'] .'">';
                    $str .= '<td>Giá chào</td>';
                    $str .= '<td><input  type="text" style="width:90px" class="number tire_price"  name="tire_price[]" tabindex="12" > <input  type="checkbox"  class="check_vat"  name="check_vat[]"  > VAT</td>';
                    $str .= '<td>Hoa hồng </td>';
                    $str .= '<td><input  type="text"  class="number tire_commission"  name="tire_commission[]" tabindex="13" ></td>';
                    $str .= '<td>Ghi chú</td>';
                    $str .= '<td><textarea name="comment[]" class="comment" tabindex="14"></textarea></td></tr>';
                    
                    $str .= '</table></td></tr>';
            }
            else{

                foreach ($customer_types as $v) {
                    $str .= '<tr class="'.$v->customer_tire.'">';
                    $str .= '<td><input type="checkbox"  name="chk" class="'.$v->tire_pattern.'" data="'.$v->tire_brand.'" tabindex="'.$v->tire_size.'" title="'.$v->customer_tire.'"></td>';
                    $str .= '<td><table style="width: 100%">';
                    $str .= '<tr class="'.$v->customer_tire.'">';
                    $str .= '<td>Thương hiệu</td>';
                    $str .= '<td><input type="text" disabled class="tire_brand" tabindex="8" name="tire_brand[]" data="'.$v->tire_brand.'" value="'.$brand[$v->tire_brand]['name'].'" autocomplete="false" >';
                    $str .= '<ul class="brand_list_id"></ul></td>';
                    $str .= '<td>Size</td>';
                    $str .= '<td><input type="text" disabled class="tire_size" tabindex="9" name="tire_size[]" data="'.$v->tire_size.'" value="'.$size[$v->tire_size]['name'].'" autocomplete="false" >';
                    $str .= '<ul class="size_list_id"></ul></td>';
                    $str .= '<td>Mã gai</td>';
                    $str .= '<td><input type="text" disabled class="numbers tire_pattern" tabindex="10" name="tire_pattern[]" data="'.$v->tire_pattern.'" value="'.$pattern[$v->tire_pattern]['name'].'" autocomplete="false" >';
                    $str .= '<ul class="size_list_id"></ul></td>';
                    $str .= '<td>Số lượng</td>';
                    $str .= '<td><input  type="text" class="numbers tire_number" tabindex="11" value="'.$v->tire_number.'" name="tire_number[]"  ></td></tr>';
                    $str .= '<tr class="'.$_POST['customer_tire'] .'">';
                    $str .= '<td>Giá chào</td>';
                    $str .= '<td><input  type="text" style="width:90px" class="number tire_price" tabindex="12" value="'.$this->lib->formatMoney($v->tire_price).'" name="tire_price[]"  > <input  type="checkbox"  class="check_vat" '.($v->check_vat==1?'checked':null).'  name="check_vat[]" value="'.$v->check_vat.'" > VAT</td>';
                    $str .= '<td>Hoa hồng </td>';
                    $str .= '<td><input  type="text"  class="number tire_commission" tabindex="13" value="'.$this->lib->formatMoney($v->tire_commission).'" name="tire_commission[]"  ></td>';
                    $str .= '<td>Ghi chú</td>';
                    $str .= '<td><textarea name="comment[]" class="comment" tabindex="14">'.$v->comment.'</textarea></td></tr>';
                    
                    $str .= '</table></td></tr>';
                }
            }

            echo $str;
        }
    }

    public function deletetiretype(){
        if (isset($_POST['data'])) {
            $tire_type = $this->model->get('customertiretypeModel');

            $tire_type->queryCustomer('DELETE FROM customer_tire_type WHERE tire_brand='.$_POST['data'].' AND tire_size='.$_POST['type'].' AND tire_pattern='.$_POST['pattern'].' AND customer_tire='.$_POST['customer']);
        }
    }

    public function delete(){
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $customer = $this->model->get('customertireModel');
            if (isset($_POST['xoa'])) {
                $data = explode(',', $_POST['xoa']);
                foreach ($data as $data) {
                    $customer->deleteCustomer($data);
                        echo "Xóa thành công";

                        date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$data."|customer_tire|"."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                    
                }
                return true;
            }
            else{
                    $customer->deleteCustomer($_POST['data']);
                        echo "Xóa thành công";

                        date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$_POST['data']."|customer_tire|"."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
            }
            
        }
    }

    public function statistic(){
        $this->view->setLayout('admin');
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Thống kê';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $batdau = isset($_POST['batdau']) ? $_POST['batdau'] : null;
            $ketthuc = isset($_POST['ketthuc']) ? $_POST['ketthuc'] : null;
            $vong = isset($_POST['sl_round']) ? $_POST['sl_round'] : null;
            $trangthai = isset($_POST['sl_trangthai']) ? $_POST['sl_trangthai'] : null;
        }
        else{
            $batdau = '01-'.date('m-Y');
            $ketthuc = date('t-m-Y');
            $vong = (int)date('m',strtotime($batdau));
            $trangthai = date('Y',strtotime($batdau));
        }

        $vong = (int)date('m',strtotime($batdau));
        $trangthai = date('Y',strtotime($batdau));

        $customer_model = $this->model->get('customertireModel');
        $user_model = $this->model->get('userModel');
        $salary_model = $this->model->get('newsalaryModel');

        $join = array('table'=>'staff','where'=>'user_id=account');
        $data_user = array(
            'where' => 'user_id IN (SELECT customer_tire_sale FROM customer_tire WHERE customer_tire_date >= '.strtotime($batdau).' AND customer_tire_date <= '.strtotime($ketthuc).')',
        );
        $users = $user_model->getAllUser($data_user,$join);

        $join_salary = array('table'=>'staff, user','where'=>'user_id=account AND staff=staff_id AND new_salary.create_time >= '.strtotime($batdau).' AND new_salary.create_time <= '.strtotime($ketthuc));
        $salarys = $salary_model->getAllSalary($data_user,$join_salary);

        $data_salary = array();
        foreach ($salarys as $salary) {
            $data_salary[$salary->user_id] = $salary->basic_salary;
        }


        $data = array(
            'where' => '(customer_tire_email != "" OR customer_tire_phone != "") AND customer_tire_date >= '.strtotime($batdau).' AND customer_tire_date <= '.strtotime($ketthuc),
        );

        $customers = $customer_model->getAllCustomer($data);
        $sales = array();

        foreach ($customers as $customer) {
            $sales[$customer->customer_tire_sale][$customer->customer_tire_date] = isset($sales[$customer->customer_tire_sale][$customer->customer_tire_date])?$sales[$customer->customer_tire_sale][$customer->customer_tire_date]+1:1;
        }

        $data['where'] .= ' GROUP BY customer_tire_date ORDER BY customer_tire_date ASC';
        $customers = $customer_model->getAllCustomer($data);

        $this->view->data['customers'] = $customers;
        $this->view->data['users'] = $users;
        $this->view->data['data_salary'] = $data_salary;
        $this->view->data['sales'] = $sales;
        $this->view->data['batdau'] = $batdau;
        $this->view->data['ketthuc'] = $ketthuc;
        $this->view->data['vong'] = $vong;
        $this->view->data['trangthai'] = $trangthai;

        $this->view->show('customertire/statistic');

    }

    public function mail(){
        $this->view->disableLayout();
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Gửi mail';

        $customer_model = $this->model->get('customertireModel');

        $data = array(
            'where' => '(customer_tire_email IS NOT NULL AND customer_tire_email != "") ',
        );

        if ($_SESSION['role_logined'] == 3) {
            $data['where'] .= ' AND customer_tire_sale = '.$_SESSION['userid_logined'];
        }

        $customers = $customer_model->getAllCustomer($data);

        $this->view->data['customers'] = $customers;

        $this->view->show('customertire/mail');
    }

    public function postmail(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require "lib/class.phpmailer.php";

            $arrays = $_POST['customer_email'];
            $noidung = trim($_POST['mail_content']);
            $chude = trim($_POST['subject']);
            $usr = trim($_POST['tendangnhap']);
            $pas = trim($_POST['matkhau']);
            $hostname = trim($_POST['hostname']);

            $err = array();

            foreach ($arrays as $arr) {
                // Khai báo tạo PHPMailer
                $mail = new PHPMailer();
                //Khai báo gửi mail bằng SMTP
                $mail->IsSMTP();
                //Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
                // 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
                // 1 = Thông báo lỗi ở client
                // 2 = Thông báo lỗi cả client và lỗi ở server
                $mail->SMTPDebug  = 0;
                 
                $mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
                $mail->Host       = $hostname; //host smtp để gửi mail
                $mail->Port       = 587; // cổng để gửi mail
                $mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
                $mail->SMTPAuth   = true; //Xác thực SMTP
                $mail->CharSet = 'UTF-8';
                $mail->Username   = $usr; // Tên đăng nhập tài khoản Gmail
                $mail->Password   = $pas; //Mật khẩu của gmail
                $mail->SetFrom($usr, "VIET TRADE"); // Thông tin người gửi
                //$mail->AddReplyTo("sale@cmglogistics.com.vn","Sale CMG");// Ấn định email sẽ nhận khi người dùng reply lại.

                $mail->AddAddress($arr, $arr);//Email của người nhận
                $mail->Subject = $chude; //Tiêu đề của thư
                $mail->IsHTML(true); // send as HTML   
                //$mail->AddEmbeddedImage('public/img/christmas.jpg', 'hinhanh');
                $mail->MsgHTML($noidung); //Nội dung của bức thư.
                // $mail->MsgHTML(file_get_contents("email-template.html"), dirname(__FILE__));
                // Gửi thư với tập tin html

                $mail->AltBody = $chude;//Nội dung rút gọn hiển thị bên ngoài thư mục thư.
                //$mail->AddAttachment("images/attact-tui.gif");//Tập tin cần attach
                // For most clients expecting the Priority header:
                // 1 = High, 2 = Medium, 3 = Low
                $mail->Priority = 1;
                // MS Outlook custom header
                // May set to "Urgent" or "Highest" rather than "High"
                $mail->AddCustomHeader("X-MSMail-Priority: High");
                // Not sure if Priority will also set the Importance header:
                $mail->AddCustomHeader("Importance: High"); 

                if(!$mail->Send()){
                    $err[] = array(
                        'email' => $arr,
                        'err' => 1,
                    );
                }
                else{
                    $err[] = array(
                        'email' => $arr,
                        'err' => 0,
                    );
                }
                //Tiến hành gửi email và kiểm tra lỗi
            }

            echo json_encode($err);
        }
    }

    public function sendmail(){
        $customer_model = $this->model->get('customertireModel');
        $user_id = 23;
        $data_customer = array(
            'where' => 'customer_tire_email IS NOT NULL AND customer_tire_sale = '.$user_id,
            'limit' => 50,50,
        );

        $customers = $customer_model->getAllCustomer($data);



        $noidung = "
        <p style='margin:0in;margin-bottom:.0001pt;line-height:18.75pt;background:white'>
        <span style='font-size:10.5pt;font-family:'Arial',sans-serif;color:#3E3E3E'>Kính gửi Quý khách hàng</span>
        <span style='font-size:10.5pt;font-family:'Arial',sans-serif;color:#3E3E3E'><br>
        Nhân dịp Giáng sinh và Năm mới sắp tới, <br>
        Chúng tôi xin trân trọng gửi lời chúc ấm áp của chúng tôi cho kỳ nghỉ lễ sắp tới và xin chúc bạn và gia đình một Giáng sinh vui vẻ và một năm mới thịnh vượng. Chúng tôi cũng muốn nhân cơ hội này để nói lời cảm ơn đến doanh nghiệp của bạn đã đồng hành cùng chúng tôi trong năm vừa qua và mong muốn được tiếp tục hợp tác trong những năm tới.
        </span>
        </p>
        <p style='mso-margin-top-alt:0in;margin-right:0in;margin-bottom:12.0pt;margin-left:0in;line-height:18.75pt;background:white;BOX-SIZING: border-box !important;MIN-HEIGHT: 1em;MAX-WIDTH: 100%;WORD-WRAP: break-word !important;white-space:pre-wrap;-webkit-text-stroke-width: 0px;word-spacing:0px'>
        <span style='font-size:10.5pt;font-family:'Arial',sans-serif;color:#3E3E3E'>
        Merry Christmas and Happy New Year.<br>
        <img width=697 height=488 id='christmas' src='cid:hinhanh'><br>
        </span>
        <b><span style='font-size:10.5pt;font-family:'Arial',sans-serif;color:#3E3E3E'>
        Best regards,
        </span></b>
        <b><span style='font-family:'Arial',sans-serif;color:#3E3E3E'>Sale Team<br></span></b>
        <span style='font-size:11.0pt;font-family:'Arial',sans-serif;color:#666666'>Mobile: 0937 131 845</span>
        <span style='font-size:11.0pt;font-family:'Arial',sans-serif;color:#666666'>Hotline: 083 500 9000</span>
        <span style='font-size:11.0pt;font-family:'Arial',sans-serif;color:#4E8FCD'>Email: 
        <a href='mailto:lopxe@viet-trade.org'>lopxe@viet-trade.org</a></span>
        </p>
        ";
        
        // Khai báo thư viên phpmailer
            require "lib/class.phpmailer.php";
             
            foreach ($customers as $customer) {
                // Khai báo tạo PHPMailer
                $mail = new PHPMailer();
                //Khai báo gửi mail bằng SMTP
                $mail->IsSMTP();
                //Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
                // 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
                // 1 = Thông báo lỗi ở client
                // 2 = Thông báo lỗi cả client và lỗi ở server
                $mail->SMTPDebug  = 0;
                 
                $mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
                $mail->Host       = "smtp.zoho.com"; //host smtp để gửi mail
                $mail->Port       = 587; // cổng để gửi mail
                $mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
                $mail->SMTPAuth   = true; //Xác thực SMTP
                $mail->CharSet = 'UTF-8';
                $mail->Username   = "nghi.nguyen@viet-trade.org"; // Tên đăng nhập tài khoản Gmail
                $mail->Password   = "nghinguyen!@#$"; //Mật khẩu của gmail
                $mail->SetFrom("nghi.nguyen@viet-trade.org", "VIET TRADE"); // Thông tin người gửi
                //$mail->AddReplyTo("sale@cmglogistics.com.vn","Sale CMG");// Ấn định email sẽ nhận khi người dùng reply lại.

                $mail->AddAddress($customer->customer_tire_email, $customer_tire_contact);//Email của người nhận
                $mail->Subject = "MERRY CHRISTMAS & HAPPY NEW YEAR - VIET TRADE"; //Tiêu đề của thư
                $mail->IsHTML(true); // send as HTML   
                $mail->AddEmbeddedImage('public/img/christmas.jpg', 'hinhanh');
                $mail->MsgHTML($noidung); //Nội dung của bức thư.
                // $mail->MsgHTML(file_get_contents("email-template.html"), dirname(__FILE__));
                // Gửi thư với tập tin html

                $mail->AltBody = "MERRY CHRISTMAS & HAPPY NEW YEAR - VIET TRADE";//Nội dung rút gọn hiển thị bên ngoài thư mục thư.
                //$mail->AddAttachment("images/attact-tui.gif");//Tập tin cần attach
                // For most clients expecting the Priority header:
                // 1 = High, 2 = Medium, 3 = Low
                $mail->Priority = 1;
                // MS Outlook custom header
                // May set to "Urgent" or "Highest" rather than "High"
                $mail->AddCustomHeader("X-MSMail-Priority: High");
                // Not sure if Priority will also set the Importance header:
                $mail->AddCustomHeader("Importance: High"); 
                $mail->Send();
                //Tiến hành gửi email và kiểm tra lỗi
            }

            
    }

    public function importsendmail(){
        $this->view->disableLayout();
        header('Content-Type: text/html; charset=utf-8');
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_FILES['import']['name'] != null) {

            require("lib/Classes/PHPExcel/IOFactory.php");
            require("lib/Classes/PHPExcel.php");

            $customer = $this->model->get('customertireModel');

            $objPHPExcel = new PHPExcel();
            // Set properties
            if (pathinfo($_FILES['import']['name'], PATHINFO_EXTENSION) == "xls") {
                $objReader = PHPExcel_IOFactory::createReader('Excel5');
            }
            else if (pathinfo($_FILES['import']['name'], PATHINFO_EXTENSION) == "xlsx") {
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            }
            
            $objReader->setReadDataOnly(false);

            $objPHPExcel = $objReader->load($_FILES['import']['tmp_name']);
            $objWorksheet = $objPHPExcel->getActiveSheet();

            

            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

            //var_dump($objWorksheet->getMergeCells());die();
            
             require "lib/class.phpmailer.php";

                for ($row = 3; $row <= $highestRow; ++ $row) {
                    $val = array();
                    for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                        $cell = $objWorksheet->getCellByColumnAndRow($col, $row);
                        // Check if cell is merged
                        foreach ($objWorksheet->getMergeCells() as $cells) {
                            if ($cell->isInRange($cells)) {
                                $currMergedCellsArray = PHPExcel_Cell::splitRange($cells);
                                $cell = $objWorksheet->getCell($currMergedCellsArray[0][0]);
                                break;
                                
                            }
                        }
                        //$val[] = $cell->getValue();
                        $val[] = is_numeric($cell->getCalculatedValue()) ? round($cell->getCalculatedValue()) : $cell->getCalculatedValue();
                        //here's my prob..
                        //echo $val;
                    }
                    if ($val[7] != null  ) {

                        
                        $noidung = "
                        <p style='margin:0in;margin-bottom:.0001pt;line-height:18.75pt;background:white'>
                        <span style='font-size:10.5pt;font-family:'Arial',sans-serif;color:#3E3E3E'>Kính gửi Quý khách hàng</span>
                        <span style='font-size:10.5pt;font-family:'Arial',sans-serif;color:#3E3E3E'><br>
                        Nhân dịp Giáng sinh và Năm mới sắp tới, <br>
                        Chúng tôi xin trân trọng gửi lời chúc ấm áp của chúng tôi cho kỳ nghỉ lễ sắp tới và xin chúc bạn và gia đình một Giáng sinh vui vẻ và một năm mới thịnh vượng. Chúng tôi cũng muốn nhân cơ hội này để nói lời cảm ơn đến doanh nghiệp của bạn đã đồng hành cùng chúng tôi trong năm vừa qua và mong muốn được tiếp tục hợp tác trong những năm tới.
                        </span>
                        </p>
                        <p style='mso-margin-top-alt:0in;margin-right:0in;margin-bottom:12.0pt;margin-left:0in;line-height:18.75pt;background:white;BOX-SIZING: border-box !important;MIN-HEIGHT: 1em;MAX-WIDTH: 100%;WORD-WRAP: break-word !important;white-space:pre-wrap;-webkit-text-stroke-width: 0px;word-spacing:0px'>
                        <span style='font-size:10.5pt;font-family:'Arial',sans-serif;color:#3E3E3E'>
                        Merry Christmas and Happy New Year.<br>
                        <img width=697 height=488 id='christmas' src='cid:hinhanh'><br>
                        </span>
                        <b><span style='font-size:10.5pt;font-family:'Arial',sans-serif;color:#3E3E3E'>
                        Best regards,
                        </span></b>
                        <b><span style='font-family:'Arial',sans-serif;color:#3E3E3E'>Sale Team<br></span></b>
                        <span style='font-size:11.0pt;font-family:'Arial',sans-serif;color:#666666'>Mobile: 0931 298 189 - 0933 235 815 - 0937 131 845</span>
                        <span style='font-size:11.0pt;font-family:'Arial',sans-serif;color:#666666'>Hotline: 083 500 9000</span>
                        <span style='font-size:11.0pt;font-family:'Arial',sans-serif;color:#4E8FCD'>Email: 
                        <a href='mailto:lopxe@viet-trade.org'>lopxe@viet-trade.org</a></span>
                        <span style='font-size:11.0pt;font-family:'Arial',sans-serif;color:#4E8FCD'>Website: 
                        <a href='http://www.viet-trade.org'>www.viet-trade.org</a></span>
                        </p>
                        ";

                        

                        // Khai báo tạo PHPMailer
                        $mail = new PHPMailer();
                        //Khai báo gửi mail bằng SMTP
                        $mail->IsSMTP();
                        //Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
                        // 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
                        // 1 = Thông báo lỗi ở client
                        // 2 = Thông báo lỗi cả client và lỗi ở server
                        $mail->SMTPDebug  = 0;
                         
                        $mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
                        $mail->Host       = "smtp.zoho.com"; //host smtp để gửi mail
                        $mail->Port       = 587; // cổng để gửi mail
                        $mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
                        $mail->SMTPAuth   = true; //Xác thực SMTP
                        $mail->CharSet = 'UTF-8';
                        $mail->Username   = "lopxe@viet-trade.org"; // Tên đăng nhập tài khoản Gmail
                        $mail->Password   = "lopxe!@#$"; //Mật khẩu của gmail
                        $mail->SetFrom("lopxe@viet-trade.org", "VIET TRADE"); // Thông tin người gửi
                        //$mail->AddReplyTo("sale@cmglogistics.com.vn","Sale CMG");// Ấn định email sẽ nhận khi người dùng reply lại.

                        $mail->AddAddress(trim($val[7]), trim($val[1]));//Email của người nhận
                        $mail->Subject = "MERRY CHRISTMAS & HAPPY NEW YEAR - VIET TRADE"; //Tiêu đề của thư
                        $mail->IsHTML(true); // send as HTML   
                        $mail->AddEmbeddedImage('public/img/christmas.jpg', 'hinhanh');
                        $mail->MsgHTML($noidung); //Nội dung của bức thư.
                        // $mail->MsgHTML(file_get_contents("email-template.html"), dirname(__FILE__));
                        // Gửi thư với tập tin html

                        $mail->AltBody = "MERRY CHRISTMAS & HAPPY NEW YEAR - VIET TRADE";//Nội dung rút gọn hiển thị bên ngoài thư mục thư.
                        //$mail->AddAttachment("images/attact-tui.gif");//Tập tin cần attach
                        // For most clients expecting the Priority header:
                        // 1 = High, 2 = Medium, 3 = Low
                        $mail->Priority = 1;
                        // MS Outlook custom header
                        // May set to "Urgent" or "Highest" rather than "High"
                        $mail->AddCustomHeader("X-MSMail-Priority: High");
                        // Not sure if Priority will also set the Importance header:
                        $mail->AddCustomHeader("Importance: High"); 
                        $mail->Send();
                        //Tiến hành gửi email và kiểm tra lỗi

                        
                    }
                    
                    //var_dump($this->getNameDistrict($this->lib->stripUnicode($val[1])));
                    // insert


                }
                //return $this->view->redirect('transport');
            
            return $this->view->redirect('customertire');
        }
        $this->view->show('customertire/importsendmail');

    }

    public function pdf(){
        require "lib/class.phpmailer.php";
        require("lib/Classes/tcpdf/tcpdf.php");

        $customer_model = $this->model->get('customertireModel');
        $customers = $customer_model->getAllCustomer(array('limit'=>5));

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Ngô Tôn');
        $pdf->SetTitle('Bảng báo giá');
        $pdf->SetSubject('BÁO GIÁ');
        $pdf->SetKeywords('Viet Trade, tire');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(11, PDF_MARGIN_TOP, 11);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

        $pdf->SetFont('freeserif', '', 9);
        $pdf->AddPage();

        $left_cell_width = 60;
        $row_height = 6;

        $pdf->Image(BASE_URL . '/public/img/banggia.png', 0, 5, null, 16, null, null, 'N', false, null,'L');
        $pdf->Ln('3');

        $html = '<html>
                <head></head>
                <body><table border="1" cellpadding="5">
                <tr><th>Tên</th>
                <th>số điện thoại</th></tr>
                <tr>
                <td>hello</td>
                <td>xx technologies</td>
                </tr>
                </table>
                </body>
                </html>';

        $pdf->writeHTML($html, true, false, true, false, '');

        $filename = "baogia.pdf";

        $pdf->Output($filename, 'F'); // save the pdf under filename

        // Khai báo tạo PHPMailer
        $mail = new PHPMailer();
        //Khai báo gửi mail bằng SMTP
        $mail->IsSMTP();
        //Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
        // 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
        // 1 = Thông báo lỗi ở client
        // 2 = Thông báo lỗi cả client và lỗi ở server
        $mail->SMTPDebug  = 0;
         
        $mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
        $mail->Host       = "smtp.zoho.com"; //host smtp để gửi mail
        $mail->Port       = 587; // cổng để gửi mail
        $mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
        $mail->SMTPAuth   = true; //Xác thực SMTP
        $mail->CharSet = 'UTF-8';
        $mail->Username   = "lopxe@viet-trade.org"; // Tên đăng nhập tài khoản Gmail
        $mail->Password   = "lopxe!@#$"; //Mật khẩu của gmail
        $mail->SetFrom("lopxe@viet-trade.org", "VIET TRADE"); // Thông tin người gửi
        //$mail->AddReplyTo("sale@cmglogistics.com.vn","Sale CMG");// Ấn định email sẽ nhận khi người dùng reply lại.

        $pdf_content = file_get_contents($filename);

        $mail->AddAddress('ngoton.it@gmail.com', 'Ngô Tôn');//Email của người nhận
        $mail->Subject = "MERRY CHRISTMAS & HAPPY NEW YEAR - VIET TRADE"; //Tiêu đề của thư
        $mail->IsHTML(true); // send as HTML   
        $mail->AddStringAttachment($pdf_content, "baogia.pdf", "base64", "application/pdf");  // note second item is name of emailed pdf
        $mail->AddEmbeddedImage('public/img/christmas.jpg', 'hinhanh');
        $mail->MsgHTML($html); //Nội dung của bức thư.
        // $mail->MsgHTML(file_get_contents("email-template.html"), dirname(__FILE__));
        // Gửi thư với tập tin html

        $mail->AltBody = "MERRY CHRISTMAS & HAPPY NEW YEAR - VIET TRADE";//Nội dung rút gọn hiển thị bên ngoài thư mục thư.
        //$mail->AddAttachment("images/attact-tui.gif");//Tập tin cần attach
        // For most clients expecting the Priority header:
        // 1 = High, 2 = Medium, 3 = Low
        $mail->Priority = 1;
        // MS Outlook custom header
        // May set to "Urgent" or "Highest" rather than "High"
        $mail->AddCustomHeader("X-MSMail-Priority: High");
        // Not sure if Priority will also set the Importance header:
        $mail->AddCustomHeader("Importance: High"); 
        $mail->Send();
        //Tiến hành gửi email và kiểm tra lỗi

        unlink($filename); // this will delete the file off of server

    }

    public function import(){
        $this->view->disableLayout();
        header('Content-Type: text/html; charset=utf-8');
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_FILES['import']['name'] != null) {

            require("lib/Classes/PHPExcel/IOFactory.php");
            require("lib/Classes/PHPExcel.php");

            $customer = $this->model->get('customertireModel');

            $objPHPExcel = new PHPExcel();
            // Set properties
            if (pathinfo($_FILES['import']['name'], PATHINFO_EXTENSION) == "xls") {
                $objReader = PHPExcel_IOFactory::createReader('Excel5');
            }
            else if (pathinfo($_FILES['import']['name'], PATHINFO_EXTENSION) == "xlsx") {
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            }
            
            $objReader->setReadDataOnly(false);

            $objPHPExcel = $objReader->load($_FILES['import']['tmp_name']);
            $objWorksheet = $objPHPExcel->getActiveSheet();

            

            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

            //var_dump($objWorksheet->getMergeCells());die();
            
             

                for ($row = 2; $row <= $highestRow; ++ $row) {
                    $val = array();
                    for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                        $cell = $objWorksheet->getCellByColumnAndRow($col, $row);
                        // Check if cell is merged
                        foreach ($objWorksheet->getMergeCells() as $cells) {
                            if ($cell->isInRange($cells)) {
                                $currMergedCellsArray = PHPExcel_Cell::splitRange($cells);
                                $cell = $objWorksheet->getCell($currMergedCellsArray[0][0]);
                                break;
                                
                            }
                        }
                        //$val[] = $cell->getValue();
                        $val[] = is_numeric($cell->getCalculatedValue()) ? round($cell->getCalculatedValue()) : $cell->getCalculatedValue();
                        //here's my prob..
                        //echo $val;
                    }
                    if ($val[0] != null  ) {

                        
                            if(!$customer->getCustomerByWhere(array('customer_name'=>trim($val[0])))) {
                                $customer_data = array(
                                'customer_name' => trim($val[0]),
                                'company_name' => trim($val[1]),
                                'co_name' => trim($val[0]),
                                'mst' => trim($val[2]),
                                'customer_address' => trim($val[3]),
                                'customer_phone' => trim($val[4]),
                                );
                                $customer->createCustomer($customer_data);
                            }
                            else if($customer->getCustomerByWhere(array('customer_name'=>trim($val[0])))){
                                $id_customer = $customer->getCustomerByWhere(array('customer_serie'=>trim($val[0])))->customer_id;
                                $customer_data = array(
                                'company_name' => trim($val[1]),
                                'co_name' => trim($val[0]),
                                'mst' => trim($val[2]),
                                'customer_address' => trim($val[3]),
                                'customer_phone' => trim($val[4]),
                                );
                                $customer->updateCustomer($customer_data,array('customer_id' => $id_customer));
                            }


                        
                    }
                    
                    //var_dump($this->getNameDistrict($this->lib->stripUnicode($val[1])));
                    // insert


                }
                //return $this->view->redirect('transport');
            
            return $this->view->redirect('customer');
        }
        $this->view->show('customertire/import');

    }

    public function getCustomer($id){
        return $this->getByID($this->table,$id);
    }

    private function getUrl(){

    }


}
?>