<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 采用TP5助手函数可实现单字母函数M D U等,也可db::name方式,可双向兼容
 * ============================================================================
 * Author: 当燃      
 * Date: 2015-09-09
 */

namespace app\admin\controller;
use app\admin\logic\OrderLogic;
use think\AjaxPage;
use think\Page;
use think\Verify;
use think\Db;
use app\admin\logic\UsersLogic;
use think\Loader;
use think\ID;

class User extends Base {
	
  	public function  get_all_num2($user_id, &$data_list = array()){
        //获取线下成员
        $data = M('users')->where(array('recommend_id'=>$user_id,'is_vip'=>1))->select();
        if(!empty($data)){
            foreach ($data as $k=>$v){
                $data_list[] = $v['fenhong_points_num'];
                $this->get_all_num2($v['user_id'],$data_list);
            }
        }
        return $data_list;
    }
    public function index(){
        return $this->fetch();
    }
	
    /**
     * 会员列表
     */
    public function ajaxindex(){
        // 搜索条件
        $condition = array();
        I('mobile') ? $condition['mobile'] = I('mobile') : false;
        I('email') ? $condition['email'] = I('email') : false;

        I('first_leader') && ($condition['first_leader'] = I('first_leader')); // 查看一级下线人有哪些
        I('second_leader') && ($condition['second_leader'] = I('second_leader')); // 查看二级下线人有哪些
        I('third_leader') && ($condition['third_leader'] = I('third_leader')); // 查看三级下线人有哪些
        $sort_order = I('order_by').' '.I('sort');
               
        $model = M('users');
        $count = $model->where($condition)->count();
        $Page  = new AjaxPage($count,10);
        //  搜索条件下 分页赋值
        foreach($condition as $key=>$val) {
            $Page->parameter[$key]   =   urlencode($val);
        }
        
        $userList = $model->where($condition)->order($sort_order)->limit($Page->firstRow.','.$Page->listRows)->select();
               
        $user_id_arr = get_arr_column($userList, 'user_id');
        if(!empty($user_id_arr))
        {
            $first_leader = DB::query("select first_leader,count(1) as count  from __PREFIX__users where first_leader in(".  implode(',', $user_id_arr).")  group by first_leader");
            $first_leader = convert_arr_key($first_leader,'first_leader');
            
            $second_leader = DB::query("select second_leader,count(1) as count  from __PREFIX__users where second_leader in(".  implode(',', $user_id_arr).")  group by second_leader");
            $second_leader = convert_arr_key($second_leader,'second_leader');            
            
            $third_leader = DB::query("select third_leader,count(1) as count  from __PREFIX__users where third_leader in(".  implode(',', $user_id_arr).")  group by third_leader");
            $third_leader = convert_arr_key($third_leader,'third_leader');            
        }

        foreach ($userList as $key => $value) {
            $data = array();
            $all_num = $this->get_all_num2($value['user_id'],$data);

            $all = array_sum($all_num)+count($all_num);
            if (empty($all_num)) {
                $max_index = 0;
            }else{
                $max_index = array_search(max($all_num), $all_num);
            }

            $userList[$key]['all_money'] = $all*1500;

            $userList[$key]['qdzg'] = ($all - $all_num[$max_index])*1500;
        }

        $this->assign('first_leader',$first_leader);
        $this->assign('second_leader',$second_leader);
        $this->assign('third_leader',$third_leader);                                
        $show = $Page->show();
        $this->assign('userList',$userList);
        $this->assign('level',M('user_level')->getField('level_id,level_name'));
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('pager',$Page);
        return $this->fetch();
    }

    /**
     * 会员详细信息查看
     */
    public function detail(){
        $uid = I('get.id');
        $user = D('users')->where(array('user_id'=>$uid))->find();
        if(!$user)
            exit($this->error('会员不存在'));
        if(IS_POST){
            //  会员信息编辑
            $mobile = I('post.mobile');
            if($mobile){
                unset($mobile);
            }
            $user_card_id = I('post.user_card_id');
            $id_obj = new ID();
            $is_true_card = $id_obj->validateIDCard($user_card_id);

            if(!$is_true_card){

                $this->error('请填写正确的身份证号');
            }
            $password = I('post.password');
            $password2 = I('post.password2');
            $paypwd = I('post.paypwd');
            if($password != '' && $password != $password2){
                exit($this->error('两次输入密码不同'));
            }
            if($password == '' && $password2 == ''){
                unset($_POST['password']);
            }else{
                $_POST['password'] = encrypt($_POST['password']);
            }
            if($paypwd == ''){
                unset($_POST['paypwd']);
            }else{
                $_POST['paypwd'] =encrypt( $paypwd);
            }
            if(!empty($_POST['email']))
            {   $email = trim($_POST['email']);
                $c = M('users')->where("user_id != $uid and email = '$email'")->count();
                $c && exit($this->error('邮箱不得和已有用户重复'));
            }            
            
            if(!empty($_POST['mobile']))
            {   $mobile = trim($_POST['mobile']);
                $c = M('users')->where("user_id != $uid and mobile = '$mobile'")->count();
                $c && exit($this->error('手机号不得和已有用户重复'));
            }            
            //dump($_POST);die;
            $_POST['user_bank'] = I('post.user_bank');
            $_POST['user_bank_name'] = I('post.user_bank_name');
            $_POST['nickname'] = I('post.user_bank_name');
            $_POST['bank_num'] = I('post.bank_num');
            $row = M('users')->where(array('user_id'=>$uid))->save($_POST);
            if($row)
                exit($this->success('修改成功'));
            exit($this->error('未作内容修改或修改失败'));
        }
        
        $user['first_lower'] = M('users')->where("first_leader = {$user['user_id']}")->count();
        $user['second_lower'] = M('users')->where("second_leader = {$user['user_id']}")->count();
        $user['third_lower'] = M('users')->where("third_leader = {$user['user_id']}")->count();
 
        $this->assign('user',$user);
        return $this->fetch();
    }
    
    public function add_user(){
    	if(IS_POST){
    		$data = I('post.');
            //dump($data);die;
			$user_obj = new UsersLogic();
			$res = $user_obj->addUser($data);
			if($res['status'] == 1){
				$this->success('添加成功',U('User/index'));exit;
			}else{
				$this->error('添加失败,'.$res['msg'],U('User/index'));
			}
    	}
    	return $this->fetch();
    }
    
    public function export_user(){
    	$strTable ='<table width="500" border="1">';
    	$strTable .= '<tr>';
    	$strTable .= '<td style="text-align:center;font-size:12px;width:120px;">会员ID</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="100">会员昵称</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">会员等级</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">手机号</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">团队业绩</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">注册时间</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">最后登陆</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">余额</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">积分</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">累计消费</td>';
    	$strTable .= '</tr>';
    	$count = M('users')->count();
    	$p = ceil($count/5000);
    	for($i=0;$i<$p;$i++){
    		$start = $i*5000;
    		$end = ($i+1)*5000;
    		$userList = M('users')->order('user_id')->limit($start.','.$end)->select();
    		if(is_array($userList)){
    			foreach($userList as $k=>$val){
    				$strTable .= '<tr>';
    				$strTable .= '<td style="text-align:center;font-size:12px;">'.$val['user_id'].'</td>';
    				$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['nickname'].' </td>';
    				$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['level'].'</td>';
    				$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['mobile'].'</td>';
    				$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['fenhong_points_num'].'</td>';
    				$strTable .= '<td style="text-align:left;font-size:12px;">'.date('Y-m-d H:i',$val['reg_time']).'</td>';
    				$strTable .= '<td style="text-align:left;font-size:12px;">'.date('Y-m-d H:i',$val['last_login']).'</td>';
    				$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['user_money'].'</td>';
    				$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['pay_points'].' </td>';
    				$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['total_amount'].' </td>';
    				$strTable .= '</tr>';
    			}
    			unset($userList);
    		}
    	}
    	$strTable .='</table>';
    	downloadExcel($strTable,'users_'.$i);
    	exit();
    }

