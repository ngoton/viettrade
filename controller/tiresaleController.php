<?php
Class tiresaleController Extends baseController {
    public function index() {
        $this->view->setLayout('admin');
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Lốp xe';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;
            $order = isset($_POST['order']) ? $_POST['order'] : null;
            $page = isset($_POST['page']) ? $_POST['page'] : null;
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;
            $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;
            $ngay = isset($_POST['ketthuc']) ? $_POST['ketthuc'] : null;
            $code = isset($_POST['batdau']) ? $_POST['batdau'] : null;
            $thuonghieu = isset($_POST['ngaytao']) ? $_POST['ngaytao'] : null;
            $size = isset($_POST['ngaytaobatdau']) ? $_POST['ngaytaobatdau'] : null;
            $kh = isset($_POST['trangthai']) ? $_POST['trangthai'] : null;
        }
        else{
            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'code';
            $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';
            $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;
            $keyword = "";
            $limit = 50;
            $ngay = "";
            $code = "";
            $thuonghieu = 0;
            $size = 0;
            $kh = 0;
        }

        
        $tire_brand_model = $this->model->get('tirebrandModel');
        $tire_size_model = $this->model->get('tiresizeModel');
        $tire_sale_model = $this->model->get('tiresaleModel');
        $tire_price_model = $this->model->get('tirepriceModel');
        $tire_excess_model = $this->model->get('tireexcessModel');
        $tire_ocean_freight_model = $this->model->get('tireoceanfreightModel');

        $chonngay = $this->registry->router->param_id;

        $tire_pattern_model = $this->model->get('tirepatternModel');
        $customer_model = $this->model->get('customerModel');

        $tire_brands = $tire_brand_model->getAllTire();
        $tire_sizes = $tire_size_model->getAllTire();
        $tire_patterns = $tire_pattern_model->getAllTire();
        $customers = $customer_model->getAllCustomer(array(
            'order_by'=> 'customer_name',
            'order'=> 'ASC',
            ));

        $this->view->data['tire_brands'] = $tire_brands;
        $this->view->data['tire_sizes'] = $tire_sizes;
        $this->view->data['tire_patterns'] = $tire_patterns;
        $this->view->data['customers'] = $customers;

        $join = array('table'=>'tire_brand, tire_size, tire_pattern','where'=>'tire_brand.tire_brand_id = tire_buy.tire_buy_brand AND tire_size.tire_size_id = tire_buy.tire_buy_size AND tire_pattern.tire_pattern_id = tire_buy.tire_buy_pattern');

        $tire_buy_model = $this->model->get('tirebuyModel');
        $sonews = $limit;
        $x = ($page-1) * $sonews;
        $pagination_stages = 2;
        
        $data = array(
            'where' => '1=1',
        );

        if ($chonngay != "") {
            $ngay = date('d-m-Y',$chonngay);
        }

        if ($ngay != "") {
            $data['where'] .= ' AND tire_buy_date > '.strtotime("-1 day",$chonngay).' AND tire_buy_date < '.strtotime("+1 day",$chonngay);
        }

        if ($code != "") {
            $data['where'] .= ' AND code = '.$code;
        }

        if ($kh > 0) {
            $data['where'] .= ' AND customer = '.$kh;
        }

        if ($thuonghieu > 0) {
            $data['where'] .= ' AND tire_buy_brand = '.$thuonghieu;
        }

        if ($size > 0) {
            $data['where'] .= ' AND tire_buy_size = '.$size;
        }
        
        
        $tongsodong = count($tire_buy_model->getAllTire($data,$join));
        $tongsotrang = ceil($tongsodong / $sonews);
        

        $this->view->data['page'] = $page;
        $this->view->data['order_by'] = $order_by;
        $this->view->data['order'] = $order;
        $this->view->data['keyword'] = $keyword;
        $this->view->data['pagination_stages'] = $pagination_stages;
        $this->view->data['tongsotrang'] = $tongsotrang;
        $this->view->data['limit'] = $limit;
        $this->view->data['sonews'] = $sonews;
        $this->view->data['ngay'] = $ngay;
        $this->view->data['code'] = $code;
        $this->view->data['kh'] = $kh;
        $this->view->data['thuonghieu'] = $thuonghieu;
        $this->view->data['size'] = $size;

        $data = array(
            'order_by'=>$order_by,
            'order'=>$order,
            'limit'=>$x.','.$sonews,
            'where' => '1=1',
            );
        if ($chonngay != "") {
            $ngay = date('d-m-Y',$chonngay);
        }

        if ($ngay != "") {
            $data['where'] .= ' AND tire_buy_date > '.strtotime("-1 day",$chonngay).' AND tire_buy_date < '.strtotime("+1 day",$chonngay);
        }

        if ($code != "") {
            $data['where'] .= ' AND code = '.$code;
        }

        if ($kh > 0) {
            $data['where'] .= ' AND customer = '.$kh;
        }

        if ($thuonghieu > 0) {
            $data['where'] .= ' AND tire_buy_brand = '.$thuonghieu;
        }

        if ($size > 0) {
            $data['where'] .= ' AND tire_buy_size = '.$size;
        }
      
        if ($keyword != '') {
            $search = '( code LIKE "%'.$keyword.'%" 
                OR tire_brand_name LIKE "%'.$keyword.'%" 
                OR tire_size_number LIKE "%'.$keyword.'%" )';
            
                $data['where'] = $data['where'].' AND '.$search;
        }

        
        $tire_buys = $tire_buy_model->getAllTire($data,$join);
        $tire_buy_data = array();

        $sell = array();

        $tire_product_model = $this->model->get('tireproductModel');
        $link_picture = array();
        
        foreach ($tire_buys as $tire_buy) {

            $tire_products = $tire_product_model->queryTire('SELECT tire_product_thumb FROM tire_product, tire_product_pattern WHERE tire_pattern = tire_product_pattern_id AND tire_product_pattern_name LIKE "%'.$tire_buy->tire_pattern_name.'%"');

            foreach ($tire_products as $tire_product) {
                $link_picture[$tire_buy->tire_buy_id]['image'] = $tire_product->tire_product_thumb;
            }

            $tongsl = 0;
            $price = array();

            if ($tire_buy->code > 0) {
                $datas = array(
                    'where'=>'code='.$tire_buy->code,
                );
            }
            
            $tire_buy_datas = $tire_buy_model->getAllTire($datas);

            foreach ($tire_buy_datas as $b) {
                $tongsl += $b->tire_buy_volume;
            }

            $data_sale = array(
                'where'=>'code='.$tire_buy->code.' AND tire_brand='.$tire_buy->tire_buy_brand.' AND tire_size='.$tire_buy->tire_buy_size.' AND tire_pattern='.$tire_buy->tire_buy_pattern,
            );
            $tire_sales = $tire_sale_model->getAllTire($data_sale);

            $price['income'] = 0;

            foreach ($tire_sales as $tire_sale) {
                $price['income'] = isset($price['income'])?($price['income']+($tire_sale->volume*$tire_sale->sell_price)):($tire_sale->volume*$tire_sale->sell_price);
                
                if ($tire_sale->customer != 119) {
                    $sell[$tire_buy->tire_buy_id]['number'] = isset($sell[$tire_buy->tire_buy_id]['number'])?$sell[$tire_buy->tire_buy_id]['number']+$tire_sale->volume:$tire_sale->volume;
                }
                
            }

            $tire_buy_data[$tire_buy->tire_buy_id]['revenue'] = $price['income'];

            $w = array(
                'where' => 'tire_brand='.$tire_buy->tire_buy_brand.' AND tire_size='.$tire_buy->tire_buy_size.' AND tire_pattern='.$tire_buy->tire_buy_pattern.' AND price_start_time <= '.$tire_buy->tire_buy_date.' AND price_end_time >= '.$tire_buy->tire_buy_date,
            );
            $tire_prices = $tire_price_model->getAllTire($w);
            foreach ($tire_prices as $tire) {
                $income = ($tire->tax_price)*0.25;
                $vat = ($income+$tire->tax_price)*0.1;
                $tax = $income+$vat;
                $customs = (($tire->custom_price-$tire->tax_price)*0.25)/2;
                $price['shipper'] = isset($price['shipper'])?($price['shipper']+($tire_buy->tire_buy_volume*($tire->tax_price))):($tire_buy->tire_buy_volume*($tire->tax_price));
                $price['solow'] = isset($price['solow'])?($price['solow']+($tire_buy->tire_buy_volume*(($tire->supply_price-$tire->tax_price)))):($tire_buy->tire_buy_volume*(($tire->supply_price-$tire->tax_price)));
            }
            

            $price['tax_amount'] = isset($price['tax_amount'])?($price['tax_amount']+($tire_buy->tire_buy_volume*($tax))):($tire_buy->tire_buy_volume*($tax));
            $price['customs_amount'] = isset($price['customs_amount'])?($price['customs_amount']+($tire_buy->tire_buy_volume*($customs))):($tire_buy->tire_buy_volume*($customs));
            
            $price['stevedore'] = isset($price['stevedore'])?($price['stevedore']+($tire_buy->tire_buy_volume*(0.5))):($tire_buy->tire_buy_volume*(0.5));
            $price['rate'] = $tire_buy->rate;
            $price['rate_shipper'] = $tire_buy->rate_shipper;

            if ($tongsl > 120) {
                $price['lift'] = 1010000*$tire_buy->tire_buy_volume/$tongsl;
                $price['local_charge'] = 218*$tire_buy->tire_buy_volume/$tongsl;

                $o = array(
                    'where' => 'feet=2 AND tire_ocean_freight_start_time <= '.$tire_buy->tire_buy_date.' AND tire_ocean_freight_end_time >= '.$tire_buy->tire_buy_date,
                );
                $tire_ocean_freights = $tire_ocean_freight_model->getAllTire($o);

                foreach ($tire_ocean_freights as $tire) {
                    $price['ocean_freight'] = $tire->tire_ocean_freight*$tire_buy->tire_buy_volume/$tongsl;
                }
            }
            elseif ($tongsl > 0 && $tongsl <= 120) {
                $price['lift'] = 665000*$tire_buy->tire_buy_volume/$tongsl;
                $price['local_charge'] = 157*$tire_buy->tire_buy_volume/$tongsl;

                $o = array(
                    'where' => 'feet=1 AND tire_ocean_freight_start_time <= '.$tire_buy->tire_buy_date.' AND tire_ocean_freight_end_time >= '.$tire_buy->tire_buy_date,
                );
                $tire_ocean_freights = $tire_ocean_freight_model->getAllTire($o);

                foreach ($tire_ocean_freights as $tire) {
                    $price['ocean_freight'] = $tire->tire_ocean_freight*$tire_buy->tire_buy_volume/$tongsl;
                }
            }

            $data_cost = array(
                'where' => '(customer IS NULL OR customer <= 0) AND code='.$tire_buy->code.' AND tire_excess_brand='.$tire_buy->tire_buy_brand.' AND tire_excess_size='.$tire_buy->tire_buy_size.' AND tire_excess_pattern='.$tire_buy->tire_buy_pattern,
            );
            $join_cost = array('table'=>'tire_excess_type','where'=>'tire_excess.tire_excess_type = tire_excess_type.tire_excess_type_id');

            $costs = $tire_excess_model->getAllTire($data_cost,$join_cost);
            

            ////
            $total = $price['shipper']*$price['rate_shipper'];
            $total += ($price['solow']*$price['rate'])*1.1;
            $total_kvat = $price['solow']*$price['rate'];
            $total += round(($price['shipper']*$price['rate_shipper'])*0.002 + ($price['solow']*$price['rate'])*0.0005);
            $total += round(33*$price['rate']*$tire_buy->tire_buy_volume/$tongsl);
            $total += $price['ocean_freight']*$price['rate'];
            $total += $price['local_charge']*$price['rate'];
            $tax_amount = ($price['shipper']+$price['ocean_freight'])*0.25+($price['shipper']+$price['ocean_freight']+(($price['shipper']+$price['ocean_freight'])*0.25))*0.1;
            $total += round($tax_amount*$price['rate']);
            $total += $price['lift'];
            $total += ($price['stevedore']*$price['rate'])*1.1;
            $total_kvat += $price['stevedore']*$price['rate'];
            $total += (3500000*$tire_buy->tire_buy_volume/$tongsl)*1.1;
            $total_kvat += 3500000*$tire_buy->tire_buy_volume/$tongsl;
            $tongps = 0; $tongkvat=0;
            foreach ($costs as $cost) { 
                $tongps += $cost->tire_excess*1.1+$cost->tire_excess_vat;
                $tongkvat += $cost->tire_excess;
            }

            $thue = round($tongkvat*0.1);
            $tongps += $thue;

            $tire_buy_data[$tire_buy->tire_buy_id]['cost'] = round($total+$tongps);
           

        }


        $this->view->data['tire_buy_data'] = $tire_buy_data;
        $this->view->data['sell'] = $sell;

        $this->view->data['link_picture'] = $link_picture;
        
        $this->view->data['tire_buys'] = $tire_buys;
        $this->view->data['lastID'] = isset($tire_buy_model->getLastTire()->tire_buy_id)?$tire_buy_model->getLastTire()->tire_buy_id:0;

        /* Lấy tổng doanh thu*/
        
        /*************/
        $this->view->show('tiresale/index');
    }

   
   
    public function add(){
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        if (isset($_POST['yes'])) {
            
            $tire_buy_model = $this->model->get('tirebuyModel');
            $data = array(
                        
                        'code' => trim($_POST['code']),
                        'tire_buy_volume' => trim($_POST['tire_buy_volume']),
                        'tire_buy_brand' => trim($_POST['tire_buy_brand']),
                        'tire_buy_size' => trim($_POST['tire_buy_size']),
                        'rate' => trim(str_replace(',','',$_POST['rate'])),
                        'rate_shipper' => trim(str_replace(',','',$_POST['rate_shipper'])),
                        'date_solow' => strtotime($_POST['date_solow']),
                        'date_shipper' => strtotime($_POST['date_shipper']),
                        'tire_buy_date' => strtotime($_POST['tire_buy_date']),
                        );
            if (trim($_POST['tire_buy_pattern']) == "" && trim($_POST['tire_pattern_name']) != "") {
                $tire_pattern_model = $this->model->get('tirepatternModel');
                if($tire_pattern_model->getTireByWhere(array('tire_pattern_name' => trim($_POST['tire_pattern_name'])))){
                    $data['tire_buy_pattern'] = $tire_pattern_model->getTireByWhere(array('tire_pattern_name' => trim($_POST['tire_pattern_name'])))->tire_pattern_id;
                }
                else{
                    $data_pattern = array(
                        'tire_pattern_name' => trim($_POST['tire_pattern_name']),
                    );
                    $tire_pattern_model->createTire($data_pattern);
                    $data['tire_buy_pattern'] = $tire_pattern_model->getLastTire()->tire_pattern_id;
                }
                
            }
            elseif (trim($_POST['tire_buy_pattern']) != "") {
                $data['tire_buy_pattern'] = trim($_POST['tire_buy_pattern']);
            }

            if ($_POST['yes'] != "") {
                


                    $tire_buy_model->updateTire($data,array('tire_buy_id' => trim($_POST['yes'])));
                    echo "Cập nhật thành công";

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|tire_buy|".implode("-",$data)."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                
                
            }
            else{
                
                
                    $tire_buy_model->createTire($data);
                    echo "Thêm thành công";

                 

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$tire_buy_model->getLastTire()->tire_buy_id."|tire_buy|".implode("-",$data)."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                
                
            }
                    
        }
    }

    public function delete(){
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tire_buy_model = $this->model->get('tirebuyModel');
           
            if (isset($_POST['xoa'])) {
                $data = explode(',', $_POST['xoa']);
                foreach ($data as $data) {
                       $tire_buy_model->deleteTire($data);
                        echo "Xóa thành công";
                        date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$data."|tire_buy|"."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                    
                    
                }
                return true;
            }
            else{
                        $tire_buy_model->deleteTire($_POST['data']);
                        echo "Xóa thành công";
                        date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$_POST['data']."|tire_buy|"."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                    
            }
            
        }
    }

    public function view() {
        $this->view->setLayout('admin');
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        
        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Lốp xe';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;
            $order = isset($_POST['order']) ? $_POST['order'] : null;
            $page = isset($_POST['page']) ? $_POST['page'] : null;
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;
            $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;
        }
        else{
            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_sale_date';
            $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'DESC';
            $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;
            $keyword = "";
            $limit = 50;
        }

        $code = $this->registry->router->param_id;
        $brand = $this->registry->router->page;
        $size = $this->registry->router->order_by;
        $pattern = $this->registry->router->order;

        $this->view->data['code'] = $code;
        $this->view->data['tire_pattern'] = $pattern;

        $staff_model = $this->model->get('staffModel');
        $staffs = $staff_model->getAllStaff(array('order_by'=>'staff_name','order'=>'ASC'));
        $this->view->data['staffs'] = $staffs;
        foreach ($staffs as $staff) {
            $staff_data[$staff->staff_id]['name'] = $staff->staff_name;
        }
        $this->view->data['staff_data'] = $staff_data;

        $tire_buy_model = $this->model->get('tirebuyModel');
        $tire_brand_model = $this->model->get('tirebrandModel');
        $tire_size_model = $this->model->get('tiresizeModel');
        $tire_pattern_model = $this->model->get('tirepatternModel');

        $tire_patterns = $tire_pattern_model->getTire($pattern);
        $this->view->data['tire_pattern_name'] = $tire_patterns->tire_pattern_name;

        $tire_brands = $tire_brand_model->getAllTire(array('where'=>'tire_brand_id='.$brand));
        $tire_sizes = $tire_size_model->getAllTire(array('where'=>'tire_size_id='.$size));

        $this->view->data['tire_brands'] = $tire_brands;
        $this->view->data['tire_sizes'] = $tire_sizes;

        $join = array('table'=>'tire_brand, tire_size, customer, tire_pattern','where'=>'tire_sale.customer=customer.customer_id AND tire_brand.tire_brand_id = tire_sale.tire_brand AND tire_size.tire_size_id = tire_sale.tire_size AND tire_pattern.tire_pattern_id = tire_sale.tire_pattern');

        $tire_sale_model = $this->model->get('tiresaleModel');
        $sonews = $limit;
        $x = ($page-1) * $sonews;
        $pagination_stages = 2;
        
        $data = array(
            'where' => 'code='.$code.' AND tire_brand='.$brand.' AND tire_size='.$size.' AND tire_pattern='.$pattern,
        );
        
        
        $tongsodong = count($tire_sale_model->getAllTire($data,$join));
        $tongsotrang = ceil($tongsodong / $sonews);
        

        $this->view->data['page'] = $page;
        $this->view->data['order_by'] = $order_by;
        $this->view->data['order'] = $order;
        $this->view->data['keyword'] = $keyword;
        $this->view->data['pagination_stages'] = $pagination_stages;
        $this->view->data['tongsotrang'] = $tongsotrang;
        $this->view->data['limit'] = $limit;
        $this->view->data['sonews'] = $sonews;

        $data = array(
            
            'where' => 'code='.$code.' AND tire_brand='.$brand.' AND tire_size='.$size.' AND tire_pattern='.$pattern,
            );
        
      
        if ($keyword != '') {
            $search = '( code LIKE "%'.$keyword.'%" 
                OR tire_brand_name LIKE "%'.$keyword.'%" 
                OR tire_size_number LIKE "%'.$keyword.'%" )';
            
                $data['where'] = $data['where'].' AND '.$search;
        }

        

        
        $this->view->data['tire_sales'] = $tire_sale_model->getAllTire($data,$join);
        $this->view->data['lastID'] = isset($tire_sale_model->getLastTire()->tire_sale_id)?$tire_sale_model->getLastTire()->tire_sale_id:0;

        /* Lấy tổng doanh thu*/
        
        /*************/
        $this->view->show('tiresale/view');
    }

    public function sale() {
        $this->view->setLayout('admin');
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        
        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Lốp xe';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;
            $order = isset($_POST['order']) ? $_POST['order'] : null;
            $page = isset($_POST['page']) ? $_POST['page'] : null;
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;
            $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;
            $ngay = isset($_POST['ketthuc']) ? $_POST['ketthuc'] : null;
            $code = isset($_POST['batdau']) ? $_POST['batdau'] : null;
            $thuonghieu = isset($_POST['ngaytao']) ? $_POST['ngaytao'] : null;
            $size = isset($_POST['ngaytaobatdau']) ? $_POST['ngaytaobatdau'] : null;
            $kh = isset($_POST['trangthai']) ? $_POST['trangthai'] : null;
        }
        else{
            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_sale_date';
            $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'DESC';
            $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;
            $keyword = "";
            $limit = 50;
            $ngay = "";
            $code = "";
            $thuonghieu = 0;
            $size = 0;
            $kh = 0;
        }

        $chonngay = $this->registry->router->param_id;

        $staff_model = $this->model->get('staffModel');
        $staffs = $staff_model->getAllStaff(array('order_by'=>'staff_name','order'=>'ASC'));
        $this->view->data['staffs'] = $staffs;
        foreach ($staffs as $staff) {
            $staff_data[$staff->staff_id]['name'] = $staff->staff_name;
        }
        $this->view->data['staff_data'] = $staff_data;

        $tire_buy_model = $this->model->get('tirebuyModel');
        $tire_brand_model = $this->model->get('tirebrandModel');
        $tire_size_model = $this->model->get('tiresizeModel');
        $tire_pattern_model = $this->model->get('tirepatternModel');
        $customer_model = $this->model->get('customerModel');

        $tire_brands = $tire_brand_model->getAllTire();
        $tire_sizes = $tire_size_model->getAllTire();
        $tire_patterns = $tire_pattern_model->getAllTire();
        $customers = $customer_model->getAllCustomer(array(
            'order_by'=> 'customer_name',
            'order'=> 'ASC',
            ));

        $this->view->data['tire_brands'] = $tire_brands;
        $this->view->data['tire_sizes'] = $tire_sizes;
        $this->view->data['tire_patterns'] = $tire_patterns;
        $this->view->data['customers'] = $customers;

        $join = array('table'=>'tire_brand, tire_size, customer, tire_pattern','where'=>'tire_sale.customer=customer.customer_id AND tire_brand.tire_brand_id = tire_sale.tire_brand AND tire_size.tire_size_id = tire_sale.tire_size AND tire_pattern.tire_pattern_id = tire_sale.tire_pattern');

        $tire_sale_model = $this->model->get('tiresaleModel');
        $sonews = $limit;
        $x = ($page-1) * $sonews;
        $pagination_stages = 2;
        
        $data = array(
            'where' => '1=1',
        );

        if ($chonngay != "") {
            $ngay = date('d-m-Y',$chonngay);
        }

        if ($ngay != "") {
            $data['where'] .= ' AND tire_sale_date > '.strtotime("-1 day",$chonngay).' AND tire_sale_date < '.strtotime("+1 day",$chonngay);
        }

        if ($code != "") {
            $data['where'] .= ' AND code = '.$code;
        }

        if ($kh > 0) {
            $data['where'] .= ' AND customer = '.$kh;
        }

        if ($thuonghieu > 0) {
            $data['where'] .= ' AND tire_brand = '.$thuonghieu;
        }

        if ($size > 0) {
            $data['where'] .= ' AND tire_size = '.$size;
        }
        
        
        $tongsodong = count($tire_sale_model->getAllTire($data,$join));
        $tongsotrang = ceil($tongsodong / $sonews);
        

        $this->view->data['page'] = $page;
        $this->view->data['order_by'] = $order_by;
        $this->view->data['order'] = $order;
        $this->view->data['keyword'] = $keyword;
        $this->view->data['pagination_stages'] = $pagination_stages;
        $this->view->data['tongsotrang'] = $tongsotrang;
        $this->view->data['limit'] = $limit;
        $this->view->data['sonews'] = $sonews;
        $this->view->data['ngay'] = $ngay;
        $this->view->data['code'] = $code;
        $this->view->data['kh'] = $kh;
        $this->view->data['thuonghieu'] = $thuonghieu;
        $this->view->data['size'] = $size;

        $data = array(
            'order_by'=>$order_by,
            'order'=>$order,
            'limit'=>$x.','.$sonews,
            'where' => '1=1',
            );
        
        if ($chonngay != "") {
            $ngay = date('d-m-Y',$chonngay);
        }

        if ($ngay != "") {
            $data['where'] .= ' AND tire_sale_date > '.strtotime("-1 day",$chonngay).' AND tire_sale_date < '.strtotime("+1 day",$chonngay);
        }

        if ($code != "") {
            $data['where'] .= ' AND code = '.$code;
        }

        if ($kh > 0) {
            $data['where'] .= ' AND customer = '.$kh;
        }

        if ($thuonghieu > 0) {
            $data['where'] .= ' AND tire_brand = '.$thuonghieu;
        }

        if ($size > 0) {
            $data['where'] .= ' AND tire_size = '.$size;
        }
      
        if ($keyword != '') {
            $search = '( code LIKE "%'.$keyword.'%" 
                OR tire_brand_name LIKE "%'.$keyword.'%" 
                OR tire_size_number LIKE "%'.$keyword.'%" )';
            
                $data['where'] = $data['where'].' AND '.$search;
        }

        

        
        $this->view->data['tire_sales'] = $tire_sale_model->getAllTire($data,$join);
        $this->view->data['lastID'] = isset($tire_sale_model->getLastTire()->tire_sale_id)?$tire_sale_model->getLastTire()->tire_sale_id:0;

        /* Lấy tổng doanh thu*/
        
        /*************/
        $this->view->show('tiresale/sale');
    }

    public function cost() {
        $this->view->setLayout('admin');
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        
        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Lốp xe';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;
            $order = isset($_POST['order']) ? $_POST['order'] : null;
            $page = isset($_POST['page']) ? $_POST['page'] : null;
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;
            $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;
        }
        else{
            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_excess_id';
            $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'DESC';
            $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;
            $keyword = "";
            $limit = 50;
        }

        $code = $this->registry->router->param_id;
        $brand = $this->registry->router->page;
        $size = $this->registry->router->order_by;
        $pattern = $this->registry->router->order;

        $this->view->data['code'] = $code;
        $this->view->data['tire_pattern'] = $tire_pattern;

        $customer_model = $this->model->get('customerModel');
        $customers = $customer_model->getAllCustomer();
        $data_customer = array();
        foreach ($customers as $customer) {
            $data_customer[$customer->customer_id]['name'] = $customer->customer_name;
        }

        $this->view->data['customer'] = $data_customer;

        $tire_brand_model = $this->model->get('tirebrandModel');
        $tire_size_model = $this->model->get('tiresizeModel');
        $tire_pattern_model = $this->model->get('tirepatternModel');

        $tire_patterns = $tire_pattern_model->getTire($pattern);
        $this->view->data['tire_pattern_name'] = $tire_patterns->tire_pattern_name;

        $tire_brands = $tire_brand_model->getAllTire(array('where'=>'tire_brand_id='.$brand));
        $tire_sizes = $tire_size_model->getAllTire(array('where'=>'tire_size_id='.$size));

        $this->view->data['tire_brands'] = $tire_brands;
        $this->view->data['tire_sizes'] = $tire_sizes;

        $tire_excess_type_model = $this->model->get('tireexcesstypeModel');
        $tire_excess_types = $tire_excess_type_model->getAllTire();
        $this->view->data['tire_excess_types'] = $tire_excess_types;

        $join = array('table'=>'tire_excess_type, tire_size, tire_brand, tire_pattern','where'=>'tire_excess.tire_excess_type = tire_excess_type.tire_excess_type_id AND tire_brand.tire_brand_id = tire_excess.tire_excess_brand AND tire_size.tire_size_id = tire_excess.tire_excess_size AND tire_pattern.tire_pattern_id = tire_excess.tire_excess_pattern');
        $tire_excess_model = $this->model->get('tireexcessModel');
        $sonews = $limit;
        $x = ($page-1) * $sonews;
        $pagination_stages = 2;
        
        $data = array(
            'where' => 'code='.$code.' AND tire_excess_brand='.$brand.' AND tire_excess_size='.$size.' AND tire_excess_pattern='.$pattern,
        );
        
        
        $tongsodong = count($tire_excess_model->getAllTire($data,$join));
        $tongsotrang = ceil($tongsodong / $sonews);
        

        $this->view->data['page'] = $page;
        $this->view->data['order_by'] = $order_by;
        $this->view->data['order'] = $order;
        $this->view->data['keyword'] = $keyword;
        $this->view->data['pagination_stages'] = $pagination_stages;
        $this->view->data['tongsotrang'] = $tongsotrang;
        $this->view->data['limit'] = $limit;
        $this->view->data['sonews'] = $sonews;

        $data = array(
            'where' => 'code='.$code.' AND tire_excess_brand='.$brand.' AND tire_excess_size='.$size.' AND tire_excess_pattern='.$pattern,
            );
        
      
        if ($keyword != '') {
            $search = '( code LIKE "%'.$keyword.'%" )';
            
                $data['where'] = $data['where'].' AND '.$search;
        }

        

        
        $this->view->data['tire_costs'] = $tire_excess_model->getAllTire($data,$join);
        $this->view->data['lastID'] = isset($tire_excess_model->getLastTire()->tire_excess_id)?$tire_excess_model->getLastTire()->tire_excess_id:0;

        /* Lấy tổng doanh thu*/
        
        /*************/
        $this->view->show('tiresale/cost');
    }

    public function price() {
        $this->view->setLayout('admin');
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        
        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Bảng giá lốp xe';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;
            $order = isset($_POST['order']) ? $_POST['order'] : null;
            $page = isset($_POST['page']) ? $_POST['page'] : null;
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;
            $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;
        }
        else{
            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_brand';
            $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'DESC';
            $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;
            $keyword = "";
            $limit = 20;
        }


        $join = array('table'=>'tire_brand, tire_size','where'=>'tire_price.tire_brand = tire_brand.tire_brand_id AND tire_price.tire_size = tire_size.tire_size_id');
        $tire_price_model = $this->model->get('tirepriceModel');
        $sonews = $limit;
        $x = ($page-1) * $sonews;
        $pagination_stages = 2;
        
        $data = array(
            'where' => '1=1',
        );
        
        
        $tongsodong = count($tire_price_model->getAllTire($data,$join));
        $tongsotrang = ceil($tongsodong / $sonews);
        

        $this->view->data['page'] = $page;
        $this->view->data['order_by'] = $order_by;
        $this->view->data['order'] = $order;
        $this->view->data['keyword'] = $keyword;
        $this->view->data['pagination_stages'] = $pagination_stages;
        $this->view->data['tongsotrang'] = $tongsotrang;
        $this->view->data['limit'] = $limit;
        $this->view->data['sonews'] = $sonews;

        $data = array(
            'order_by'=>$order_by,
            'order'=>$order,
            'limit'=>$x.','.$sonews,
            'where' => '1=1',
            );
        
      
        if ($keyword != '') {
            $search = '( tire_brand_name LIKE "%'.$keyword.'%" 
                        OR tire_brand_name LIKE "%'.$keyword.'%" )';
            
                $data['where'] = $data['where'].' AND '.$search;
        }

        

        
        $this->view->data['tire_costs'] = $tire_excess_model->getAllTire($data,$join);
        $this->view->data['lastID'] = isset($tire_excess_model->getLastTire()->tire_excess_id)?$tire_excess_model->getLastTire()->tire_excess_id:0;

        /* Lấy tổng doanh thu*/
        
        /*************/
        $this->view->show('tiresale/price');
    }

    public function profit() {
        $this->view->setLayout('admin');
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $batdau = isset($_POST['batdau']) ? $_POST['batdau'] : null;
        }
        else{
            $batdau = 0;
        }

        $code = $batdau;

        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Lốp xe';

        $this->view->data['code'] = $code;

        $tire_buy_model = $this->model->get('tirebuyModel');
        $tire_brand_model = $this->model->get('tirebrandModel');
        $tire_size_model = $this->model->get('tiresizeModel');
        $tire_pattern_model = $this->model->get('tirepatternModel');
        $tire_sale_model = $this->model->get('tiresaleModel');
        $tire_price_model = $this->model->get('tirepriceModel');
        $tire_excess_model = $this->model->get('tireexcessModel');
        $tire_ocean_freight_model = $this->model->get('tireoceanfreightModel');

        $tire_brands = $tire_brand_model->getAllTire();
        $tire_sizes = $tire_size_model->getAllTire();
        $tire_patterns = $tire_pattern_model->getAllTire();

        $data = array();
        if ($code > 0) {
            $data = array(
                'where'=>'code='.$code,
            );
        }
        
        $tire_buys = $tire_buy_model->getAllTire($data);
        $tire_sales = $tire_sale_model->getAllTire($data);
        

        $price = array();
        $volume = array();
        foreach ($tire_buys as $tire_buy) {
            $codes[$tire_buy->code]['code'] = $tire_buy->code;

            $volume[$tire_buy->code] = isset($volume[$tire_buy->code])?$volume[$tire_buy->code]+$tire_buy->tire_buy_volume:$tire_buy->tire_buy_volume;
            
            $w = array(
                'where' => 'tire_brand='.$tire_buy->tire_buy_brand.' AND tire_size='.$tire_buy->tire_buy_size.' AND tire_pattern='.$tire_buy->tire_buy_pattern.' AND price_start_time <= '.$tire_buy->tire_buy_date.' AND price_end_time >= '.$tire_buy->tire_buy_date,
            );
            $tire_prices = $tire_price_model->getAllTire($w);
            foreach ($tire_prices as $tire) {
                $income = ($tire->tax_price)*0.25;
                $vat = ($income+$tire->tax_price)*0.1;
                $tax = $income+$vat;
                $customs = (($tire->custom_price-$tire->tax_price)*0.25)/2;
                $price['shipper'][$tire_buy->code] = isset($price['shipper'][$tire_buy->code])?($price['shipper'][$tire_buy->code]+($tire_buy->tire_buy_volume*$tire->tax_price)):($tire_buy->tire_buy_volume*$tire->tax_price);
                $price['solow'][$tire_buy->code] = isset($price['solow'][$tire_buy->code])?($price['solow'][$tire_buy->code]+($tire_buy->tire_buy_volume*($tire->supply_price-$tire->tax_price))):($tire_buy->tire_buy_volume*($tire->supply_price-$tire->tax_price));
            }
            

            $price['tax_amount'][$tire_buy->code] = isset($price['tax_amount'][$tire_buy->code])?($price['tax_amount'][$tire_buy->code]+($tire_buy->tire_buy_volume*$tax)):($tire_buy->tire_buy_volume*$tax);
            $price['customs_amount'][$tire_buy->code] = isset($price['customs_amount'][$tire_buy->code])?($price['customs_amount'][$tire_buy->code]+($tire_buy->tire_buy_volume*$customs)):($tire_buy->tire_buy_volume*$customs);
            
            $price['stevedore'][$tire_buy->code] = isset($price['stevedore'][$tire_buy->code])?($price['stevedore'][$tire_buy->code]+($tire_buy->tire_buy_volume*0.5)):($tire_buy->tire_buy_volume*0.5);
            $price['rate'][$tire_buy->code] = $tire_buy->rate;
            $price['rate_shipper'][$tire_buy->code] = $tire_buy->rate_shipper;

            if ($volume[$tire_buy->code] > 120) {
                $price['lift'][$tire_buy->code] = 1010000;
                $price['local_charge'][$tire_buy->code] = 218;

                $o = array(
                    'where' => 'feet=2 AND tire_ocean_freight_start_time <= '.$tire_buy->tire_buy_date.' AND tire_ocean_freight_end_time >= '.$tire_buy->tire_buy_date,
                );
                $tire_ocean_freights = $tire_ocean_freight_model->getAllTire($o);

                foreach ($tire_ocean_freights as $tire) {
                    $price['ocean_freight'][$tire_buy->code] = $tire->tire_ocean_freight;
                }
            }
            elseif ($volume[$tire_buy->code] > 0 && $volume[$tire_buy->code] <= 120) {
                $price['lift'][$tire_buy->code] = 665000;
                $price['local_charge'][$tire_buy->code] = 157;

                $o = array(
                    'where' => 'feet=1 AND tire_ocean_freight_start_time <= '.$tire_buy->tire_buy_date.' AND tire_ocean_freight_end_time >= '.$tire_buy->tire_buy_date,
                );
                $tire_ocean_freights = $tire_ocean_freight_model->getAllTire($o);

                foreach ($tire_ocean_freights as $tire) {
                    $price['ocean_freight'][$tire_buy->code] = $tire->tire_ocean_freight;
                }
            }
        }

        foreach ($tire_sales as $tire_sale) {
            $price['income'][$tire_sale->code] = isset($price['income'][$tire_sale->code])?($price['income'][$tire_sale->code]+($tire_sale->volume*$tire_sale->sell_price)):($tire_sale->volume*$tire_sale->sell_price);
            
        }

        $cost = array();

        foreach ($codes as $code) {
            $data = array(
                'where' => 'code='.$code['code'],
            );
            $join = array('table'=>'tire_excess_type','where'=>'tire_excess.tire_excess_type = tire_excess_type.tire_excess_type_id');

            $cost[$code['code']] = $tire_excess_model->getAllTire($data,$join);
        }

        

        $this->view->data['prices'] = $price;
        $this->view->data['codes'] = $codes;
        $this->view->data['costs'] = $cost;

        $this->view->data['tire_brands'] = $tire_brands;
        $this->view->data['tire_sizes'] = $tire_sizes;
        $this->view->data['tire_patterns'] = $tire_patterns;

        
        /* Lấy tổng doanh thu*/
        
        /*************/
        $this->view->show('tiresale/profit');
    }
    public function show() {
        $this->view->disableLayout();
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
    
        $code = $this->registry->router->param_id;
        $brand = $this->registry->router->page;
        $size = $this->registry->router->order_by;
        $pattern = $this->registry->router->order;


        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Lốp xe';

        $this->view->data['code'] = $code;

        $tire_buy_model = $this->model->get('tirebuyModel');
        $tire_brand_model = $this->model->get('tirebrandModel');
        $tire_size_model = $this->model->get('tiresizeModel');
        $tire_pattern_model = $this->model->get('tirepatternModel');
        $tire_sale_model = $this->model->get('tiresaleModel');
        $tire_price_model = $this->model->get('tirepriceModel');
        $tire_excess_model = $this->model->get('tireexcessModel');
        $tire_ocean_freight_model = $this->model->get('tireoceanfreightModel');

        $tire_brands = $tire_brand_model->getAllTire();
        $tire_sizes = $tire_size_model->getAllTire();
        $tire_patterns = $tire_pattern_model->getAllTire();

        $tire_brand_name = $tire_brand_model->getTire($brand)->tire_brand_name;
        $tire_size_name = $tire_size_model->getTire($size)->tire_size_number;
        $tire_pattern_name = $tire_pattern_model->getTire($pattern)->tire_pattern_name;

        $data = array();
        if ($code > 0) {
            $data_buy = array(
                'where'=>'code='.$code.' AND tire_buy_brand='.$brand.' AND tire_buy_size='.$size.' AND tire_buy_pattern='.$pattern,
            );

            $data_sale = array(
                'where'=>'code='.$code.' AND tire_brand='.$brand.' AND tire_size='.$size.' AND tire_pattern='.$pattern,
            );
        }
        
        $tire_buys = $tire_buy_model->getAllTire($data_buy);
        $tire_sales = $tire_sale_model->getAllTire($data_sale);
        
        $tongsl = 0;
        $price = array();
        $volume = array();
        foreach ($tire_buys as $tire_buy) {
            if ($tire_buy->code > 0) {
                $datas = array(
                    'where'=>'code='.$tire_buy->code,
                );
            }
            
            $tire_buy_datas = $tire_buy_model->getAllTire($datas);

            foreach ($tire_buy_datas as $b) {
                $tongsl += $b->tire_buy_volume;
            }

            $codes[$tire_buy->code]['code'] = $tire_buy->code;

            $volume[$tire_buy->code] = isset($volume[$tire_buy->code])?$volume[$tire_buy->code]+$tire_buy->tire_buy_volume:$tire_buy->tire_buy_volume;
            
            $w = array(
                'where' => 'tire_brand='.$tire_buy->tire_buy_brand.' AND tire_size='.$tire_buy->tire_buy_size.' AND tire_pattern='.$tire_buy->tire_buy_pattern.' AND price_start_time <= '.$tire_buy->tire_buy_date.' AND price_end_time >= '.$tire_buy->tire_buy_date,
            );
            $tire_prices = $tire_price_model->getAllTire($w);
            foreach ($tire_prices as $tire) {
                $income = ($tire->tax_price)*0.25;
                $vat = ($income+$tire->tax_price)*0.1;
                $tax = $income+$vat;
                $customs = (($tire->custom_price-$tire->tax_price)*0.25)/2;
                $price['shipper'][$tire_buy->code] = isset($price['shipper'][$tire_buy->code])?($price['shipper'][$tire_buy->code]+($tire_buy->tire_buy_volume*$tire->tax_price)):($tire_buy->tire_buy_volume*$tire->tax_price);
                $price['solow'][$tire_buy->code] = isset($price['solow'][$tire_buy->code])?($price['solow'][$tire_buy->code]+($tire_buy->tire_buy_volume*($tire->supply_price-$tire->tax_price))):($tire_buy->tire_buy_volume*($tire->supply_price-$tire->tax_price));
            }
            

            $price['tax_amount'][$tire_buy->code] = isset($price['tax_amount'][$tire_buy->code])?($price['tax_amount'][$tire_buy->code]+($tire_buy->tire_buy_volume*$tax)):($tire_buy->tire_buy_volume*$tax);
            $price['customs_amount'][$tire_buy->code] = isset($price['customs_amount'][$tire_buy->code])?($price['customs_amount'][$tire_buy->code]+($tire_buy->tire_buy_volume*$customs)):($tire_buy->tire_buy_volume*$customs);
            
            $price['stevedore'][$tire_buy->code] = isset($price['stevedore'][$tire_buy->code])?($price['stevedore'][$tire_buy->code]+($tire_buy->tire_buy_volume*0.5)):($tire_buy->tire_buy_volume*0.5);
            $price['rate'][$tire_buy->code] = $tire_buy->rate;
            $price['rate_shipper'][$tire_buy->code] = $tire_buy->rate_shipper;

            if ($tongsl > 120) {
                $price['lift'][$tire_buy->code] = 1010000*$tire_buy->tire_buy_volume/$tongsl;
                $price['local_charge'][$tire_buy->code] = 218*$tire_buy->tire_buy_volume/$tongsl;

                $o = array(
                    'where' => 'feet=2 AND tire_ocean_freight_start_time <= '.$tire_buy->tire_buy_date.' AND tire_ocean_freight_end_time >= '.$tire_buy->tire_buy_date,
                );
                $tire_ocean_freights = $tire_ocean_freight_model->getAllTire($o);

                foreach ($tire_ocean_freights as $tire) {
                    $price['ocean_freight'][$tire_buy->code] = $tire->tire_ocean_freight*$tire_buy->tire_buy_volume/$tongsl;
                }
            }
            elseif ($tongsl > 0 && $tongsl <= 120) {
                $price['lift'][$tire_buy->code] = 665000*$tire_buy->tire_buy_volume/$tongsl;
                $price['local_charge'][$tire_buy->code] = 157*$tire_buy->tire_buy_volume/$tongsl;

                $o = array(
                    'where' => 'feet=1 AND tire_ocean_freight_start_time <= '.$tire_buy->tire_buy_date.' AND tire_ocean_freight_end_time >= '.$tire_buy->tire_buy_date,
                );
                $tire_ocean_freights = $tire_ocean_freight_model->getAllTire($o);

                foreach ($tire_ocean_freights as $tire) {
                    $price['ocean_freight'][$tire_buy->code] = $tire->tire_ocean_freight*$tire_buy->tire_buy_volume/$tongsl;
                }
            }
        }

        foreach ($tire_sales as $tire_sale) {
            $price['income'][$tire_sale->code] = isset($price['income'][$tire_sale->code])?($price['income'][$tire_sale->code]+($tire_sale->volume*$tire_sale->sell_price)):($tire_sale->volume*$tire_sale->sell_price);
            
        }

        $cost = array();

        foreach ($codes as $code) {
            $data = array(
                'where' => 'code='.$code['code'].' AND tire_excess_brand='.$brand.' AND tire_excess_size='.$size.' AND tire_excess_pattern='.$pattern,
            );
            $join = array('table'=>'tire_excess_type','where'=>'tire_excess.tire_excess_type = tire_excess_type.tire_excess_type_id');

            $cost[$code['code']] = $tire_excess_model->getAllTire($data,$join);
        }

        

        $this->view->data['prices'] = $price;
        $this->view->data['codes'] = $codes;
        $this->view->data['costs'] = $cost;

        $this->view->data['tire_brands'] = $tire_brands;
        $this->view->data['tire_sizes'] = $tire_sizes;
        $this->view->data['tire_patterns'] = $tire_patterns;

        $this->view->data['tire_brand_name'] = $tire_brand_name;
        $this->view->data['tire_size_name'] = $tire_size_name;
        $this->view->data['tire_pattern_name'] = $tire_pattern_name;

        $this->view->data['volume'] = $volume;
        $this->view->data['tongsl'] = $tongsl;

        
        /* Lấy tổng doanh thu*/
        
        /*************/
        $this->view->show('tiresale/show');
    }

    public function showbuy($code) {
        $this->view->disableLayout();
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
    

        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Lốp xe';

        $this->view->data['code'] = $code;

        $tire_buy_model = $this->model->get('tirebuyModel');
        $tire_brand_model = $this->model->get('tirebrandModel');
        $tire_size_model = $this->model->get('tiresizeModel');
        $tire_pattern_model = $this->model->get('tirepatternModel');
        $tire_sale_model = $this->model->get('tiresaleModel');
        $tire_price_model = $this->model->get('tirepriceModel');
        $tire_excess_model = $this->model->get('tireexcessModel');
        $tire_ocean_freight_model = $this->model->get('tireoceanfreightModel');

        $tire_brands = $tire_brand_model->getAllTire();
        $tire_sizes = $tire_size_model->getAllTire();
        $tire_patterns = $tire_pattern_model->getAllTire();

        $data = array();
        if ($code > 0) {
            $data = array(
                'where'=>'tire_buy_id='.$code,
            );
        }
        
        $tire_buys = $tire_buy_model->getAllTire($data);
        
        $tongsl = 0;

        $price = array();
        $volume = array();
        foreach ($tire_buys as $tire_buy) {
            $tire_brand_name = $tire_brand_model->getTire($tire_buy->tire_buy_brand);
            $tire_size_name = $tire_size_model->getTire($tire_buy->tire_buy_size);
            $tire_pattern_name = $tire_pattern_model->getTire($tire_buy->tire_buy_pattern);

            if ($tire_buy->code > 0) {
                $datas = array(
                    'where'=>'code='.$tire_buy->code,
                );
            }
            
            $tire_buy_datas = $tire_buy_model->getAllTire($datas);

            foreach ($tire_buy_datas as $b) {
                $tongsl += $b->tire_buy_volume;
            }

            $data_sale = array(
                'where'=>'code='.$tire_buy->code.' AND tire_brand='.$tire_buy->tire_buy_brand.' AND tire_size='.$tire_buy->tire_buy_size.' AND tire_pattern='.$tire_buy->tire_buy_pattern,
            );
            $tire_sales = $tire_sale_model->getAllTire($data_sale);
            
            $codes[$tire_buy->code]['code'] = $tire_buy->code;

            $volume[$tire_buy->code] = isset($volume[$tire_buy->code])?$volume[$tire_buy->code]+$tire_buy->tire_buy_volume:$tire_buy->tire_buy_volume;
            
            $w = array(
                'where' => 'tire_brand='.$tire_buy->tire_buy_brand.' AND tire_size='.$tire_buy->tire_buy_size.' AND tire_pattern='.$tire_buy->tire_buy_pattern.' AND price_start_time <= '.$tire_buy->tire_buy_date.' AND price_end_time >= '.$tire_buy->tire_buy_date,
            );
            $tire_prices = $tire_price_model->getAllTire($w);
            foreach ($tire_prices as $tire) {
                $income = ($tire->tax_price)*0.25;
                $vat = ($income+$tire->tax_price)*0.1;
                $tax = $income+$vat;
                $customs = (($tire->custom_price-$tire->tax_price)*0.25)/2;
                $price['shipper'][$tire_buy->code] = isset($price['shipper'][$tire_buy->code])?($price['shipper'][$tire_buy->code]+($tire_buy->tire_buy_volume*($tire->tax_price))):($tire_buy->tire_buy_volume*($tire->tax_price));
                $price['solow'][$tire_buy->code] = isset($price['solow'][$tire_buy->code])?($price['solow'][$tire_buy->code]+($tire_buy->tire_buy_volume*(($tire->supply_price-$tire->tax_price)))):($tire_buy->tire_buy_volume*(($tire->supply_price-$tire->tax_price)));
            }
            

            $price['tax_amount'][$tire_buy->code] = isset($price['tax_amount'][$tire_buy->code])?($price['tax_amount'][$tire_buy->code]+($tire_buy->tire_buy_volume*($tax))):($tire_buy->tire_buy_volume*($tax));
            $price['customs_amount'][$tire_buy->code] = isset($price['customs_amount'][$tire_buy->code])?($price['customs_amount'][$tire_buy->code]+($tire_buy->tire_buy_volume*($customs))):($tire_buy->tire_buy_volume*($customs));
            
            $price['stevedore'][$tire_buy->code] = isset($price['stevedore'][$tire_buy->code])?($price['stevedore'][$tire_buy->code]+($tire_buy->tire_buy_volume*(0.5))):($tire_buy->tire_buy_volume*(0.5));
            $price['rate'][$tire_buy->code] = $tire_buy->rate;
            $price['rate_shipper'][$tire_buy->code] = $tire_buy->rate_shipper;

            if ($tongsl > 120) {
                $price['lift'][$tire_buy->code] = 1010000*$tire_buy->tire_buy_volume/$tongsl;
                $price['local_charge'][$tire_buy->code] = 218*$tire_buy->tire_buy_volume/$tongsl;

                $o = array(
                    'where' => 'feet=2 AND tire_ocean_freight_start_time <= '.$tire_buy->tire_buy_date.' AND tire_ocean_freight_end_time >= '.$tire_buy->tire_buy_date,
                );
                $tire_ocean_freights = $tire_ocean_freight_model->getAllTire($o);

                foreach ($tire_ocean_freights as $tire) {
                    $price['ocean_freight'][$tire_buy->code] = $tire->tire_ocean_freight*$tire_buy->tire_buy_volume/$tongsl;
                }
            }
            elseif ($tongsl > 0 && $tongsl <= 120) {
                $price['lift'][$tire_buy->code] = 665000*$tire_buy->tire_buy_volume/$tongsl;
                $price['local_charge'][$tire_buy->code] = 157*$tire_buy->tire_buy_volume/$tongsl;

                $o = array(
                    'where' => 'feet=1 AND tire_ocean_freight_start_time <= '.$tire_buy->tire_buy_date.' AND tire_ocean_freight_end_time >= '.$tire_buy->tire_buy_date,
                );
                $tire_ocean_freights = $tire_ocean_freight_model->getAllTire($o);

                foreach ($tire_ocean_freights as $tire) {
                    $price['ocean_freight'][$tire_buy->code] = $tire->tire_ocean_freight*$tire_buy->tire_buy_volume/$tongsl;
                }
            }
        }

        foreach ($tire_sales as $tire_sale) {
            $price['income'][$tire_sale->code] = isset($price['income'][$tire_sale->code])?($price['income'][$tire_sale->code]+($tire_sale->volume*$tire_sale->sell_price)):($tire_sale->volume*$tire_sale->sell_price);
            
        }

        $cost = array();

        foreach ($codes as $code) {
            $data = array(
                'where' => '(customer IS NULL OR customer <= 0) AND code='.$code['code'].' AND tire_excess_brand='.$tire_brand_name->tire_brand_id.' AND tire_excess_size='.$tire_size_name->tire_size_id.' AND tire_excess_pattern='.$tire_pattern_name->tire_pattern_id,
            );
            $join = array('table'=>'tire_excess_type','where'=>'tire_excess.tire_excess_type = tire_excess_type.tire_excess_type_id');

            $cost[$code['code']] = $tire_excess_model->getAllTire($data,$join);
        }

        

        $this->view->data['prices'] = $price;
        $this->view->data['codes'] = $codes;
        $this->view->data['costs'] = $cost;

        $this->view->data['tire_brands'] = $tire_brands;
        $this->view->data['tire_sizes'] = $tire_sizes;
        $this->view->data['tire_patterns'] = $tire_patterns;

        $this->view->data['tire_brand_name'] = $tire_brand_name->tire_brand_name;
        $this->view->data['tire_size_name'] = $tire_size_name->tire_size_number;
        $this->view->data['tire_pattern_name'] = $tire_pattern_name->tire_pattern_name;

        $this->view->data['volume'] = $volume;
        $this->view->data['tongsl'] = $tongsl;

        
        /* Lấy tổng doanh thu*/
        
        /*************/
        $this->view->show('tiresale/showbuy');
    }

   
   
    public function addsale(){
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        if (isset($_POST['yes'])) {
            
            $sale = $this->model->get('salereportModel');
            $customer_sale = $this->model->get('customersaleModel');
            $sales_model = $this->model->get('salesModel');
            $obtain = $this->model->get('obtainModel');
            $receivable = $this->model->get('receivableModel');

            $tire_sale_model = $this->model->get('tiresaleModel');
            $data = array(
                        
                        'code' => trim($_POST['code']),
                        'volume' => trim($_POST['volume']),
                        'tire_brand' => trim($_POST['tire_brand']),
                        'tire_size' => trim($_POST['tire_size']),
                        'sell_price' => trim(str_replace(',','',$_POST['sell_price'])),
                        'customer' => trim($_POST['customer']),
                        'tire_sale_date' => strtotime($_POST['tire_sale_date']),
                        //'tire_sale_date_expect' => strtotime($_POST['tire_sale_date_expect']),
                        'tire_pattern' => trim($_POST['tire_pattern']),
                        'check_vat' => trim($_POST['check_vat']),
                        'sale' => trim($_POST['sale']),
                        );

            $trading = $sale->getSaleByWhere(array('code'=>$data['code']));

            
            
            

            
            /*$trading = $sale->getSaleByWhere(array('code'=>$data['code']));

            $other_revenue = $data['check_vat']==0?($data['volume']*$data['sell_price']):0;
            $other_revenue_vat = $data['check_vat']==1?($data['volume']*$data['sell_price']):0;

            $data_update = array(
                'profit' => $trading->profit+$other_revenue,
                'profit_vat' => $trading->profit_vat+$other_revenue_vat,
                'other_revenue' => $other_revenue,
                'other_revenue_vat' => $other_revenue_vat,

            );
            
            $sale->updateSale($data_update,array('sale_report_id' => $trading->sale_report_id));

            $salesdata = $sales_model->getSalesByWhere(array('trading'=>$trading->sale_report_id));

            $data_sales = array(
                
                'revenue' => $trading->revenue+$trading->revenue_vat+$trading->other_revenue+$trading->other_revenue_vat,
                'profit' => $trading->revenue+$trading->revenue_vat+$trading->other_revenue+$trading->other_revenue_vat-$trading->cost-$trading->cost_vat-$trading->estimate_cost-$trading->estimate_cost_2,
                
                'sales_update_user' => $_SESSION['userid_logined'],
                'sales_update_time' => strtotime(date('d-m-Y')),
            );
            $sales_model->updateSales($data_sales,array('sales_id'=>$salesdata->sales_id));

            $customer_sale_data = array(
                'sale_report' => $trading->sale_report_id,
                'customer' => $data['customer'],
                'bank' => 1,
                'revenue_vat' => $other_revenue_vat,
                'revenue' => $other_revenue,
                'expect_date' => $data['tire_sale_date_expect'],
                
            );

            if($customer_sale->getCustomerByWhere(array('customer'=>$data['customer'],'sale_report'=>$trading->sale_report_id,'expect_date'=>$data['tire_sale_date_expect']))){
                $old_revenue = $customer_sale->getCustomerByWhere(array('customer'=>$data['customer'],'sale_report'=>$trading->sale_report_id,'expect_date'=>$data['tire_sale_date_expect']))->revenue;
                $old_revenue_vat = $customer_sale->getCustomerByWhere(array('customer'=>$data['customer'],'sale_report'=>$trading->sale_report_id,'expect_date'=>$data['tire_sale_date_expect']))->revenue_vat;
                $total = $old_revenue+$old_revenue_vat;

                $ob = $obtain->getObtainByWhere(array('trading'=>$trading->sale_report_id,'customer'=>$data['customer'],'money'=>$total));

                $obtain_data = array(
                    'obtain_date' => $trading->sale_date,
                    'customer' => $data['customer'],
                    'money' => $other_revenue_vat+$other_revenue,
                    'week' => (int)date('W',$trading->sale_date),
                    'year' => (int)date('Y',$trading->sale_date),
                    'trading' => $trading->sale_report_id,
                );
                if($obtain_data['week'] == 53){
                    $obtain_data['week'] = 1;
                    $obtain_data['year'] = $obtain_data['year']+1;
                }
                if (((int)date('W',$trading->sale_date) == 1) && ((int)date('m',$trading->sale_date) == 12) ) {
                    $obtain_data['year'] = (int)date('Y',$trading->sale_date)+1;
                }

                $obtain->updateObtain($obtain_data,array('trading'=>$trading->sale_report_id,'customer'=>$data['customer'],'money'=>$total));

                $receivable_data = array(
                    'customer' => $customer_sale_data['customer'],
                    'money' => $customer_sale_data['revenue_vat'],
                    'receivable_date' => $trading->sale_date,
                    'expect_date' => $customer_sale_data['expect_date'],
                    'week' => (int)date('W',$customer_sale_data['expect_date']),
                    'year' => (int)date('Y',$customer_sale_data['expect_date']),
                    'code' => $trading->code,
                    'source' => $customer_sale_data['bank'],
                    'comment' => $trading->comment,
                    'create_user' => $_SESSION['userid_logined'],
                    'type' => 4,
                    'trading' => $trading->sale_report_id,
                    'check_vat'=>1,
                );
                if($receivable_data['week'] == 53){
                    $receivable_data['week'] = 1;
                    $receivable_data['year'] = $receivable_data['year']+1;
                }
                if (((int)date('W',$customer_sale_data['expect_date']) == 1) && ((int)date('m',$customer_sale_data['expect_date']) == 12) ) {
                    $receivable_data['year'] = (int)date('Y',$customer_sale_data['expect_date'])+1;
                }

                if($receivable->getCostsByWhere(array('money'=>$old_revenue_vat,'customer' => $customer_sale_data['customer'],'trading'=>$trading->sale_report_id))){
                    $re = $receivable->getCostsByWhere(array('money'=>$old_revenue_vat,'customer' => $customer_sale_data['customer'],'trading'=>$trading->sale_report_id));
                        $receivable->updateCosts($receivable_data,array('money'=>$old_revenue_vat,'customer' => $customer_sale_data['customer'],'trading'=>$trading->sale_report_id));

                }
                elseif(!$receivable->getCostsByWhere(array('money'=>$old_revenue_vat,'customer' => $customer_sale_data['customer'],'trading'=>$trading->sale_report_id))){
                    if($customer_sale_data['revenue_vat'] > 0){
                        $receivable->createCosts($receivable_data);
                    }
                }
                
            


                $receivable_data = array(
                    'customer' => $customer_sale_data['customer'],
                    'money' => $customer_sale_data['revenue'],
                    'receivable_date' => $trading->sale_date,
                    'expect_date' => $customer_sale_data['expect_date'],
                    'week' => (int)date('W',$customer_sale_data['expect_date']),
                    'year' => (int)date('Y',$customer_sale_data['expect_date']),
                    'code' => $trading->code,
                    'source' => $customer_sale_data['bank'],
                    'comment' => $sale_data->comment,
                    'create_user' => $_SESSION['userid_logined'],
                    'type' => 4,
                    'trading' => $trading->sale_report_id,
                    'check_vat'=>0,
                );
                if($receivable_data['week'] == 53){
                    $receivable_data['week'] = 1;
                    $receivable_data['year'] = $receivable_data['year']+1;
                }
                if (((int)date('W',$customer_sale_data['expect_date']) == 1) && ((int)date('m',$customer_sale_data['expect_date']) == 12) ) {
                    $receivable_data['year'] = (int)date('Y',$customer_sale_data['expect_date'])+1;
                }

                if($receivable->getCostsByWhere(array('money'=>$old_revenue,'customer' => $customer_sale_data['customer'],'trading'=>$trading->sale_report_id))){
                    $re = $receivable->getCostsByWhere(array('money'=>$old_revenue,'customer' => $customer_sale_data['customer'],'trading'=>$trading->sale_report_id));
                        $receivable->updateCosts($receivable_data,array('money'=>$old_revenue,'customer' => $customer_sale_data['customer'],'trading'=>$trading->sale_report_id));
                    
                }
                elseif(!$receivable->getCostsByWhere(array('money'=>$old_revenue,'customer' => $customer_sale_data['customer'],'trading'=>$trading->sale_report_id))){
                    if($customer_sale_data['revenue'] > 0){
                        $receivable->createCosts($receivable_data);
                    }
                }


            }
            else{

            }*/

            if ($_POST['yes'] != "") {

                $tire_sale_data = $tire_sale_model->getTire($_POST['yes']);

                /*if ( ($tire_sale_data->volume*$tire_sale_data->sell_price) != ($data['volume']*$data['sell_price']) ) {
                    $chenhlech = ($data['volume']*$data['sell_price'])-($tire_sale_data->volume*$tire_sale_data->sell_price);

                    $customer_sale_datas = $customer_sale->getCustomerByWhere(array('customer'=>119,'sale_report'=>$trading->sale_report_id));

                    if ($customer_sale_datas->revenue_vat >= $chenhlech ) {
                        $customer_sale_data = array(
                            'sale_report' => $trading->sale_report_id,
                            'customer' => 119,
                            'bank' => $customer_sale_datas->bank,
                            'revenue_vat' => $customer_sale_datas->revenue_vat+$chenhlech,
                            'revenue' => $customer_sale_datas->revenue,
                            'expect_date' => $customer_sale_datas->expect_date,
                            
                        );
                        $customer_sale->updateCustomer($customer_sale_data,array('customer_sale_id'=>$customer_sale_datas->customer_sale_id));

                        $obtain_datas = $obtain->getObtainByWhere(array('trading'=>$trading->sale_report_id,'customer'=>119,'money'=>$customer_sale_datas->revenue_vat));
                        
                        $obtain_data = array(
                            'obtain_date' => $trading->sale_date,
                            'customer' => 119,
                            'money' => $obtain_datas->money+$chenhlech,
                            'week' => $obtain_datas->week,
                            'year' => $obtain_datas->year,
                            'trading' => $trading->sale_report_id,
                        );
                        $obtain->updateObtain($obtain_data,array('trading'=>$trading->sale_report_id,'customer'=>119,'money'=>$customer_sale_datas->revenue_vat));

                        $receivable_datas = $receivable->getCostsByWhere(array('money'=>$customer_sale_datas->revenue_vat,'customer' => 119,'trading'=>$trading->sale_report_id));
                        $receivable_data = array(
                            'customer' => 119,
                            'money' => $receivable_datas->money+$chenhlech,
                            'receivable_date' => $trading->sale_date,
                            'expect_date' => $receivable_datas->expect_date,
                            'week' => $receivable_datas->week,
                            'year' => $receivable_datas->year,
                            'code' => $receivable_datas->code,
                            'source' => $receivable_datas->source,
                            'comment' => $receivable_datas->comment,
                            'create_user' => $receivable_datas->create_user,
                            'type' => 4,
                            'trading' => $trading->sale_report_id,
                            'check_vat'=>1,
                        );
                        
                        $receivable->updateCosts($receivable_data,array('money'=>$customer_sale_datas->revenue_vat,'customer' => 119,'trading'=>$trading->sale_report_id));


                    }
                    else{
                        $conlai = $chenhlech + $customer_sale_datas->revenue_vat;
                        $customer_sale_data = array(
                            'sale_report' => $trading->sale_report_id,
                            'customer' => 119,
                            'bank' => $customer_sale_datas->bank,
                            'revenue_vat' => 0,
                            'revenue' => $customer_sale_datas->revenue,
                            'expect_date' => $customer_sale_datas->expect_date,
                            
                        );
                        $customer_sale->updateCustomer($customer_sale_data,array('customer_sale_id'=>$customer_sale_datas->customer_sale_id));

                        $obtain_datas = $obtain->getObtainByWhere(array('trading'=>$trading->sale_report_id,'customer'=>119,'money'=>$customer_sale_datas->revenue_vat));
                        
                        $obtain_data = array(
                            'obtain_date' => $trading->sale_date,
                            'customer' => 119,
                            'money' => 0,
                            'week' => $obtain_datas->week,
                            'year' => $obtain_datas->year,
                            'trading' => $trading->sale_report_id,
                        );
                        $obtain->updateObtain($obtain_data,array('trading'=>$trading->sale_report_id,'customer'=>119,'money'=>$customer_sale_datas->revenue_vat));

                        $receivable_datas = $receivable->getCostsByWhere(array('money'=>$customer_sale_datas->revenue_vat,'customer' => 119,'trading'=>$trading->sale_report_id));
                        $receivable_data = array(
                            'customer' => 119,
                            'money' => 0,
                            'receivable_date' => $trading->sale_date,
                            'expect_date' => $receivable_datas->expect_date,
                            'week' => $receivable_datas->week,
                            'year' => $receivable_datas->year,
                            'code' => $receivable_datas->code,
                            'source' => $receivable_datas->source,
                            'comment' => $receivable_datas->comment,
                            'create_user' => $receivable_datas->create_user,
                            'type' => 4,
                            'trading' => $trading->sale_report_id,
                            'check_vat'=>1,
                        );
                        
                        $receivable->updateCosts($receivable_data,array('money'=>$customer_sale_datas->revenue_vat,'customer' => 119,'trading'=>$trading->sale_report_id));


                        $other_revenue = $data['check_vat']==0?$conlai:0;
                        $other_revenue_vat = $data['check_vat']==1?$conlai:0;

                        $data_update = array(
                            'profit' => $trading->profit+$other_revenue,
                            'profit_vat' => $trading->profit_vat+$other_revenue_vat,
                            'other_revenue' => $trading->other_revenue+$other_revenue,
                            'other_revenue_vat' => $trading->other_revenue_vat+$other_revenue_vat,

                        );
                        
                        $sale->updateSale($data_update,array('sale_report_id' => $trading->sale_report_id));


                        $trading = $sale->getSaleByWhere(array('code'=>$data['code']));

                        $salesdata = $sales_model->getSalesByWhere(array('trading'=>$trading->sale_report_id));

                        $data_sales = array(
                            
                            'revenue' => $trading->revenue+$trading->revenue_vat+$trading->other_revenue+$trading->other_revenue_vat,
                            'profit' => $trading->revenue+$trading->revenue_vat+$trading->other_revenue+$trading->other_revenue_vat-$trading->cost-$trading->cost_vat-$trading->estimate_cost-$trading->estimate_cost_2,
                            
                            'sales_update_user' => $_SESSION['userid_logined'],
                            'sales_update_time' => strtotime(date('d-m-Y')),
                        );
                        $sales_model->updateSales($data_sales,array('sales_id'=>$salesdata->sales_id));

                    }
                }*/
                
                

                    $tire_sale_model->updateTire($data,array('tire_sale_id' => trim($_POST['yes'])));
                    echo "Cập nhật thành công";

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|tire_sale|".implode("-",$data)."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                
                
            }
            else{

                /*$customer_sale_datas = $customer_sale->getCustomerByWhere(array('customer'=>119,'sale_report'=>$trading->sale_report_id));

                if ($customer_sale_datas->revenue_vat >= ($data['volume']*$data['sell_price']) ) {
                    $customer_sale_data = array(
                        'sale_report' => $trading->sale_report_id,
                        'customer' => 119,
                        'bank' => $customer_sale_datas->bank,
                        'revenue_vat' => $customer_sale_datas->revenue_vat-($data['volume']*$data['sell_price']),
                        'revenue' => $customer_sale_datas->revenue,
                        'expect_date' => $customer_sale_datas->expect_date,
                        
                    );
                    $customer_sale->updateCustomer($customer_sale_data,array('customer_sale_id'=>$customer_sale_datas->customer_sale_id));

                    $obtain_datas = $obtain->getObtainByWhere(array('trading'=>$trading->sale_report_id,'customer'=>119,'money'=>$customer_sale_datas->revenue_vat));
                    
                    $obtain_data = array(
                        'obtain_date' => $trading->sale_date,
                        'customer' => 119,
                        'money' => $obtain_datas->money-($data['volume']*$data['sell_price']),
                        'week' => $obtain_datas->week,
                        'year' => $obtain_datas->year,
                        'trading' => $trading->sale_report_id,
                    );
                    $obtain->updateObtain($obtain_data,array('trading'=>$trading->sale_report_id,'customer'=>119,'money'=>$customer_sale_datas->revenue_vat));

                    $receivable_datas = $receivable->getCostsByWhere(array('money'=>$customer_sale_datas->revenue_vat,'customer' => 119,'trading'=>$trading->sale_report_id));
                    $receivable_data = array(
                        'customer' => 119,
                        'money' => $receivable_datas->money-($data['volume']*$data['sell_price']),
                        'receivable_date' => $trading->sale_date,
                        'expect_date' => $receivable_datas->expect_date,
                        'week' => $receivable_datas->week,
                        'year' => $receivable_datas->year,
                        'code' => $receivable_datas->code,
                        'source' => $receivable_datas->source,
                        'comment' => $receivable_datas->comment,
                        'create_user' => $receivable_datas->create_user,
                        'type' => 4,
                        'trading' => $trading->sale_report_id,
                        'check_vat'=>1,
                    );
                    
                    $receivable->updateCosts($receivable_data,array('money'=>$customer_sale_datas->revenue_vat,'customer' => 119,'trading'=>$trading->sale_report_id));


                }
                else{
                    $conlai = ($data['volume']*$data['sell_price']) - $customer_sale_datas->revenue_vat;
                    $customer_sale_data = array(
                        'sale_report' => $trading->sale_report_id,
                        'customer' => 119,
                        'bank' => $customer_sale_datas->bank,
                        'revenue_vat' => 0,
                        'revenue' => $customer_sale_datas->revenue,
                        'expect_date' => $customer_sale_datas->expect_date,
                        
                    );
                    $customer_sale->updateCustomer($customer_sale_data,array('customer_sale_id'=>$customer_sale_datas->customer_sale_id));

                    $obtain_datas = $obtain->getObtainByWhere(array('trading'=>$trading->sale_report_id,'customer'=>119,'money'=>$customer_sale_datas->revenue_vat));
                    
                    $obtain_data = array(
                        'obtain_date' => $trading->sale_date,
                        'customer' => 119,
                        'money' => 0,
                        'week' => $obtain_datas->week,
                        'year' => $obtain_datas->year,
                        'trading' => $trading->sale_report_id,
                    );
                    $obtain->updateObtain($obtain_data,array('trading'=>$trading->sale_report_id,'customer'=>119,'money'=>$customer_sale_datas->revenue_vat));

                    $receivable_datas = $receivable->getCostsByWhere(array('money'=>$customer_sale_datas->revenue_vat,'customer' => 119,'trading'=>$trading->sale_report_id));
                    $receivable_data = array(
                        'customer' => 119,
                        'money' => 0,
                        'receivable_date' => $trading->sale_date,
                        'expect_date' => $receivable_datas->expect_date,
                        'week' => $receivable_datas->week,
                        'year' => $receivable_datas->year,
                        'code' => $receivable_datas->code,
                        'source' => $receivable_datas->source,
                        'comment' => $receivable_datas->comment,
                        'create_user' => $receivable_datas->create_user,
                        'type' => 4,
                        'trading' => $trading->sale_report_id,
                        'check_vat'=>1,
                    );
                    
                    $receivable->updateCosts($receivable_data,array('money'=>$customer_sale_datas->revenue_vat,'customer' => 119,'trading'=>$trading->sale_report_id));


                    $other_revenue = $data['check_vat']==0?$conlai:0;
                    $other_revenue_vat = $data['check_vat']==1?$conlai:0;

                    $data_update = array(
                        'profit' => $trading->profit+$other_revenue,
                        'profit_vat' => $trading->profit_vat+$other_revenue_vat,
                        'other_revenue' => $trading->other_revenue+$other_revenue,
                        'other_revenue_vat' => $trading->other_revenue_vat+$other_revenue_vat,

                    );
                    
                    $sale->updateSale($data_update,array('sale_report_id' => $trading->sale_report_id));


                    $trading = $sale->getSaleByWhere(array('code'=>$data['code']));

                    $salesdata = $sales_model->getSalesByWhere(array('trading'=>$trading->sale_report_id));

                    $data_sales = array(
                        
                        'revenue' => $trading->revenue+$trading->revenue_vat+$trading->other_revenue+$trading->other_revenue_vat,
                        'profit' => $trading->revenue+$trading->revenue_vat+$trading->other_revenue+$trading->other_revenue_vat-$trading->cost-$trading->cost_vat-$trading->estimate_cost-$trading->estimate_cost_2,
                        
                        'sales_update_user' => $_SESSION['userid_logined'],
                        'sales_update_time' => strtotime(date('d-m-Y')),
                    );
                    $sales_model->updateSales($data_sales,array('sales_id'=>$salesdata->sales_id));

                }*/

                
                
                    $tire_sale_model->createTire($data);
                    echo "Thêm thành công";

                 

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$tire_sale_model->getLastTire()->tire_sale_id."|tire_sale|".implode("-",$data)."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                
                
            }
                    
        }
    }

    public function deletesale(){
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tire_sale_model = $this->model->get('tiresaleModel');
           
            if (isset($_POST['xoa'])) {
                $data = explode(',', $_POST['xoa']);
                foreach ($data as $data) {
                       $tire_sale_model->deleteTire($data);
                        echo "Xóa thành công";
                        date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$data."|tire_sale|"."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                    
                    
                }
                return true;
            }
            else{
                        $tire_sale_model->deleteTire($_POST['data']);
                        echo "Xóa thành công";
                        date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$_POST['data']."|tire_sale|"."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                    
            }
            
        }
    }

    public function addcost(){
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        if (isset($_POST['yes'])) {
            
            $tire_excess_model = $this->model->get('tireexcessModel');
            $data = array(
                        
                        'code' => trim($_POST['code']),
                        'tire_excess_name' => trim($_POST['tire_excess_name']),
                        'tire_excess_type' => trim($_POST['tire_excess_type']),
                        'tire_excess' => trim(str_replace(',','',$_POST['tire_excess'])),
                        'tire_excess_vat' => trim(str_replace(',','',$_POST['tire_excess_vat'])),
                        'tire_excess_brand' => trim($_POST['tire_excess_brand']),
                        'tire_excess_size' => trim($_POST['tire_excess_size']),
                        'customer' => trim($_POST['customer']),
                        'tire_excess_pattern' => trim($_POST['tire_excess_pattern']),
                        );
            

            if ($_POST['yes'] != "") {
                


                    $tire_excess_model->updateTire($data,array('tire_excess_id' => trim($_POST['yes'])));
                    echo "Cập nhật thành công";

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|tire_excess|".implode("-",$data)."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                
                
            }
            else{
                
                
                    $tire_excess_model->createTire($data);
                    echo "Thêm thành công";

                 

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$tire_excess_model->getLastTire()->tire_excess_id."|tire_excess|".implode("-",$data)."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                
                
            }
                    
        }
    }

    public function deletecost(){
        if (!isset($_SESSION['userid_logined'])) {
            return $this->view->redirect('user/login');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tire_excess_model = $this->model->get('tireexcessModel');
           
            if (isset($_POST['xoa'])) {
                $data = explode(',', $_POST['xoa']);
                foreach ($data as $data) {
                       $tire_excess_model->deleteTire($data);
                        echo "Xóa thành công";
                        date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$data."|tire_excess|"."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                    
                    
                }
                return true;
            }
            else{
                        $tire_excess_model->deleteTire($_POST['data']);
                        echo "Xóa thành công";
                        date_default_timezone_set("Asia/Ho_Chi_Minh"); 
                        $filename = "action_logs.txt";
                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$_POST['data']."|tire_excess|"."\n"."\r\n";
                        
                        $fh = fopen($filename, "a") or die("Could not open log file.");
                        fwrite($fh, $text) or die("Could not write file!");
                        fclose($fh);
                    
            }
            
        }
    }

}
?>