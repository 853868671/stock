<?php

namespace Tiger;

class helper
{

	public static function curl($url,$header=false,$params=false,$ispost=0)
    {
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
        if($header)
        {
            curl_setopt ($ch, CURLOPT_HEADER , 0 );
            curl_setopt ($ch, CURLOPT_HTTPHEADER , $header );
        }
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }

        $response = curl_exec( $ch );
        if ($response === FALSE) {
            echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;        
    }

    public static function dd($str,$pre=0)
    {
    	if(!$pre)
    	{
    		var_dump($str);
    	} else {
    		echo '<pre>';
    		print_r($str);
    	}
    	die;
    	
    }	
    /**
     * RSA 签名请求
     * 1.筛选：去除sign和sign_type参数、所有value为空的参数名；
     * 2.排序：对参数名按照字典序排序（即从左到右按照ASCII字符顺序比较排序）；
     * 3.拼接：按照排序好的参数名顺序，将参数对按照 ${key}=${value} 的规则拼成字符串，其中value是urlencode之前的值，之后用&符号拼接成字符串；
     * 4.对3形成的字符串，使用第三方私钥进行 SHA1withRSA 签名，并进行Base64编码，生成sign参数的值。
     */
    public function RSASign(array $query) {
        if (array_key_exists('sign', $query)) {
                unset($query['sign']);
        }
        ksort($query);
        foreach($query as $k => $v){
                $s .= $k.'='.$v.'&';
        }
        $len = strlen($s) - 1;
        $str = substr($s, 0, $len);
        $url = base_path();
        $priKey = file_get_contents($url.'/public/rsa_private_key.pem');
        $result = openssl_get_privatekey($priKey);
        openssl_sign($str, $sign, $result);
        openssl_free_key($result);
            //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }

}