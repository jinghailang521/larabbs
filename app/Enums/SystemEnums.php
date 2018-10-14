<?php
namespace App\Enums;


/**
 * 系统枚举类
 * @author Administrator
 *
 */
class SystemEnums
{
    /**
     * 系统默认语言id
     * @var integer
     */
    const SYSTEM_DEFAULT_LANGUAGE_ID = 1;

    /**
     * 系统第二语言id
     * @var integer
     */
    const SYSTEM_JA_LANGUAGE_ID = 9;
    
    /**
     * 系统 - 表倒叙查询
     * @var string
     */
    const DB_ORDERBY_DESC = 'desc';
    
    /**
     * 系统 - 表正序查询
     * @var string
     */
    const DB_ORDERBY_ASC  = 'asc';
    
   /**
    * 系统 - 默认分页数
    * @var integer
    */
   const SYSTEM_DEFAULT_PAGE_NUM = 50;
   
   /**
    * 关联用户列表分页
    * @var integer
    */
   const SYSTEM_USER_RELUSER_PAGE_NUM = 10;
   
   /**
    * 列表页数据缓存时长
    * - 短时间
    * @var integer
    */
   const SYSTEM_LIST_CACHE_TIME_BRIEF = 5;
   
   /**
    * 列表页数据缓存时长
    * - 中等时间
    * @var integer
    */
   const SYSTEM_LIST_CACHE_TIME_MEDIUM = 10;
   
   /**
    * 列表页数据缓存时长
    * - 长时间
    * @var integer
    */
   const SYSTEM_LIST_CACHE_TIME_LONG =  30;
   
   /**
    * 列表页数据缓存时长
    * - 一小时
    * @var integer
    */
   const SYSTEM_LIST_CACHE_HOUR =  60;
   
   /**
    * 列表页数据缓存时长
    * - 半天
    * @var integer
    */
   const SYSTEM_LIST_CACHE_HAFDAY =  720;
   
   /**
    * 列表页数据缓存时长
    * - 一天
    * @var integer
    */
   const SYSTEM_LIST_CACHE_DAY =  1440;
   
   
   /**
    * api 请求时长
    * @var integer
    */
   const API_REQUEST_CREATE_PRODUCT_WAIT_TIME = 30;

   /**
    * 系统http请求方法 get
    * @var string
    */
   const SYSTEM_HTTP_METHOD_GET = 'GET';
   /**
    * 系统http请求方法 put
    * @var string
    */
   const SYSTEM_HTTP_METHOD_PUT = 'PUT';
   /**
    * 系统http请求方法 post
    * @var string
    */
   const SYSTEM_HTTP_METHOD_POST = 'POST';
   
   /**
    * 系统http请求方法 delete
    * @var string
    */
   const SYSTEM_HTTP_METHOD_DELETE = 'DELETE';
   
   /**
    * 系统http 数据格式 json
    * @var string
    */
   const SYSTEM_HTTP_DATA_FORMAT_JSON = 'JSON';
   
   /**
    * 系统http 数据格式 string
    * @var string
    */
   const SYSTEM_HTTP_DATA_FORMAT_STRING = 'STRING';
   
   /**
    * 系统相似度匹配界限
    * @var string
    */
   const SYSTEM_DUPLICATE_RATE = 1;
   
   /**
    * 系统相似度二次匹配界限
    * @var string
    */
   const SYSTEM_DUPLICATE_RATE_LOW = 0.9;
   
   /**
    * 系统相似度 - 是否为关联关系相似
    * @var string
    */
   const SYSTEM_DUPLICATE_RELATION_TRUE = 1;
   
   /**
    * 系统 - 尺码库
    * @var string
    */
   const SYSTEM_SIZE_LIBRARY  = 0;
   
   /**
    * 系统产品得spu个数
    * @var integer
    */
   const SYSTEM_PRODUCT_SPU_NUM  = 10;
   
