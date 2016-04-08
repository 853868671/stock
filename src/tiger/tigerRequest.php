<?php

namespace Tiger;

use Tiger\helper;
class tigerRequest
{

	const dev_url = 'https://open-dev.tigerbrokers.com/v1/';
	const open_url = 'https://open.tigerbrokers.com/v1/';
	const user = 'user'; //获取用户信息
	const stock_suggest = 'stock/suggest'; //搜索股票代码
	const portfolio_assets = 'portfolio/assets'; //获取用户资产
	const portfolio_positions = 'portfolio/positions'; //获取用户持仓
	const orders_open = 'orders/open'; //查询委托订单
	const orders_filled = 'orders/filled'; //查询已成交订单
	const orders_inactive = 'orders/inactive'; //查询已失效的订单
	const orders_show = 'orders/show'; //查询单个订单
	const orders_create = 'orders/create'; 	//创建订单

	const orders_place = 'orders/place'; //委托下单
	const orders_cancel = 'orders/cancel'; 	//撤单


	private $http_url = self::dev_url;
	private $access_token;
	private $headers;

	public function __construct($access_token,$open=false)
	{
		if($open){
			$this->http_url = self::open_url;
		}
		$this->access_token = $access_token;
		$this->headers[] = "Authorization: Bearer $access_token";
	}


	public static function test(){
		echo 'HI';
	}

    public function getUser()
    {
        $url = $this->http_url.self::user;        
        $this->getResult($url);
    }

    public function getPortfolioAssets()
    {
        $url = $this->http_url.self::portfolio_assets;        
        $this->getResult($url);
    }

    public function getPortfolioPositions()
    {
        $url = $this->http_url.self::portfolio_positions;        
        $this->getResult($url);	
    }

    public function getStockSuggest($params=array())
    {

        $url = $this->http_url.self::stock_suggest;
        $this->getResult($url,$params);   	
    }

    public function getOrdersOpen($params=false)
    {

        $url = $this->http_url.self::orders_open;
        $this->getResult($url,$params);
    }
    public function getOrdersFilled($params=false)
    {

        $url = $this->http_url.self::orders_filled;
        $this->getResult($url,$params);
    }
    public function getOrdersInactive($params=false)
    {

        $url = $this->http_url.self::orders_inactive;
        $this->getResult($url,$params);
    }
    public function getOrdersShow($params=false)
    {
    	//$params = array('order_id'=>3457);

        $url = $this->http_url.self::orders_show;
        $this->getResult($url,$params);
    }   
    public function getOrdersCreate($params=false)
    {
    	//$params = array('symbol'=>'NTES','action'=>'BUY','quantity'=>1340,'order_type'=>'MKT');
        $url = $this->http_url.self::orders_create;
        $this->getResult($url,$params,true);
    }                 

    private function getResult($url,$params=false,$ispost=false)
    {
        if($params){
        	$params = http_build_query($params);
        	if($ispost){
        		$res = helper::curl($url,$this->headers,$params,1);
        	} else{
        		$res = helper::curl($url,$this->headers,$params);
        	}        	
        } else{
        	$res = helper::curl($url,$this->headers);
        }                
        //helper::dd(json_decode($res,true),1);
        return $res;       	
    }
    
}