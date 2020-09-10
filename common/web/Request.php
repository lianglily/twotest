<?php
 namespace common\web;
 use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
class Request extends Component
{
  
  protected function resolveRequestUri()
    {
		
        if (isset($_SERVER['HTTP_X_REWRITE_URL'])) { // IIS
            $requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            $requestUri = $_SERVER['REQUEST_URI'];
            if ($requestUri !== '' && $requestUri[0] !== '/') {
                $requestUri = preg_replace('/^(http|https):\/\/[^\/]+/i', '', $requestUri);
            }
        } elseif (isset($_SERVER['ORIG_PATH_INFO'])) { // IIS 5.0 CGI
            $requestUri = $_SERVER['ORIG_PATH_INFO'];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $requestUri .= '?' . $_SERVER['QUERY_STRING'];
            }
        } else {
            throw new InvalidConfigException('Unable to determine the request URI.');
        }
    # 修改代码如下：
    # return $requestUri;
    # 改为：
    return $this->getRewriteUri($requestUri);
    }
	
	protected function getRewriteUri($requestUri){
    $front_requestUri = "";
    $wh_requestUri = "";
    $dh_requestUri = "";
    if(strstr($requestUri,"?")){
      $arr = explode("?",$requestUri);
      $front_requestUri = $arr[0];
      $wh_requestUri = $arr[1];
    }else if(strstr($requestUri,"#")){
      $arr = explode("#",$requestUri);
      $front_requestUri = $arr[0];
      $dh_requestUri = $arr[1];
    }else{
      $front_requestUri = $requestUri;
    }
    //echo $requestUri;exit;
    if($custom_uri = $this->getCustomUrl($front_requestUri)){
      if($wh_requestUri){
        return $custom_uri."?".$wh_requestUri;
      }else if($dh_requestUri){
        return $custom_uri."#".$dh_requestUri;
      }else{
        return $custom_uri;
      } 
    }else{
      return $requestUri;
    }
    
  }
  #根据当前的自定义uri，得到数据库保存的真实uri。
  protected function getCustomUrl($uri){
    # 去掉头部的/
    if(substr($uri,0,1) == "/"){
      $uri = substr($uri,1);
    }
    $url_rewrite_coll = \Yii::$app->mongodb->getCollection('url_rewrite');
    $one = $url_rewrite_coll->findOneConvert(['request_path' => $uri]);
    if($one['_id']){
      $type = $one['type'];
      $type_data_id = $one['type_data_id'];
      Global $page_handle;
      if($type == 'product'){
        $product_coll = \Yii::$app->mongodb->getCollection("catalog_product");
        $where = ["_id"=>(int)$type_data_id,"status"=>1 ];
        if(!Config::param("out_stock_product_is_show")){
          $where['is_in_stock'] = 1;
        }
        $product_data = $product_coll->findOneConvert($where);
        if($product_data['_id']){
          $page_handle = $product_data;
          return '/catalog/product/index';
        }
      }else if($type == 'category'){
        $category_table = "catalog_category";
        $category_coll = \Yii::$app->mongodb->getCollection($category_table);
        
        $category_data = $category_coll->findOneConvert(["_id"=>(int)$type_data_id,"status"=>1 ]);
        if($category_data['_id']){
          $page_handle = $category_data;
          return '/catalog/category/index';
        }
      }else if($type == 'cmspage'){
        $cmspage_coll = \Yii::$app->mongodb->getCollection("cms_page");
        $cmspage_data = $cmspage_coll->findOneConvert(["_id"=>(int)$type_data_id,"status"=>1 ]);
        if($cmspage_data['_id']){
          $page_handle = $cmspage_data;
          return '/home/index/page';
        }
      # 下一步做。blog没有做。
      }else if($type == 'blog'){
        $blog_coll = \Yii::$app->mongodb->getCollection("blog_article");
        $blog_data = $blog_coll->findOneConvert(["_id"=>(int)$type_data_id,"status"=>1 ]);
        if($blog_data['_id']){
          $page_handle = $blog_data;
          return '/blog/blog/index';
        }
      }else if($type == 'blogcategory'){
        $blogcategory_coll = \Yii::$app->mongodb->getCollection("blog_category");
        $blogcategory_data = $blogcategory_coll->findOneConvert(["_id"=>(int)$type_data_id ]);
        if($blogcategory_data['_id']){
          $page_handle = $blogcategory_data;
          return '/blog/category/index';
        }
      }else{
        return false;
      }
    }else{
      $rewrite_url_arr = array(
        'contacts'=>'customer/contacts/index',
      );
      if($rewrite_url_arr[$uri]){
        return "/".$rewrite_url_arr[$uri];
      }
      return false;
    }
    
    
    
  }
 
}