   /**
    * 超全局管理员 id
    * @var integer
    */
   const USER_SUPERADMIN_ID = 1;
   
   
   /**
    * 系统主页路由默认名称
    * @var string
    */
   const SYSTEM_INDEX_DEFAULT_ROUTENAME = 'dasboard';
   
   
   /**
    * 系统默认父级id
    * @var integer
    */
   const SYSTEM_DEFAULT_PARENT_ID = 0;
   
   /**
    * 系统操作成功代码
    * @var integer
    */
   const SYSTEM_OPERATE_CODE_SUCCESS = 0;
    
   /**
    * 系统操作失败代码
    * @var integer
    */
   const SYSTEM_OPERATE_CODE_FAIL = 1;
   
   /**
    * 系统提示级别 - 成功
    * @var unknown
    */
   const SYSTEM_LEVEL_SUCCESS = 'success';
   
   /**
    * 系统提示级别 - 失败
    * @var string
    */
   const SYSTEM_LEVEL_ERROR = 'error';
   
   /**
    * 系统提示级别 - 信息
    * @var string
    */
   const SYSTEM_LEVEL_INFO = 'info';
    
   /**
    *系统提示级别 - 警告
    * @var string
    */
   const SYSTEM_LEVEL_WARNING = 'warning';
   
   /**
    * 系统操作日志类型 - 发生在用户模块
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_USER = 1;
   
   /**
    * 系统操作日志类型 - 发生在角色模块
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_ROLE = 2;
   
   /**
    * 系统操作日志类型 - 发生在权限模块
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_PERMS = 3;
   
   /**
    * 系统操作日志类型 - 发生在尺码表模块
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_SIZE = 4;
   
   /**
    * 系统操作日志类型 - 发生在语言模块
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_LANGUAGE = 5;
   
   /**
    * 系统操作日志类型 - 发生在特征模块
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_FEATURE = 6;
   
   
   /**
    * 系统操作日志类型 - 发生在产品特征模块
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_CATEGORY = 7;
   
   /**
    * 系统操作日志类型 - 发生在访问密钥
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_ACCESSAPIKEY = 8;
   
   /**
    * 系统操作日志类型 - 发生在特征组
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_FEATURE_GROUPS = 9;
   
   /**
    * 系统操作日志类型 - 发生在平台模块
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_PLATFORM = 10;
   
   /**
    * 系统操作日志类型 - 发生在推送产品
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_PUSHPRODUCT = 11;
   
   /**
    * 系统操作日志类型 - 发生在平台图集尺寸
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_IMAGESIZE = 12;
   
   /**
    * 系统操作日志类型 - 发生在店铺
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_SHOPS = 13;
   
   /**
    * 系统操作日志类型 - 发生在尺码组
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_SIZE_GROUPS = 14;
   
   /**
    * 系统操作日志类型 - 发生在接入站点模块
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_ACCESS_SITES = 15;
   
   
   /**
    * 系统操作日志类型 - 发生在录入ip名单
    * @var integer
    */
   const SYSTEM_OPTLOG_MODULE_INTERFACE_IP = 16;
   
   /**
    * 系统操作日志操作 - 登录
    * @var integer
    */
   const SYSTEM_OPTLOG_ACTION_LOGIN = 0;
   
   /**
    * 系统操作日志操作 - 登出
    * @var integer
    */
   const SYSTEM_OPTLOG_ACTION_LOGOUT = 1;
   
   /**
    * 系统操作日志操作 - 创建
    * @var integer
    */
   const SYSTEM_OPTLOG_ACTION_CREATE = 2;
   
   /**
    * 系统操作日志操作 - 编辑
    * @var integer
    */
   const SYSTEM_OPTLOG_ACTION_EDIT = 3;
   
   /**
    * 系统操作日志操作 - 删除
    * @var integer
    */
   const SYSTEM_OPTLOG_ACTION_DELETE = 4;
   
