<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:38:"./template/mobile/new2/user\index.html";i:1505444874;s:41:"./template/mobile/new2/public\header.html";i:1505386666;s:45:"./template/mobile/new2/public\footer_nav.html";i:1499420874;s:43:"./template/mobile/new2/public\wx_share.html";i:1499420874;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>个人中心--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
<body class="g4">

    <div class="myhearder">
        <div class="person">
            <!--<a href="">-->
                <div class="fl personicon">
                    <div class="personicon">
                        <img src="<?php echo (isset($user[head_pic]) && ($user[head_pic] !== '')?$user[head_pic]:"__STATIC__/images/user68.jpg"); ?>"/>
                    </div>
                </div>
                <div class="fl lors">
                    <span><?php echo $user['nickname']; ?></span>
                    <?php if($first_nickname != ''): ?>
                        <br />
                        <span style="font-size:20px">由(<?php echo $first_nickname; ?>)推荐</span>
                    <?php endif; ?>
                </div>
            <!--</a>-->
        </div>
        <div class="set">
            <!--设置-->
            <a class="setting" href="<?php echo U('Mobile/User/userinfo'); ?>"><i></i></a>
            <!--&lt;!&ndash;我的留言&ndash;&gt;-->
            <!--<a class="massage" href="<?php echo U('User/message_notice'); ?>"><i></i></a>-->
        </div>
        <div class="scgz">
            <ul>
                <li>
                    <a href="<?php echo U('Mobile/User/collect_list'); ?>">
                        <h2><?php echo $user['collect_count']; ?></h2>
                        <p>我的收藏</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('Mobile/User/message_notice'); ?>">
                        <h2><?php echo $user_message_count; ?></h2>
                        <p>消息通知</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="floor my p">
        <div class="content">
            <!--订单管理模块-s-->
            <div class="floor myorder ma-to-20 p">
                <div class="content30">
                    <div class="order">
                        <div class="fl">
                            <img src="__STATIC__/images/mlist.png"/>
                            <span>我的订单</span>
                        </div>
                        <div class="fr">
                            <a href="<?php echo U('Mobile/User/order_list'); ?>">
                                <span>全部订单</span>
                                <i class="Mright"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="floor">
                <ul>
                    <li>
                        <a href="<?php echo U('/Mobile/User/order_list',array('type'=>'WAITPAY')); ?>">
                            <span><?php echo $user['waitPay']; ?></span>
                            <img src="__STATIC__/images/q1.png" alt="" />
                            <p>待付款</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('/Mobile/User/wait_receive',array('type'=>'WAITRECEIVE')); ?>">
                            <span><?php echo $user['waitReceive']; ?></span>
                            <img src="__STATIC__/images/q2.png" alt="" />
                            <p>待收货</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Mobile/User/comment',array('status'=>0)); ?>">
                            <span><?php echo $user['uncomment_count']; ?></span>
                            <img src="__STATIC__/images/q3.png" alt="" />
                            <p>待评价</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Mobile/User/return_goods_list',array('type'=>1)); ?>">
                            <span><?php echo $user['return_count']; ?></span>
                            <img src="__STATIC__/images/q4.png" alt="" />
                            <p>退款/退货</p>
                        </a>
                    </li>
                </ul>
            </div>
            <!--订单管理模块-e-->

            <!--资金管理-s-->
            <div class="floor myorder ma-to-20 p">
                <div class="content30">
                    <div class="order">
                        <div class="fl">
                            <img src="__STATIC__/images/mwallet.png"/>
                            <span>我的钱包</span>
                        </div>
                        <div class="fr">
                            <!--<a href="bankrollmm.html">-->
                            <a href="<?php echo U('Mobile/User/account'); ?>">
                                <span>资金管理</span>
                                <i class="Mright"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="floor w3">
                <ul>
                    <li>
                        <a href="#">
                            <h2><?php echo $user['user_money']; ?></h2>
                            <p>购物券</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Mobile/User/account'); ?>">
                            <h2><?php echo $user['group_money']; ?></h2>
                            <p>奖励券</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <h2><?php echo $user['baodanbi']; ?></h2>
                            <p>报单券</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <h2><?php echo $user['jihuobi']; ?></h2>
                            <p>激活券</p>
                        </a>
                    </li>
                </ul>
            </div>
            <!--资金管理-e-->

            <div class="floor list7 ma-to-20">
                <?php if($tpshop_config['distribut_switch'] == 1): ?>
                    <div class="myorder p">
                        <div class="content30">
                            <a href="<?php echo U('Distribut/index'); ?>">
                                <div class="order">
                                    <div class="fl">
                                        <img src="__STATIC__/images/w1.png"/>
                                        <span>我的分销</span>
                                    </div>
                                    <div class="fr">
                                        <i class="Mright"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/User/comment',array('status'=>1)); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w2.png"/>
                                    <span>我的评价</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/Activity/coupon_list'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w7.png"/>
                                    <span>领券中心</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/User/visit_log'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w3.png"/>
                                    <span>浏览历史</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/User/address_list'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w8.png"/>
                                    <span>地址管理</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!--
                <div class="myorder p">
                    <div class="content30">
                        <a href="">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w3.png"/>
                                    <span>我的预售</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w4.png"/>
                                    <span>我的拼团</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
               <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/Goods/integralMall'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w5.png"/>
                                    <span>积分商城</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w6.png"/>
                                    <span>帮助中心</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="myorder p">
                    <div class="content30">
                        <a href="">
                            <div class="order">
                                <div class="fl">
                                    <img src="__STATIC__/images/w7.png"/>
                                    <span>意见反馈</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>

    <!--底部导航-start-->
    <div class="foohi">
    <div class="footer">
        <ul>
            <li>
                <a <?php if(CONTROLLER_NAME == 'Index'): ?>class="yello" <?php endif; ?>  href="<?php echo U('Index/index'); ?>">
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
                <a href="<?php echo U('Cart/cart'); ?>">
                    <div class="icon">
                        <i class="icon-gouwuche iconfont"></i>
                        <p>购物车</p>
                    </div>
                </a>
            </li>
            <li>
                <a <?php if(CONTROLLER_NAME == 'User'): ?>class="yello" <?php endif; ?> href="<?php echo U('User/index'); ?>">
                    <div class="icon">
                        <i class="icon-wode iconfont"></i>
                        <p>我的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	  var cart_cn = getCookie('cn');
	  if(cart_cn == ''){
		$.ajax({
			type : "GET",
			url:"/index.php?m=Home&c=Cart&a=header_cart_list",//+tab,
			success: function(data){								 
				cart_cn = getCookie('cn');
				$('#cart_quantity').html(cart_cn);						
			}
		});	
	  }
	  $('#cart_quantity').html(cart_cn);
});
</script>
<!-- 微信浏览器 调用微信 分享js-->
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="__PUBLIC__/js/global.js"></script>
<script type="text/javascript">
<?php if(ACTION_NAME == 'goodsInfo'): ?>
   var ShareLink = "http://<?php echo $_SERVER[HTTP_HOST]; ?>/index.php?m=Mobile&c=Goods&a=goodsInfo&id=<?php echo $goods[goods_id]; ?>"; //默认分享链接
   var ShareImgUrl = "http://<?php echo $_SERVER[HTTP_HOST]; ?><?php echo goods_thum_images($goods[goods_id],400,400); ?>"; // 分享图标
