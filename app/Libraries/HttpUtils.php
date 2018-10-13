<?php
namespace App\Libraries;


use App\Enums\HttpCodeEnums;
use App\Enums\SystemEnums;

/**
 * http 工具类
 * @author Administrator
 *
 */
class HttpUtils
{
    
    private static $_instance;
    
    //远程端接收产品数据路由
    private $route;
    
    private function __construct()
    {
        $this->route = '/receive/products';
    }
    
    public static function getInstance()
    {
        if( null == self::$_instance )
        {
            self::$_instance = new HttpUtils();
        }
        return self::$_instance;
    }
    
    /**
     * http curl 请求
     * @param unknown $remote
     * @param unknown $method
     * @param array $data
     * @param array $headers
     * @return string
     */
    public function curl( $remote, $method = SystemEnums::SYSTEM_HTTP_METHOD_GET, $data = [], $headers = [], $format = SystemEnums::SYSTEM_HTTP_DATA_FORMAT_STRING )
    {
       
        if( !$remote  )
        {
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'msg' ] = 'ERROR: undefined request url';
            return $arrMsg;
        }
        
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $remote );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        if( isset( $headers ) && !empty( $headers ) )
        {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        }
        
        switch ( $method )
        {
            case SystemEnums::SYSTEM_HTTP_METHOD_GET:
                
            break;
            case SystemEnums::SYSTEM_HTTP_METHOD_PUT:
                curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, SystemEnums::SYSTEM_HTTP_METHOD_PUT );
                switch ( $format )
                {
                    case SystemEnums::SYSTEM_HTTP_DATA_FORMAT_STRING:
                        curl_setopt( $ch, CURLOPT_POSTFIELDS,  http_build_query( $data, '', '&' ) ); //设置请求体，提交数据包
                    break;
                    case SystemEnums::SYSTEM_HTTP_DATA_FORMAT_JSON:
                        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $data ) ); //设置请求体，提交数据包
                    break;
                }
            break;
            case SystemEnums::SYSTEM_HTTP_METHOD_POST:
                curl_setopt( $ch, CURLOPT_POST, 1 );
                switch ( $format )
                {
                    case SystemEnums::SYSTEM_HTTP_DATA_FORMAT_STRING:
                        curl_setopt( $ch, CURLOPT_POSTFIELDS,  http_build_query( $data, '', '&' ) );
                    break;
                    case SystemEnums::SYSTEM_HTTP_DATA_FORMAT_JSON:
                        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $data ) );
                    break;
                }
            break;
            case SystemEnums::SYSTEM_HTTP_METHOD_DELETE:
                curl_setopt ( $ch, CURLOPT_NOSIGNAL, true );
                curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, SystemEnums::SYSTEM_HTTP_METHOD_DELETE );
            break;
        }
        
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        $result = curl_exec( $ch );
        $error = curl_error( $ch );
        $curl_info = curl_getinfo( $ch );
        curl_close( $ch );
        if( 0 != $error || strlen( $error ) > 0 )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'msg' ] = ' Curl ERROR: curl error code is ' . $error;
            
            return $arrMsg;
        }
        
        if( HttpCodeEnums::HTTP_CODE_SUCCESS_ERROR_AGENCY <= $curl_info[ 'http_code' ] )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'http_code' ] = $curl_info[ 'http_code' ];
            $arrMsg[ 'errmsg' ] = $result;
            $arrMsg[ 'msg' ] = ' CURL ERROR： http response error ';
            
            return $arrMsg;
        }
        
        $arrMsg[ 'code' ] = $curl_info[ 'http_code' ];
        $arrMsg[ 'data' ] = $result;
        $arrMsg[ 'msg' ] = 'REMOTE: http code ' . $curl_info[ 'http_code' ];
        
        return $arrMsg;
    }
    
    
    /**
     * 获取远程数据是否正常
     * @param unknown $remote
     * @return string
     */
    public function curlGet( $remote, $headers = [], $agent = false )
    {
        if( !$remote  )
        {
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'msg' ] = 'ERROR: undefined request url';
            return $arrMsg;
        }
        
        $curl = curl_init();
        curl_setopt( $curl, CURLOPT_URL, $remote );
        curl_setopt( $curl, CURLOPT_HEADER, false );
        curl_setopt( $curl, CURLOPT_TIMEOUT, 60 );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $curl, CURLOPT_USERAGENT,  $this->_getAgent() );
        if( !empty( $headers ) )
        {
            curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
        }
        if( $agent )
        {
            $arrAgentINfo = $this->_getProxy();
            curl_setopt( $curl, CURLOPT_REFERER, 'https://item.taobao.com/' ); 
            curl_setopt( $curl, CURLOPT_PROXY,  $arrAgentINfo[ 'proxy' ] ); //代理服务器地址
            curl_setopt( $curl, CURLOPT_PROXYPORT, $arrAgentINfo[ 'port' ] ); //代理服务器端口
        }
        $data = curl_exec( $curl );
        $error_code = curl_errno( $curl );
        $curl_info = curl_getinfo( $curl );
        curl_close( $curl );
        if( 0 != $error_code )
        {
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'curl_code' ] = $error_code;
            $arrMsg[ 'msg' ] = 'CURL ERROR: error code '.$error_code;
            return $arrMsg;
        }
        
        $arrMsg[ 'code' ] = $curl_info[ 'http_code' ];
        $arrMsg[ 'data' ] = $data;
        $arrMsg[ 'msg' ] = 'REMOTE: http code ' . $curl_info[ 'http_code' ];
        
        return $arrMsg;
    }
    
    
    /**
     * 模拟post提交
     * @param unknown $remoteUrl
     * @param unknown $data
     * @return boolean|string
     */
    public function curlPost( $remoteUrl, $data, $headers = [], $format = SystemEnums::SYSTEM_HTTP_DATA_FORMAT_STRING )
    {
        if( !$remoteUrl || !$data || empty( $data ) )
        {
            return false;
        }
        
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $remoteUrl );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'WHR' );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        switch ( $format )
        {
            case SystemEnums::SYSTEM_HTTP_DATA_FORMAT_STRING:
                curl_setopt( $ch, CURLOPT_POSTFIELDS,  http_build_query( $data, '', '&' ) );
            break;
            case SystemEnums::SYSTEM_HTTP_DATA_FORMAT_JSON:
                curl_setopt( $ch, CURLOPT_POSTFIELDS, \GuzzleHttp\json_encode( $data ) );
            break;
        }
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 500 );
        if( !empty( $headers ) )
        {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        }
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        $result = curl_exec( $ch );
        $error = curl_error( $ch );
        $curl_info = curl_getinfo( $ch );
        curl_close( $ch );
        
        if( 0 != $error || strlen( $error ) > 0 )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'msg' ] = ' Curl ERROR: curl error code is ' . $error;
            
            return $arrMsg;
        }
        
        if( HttpCodeEnums::HTTP_RESPONSE_CODE_SUCCESS != $curl_info[ 'http_code' ] )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'http_code' ] = $curl_info[ 'http_code' ];
            $arrMsg[ 'data' ] = $result;
            $arrMsg[ 'msg' ] = ' CURL ERROR： http response error ';
            
            return $arrMsg;
        }
        
        $arrMsg[ 'code' ] = $curl_info[ 'http_code' ];
        $arrMsg[ 'data' ] = $result;
        $arrMsg[ 'msg' ] = 'REMOTE: http code ' . $curl_info[ 'http_code' ];
        
        return $arrMsg;
    }
    
    
    /**
     * 模拟post提交
     * @param unknown $remoteUrl
     * @param unknown $data
     * @return boolean|string
     */
    public function curlPut( $remoteUrl, $data, $headers = [], $format = SystemEnums::SYSTEM_HTTP_DATA_FORMAT_STRING )
    {
        if( !$remoteUrl || !$data || empty( $data ) )
        {
            return false;
        }
        
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $remoteUrl );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'WHR' );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, SystemEnums::SYSTEM_HTTP_METHOD_PUT );
        switch ( $format )
        {
            case SystemEnums::SYSTEM_HTTP_DATA_FORMAT_STRING:
                curl_setopt( $ch, CURLOPT_POSTFIELDS,  http_build_query( $data, '', '&' ) );
                break;
            case SystemEnums::SYSTEM_HTTP_DATA_FORMAT_JSON:
                curl_setopt( $ch, CURLOPT_POSTFIELDS, \GuzzleHttp\json_encode( $data ) );
                break;
        }
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 500 );
        if( !empty( $headers ) )
        {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        }
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        $result = curl_exec( $ch );
        $error = curl_error( $ch );
        $curl_info = curl_getinfo( $ch );
        curl_close( $ch );
        
        if( 0 != $error || strlen( $error ) > 0 )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'msg' ] = ' Curl ERROR: curl error code is ' . $error;
            
            return $arrMsg;
        }
        
        if( HttpCodeEnums::HTTP_RESPONSE_CODE_SUCCESS != $curl_info[ 'http_code' ] )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'http_code' ] = $curl_info[ 'http_code' ];
            $arrMsg[ 'data' ] = $result;
            $arrMsg[ 'msg' ] = ' CURL ERROR： http response error ';
            
            return $arrMsg;
        }
        
        $arrMsg[ 'code' ] = $curl_info[ 'http_code' ];
        $arrMsg[ 'data' ] = $result;
        $arrMsg[ 'msg' ] = 'REMOTE: http code ' . $curl_info[ 'http_code' ];
        
        return $arrMsg;
    }
    
    
    
    /**
     * 模拟post提交
     * @param unknown $remoteUrl
     * @param unknown $data
     * @return boolean|string
     */
    public function curlDelete( $remoteUrl, $headers = [] )
    {
        if( !$remoteUrl )
        {
            return false;
        }
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $remoteUrl );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'WHR' );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
        if( !empty( $headers ) )
        {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        }
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, SystemEnums::SYSTEM_HTTP_METHOD_DELETE );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        $result = curl_exec( $ch );
        $error = curl_error( $ch );
        $curl_info = curl_getinfo( $ch );
        curl_close( $ch );
        
        if( 0 != $error || strlen( $error ) > 0 )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'msg' ] = ' Curl ERROR: curl error code is ' . $error;
            
            return $arrMsg;
        }
        if( HttpCodeEnums::HTTP_RESPONSE_CODE_SUCCESS <= $curl_info[ 'http_code' ] && HttpCodeEnums::HTTP_CODE_SUCCESS_ERROR_AGENCY > $curl_info[ 'http_code' ])
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'http_code' ] = $curl_info[ 'http_code' ];
            $arrMsg[ 'msg' ] = ' CURL ERROR： http response error ';
            
            return $arrMsg;
        }
        
        $arrMsg[ 'code' ] = $curl_info[ 'http_code' ];
        $arrMsg[ 'data' ] = $result;
        $arrMsg[ 'msg' ] = 'REMOTE: http code ' . $curl_info[ 'http_code' ];
        
        return $arrMsg;
    }
    
    
    /**
     * 异步发送数据
     * @param unknown $remote
     * @param unknown $data
     * @return boolean
     */
    public function curlPostData( $remote, $data, $headers = [] )
    {
        if( !$remote || !$data || empty( $data ) )
        {
            return false;
        }
        
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, trim( $remote ). $this->route );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'WHR' );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $data, '', '&' ) );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 20 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
        if( !empty( $headers ) )
        {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        }
        $result = curl_exec( $ch );
        $error = curl_error( $ch );
        $curl_info = curl_getinfo( $ch );
        curl_close( $ch );
        
        if( 0 != $error || strlen( $error ) > 0 )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'msg' ] = ' Curl ERROR: curl error code is ' . $error;
            
            return $arrMsg;
        }
        
        if( HttpCodeEnums::HTTP_RESPONSE_CODE_SUCCESS != $curl_info[ 'http_code' ] )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'http_code' ] = $curl_info[ 'http_code' ];
            $arrMsg[ 'msg' ] = ' CURL ERROR： http response error ';
            
            return $arrMsg;
        }
        
        $arrMsg[ 'code' ] = $curl_info[ 'http_code' ];
        $arrMsg[ 'data' ] = $result;
        $arrMsg[ 'msg' ] = 'REMOTE: http code ' . $curl_info[ 'http_code' ];
        
        return true;
    }
    
    
    /**
    * 随机取 代理信息
    * @return unknown[]
    */
    private function _getProxy()
    {
        $arrRet = array();
        $proxy = config( 'agents.proxys' );
        $iGNum = count( $proxy );
        $iCurrent = rand( 0, intval( $iGNum - 1 ) );
        
        $arrRet[ 'proxy' ] = $proxy[$iCurrent][ 'proxy' ];
        $arrRet[ 'port' ] = $proxy[$iCurrent][ 'port' ];
        
        return $arrRet;
        
    }
    
    
    /**
     * 随机获取 user-agent
     */
    private function _getAgent()
    {
        $agent = config( 'agents.agents' );
        $iGNum = count( $agent );
        $iCurrent = rand( 0, intval( $iGNum - 1 ) );
        
        return $agent[$iCurrent];
        
    }


    /**
     * 模拟post提交
     * @param unknown $remoteUrl
     * @param unknown $data
     * @return boolean|string
     */
    public function curlPostWithCookie( $remoteUrl, $data,$cookie, $headers = [], $format = SystemEnums::SYSTEM_HTTP_DATA_FORMAT_STRING )
    {
        if( !$remoteUrl || !$data || empty( $data ) )
        {
            return false;
        }

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $remoteUrl );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'WHR' );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie ); //设置Cookie信息保存在指定的文件中
        switch ( $format )
        {
            case SystemEnums::SYSTEM_HTTP_DATA_FORMAT_STRING:
                curl_setopt( $ch, CURLOPT_POSTFIELDS,  http_build_query( $data, '', '&' ) );
                break;
            case SystemEnums::SYSTEM_HTTP_DATA_FORMAT_JSON:
                curl_setopt( $ch, CURLOPT_POSTFIELDS, \GuzzleHttp\json_encode( $data ) );
                break;
        }
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 500 );
        if( !empty( $headers ) )
        {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        }
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        $result = curl_exec( $ch );
        $error = curl_error( $ch );
        $curl_info = curl_getinfo( $ch );
        curl_close( $ch );

        if( 0 != $error || strlen( $error ) > 0 )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'msg' ] = ' Curl ERROR: curl error code is ' . $error;

            return $arrMsg;
        }

        if( HttpCodeEnums::HTTP_RESPONSE_CODE_SUCCESS != $curl_info[ 'http_code' ] )
        {
            //异常
            $arrMsg[ 'code' ] = HttpCodeEnums::HTTP_CODE_ERROR;
            $arrMsg[ 'http_code' ] = $curl_info[ 'http_code' ];
            $arrMsg[ 'data' ] = $result;
            $arrMsg[ 'msg' ] = ' CURL ERROR： http response error ';

            return $arrMsg;
        }

        $arrMsg[ 'code' ] = $curl_info[ 'http_code' ];
        $arrMsg[ 'data' ] = $result;
        $arrMsg[ 'msg' ] = 'REMOTE: http code ' . $curl_info[ 'http_code' ];

        return $arrMsg;
    }
}