   /**
    * 系统操作日志操作 - 严重操作
    * @var integer
    */
   const SYSTEM_OPTLOG_ACTION_DANGER = 5;
   
   /**
    * 平台商品来源- 采集
    * @var integer
    */
   const SYSTEM_PRODUCT_SOURCE_TYPE_CATCH = 0;
   
   /**
    * 平台商品来源- 商城站导入
    * @var integer
    */
   const SYSTEM_PRODUCT_SOURCE_TYPE_IMPORT = 1;

    /**
     * 平台商品来源- 商城站推送
     * @var integer
     */
    const SYSTEM_PRODUCT_SOURCE_TYPE_PUSH = 2;
   
   
   /**
    * 系统内存大小
    * @var string
    */
   const SYSTEM_ALLOW_MEMORY_LIMIT = '528M';

    /**
     * 系统图片上传单文件大小
     * @var string
     */
    const SYSTEM_ALLOW_UPLOAD_MAX_FILESIZE = '16M';

    /**
     * 图片类型 - 内容图片
     * @var string
     */
    const SYSTEM_IMAGE_CONTENT = 1;

    /**
     * 图片类型 - 特色图片
     * @var string
     */
    const SYSTEM_IMAGE_FEATURE = 2;

    /**
     * 图片类型 - 选项图片
     * @var string
     */
    const SYSTEM_IMAGE_OPTION = 3;

    /**
     * 价格货源接口 - 每页获取的记录数
     * @var string
     */
    const SYSTEM_PRICE_SOURCE_NUM = 2000;

    /**
     * 采集统一接口队列任务url限制数量
     *
     */
    const FETCH_URL_MAX_NUM = 1;

    /**
     * 产品库的平台标识
     *
     */
    const PRODUCT_LIBRARY_PLATFORM = 0;

    /**
     * 系统提交类型
     * 仅保存
     * @var string
     */
    const SYSTEM_SAVE_TYPE_SAVED = 'save';
    
    /**
     * 系统提交类型
     * 保存并关闭
     * @var string
     */
    const SYSTEM_SAVE_TYPE_SAVED_AND_CLOSE = 'save-close';

    /**
     * 系统上传的图片来源
     * @var int
     */
    const SYSTEM_LOCAL_IMAGE_FROM = 1;
    
    /**
     * 设置回推类型 - 合并回推
     */
    const PUSH_PRODUCT_BACK_TYPE_PROMPTLY = 'promptly';
    
    /**
     * 设置回推类型 - 整体回推
     */
    const PUSH_PRODUCT_BACK_TYPE_WHOLE = 'whole';

    /**
     * 设置产品列表默认图名称
     */
    const PRODUCT_MAIN_THUMB = 'default-thumb_120x120.png';

    /**
     * 产品查重结束标识
     * @var integer
     */
    const PRODUCT_IS_DUPLICATED = 0;
    
    
    /**
     * 推送产品携带数量
     * @var integer
     */
    const SYSTEM_PUSH_DEFAULT_TAKE_NUM = 1;
    
    
     /**
     * ElasticSearch 的配置-shards number
     * @var integer
     */
    const ELASTICSEARCH_SHARDS_NUMBER = 3;

    /**
     * ElasticSearch 的配置-replicas number
     * @var integer
     */
    const ELASTICSEARCH_REPLICAS_NUMBER = 1;

    /**
     * ElasticSearch 的配置-index name
     * @var integer
     */
    const ELASTICSEARCH_INDEX_NAME = 'product_library';

    /**
     * ElasticSearch 的配置-type name
     * @var integer
     */
    const ELASTICSEARCH_TYPE_NAME = 'product_statistic';

    /**
     * ElasticSearch 的配置- 批量写入的数量
     * @var integer
     */
    const ELASTICSEARCH_WRITE_LIMIT = 100;

    /**
     * 系统 - 默认分页数
     * @var integer
     */
    const ELASTICSEARCH_DEFAULT_PAGE_LIMIT = 1000;
    
    
    
}