<?php else: ?>
   var ShareLink = "http://<?php echo $_SERVER[HTTP_HOST]; ?>/index.php?m=Mobile&c=Index&a=index"; //默认分享链接
   var ShareImgUrl = "http://<?php echo $_SERVER[HTTP_HOST]; ?><?php echo $tpshop_config['shop_info_store_logo']; ?>"; //分享图标
<?php endif; ?>

var is_distribut = getCookie('is_distribut'); // 是否分销代理
var user_id = getCookie('user_id'); // 当前用户id
//alert(is_distribut+'=='+user_id);
// 如果已经登录了, 并且是分销商
if(parseInt(is_distribut) == 1 && parseInt(user_id) > 0)
{									
	ShareLink = ShareLink + "&first_leader="+user_id;									
}

$(function() {
	if(isWeiXin() && parseInt(user_id)>0){
		$.ajax({
			type : "POST",
			url:"/index.php?m=Mobile&c=Index&a=ajaxGetWxConfig&t="+Math.random(),
			data:{'askUrl':encodeURIComponent(location.href.split('#')[0])},		
			dataType:'JSON',
			success: function(res)
			{
				//微信配置
				wx.config({
				    debug: false, 
				    appId: res.appId,
				    timestamp: res.timestamp, 
				    nonceStr: res.nonceStr, 
				    signature: res.signature,
				    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone','hideOptionMenu'] // 功能列表，我们要使用JS-SDK的什么功能
				});
			},
			error:function(){
				return false;
			}
		}); 

		// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在 页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready 函数中。
		wx.ready(function(){
		    // 获取"分享到朋友圈"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareTimeline({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
		    });

		    // 获取"分享给朋友"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareAppMessage({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        desc: "<?php echo $tpshop_config['shop_info_store_desc']; ?>", // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
		    });
			// 分享到QQ
			wx.onMenuShareQQ({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        desc: "<?php echo $tpshop_config['shop_info_store_desc']; ?>", // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});	
			// 分享到QQ空间
			wx.onMenuShareQZone({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        desc: "<?php echo $tpshop_config['shop_info_store_desc']; ?>", // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});

		   <?php if(CONTROLLER_NAME == 'User'): ?> 
				wx.hideOptionMenu();  // 用户中心 隐藏微信菜单
		   <?php endif; ?>	
		});
	}
});

function isWeiXin(){
    var ua = window.navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
        return true;
    }else{
        return false;
    }
}
</script>
<!--微信关注提醒 start-->
<?php if(\think\Session::get('subscribe') == 0): endif; ?>
<button class="guide" style="display:none;" onclick="follow_wx()">关注公众号</button>
<style type="text/css">
.guide{width:1rem;height:4rem;text-align: center;border-radius: 0.2rem ;font-size:0.5rem;padding:0.2rem 0;border:1px solid #adadab;color:#000000;background-color: #fff;position: fixed;right: 0.1rem;bottom: 10rem;}
#cover{display:none;position:absolute;left:0;top:0;z-index:18888;background-color:#000000;opacity:0.7;}
#guide{display:none;position:absolute;top:0.1rem;z-index:19999;}
#guide img{width: 70%;height: auto;display: block;margin: 0 auto;margin-top: 0.2rem;}
</style>
<script type="text/javascript">
  //关注微信公众号二维码	 
function follow_wx()
{
	layer.open({
		type : 1,  
		title: '关注公众号',
		content: '<img src="<?php echo $wx_qr; ?>" width="100%">',
		style: ''
	});
}
  
$(function(){
	if(isWeiXin()){
		var subscribe = getCookie('subscribe'); // 是否已经关注了微信公众号		
		if(subscribe == 0)
			$('.guide').show();
	}else{
		$('.guide').hide();
	}
})
 
</script> 

<!--微信关注提醒  end-->
<!-- 微信浏览器 调用微信 分享js  end-->
    <!--底部导航-end-->
    <script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