    /**
     * 用户收货地址查看
     */
    public function address(){
        $uid = I('get.id');
        $lists = D('user_address')->where(array('user_id'=>$uid))->select();
        $regionList = get_region_list();
        $this->assign('regionList',$regionList);
        $this->assign('lists',$lists);
        return $this->fetch();
    }

    /**
     * 删除会员
     */
    public function delete(){
        $uid = I('get.id');
        $row = M('users')->where(array('user_id'=>$uid))->delete();
        if($row){
            $this->success('成功删除会员');
        }else{
            $this->error('操作失败');
        }
    }
    /**
     * 删除会员
     */
    private function ajax_delete(){
        $uid = I('id');
        if($uid){
            $row = M('users')->where(array('user_id'=>$uid))->delete();
            if($row !== false){
                $this->ajaxReturn(array('status' => 1, 'msg' => '删除成功', 'data' => ''));
            }else{
                $this->ajaxReturn(array('status' => 0, 'msg' => '删除失败', 'data' => ''));
            }
        }else{
            $this->ajaxReturn(array('status' => 0, 'msg' => '参数错误', 'data' => ''));
        }
    }

    /**
     * 账户资金记录
     */
    public function account_log(){
        $user_id = I('get.id');
        //获取类型
        $type = I('get.type');
        //获取记录总数
        $count = M('account_log')->where(array('user_id'=>$user_id))->count();
        $page = new Page($count);
        $lists  = M('account_log')->where(array('user_id'=>$user_id))->order('change_time desc')->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign('user_id',$user_id);
        $this->assign('page',$page->show());
        $this->assign('lists',$lists);
        return $this->fetch();
    }

    /**
     * 账户资金调节
     */
    /*public function account_edit(){
        $order_info = I('get.');
        $user_id = $order_info['user_id'];
        if(!$user_id > 0)
            $this->error("参数有误");
        $user = M('users')->field('user_id,user_money,frozen_money,pay_points,is_lock')->where('user_id',$user_id)->find();
        if(IS_POST){
            $return_info = I('post.');
            $return_id   = $return_info['return_id'];
            if(!$return_info['desc'])
                $this->error("请填写操作说明");
            //加减用户资金
            $m_op_type = I('post.money_act_type');
            $user_money = I('post.user_money/f');
            $user_money =  $m_op_type ? $user_money : 0-$user_money;
            //加减用户积分
            $p_op_type = I('post.point_act_type');
            $pay_points = I('post.pay_points/d');
            $pay_points =  $p_op_type ? $pay_points : 0-$pay_points;
            //加减冻结资金
            $f_op_type = I('post.frozen_act_type');
            $revision_frozen_money = I('post.frozen_money/f');
            if( $revision_frozen_money != 0){    //有加减冻结资金的时候
                $frozen_money =  $f_op_type ? $revision_frozen_money : 0-$revision_frozen_money;
                $frozen_money = $user['frozen_money']+$frozen_money;    //计算用户被冻结的资金
                if($f_op_type==1 and $revision_frozen_money > $user['user_money']){ $this->error("用户剩余资金不足！！");}
                if($f_op_type==0 and $revision_frozen_money > $user['frozen_money']){$this->error("冻结的资金不足！！");}
                $user_money = $f_op_type ? 0-$revision_frozen_money : $revision_frozen_money ;    //计算用户剩余资金
                M('users')->where('user_id',$user_id)->update(['frozen_money' => $frozen_money]);
            }

            if(accountLog($user_id,$user_money,$pay_points,$return_info['desc'],0,$return_info['order_id'],$return_info['order_sn'])){
                if($return_id>0){  //有退货id,是订单退款，要更新退货单状态
                    $orderLogic = new OrderLogic();
                    $res = $orderLogic->alterReturnGoodsStatus($return_id,$return_info['order_id']);
                    $orderLogic->closeOrderByReturn($return_info['order_id']);
                    if($res)
                        $this->success("操作成功", U("Admin/order/return_info", array('id' => $return_id)));
                    $this->error("操作失败");
                }
                $this->success("操作成功",U("Admin/User/account_log",array('id'=>$user_id)));
            }else{
                $this->error("操作失败");
            }
            exit;
        }
        if($order_info['return_id']){  //有退货id,是订单退款
            $return_info = M('return_goods')->field('order_sn,order_id,goods_id,spec_key')->where('id',$order_info['return_id'])->find(); //查找退货商品信息
            $order_info=array_merge($return_info,$order_info);  //合并数值
            $order_goods= M('order_goods')->where(array_splice($return_info ,1))->find();  //去掉order_sn 后作为条件去查找
            $order_info['user_money']  =$order_goods['member_goods_price']*$order_goods['goods_num'];  //计算默认退款
        }
        $this->assign('user_id',$user_id);
        $this->assign('user',$user);
        $this->assign('order_info',$order_info);
        return $this->fetch();
    }*/
    public function account_edit(){
        $order_info = I('get.');
        $user_id = $order_info['user_id'];
        if(!$user_id > 0)
            $this->error("参数有误");
        $user = M('users')->where('user_id',$user_id)->find();

        if(IS_POST){
            $return_info = I('post.');
            //购物币操作
           if($return_info['zhang_type'] == 1){
                //购物币增加操作
               if($return_info['act_type'] ==1){
                   $res = accountLog($user['user_id'],$return_info['money'],0,$return_info['desc'],0,0,0,0,38);
                   if($res){
                       $this->success('增加成功');
                   }else{
                       $this->error('增加失败');
                   }

                //购物币减少操作
               }elseif($return_info['act_type'] ==0){
                    if($return_info['money'] > $user['user_money']){
                        $this->error('用户的购物币最大金额不够扣除');exit();
                    }else{
                        $res = accountLog($user['user_id'],-$return_info['money'],0,$return_info['desc'],0,0,0,0,38);
                        if($res){
                            $this->success('增加成功');
                        }else{
                            $this->error('增加失败');
                        }
                    }
               }
            //激活币操作
           }elseif($return_info['zhang_type'] == 2){

               if($return_info['act_type'] ==1){
                   $res = accountLog($user['user_id'],0,0,$return_info['desc'],0,0,0,0,37,0,$return_info['money']);
                   if($res){
                       $this->success('增加成功');
                   }else{
                       $this->error('增加失败');
                   }
               }elseif($return_info['act_type'] ==0){
                   if($return_info['money'] > $user['jihuobi']){
                       $this->error('用户的激活币最大金额不够扣除');exit();
                   }else{

                       $res = accountLog($user['user_id'],0,0,$return_info['desc'],0,0,0,0,37,0,-$return_info['money']);
                       if($res){
                           $this->success('减少成功');
                       }else{
                           $this->error('减少失败');
                       }
                   }

               }

               //报单币操作
           }elseif($return_info['zhang_type'] == 3){

               if($return_info['act_type'] ==1){
                   $res = accountLog($user['user_id'],0,0,$return_info['desc'],0,0,0,0,36,$return_info['money'],0);
                   if($res){
                       $this->success('增加成功');
                   }else{
                       $this->error('增加失败');
                   }


               }elseif($return_info['act_type'] ==0){
                   if($return_info['money'] > $user['baodanbi']){
                       $this->error('用户的报单币最大金额不够扣除');exit();
                   }else{

                       $res = accountLog($user['user_id'],0,0,$return_info['desc'],0,0,0,0,36,-$return_info['money'],0);
                       if($res){
                           $this->success('减少成功');
                       }else{
                           $this->error('减少失败');
                       }
                   }

               }
               //奖励币操作
           }elseif($return_info['zhang_type'] == 4){

               if($return_info['act_type'] ==1){
                   $res = accountLog($user['user_id'],0,0,$return_info['desc'],0,0,0,$return_info['money'],35,0,0);
                   if($res){
                       $this->success('增加成功');
                   }else{
                       $this->error('增加失败');
                   }


               }elseif($return_info['act_type'] ==0){
                   if($return_info['money'] > $user['group_money']){
                       $this->error('用户的奖励币最大金额不够扣除');exit();
                   }else{

                       $res = accountLog($user['user_id'],0,0,$return_info['desc'],0,0,0,-$return_info['money'],35,0,0);
                       if($res){
                           $this->success('增加成功');
                       }else{
                           $this->error('增加失败');
                       }
                   }

               }


           }
        }
        if($order_info['return_id']){  //有退货id,是订单退款
            $return_info = M('return_goods')->field('order_sn,order_id,goods_id,spec_key')->where('id',$order_info['return_id'])->find(); //查找退货商品信息
            $order_info=array_merge($return_info,$order_info);  //合并数值
            $order_goods= M('order_goods')->where(array_splice($return_info ,1))->find();  //去掉order_sn 后作为条件去查找
            $order_info['user_money']  =$order_goods['member_goods_price']*$order_goods['goods_num'];  //计算默认退款
        }
        $this->assign('user_id',$user_id);
        $this->assign('user',$user);
        $this->assign('order_info',$order_info);
        return $this->fetch();
    }
    
