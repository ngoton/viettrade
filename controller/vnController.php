<?php



Class vnController Extends baseController {



    public function index() {



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade | ';

            $this->view->data['lib'] = $this->lib;



            $tire_product_model = $this->model->get('tireproductModel');

            $tire_producer_model = $this->model->get('tireproducerModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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



            $tire_producers = $tire_producer_model->getAllTire();



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



            $this->view->show('vn/index');



    }

    public function thong_so_lop() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Thông số kỹ thuật lốp xe | ';

        $this->view->data['lib'] = $this->lib;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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

        $this->view->show('vn/thongsolop');
    }

    public function dai_ly_lop_xe() {

        $this->view->setLayout('detail');

        $this->view->data['title'] = 'Đại lý lốp xe | ';

        $this->view->data['lib'] = $this->lib;

        $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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

        $this->view->show('vn/dailylopxe');
    }

    public function lop_xe_bo_kem() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade | ';

            $this->view->data['lib'] = $this->lib;



            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_product_id';



                $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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



            $this->view->show('vn/index');



    }



    public function lop_xe_bo_nylon() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade | ';

            $this->view->data['lib'] = $this->lib;



            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_product_id';



                $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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



            $this->view->show('vn/index');



    }



    public function lop_xe_co_ruot() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade | ';

            $this->view->data['lib'] = $this->lib;



            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_product_id';



                $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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



            $this->view->show('vn/index');



    }



    public function lop_xe_khong_ruot() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade | ';

            $this->view->data['lib'] = $this->lib;



            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_product_id';



                $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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



            $this->view->show('vn/index');



    }



    public function lop_xe_tai() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade | ';

            $this->view->data['lib'] = $this->lib;



            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_product_id';



                $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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



            $param = str_replace('?', '', strstr(rawurldecode($_SERVER['REQUEST_URI']),"?"));



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



            $this->view->show('vn/index');



    }



    public function lop_xe_du_lich() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade | ';

            $this->view->data['lib'] = $this->lib;



            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_product_id';



                $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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



            $param = str_replace('?', '', strstr(rawurldecode($_SERVER['REQUEST_URI']),"?"));



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



            $this->view->show('vn/index');



    }



    public function lop_xe_dac_chung() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade | ';

            $this->view->data['lib'] = $this->lib;



            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_product_id';



                $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $tire_product_model = $this->model->get('tireproductModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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



            $param = str_replace('?', '', strstr(rawurldecode($_SERVER['REQUEST_URI']),"?"));



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



            $this->view->show('vn/index');



    }



    public function lop_xe_theo_hang_san_xuat() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade | ';

            $this->view->data['lib'] = $this->lib;



            $tire_product_model = $this->model->get('tireproductModel');

            $tire_producer_model = $this->model->get('tireproducerModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $tire_producers = $tire_producer_model->getAllTire();



            $tire_products = array();

            foreach ($tire_producers as $tire_producer) {

                $data = array(

                    'order_by' => 'RAND()',

                    'limit' => '3',

                    'where' => 'tire_producer = '.$tire_producer->tire_producer_id,

                );



                $tire_products[$tire_producer->tire_producer_id] = $tire_product_model->getAllTire($data,$join);

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

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;



            $this->view->show('vn/index');



    }



    public function brand() {

        $this->view->setLayout('detail');



        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            $this->view->data['title'] = 'Việt Trade | ';

            $this->view->data['lib'] = $this->lib;



            if ($_SERVER['REQUEST_METHOD'] == 'POST') {



                $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



                $order = isset($_POST['order']) ? $_POST['order'] : null;



                $page = isset($_POST['page']) ? $_POST['page'] : null;



                $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



                $limit = 12;



            }



            else{



                $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'tire_product_id';



                $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';



                $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



                $keyword = "";



                $limit = 12;



            }



            $brand_name = ucwords(str_replace('-', ' ', $this->registry->router->param_id));



            $tire_product_model = $this->model->get('tireproductModel');

            $tire_producer_model = $this->model->get('tireproducerModel');



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'order_by' => 'RAND()',

                'limit' => '10',

                'where' => 'tire_product_feature = 1',

            );



            $tire_product_features = $tire_product_model->getAllTire($data,$join);



            $data = array(

                    'where' => 'tire_producer_name LIKE "%'.$brand_name.'%"',

                );



            $tire_producers = $tire_producer_model->getAllTire($data);



            $tire_products = array();

            foreach ($tire_producers as $tire_producer) {



                if (count($tire_producers) == 1) {

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

                }

                

            }



            



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



            $this->view->data['tire_product_features'] = $tire_product_features;

            $this->view->data['tire_producers'] = $tire_producers;

            $this->view->data['tire_products'] = $tire_products;

            $this->view->data['link_breadcrumb'] = $link_breadcrumb;



            $this->view->show('vn/index');



    }



    public function detail() {

        $this->view->setLayout('detail');

        /*** set a template variable ***/



            //$this->view->data['welcome'] = 'Welcome to CAI MEP TRADING !';



        /*** load the index template ***/



            

            $this->view->data['lib'] = $this->lib;



            $link = $this->registry->router->param_id;



            $tire_product_model = $this->model->get('tireproductModel');

            $tire_vehicle_model = $this->model->get('tirevehicleModel');



            $tire_vehicles = $tire_vehicle_model->getAllTire();

            foreach ($tire_vehicles as $tire_vehicle) {

                $data_vehicle[$tire_vehicle->tire_vehicle_id]['name'] = $tire_vehicle->tire_vehicle_name;

                $data_vehicle[$tire_vehicle->tire_vehicle_id]['type'] = $tire_vehicle->tire_vehicle_type;

            }



            $this->view->data['data_vehicle'] = $data_vehicle;



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

            $data = array(

                'limit' => '1',

                'where' => 'tire_product_link = "'.$link.'"',

            );



            $tire_products = $tire_product_model->getAllTire($data,$join);



            foreach ($tire_products as $tire_product) {

                $this->view->data['title'] = "Lốp xe ".$tire_product->tire_producer_name.' '.$tire_product->tire_product_size_number.' '.$tire_product->tire_product_name.' | ';

                $data = array(

                    'order_by' => 'RAND()',

                    'limit' => '3',

                    'where' => 'tire_product_vehicle LIKE "%'.$tire_product->tire_product_vehicle.'%"',

                );



                $tire_product_relatives = $tire_product_model->getAllTire($data,$join);



                $vehicle = $tire_vehicle_model->getTire(substr($tire_product->tire_product_vehicle,0,1));



                $l_v = $vehicle->tire_vehicle_type==1?"lop-xe-tai":($vehicle->tire_vehicle_type==2?"lop-xe-du-lich":($vehicle->tire_vehicle_type==3?"lop-xe-dac-chung":"lop-xe"));



                $link_breadcrumb = '

                <span class="arrow">›</span>        

                  <div itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">         

                    <a title="'.$vehicle->tire_vehicle_name.'" href="'.BASE_URL.'/vn/'.$l_v.'" itemprop="url">            

                      <span itemprop="title">'.$vehicle->tire_vehicle_name.'</span>

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



            $join = array('table'=>'tire_producer, tire_product_size','where'=>'tire_producer=tire_producer_id AND tire_size=tire_product_size_id');

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



            $this->view->show('vn/detail');



    }







}



?>