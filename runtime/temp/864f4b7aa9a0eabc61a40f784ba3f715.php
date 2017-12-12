<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:45:"./template/mobile/new2/goods\brandstreet.html";i:1499420874;s:41:"./template/mobile/new2/public\header.html";i:1505386666;s:45:"./template/mobile/new2/public\header_nav.html";i:1499420874;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>品牌街--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <link rel="stylesheet" href="__STATIC__/css/style.css">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/iconfont.css"/>
    <script src="__STATIC__/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/layer.js"  type="text/javascript" ></script>
    <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">


        #add_user_form label.error
        {
            color:Red;
            font-size:14px;
            margin-right:20px;
            padding-right:16px;

        }
    </style>
</head>
<body class="">

<div class="classreturn loginsignup ">
    <div class="content">
        <div class="ds-in-bl return">
            <a href="javascript:history.back(-1);"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>品牌街</span>
        </div>
        <div class="ds-in-bl menu">
            <a href="javascript:void(0);"><img src="__STATIC__/images/class1.png" alt="菜单"></a>
        </div>
    </div>
</div>
<div class="flool tpnavf">
    <div class="footer">
        <ul>
            <li>
                <a class="yello" href="<?php echo U('Index/index'); ?>">
                    <div class="icon">
                        <i class="icon-shouye iconfont"></i>
                        <p>首页</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Goods/categoryList'); ?>">
                    <div class="icon">
                        <i class="icon-fenlei iconfont"></i>
                        <p>分类</p>
                    </div>
                </a>
            </li>
            <li>
                <!--<a href="shopcar.html">-->
                <a href="<?php echo U('Cart/cart'); ?>">
                    <div class="icon">
                        <i class="icon-gouwuche iconfont"></i>
                        <p>购物车</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('User/index'); ?>">
                    <div class="icon">
                        <i class="icon-wode iconfont"></i>
                        <p>我的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<!--顶部广告图-s-->
    <div class="banner" id="brandstr">
        <?php $pid =400;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1506758400 and end_time > 1506758400 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
if(!in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 1- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
            <a href="<?php echo $v['ad_link']; ?>">
                <img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>"/>
            </a>
        <?php endforeach; ?>
    </div>
<!--顶部广告图-e-->

<!--商品轮播图-s-->
    <div class="banner ban1 brandbanner">
        <div class="maleri30">
            <div class="mslide" id="slideTpshop">
                <ul>
                    <?php if(is_array($recommend_goods) || $recommend_goods instanceof \think\Collection || $recommend_goods instanceof \think\Paginator): if( count($recommend_goods)==0 ) : echo "" ;else: foreach($recommend_goods as $k=>$v): if(count($v) > 0): ?>
                            <li>
                                <?php if(is_array($v) || $v instanceof \think\Collection || $v instanceof \think\Paginator): if( count($v)==0 ) : echo "" ;else: foreach($v as $kk=>$good): ?>
                                <a href="<?php echo U('Goods/goodsInfo',array('id'=>$good[goods_id])); ?>">
                                    <img src="<?php echo goods_thum_images($good[goods_id],200,200); ?>" alt="">
                                    <p class="red">￥<?php echo $good['shop_price']; ?></p>
                                    <p class="lineu">￥<?php echo $good['market_price']; ?></p>
                                </a>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </li>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <div class="signte">
            <i class="l"></i>
            <i class="r"></i>
        </div>
    </div>
<!--商品轮播图-n-->

<!--推荐大牌-s-->
    <div class="tuijbrand">
        <h2 class="titb ma-to-20">推荐大牌</h2>
        <div class="brandlistall">
            <ul id="brandlist">
                <?php if(is_array($brand_list) || $brand_list instanceof \think\Collection || $brand_list instanceof \think\Paginator): if( count($brand_list)==0 ) : echo "" ;else: foreach($brand_list as $key=>$list): ?>
                    <li>
                        <a href="<?php echo U('Goods/search',array('brand_id'=>$list[id])); ?>"><img src="<?php echo $list[logo]; ?>"/></a>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
<!--推荐大牌-e-->
<script type="text/javascript" src="__STATIC__/js/sourch_submit.js"></script>
<script type="text/javascript">
    /**
     * 加载更多品牌
     */
    var page=1;
    function ajax_sourch_submit(){
        ++page;
        $.ajax({
            type:'GET',
            url:"/index.php?m=Mobile&c=Goods&a=brandstreet&is_ajax=1&p="+page,
            success:function(data){
                if($.trim(data) == ''){
                    $('.more').hide();
                    return false;
                }else{
                   $('.more').before(data);
                }
            }
        });
    }
    $(function(){
        $('#brandstr').swipeSlide({
            continuousScroll:true,
            speed : 3000,
            transitionType : 'cubic-bezier(0.22, 0.69, 0.72, 0.88)',
            firstCallback : function(i,sum,me){
                me.find('.dot').children().first().addClass('cur');
            },
            callback : function(i,sum,me){
                me.find('.dot').children().eq(i).addClass('cur').siblings().removeClass('cur');
            }
        });
    });
</script>
	</body>
</html>
