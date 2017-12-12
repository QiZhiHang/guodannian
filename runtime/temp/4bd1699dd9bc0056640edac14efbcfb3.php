<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:41:"./template/mobile/new2/user\recharge.html";i:1505214254;s:41:"./template/mobile/new2/public\header.html";i:1505386666;s:45:"./template/mobile/new2/public\header_nav.html";i:1499420874;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>充值--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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

<div class="classreturn loginsignup ">
    <div class="content">
        <div class="ds-in-bl return">
            <a href="javascript:history.back(-1)"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>充值</span>
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
<div class="loginsingup-input mobil_topup">

    <form method="post"  id="recharge_form" onsubmit="return recharge_submit()" action="">
        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
        <div class="bawhite">
            <div class="content30">
                <div class="lsu">
                    <span>您的当前余额：<span class="red"><?php echo $user['user_money']; ?></span>元</span>
                    <!--<input type="text" name="account" id="add_money" value=""  placeholder="0.00">-->
                </div>
            </div>
        </div>
        <div class="bawhite">
            <div class="content30">
                <div class="lsu">
                    <span>充值金额：</span>
                    <input type="text" name="account" id="add_money" value=""  placeholder="0.00">
                </div>
            </div>
        </div>
        <!--<div class="customer-messa">-->
            <!--<div class="maleri30">-->
                <!--<p>会员备注（50字）</p>-->
                <!--<textarea class="tapassa" onkeyup="checkfilltextarea('.tapassa','50')" name="" rows="" cols="" placeholder="选填"></textarea>-->
                <!--<span class="xianzd"><em id="zero">50</em>/50</span>-->
            <!--</div>-->
        <!--</div>-->
        <div class="myorder usedeb p">
            <div class="content30">
                <a class="takeoutps" href="javascript:void(0);">
                    <div class="order p">
                        <div class="fl">
                            <span>充值方式：</span>
                        </div>
                        <span id="codename" style="font-size:0.5rem; color:#89898A;">请选择支付方式</span>
                        <div class="fr">
                            <i class="Mright"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="content30">
            <div class="lsu submit">
                <input type="submit" onclick="recharge_submit()" value="提交申请">
            </div>
        </div>
        <!--充值方式-s-->
        <div class="chooseebitcard" style="display: none;">
            <div class="maleri30">
                <div class="choose-titr">
                    <span>选择充值方式</span>
                    <i class="gb-close"></i>
                </div>
                <?php if(is_array($paymentList) || $paymentList instanceof \think\Collection || $paymentList instanceof \think\Paginator): if( count($paymentList)==0 ) : echo "" ;else: foreach($paymentList as $k=>$v): ?>
                <div class="card">
                        <leable>
                        <div class="card-list">
                            <input type="radio" style="display: none;" value="pay_code=<?php echo $v['code']; ?>" name="pay_radio" <?php if($k == 'alipayMobile'): ?>checked<?php endif; ?> >
                            <div class="radio fl">
                                <span name="<?php echo $v[name]; ?>"  class="che  <?php if($k == 'alipayMobile'): ?>check_t<?php endif; ?>" >
                                    <i></i>
                                </span>
                            </div>
                            <p class="fl">&nbsp;&nbsp;<span><img src="/plugins/<?php echo $v['type']; ?>/<?php echo $v['code']; ?>/<?php echo $v['icon']; ?>" width="110" height="40" /></span></p>
                        </div>
                        </leable>
                    </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <p class="teuse"><span class="red"></span><span>确定</span></p>
            </div>
        </div>
        <!--充值方式-e-->
    </form>
</div>
<div class="mask-filter-div" style="display: none;"></div>
<div id="pay_codeweixin" style="display: none;">
    请扫描图中的微信二维码
</div>
<div id="pay_codealipayMobile" style="display: none;">
    请扫描图中的支付宝二维码

</div>
<div id="pay_codeunionpay" style="display: none;">
    请扫描图中的银行二维码
</div>
<script type="text/javascript">
    $(function(){
        $('.usedeb').click(function(){
            $('.chooseebitcard').show();
            $('.submit').hide();
        })
        $('.gb-close').click(function(){
            $('.chooseebitcard').hide();
        })
        $('.teuse').click(function(){
            $.each($('input:radio:checked'),function(){

                //alert($(this).val())
                if($(this).val() == 'pay_code=weixin'){

                    $("#pay_codeweixin").show();
                    $("#pay_codeunionpay").hide();
                    $("#pay_codealipayMobile").hide();
                }else if($(this).val() == 'pay_code=alipayMobile'){

                    //$("#pay_codealipayMobile").show();

                    $("#pay_codeweixin").hide();
                    $("#pay_codeunionpay").hide();
                    $("#pay_codealipayMobile").show();
                }else if($(this).val() == 'pay_code=unionpay'){

                    $("#pay_codeweixin").hide();
                    $("#pay_codeunionpay").show();
                    $("#pay_codealipayMobile").hide();
                }
            });
            $('.chooseebitcard').hide();
            $('.submit').show();
            $('#codename').text($('.check_t').attr('name'));
        })
    })
    $(function(){
        $('.card-list').click(function(){
            var _this = $(this);
            _this.find('input').prop('checked',true).parents('.card').siblings().find('input').prop('checked',false);
            _this.find('.che').toggleClass('check_t').parents('.card').siblings().find('.che').removeClass('check_t');
        })
    })

    //提交表单
    function recharge_submit(){
        var account = $('#add_money').val();
        if(isNaN(account) || parseInt(account)<=0 || account==''){
            layer.open({content:'请输入正确的充值金额',time:2});
            return false;
        }
        $('#recharge_form').submit();
    }
</script>
</body>
</html>
