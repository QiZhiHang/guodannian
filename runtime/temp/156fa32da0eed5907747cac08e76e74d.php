<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:44:"./template/mobile/new2/user\withdrawals.html";i:1505386666;s:41:"./template/mobile/new2/public\header.html";i:1505386666;s:45:"./template/mobile/new2/public\header_nav.html";i:1499420874;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>申请提现--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <a href="javascript:history.back(-1)"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>申请提现</span>
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
		<div class="loginsingup-input ma-to-20">
			<form action="?" method="post" onsubmit="return checkSubmit()">
				<div class="content30">

					<input type="hidden" name="withdrawals_type" value="3">


						<input type="hidden" name="account_bank" id="account_bank" value="<?php echo $user_info['bank_num']; ?>"  placeholder="银行卡号" onKeyUp="this.value=this.value.replace(/[^\d]/g,'')">


						<input type="hidden" name="account_name" id="account_name" value="<?php echo $user_info['user_bank_name']; ?>"  placeholder="持卡人姓名">


						<input type="hidden" name="bank_name" id="bank_name" value="<?php echo C('USER_BANK')[$user_info['user_bank']]; ?>" placeholder="如：工商银行">

                    <div class="lsu">
                        <span>提现金额：</span>
                        <input type="text" name="money" id="money" value="<?php

                        		if(($user_info['group_money'] % 100) == 0){
                        			echo $user_info['group_money'];
                        		}else{
                        			echo $user_info['group_money'] - ($user_info['group_money'] % 100);
                        		}


                        ?>" usermoney="" placeholder="" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')">
                    </div>
                    <div class="lsu test">
                        <span>验证码：</span>
                        <input type="text" name="verify_code" id="verify_code" value="" placeholder="请输入验证码">
                        <img  id="verify_code_img" src="<?php echo U('User/verify',array('type'=>'withdrawals')); ?>" onClick="verify()" style=""/>
                    </div>
					<div class="lsu">
						<span>二级密码：</span>
						<input type="password" name="paypwd" id="paypwd" value="" placeholder="请输入您的二级密码" >
					</div>
					<div class="lsu submit">
						<input type="submit" name="" id="" value="提交申请">
					</div>
				</div>
			</form>
		</div>

<script type="text/javascript" charset="utf-8">
    // 验证码切换
    function verify(){
        $('#verify_code_img').attr('src','/index.php?m=Mobile&c=User&a=verify&type=withdrawals&r='+Math.random());
    }

    /**
     * 提交表单
     * */
    function checkSubmit(){
        var bank_name = $.trim($('#bank_name').val());
        var account_bank = $.trim($('#account_bank').val());
        var account_name = $.trim($('#account_name').val());
        var money = parseFloat($.trim($('#money').val()));
        var verify_code = $.trim($('#verify_code').val());
        var paypwd = $.trim($('#paypwd').val());
        //验证码
        if(verify_code == '' ){
            showErrorMsg('验证码不能空')
            return false;
        }
        if(bank_name == '' || account_bank == '' || account_name=='' || money == ''){
            showErrorMsg("所有信息为必填")
            return false;
        }

    }
</script>
	</body>
</html>
