<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:37:"./template/pc/rainbow/user\login.html";i:1505816154;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登录-<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/tpshop.css" />
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/myaccount.css" />
    <script src="__STATIC__/js/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/static/js/layer/layer.js" type="text/javascript"></script>
</head>
<body>
<div class="loginsum_cm">
    <div class="w1224 p">
        <div class="login-dl">
            <a href="/index.php" title="首页">
                <img src="<?php echo $tpshop_config['shop_info_store_logo']; ?>"/>
            </a>
        </div>
        <div class="login-welcome">
            <span>欢迎登录</span>
        </div>
    </div>
</div>
<div class="loginsum_main" style="background: #bf1919;">
    <div class="w1224 p">
        <div class="advertisement">
            <?php $pid =9;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1507510800 and end_time > 1507510800 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
foreach($result as $k=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
                <a href="<?php echo $v[ad_link]; ?>">
                    <img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>"/>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="login_form">
            <div class="lo_intext">
                <div class="layel1">
                    <span>账户登录</span>
                </div>
                <form id="loginform" method="post">
                    <div class="layel2">
                        <div class="text_uspa">
                            <label class="judgp uspa_user"></label>
                            <input type="text" autofocus="autofocus" class="text_cmu" value="" placeholder="手机号/邮箱" name="username" id="username" autocomplete="off">
                        </div>
                        <div class="text_uspa">
                            <label class="judgp uspa_pwd"></label>
                            <input type="password" class="text_cmu" value="" placeholder="密码" name="password" id="password" autocomplete="off">
                        </div>
                        <div class="text_uspa check_cum">
                            <input type="text" class="text_cmu" value="" placeholder="验证码" name="verify_code" id="verify_code" autocomplete="off">
                        </div>
                        <div class="check_cum_img">
                            <img src="/index.php?m=Home&c=User&a=verify" id="verify_code_img" onclick="verify()"/>
                        </div>
                        <div class="sum_reme_for p">
                          <!--  <div class="autplog">
                                <label>
                                    <input type="hidden" name="referurl" id="referurl" value="<?php echo $referurl; ?>">
                                    <input type="checkbox" class="u-ckb J-auto-rmb"  name="autologin" value="1">自动登录
                                </label>
                            </div>-->
                            <div class="foget_pwt">
                                <a href="<?php echo U('Home/User/forget_pwd'); ?>">忘记密码？</a>
                            </div>
                        </div>
                        <div class="login_bnt">
                            <a href="javascript:void(0);" onClick="checkSubmit();" class="J-login-submit" name="sbtbutton">登&nbsp;&nbsp;&nbsp;&nbsp;录</a>
                        </div>
                    </div>
                </form>
                <div class="layel3">
                    <div class="contactsty">
                        <div class="tecant_c">
                            <ul>
                                <?php
                                   
                                $md5_key = md5("select * from __PREFIX__plugin where type='login' AND status = 1");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("select * from __PREFIX__plugin where type='login' AND status = 1"); 
                                    S("sql_".$md5_key,$sql_result_v,86400);
                                }    
                              foreach($sql_result_v as $k=>$v): if($v['code'] == 'weixin'): ?>
                                        <li class="spacer"></li>
                                        <li>
                                            <a class="justclix" href="<?php echo U('LoginApi/login',array('oauth'=>'weixin')); ?>" title="weixin">
                                                <i class="judgp co_wechat"></i>
                                                <span>微信</span>
                                            </a>
                                        </li>
                                    <?php endif; if($v['code'] == 'qq'): ?>
                                        <li class="spacer"></li>
                                        <li>
                                            <a class="justclix" href="<?php echo U('LoginApi/login',array('oauth'=>'qq')); ?>" title="QQ">
                                                <i class="judgp co_qq"></i>
                                                <span>QQ</span>
                                            </a>
                                        </li>
                                    <?php endif; if($v['code'] == 'alipay'): ?>
                                        <li>
                                            <a class="justclix" href="<?php echo U('LoginApi/login',array('oauth'=>'alipay')); ?>" title="支付宝">
                                                <i class="judgp co_alipay"></i>
                                                <span>支付宝</span>
                                            </a>
                                        </li>
                                    <?php endif; endforeach; ?>
                            </ul>
                        </div>
                        <div class="register_c">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footer-s-->
