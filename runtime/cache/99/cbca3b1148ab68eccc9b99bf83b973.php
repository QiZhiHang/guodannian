<?php
//000000000000s:70064:"<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商品详情</title>
    <link rel="stylesheet" type="text/css" href="/template/pc/rainbow/static/css/tpshop.css" />
    <link rel="stylesheet" type="text/css" href="/template/pc/rainbow/static/css/jquery.jqzoom.css">
    <script src="/template/pc/rainbow/static/js/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/public/js/layer/layer-min.js"></script>
    <script type="text/javascript" src="/template/pc/rainbow/static/js/jquery.jqzoom.js"></script>
    <script src="/public/js/global.js"></script>
    <script src="/public/js/pc_common.js"></script>
    <link rel="stylesheet" href="/template/pc/rainbow/static/css/location.css" type="text/css"><!-- 收货地址，物流运费 -->
</head>
<body>
<!--header-s-->

<!--header-s-->
    <div class="tpshop-tm-hander tp_h_alone p">
        <!--导航栏-s-->
        <div class="top-hander p">
            <div class="w1224 pr p">
                <div class="fl">
                    <!-- 收货地址，物流运费 -start-->
                    <div class="sendaddress pr fl">
                        <span>送货至：</span>
                        <span>
                            <ul class="list1">
                                <li class="summary-stock though-line">
                                    <div class="dd" style="border-right:0px;width:200px;">
                                        <div class="store-selector add_cj_p">
                                            <div class="text"><div></div><b></b></div>
                                            <div onclick="$(this).parent().removeClass('hover')" class="close"></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </span>
                    </div>
                    <!-- 收货地址，物流运费 -end-->
                        <div class="fl nologin">
                            <a class="red" href="/Home/user/login.html">Hi.请登录</a>
                            <!-- <a href="/Home/user/reg.html">免费注册</a> -->
                        </div>
                        <div class="fl islogin">
                            <a class="red userinfo" href="/Home/user/index.html" ></a>
                            <a  href="/Home/user/logout.html"  title="退出" target="_self">安全退出</a>
                        </div>
                </div>
                <div class="top-ri-header fr">
                    <ul>
                        <!-- <li><a target="_blank" href="/Home/User/order_list.html">我的订单</a></li>
                        <li class="spacer"></li>
                        <li><a target="_blank" href="/Home/User/visit_log.html">我的浏览</a></li>
                        <li class="spacer"></li>
                        <li><a target="_blank" href="/Home/User/coupon.html">我的优惠券</a></li>
                        <li class="spacer"></li>
                        <li><a target="_blank" href="/Home/User/goods_collect.html">我的收藏</a></li>
                        <li class="spacer"></li>
                        <li><a target="_blank" title="点击这里给我发消息" href="/Home/Article/detail/article_id/22.html" target="_blank">在线客服</a></li>
                        <li class="spacer"></li>
                        <li class="hover-ba-navdh">
                            <div class="nav-dh">
                                <span>网站导航</span>
                                <i class="share-a_a1"></i>
                                <div class="conta-hv-nav">
                                    <ul>
                                        <li>
                                            <a href="/Home/Activity/group_list.html">团购</a>
                                        </li>
                                        <li>
                                            <a href="/Home/Index/index.html">首页</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
        <!--导航栏-e-->
        <div class="nav-middan-z p">
            <div class="header w1224 p">
                <div class="ecsc-logo">
                    <a href="/home/Index/index.html" class="logo"> <img src="/public/upload/logo/2017/09-20/0017b992292003ed91cdadfd659dcbd1.png"></a>
                </div>
                <!--搜索-s-->
               <!--  <div class="ecsc-search">
                    <form id="searchForm" name="" method="get" action="/Home/Goods/search.html" class="ecsc-search-form">
                        <input autocomplete="off" name="q" id="q" type="text" value="" placeholder="搜索关键字" class="ecsc-search-input">
                        <button type="submit" class="ecsc-search-button" onclick="if($.trim($('#q').val()) != '') $('#searchForm').submit();"><i></i></button>
                        <div class="candidate p">
                            <ul id="search_list"></ul>
                        </div>
                        <script type="text/javascript">
                            ;(function($){
                                $.fn.extend({
                                    donetyping: function(callback,timeout){
                                        timeout = timeout || 1e3;
                                        var timeoutReference,
                                                doneTyping = function(el){
                                                    if (!timeoutReference) return;
                                                    timeoutReference = null;
                                                    callback.call(el);
                                                };
                                        return this.each(function(i,el){
                                            var $el = $(el);
                                            $el.is(':input') && $el.on('keyup keypress',function(e){
                                                if (e.type=='keyup' && e.keyCode!=8) return;
                                                if (timeoutReference) clearTimeout(timeoutReference);
                                                timeoutReference = setTimeout(function(){
                                                    doneTyping(el);
                                                }, timeout);
                                            }).on('blur',function(){
                                                doneTyping(el);
                                            });
                                        });
                                    }
                                });
                            })(jQuery);

                            $('.ecsc-search-input').donetyping(function(){
                                search_key();
                            },500).focus(function(){
                                var search_key = $.trim($('#q').val());
                                if(search_key != ''){
                                    $('.candidate').show();
                                }
                            });
                            $('.candidate').mouseleave(function(){
                                $(this).hide();
                            });

                            function searchWord(words){
                                $('#q').val(words);
                                $('#searchForm').submit();
                            }
                            function search_key(){
                                var search_key = $.trim($('#q').val());
                                if(search_key != ''){
                                    $.ajax({
                                        type:'post',
                                        dataType:'json',
                                        data: {key: search_key},
                                        url:"/Home/Api/searchKey.html",
                                        success:function(data){
                                            if(data.status == 1){
                                                var html = '';
                                                $.each(data.result, function (n, value) {
                                                    html += '<li onclick="searchWord(\''+value.keywords+'\');"><div class="search-item">'+value.keywords+'</div><div class="search-count">约'+value.goods_num+'个商品</div></li>';
                                                });
                                                html += '<li class="close"><div class="search-count">关闭</div></li>';
                                                $('#search_list').empty().append(html);
                                                $('.candidate').show();
                                            }else{
                                                $('#search_list').empty();
                                            }
                                        }
                                    });
                                }
                            }
                        </script>
                    </form>
                    <div class="keyword">
                        <ul>
                                                            <li>
                                    <a href="/Home/Goods/search/q/%E9%85%92.html" target="_blank">酒</a>
                                </li>
                                                            <li>
                                    <a href="/Home/Goods/search/q/%E5%B0%8F%E6%B4%9E%E4%BB%99.html" target="_blank">小洞仙</a>
                                </li>
                                                    </ul>
                    </div>
                </div> -->
                <!--搜索-e-->
                <!--购物车-s-->
                
               <!--  <div class="shopingcar-index fr">
                    <div class="u-g-cart fr fixed" id="hd-my-cart">
                        <a href="/Home/Cart/cart.html">
                            <div class="c-n fl" >
                                <i class="share-shopcar-index"></i>
                                <span>我的购物车<em class="sc_z" id="cart_quantity"></em></span>
                            </div>
                        </a>
                        <div class="u-fn-cart u-mn-cart" id="show_minicart"></div>
                    </div>
                </div> -->
                <!--购物车-e-->
            </div>
        </div>
        <!--商品分类-s-->
        <div class="nav p">
            <div class="w1224 p">
                <div class="categorys2 home_categorys">
                    <div class="dt">
                        <a href="/Home/Goods/all_category.html" target="_blank"><i class="share-a_a2"></i>全部商品分类</a>
                    </div>
                    <!--全部商品分类-s-->
                    <div class="dd">
                        <div class="cata-nav">
                            <!-- 外层循环点-->
                                                        <div class="item fore1">
                                                                <div class="item-left">
                                    <div class="cata-nav-name">
                                        <h3>
                                            <div class="contiw-cer"><span class="share-icon-844"></span></div>
                                            <a href="/Home/Goods/goodsList/id/844.html" title="酒类">酒类</a>
                                        </h3>
                                    </div>
                                    <b>&gt;</b>
                                </div>
                                                                <div class="cata-nav-layer">
                                    <div class="cata-nav-left">
                                        <div class="subitems">
                                                                                        <!--商品分类底部广告-s-->
                                            <div class="advertisement_down">
                                                <ul>                                                
                                                                                                            <li>
                                                            <a href="http://www.tp-shop.cn/" >
                                                                <img src="/public/upload/ad/2017/05-20/b6978d49ea385b990772c356af29d54f.jpg" title="" style="" width="129" height="45"/>
                                                            </a>
                                                        </li>
                                                                                                    
                                                </ul>
                                            </div>
                                            <!--商品分类底部广告-e-->
                                        </div>
                                    </div>
                                    <!--商品分类右侧广告-s-->
                                    <div class="cata-nav-rigth">
                                                                                    <a href="" target="_blank">
                                                <img src="/public/upload/ad/2017/09-20/67736d759254649885a90054e1a70037.jpg" title="" style=""/>
                                            </a>
                                                                            </div>
                                    <!--商品分类右侧广告-e-->
                                </div>
                            </div>
                                                    </div>
                    </div>
                    <!--全部商品分类-e-->
                </div>
                <!--导航栏-s-->
                 <div class="navitems" id="nav">
                    <ul>
                        <li class="index_modify">
                            <a href="/home/Index/index.html" class="selected">首页</a>
                        </li>
                                            </ul>
                    <!-- <div class="wrap-line" style="width: 72px; left: 20px;">
                        <span style="left:15px;"></span>
                    </div> -->
                </div>
                <!--导航栏-e-->
            </div>
        </div>
        <!--商品分类-e-->
    </div>
    <!--header-e