    public function recharge(){
    	$timegap = I('timegap');
    	$nickname = I('nickname');
    	$map = array();
    	if($timegap){
    		$gap = explode(' - ', $timegap);
    		$begin = $gap[0];
    		$end = $gap[1];
    		$map['ctime'] = array('between',array(strtotime($begin),strtotime($end)));
    	}
    	if($nickname){
    		$map['nickname'] = array('like',"%$nickname%");
    	}  	
    	$count = M('recharge')->where($map)->count();
    	$page = new Page($count);
    	$lists  = M('recharge')->where($map)->order('ctime desc')->limit($page->firstRow.','.$page->listRows)->select();
    	$this->assign('page',$page->show());
        $this->assign('pager',$page);
    	$this->assign('lists',$lists);
    	return $this->fetch();
    }
    /*
     *
     * 用户充值后台通过*/
    public function tj_money()
    {
        $order_id = intval(I('post.order_id'));
        $reg_info = M('recharge')->where('order_id='.$order_id)->find();
        if(!$reg_info){
            $return = array('status'=>-1,'msg'=>'信息不存在');
            $this->ajaxReturn( $return );
            exit();
        }else{

            if($reg_info['pay_status'] == 0){

                $res = M('recharge')->where('order_id='.$order_id)->save(array('pay_status'=>1,'pay_time'=>time()));
                if($res){

                    accountLog($reg_info['user_id'],+$reg_info['account'],0,'用户充值',0,$order_id);
                    $return = array('status'=>1,'msg'=>'审核通过');
                    $this->ajaxReturn( $return );
                }
            }
        }
    }

    public function rechargeHandle()
    {
        $order_id = intval(I('post.order_id'));

        $res = M('recharge')->where('order_id='.$order_id)->delete();
        if( $res ){

            $this->ajaxReturn(array('msg'=>'成功'));
        }
    }

    public function rechargeRefuse()
    {
        $order_id = intval(I('post.order_id'));

        $res = M('recharge')->where('order_id='.$order_id)->save(array('pay_status'=>3));
        if($res){

            $this->ajaxReturn('拒绝成功');
        }
    }
    
    public function level(){
    	$act = I('get.act','add');
    	$this->assign('act',$act);
    	$level_id = I('get.level_id');
    	if($level_id){
    		$level_info = D('user_level')->where('level_id='.$level_id)->find();
    		$this->assign('info',$level_info);
    	}
    	return $this->fetch();
    }
    
    public function levelList(){
    	$Ad =  M('user_level');
        $p = $this->request->param('p');
    	$res = $Ad->order('level_id')->page($p.',10')->select();
    	if($res){
    		foreach ($res as $val){
    			$list[] = $val;
    		}
    	}
    	$this->assign('list',$list);
    	$count = $Ad->count();
    	$Page = new Page($count,10);
    	$show = $Page->show();
    	$this->assign('page',$show);
    	return $this->fetch();
    }

    /**
     * 会员等级添加编辑删除
     */
    public function levelHandle()
    {
        $data = I('post.');
        $userLevelValidate = Loader::validate('UserLevel');
        $return = ['status' => 0, 'msg' => '参数错误', 'result' => ''];//初始化返回信息
        if ($data['act'] == 'add') {
            if (!$userLevelValidate->batch()->check($data)) {
                $return = ['status' => 0, 'msg' => '添加失败', 'result' => $userLevelValidate->getError()];
            } else {
                $r = D('user_level')->add($data);
                if ($r !== false) {
                    $return = ['status' => 1, 'msg' => '添加成功', 'result' => $userLevelValidate->getError()];
                } else {
                    $return = ['status' => 0, 'msg' => '添加失败，数据库未响应', 'result' => ''];
                }
            }
        }
        if ($data['act'] == 'edit') {
            if (!$userLevelValidate->scene('edit')->batch()->check($data)) {
                $return = ['status' => 0, 'msg' => '编辑失败', 'result' => $userLevelValidate->getError()];
            } else {
                $r = D('user_level')->where('level_id=' . $data['level_id'])->save($data);
                if ($r !== false) {
                    $return = ['status' => 1, 'msg' => '编辑成功', 'result' => $userLevelValidate->getError()];
                } else {
                    $return = ['status' => 0, 'msg' => '编辑失败，数据库未响应', 'result' => ''];
                }
            }
        }
        if ($data['act'] == 'del') {
            $r = D('user_level')->where('level_id=' . $data['level_id'])->delete();
            if ($r !== false) {
                $return = ['status' => 1, 'msg' => '删除成功', 'result' => ''];
            } else {
                $return = ['status' => 0, 'msg' => '删除失败，数据库未响应', 'result' => ''];
            }
        }
        $this->ajaxReturn($return);
    }

    /**
     * 搜索用户名
     */
    public function search_user()
    {
        $search_key = trim(I('search_key'));        
        if(strstr($search_key,'@'))    
        {
            $list = M('users')->where(" email like '%$search_key%' ")->select();        
            foreach($list as $key => $val)
            {
                echo "<option value='{$val['user_id']}'>{$val['email']}</option>";
            }                        
        }
        else
        {
            $list = M('users')->where(" mobile like '%$search_key%' ")->select();        
            foreach($list as $key => $val)
            {
                echo "<option value='{$val['user_id']}'>{$val['mobile']}</option>";
            }            
        } 
        exit;
    }
    
