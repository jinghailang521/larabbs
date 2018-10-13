<?php
namespace App\Enums;



/**
 * http 响应状态
 * @author Administrator
 *
 */
class HttpCodeEnums
{


    /**
     * curl 请求url错误异常代码
     * url 地址异常
     * @var integer
     */
    const HTTP_CURL_RESPONSE_ERROR_URL_ABNORMAL = 6;


    /**
     * curl 货源价格请求参数错误
     * post data 参数格式错误
     * @var integer
     */
    const HTTP_CURL_RESPONSE_ERROR_PARAM_INVALID = 1;

    
    /**
     * http 响应成功
     * @var integer
     */
    const HTTP_RESPONSE_CODE_SUCCESS = 200;
    

    /**
     * 未知的错误
     * @var integer
     */
    const HTTP_CODE_ERROR = 0;
    


    /**
     * http 返回状态分级 
     * @var integer
     */
    const HTTP_CODE_SUCCESS_ERROR_AGENCY = 400;
    


    /**
     * 密钥方式未开启
     * @var integer
     */
    const HTTP_CODE_TOKEN_SWITCH_CLODE = 4000;
    


    /**
     * header 未发现api_key api_token 异常请求
     * @var integer
     */
    const HTTP_CODE_HEADER_ENPTY = 40001;
    


    /**
     * api_key 未找到
     * @var integer
     */
    const HTTP_CODE_USER_NOTFOUND = 40002;
    


    /**
     * api_token 未找到
     * @var integer
     */
    const HTTP_CODE_TOKEN_NOTFOUND = 40003;
    


    /**
     * key token 不匹配
     * @var integer
     */
    const HTTP_CODE_KEY_TOKEN_NOTMATCH = 40004;
    


    /**
     * 未发现匹配的数据
     * @var integer
     */
    const HTTP_CODE_NOTMACTH_DATAS = 40010;
    


    /**
     * 未发现匹配的站点信息
     * @var integer
     */
    const HTTP_CODE_NOTMACTH_SITEINFO = 40011;
    


    /**
     * 未发现匹配的推送任务标记
     * @var integer
     */
    const HTTP_CODE_NOTMACTH_PUSHSIGN = 40012;

    
    
    /**
     * 未发现匹配的推送任务标记
     * @var integer
     */
    const HTTP_CODE_PUSHSIGN_STATUS_ERROR = 40013;
    
    
    
    /**
     * 未匹配到客户端ip
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_CLIENT_IP = 40016;

    
    /**
     * 客户端ip 为黑名单
     * @var integer
     */
    const HTTP_CODE_CLIENT_IP_IS_BLOCK = 40017;




    ///////////////////////////////////////////////////////////
    //公共异常代码块
    /**
     * 数据库保存异常
     * @var integer
     */
    const HTTP_CODE_DATABASE_ERROR = 40014;


    /**
     * 未识别得参数
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_SIGN = 40014;


    /**
     * 未识别得语言代码
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_LANGUAGE = 40015;







    ///////////////////////////////////////////////////////////
    //产品异常代码块
    /**
     * 未发现产品信息
     * @var integer
     */
    const HTTP_CODE_UNKOMW_PRODUCT = 41001;


    /**
     * 产品已合并，且合并信息未找到
     * @var integer
     */
    const HTTP_CODE_UNKOMW_DEUPLICATE_PRODUCT = 41002;


    /**
     * 未定义得集合 item_category_id
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_SET_PRODUCT_CATEGORY = 41003;


    /**
     * 未定义得集合 category
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_SET_CATEGORY = 41004;


    /**
     * 未定义得集合 name
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_SET_NAME = 41005;


    /**
     * 未定义得集合 price
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_SET_PRICE = 41006;

    /**
     * 未定义得集合 sources
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_SET_SOURCE = 41007;
    
    
    /**
     * 未识别的 _token
     * @var integer
     */
    const HTTP_CODE_INVISIBLE_PRODUCT_TOKEN = 41008;
    
    
    
    /**
     * token 不匹配
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_PRODUCT_TOKEN = 41009;
    
    /**
     * 数据类型错误
     * @var integer
     */
    const HTTP_CODE_UNMACTH_DATA_TYPE = 41010;








    ///////////////////////////////////////////////////////////
    //分类异常代码块
    /**
     *  未找到分类信息
     * @var integer
     */
    const HTTP_CODE_UNKOMW_CATEGORY = 42001;









    ///////////////////////////////////////////////////////////
    //货源异常代码块
    /**
     *  货源信息未找到
     * @var integer
     */
    const HTTP_CODE_UNKOMW_SOURCE = 43001;
    /**
     *  未定义得集合 item_sources
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_SET_PRODUCT_SOURCE = 43002;
    
    
    
    
    
    
    
    
    
    
    
    ///////////////////////////////////////////////////////////
    //sku异常代码块
    /**
     *  未定义得集合 item_skus
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_SET_PRODUCT_SKUS = 44002;
    
    
    /**
     * 数据异常，未检测到  options 信息导致sku入库失败
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_SET_SKU_OPTIONS = 44003;
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    ///////////////////////////////////////////////////////////
    //请求异常代码块
    /**
     *  未定义得集合 domain
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_REQUEST_DOMAIN = 45001;
    
    /**
     * 请求占用
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_REQUEST_OCCUPY= 45002;
    
    /**
     * 野锁
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_REQUEST_LOCK = 45003;
    
    /**
     * 瞎解锁
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_REQUEST_UNKNOW_DOMAIN = 45004;
    
    
    
    
    
    
    ///////////////////////////////////////////////////////////
    //采集异常代码块
    /**
     *  未定义得集合   url_ids
     * @var integer
     */
    const HTTP_CODE_UNDEFINED_COLLECTS_URL_IDS = 46001;
    
    

    
    
}

