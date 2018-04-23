<?php



Class vnController Extends baseController {


    public function index() {

        /*** set a template variable ***/

            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';

        /*** load the index template ***/

            $this->view->data['title'] = 'Việt Trade';



            $this->view->data['lib'] = $this->lib;


            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;



            $tire_product_model = $this->model->get('tireproductModel');

            $tire_producer_model = $this->model->get('tireproducerModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');



            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );

            $this->view->data['limit'] = 10;

            $tire_product_features = $tire_product_model->getAllTire($data,$join);


            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));



            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_producers'] = $tire_producers;

            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('index/index');

    }

    public function views() {



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            $tire_product_model = $this->model->get('tireproductModel');

            $tire_producer_model = $this->model->get('tireproducerModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $data = array(

                'order_by' => 'RAND()',

                'limit' => '6',

                'where' => 'tire_product_plies = 1',

            );



            $tire_product_tbrs = $tire_product_model->getAllTire($data,$join);



            $data = array(

                'order_by' => 'RAND()',

                'limit' => '6',

                'where' => 'tire_product_plies = 2',

            );



            $tire_product_nylons = $tire_product_model->getAllTire($data,$join);



            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));



            $tire_products = array();

            foreach ($tire_producers as $tire_producer) {

                $data = array(

                    'order_by' => 'RAND()',

                    'limit' => '3',

                    'where' => 'tire_producer = '.$tire_producer->tire_producer_id,

                );



                $tire_products[$tire_producer->tire_producer_id] = $tire_product_model->getAllTire($data,$join);

            }





            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_product_tbrs'] = $tire_product_tbrs;

            $this->view->data['tire_product_nylons'] = $tire_product_nylons;

            $this->view->data['tire_products'] = $tire_products;

            $this->view->data['tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;



            $this->view->show('vn/view');



    }

    public function thong_so_lop() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Thông số kỹ thuật lốp xe';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Thông số kỹ thuật lốp xe" href="'.BASE_URL.'/vn/thong-so-lop" itemprop="url">            

                      <span itemprop="title">Thông số kỹ thuật lốp xe</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            

        $this->view->show('vn/thongsolop');
    }

    public function dai_ly_lop_xe() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Đại lý lốp xe';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Đại lý lốp xe" href="'.BASE_URL.'/vn/dai-ly-lop-xe" itemprop="url">            

                      <span itemprop="title">Đại lý lốp xe</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/dailylopxe');
    }

    public function dai_ly() {

        $this->view->setLayout('detail');
        $this->view->data['lib'] = $this->lib;

        $this->view->data['title'] = 'Đại lý lốp xe, đại lý vỏ xe';
        $this->view->data['description'] = 'Đại lý lốp xe, đại lý vỏ xe chuyên bán các loại lốp xe, vỏ xe chính hãng chất lượng cao giá rẻ nhất dùng cho xe ô tô, xe tải, xe container, xe ben tại Hồ Chí Minh, Đồng Nai, Bình Dương, Tây Ninh, Bình Phước, Bà Rịa Vũng Tàu...';

        $link_breadcrumb = '

        <span class="arrow">›</span>        

          <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

            <a title="Đại lý lốp xe" href="'.BASE_URL.'/vn/dai-ly" itemprop="url">            

              <span itemprop="title">Danh sách đại lý</span>

            </a>

          </div>

        ';

        $ten = "";

        $name = $this->registry->router->param_id;
        if ($name != "") {
            $arr = array(
                'mien-bac' => 'Miền Bắc',
                'mien-trung' => 'Miền Trung',
                'tay-nguyen' => 'Tây Nguyên',
                'mien-nam' => 'Miền Nam',
                'dong-bac-bo' => 'Đông Bắc Bộ',
                'tay-bac-bo' => 'Tây Bắc Bộ',
                'ha-noi' => 'Hà Nội',
                'bac-trung-bo' => 'Bắc Trung Bộ',
                'da-nang' => 'Đà Nẵng',
                'quang-nam' => 'Quảng Nam',
                'quang-ngai' => 'Quảng Ngãi',
                'binh-dinh' => 'Bình Định',
                'phu-yen' => 'Phú Yên',
                'khanh-hoa' => 'Khánh Hòa',
                'ninh-thuan' => 'Ninh Thuận',
                'binh-thuan' => 'Bình Thuận',
                'gia-lai' => 'Gia Lai',
                'kon-tum' => 'Kon Tum',
                'dak-lak' => 'Đắk Lắk',
                'lam-dong' => 'Lâm Đồng',
                'dak-nong' => 'Đắk Nông',
                'ho-chi-minh' => 'TP. Hồ Chí Minh',
                'dong-nai' => 'Đồng Nai',
                'binh-duong' => 'Bình Dương',
                'ba-ria-vung-tau' => 'Bà Rịa - Vũng Tàu',
                'tay-ninh' => 'Tây Ninh',
                'binh-phuoc' => 'Bình Phước',
                'long-an' => 'Long An',
                'can-tho' => 'Cần Thơ',
            );
            $ten = $arr[$name];
        }

        $this->view->data['ten'] = $ten;

        if ($ten != "") {
            $this->view->data['title'] = 'Đại lý lốp xe tại '.$ten;
            $this->view->data['description'] = 'Đại lý lốp xe tại '.$ten.', đại lý vỏ xe tại '.$ten.' chuyên bán các loại lốp xe, vỏ xe chính hãng chất lượng cao giá rẻ nhất dùng cho xe ô tô, xe tải, xe container, xe ben';


            $link_breadcrumb = '

            <span class="arrow">›</span>        

              <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                <a title="Đại lý lốp xe" href="'.BASE_URL.'/vn/dai-ly-lop-xe" itemprop="url">            

                  <span itemprop="title">Danh sách đại lý</span>

                </a>

                <span class="arrow">›</span>        

                <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                  <a title="Đại lý lốp xe tại '.$ten.'" href="'.BASE_URL.'/vn/dai-ly/'.$name.'" itemprop="url">      

                    <span itemprop="title">Đại lý lốp xe tại '.$ten.'</span>

                  </a>

                </div>

              </div>

            ';
        }


        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            

            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/daily');
    }

    public function lop_xe_bo_kem() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Lốp bố kẽm';

            $this->view->data['lib'] = $this->lib;


            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : null;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_producer_id';



                $order = $this->registry->router->order ? $this->registry->router->order : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $sonews = $limit;



            $x = ($page-1) * $sonews;



            $pagination_stages = 2;



            $data = array(

                'where' => 'tire_product_plies = 1',

            );



            $tire_product_tbrs = $tire_product_model->getAllTire($data,$join);



            $tongsodong = count($tire_product_tbrs);



            $tongsotrang = ceil($tongsodong / $sonews);



            $this->view->data['page'] = $page;



            $this->view->data['order_by'] = $order_by;



            $this->view->data['order'] = $order;



            $this->view->data['keyword'] = $keyword;



            $this->view->data['pagination_stages'] = $pagination_stages;



            $this->view->data['tongsotrang'] = $tongsotrang;



            $this->view->data['sonews'] = $sonews;

            $this->view->data['limit'] = $limit;



            $data = array(



                'order_by'=>$order_by,



                'order'=>$order,



                'limit'=>$x.','.$sonews,



                'where' => 'tire_product_plies = 1',



                );



            $tire_product_tbrs = $tire_product_model->getAllTire($data,$join);





            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Lốp xe bố kẽm" href="'.BASE_URL.'/vn/lop-xe-bo-kem" itemprop="url">            

                      <span itemprop="title">Lốp xe bố kẽm</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_product_tbrs'] = $tire_product_tbrs;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/index');



    }



    public function lop_xe_bo_nylon() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Lốp bố nylon';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : null;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_producer_id';



                $order = $this->registry->router->order ? $this->registry->router->order : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $sonews = $limit;



            $x = ($page-1) * $sonews;



            $pagination_stages = 2;



            $data = array(

                'where' => 'tire_product_plies = 2',

            );



            $tire_product_nylons = $tire_product_model->getAllTire($data,$join);



            $tongsodong = count($tire_product_nylons);



            $tongsotrang = ceil($tongsodong / $sonews);



            $this->view->data['page'] = $page;



            $this->view->data['order_by'] = $order_by;



            $this->view->data['order'] = $order;



            $this->view->data['keyword'] = $keyword;



            $this->view->data['pagination_stages'] = $pagination_stages;



            $this->view->data['tongsotrang'] = $tongsotrang;



            $this->view->data['sonews'] = $sonews;

            $this->view->data['limit'] = $limit;



            $data = array(



                'order_by'=>$order_by,



                'order'=>$order,



                'limit'=>$x.','.$sonews,



                'where' => 'tire_product_plies = 2',



                );



            $tire_product_nylons = $tire_product_model->getAllTire($data,$join);



            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Lốp xe bố nylon" href="'.BASE_URL.'/vn/lop-xe-bo-nylon" itemprop="url">            

                      <span itemprop="title">Lốp xe bố nylon</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_product_nylons'] = $tire_product_nylons;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;


            $this->view->show('vn/index');



    }



    public function lop_xe_co_ruot() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Lốp có ruột';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : null;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_producer_id';



                $order = $this->registry->router->order ? $this->registry->router->order : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $sonews = $limit;



            $x = ($page-1) * $sonews;



            $pagination_stages = 2;



            $data = array(

                'where' => 'tire_product_tube = 1',

            );



            $tire_product_tubes = $tire_product_model->getAllTire($data,$join);



            $tongsodong = count($tire_product_tubes);



            $tongsotrang = ceil($tongsodong / $sonews);



            $this->view->data['page'] = $page;



            $this->view->data['order_by'] = $order_by;



            $this->view->data['order'] = $order;



            $this->view->data['keyword'] = $keyword;



            $this->view->data['pagination_stages'] = $pagination_stages;



            $this->view->data['tongsotrang'] = $tongsotrang;



            $this->view->data['sonews'] = $sonews;

            $this->view->data['limit'] = $limit;



            $data = array(



                'order_by'=>$order_by,



                'order'=>$order,



                'limit'=>$x.','.$sonews,



                'where' => 'tire_product_tube = 1',



                );





            $tire_product_tubes = $tire_product_model->getAllTire($data,$join);



            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Lốp xe có ruột" href="'.BASE_URL.'/vn/lop-xe-co-ruot" itemprop="url">            

                      <span itemprop="title">Lốp xe có ruột</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_product_tubes'] = $tire_product_tubes;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/index');



    }



    public function lop_xe_khong_ruot() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Lốp không ruột';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : null;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_producer_id';



                $order = $this->registry->router->order ? $this->registry->router->order : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $sonews = $limit;



            $x = ($page-1) * $sonews;



            $pagination_stages = 2;



            $data = array(

                'where' => 'tire_product_tube = 2',

            );



            $tire_product_tubeless = $tire_product_model->getAllTire($data,$join);



            $tongsodong = count($tire_product_tubeless);



            $tongsotrang = ceil($tongsodong / $sonews);



            $this->view->data['page'] = $page;



            $this->view->data['order_by'] = $order_by;



            $this->view->data['order'] = $order;



            $this->view->data['keyword'] = $keyword;



            $this->view->data['pagination_stages'] = $pagination_stages;



            $this->view->data['tongsotrang'] = $tongsotrang;



            $this->view->data['sonews'] = $sonews;

            $this->view->data['limit'] = $limit;



            $data = array(



                'order_by'=>$order_by,



                'order'=>$order,



                'limit'=>$x.','.$sonews,



                'where' => 'tire_product_tube = 2',



                );





            $tire_product_tubeless = $tire_product_model->getAllTire($data,$join);



            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Lốp xe không ruột" href="'.BASE_URL.'/vn/lop-xe-khong-ruot" itemprop="url">            

                      <span itemprop="title">Lốp xe không ruột</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_product_tubeless'] = $tire_product_tubeless;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/index');



    }



    public function lop_xe_tai() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Lốp xe tải';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : null;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_producer_id';



                $order = $this->registry->router->order ? $this->registry->router->order : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $sonews = $limit;



            $x = ($page-1) * $sonews;



            $pagination_stages = 2;



            $data = array(

                'where' => 'tire_product_vehicle IN (SELECT tire_vehicle_id FROM tire_vehicle WHERE tire_vehicle_type = 1)',

            );



            $tire_product_trucks = $tire_product_model->getAllTire($data,$join);



            $tongsodong = count($tire_product_trucks);



            $tongsotrang = ceil($tongsodong / $sonews);



            $this->view->data['page'] = $page;



            $this->view->data['order_by'] = $order_by;



            $this->view->data['order'] = $order;



            $this->view->data['keyword'] = $keyword;



            $this->view->data['pagination_stages'] = $pagination_stages;



            $this->view->data['tongsotrang'] = $tongsotrang;



            $this->view->data['sonews'] = $sonews;

            $this->view->data['limit'] = $limit;



            $data = array(



                'order_by'=>$order_by,



                'order'=>$order,



                'limit'=>$x.','.$sonews,



                'where' => 'tire_product_vehicle IN (SELECT tire_vehicle_id FROM tire_vehicle WHERE tire_vehicle_type = 1)',



                );



            $tire_product_trucks = $tire_product_model->getAllTire($data,$join);

            $param_id = $this->registry->router->param_id;

            $param = str_replace('?', '', strstr(rawurldecode($_SERVER['REQUEST_URI']),"?"));

            if ($param_id != "") {
                $param = rawurldecode($param_id);
            }

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Lốp xe tải & bus" href="'.BASE_URL.'/vn/lop-xe-tai" itemprop="url">            

                      <span itemprop="title">Lốp xe tải & bus</span>

                    </a>

                    <span class="arrow">›</span>        

                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                      <a title="'.$param.'" href="'.BASE_URL.'/vn/lop-xe-tai?'.$param.'" itemprop="url">      

                        <span itemprop="title">'.$param.'</span>

                      </a>

                    </div>

                  </div>

                ';



            $param = $param!=""?$param:"Lốp xe tải & bus";

            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_product_trucks'] = $tire_product_trucks;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $this->view->data['param'] = $param;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/index');



    }



    public function lop_xe_du_lich() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Lốp xe du lịch';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : null;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_producer_id';



                $order = $this->registry->router->order ? $this->registry->router->order : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $sonews = $limit;



            $x = ($page-1) * $sonews;



            $pagination_stages = 2;



            $data = array(

                'where' => 'tire_product_vehicle IN (SELECT tire_vehicle_id FROM tire_vehicle WHERE tire_vehicle_type = 2)',

            );



            $tire_product_cars = $tire_product_model->getAllTire($data,$join);



            $tongsodong = count($tire_product_cars);



            $tongsotrang = ceil($tongsodong / $sonews);



            $this->view->data['page'] = $page;



            $this->view->data['order_by'] = $order_by;



            $this->view->data['order'] = $order;



            $this->view->data['keyword'] = $keyword;



            $this->view->data['pagination_stages'] = $pagination_stages;



            $this->view->data['tongsotrang'] = $tongsotrang;



            $this->view->data['sonews'] = $sonews;

            $this->view->data['limit'] = $limit;



            $data = array(



                'order_by'=>$order_by,



                'order'=>$order,



                'limit'=>$x.','.$sonews,



                'where' => 'tire_product_vehicle IN (SELECT tire_vehicle_id FROM tire_vehicle WHERE tire_vehicle_type = 2)',



                );



            $tire_product_cars = $tire_product_model->getAllTire($data,$join);



            $param_id = $this->registry->router->param_id;

            $param = str_replace('?', '', strstr(rawurldecode($_SERVER['REQUEST_URI']),"?"));

            if ($param_id != "") {
                $param = rawurldecode($param_id);
            }



            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Lốp xe du lịch" href="'.BASE_URL.'/vn/lop-xe-du-lich" itemprop="url">            

                      <span itemprop="title">Lốp xe du lịch</span>

                    </a>

                    <span class="arrow">›</span>        

                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                      <a title="'.$param.'" href="'.BASE_URL.'/vn/lop-xe-du-lich?'.$param.'" itemprop="url">      

                        <span itemprop="title">'.$param.'</span>

                      </a>

                    </div>

                  </div>

                ';



            $param = $param!=""?$param:"Lốp xe du lịch";



            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_product_cars'] = $tire_product_cars;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $this->view->data['param'] = $param;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/index');



    }



    public function lop_xe_dac_chung() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Lốp xe đặc chủng';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : null;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_producer_id';



                $order = $this->registry->router->order ? $this->registry->router->order : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $sonews = $limit;



            $x = ($page-1) * $sonews;



            $pagination_stages = 2;



            $data = array(

                'where' => 'tire_product_vehicle IN (SELECT tire_vehicle_id FROM tire_vehicle WHERE tire_vehicle_type = 3)',

            );



            $tire_product_otrs = $tire_product_model->getAllTire($data,$join);



            $tongsodong = count($tire_product_otrs);



            $tongsotrang = ceil($tongsodong / $sonews);



            $this->view->data['page'] = $page;



            $this->view->data['order_by'] = $order_by;



            $this->view->data['order'] = $order;



            $this->view->data['keyword'] = $keyword;



            $this->view->data['pagination_stages'] = $pagination_stages;



            $this->view->data['tongsotrang'] = $tongsotrang;



            $this->view->data['sonews'] = $sonews;

            $this->view->data['limit'] = $limit;



            $data = array(



                'order_by'=>$order_by,



                'order'=>$order,



                'limit'=>$x.','.$sonews,



                'where' => 'tire_product_vehicle IN (SELECT tire_vehicle_id FROM tire_vehicle WHERE tire_vehicle_type = 3)',



                );



            $tire_product_otrs = $tire_product_model->getAllTire($data,$join);



            $param_id = $this->registry->router->param_id;

            $param = str_replace('?', '', strstr(rawurldecode($_SERVER['REQUEST_URI']),"?"));

            if ($param_id != "") {
                $param = rawurldecode($param_id);
            }



            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Lốp xe đặc chủng" href="'.BASE_URL.'/vn/lop-xe-dac-chung" itemprop="url">            

                      <span itemprop="title">Lốp xe đặc chủng</span>

                    </a>

                    <span class="arrow">›</span>        

                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                      <a title="'.$param.'" href="'.BASE_URL.'/vn/lop-xe-dac-chung?'.$param.'" itemprop="url">      

                        <span itemprop="title">'.$param.'</span>

                      </a>

                    </div>

                  </div>

                ';



            $param = $param!=""?$param:"Lốp xe đặc chủng";



            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_product_otrs'] = $tire_product_otrs;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $this->view->data['param'] = $param;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/index');



    }



    public function lop_xe_theo_hang_san_xuat() {

        $this->view->setLayout('detail');


        $this->view->data['limit'] = 10;
        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Hãng sản xuất lốp xe | Việt Trade';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            $tire_product_model = $this->model->get('tireproductModel');

            $tire_producer_model = $this->model->get('tireproducerModel');

            $tire_pattern_model = $this->model->get('tireproductpatternModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));



            $tire_products = array();
            $tire_patterns = array();

            foreach ($tire_producers as $tire_producer) {

                $data_pattern = array(

                    'where' => 'tire_product_pattern_id IN (SELECT tire_pattern FROM tire_product WHERE tire_producer = '.$tire_producer->tire_producer_id.')',

                );



                //$tire_patterns[$tire_producer->tire_producer_id] = $tire_pattern_model->getAllTire($data_pattern);
                $tire_patterns[$tire_producer->tire_producer_id] = array();

            }





            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Hãng sản xuất" href="'.BASE_URL.'/vn/lop-xe-theo-hang-san-xuat" itemprop="url">            

                      <span itemprop="title">Hãng sản xuất</span>

                    </a>

                  </div>

                ';



            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_producers'] = $tire_producers;

            $this->view->data['tire_products'] = $tire_products;

            $this->view->data['tire_patterns'] = $tire_patterns;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/index');



    }

    public function lop_theo_hang_san_xuat() {

        $this->view->setLayout('detail');


        $this->view->data['limit'] = 10;
        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Hãng sản xuất lốp xe | Việt Trade';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            $tire_product_model = $this->model->get('tireproductModel');

            $tire_producer_model = $this->model->get('tireproducerModel');

            $tire_pattern_model = $this->model->get('tireproductpatternModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));



            $tire_products = array();
            $tire_patterns = array();

            foreach ($tire_producers as $tire_producer) {

                $data_pattern = array(

                    'where' => 'tire_product_pattern_id IN (SELECT tire_pattern FROM tire_product WHERE tire_producer = '.$tire_producer->tire_producer_id.')',

                );



                //$tire_patterns[$tire_producer->tire_producer_id] = $tire_pattern_model->getAllTire($data_pattern);
                $tire_patterns[$tire_producer->tire_producer_id] = array();

            }





            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Hãng sản xuất" href="'.BASE_URL.'/vn/lop-xe-theo-hang-san-xuat" itemprop="url">            

                      <span itemprop="title">Hãng sản xuất</span>

                    </a>

                  </div>

                ';



            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_producers'] = $tire_producers;

            $this->view->data['tire_products'] = $tire_products;

            $this->view->data['tire_patterns'] = $tire_patterns;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/index');



    }



    public function brand() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/


            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;


                $order = isset($_POST['order']) ? $_POST['order'] : null;


                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : null;

                $brand_name = isset($_POST['brand']) ? $_POST['brand'] : null;

                $pattern_name = isset($_POST['pattern']) ? $_POST['pattern'] : null;

            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'RAND()';



                $order = $this->registry->router->order ? $this->registry->router->order : null;



                $keyword = "";



                $limit = 12;

                $brand_name = ucwords(str_replace('-', ' ', $this->registry->router->param_id));

                $pattern_name = $this->registry->router->page;

            }



            if ($brand_name != "") {
                $this->view->data['title'] = "Lốp xe ".$brand_name;
                $this->view->data['img_prop'] = BASE_URL."/public/images/upload/".$this->registry->router->param_id.".jpg";
                $this->view->data['description'] = "Lốp xe, vỏ xe ".$brand_name." chính hãng, có ruột, không ruột đảm bảo chất lượng, giá rẻ dùng cho xe tải, xe container, xe ben, xe khách, xe ô tô";
            }
            else{
                $this->view->data['title'] = 'Hãng sản xuất lốp xe | Việt Trade';
            }



            $tire_product_model = $this->model->get('tireproductModel');

            $tire_producer_model = $this->model->get('tireproducerModel');

            $tire_pattern_model = $this->model->get('tireproductpatternModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $data = array(

                    'where' => 'tire_producer_name LIKE "%'.$brand_name.'%"',

                );

            if ($brand_name == "") {
                $data = array();
            }



            $tire_producers = $tire_producer_model->getAllTire($data);

            $tire_patterns = array();

            $tire_products = array();

            foreach ($tire_producers as $tire_producer) {


                if ($brand_name == "") {
                    $tire_patterns[$tire_producer->tire_producer_id] = array();
                }
                else{
                    $data_pattern = array(

                        'where' => 'tire_product_pattern_id IN (SELECT tire_pattern FROM tire_product WHERE tire_producer = '.$tire_producer->tire_producer_id.')',

                    );

                    $tire_patterns[$tire_producer->tire_producer_id] = $tire_pattern_model->getAllTire($data_pattern);

                    if ($pattern_name != "") {
                        $data = array(

                            'where' => 'tire_producer = '.$tire_producer->tire_producer_id.' AND tire_pattern = '.$pattern_name,

                        );



                        $tire_products = $tire_product_model->getAllTire($data,$join);

                        $this->view->data['tire_brand_name'] = $tire_producer->tire_producer_name;
                        $this->view->data['tire_pattern_name'] = $tire_pattern_model->getTire($pattern_name);
                    }
                }

                /*if (count($tire_producers) == 1) {

                    $sonews = $limit;



                    $x = ($page-1) * $sonews;



                    $pagination_stages = 2;



                    $data = array(

                        'where' => 'tire_producer = '.$tire_producer->tire_producer_id,

                    );



                    $tire_product_otrs = $tire_product_model->getAllTire($data,$join);



                    $tongsodong = count($tire_product_otrs);



                    $tongsotrang = ceil($tongsodong / $sonews);



                    $this->view->data['page'] = $page;



                    $this->view->data['order_by'] = $order_by;



                    $this->view->data['order'] = $order;



                    $this->view->data['keyword'] = $keyword;



                    $this->view->data['pagination_stages'] = $pagination_stages;



                    $this->view->data['tongsotrang'] = $tongsotrang;



                    $this->view->data['sonews'] = $sonews;

                    $this->view->data['limit'] = $limit;



                    $data = array(



                        'order_by'=>$order_by,



                        'order'=>$order,



                        'limit'=>$x.','.$sonews,



                        'where' => 'tire_producer = '.$tire_producer->tire_producer_id,



                        );



                    $tire_products[$tire_producer->tire_producer_id] = $tire_product_model->getAllTire($data,$join);

                }



                else{

                    $data = array(



                        'order_by'=> 'RAND()',



                        'limit'=> '3',



                        'where' => 'tire_producer = '.$tire_producer->tire_producer_id,



                        );



                    $tire_products[$tire_producer->tire_producer_id] = $tire_product_model->getAllTire($data,$join);

                }*/

                

            }


            $this->view->data['limit'] = $limit;
            



            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Hãng sản xuất" href="'.BASE_URL.'/vn/lop-xe-theo-hang-san-xuat" itemprop="url">            

                      <span itemprop="title">Hãng sản xuất</span>

                    </a>

                    <span class="arrow">›</span>        

                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                      <a title="'.$brand_name.'" href="'.BASE_URL.'/vn/brand/'.$this->registry->router->param_id.'" itemprop="url">      

                        <span itemprop="title">'.$brand_name.'</span>

                      </a>

                    </div>

                  </div>

                ';

            if (isset($this->view->data['tire_pattern_name'])) {
                $this->view->data['title'] = "Lốp xe ".$brand_name." mã gai ".$this->view->data['tire_pattern_name']->tire_product_pattern_name;

                $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Hãng sản xuất" href="'.BASE_URL.'/vn/lop-xe-theo-hang-san-xuat" itemprop="url">            

                      <span itemprop="title">Hãng sản xuất</span>

                    </a>

                    <span class="arrow">›</span>        

                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                      <a title="'.$brand_name.'" href="'.BASE_URL.'/vn/brand/'.$this->registry->router->param_id.'" itemprop="url">      

                        <span itemprop="title">'.$brand_name.'</span>

                      </a>

                    </div>

                    <span class="arrow">›</span>        

                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                      <a title="'.$brand_name.' '.$this->view->data['tire_pattern_name']->tire_product_pattern_name.'" href="'.BASE_URL.'/vn/brand/'.$this->registry->router->param_id.'/'.$pattern_name.'" itemprop="url">      

                        <span itemprop="title">'.$this->view->data['tire_pattern_name']->tire_product_pattern_name.'</span>

                      </a>

                    </div>

                  </div>

                ';
            }



            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_producers'] = $tire_producers;

            $this->view->data['tire_patterns'] = $tire_patterns;

            $this->view->data['tire_brand_products'] = $tire_products;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/index');



    }



    public function detail() {

        $this->view->setLayout('detail');

        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            $link = $this->registry->router->param_id;



            $tire_product_model = $this->model->get('tireproductModel');

            $tire_vehicle_model = $this->model->get('tirevehicleModel');



            $tire_vehicles = $tire_vehicle_model->getAllTire();

            foreach ($tire_vehicles as $tire_vehicle) {

                $data_vehicle[$tire_vehicle->tire_vehicle_id]['name'] = $tire_vehicle->tire_vehicle_name;

                $data_vehicle[$tire_vehicle->tire_vehicle_id]['type'] = $tire_vehicle->tire_vehicle_type;

            }



            $this->view->data['data_vehicle'] = $data_vehicle;

            $vehicle = null;
            $link_breadcrumb = "";

            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'limit' => '1',

                'where' => 'tire_product_link = "'.$link.'"',

            );



            $tire_products = $tire_product_model->getAllTire($data,$join);

            $tire_product_relatives = array();

            foreach ($tire_products as $tire_product) {

                $this->view->data['title'] = "Lốp xe ".$tire_product->tire_producer_name.' '.$tire_product->tire_product_size_number.' '.$tire_product->tire_product_name.'';
                $this->view->data['img_prop'] = $tire_product->tire_product_thumb != "" ? BASE_URL."/public/images/upload/".$tire_product->tire_product_thumb : BASE_URL."/public/images/upload/".$tire_product->tire_product_pattern_type."jpg";
                $this->view->data['description'] = $tire_product->tire_product_desc != "" ? $tire_product->tire_product_desc : "Lốp xe, vỏ xe ".$tire_product->tire_producer_name.' '.$tire_product->tire_product_size_number.' '.$tire_product->tire_product_name." chính hãng, có ruột, không ruột đảm bảo chất lượng, giá rẻ dùng cho xe tải, xe container, xe ben, xe khách, xe ô tô";
                $this->view->data['price_prop'] = $tire_product->tire_retail;

                $data = array(

                    'order_by' => 'RAND()',

                    'limit' => '8',

                    'where' => 'tire_size = '.$tire_product->tire_size,

                );



                $tire_product_relatives = $tire_product_model->getAllTire($data,$join);



                $vehicle = $tire_vehicle_model->getTire(substr($tire_product->tire_product_vehicle,0,1));



                $l_v = !isset($vehicle->tire_vehicle_type)?"lop-xe":($vehicle->tire_vehicle_type==1?"lop-xe-tai":($vehicle->tire_vehicle_type==2?"lop-xe-du-lich":($vehicle->tire_vehicle_type==3?"lop-xe-dac-chung":"lop-xe")));



                $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="'.$tire_product->tire_producer_name.'" href="'.BASE_URL.'/vn/brand/'.strtolower(str_replace(' ', '-', $tire_product->tire_producer_name)).'" itemprop="url">            

                      <span itemprop="title">'.$tire_product->tire_producer_name.'</span>

                    </a>

                    <span class="arrow">›</span>        

                    <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                      <a title="Lốp xe '.$tire_product->tire_producer_name.' '.$tire_product->tire_product_size_number.' '.$tire_product->tire_product_name.'" href="'.BASE_URL.'/vn/detail/'.$tire_product->tire_product_link.'" itemprop="url">      

                        <span itemprop="title">Lốp xe '.$tire_product->tire_producer_name.' '.$tire_product->tire_product_size_number.' '.$tire_product->tire_product_name.'</span>

                      </a>

                    </div>

                  </div>

                ';

            }



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $data = array(

                'order_by' => 'RAND()',

                'limit' => '1',

            );



            $tire_product_others = $tire_product_model->getAllTire($data,$join);



            



            $this->view->data['tire_product_s'] = $tire_products;

            $this->view->data['tire_product_other_s'] = $tire_product_others;

            $this->view->data['tire_product_relatives'] = $tire_product_relatives;

            $this->view->data['tire_product_features'] = $tire_product_features;



            $this->view->data['vehicle'] = $vehicle;



            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/detail');



    }

    public function ban_do() {
        $this->view->setLayout('detail');

            $this->view->data['title'] = 'Bản đồ Đại lý lốp xe, vỏ xe chính hãng';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Bản đồ đường đi" href="'.BASE_URL.'/vn/ban-do" itemprop="url">            

                      <span itemprop="title">Bản đồ đường đi</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/bando');


    }


    public function tim_kiem() {

        $this->view->setLayout('detail');
        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

        $data = array(

            'order_by' => 'post_date',

            'order' => 'DESC',

            'limit' => '10',

            'where' => '1=1',

        );

        $new_posts = $post_model->getAllPost($data);

        $this->view->data['new_posts'] = $new_posts;

        $keyword = null;
        $rimSize = null;
        $width = null;
        $brand = null;
        $pattern_name = null;
        $ratio = null;
        $position = null;
        $usage = null;
        $sort_select = 0;
        $limit = 18;
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $pagination_stages = 2;
        $tongsotrang = 0;
        $sonews = 0;
        $order_by = 'RAND()';
        $order = "";
        $min_price = "Tất cả";
        $max_price = "Tất cả";

        $tire_product_model = $this->model->get('tireproductModel');

        $tire_producer_model = $this->model->get('tireproducerModel');

        $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

        $tire_products = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_POST['keyword'])) {
                $keyword = trim($_POST['keyword']);
                $order_by = 'RAND()';
                $limit = isset($_POST['limit'])?$_POST['limit']:18;

                if (isset($_POST['sort'])) {
                    if ($_POST['sort'] == 1) {
                        $order_by = 'tire_retail ASC';
                    }
                    elseif ($_POST['sort'] == 2) {
                        $order_by = 'tire_retail DESC';
                    }
                    $sort_select = $_POST['sort'];
                }

                $sonews = $limit;
                $x = ($page-1) * $sonews;
                $pagination_stages = 2;


                $data = array(
                    'where' => '"'.$keyword.'" LIKE CONCAT("%",tire_product_link,"%")',
                );

                
                $tongsodong = count($tire_product_model->getAllTire($data,$join));
                $tongsotrang = ceil($tongsodong / $sonews);

                $data = array(
                    'order_by' => $order_by,
                    'limit'=>$x.','.$sonews,
                    'where' => '"'.$keyword.'" LIKE CONCAT("%",tire_product_link,"%")',
                );
                $tire_products = $tire_product_model->getAllTire($data,$join);
                if ($tire_products == null) {
                    $sonews = $limit;
                    $x = ($page-1) * $sonews;
                    $pagination_stages = 2;


                    $data = array(
                        'where' => '"'.$keyword.'" LIKE CONCAT("%",tire_producer_name,"%")',
                    );

                    
                    $tongsodong = count($tire_product_model->getAllTire($data,$join));
                    $tongsotrang = ceil($tongsodong / $sonews);

                    $data = array(
                        'order_by' => $order_by,
                        'limit'=>$x.','.$sonews,
                        'where' => '"'.$keyword.'" LIKE CONCAT("%",tire_producer_name,"%")',
                    );
                    $tire_products = $tire_product_model->getAllTire($data,$join);

                    if ($tire_products == null) {
                        $sonews = $limit;
                        $x = ($page-1) * $sonews;
                        $pagination_stages = 2;


                        $data = array(
                            'where' => '"'.$keyword.'" LIKE CONCAT("%",tire_product_size_number,"%")',
                        );

                        
                        $tongsodong = count($tire_product_model->getAllTire($data,$join));
                        $tongsotrang = ceil($tongsodong / $sonews);

                        $data = array(
                            'order_by' => $order_by,
                            'limit'=>$x.','.$sonews,
                            'where' => '"'.$keyword.'" LIKE CONCAT("%",tire_product_size_number,"%")',
                        );
                        $tire_products = $tire_product_model->getAllTire($data,$join);

                        if ($tire_products == null) {
                            $sonews = $limit;
                            $x = ($page-1) * $sonews;
                            $pagination_stages = 2;


                            $data = array(
                                'where' => '"'.$keyword.'" LIKE CONCAT("%",tire_product_pattern_name,"%")',
                            );

                            
                            $tongsodong = count($tire_product_model->getAllTire($data,$join));
                            $tongsotrang = ceil($tongsodong / $sonews);

                            $data = array(
                                'order_by' => $order_by,
                                'limit'=>$x.','.$sonews,
                                'where' => '"'.$keyword.'" LIKE CONCAT("%",tire_product_pattern_name,"%")',
                            );
                            $tire_products = $tire_product_model->getAllTire($data,$join);

                            if ($tire_products == null) {
                                $sonews = $limit;
                                $x = ($page-1) * $sonews;
                                $pagination_stages = 2;


                                $data = array(
                                    'where' => '"'.$keyword.'" LIKE CONCAT("%",tire_product_pattern_type,"%")',
                                );

                                
                                $tongsodong = count($tire_product_model->getAllTire($data,$join));
                                $tongsotrang = ceil($tongsodong / $sonews);

                                $data = array(
                                    'order_by' => $order_by,
                                    'limit'=>$x.','.$sonews,
                                    'where' => '"'.$keyword.'" LIKE CONCAT("%",tire_product_pattern_type,"%")',
                                );
                                $tire_products = $tire_product_model->getAllTire($data,$join);

                                if ($tire_products == null) {
                                    $sonews = $limit;
                                    $x = ($page-1) * $sonews;
                                    $pagination_stages = 2;


                                    $data = array(
                                        'where' => '1=1',
                                    );

                                    
                                    $tongsodong = count($tire_product_model->getAllTire($data,$join));
                                    $tongsotrang = ceil($tongsodong / $sonews);

                                    $data = array(
                                        'order_by' => $order_by,
                                        'limit'=>$x.','.$sonews,
                                    );
                                    $tire_products = $tire_product_model->getAllTire($data,$join);
                                }
                            }
                        }
                    }
                }
            }
            else{
                $rimSize = trim($_POST['rimSize']);
                $width = trim($_POST['width']);
                $position = trim($_POST['position']);
                $brand = trim($_POST['brand']);
                $pattern_name = trim($_POST['pattern']);
                $price_range = trim($_POST['price_range']);

                $arr = explode(';', $price_range);
                $min_price = $arr[0];
                $max_price = $arr[1];

                $gia = 0;

                if ($min_price == "Tất cả" && $min_price == $max_price) {
                    $gia = -1;
                }
                elseif ($min_price == "Tất cả" && $max_price == "Trên 10,000,000") {
                    $gia = -1;
                }
                elseif ($min_price == "Tất cả" && $max_price != "Trên 10,000,000") {
                    $min_price = 0;
                }
                elseif ($min_price == "Trên 10,000,000" && $min_price == $max_price) {
                    $gia = 10000001;
                }

                $size = $width.$rimSize;
                $pattern = $position=="front"?'"DC01","DC02","DC03","DK01","DK02"':($position=="drive"?'"DK01","DK02","NK01","NK02"':($position=="trailer"?'"NC01","BC01","BC02"':null));

                $order_by = 'RAND()';
                $limit = isset($_POST['limit'])?$_POST['limit']:18;

                if (isset($_POST['sort'])) {
                    if ($_POST['sort'] == 1) {
                        $order_by = 'tire_retail ASC';
                    }
                    elseif ($_POST['sort'] == 2) {
                        $order_by = 'tire_retail DESC';
                    }
                    $sort_select = $_POST['sort'];
                }

                $sonews = $limit;
                $x = ($page-1) * $sonews;
                $pagination_stages = 2;


                $data = array(
                    'where' => '1=1',
                );
                if ($size != "") {
                    $data['where'] .= ' AND tire_product_size_number LIKE "%'.$size.'%"';
                }
                if ($pattern != null) {
                    $data['where'] .= ' AND tire_product_pattern_type IN ('.$pattern.')';
                }
                if ($brand != "") {
                    $data['where'] .= " AND tire_producer = ".$brand;
                }
                if ($pattern_name != "") {
                    $data['where'] .= ' AND tire_product_pattern_name = "'.$pattern_name.'"';
                }

                if ($gia == 10000001) {
                    $data['where'] .= ' AND tire_retail >= '.$gia;
                }
                elseif ($gia == 0) {
                    $data['where'] .= ' AND tire_retail >= '.$min_price.' AND tire_retail <= '.$max_price;
                }

                
                $tongsodong = count($tire_product_model->getAllTire($data,$join));
                $tongsotrang = ceil($tongsodong / $sonews);
                

                $data = array(
                    'order_by' => $order_by,
                    'limit'=>$x.','.$sonews,
                    'where' => '1=1',
                );

                if ($size != "") {
                    $data['where'] .= ' AND tire_product_size_number LIKE "%'.$size.'%"';
                }
                if ($pattern != null) {
                    $data['where'] .= ' AND tire_product_pattern_type IN ('.$pattern.')';
                }
                if ($brand != "") {
                    $data['where'] .= " AND tire_producer = ".$brand;
                }
                if ($pattern_name != "") {
                    $data['where'] .= ' AND tire_product_pattern_name = "'.$pattern_name.'"';
                }

                if ($gia == 10000001) {
                    $data['where'] .= ' AND tire_retail >= '.$gia;
                }
                elseif ($gia == 0) {
                    $data['where'] .= ' AND tire_retail >= '.$min_price.' AND tire_retail <= '.$max_price;
                }

                $tire_products = $tire_product_model->getAllTire($data,$join);
            }

            
        }

        $this->view->data['tire_products'] = $tire_products;

        $data = array(

            'order_by' => 'RAND()',

            'limit' => '10',

            'where' => 'tire_product_feature = 1',

        );



        $tire_product_features = $tire_product_model->getAllTire($data,$join);
        $this->view->data['tire_product_features'] = $tire_product_features;

        $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
        $this->view->data['list_tire_producers'] = $tire_producers;

        $producer = $tire_producer_model->getTire($brand);
        $this->view->data['producer_name'] = $producer;

        $this->view->data['keyword'] = $keyword;
        $this->view->data['rimSize'] = $rimSize;
        $this->view->data['width'] = $width;
        $this->view->data['position'] = $position;
        $this->view->data['brand'] = $brand;
        $this->view->data['pattern'] = $pattern_name;
        $this->view->data['min_price'] = $min_price;
        $this->view->data['max_price'] = $max_price;
        $this->view->data['sort_select'] = $sort_select;
        $this->view->data['limit'] = $limit;
        $this->view->data['page'] = $page;
        $this->view->data['order_by'] = $sort_select;
        $this->view->data['order'] = $order;
        $this->view->data['pagination_stages'] = $pagination_stages;
        $this->view->data['tongsotrang'] = $tongsotrang;
        $this->view->data['sonews'] = $sonews;

        $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/timkiem');


    }

    public function getPattern(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $brand = trim($_POST['data']);
            $pattern = isset($_POST['pattern'])?trim($_POST['pattern']):"";
            $str = "";

            $tire_product_model = $this->model->get('tireproductModel');
            $tire_pattern_model = $this->model->get('tireproductpatternModel');

            $tire_products = $tire_product_model->queryTire('SELECT tire_pattern FROM tire_product WHERE tire_producer = '.$brand.' GROUP BY tire_pattern');
            foreach ($tire_products as $tire_product) {
                $tire_patterns = $tire_pattern_model->getTire($tire_product->tire_pattern);
                $str .= '<option '.($pattern==$tire_patterns->tire_product_pattern_name?"selected":null).' value="'.$tire_patterns->tire_product_pattern_name.'">'.$tire_patterns->tire_product_pattern_name.'</option>';
            }

            echo $str;
        }
    }

    public function tu_van() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Thông số kỹ thuật lốp xe';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Thông số kỹ thuật lốp xe" href="'.BASE_URL.'/vn/thong-so-lop" itemprop="url">            

                      <span itemprop="title">Thông số kỹ thuật lốp xe</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/thongsolop');
    }

    public function gioi_thieu() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Giới thiệu công ty Việt Trade';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Việt Trade" href="'.BASE_URL.'" itemprop="url">            

                      <span itemprop="title">Việt Trade</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/gioithieu');
    }

    public function lien_he() {
        $this->view->setLayout('detail');

            $this->view->data['title'] = 'Liên hệ';

            $this->view->data['lib'] = $this->lib;

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Việt Trade" href="'.BASE_URL.'" itemprop="url">            

                      <span itemprop="title">Việt Trade</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/lienhe');


    }

    public function huong_dan_mua_hang() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Hướng dẫn mua hàng';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Hướng dẫn mua hàng" href="'.BASE_URL.'/vn/huong-dan-mua-hang" itemprop="url">            

                      <span itemprop="title">Hướng dẫn mua hàng</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/huongdan');
    }

    public function thong_tin_thanh_toan() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Thông tin thanh toán';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Thông tin thanh toán" href="'.BASE_URL.'/vn/thong-tin-thanh-toan" itemprop="url">            

                      <span itemprop="title">Thông tin thanh toán</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/thongtinthanhtoan');
    }
    public function giao_nhan_hang() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Giao hàng & Nhận hàng';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Giao hàng & Nhận hàng" href="'.BASE_URL.'/vn/giao-nhan-hang" itemprop="url">            

                      <span itemprop="title">Giao hàng & Nhận hàng</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/giaonhanhang');
    }
    public function dieu_khoan_su_dung() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Điều khoản sử dụng';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Điều khoản sử dụng" href="'.BASE_URL.'/vn/dieu-khoan-su-dung" itemprop="url">            

                      <span itemprop="title">Điều khoản sử dụng</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/dieukhoan');
    }
    public function chinh_sach_bao_mat() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Chính sách bảo mật';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Chính sách bảo mật" href="'.BASE_URL.'/vn/chinh-sach-bao-mat" itemprop="url">            

                      <span itemprop="title">Chính sách bảo mật</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/chinhsach');
    }
    public function chinh_sach_bao_hanh() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Chính sách bảo hành & đổi trả';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Chính sách bảo hành & đổi trả" href="'.BASE_URL.'/vn/chinh-sach-bao-hanh" itemprop="url">            

                      <span itemprop="title">Chính sách bảo hành & đổi trả</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $this->view->show('vn/baohanh');
    }

    public function bang_gia_lop_xe(){
        $this->view->setLayout('detail');
        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Bảng giá lốp xe';
        $this->view->data['description'] = 'Bảng giá lốp xe, vỏ xe ô tô, xe tải, xe container, xe khách, xe ben. Đại lý lốp xe chính hãng, chất lượng, giá rẻ nhập khẩu từ Thái Lan, Trung Quốc, Ấn Độ';

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



        $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

        $data = array(

            'order_by' => 'RAND()',

            'limit' => '10',

            'where' => 'tire_product_feature = 1',

        );



        $tire_product_features = $tire_product_model->getAllTire($data,$join);

        $link_breadcrumb = '

            <span class="arrow">›</span>        

              <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                <a title="Bảng giá lốp xe" href="'.BASE_URL.'/vn/bang-gia-lop-xe" itemprop="url">            

                  <span itemprop="title">Bảng giá lốp xe</span>

                </a>

              </div>

            ';



        

        $this->view->data['tire_product_features'] = $tire_product_features;

        $this->view->data['link_breadcrumb'] = $link_breadcrumb;


        $tire_price_model = $this->model->get('tirequotationModel');

        $tire_producer_model = $this->model->get('tirequotationbrandModel');
        $tire_producers = $tire_producer_model->getAllTire();
        $this->view->data['tire_producers'] = $tire_producers;

        $tire_pattern_model = $this->model->get('tirequotationpatternModel');
        $tire_size_model = $this->model->get('tirequotationsizeModel');
        $tire_size_lists = $tire_size_model->getAllTire();
        $this->view->data['tire_size_lists'] = $tire_size_lists;

        $tire_patterns = $tire_pattern_model->getAllTire();
        $this->view->data['tire_patterns'] = $tire_patterns;

        $rowspan = array();
        $tire_sizes = array();

        $row_size = array();

        foreach ($tire_patterns as $tire_pattern) {
            $rowspan[$tire_pattern->tire_quotation_pattern_id] = 1;
            $sizes = $tire_size_model->queryTire('SELECT * FROM tire_quotation_size WHERE tire_quotation_size_id IN (SELECT tire_quotation_size FROM tire_quotation WHERE tire_quotation_pattern = '.$tire_pattern->tire_quotation_pattern_id.')');
            foreach ($sizes as $size) {
                $rowspan[$tire_pattern->tire_quotation_pattern_id]++;
                $tire_sizes['size_number'][$tire_pattern->tire_quotation_pattern_id][] = $size->tire_quotation_size_number;
                $row_size[$tire_pattern->tire_quotation_pattern_id][] = $size->tire_quotation_size_id;
            }
        }


        $tire_prices = array();
        $join = array('table'=>'tire_quotation_brand,tire_quotation_pattern,tire_quotation_size','where'=>'tire_quotation_brand=tire_quotation_brand_id AND tire_quotation_size=tire_quotation_size_id AND tire_quotation_pattern=tire_quotation_pattern_id');
        $prices = $tire_price_model->getAllTire(array('where'=>'( end_date IS NULL OR end_date >= '.strtotime(date('d-m-Y')).')'),$join);
        foreach ($prices as $price) {
            $tire_prices[$price->tire_quotation_brand][$price->tire_quotation_size_number][$price->tire_quotation_pattern] = $price->tire_quotation_price;
        }

        $this->view->data['rowspan'] = $rowspan;
        $this->view->data['tire_sizes'] = $tire_sizes;
        $this->view->data['tire_prices'] = $tire_prices;
        $this->view->data['row_size'] = $row_size;

        $tire_producer_model = $this->model->get('tireproducerModel');
        $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
        $this->view->data['list_tire_producers'] = $tire_producers;

        $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        

        $this->view->show('vn/quotation');
    }
    public function regis(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $customer = $this->model->get('customertireModel');

            $data = array(
                        
                'customer_tire_company' => trim($_POST['company']),
                'customer_tire_phone' => trim($_POST['phone']),
                'customer_tire_email' => trim($_POST['email']),
                'customer_tire_date' => strtotime(date('d-m-Y')),
                'customer_tire_sale' => 1
                
            );
            if($customer->getCustomerByWhere(array('customer_tire_email'=>$data['customer_tire_email']))){
                echo "Thông tin của quý khách đã có trong hệ thống!";
                return false;
            }
            else{
                $customer->createCustomer($data);
                echo "Đăng ký thành công!";
            }
            
        }
    }
    public function agent(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $customer = $this->model->get('tireagentModel');

            $data = array(
                        
                'company_name' => trim($_POST['company_name']),
                'company_mst' => trim($_POST['company_mst']),
                'company_address' => trim($_POST['company_address']),
                'company_phone' => trim($_POST['company_phone']),
                'company_email' => trim($_POST['company_email']),
                'company_contact' => trim($_POST['company_contact']),
                'place' => trim($_POST['place']),
                'tire_agent_date' => strtotime(date('d-m-Y')),
                
            );
            if($customer->getTireByWhere(array('company_mst'=>$data['company_mst']))){
                echo "Thông tin của quý khách đã có trong hệ thống!";
                return false;
            }
            else if($customer->getTireByWhere(array('company_email'=>$data['company_email']))){
                echo "Thông tin của quý khách đã có trong hệ thống!";
                return false;
            }
            else{
                $customer->createTire($data);
                echo "Đăng ký thành công!";
            }
            
        }
    }

    public function add_to_cart(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($_SESSION['user_logined']) {
                $_SESSION['user_logined'] = $_SESSION['user_logined'];
                $_SESSION['userid_logined'] = $_SESSION['userid_logined'];
                $_SESSION['role_logined'] = $_SESSION['role_logined'];
            }

            $id = trim($_POST['data']);

            if(isset($_SESSION['cart'][$id]))
            {
                if (isset($_POST['num'])) {
                    $qty = $_SESSION['cart'][$id] + $_POST['num'];
                }
                else{
                    $qty = $_SESSION['cart'][$id] + 1;
                }
                
            }
            else
            {
                if (isset($_POST['num'])) {
                    $qty = $_POST['num'];
                }
                else{
                    $qty=1;
                }
                
            }
            $_SESSION['cart'][$id]=$qty;

            echo count($_SESSION['cart']);
        }
    }

    public function show_cart(){
        if (!isset($_SESSION['cart']) || $_SESSION['cart'] == null) {
            echo "Bạn không có sản phẩm nào trong giỏ hàng!";
            return;
        }

        foreach($_SESSION['cart'] as $key=>$value)
        {
            $item[]=$key;
        }
        $ids = implode(",",$item);

        $tire_product_model = $this->model->get('tireproductModel');

        $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

        $data = array(
            'where' => 'tire_product_id IN('.$ids.')',
        );

        $tire_product_carts = $tire_product_model->getAllTire($data,$join);

        $tongtien = 0;

        $str = '<div class="maxheighttablecart">
                    <table class="table table-bordered">
                        <tbody>';
        foreach ($tire_product_carts as $cart) {
            $filename = BASE_URL."/public/images/upload/".$cart->tire_product_thumb;
            if (!@getimagesize($filename)) {
                $filename = BASE_URL."/public/images/upload/".$cart->tire_product_pattern_type.".jpg";
            }
            $link = BASE_URL."/vn/detail/".$cart->tire_product_link;
            $name = $cart->tire_producer_name.' '.$cart->tire_product_size_number.' '.$cart->tire_product_name;
            $id = $cart->tire_product_id;
            $tien = $cart->tire_retail*$_SESSION['cart'][$id];
            $tongtien += $tien;

            $str .= '<tr class="'.$id.'">
                <td rowspan="2" width="30"><img src="'.$filename.'" alt="" width="30" height="30"></td>
                <td colspan="2" class="bold"><a href="'.$link.'">'.$name.'</a> <i title="Xóa" class="fa fa-trash-o delete_pro_in_cart" data-number="'.$_SESSION['cart'][$id].'" data-money="'.$tien.'" data="'.$id.'"></i></td>
            </tr>
            <tr class="'.$id.'">
                <td class="align_right">
                <input min="1" class="soluong" data-money="'.$cart->tire_retail.'" type="number" style="width:50px" data="'.$id.'" id="soluong_'.$id.'" value="'.$_SESSION['cart'][$id].'"/>
                <td class="align_right bold">'.$this->lib->formatMoney($cart->tire_retail).' đ/cái</td>
            </tr>';
        }
        $str .= '</tbody>
                <tfoot>
                <tr>
                    <td colspan="2"><b>Tổng cộng</b></td>
                    <td class="align_right"><b class="red total" data="'.$tongtien.'">'.$this->lib->formatMoney($tongtien).' VNĐ</b></td>
                </tr>
            </tfoot>
        </table>
        </div>
        <p class="align_left margintop10">
            <a href="'.BASE_URL.'/vn/thanh-toan" title="Thanh toán" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Thanh toán</a>
            <a data-box-cart="1" title="Tiếp tục mua hàng" class="btn btn-warning close_box_cart"><i class="fa fa-times"></i> Tiếp tục</a>
            <a data-box-cart="1" title="Xoá khỏi giỏ hàng" class="btn btn-danger restroy_cart"><i class="fa fa-trash-o"></i> Huỷ</a>
        </p>
        <script>
        $(".close_box_cart").click(function(e){
            $(".cart-top").removeClass("open");
            $(".cart-fixed").removeClass("open");
        });
        $(".delete_pro_in_cart").click(function(){
            var id = $(this).attr("data");
            var tien = $(this).attr("data-money");
            $.ajax({
              type: "GET",
              url: "'.BASE_URL.'/vn/delete-cart",
              data: "id="+id, // giá trị post
              success: function(answer){ 
                $("."+id).remove();
                var num = parseInt($(".cartTopRightQuantity").html());
                $(".cartTopRightQuantity").html(num-1);

                var total = parseInt($(".total").attr("data"));
                $(".total").html(total-tien);
                $(".total").attr("data",total-tien)
                $(".total").html(function(index, value) {
                    return value
                      .replace(/\D/g, "")
                      .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
                });
                $(".total").html($(".total").html()+" VNĐ");
              }
            });
        });
        $(".restroy_cart").click(function(){
            $.ajax({
              type: "GET",
              url: "'.BASE_URL.'/vn/remove-cart",
              data: "id=1", // giá trị post
              success: function(answer){ 
                $(".maxheighttablecart").html("Bạn không có sản phẩm nào trong giỏ hàng!");
                $(".cartTopRightQuantity").html(0);
                $(".margintop10").remove();
              }
            });
        });
        $(document).on("focusin", ".soluong", function(){
            $(this).data("val", $(this).val());
        }).on("change",".soluong", function(){
            var prev = parseInt($(this).data("val"));
            var current = parseInt($(this).val());

            $(this).data("val", $(this).val());

            var price = $(this).attr("data-money");
            var total = parseInt($(".total").attr("data"));

            var tien = prev*price;
            total = total - tien;
            total = total + (current*price);

            $(".total").html(total);
            $(".total").attr("data",total)
            $(".total").html(function(index, value) {
                return value
                  .replace(/\D/g, "")
                  .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
            $(".total").html($(".total").html()+" VNĐ");

            var id = $(this).attr("data");
            $.ajax({
              type: "GET",
              url: "'.BASE_URL.'/vn/update-cart",
              data: "id="+id+"&data="+current, // giá trị post
              success: function(answer){ 
              }
            });

        });

        $(document).on("focusin", ".soluong", function(){
            $(this).data("val", $(this).val());
        }).on("keyup",".soluong", function(){
            var prev = parseInt($(this).data("val"));
            var current = parseInt($(this).val());

            $(this).data("val", $(this).val());

            var price = $(this).attr("data-money");
            var total = parseInt($(".total").attr("data"));

            var tien = prev*price;
            total = total - tien;
            total = total + (current*price);

            $(".total").html(total);
            $(".total").attr("data",total)
            $(".total").html(function(index, value) {
                return value
                  .replace(/\D/g, "")
                  .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ;
            });
            $(".total").html($(".total").html()+" VNĐ");

            var id = $(this).attr("data");
            $.ajax({
              type: "GET",
              url: "'.BASE_URL.'/vn/update-cart",
              data: "id="+id+"&data="+current, // giá trị post
              success: function(answer){ 
              }
            });
        });
        </script>';

        echo $str;

    }

    public function delete_cart(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            unset($_SESSION['cart'][$id]);
        }
        
    }

    public function remove_cart(){
        unset($_SESSION['cart']);
        
    }

    public function update_cart(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $_SESSION['cart'][$id] = $_GET['data'];
        }
        
    }

    public function thanh_toan() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Đơn hàng';

        $this->view->data['lib'] = $this->lib;

        $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);

            $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="Đơn hàng" href="'.BASE_URL.'/vn/thanh-toan" itemprop="url">            

                      <span itemprop="title">Đơn hàng</span>

                    </a>

                  </div>

                ';



            

            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

        $tire_product_carts = array();   
        if (isset($_SESSION['cart']) && $_SESSION['cart'] != null) {
            foreach($_SESSION['cart'] as $key=>$value)
            {
                $item[]=$key;
            }
            $ids = implode(",",$item);

            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(
                'where' => 'tire_product_id IN('.$ids.')',
            );

            $tire_product_carts = $tire_product_model->getAllTire($data,$join);
        }
        
        $this->view->data['tire_product_carts'] = $tire_product_carts;

        $this->view->show('vn/thanhtoan');
    }

    public function submit_cart() {

       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $customer_model = $this->model->get('ecustomerModel');
            $cart_model = $this->model->get('ecartModel');
            $cartlist_model = $this->model->get('ecartlistModel');
            $tire_product_model = $this->model->get('tireproductModel');

            $hoten = trim($_POST['hoten']);
            $dienthoai = trim($_POST['dienthoai']);
            $diachi = trim($_POST['diachi']);
            $email = trim($_POST['email']);
            $congty = trim($_POST['congty']);

            $vanchuyen = trim($_POST['vanchuyen']);
            $ghichu = trim($_POST['ghichu']);

            $customer = $customer_model->getCustomerByWhere(array('e_customer_phone'=>$dienthoai));
            if (!$customer) {
                $customer = $customer_model->getCustomerByWhere(array('e_customer_email'=>$email));
                if (!$customer) {
                    $data_customer = array(
                        'e_customer_date' => strtotime(date('d-m-Y')),
                        'e_customer_co' => $congty,
                        'e_customer_phone' => $dienthoai,
                        'e_customer_email' => $email,
                        'e_customer_address' => $diachi,
                        'e_customer_contact' => $hoten,
                        'e_customer_type' => 1,
                    );
                    $customer_model->createCustomer($data_customer);
                    $id_customer = $customer_model->getLastCustomer()->e_customer_id;
                }
                else{
                    $id_customer = $customer->e_customer_id;
                }
            }
            else{
                    $id_customer = $customer->e_customer_id;
                }

            $tire_product_carts = array();   
            if (isset($_SESSION['cart']) && $_SESSION['cart'] != null) {
                foreach($_SESSION['cart'] as $key=>$value)
                {
                    $item[]=$key;
                }
                $ids = implode(",",$item);

                $soluong = 0;
                $tien = 0;

                $tire_product_carts = $tire_product_model->getAllTire(array('where' => 'tire_product_id IN('.$ids.')'));
                foreach ($tire_product_carts as $tire) {
                    $soluong += $_SESSION['cart'][$tire->tire_product_id];
                    $tien += $_SESSION['cart'][$tire->tire_product_id]*$tire->tire_retail;
                }

                $discount = 0;
                if ($vanchuyen == 1) {
                    $discount += $soluong*100000;
                }

                $total = $tien-$discount;

                $data = array(
                    'e_cart_date' => strtotime(date('d-m-Y')),
                    'e_customer' => $id_customer,
                    'e_product' => $ids,
                    'e_number' => $soluong,
                    'e_total' => $total,
                    'e_discount' => $discount,
                    'e_comment' => $ghichu,
                );

                $cart_model->createCart($data);
                $id_cart = $cart_model->getLastCart()->e_cart_id;

                foreach ($tire_product_carts as $tire) {
                    $data = array(
                        'e_cart' => $id_cart,
                        'tire_product' => $tire->tire_product_id,
                        'tire_number' => $_SESSION['cart'][$tire->tire_product_id],
                    );
                    $cartlist_model->createCart($data);
                }

                unset($_SESSION['cart']);
            }
        }
        
    }

    public function getCustomer(){
        if (isset($_GET['email'])) {
            $customer_model = $this->model->get('ecustomerModel');

            $customer = $customer_model->getCustomerByWhere(array('e_customer_email'=>trim($_GET['email'])));

            $arr = array(
                'hoten' => $customer->e_customer_contact,
                'dienthoai' => $customer->e_customer_phone,
                'diachi' => $customer->e_customer_address,
                'congty' => $customer->e_customer_co,
            );

            echo json_encode($arr);
        }
    }

    public function tin_tuc() {

        $this->view->setLayout('detail');

            $this->view->data['lib'] = $this->lib;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : null;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'post_date';



                $order = $this->registry->router->order ? $this->registry->router->order : 'DESC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 10;



            }

            $link = $this->registry->router->param_id != "page" ? $this->registry->router->param_id : null;



            $tire_product_model = $this->model->get('tireproductModel');

            $post_model = $this->model->get('postModel');

            $data = array(

                'order_by' => 'post_date',

                'order' => 'DESC',

                'limit' => '10',

                'where' => '1=1',

            );

            $new_posts = $post_model->getAllPost($data);

            $this->view->data['new_posts'] = $new_posts;

            $join = array('table'=>'user','where'=>'user_id=post_user');

           if ($link != "") {

                

                $data = array(

                    'limit' => '1',

                    'where' => 'post_link = "'.$link.'"',

                );



                $posts = $post_model->getAllPost($data,$join);


                foreach ($posts as $post) {

                    $this->view->data['title'] = $post->post_title;
                    $this->view->data['description'] = trim(strip_tags($post->post_desc));


                    $link_breadcrumb = '

                    <span class="arrow">›</span>        

                      <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                        <a title="Tin tức" href="'.BASE_URL.'/vn/tin-tuc" itemprop="url">            

                          <span itemprop="title">Tin tức</span>

                        </a>

                        <span class="arrow">›</span>        

                        <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                          <a title="'.$post->post_title.'" href="'.BASE_URL.'/vn/tin-tuc/'.$post->post_link.'" itemprop="url">      

                            <span itemprop="title">'.$post->post_title.'</span>

                          </a>

                        </div>

                      </div>

                    ';

                }
            }
            else{
                $sonews = $limit;
                $x = ($page-1) * $sonews;
                $pagination_stages = 2;


                $data = array(
                    'where' => '1=1',
                );

                
                $tongsodong = count($post_model->getAllPost($data,$join));
                $tongsotrang = ceil($tongsodong / $sonews);
                

                $this->view->data['page'] = $page;
                $this->view->data['order_by'] = $order_by;
                $this->view->data['order'] = $order;
                $this->view->data['keyword'] = $keyword;
                $this->view->data['pagination_stages'] = $pagination_stages;
                $this->view->data['tongsotrang'] = $tongsotrang;
                $this->view->data['sonews'] = $sonews;
                $this->view->data['limit'] = $limit;

                $data = array(
                    'order_by'=>$order_by,
                    'order'=>$order,
                    'limit'=>$x.','.$sonews,
                    'where' => '1=1',
                    );


                $posts = $post_model->getAllPost($data,$join);

                $this->view->data['lists'] = $posts;

                $photo_model = $this->model->get('photoModel');
                $photos = $photo_model->getAllPhoto();
                $photo_data = array();
                foreach ($photos as $photo) {
                    $photo_data['link'][$photo->photo_id] = $photo->photo_url;
                }
                $this->view->data['photo_data'] = $photo_data;

                $link_breadcrumb = '

                    <span class="arrow">›</span>        

                      <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                        <a title="Tin tức" href="'.BASE_URL.'/vn/tin-tuc" itemprop="url">            

                          <span itemprop="title">Tin tức</span>

                        </a>

                      </div>

                    ';
            }


            $join = array('table'=>'tire_producer, tire_product_size, tire_product_pattern','where'=>'tire_pattern=tire_product_pattern_id AND tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);


            $join = array('table'=>'user','where'=>'user_id=post_user');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '5',

            );



            $post_others = $post_model->getAllPost($data,$join);



            $this->view->data['limit'] = $limit;



            $this->view->data['posts'] = $posts;

            $this->view->data['post_others'] = $post_others;

            $this->view->data['tire_product_features'] = $tire_product_features;


            $this->view->data['link_breadcrumb'] = $link_breadcrumb;

            $tire_producer_model = $this->model->get('tireproducerModel');
            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_position ASC, tire_producer_name ASC'));
            $this->view->data['list_tire_producers'] = $tire_producers;

            $tire_producers = $tire_producer_model->getAllTire(array('order_by'=>'tire_producer_name','order'=>'ASC'));
            $tire_producer_data = array();
            foreach ($tire_producers as $tire) {
                $tire_producer_data[strtoupper(substr($tire->tire_producer_name, 0, 1))][] = $tire->tire_producer_name;
            }
            $this->view->data['tire_producer_data'] = $tire_producer_data;

            $this->view->show('vn/news');



    }


}



?>