    /**
     * 分销树状关系
     */
    public function ajax_distribut_tree()
    {
          $list = M('users')->where("first_leader = 1")->select();
          return $this->fetch();
    }

    /**
     *
     * @time 2016/08/31
     * @author dyr
     * 发送站内信
     */
    public function sendMessage()
    {
        $user_id_array = I('get.user_id_array');
        $users = array();
        if (!empty($user_id_array)) {
            $users = M('users')->field('user_id,nickname')->where(array('user_id' => array('IN', $user_id_array)))->select();
        }
        $this->assign('users',$users);
        return $this->fetch();
    }

    /**
     * 发送系统消息
     * @author dyr
     * @time  2016/09/01
     */
    public function doSendMessage()
    {
        $call_back = I('call_back');//回调方法
        $text= I('post.text');//内容
        $type = I('post.type', 0);//个体or全体
        $admin_id = session('admin_id');
        $users = I('post.user/a');//个体id
        $message = array(
            'admin_id' => $admin_id,
            'message' => $text,
            'category' => 0,
            'send_time' => time()
        );

        if ($type == 1) {
            //全体用户系统消息
            $message['type'] = 1;
            M('Message')->add($message);
        } else {
            //个体消息
            $message['type'] = 0;
            if (!empty($users)) {
                $create_message_id = M('Message')->add($message);
                foreach ($users as $key) {
                    M('user_message')->add(array('user_id' => $key, 'message_id' => $create_message_id, 'status' => 0, 'category' => 0));
                }
            }
        }
        echo "<script>parent.{$call_back}(1);</script>";
        exit();
    }

    /**
     *
     * @time 2016/09/03
     * @author dyr
     * 发送邮件
     */
    public function sendMail()
    {
        $user_id_array = I('get.user_id_array');
        $users = array();
        if (!empty($user_id_array)) {
            $user_where = array(
                'user_id' => array('IN', $user_id_array),
                'email' => array('neq', '')
            );
            $users = M('users')->field('user_id,nickname,email')->where($user_where)->select();
        }
        $this->assign('smtp', tpCache('smtp'));
        $this->assign('users', $users);
        return $this->fetch();
    }

    /**
     * 发送邮箱
     * @author dyr
     * @time  2016/09/03
     */
    public function doSendMail()
    {
        $call_back = I('call_back');//回调方法
        $message = I('post.text');//内容
        $title = I('post.title');//标题
        $users = I('post.user/a');
        $email= I('post.email');
        if (!empty($users)) {
            $user_id_array = implode(',', $users);
            $users = M('users')->field('email')->where(array('user_id' => array('IN', $user_id_array)))->select();
            $to = array();
            foreach ($users as $user) {
                if (check_email($user['email'])) {
                    $to[] = $user['email'];
                }
            }
            $res = send_email($to, $title, $message);
            echo "<script>parent.{$call_back}({$res['status']});</script>";
            exit();
        }
        if($email){
            $res = send_email($email, $title, $message);
            echo "<script>parent.{$call_back}({$res['status']});</script>";
            exit();
        }
    }

    /**
     * 提现申请记录
     */
    public function withdrawals()
    {
        $model = M("withdrawals");
        $_GET = array_merge($_GET,$_POST);
        unset($_GET['create_time']);

        $status = I('status');
        $user_id = I('user_id');
        $account_bank = I('account_bank');
        $account_name = I('account_name');
        $create_time = I('create_time');
        $create_time = $create_time  ? $create_time  : date('Y/m/d',strtotime('-1 year')).'-'.date('Y/m/d',strtotime('+1 day'));
        $create_time2 = explode('-',$create_time);
        $this->assign('start_time', $create_time2[0]);
        $this->assign('end_time', $create_time2[1]);
        $where = " create_time >= '".strtotime($create_time2[0])."' and create_time <= '".strtotime($create_time2[1])."' ";

        if($status === '0' || $status > 0)
            $where .= " and status = $status ";
        $user_id && $where .= " and user_id = $user_id ";
        $account_bank && $where .= " and account_bank like '%$account_bank%' ";
        $account_name && $where .= " and account_name like '%$account_name%' ";

        $count = $model->where($where)->count();
        $Page  = new Page($count,16);
        $list = $model->where($where)->order("`id` desc")->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('create_time',$create_time);
        $show  = $Page->show();
        $this->assign('show',$show);
        $this->assign('pager',$Page);
        $this->assign('list',$list);
        C('TOKEN_ON',false);
        return $this->fetch();
    }
    /**
     * 删除申请记录
     */
    public function delWithdrawals()
    {
        $model = M("withdrawals");
        $model->where('id ='.$_GET['id'])->delete();
        $return_arr = array('status' => 1,'msg' => '操作成功','data'  =>'',);   //$return_arr = array('status' => -1,'msg' => '删除失败','data'  =>'',);
        $this->ajaxReturn($return_arr);
    }

    /**
     * 修改编辑 申请提现
     */
    public function editWithdrawals()
    {
        $id = I('id');
        $withdrawals = DB::name('withdrawals')->where('id',$id)->find();
        $user = M('users')->where("user_id = {$withdrawals[user_id]}")->find();
        if (IS_POST) {
            $data = I('post.');
            if($withdrawals['withdrawals_type'] == 1){
                if($data['status'] == 1 && $withdrawals['status'] != 1){
                    //通过提现
                    $res = M('withdrawals')->where('id='.$id)->save(array('status'=>1,'confirm_time'=>time()));
                    if($res){
                        $this->success('提现成功');exit;
                    }else{

                        $this->error('提现失败，请联系技术人员');
                        exit();
                    }

                }elseif($data['status'] == 2){
                    //拒绝提现
                    accountLog($user['user_id'],0,$withdrawals['money'],'您的注册积分提现未通过');
                    $res = M('withdrawals')->where('id='.$id)->save(array('status'=>2,'confirm_time'=>time()));
                    if($res){
                        $this->success('提交成功，未通过提现');
                        exit();
                    }else{

                        $this->error('提交失败，请联系技术人员');
                        exit();
                    }
                }


            }elseif($withdrawals['withdrawals_type'] == 2){
                if($data['status'] == 1 && $withdrawals['status'] != 1){
                    //通过提现
                    $res = M('withdrawals')->where('id='.$id)->save(array('status'=>1,'confirm_time'=>time()));
                    if($res){
                        $this->success('提现成功');exit;
                    }else{

                        $this->error('提现失败，请联系技术人员');
                        exit();
                    }

                }elseif($data['status'] == 2){
                    //拒绝提现
                    accountLog($user['user_id'],$withdrawals['money'],0,'您的购物积分提现未通过');
                    $res = M('withdrawals')->where('id='.$id)->save(array('status'=>2,'confirm_time'=>time()));
                    if($res){
                        $this->success('提交成功，未通过提现');
                        exit();
                    }else{

                        $this->error('提交失败，请联系技术人员');
                        exit();
                    }
                }


            }elseif($withdrawals['withdrawals_type'] == 3){

                if($data['status'] == 1 && $withdrawals['status'] != 1){
                    //通过提现
                    $res = M('withdrawals')->where('id='.$id)->save(array('status'=>1,'confirm_time'=>time()));
                    if($res){
                        $this->success('提现成功');exit;
                    }else{

                        $this->error('提现失败，请联系技术人员');
                        exit();
                    }

                }elseif($data['status'] == 2){
                    //拒绝提现
                    accountLog($user['user_id'],0,0,'您的收益积分提现未通过',0,0,0,$withdrawals['money']);
                    $res = M('withdrawals')->where('id='.$id)->save(array('status'=>2,'confirm_time'=>time()));
                    if($res){
                        $this->success('提交成功，未通过提现');
                        exit();
                    }else{

                        $this->error('提交失败，请联系技术人员');
                        exit();
                    }
                }


            }
            // 如果是已经给用户转账 则生成转账流水记录
            /*if ($data['status'] == 1 && $withdrawals['status'] != 1) {
                if ($user['user_money'] < $withdrawals['money']) {
                    $this->error("用户余额不足{$withdrawals['money']}，不够提现");
                    exit;
                }
                accountLog($withdrawals['user_id'], ($withdrawals['money'] * -1), 0, "平台提现");
                $remittance = array(
                    'user_id' => $withdrawals['user_id'],
                    'bank_name' => $withdrawals['bank_name'],
                    'account_bank' => $withdrawals['account_bank'],
                    'account_name' => $withdrawals['account_name'],
                    'money' => $withdrawals['money'],
                    'status' => 1,
                    'create_time' => time(),
                    'admin_id' => session('admin_id'),
                    'withdrawals_id' => $withdrawals['id'],
                    'remark' => $data['remark'],
                );
                M('remittance')->add($remittance);
            }
            DB::name('withdrawals')->update($data);
            $this->success("操作成功!", U('Admin/User/remittance'), 3);
            exit;*/
        }

        if ($user['nickname'])
            $withdrawals['user_name'] = $user['nickname'];
        elseif ($user['email'])
            $withdrawals['user_name'] = $user['email'];
        elseif ($user['mobile'])
            $withdrawals['user_name'] = $user['mobile'];
        $this->assign('user', $user);
        $this->assign('data', $withdrawals);
        return $this->fetch();
    }