<!--<div class="footer p">-->
    <!--<//include file="public/footer_index" />-->
<!--</div>-->
<div class="footer p">
    <div class="mod_copyright p" style="border-top: 0;">
        <div class="grid-top">
            <?php
                                   
                                $md5_key = md5("select * from `__PREFIX__article_cat` where parent_id = 2");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("select * from `__PREFIX__article_cat` where parent_id = 2"); 
                                    S("sql_".$md5_key,$sql_result_v,86400);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>
                <a href=""><?php echo $v[cat_name]; ?></a>
                <span>|</span>
            <?php endforeach; ?>
        </div>
        <p>Copyright © 2016-2025 本商城 版权所有 保留一切权利 备案号:粤00-123456号</p>
        <!-- <p class="mod_copyright_auth">
            <a class="mod_copyright_auth_ico mod_copyright_auth_ico_1" href="" target="_blank">经营性网站备案中心</a>
            <a class="mod_copyright_auth_ico mod_copyright_auth_ico_2" href="" target="_blank">可信网站信用评估</a>
            <a class="mod_copyright_auth_ico mod_copyright_auth_ico_3" href="" target="_blank">网络警察提醒你</a>
            <a class="mod_copyright_auth_ico mod_copyright_auth_ico_4" href="" target="_blank">诚信网站</a>
            <a class="mod_copyright_auth_ico mod_copyright_auth_ico_5" href="" target="_blank">中国互联网举报中心</a>
            <a class="mod_copyright_auth_ico mod_copyright_auth_ico_6" href="" target="_blank">网络举报APP下载</a>
        </p> -->
    </div>
</div>
<!--footer-e-->
<script type="text/javascript">
    $(function(){
        $('.text_cmu').focus(function(){
            //焦点获取
            $(this).parents('.text_uspa').addClass('text_uspa_focus');
        })
        $('.text_cmu').blur(function(){
            //失去焦点
            $(this).parents('.text_uspa').removeClass('text_uspa_focus');
        })
    })

    function checkSubmit()
    {
        var username = $.trim($('#username').val());
        var password = $.trim($('#password').val());
        var referurl = $('#referurl').val();
        var verify_code = $.trim($('#verify_code').val());
        if(username == ''){
            showErrorMsg('用户名不能为空!');
            return false;
        }
        /*if(!checkMobile(username) && !(username != '')){
            showErrorMsg('账号格式不匹配!');
            return false;
        }*/
        if(password == ''){
            showErrorMsg('密码不能为空!');
            return false;
        }
        if(verify_code == ''){
            showErrorMsg('验证码不能为空!');
            return false;
        }
        $.ajax({
            type : 'post',
            url : '/index.php?m=Home&c=User&a=do_login&t='+Math.random(),
            data : $('#loginform').serialize(),
            dataType : 'json',
            success : function(res){
                if(res.status == 1){
                    window.location.href = res.url;
                }else{
                    showErrorMsg(res.msg);
                    verify();
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                showErrorMsg('网络失败，请刷新页面后重试');
            }
        })

    }

    function checkMobile(tel) {
        var reg = /(^1[3|4|5|7|8][0-9]{9}$)/;
        if (reg.test(tel)) {
            return true;
        }else{
            return false;
        };
    }

    function checkEmail(str){
        var reg = /^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        if(reg.test(str)){
            return true;
        }else{
            return false;
        }
    }

    function showErrorMsg(msg){
        layer.alert(msg, {icon: 2});
//        $('.msg-err').show();
//        $('.J-errorMsg').html(msg);
    }

    function verify(){
        $('#verify_code_img').attr('src','/index.php?m=Home&c=User&a=verify&r='+Math.random());
    }
</script>
</body>
</html>