<!--header-e-->
<div class="search-box p">
    <div class="w1224">
        <div class="search-path fl">
                            <a href="/Home/Goods/goodsList/id/844.html">酒类</a>
                <i class="litt-xyb"></i>
                            <a href="/Home/Goods/goodsList/id/845.html">小洞仙</a>
                <i class="litt-xyb"></i>
                            <a href="/Home/Goods/goodsList/id/847.html">小洞仙53°</a>
                <i class="litt-xyb"></i>
                        <div class="havedox">
                <span>【商城推荐】吉尼斯官方认证53°洞藏</span>
            </div>
        </div>
    </div>
</div>
<div class="details-bigimg p">
    <div class="w1224">
        <div class="detail-img">
            <div class="product-gallery">
                <div class="product-photo" id="photoBody">
                    <!-- 商品大图介绍 start [[-->
                    <div class="product-img jqzoom">
                        <img id="zoomimg" src="/public/upload/goods/thumb/144/goods_thumb_144_400_400.jpeg" jqimg="/public/upload/goods/thumb/144/goods_thumb_144_800_800.jpeg">
                    </div>
                    <!-- 商品大图介绍 end ]]-->
                    <!-- 商品小图介绍 start [[-->
                    <div class="product-small-img fn-clear"> <a href="javascript:;" class="next-left next-btn fl disabled"></a>
                        <div class="pic-hide-box fl">
                            <ul class="small-pic" style="left:0;">
                                                                    <li class="small-pic-li active">
                                    <a href="javascript:;">
                                        <img src="/public/images/icon_goods_thumb_empty_300.png" data-img="/public/images/icon_goods_thumb_empty_300.png" data-big="/public/images/icon_goods_thumb_empty_300.png">
                                        <i></i>
                                    </a>
                                    </li>
                                                                    <li class="small-pic-li ">
                                    <a href="javascript:;">
                                        <img src="/public/images/icon_goods_thumb_empty_300.png" data-img="/public/images/icon_goods_thumb_empty_300.png" data-big="/public/images/icon_goods_thumb_empty_300.png">
                                        <i></i>
                                    </a>
                                    </li>
                                                            </ul>
                        </div>
                        <a href="javascript:;" class="next-right next-btn fl"></a> </div>
                    <!-- 商品小图介绍 end ]]-->
                </div>
                <!-- 收藏商品 start [[-->
                <div class="collect">
                    <a href="javascript:void(0);" id="collectLink"><i class="collect-ico collect-ico-null"></i>
                        <span class="collect-text">收藏商品</span>
                        <em class="J_FavCount"></em></a>
                    <!--<a href="javascript:void(0);" id="collectLink"><i class="collect-ico collect-ico-ok"></i>已收藏<em class="J_FavCount">(20)</em></a>-->
                </div>
                <!-- 分享商品 -->
                <div class="share">
                    <div class="jiathis_style">
                        <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt" target="_blank"><img src="http://v3.jiathis.com/code_mini/images/btn/v1/jiathis1.gif" border="0" /></a>
                    </div>
                    <script>
                        var jiathis_config = {
                            url:"http://www.newtpshop.com/index.php?m=Home&c=Goods&a=goodsInfo&id=144",
                            pic:"http://www.newtpshop.com/public/upload/goods/thumb/144/goods_thumb_144_400_400.jpeg",
                        }
                        var is_distribut = getCookie('is_distribut');
                        var user_id = getCookie('user_id');
                        // 如果已经登录了, 并且是分销商
                        if(parseInt(is_distribut) == 1 && parseInt(user_id) > 0)
                        {
                            jiathis_config.url = jiathis_config.url + "&first_leader="+user_id;
                        }
                    </script>
                    <script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js" charset="utf-8"></script>
                </div>
            </div>
        </div>
        <form id="buy_goods_form" name="buy_goods_form" method="post" >
            <input type="hidden" name="goods_prom_type" value="0"/><!-- 活动类型 -->
            <input type="hidden" name="shop_price" value="3000.00"/><!-- 活动价格 -->
            <input type="hidden" name="store_count" value="99"/><!-- 活动库存 -->
            <input type="hidden" name="market_price" value="3100.00"/><!-- 商品原价 -->
            <input type="hidden" name="start_time" value=""/><!-- 活动开始时间 -->
            <input type="hidden" name="end_time" value=""/><!-- 活动结束时间 -->
            <input type="hidden" name="activity_title" value=""/><!-- 活动标题 -->
            <input type="hidden" name="prom_detail" value=""/><!-- 促销活动的促销类型 -->
            <input type="hidden" name="activity_is_on" value=""/><!-- 活动是否正在进行中 -->
            <input type="hidden" name="item_id" value=""/><!-- 商品规格id -->
            <div class="detail-ggsl">
                <h1>【商城推荐】吉尼斯官方认证53°洞藏</h1>
                <div class="presale-time" style="display: none">
                    <div class="pre-icon fl">
                        <span class="ys"><i class="detai-ico"></i><span id="activity_type">抢购活动</span></span>
                    </div>
                    <div class="pre-icon fr">
                        <span class="per" style="display: none"><i class="detai-ico"></i><em id="order_user_num">0</em>人预定</span>
                        <span class="ti" id="activity_time"><i class="detai-ico"></i>剩余时间：<span id="overTime"></span></span>
                        <span class="ti" id="prom_detail"></span>
                    </div>
                </div>
                <div class="shop-price-cou">
                    <div class="shop-price-le">
                        <ul>
                            <li class="jaj"><span id="goods_price_title">商城价：</span></li>
                            <li>
                                            <span class="bigpri_jj" id="goods_price"><em>￥</em>
                                                <!--<a href=""><em class="sale">（降价通知）</em></a>-->
                                            </span>
                            </li>
                        </ul>
                        <ul>
                            <li class="jaj"><span id="market_price_title">市场价：</span></li>
                            <li class="though-line"><span><em>￥</em><span id="market_price">3100.00</span></span></li>
                        </ul>
                        <ul id="activity_title_div" style="display: none">
                            <li class="jaj"><span id="activity_label"></span></li>
                            <li><span id="activity_title" style="color: #df3033;background: 0 0;border: 1px solid #df3033;padding: 2px 3px;"></span></li>
                        </ul>
                                            </div>
                    <div class="shop-cou-ri">
                        <div class="allcomm"><p>累计评价</p><p class="f_blue">0</p></div>
                        <div class="br1"></div>
                        <div class="allcomm"><p>累计销量</p><p class="f_blue">1</p></div>
                    </div>
                </div>
                <div class="standard p">
                    <!-- 收货地址，物流运费 -start-->
                    <ul class="list1">
                        <li class="jaj"><span>配&nbsp;&nbsp;送：</span></li>
                        <li class="summary-stock though-line">
                            <div class="dd shd_address">
                                <!--<div class="addrID"><div></div><b></b></div>-->
                                <div class="store-selector add_cj_p">
                                    <div class="text" style="width: 150px;"><div></div><b></b></div>
                                    <div onclick="$(this).parent().removeClass('hover')" class="close"></div>
                                </div>
                                <span id="dispatching_msg" style="display: none;">可发货</span>
                                <select id="dispatching_select" style="display: none;">
                                                                </select>
                            </div>
                        </li>
                    </ul>
                    <script src="/template/pc/rainbow/static/js/location.js"></script>
                    <!-- 收货地址，物流运费 -end-->
                </div>
                <div class="standard p">
                    <ul>
                        <li class="jaj"><span>服&nbsp;&nbsp;务：</span></li>
                        <li class="lawir"><span class="service">由<a >圣和醉美商城</a>发货并提供售后服务</span></li>
                    </ul>
                </div>
                
                <!-- 规格 start [[-->
                                <script>

                </script>
                <!-- 规格end ]]-->
                <div class="standard">
                    <ul class="p">
                        <li class="jaj"><span>数&nbsp;&nbsp;量：</span></li>
                        <li class="lawir">
                            <div class="minus-plus">
                                <a class="mins" href="javascript:void(0);" onclick="altergoodsnum(-1)">-</a>
                                <input class="buyNum" id="number" type="text" name="goods_num" value="1" onblur="altergoodsnum(0)" max=""/>
                                <a class="add" href="javascript:void(0);" onclick="altergoodsnum(1)">+</a>
                            </div>
                            <div class="sav_shop">库存：<span id="spec_store_count">99</span></div>
                        </li>
                    </ul>
                </div>
                <div class="standard p">
                    <input type="hidden" name="goods_id" value="144" />
                    <a id="join_cart_now" class="paybybill" href="javascript:;" onclick="AjaxAddCart(144,1,1);">立即购买</a>
                    <a id="join_cart" class="addcar" href="javascript:;" onclick="AjaxAddCart(144,1,0);"><i class="sk"></i>加入购物车</a>
                    <a id="no_join_cart_now" class="paybybill" style="display:none;background: #ebebeb;color: #999;cursor: not-allowed">立即购买</a>
                    <a id="no_join_cart" class="addcar" style="display:none;background: #ebebeb;color: #999;cursor: not-allowed"><i class="sk"></i>加入购物车</a>
                </div>
            </div>
        </form>
        <!--看了又看-s-->
       <!--  <div class="detail-ry p">
           <div class="type_more" >
               <div class="type-top">
                   <h2>看了又看<a class="update_h fr" href="javascript:;" onclick="replace_look();">换一换</a></h2>
               </div>
               <div id="see_and_see">
               </div>
           </div>
       </div> -->
        <!--看了又看-s-->
    </div>
</div>
<div class="detail-main p">
    <div class="w1224">
        <div class="deta-le-ma">
            <div class="type_more">
                <div class="type-top">
                    <h2>热搜推荐</h2>
                </div>
                <div class="type-bot">
                    <ul class="xg_typ">
                                                    <li><a href="/Home/Goods/search/q/%E9%85%92.html">酒</a></li>
                                                    <li><a href="/Home/Goods/search/q/%E5%B0%8F%E6%B4%9E%E4%BB%99.html">小洞仙</a></li>
                                            </ul>
                </div>
            </div>
            <div class="type_more ma-to-20">
                <div class="type-top">
                    <h2>推荐热卖</h2>
                </div>
                <div class="tjhot-shoplist type-bot">
                                            <div class="alone-shop">
                            <a href="/Home/Goods/goodsInfo/id/149.html"><img src="/public/upload/goods/thumb/149/goods_thumb_149_206_206.jpeg" style="display: inline;"></a>
                            <p class="line-two-hidd"><a href="/Home/Goods/goodsInfo/id/149.html">【商城推荐】吉尼斯官方推荐53°</a></p>
                            <p class="price-tag"><span class="li_xfo">￥</span><span>3000.00</span></p>
                            <!--<p class="store-alone"><a href="">恒要达食品专享店</a></p>-->
                        </div>
                                            <div class="alone-shop">
                            <a href="/Home/Goods/goodsInfo/id/148.html"><img src="/public/upload/goods/thumb/148/goods_thumb_148_206_206.jpeg" style="display: inline;"></a>
                            <p class="line-two-hidd"><a href="/Home/Goods/goodsInfo/id/148.html">【商城设置】洞藏53°吉尼斯官方认证</a></p>
                            <p class="price-tag"><span class="li_xfo">￥</span><span>3000.00</span></p>
                            <!--<p class="store-alone"><a href="">恒要达食品专享店</a></p>-->
                        </div>
                                            <div class="alone-shop">
                            <a href="/Home/Goods/goodsInfo/id/147.html"><img src="/public/upload/goods/thumb/147/goods_thumb_147_206_206.jpeg" style="display: inline;"></a>
                            <p class="line-two-hidd"><a href="/Home/Goods/goodsInfo/id/147.html">【商城推荐】小洞仙53度吉尼斯官方推荐</a></p>
                            <p class="price-tag"><span class="li_xfo">￥</span><span>3000.00</span></p>
                            <!--<p class="store-alone"><a href="">恒要达食品专享店</a></p>-->
                        </div>
                                            <div class="alone-shop">
                            <a href="/Home/Goods/goodsInfo/id/146.html"><img src="/public/upload/goods/thumb/146/goods_thumb_146_206_206.jpeg" style="display: inline;"></a>
                            <p class="line-two-hidd"><a href="/Home/Goods/goodsInfo/id/146.html">【商城推荐】小洞仙53°洞藏</a></p>
                            <p class="price-tag"><span class="li_xfo">￥</span><span>3000.00</span></p>
                            <!--<p class="store-alone"><a href="">恒要达食品专享店</a></p>-->
                        </div>
                                            <div class="alone-shop">
                            <a href="/Home/Goods/goodsInfo/id/145.html"><img src="/public/upload/goods/thumb/145/goods_thumb_145_206_206.jpeg" style="display: inline;"></a>
                            <p class="line-two-hidd"><a href="/Home/Goods/goodsInfo/id/145.html">【商城推荐】小洞仙53度</a></p>
                            <p class="price-tag"><span class="li_xfo">￥</span><span>3000.00</span></p>
                            <!--<p class="store-alone"><a href="">恒要达食品专享店</a></p>-->
                        </div>
                                            <div class="alone-shop">
                            <a href="/Home/Goods/goodsInfo/id/144.html"><img src="/public/upload/goods/thumb/144/goods_thumb_144_206_206.jpeg" style="display: inline;"></a>
                            <p class="line-two-hidd"><a href="/Home/Goods/goodsInfo/id/144.html">【商城推荐】吉尼斯官方认证53°洞藏</a></p>
                            <p class="price-tag"><span class="li_xfo">￥</span><span>3000.00</span></p>
                            <!--<p class="store-alone"><a href="">恒要达食品专享店</a></p>-->
                        </div>
                                    </div>
            </div>
        </div>
        <div class="deta-ri-ma">
            <div class="introduceshop">
                <div class="datail-nav-top">
                    <ul>
                        <li class="red"><a href="javascript:void(0);">商品介绍</a></li>
                        <li><a href="javascript:void(0);">规格及包装</a></li>
                        <li><a href="javascript:void(0);">评价<em>(0)</em></a></li>
                        <li><a href="javascript:void(0);">售后服务</a></li>
                    </ul>
                </div>
                <!--<div class="he-nav"></div>-->
                <div class="shop-describe shop-con-describe p">
                    <div class="deta-descri">
                        <p class="shopname_de"><span>商品名称：</span><span>【商城推荐】吉尼斯官方认证53°洞藏</span></p>
                        <div class="ma-d-uli p">
                            <ul>
                                <!--<li><span>品牌：</span><span></span></li>-->
                                <li><span>货号：</span><span>TP09999</span></li>
                                                            </ul>
                        </div>

                        <div class="moreparameter">
                            <!--
                            <a href="">跟多参数<em>>></em></a>
                            -->
                        </div>
                    </div>
                    <div class="detail-img-b">
                        <p><img src="/public/upload/temp/2017/09-19/30b48b68f34d0b8614e100d088816734.jpeg" title="30b48b68f34d0b8614e100d088816734.jpeg" alt="30b48b68f34d0b8614e100d088816734.jpeg"/></p>                    </div>
                </div>
                <div class="shop-describe shop-con-describe p" style="display: none;">
                    <div class="deta-descri">
                        <!--
                        <p class="shopname_de"><span>如果您发现商品信息不准确，<a class="de_cb" href="">欢迎纠错</a></span></p>
                        -->
                        <h2 class="shopname_de">属性</h2>
                                            </div>
                </div>
                <div class="shop-con-describe p" style="display: none;">
                    <div class="shop-describe p">
                        <div class="comm_stsh ma-to-20">
                            <div class="deta-descri">
                                <h2>商品评价</h2>
                            </div>
                        </div>
                        <div class="deta-descri p">
                            <ul class="tebj">
                                <li class="percen"><span>100%</span></li>
                                <li class="co-cen">
                                    <div class="comm_gooba">
                                        <div class="gg_c">
                                            <span class="hps">好评</span>
                                            <span class="hp">（100%）</span>
                                            <span class="zz_rg"><i style="width: 100%;"></i></span>
                                        </div>
                                        <div class="gg_c">
                                            <span class="hps">中评</span>
                                            <span class="hp">（0%）</span>
                                            <span class="zz_rg"><i style="width: 0%;"></i></span>
                                        </div>
                                        <div class="gg_c">
                                            <span class="hps">差评</span>
                                            <span class="hp">（0%）</span>
                                            <span class="zz_rg"><i style="width: 0%;"></i></span>
                                        </div>
                                    </div>
                                </li>
                                <li class="tjd-sum">
                                    <!--<p class="tjd">推荐点：</p>-->
                                    <div class="tjd-a">
                                        买家评论事项：购买后有什么问题, 满意, 或者不不满, 都可以在这里评论出来, 这里评论全部源于真实的评论.
                                    </div>
                                </li>
                                <li class="te-cen">
                                    <div class="nchx_com">
                                        <p>您可以对已购的商品进行评价</p>
                                        <a class="jfnuv" href="/Home/User/comment.html">发表评论</a>
                                        <!--<p class="xja"><span>详见</span><a class="de_cb" href="">积分规则</a></p>-->
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="deta-descri p">
                            <div class="cte-deta">
                                <ul id="fy-comment-list">
                                    <li data-t="1" class="red">
                                        <a href="javascript:void(0);" class="selected">全部评论（0）</a>
                                    </li>
                                    <li data-t="2">
                                        <a href="javascript:void(0);">好评（0）</a>
                                    </li>
                                    <li data-t="3">
                                        <a href="javascript:void(0);">中评（0）</a>
                                    </li>
                                    <li data-t="4">
                                        <a href="javascript:void(0);">差评（0）</a>
                                    </li>
                                    <li data-t="5">
                                        <a href="javascript:void(0);">有图（0）</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="line-co-sunall"  id="ajax_comment_return">
                        </div>
                    </div>
                </div>
                <div class="shop-con-describe p" style="display: none;">
                    <div class="shop-describe p">
                        <div class="comm_stsh ma-to-20">
                            <div class="deta-descri">
                                <h2>售后保障</h2>
                            </div>
                        </div>
                        <div class="deta-descri p">
                            <div class="securi-afr">
                                <ul>
                                    <li class="frhe"><i class="detai-ico msz1"></i></li>
                                    <li class="wnuzsuhe">
                                        <h2>卖家服务</h2>
                                        <p>全国联保一年</p>
                                    </li>
                                </ul>
                                <ul>
                                    <li class="frhe"><i class="detai-ico msz2"></i></li>
                                    <li class="wnuzsuhe">
                                        <h2>商城承诺</h2>
                                        <p>商城平台卖家销售并发货的商品，由平台卖家提供发票和相应的售后服务。请您放心购买！
                                            注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。
                                            只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>
                                    </li>
                                </ul>
                                <ul>
                                    <li class="frhe"><i class="detai-ico msz3"></i></li>
                                    <li class="wnuzsuhe">
                                        <h2>正品行货</h2>
                                        <p>商城向您保证所售商品均为正品行货，商城自营商品开具机打发票或电子发票。</p>
                                    </li>
                                </ul>
                                <ul>
                                    <li class="frhe"><i class="detai-ico msz4"></i></li>
                                    <li class="wnuzsuhe">
                                        <h2>全国联保</h2>
                                        <p>凭质保证书及商城发票，可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由联系保修，享受法定三包售后服务），与您亲临商场选购的商品享
                                            受相同的质量保证。商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！ </p>
                                    </li>
                                </ul>
                                <ul>
                                    <li class="frhe"><i class="detai-ico msz5"></i></li>
                                    <li class="wnuzsuhe">
                                        <h2>退货无忧</h2>
                                        <p>客户购买商城自营商品7日内（含7日，自客户收到商品之日起计算），在保证商品完好的前提下，可无理由退货。（部分商品除外，详情请见各商品细则）</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="comm_stsh ma-to-20">
                            <div class="deta-descri">
                                <h2>退款说明</h2>
                            </div>
                        </div>
                        <div class="deta-descri p">
                            <div class="fetbajc">
                                <p>1.若您购买的家电商品已经拆封过，需要退换货，需请联系原厂开具鉴定检测单</p>
                                <p>2.签收商品隔日起七日内提交退货申请，2-3天快递员与您联系安排取回商品</p>
                                <p>3.商品退回检验，且必须附上检测单</p>
                                <p>5.若退回商品有缺件、影响二次销售状况时，退款作业将暂时停止，飞牛网会依商品状况报价，后由客服人员与您联系说明并于订单内扣除费用后退回剩余款项，
                                    或您可以取消退货申请；若符合退货条件者将于商品取回后约1-2个工作日内完成退款</p>
                                <p>4.通过线上支付的订单办理退货，商品退回检验无误后，商城将提交退款申请, 实际款项会依照各银行作业时间返还至您原支付方式 若您采用货到付款，请于
                                    办理退货时提供退款账户，亦于商品退回检验无误后，将退款汇至您的银行账户中</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footer-s-->
<div class="footer p">
    <div class="mod_service_inner">
        <div class="w1224">
            <ul>
                <li>
                    <div class="mod_service_unit">
                        <h5 class="mod_service_duo">多</h5>
                        <p>品类齐全，轻松购物</p>
                    </div>
                </li>
                <li>
                    <div class="mod_service_unit">
                        <h5 class="mod_service_kuai">快</h5>
                        <p>多仓直发，极速配送</p>
                    </div>
                </li>
                <li>
                    <div class="mod_service_unit">
                        <h5 class="mod_service_hao">好</h5>
                        <p>正品行货，精致服务</p>
                    </div>
                </li>
                <li>
                    <div class="mod_service_unit">
                        <h5 class="mod_service_sheng">省</h5>
                        <p>天天低价，畅选无忧</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="w1224">
        <div class="footer-ewmcode">
		    <div class="foot-list-fl">
		        		            <ul>
		                <li class="foot-th">
		                    售后服务		                </li>
		                		            </ul>
		        		            <ul>
		                <li class="foot-th">
		                    新手上路 		                </li>
		                		            </ul>
		        		            <ul>
		                <li class="foot-th">
		                    关于我们		                </li>
		                		            </ul>
		        		            <ul>
		                <li class="foot-th">
		                    配送方式 		                </li>
		                		            </ul>
		        		            <ul>
		                <li class="foot-th">
		                    购物指南		                </li>
		                		            </ul>
		        		    </div>
		    <!-- <div class="QRcode-fr">
		        <ul>
		            <li class="foot-th">客户端</li>
		            <li><img src="/template/pc/rainbow/static/images/qrcode.png"/></li>
		        </ul>
		        <ul>
		            <li class="foot-th">微信</li>
		            <li><img src="/template/pc/rainbow/static/images/qrcode.png"/></li>
		        </ul>
		    </div> -->
		</div>
		<div class="mod_copyright p">
		    <div class="grid-top">
		        		       <!--  <a href="javascript:void (0);">客服热线:</a> -->
		    </div>
		    <p>Copyright © 2016-2025 圣和醉美商城 版权所有 保留一切权利 </p>
		
		   <!--  <p class="mod_copyright_auth">
		        <a class="mod_copyright_auth_ico mod_copyright_auth_ico_1" href="" target="_blank">经营性网站备案中心</a>
		        <a class="mod_copyright_auth_ico mod_copyright_auth_ico_2" href="" target="_blank">可信网站信用评估</a>
		        <a class="mod_copyright_auth_ico mod_copyright_auth_ico_3" href="" target="_blank">网络警察提醒你</a>
		        <a class="mod_copyright_auth_ico mod_copyright_auth_ico_4" href="" target="_blank">诚信网站</a>
		        <a class="mod_copyright_auth_ico mod_copyright_auth_ico_5" href="" target="_blank">中国互联网举报中心</a>
		        <a class="mod_copyright_auth_ico mod_copyright_auth_ico_6" href="" target="_blank">网络举报APP下载</a>
		    </p> -->
		</div>
    </div>
</div>
<div class="soubao-sidebar">
    <div class="soubao-sidebar-bg"></div>
    <div class="sidertabs tab-lis-1">
        <div class="sider-top-stra sider-midd-1">
            <div class="icon-tabe-chan">
                <a href="/Home/User/index.html">
                    <i class="share-side share-side1"></i>
                    <i class="share-side tab-icon-tip triangleshow"></i>
                </a>

                <div class="dl_login">
                    <div class="hinihdk">
                        <img src="/template/pc/rainbow/static/images/dl.png"/>

                        <p class="loginafter nologin"><span>你好，请先</span><a href="/Home/user/login.html">登录！</a></p>
                        <!--未登录-e--->
                        <!--登录后-s--->
                        <p class="loginafter islogin">
                            <span class="id_jq userinfo">陈xxxxxxx</span>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;</span><a href="/Home/user/logout.html" title="点击退出">退出！</a>
                        </p>
                        <!--未登录-s--->
                    </div>
                </div>
            </div>
            <div class="icon-tabe-chan shop-car">
                <a href="javascript:void(0);" onclick="ajax_side_cart_list()">
                    <div class="tab-cart-tip-warp-box">
                        <div class="tab-cart-tip-warp">
                            <i class="share-side share-side1"></i>
                            <i class="share-side tab-icon-tip"></i>
                            <span class="tab-cart-tip">购物车</span>
                            <span class="tab-cart-num J_cart_total_num" id="tab_cart_num">0</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="icon-tabe-chan massage">
                <a href="/Home/User/message_notice.html" target="_blank">
                    <i class="share-side share-side1"></i>
                    <!--<i class="share-side tab-icon-tip"></i>-->
                    <span class="tab-tip">消息</span>
                </a>
            </div>
        </div>
        <div class="sider-top-stra sider-midd-2">
            <div class="icon-tabe-chan mmm">
                <a href="/Home/User/goods_collect.html" target="_blank">
                    <i class="share-side share-side1"></i>
                    <!--<i class="share-side tab-icon-tip"></i>-->
                    <span class="tab-tip">收藏</span>
                </a>
            </div>
            <div class="icon-tabe-chan hostry">
                <a href="/Home/User/visit_log.html" target="_blank">
                    <i class="share-side share-side1"></i>
                    <!--<i class="share-side tab-icon-tip"></i>-->
                    <span class="tab-tip">足迹</span>
                </a>
            </div>
            <!--<div class="icon-tabe-chan sign">-->
                <!--<a href="" target="_blank">-->
                    <!--<i class="share-side share-side1"></i>-->
                    <!--&lt;!&ndash;<i class="share-side tab-icon-tip"></i>&ndash;&gt;-->
                    <!--<span class="tab-tip">签到</span>-->
                <!--</a>-->
            <!--</div>-->
        </div>
    </div>
    <div class="sidertabs tab-lis-2">
        <div class="icon-tabe-chan advice">
            <a title="点击这里给我发消息" href="javascript:void();" target="_blank">
                <i class="share-side share-side1"></i>
                <!--<i class="share-side tab-icon-tip"></i>-->
                <span class="tab-tip">在线咨询</span>
            </a>
        </div>
        <div class="icon-tabe-chan request">
            <a href="" target="_blank">
                <i class="share-side share-side1"></i>
                <!--<i class="share-side tab-icon-tip"></i>-->
                <span class="tab-tip">意见反馈</span>
            </a>
        </div>
        <div class="icon-tabe-chan qrcode">
            <a href="" target="_blank">
                <i class="share-side share-side1"></i>
                <i class="share-side tab-icon-tip triangleshow"></i>
                <span class="tab-tip qrewm">
                    <img src="/template/pc/rainbow/static/images/qrcode.png"/>
                    扫一扫
                </span>
            </a>
        </div>
        <div class="icon-tabe-chan comebacktop">
            <a href="" target="_blank">
                <i class="share-side share-side1"></i>
                <!--<i class="share-side tab-icon-tip"></i>-->
                <span class="tab-tip">返回顶部</span>
            </a>
        </div>
    </div>
    <div class="shop-car-sider">

    </div>
</div>
<script src="/template/pc/rainbow/static/js/common.js"></script>
<!--看了又看-s-->
<div style="display: none" id="look_see">
        <!--看了又看-s-->
</div>
<!--footer-e-->
<script src="/template/pc/rainbow/static/js/lazyload.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/template/pc/rainbow/static/js/headerfooter.js" ></script>
<script type="text/javascript">
    var commentType = 1;// 默认评论类型
    var spec_goods_price = [];//规格库存价格
    $(document).ready(function () {
        /*商品缩略图放大镜*/
        $(".jqzoom").jqueryzoom({
            xzoom: 500,
            yzoom: 500,
            offset: 1,
            position: "right",
            preload: 1,
            lens: 1
        });
        replace_look();
        initSpec();
        initGoodsPrice();
    });
    //有规格id的时候，解析规格id选中规格
    function initSpec(){
        var item_id = $("input[name='item_id']").val();
        $.each(spec_goods_price,function(i, o){
            if(o.item_id == item_id){
                var spec_key_arr = o.key.split("_");
                $.each(spec_key_arr,function(index,item){
                    var spec_radio = $("#goods_spec_"+item);
                    var goods_spec_a = $("#goods_spec_a_"+item);
                    spec_radio.attr("checked","checked");
                    goods_spec_a.addClass('red');
                })
            }
        })
        if(item_id > 0 && !$.isEmptyObject(spec_goods_price)){
            var item_arr = [];
            $.each(spec_goods_price,function(i, o){
                item_arr.push(o.item_id);
            })
            //规格id不存在商品里
            if($.inArray(parseInt(item_id), item_arr) < 0){
                initFirstSpec();
            }else{
                $.each(spec_goods_price,function(i, o){
                    if(o.item_id == item_id){
                        var spec_key_arr = o.key.split("_");
                        $.each(spec_key_arr,function(index,item){
                            var spec_radio = $("#goods_spec_"+item);
                            var goods_spec_a = $("#goods_spec_a_"+item);
                            spec_radio.attr("checked","checked");
                            goods_spec_a.addClass('red');
                        })
                    }
                })
            }
        }else{
            initFirstSpec();
        }
    }

    //默认让每种规格第一个选中
    function initFirstSpec(){
        $('.spec_goods_price_div').each(function (i, o) {
            var firstSpecRadio = $(this).find("input[type='radio']").eq(0);
            firstSpecRadio.attr('checked','checked').prop('checked','checked');
            firstSpecRadio.parent().find('a').eq(0).addClass('red');
        })
    }

    /**
     * 切换规格
     */
    function select_filter(obj)
    {
        $(obj).addClass('red').siblings('a').removeClass('red');
        $(obj).siblings('input').removeAttr('checked');
        $(obj).prev('input').attr('checked','checked').prop('checked','checked');
        // 更新商品价格
        initGoodsPrice();
    }

    //看了又看切换
    var tmpindex = 0;
    var look_see_length = $('#look_see').children().length;
    function replace_look(){
        var listr='';
        if(tmpindex*2>=look_see_length) tmpindex = 0;
        $('#look_see').children().each(function(i,o){
            if((i>=tmpindex*2) && (i<(tmpindex+1)*2)){
                listr += '<div class="tjhot-shoplist type-bot">'+$(o).html()+'</div>';
            }
        });
        tmpindex++;
        $('#see_and_see').empty().append(listr);
    }
    //缩略图切换
    $('.small-pic-li').each(function (i, o) {
        var lilength = $('.small-pic-li').length;
        $(o).hover(function () {
            $(o).siblings().removeClass('active');
            $(o).addClass('active');
            $('#zoomimg').attr('src', $(o).find('img').attr('data-img'));
            $('#zoomimg').attr('jqimg', $(o).find('img').attr('data-big'));

            $('.next-btn').removeClass('disabled');
            if (i == 0) {
                $('.next-left').addClass('disabled');
            }
            if (i + 1 == lilength) {
                $('.next-right').addClass('disabled');
            }
        });
    })

    //前一张缩略图
    $('.next-left').click(function () {
        var newselect = $('.small-pic>.active').prev();
        $('.small-pic>.active').removeClass('active');
        $(newselect).addClass('active');
        $('#zoomimg').attr('src', $(newselect).find('img').attr('data-img'));
        $('#zoomimg').attr('jqimg', $(newselect).find('img').attr('data-big'));
        var index = $('.small-pic>li').index(newselect);
        if (index == 0) {
            $('.next-left').addClass('disabled');
        }
        $('.next-right').removeClass('disabled');
    })

    //后前一张缩略图
    $('.next-right').click(function () {
        var newselect = $('.small-pic>.active').next();
        $('.small-pic>.active').removeClass('active');
        $(newselect).addClass('active');
        $('#zoomimg').attr('src', $(newselect).find('img').attr('data-img'));
        $('#zoomimg').attr('jqimg', $(newselect).find('img').attr('data-big'));
        var index = $('.small-pic>li').index(newselect);
        if (index + 1 == $('.small-pic>li').length) {
            $('.next-right').addClass('disabled');
        }
        $('.next-left').removeClass('disabled');
    })
    $(function(){
        $("#area").click(function (e) {
            SelCity(this,e);
        });
    })

    $(function() {
        ajaxComment(1,1);
        // 好评差评 切换
        $('.cte-deta ul li').click(function(){
            $(this).addClass('red').siblings().removeClass('red');
            commentType = $(this).data('t');// 评价类型   好评 中评  差评
            ajaxComment(commentType,1);
        })
    });
    $(function(){
        $('.datail-nav-top ul li').click(function(){
            $(this).addClass('red').siblings().removeClass('red');
            var er = $('.datail-nav-top ul li').index(this);
            $('.shop-con-describe').eq(er).show().siblings('.shop-con-describe').hide();
        })
    })

    /**
     * 加减数量
     * n 点击一次要改变多少
     * maxnum 允许的最大数量(库存)
     * number ，input的id
     */
    function altergoodsnum(n){
        var num = parseInt($('#number').val());
        var maxnum = parseInt($('#number').attr('max'));
        num += n;
        num <= 0 ? num = 1 :  num;
        if(num >= maxnum){
            $(this).addClass('no-mins');
            num = maxnum;
        }
        $('#store_count').text(maxnum-num); //更新库存数量
        $('#number').val(num)
    }

    //初始化商品价格库存
    function initGoodsPrice() {
        var goods_id = $('input[name="goods_id"]').val();
        if (!$.isEmptyObject(spec_goods_price)) {
            var goods_spec_arr = [];
            $("input[name^='goods_spec']").each(function () {
                if($(this).attr('checked') == 'checked'){
                    goods_spec_arr.push($(this).val());
                }
            });
            var spec_key = goods_spec_arr.sort(sortNumber).join('_');  //排序后组合成 key
            var item_id = spec_goods_price[spec_key]['item_id'];
            $('input[name=item_id]').val(item_id);
        }
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {goods_id: goods_id, item_id: item_id},
            url: "/Home/Goods/activity.html",
            success: function (data) {
                if (data.status == 1) {
                    $('input[name="goods_prom_type"]').attr('value', data.result.goods.prom_type);//商品活动类型
                    $('input[name="shop_price"]').attr('value', data.result.goods.shop_price);//商品价格
                    $('input[name="store_count"]').attr('value', data.result.goods.store_count);//商品库存
                    $('input[name="market_price"]').attr('value', data.result.goods.market_price);//商品原价
                    $('input[name="start_time"]').attr('value', data.result.goods.start_time);//活动开始时间
                    $('input[name="end_time"]').attr('value', data.result.goods.end_time);//活动结束时间
                    $('input[name="activity_title"]').attr('value', data.result.goods.activity_title);//活动标题
                    $('input[name="prom_detail"]').attr('value', data.result.goods.prom_detail);//促销详情
                    $('input[name="activity_is_on"]').attr('value', data.result.goods.activity_is_on);//活动是否正在进行中
                    goods_activity_theme();
                }
            }
        });
    }

    //商品价格库存显示
    function goods_activity_theme(){
        var goods_prom_type = $('input[name="goods_prom_type"]').attr('value');
        var activity_is_on = $('input[name="activity_is_on"]').attr('value');
        if(activity_is_on == 0){
            setNormalGoodsPrice();
        }else{
            if(goods_prom_type == 0){
                //普通商品
                setNormalGoodsPrice();
            }else if(goods_prom_type == 1){
                //抢购
                setFlashSaleGoodsPrice();
            }else if(goods_prom_type == 2){
                //团购
                setGroupByGoodsPrice();
            }else if(goods_prom_type == 3){
                //优惠促销
                setPromGoodsPrice();
            }else{

            }
        }
        var buy_num  = $('#number').val();//购买数
        var store = $('#spec_store_count').html();//实际库存数量
        if(store<= 0){
            joinCart(false);
        }else{
            joinCart(true);
        }
        if(store<=0){
            $('.buyNum').val(store);
        }else{
            $('.buyNum').val(1);
        }
    }

    //普通商品库存和价格
    function setNormalGoodsPrice(){
        var goods_price =  $("input[name='shop_price']").attr('value');// 商品本店价
        var market_price =  $("input[name='market_price']").attr('value');// 商品市场价
        var store_count = $("input[name='store_count']").attr('value');// 商品库存
        // 如果有属性选择项
        if(!$.isEmptyObject(spec_goods_price))
        {
            var goods_spec_arr = [];
            $("input[name^='goods_spec']").each(function () {
                if($(this).attr('checked') == 'checked'){
                    goods_spec_arr.push($(this).val());
                }
            });
            var spec_key = goods_spec_arr.sort(sortNumber).join('_');  //排序后组合成 key
            goods_price = spec_goods_price[spec_key]['price']; // 找到对应规格的价格
            store_count = spec_goods_price[spec_key]['store_count']; // 找到对应规格的库存
        }
        $('#market_price_title').empty().html('市场价：');
        $('#market_price').empty().html(market_price);
        $("#goods_price").html("<em>￥</em>"+goods_price); //变动价格显示
        $('#spec_store_count').html(store_count);
        $('.presale-time').hide();
        $('#number').attr('max',store_count);
    }

    //秒杀商品库存和价格
    function setFlashSaleGoodsPrice(){
        var flash_sale_price = $("input[name='shop_price']").attr('value');
        var flash_sale_count = $("input[name='store_count']").attr('value');
        var market_price = $("input[name='market_price']").attr('value');
        var start_time = $("input[name='start_time']").attr('value');
        var end_time = $("input[name='end_time']").attr('value');
        var activity_title = $("input[name='activity_title']").attr('value');
        $("#goods_price").html("<em>￥</em>"+flash_sale_price); //变动价格显示
        $('#spec_store_count').html(flash_sale_count);
        $('#goods_price_title').html('抢购价：');
        $('#market_price_title').empty().html('原&nbsp;&nbsp;价：');
        $('#activity_label').empty().html('抢&nbsp;&nbsp;购：');
        $('#activity_title').empty().html(activity_title);
        $('#activity_title_div').show();
        $('#market_price').empty().html(market_price);
        $('.presale-time').show();
        $('#prom_detail').hide();
        $('#number').attr('max',flash_sale_count);
        setInterval(activityTime, 1000);
    }

    //团购商品库存和价格
    function setGroupByGoodsPrice(){
        var group_by_price = $("input[name='shop_price']").attr('value');
        var group_by_count = $("input[name='store_count']").attr('value');
        var market_price = $("input[name='market_price']").attr('value');
        var start_time = $("input[name='start_time']").attr('value');
        var end_time = $("input[name='end_time']").attr('value');
        var activity_title = $("input[name='activity_title']").attr('value');
        $("#goods_price").empty().html("<em>￥</em>"+group_by_price); //变动价格显示
        $('#spec_store_count').empty().html(group_by_count);
        $('#activity_type').empty().html('团购');
        $('#goods_price_title').empty().html('团购价：');
        $('#market_price_title').empty().html('原&nbsp;&nbsp;价：');
        $('#activity_label').empty().html('团&nbsp;&nbsp;购：');
        $('#activity_title').empty().html(activity_title);
        $('#activity_title_div').show();
        $('#market_price').empty().html(market_price);
        $('.presale-time').show();
        $('#prom_detail').hide();
        $('#number').attr('max',group_by_count);
        setInterval(activityTime, 1000);
    }

    //促销商品库存和价格
    function setPromGoodsPrice(){
        var prom_goods_price = $("input[name='shop_price']").attr('value');
        var prom_goods_count = $("input[name='store_count']").attr('value');
        var market_price = $("input[name='market_price']").attr('value');
        var start_time = $("input[name='start_time']").attr('value');
        var end_time = $("input[name='end_time']").attr('value');
        var activity_title = $("input[name='activity_title']").attr('value');
        var prom_detail = $("input[name='prom_detail']").attr('value');
        $("#goods_price").empty().html("<em>￥</em>"+prom_goods_price); //变动价格显示
        $('#spec_store_count').empty().html(prom_goods_count);
        $('#activity_type').empty().html('促销');
        $('.presale-time').show();
        $('#prom_detail').empty().html(prom_detail).show();
        $('#activity_time').hide();
        $('#goods_price_title').empty().html('促销价：');
        $('#market_price_title').empty().html('原&nbsp;&nbsp;价：');
        $('#activity_label').empty().html('促&nbsp;&nbsp;销：');
        $('#activity_title').empty().html(activity_title);
        $('#activity_title_div').show();
        $('#market_price').empty().html(market_price);
        $('#number').attr('max',prom_goods_count);
    }

    // 倒计时
    function activityTime() {
        var end_time = parseInt($("input[name='end_time']").attr('value'));
        var timestamp = Date.parse(new Date());
        var now = timestamp/1000;
        var end_time_date = formatDate(end_time*1000);
        var text = GetRTime(end_time_date);
        //活动时间到了就刷新页面重新载入
        if(now > end_time){
            layer.msg('该商品活动已结束',function(){
                location.reload();
            });
        }
        $("#overTime").text(text);
    }
    //时间戳转换
    function add0(m){return m<10?'0'+m:m }
    function  formatDate(now)   {
        var time = new Date(now);
        var y = time.getFullYear();
        var m = time.getMonth()+1;
        var d = time.getDate();
        var h = time.getHours();
        var mm = time.getMinutes();
        var s = time.getSeconds();
        return y+'/'+add0(m)+'/'+add0(d)+' '+add0(h)+':'+add0(mm)+':'+add0(s);
    }

    /***用作 sort 排序用*/
    function sortNumber(a,b)
    {
        return a - b;
    }

    /***收藏商品**/
    $('#collectLink').click(function(){
        if(getCookie('user_id') == ''){
            layer.msg('请先登录！', {icon: 1});
        }else{
            $.ajax({
                type:'post',
                dataType:'json',
                data:{goods_id:$('input[name="goods_id"]').val()},
                url:"/Home/Goods/collect_goods.html",
                success:function(res){
                    if(res.status == 1){
                        layer.msg('成功添加至收藏夹', {icon: 1});
                    }else{
                        layer.msg(res.msg, {icon: 3});
                    }
                }
            });
        }
    });

    /***用ajax分页显示评论**/
    function ajaxComment(commentType,page){
        $.ajax({
            type : "GET",
            url:"/index.php?m=Home&c=goods&a=ajaxComment&goods_id=144&commentType="+commentType+"&p="+page,//+tab,
            success: function(data){
                $("#ajax_comment_return").html('').append(data);
            }
        });
    }
    /**
     * 切换图片
     */
    function switch_zooming(img)
    {
        if(img != ''){
            $('#zoomimg').attr('jqimg', img).attr('src', img);
        }
    }
</script>
</body>
</html>";
?>