    public function withdrawals_update(){
        $id = I('id/a');
        $status = I('status');
        $withdrawals = M('withdrawals')->where('id','in', $id)->select();
        if($status == 1){
            $r = M('withdrawals')->where('id','in', $id)->save(array('status'=>$status,'check_time'=>time()));
        }else if($status == -1){
            $r = M('withdrawals')->where('id','in', $id)->save(array('status'=>$status,'refuse_time'=>time()));
        }else if($status == 2){
            foreach($withdrawals as $val){
                $user = M('users')->where(array('user_id'=>$val['user_id']))->find();
                if($user['user_money'] < $val['money'])
                {
                    $data['status'] = -2;
                    $data['remark'] = '账户余额不足';
                    M('withdrawals')->where(array('id'=>$val['id']))->save($data);
                }else{
                    if($val['bank_name'] == '支付宝 '){
                        //流水号1^收款方账号1^收款账号姓名1^付款金额1^备注说明1|流水号2^收款方账号2^收款账号姓名2^付款金额2^备注说明2
                        $alipay['batch_no'] = time();
                        $alipay['batch_fee'] += $val['money'];
                        $alipay['batch_num'] += 1;
                        $str = isset($alipay['detail_data']) ? '|' : '';
                        $alipay['detail_data'] .= $str.$val['pay_code'].'^'.$val['account_bank'].'^'.$val['realname'].'^'.$val['money'].'^'.$val['remark'];
                    }
                    if($val['bank_name'] == '微信'){
                        $wxpay = array(
                            'userid' => $val['user_id'],//用户ID做更新状态使用
                            'openid' => $val['account_bank'],//收钱的人微信 OPENID
                            'pay_code'=>$val['pay_code'],//提现申请ID
                            'money' => $val['money'],//金额
                            'desc' => '恭喜您提现申请成功!'
                        );
                        $res = $this->transfer('weixin',$wxpay);//微信在线付款转账
                        if($res['partner_trade_no']){
                            accountLog($val['user_id'], ($val['money'] * -1), 0,"平台处理用户提现申请");
                            $r = M('withdrawals')->where(array('id'=>$val['id']))->save(array('status'=>$status,'pay_time'=>time()));
                        }else{
                            $this->ajaxReturn(array('status'=>0,'msg'=>$res['msg']),'JSON');
                        }
                    }
                }
            }
            if(!empty($alipay)){
                $this->transfer('alipay',$alipay);
            }
            $this->ajaxReturn(array('status'=>1,'msg'=>"操作成功"),'JSON');
        }else if($status == 3){
            $r = M('withdrawals')->where('id in ('.implode(',', $id).')')->delete();
        }else{
            accountLog($val['user_id'], ($val['money'] * -1), 0,"管理员处理用户提现申请");//手动转账，默认视为已通过线下转方式处理了该笔提现申请
            $r = M('withdrawals')->where('id in ('.implode(',', $id).')')->save(array('status'=>2,'pay_time'=>time()));
        }
        if($r){
            $this->ajaxReturn(array('status'=>1,'msg'=>"操作成功"),'JSON');
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>"操作失败"),'JSON');
        }

    }

    public function transfer($atype,$data){
        if($atype == 'weixin'){
            include_once  PLUGIN_PATH."payment/weixin/weixin.class.php";
            $wxpay_obj = new \weixin();
            return $wxpay_obj->transfer($data);
        }else{
            //支付宝在线批量付款
            include_once  PLUGIN_PATH."payment/alipay/alipay.class.php";
            $alipay_obj = new \alipay();
            return $alipay_obj->transfer($data);
        }
    }
    /**
     *  转账汇款记录
     */
    public function remittance(){
        $model = M("remittance");
        $_GET = array_merge($_GET,$_POST);
        unset($_GET['create_time']);

        $user_id = I('user_id');
        $account_bank = I('account_bank');
        $account_name = I('account_name');

        $create_time = I('create_time');
        $create_time = $create_time  ? $create_time  : date('Y-m-d',strtotime('-1 year')).' - '.date('Y-m-d',strtotime('+1 day'));
        $create_time2 = explode(' - ',$create_time);
        $this->assign('start_time',$create_time2[0]);
        $this->assign('end_time',$create_time2[1]);
        $where = " create_time >= '".strtotime($create_time2[0])."' and create_time <= '".strtotime($create_time2[1])."' ";
        $user_id && $where .= " and user_id = $user_id ";
        $account_bank && $where .= " and account_bank like '%$account_bank%' ";
        $account_name && $where .= " and account_name like '%$account_name%' ";

        $count = $model->where($where)->count();
        $Page  = new Page($count,16);
        $list = $model->where($where)->order("`id` desc")->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('pager',$Page);
        $this->assign('create_time',$create_time);
        $show  = $Page->show();
        $this->assign('show',$show);
        $this->assign('list',$list);
        C('TOKEN_ON',false);
        return $this->fetch();
    }

    public function server()
    {
        return $this->fetch();

    }

    public function ajaxserver()
    {
        $condition = array();
        I('mobile') ? $condition['mobile'] = I('mobile') : false;
        // $sort_order = I('order_by').' '.I('sort');
        $model = M('server_log');
        $count = $model->where($condition)->count();
        $Page  = new AjaxPage($count,10);
        //  搜索条件下 分页赋值
        foreach($condition as $key=>$val) {
            $Page->parameter[$key]   =   urlencode($val);
        }

        $userList = $model->where($condition)->limit($Page->firstRow.','.$Page->listRows)->select();
        //dump($userList);die;
        $show = $Page->show();
        $this->assign('userList',$userList);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('pager',$Page);

        return $this->fetch();
    }

    public function tongguo()
    {   $data = intval(I('post.user_id'));
       $res =  M('users')->where('user_id='.$data)->save(array('is_service'=>1));
        if($res){
            M('server_log')->where('user_id='.$data)->save(array('is_service'=>1));
            echo json_encode(array('msg'=>'通过成功'));exit();
        }else{

            echo json_encode(array('msg'=>'申请失败，请联系技术人员'));
        }
        
    }

    public function ajax_server_delete()
    {
        $server_id = intval(I('post.id'));
        $res = M('server_log')->where('server_id='.$server_id)->delete();
        if($res){

            echo json_encode(array('msg'=>'删除成功','status'=>1));
        }



    }

        /*
        *
        * 后台自定义为用户修改保单中心
        *
        *
        * */

    public function add_server()
    {
        if(IS_POST){
            $data = I('post.');
            $mobile = $data['mobile'];
            $user_info = Db::table('tp_users')->where('mobile='.$mobile)->find();
            if(empty($user_info)){
                $this->error('用户不存在',U('User/add_server'));

            }elseif($user_info['is_service'] == 1){
                $this->error('此会员已开通',U('User/add_server'));
            }else{


               $res = M('users')->where('mobile='.$mobile)->save(array('is_service'=>$data['is_service']));
                if($res){

                    $this->success('申请成功',U('User/server'));
                }else{

                    $this->error('申请失败','');
                }
            }

        }else{

            return $this->fetch();
        }
    }

    public function fenghong_points(){
        return $this->fetch();
    }
    public function ajaxfenhong_points(){

        $condition = array();
        I('mobile') ? $condition['fenhong_user_mobile'] = I('mobile') : false;
        // $sort_order = I('order_by').' '.I('sort');
        $model = M('users_fenhong');
        $count = $model->where($condition)->count();
        $Page  = new AjaxPage($count,10);
        //  搜索条件下 分页赋值
        foreach($condition as $key=>$val) {
            $Page->parameter[$key]   =   urlencode($val);
        }

        $userList = $model->where($condition)->order('fenhong_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        //dump($userList);die;
        $show = $Page->show();
        $this->assign('userList',$userList);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('pager',$Page);

        return $this->fetch();
    }
    public function fenhong_active(){
        $id = I('id/d');
        $fenhong_info = M('users_fenhong')->where(array('fenhong_id'=>$id))->find();
        if (empty($fenhong_info)) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '未找到该点位', 'data' => ''));
        }
        if ($fenhong_info['fenhong_end_state'] == 1) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '该点位已经失效', 'data' => ''));
        }
        if ($fenhong_info['fenhong_active_state'] == 0) {
            $rs = M('users_fenhong')->where(array('fenhong_id'=>$id))->save(array('fenhong_active_state'=>1));
            if ($rs) {
                $this->ajaxReturn(array('status' => 1, 'msg' => '激活成功', 'data' => ''));
            }else{
                $this->ajaxReturn(array('status' => 0, 'msg' => '激活失败', 'data' => ''));
            }
        }else{
             $this->ajaxReturn(array('status' => 0, 'msg' => '该点位不需要激活', 'data' => ''));
        }
    }
    public function soft_del(){
        $id = I('id/d');
        $fenhong_info = M('users_fenhong')->where(array('fenhong_id'=>$id))->find();
        if (empty($fenhong_info)) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '未找到该点位', 'data' => ''));
        }
        if ($fenhong_info['fenhong_end_state'] == 1) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '该点位已失效', 'data' => ''));
        }elseif($fenhong_info['fenhong_end_state'] == -1){
            $this->ajaxReturn(array('status' => 0, 'msg' => '该点位已被软删除', 'data' => ''));
        }
        $rs = M('users_fenhong')->where(array('fenhong_id'=>$id))->save(array('fenhong_end_state'=>-1));
        if ($rs) {
            $this->ajaxReturn(array('status' => 1, 'msg' => '软删除成功', 'data' => ''));
        }else{
            $this->ajaxReturn(array('status' => 0, 'msg' => '软删除失败', 'data' => ''));
        }
    }
    public function cancel_active(){
        $id = I('id/d');
        $fenhong_info = M('users_fenhong')->where(array('fenhong_id'=>$id))->find();
        if (empty($fenhong_info)) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '未找到该点位', 'data' => ''));
        }
        if ($fenhong_info['fenhong_end_state'] == 1) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '该点位已经失效', 'data' => ''));
        }
        if ($fenhong_info['fenhong_active_state'] == 0) {
            $this->ajaxReturn(array('status' => 0, 'msg' => '该点位还未被激活', 'data' => ''));
        }
        if ($fenhong_info['fenhong_active_times'] == 0 ) {
            if ($fenhong_info['fenhong_active_state'] == 1) {
                $rs = M('users_fenhong')->where(array('fenhong_id'=>$id))->save(array('fenhong_active_state'=>0));
                if ($rs) {
                    $this->ajaxReturn(array('status' => 1, 'msg' => '解除激活成功', 'data' => ''));
                }else{
                    $this->ajaxReturn(array('status' => 0, 'msg' => '解除激活失败', 'data' => ''));
                }
            }else{
                 $this->ajaxReturn(array('status' => 0, 'msg' => '解除激活失败2', 'data' => ''));
            }
        }else{
            $this->ajaxReturn(array('status' => 0, 'msg' => '该点位激活已经开始，无法取消', 'data' => ''));
        }
    }

    public function fenhong_log(){
        return $this->fetch();
    }
    public function ajaxfenhong_log(){
        $condition = array();
       /* I('mobile') ? $condition['fenhong_user_mobile'] = I('mobile') : false;*/
        // $sort_order = I('order_by').' '.I('sort');
        $model = M('account_log');
        $count = $model->where($condition)->count();
        $Page  = new AjaxPage($count,10);
        //  搜索条件下 分页赋值
        foreach($condition as $key=>$val) {
            $Page->parameter[$key]   =   urlencode($val);
        }
        $userList = $model->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order('log_id desc')->select();
        //dump($userList);die;
        $show = $Page->show();
        $this->assign('userList',$userList);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('pager',$Page);
        return $this->fetch();
    }

    public function user_guanxi(){

        return $this->fetch();
    
    }


    public function getTree(){

        $id = intval(I('id'));
        $return = array();
        if ($id >= 0) {
            $user_info  = M('users')->field('user_id,mobile,user_bank_name,fenhong_points_num,is_vip')->where(array('recommend_id' => $id))->select();
            foreach ($user_info as $key => $value) {
                $count = M('users')->where(array('recommend_id'=>$value['user_id']))->count();
                if ($count <= 0) {
                    $isParent = false;
                }else{
                    $isParent = true;
                }
              if ($value['is_vip'] == '1') {
                    $is_vip = 'VIP';
                }else{
                    $is_vip = '未激活';
                }
              
                $return[] = array(
                    'id'=>$value['user_id'],
                    'name'=> $value['mobile'].'('.$is_vip.') '.($value['fenhong_points_num']*1500) ." ",
                    'isParent'=>$isParent,
                    );
            }
            echo json_encode($return);
            exit();
        }
        /*else{
        }
        $nu_list= array();
        $data = $this->down_user(0,$nu_list);
        var_dump($data);exit();
        echo "[{ id:'011',   name:'n1',  isParent:true},{ id:'022',   name:'n2',  isParent:false},{ id:'032',  name:'n3',  isParent:true},{ id:'04',   name:'n4',  isParent:false}]";exit();*/
    }



    public function new_tree(){

        $user_id = I('post.mobile');
        //dump($user_id);
        $info = M('users')->where('mobile='."'$user_id'")->find();
        if($info != ''){

            $_SESSION['table_user_id'] = $info['user_id'];
        }
        return $this->fetch();
    }


    public function new_getTree(){

        if(empty($_SESSION['table_user_id'])){
            $id = intval(I('id'));
        }else{

            $id = $_SESSION['table_user_id'];
        }

        $return = array();

        if( $id >= 0 ){

           // $user_info = M('users')->field('user_id,nickname,first_leader,second_leader,third_leader,dianzibi')->where('first_leader = '.$id)->select();
            $user_info  = M('users')->field('user_id,mobile,user_bank_name,fenhong_points_num,is_vip')->where(array('recommend_id' => $id))->select();
            foreach ($user_info as $key => $value) {
                $count = M('users')->where(array('recommend_id'=>$value['user_id']))->count();
                if ($count <= 0) {
                    $isParent = false;
                }else{
                    $isParent = true;
                }
                if ($value['is_vip'] == '1') {
                    $is_vip = 'VIP';
                }else{
                    $is_vip = '未激活';
                }
                $return[] = array(
                    'id'=>$value['user_id'],
                    'name'=> $value['mobile'].'('.$is_vip.') '.($value['fenhong_points_num']*1500) ." ",
                    'isParent'=>$isParent,
                );
            }
            $_SESSION['table_user_id'] = null;
            echo json_encode($return);
            exit();
        }
    }
    //获取下级所有会员
    private function down_user($uid, &$nu_list = array()){
        $db_user   = M('users');
        $user_list = array();
        $user_list = $db_user->field('user_id')->where(array('recommend_id' => $uid))->select();
        if (is_array($user_list) && !empty($user_list)) {
            $nu_list = array_merge($nu_list, $user_list);
            foreach ($user_list as $key => $val) {
                $this->down_user($val['user_id'], $nu_list);
            }
        }
        return $nu_list;
    }

    public function user_group(){
        if (I('mobile')) {
            $this->assign('temp_mobile',I('mobile'));
        }else{
            $this->assign('temp_mobile','');
        }

        return $this->fetch();
    }
    public function ajaxuser_group(){
        // 搜索条件
        $condition = array();
        I('mobile') ? $mobile = I('mobile') : false;
        if (I('mobile')) {
            $find_info = M('users')->where(array('mobile'=>I('mobile')))->find();
            $condition['recommend_id'] = $find_info['user_id'];
            // var_dump($condition);
            // exit();    

        }else{
            $condition['is_service'] = 1;
        }

        $model = M('users');
        $count = $model->where($condition)->count();
        $Page  = new AjaxPage($count,10);
        //  搜索条件下 分页赋值
        foreach($condition as $key=>$val) {
            $Page->parameter[$key]   =   urlencode($val);
        }
        
        $userList = $model->where($condition)->order($sort_order)->limit($Page->firstRow.','.$Page->listRows)->select();
                
        $user_id_arr = get_arr_column($userList, 'user_id');
        if(!empty($user_id_arr))
        {
            $first_leader = DB::query("select first_leader,count(1) as count  from __PREFIX__users where first_leader in(".  implode(',', $user_id_arr).")  group by first_leader");
            $first_leader = convert_arr_key($first_leader,'first_leader');
            
            $second_leader = DB::query("select second_leader,count(1) as count  from __PREFIX__users where second_leader in(".  implode(',', $user_id_arr).")  group by second_leader");
            $second_leader = convert_arr_key($second_leader,'second_leader');            
            
            $third_leader = DB::query("select third_leader,count(1) as count  from __PREFIX__users where third_leader in(".  implode(',', $user_id_arr).")  group by third_leader");
            $third_leader = convert_arr_key($third_leader,'third_leader');            
        }

        foreach ($userList as $key => $value) {
            $all_num = $this->get_all_num($value['user_id']);
            $all = array_sum($all_num);

            $max_index = array_search(max($all_num), $all_num);

            $userList[$key]['all_money'] = $all*1500;

            $userList[$key]['qdzg'] = ($all - $all_num[$max_index])*1500;
        }
        $this->assign('first_leader',$first_leader);
        $this->assign('second_leader',$second_leader);
        $this->assign('third_leader',$third_leader);                                
        $show = $Page->show();
        $this->assign('userList',$userList);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('pager',$Page);
        return $this->fetch();
    }

    public function  get_all_num($user_id){
        static $array = array();
        //获取线下成员
        $data = M('users')->where('recommend_id='.$user_id)->select();
        if(!empty($data)){
            foreach ($data as $k=>$v){
                $array[] = $v['fenhong_points_num'];
                $this->get_all_num($v['user_id']);
            }
        }
        return $array;
    }


    public function export_recharge(){
        $where = array();
        $type = I('type');
        if ($type == 1) {
            //今日确认到账的的充值订单
            $jin_time = strtotime(date('Y-m-d'));
            $where['pay_time'] = array(array('lt',$jin_time+24*3600),array('gt',$jin_time),'and');
        }elseif ($type == 2) {
            //昨日确认内到账的订单
            $where['pay_time'] = array(array('lt',$jin_time),array('gt',$jin_time-24*3600),'and');
        }

        $orderList = Db::name('recharge')->field("*,FROM_UNIXTIME(ctime,'%Y-%m-%d') as create_time,FROM_UNIXTIME(pay_time,'%Y-%m-%d') as sure_time")->where($where)->order('pay_time desc')->select();

        $strTable ='<table width="500" border="1">';
        $strTable .= '<tr>';
        $strTable .= '<td style="text-align:center;font-size:12px;width:120px;">充值编号</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="100">会员编号</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">充值手机</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">充值单号</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">充值金额</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">申请时间</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">确认时间</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付方式</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付状态</td>';
        $strTable .= '</tr>';
        if(is_array($orderList)){
            $region = get_region_list();
            foreach($orderList as $k=>$val){
                $strTable .= '<tr>';
                $strTable .= '<td style="text-align:center;font-size:12px;">&nbsp;'.$val['order_id'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['user_id'].' </td>';               
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['nickname'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['order_sn'].' </td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['account'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['create_time'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['sure_time'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['pay_name'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$this->pay_status[$val['pay_status']].'</td>';
                $strTable .= '</tr>';
            }
        }
        $strTable .='</table>';
        unset($orderList);
        downloadExcel($strTable,'recharge');
        exit();
    }

    public function export_recharg2(){
        $where = array();
        $type = I('type');
        if ($type == 1) {
            //今日确认到账的的充值订单
            $jin_time = strtotime(date('Y-m-d'));
            $where['pay_time'] = array(array('lt',$jin_time+24*3600),array('gt',$jin_time),'and');
        }elseif ($type == 2) {
            //昨日确认内到账的订单
            $where['pay_time'] = array(array('lt',$jin_time),array('gt',$jin_time-24*3600),'and');
        }

        $orderList = Db::name('recharge')->field("*,FROM_UNIXTIME(ctime,'%Y-%m-%d') as create_time,FROM_UNIXTIME(pay_time,'%Y-%m-%d') as sure_time")->where($where)->order('pay_time desc')->select();

        $strTable ='<table width="500" border="1">';
        $strTable .= '<tr>';
        $strTable .= '<td style="text-align:center;font-size:12px;width:120px;">充值编号</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="100">会员编号</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">充值手机</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">充值单号</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">充值金额</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">申请时间</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">确认时间</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付方式</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付状态</td>';
        $strTable .= '</tr>';
        if(is_array($orderList)){
            $region = get_region_list();
            foreach($orderList as $k=>$val){
                $strTable .= '<tr>';
                $strTable .= '<td style="text-align:center;font-size:12px;">&nbsp;'.$val['order_id'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['user_id'].' </td>';               
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['nickname'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['order_sn'].' </td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['account'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['create_time'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['sure_time'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['pay_name'].'</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">'.$this->pay_status[$val['pay_status']].'</td>';
                $strTable .= '</tr>';
            }
        }
        $strTable .='</table>';
        unset($orderList);
        downloadExcel($strTable,'recharge');
        exit();
    }


    public function every_week_return(){
        $config2 = array(
            0=>200,
            1=>100,
            2=>100,
            3=>100,
            4=>100,
            5=>100,
            6=>100,
            7=>200,
            8=>200,
            9=>400,
            );
        $ben_week_start = mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
        $time = time();
        $j = 0;
        $condition2=array();
        $condition2['fenhong_active_state'] = 0;
        $condition2['fenhong_times'] = array('lt',10);
        $condition2['fenhong_nowtime'] = array('lt',$ben_week_start);
        $condition2['fenhong_starttime'] = array('lt',$time);
        $fenhong_info2 = M('users_fenhong')->where($condition2)->limit(30)->select();

        if (!empty($fenhong_info2) && is_array($fenhong_info2)) {
            foreach ($fenhong_info2 as $key2 => $value2) {
                $data2= array();
                $data2['fenhong_nowtime'] = time();
                $data2['fenhong_times'] = array('exp','fenhong_times+1');
                if ($value2['fenhong_times'] == 9 && $value2['fenhong_end_state'] == 0) {
                    $data2['fenhong_endtime'] = time();
                    $data2['fenhong_active_starttime'] = $ben_week_start+7*24*3600;
                }
                $res = M('users_fenhong')->where(array('fenhong_id'=>$value2['fenhong_id']))->save($data2);
                if ($res) {
                    $rd = accountLog($value2['fenhong_user_id'], 0, 0, "分红点位".$value2['fenhong_id']."的第".($value2['fenhong_times'] + 1).'周分红，获得分红',0,0,'',$config2[$value2['fenhong_times']],1);
                    if ($rd) {
                        $j++;
                    }
                }
            }
        }
        exit("共处理".count($fenhong_info2)."个点位");
    }
    public function every_week_return_active(){
        $config = array(
            0=>100,
            1=>100,
            2=>100,
            3=>100,
            4=>100,
            5=>100,
            6=>100,
            7=>200,
            8=>200,
            9=>300,
            );
        $ben_week_start = mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
        $time = time();
        $i = 0;
        $condition=array();
        $condition['fenhong_active_state'] = 1;
        $condition['fenhong_active_times'] = array('lt',10);
        $condition['fenhong_active_nowtime'] = array('lt',$ben_week_start);
        $condition['fenhong_active_starttime'] = array('lt',$time);
        $fenhong_info = M('users_fenhong')->where($condition)->limit(30)->select();
        if (!empty($fenhong_info) && is_array($fenhong_info)) {
            foreach ($fenhong_info as $key => $value) {
                $data =array();
                $data['fenhong_active_nowtime'] = time();
                $data['fenhong_active_times'] = array('exp','fenhong_active_times+1');
                if ($value['fenhong_active_times'] == 9) {
                    $data['fenhong_end_state'] = 1;
                    $data['fenhong_active_endtime'] = time();
                }
                $res = M('users_fenhong')->where(array('fenhong_id'=>$value['fenhong_id']))->save($data);
                if ($res) {
                    $rd = accountLog($value['fenhong_user_id'], 0, 0, "分红点位".$value['fenhong_id']."的激活状态第".($value['fenhong_active_times'] + 1+7).'周分红，获得积分',0,0,'',$config[$value['fenhong_active_times']],2);
                    if ($rd) {
                        $i++;
                    }
                }
            }
        }
        exit("共处理".count($fenhong_info)."个点位");
    }
	public function tongji_baodanbi(){
        $timegap = I('timegap');
        $nickname = I('mobile');
        $map = array();
        if($timegap){
            $gap = explode(' - ', $timegap);
            $begin = $gap[0];
            $end = $gap[1];
            $map['change_time'] = array('between',array(strtotime($begin),strtotime($end)));
        }
        if($nickname){
            $user_info = M('users')->where(array('mobile'=>$nickname))->field('user_id')->find();
            if (!empty($user_info['user_id'])) {
                $map['user_id'] = $user_info['user_id'];
            }
        }
        $map['baodanbi'] = array('neq',0);
        $count = M('account_log')->where($map)->count();

        $in_condition = array();
        if (!empty($map['change_time'])) {
            $in_condition['change_time'] = $map['change_time'];
        }else{
            $ben_week_start = mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
            $ben_week_end = $ben_week_start+(7*24*3600);
            $in_condition['change_time'] = array(array('gt',$ben_week_start),array('lt',$ben_week_end),'and');
        }
        if (!empty($map['user_id'])) {
          $in_condition['user_id'] = $map['user_id'];
        }
        $in_condition['baodanbi'] = array('gt',0);

        $in_money = M("account_log")->where($in_condition)->sum('baodanbi');

        $this->assign("in_money",$in_money);

        $out_condition = array();
        if (!empty($map['change_time'])) {
            $out_condition['change_time'] = $map['change_time'];
        }else{
            $ben_week_start = mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
            $ben_week_end = $ben_week_start+(7*24*3600);
            $out_condition['change_time'] = array(array('gt',$ben_week_start),array('lt',$ben_week_end),'and');
        }
        if (!empty($map['user_id'])) {
          $out_condition['user_id'] = $map['user_id'];
        }
        $out_condition['baodanbi'] = array('lt',0);

        $out_money = M("account_log")->where($out_condition)->sum('baodanbi');

        $this->assign("in_money",$in_money);
        $this->assign("out_money",$out_money);

        //每周返钱返多少
        $every_condition = array();
        if (!empty($map['change_time'])) {
            $every_condition['change_time'] = $map['change_time'];
        }else{
            $ben_week_start = mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
            $ben_week_end = $ben_week_start+(7*24*3600);
            $every_condition['change_time'] = array(array('gt',$ben_week_start),array('lt',$ben_week_end),'and');
        }
        if (!empty($map['user_id'])) {
          $every_condition['user_id'] = $map['user_id'];
        }
        $every_condition['baodanbi'] = array('gt',0);
        $this_condition = $every_condition;
        $every_condition['log_type'] = 2;
        $every_count = M('account_log')->where($every_condition)->sum('baodanbi');
        $this->assign("every_count",$every_count);
        $this_condition['log_type'] = 36;
        $this_count = M('account_log')->where($this_condition)->sum('baodanbi');
        $this->assign("this_count",$this_count);
        //管理员播币多少

        $page = new Page($count);
        $lists  = M('account_log')->where($map)->order('log_id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('page',$page->show());
        $this->assign('pager',$page);
        $this->assign('lists',$lists);
        return $this->fetch();
    }
}