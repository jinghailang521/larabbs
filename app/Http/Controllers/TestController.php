<?php
namespace App\Http\Controllers;


use App\Libraries\HttpUtils;
use Illuminate\Support\Facades\DB;
use DiDom\Document;

/**
 * 测试 控制器
 * @author Administrator
 *
 */
class TestController extends Controller
{
    
    
    public function index()
    {
                
        set_time_limit( 0 );
        
        $iStartTime = microtime( true );
        $domain = 'baidu.com';
        $config = config( 'system.api.pl' );
        $header = [ 'api-key:' . $config[ 'key' ], 'api-token:' . $config[ 'token' ] ];
        $data = array();
        $productTable = DB::table( 'products' )->select( 'id', 'title', 'old_price', 'market_price', 'product_pricute_source', 'product_url', 'desc' )->get();
        if( isset( $productTable ) && count( $productTable ) > 0 )
        {
            $arrPids = array();
            foreach ( $productTable as $product )
            {
                $info[ 'language' ] = 'en';
                $info[ 'idcode' ] = $product->id;
                $info[ 'name' ] = $product->title;
                $info[ 'price' ] = $product->market_price;
                $info[ 'stock' ] = rand( 999, 5000 );
                
                $strDescription = $product->desc;
                if( isset( $product->product_pricute_source ) && strlen( $product->product_pricute_source ) )
                {
                    $images = json_decode( $product->product_pricute_source, true );
                    if( isset( $images[ 'product_feature_image' ] ) && !empty( $images[ 'product_feature_image' ] ) )
                    {
                        $info[ 'images' ] = $images[ 'product_feature_image' ];
                    }
                    if( isset( $images[ 'product_content_image' ] ) && !empty( $images[ 'product_content_image' ] ) )
                    {
                        foreach ( $images[ 'product_content_image' ] as $conImgs )
                        {
                            $strDescription .= '<p><img src="'.$conImgs.'"  /></p>';
                        }
                    }
                }
                $info[ 'content' ] = $strDescription;
                //货源
                if( isset( $product->product_url ) && strlen( $product->product_url ) )
                {
                    $source[ 'source_url' ] = $product->product_url;
                    $source[ 'price' ] = $product->old_price;
                    $source[ 'market_price' ] = $product->market_price;
                    
                    $info[ 'sources' ][] = $source;
                    unset( $source );
                }
                $info['sites'] = 45;
                // $info['from']  = 'shopfiy';
                $data[$product->id] = $info;
                $arrPids[] = $product->id;
                unset( $info );
                unset( $product );
                unset( $strDescription );
            }
            if( !empty( $arrPids ) )
            {
                //----------------------------------------
                //分类
                $productToCateTable = DB::table( 'products_to_categories' )->select( 'product_id', 'category_id' )->whereIn( 'product_id', $arrPids )->get();
                if( isset( $productToCateTable ) && count( $productToCateTable ) > 0 )
                {
                    foreach ( $productToCateTable as $relCate )
                    {
                        $categoryTable = DB::table( 'categories' )->select( 'id', 'title' )->find( $relCate->category_id );
                        if( isset( $categoryTable ) && count( $categoryTable ) > 0 )
                        {
                            if( isset( $categoryTable->title ) && strlen( $categoryTable->title ) > 0 )
                            {
                                $data[$relCate->product_id][ 'categorys' ][] = $categoryTable->title;
                            }
                            else if( isset( $categoryTable->cn_title ) && strlen( $categoryTable->cn_title ) > 0 )
                            {
                                $data[$relCate->product_id][ 'categorys' ][] = $categoryTable->cn_title;
                            }
                            else
                            {
                                continue;
                            }
                        }
                    }
                }
                
                foreach ( $arrPids as $productId )
                {
                    //-----------------------------------------------
                    //sku
                    $skuTable = DB::table( 'product_skus' )->select( 'id', 'option_values', 'product_id', 'sku_price', 'sku_thumb' )->where( 'product_id', $productId )->get();
                    if( isset( $skuTable ) && count( $skuTable ) > 0 )
                    {
                        foreach ( $skuTable as $sku )
                        {
                            $opvalue = json_decode( $sku->option_values, true );
                            if( !isset( $opvalue ) || empty( $opvalue ) )
                            {
                                continue;
                            }
                            $skuInfo[ 'price' ]  = $sku->sku_price;
                            $skuInfo[ 'status' ] = true;
                            $skuInfo[ 'stock' ] = rand( 500, 1000 );
                            $skuInfo[ 'thumb' ]  = $sku->sku_thumb;
                            foreach ( $opvalue as $op=>$value )
                            {
                                $opinfo[ 'opt_key' ] = $op;
                                $opinfo[ 'opt_value' ] = $value;
                                if( 'color' == trim( strtolower( $op ) ) )
                                {
                                    $opinfo[ 'opt_thumb' ] = $sku->sku_thumb;
                                }
                                
                                $skuInfo[ 'options' ][] = $opinfo;
                                unset( $opinfo );
                            }
                            $data[$sku->product_id][ 'skus' ][] = $skuInfo;
                            unset( $skuInfo );
                        }
                    }
                    else
                    {//选项
                        $optionTable = DB::table( 'product_options' )->select( 'id', 'name', 'product_id' )->where( 'product_id', $productId )->get();
                        if( isset( $optionTable ) && count( $optionTable ) > 0 )
                        {
                            foreach ( $optionTable as $option )
                            {
                                $optionValTable = DB::table( 'product_option_values' )->select( 'id', 'name' )->where( 'option_id', $option->id )->get();
                                if( isset( $optionValTable ) && count( $optionValTable ) > 0 )
                                {
                                    if( !isset( $option->name ) || strlen( $option->name ) <= 0 )
                                    {
                                        continue;
                                    }
                                    
                                    $op[ 'name' ] = $option->name;
                                    $op[ 'values' ] = array();
                                    foreach ( $optionValTable as $value )
                                    {
                                        if( isset( $value->name ) && strlen( $value->name ) > 0 )
                                        {
                                            $op[ 'values' ][] = $value->name;
                                        }
                                    }
                                    
                                    $data[$option->product_id][ 'options' ][] = $op;
                                    unset( $op );
                                }
                            }
                        }
                    }
                }
            }
        }
        $iEdnTime = microtime( true );
        if( !empty( $data ) )
        {
            echo '推送产品数量为：' . count( $data ) . ' /个， 检测耗时：' .round( $iEdnTime-$iStartTime, 2 ).' /s <br />';
            $iPushTimeStart = microtime( true );
            $util = HttpUtils::getInstance();
            $request = $util->curlGet( $config[ 'url' ] . '/requests/lock/' . $domain , $header );
            if( !isset( $request[ 'data' ] ) || strlen( $request[ 'data' ] ) <= 0 )
            {
                echo '本次推送出现异常信息：' . $request[ 'msg' ] . '<br />';
                exit;
            }
            $arrTokenInfo = json_decode( $request[ 'data' ], true );
            if( empty( $arrTokenInfo ) || !isset( $arrTokenInfo[ 'access_token' ] ) )
            {
                echo '本次推送出现异常信息：未识别的   access_token ，异常信息为： code-' . $arrTokenInfo[ 'status' ] . '，' . $arrTokenInfo[ 'msg' ] .'  <br />';
                exit;
            }
            $header[] = '-token:' . $arrTokenInfo[ 'access_token' ];
            
            $iTurn = 0;
            foreach ( $data as $item )
            {
                // dd($item);
                $isTime = microtime( true );
                $result = $util->curlPost( $config[ 'url' ] . '/product/create', $item, $header );
                if( isset( $result[ 'data' ] ) && strlen( $result[ 'data' ] ) )
                {
                    $arrRes = json_decode( $result[ 'data' ], true );
                    if( isset( $arrRes[ 'status' ] ) && $arrRes[ 'status' ] )
                    {
                        echo '<br />产品编号为：' . $item[ 'idcode' ] . '，产品名称为：' . $item[ 'name' ] . '， 返回状态为：' . $arrRes[ 'status' ] . '<br />';
                    }
                }
                $ieTime = microtime( true );
                echo ' 本此推送序号为：'.++$iTurn.'，产品编号为：' . $item[ 'idcode' ] . '，产品名称为：' . $item[ 'name' ] . '，本次耗时为：' . round( $ieTime-$isTime, 2 ).' /s'. '<br /><br />';
            }
            $util->curlGet( '/requests/unlock/' . $domain, $header );
            $iPushTimeEnd = microtime( true );
            
            echo ' 本此推送产已完成，推送共耗时为：' . round( $iPushTimeEnd-$iPushTimeStart, 2 ).' /s'. '<br />';
            
        }
        else
        {
            echo '数据检测异常，未发现可推送的产品信息. 检测耗时：' .round( $iEdnTime-$iStartTime, 2 ).' /s'. '<br />';
        }
        
        exit;
    }
    
}

