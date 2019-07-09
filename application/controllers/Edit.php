<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Edit_model');
		//全部使用post请求
	}


	/**
	*用于编辑or第一次插入个人信息-系统自动判定情况 
	*/
	public function editbase(){

		//处理post请求中的内容


		$openid = $this->input->post('openid');
    	$head_url = $this->input->post('head_url');
    	$real_name = $this->input->post('real_name');
    	$gender = $this->input->post('gender');
    	$descr = $this->input->post('descr');
    	$city = $this->input->post('city');
    	$birth = $this->input->post('birth');
    	$phone = $this->input->post('phone');
    	$wechat = $this->input->post('wechat');
    	$email = $this->input->post('email');

        //判断默认头像、手机、微信、email
        if($head_url===NULL){
            $head_url = 'https://www.zimotiontec.cn/head/headurl.png';
        }
        if($phone===NULL){
            $phone = '暂未填写';
        }
        if($wechat===NULL){
            $wechat = '暂未填写';
        }
        if($email===NULL){
            $email = '暂未填写';
        }

        //判断openid是否合理
        if($openid===NULL){
            $data['status'] = '500';
            $data['message'] = 'miss openid';
        }else if($real_name===NULL or $gender===NULL or $descr===NULL or $city===NULL or $birth===NULL){
            $data['status'] = '500';
            $data['message'] = 'name/gender/descr/city/birth havs to be perfect';
        }else{
            $data = $this->Edit_model->editbase($openid,$head_url,$real_name,$gender,$descr,$city,$birth,$phone,$wechat,$email);
        }
		$this->json(
			$data
    	);
	}

	/**
	*用于编辑or第一次插入个人信息-系统自动判定情况 
	*/
	public function editfirst(){

		//处理post请求中的内容

		$openid = $this->input->post('openid');//openid
    	$head_url = $this->input->post('head_url');//头像，支持默认头像
    	$real_name = $this->input->post('real_name');//名字
    	$gender = $this->input->post('gender');//性别
    	$descr = $this->input->post('descr');//描述
    	$city = $this->input->post('city');//城市
    	$birth = $this->input->post('birth');//生日
    	$phone = $this->input->post('phone');//不填写则显示“暂未填写”
    	$wechat = $this->input->post('wechat');//同上
    	$email = $this->input->post('email');//同上
    	$education_school = $this->input->post('education_school');//教育相关
    	$education_background = $this->input->post('education_background');
    	$education_department = $this->input->post('education_department');
    	$education_profession = $this->input->post('education_profession');
    	$education_start_year = $this->input->post('education_start_year');
    	$education_end_year = $this->input->post('education_end_year');
    	$work_company = $this->input->post('work_company');//工作相关
    	$work_job = $this->input->post('work_job');

        //判断默认头像
        if($head_url===NULL){
            if($gender==='2'){
                $head_url = 'https://www.zimotiontec.cn/head/2.png';
            }else if($gender === '1'){
                $head_url = 'https://www.zimotiontec.cn/head/1.png';
            }else{
                $head_url = 'https://www.zimotiontec.cn/head/headurl.png';
            }
        }
        if($phone===NULL){
            $phone = '未填写';
        }
        if($wechat===NULL){
            $wechat = '未填写';
        }
        if($email===NULL){
            $email = '未填写';
        }
        if($birth===NULL){
            $birth = '未填写';
        }
        if($education_profession===NULL){
            $profession = '未填写';
        }


    	if($openid===NULL){
    		$data['status'] = '500';
            $data['message'] = 'miss openid';
    	}else if($real_name===NULL or $gender===NULL or $descr===NULL or $city===NULL or $birth===NULL){
            $data['status'] = '500';
            $data['message'] = 'name/gender/descr/city/birth has to be perfect';
        }else if($education_school===NULL){
    		$data['status'] = '500';
            $data['message'] = 'miss school';
    	}else{
    		$data = $this->Edit_model->editfirst($openid,$head_url,$real_name,$gender,$descr,$city,$birth,$phone,$wechat,$email,
    		$education_school,$education_background,$education_department,$education_profession,$education_start_year,$education_end_year,$work_company,$work_job);
    	}

		$this->json(
			$data
    	);
	}

	/**
	*用于增加一条教育经历
	*
	*/
	public function editeducation(){

		//处理post请求中的内容
		$openid = $this->input->post('openid');
		$num = $this->input->post('num');
    	$school = $this->input->post('school');
    	$background = $this->input->post('background');
    	$department = $this->input->post('department');
    	$profession = $this->input->post('profession');
    	$start_year = $this->input->post('start_year');
    	$end_year = $this->input->post('end_year');

        if($profession===NULL){
            $profession = '未填写';
        }

    	if($openid===NULL){
    		$data['status'] = '500';
            $data['message'] = 'miss openid';
    	}else if($school===NULL){
            $data['status'] = '500';
            $data['message'] = 'miss school';
        }else{
    		$data = $this->Edit_model->addeducation($openid,$num,$school,$background,$department,$profession,$start_year,$end_year,$num);

    	}

		$this->json(
      		$data
    	);

	}

	/**
	*用于增加一条工作经历
	*
	*/
	public function editwork($openid=NULL,$num=NULL,$company=NULL,$job=NULL,$strat_year=NULL,$end_year=NULL){

		//处理post请求中的内容
		$openid = $this->input->post('openid');
		$num = $this->input->post('num');
    	$company = $this->input->post('company');
    	$job = $this->input->post('job');
    	$start_year = $this->input->post('start_year');
    	$end_year = $this->input->post('end_year');

    	if($openid===NULL){
    		$data['status'] = '500';
            $data['message'] = 'miss openid';
    	}else if($company===NULL){
            $data['status'] = '500';
            $data['message'] = 'miss company';
        }else{

    		$data = $this->Edit_model->addwork($openid,$num,$company,$job,$start_year,$end_year);
    	}

		$this->json(
      		$data
    	);

	}

	/**
	*用于删除一条工作经历
	*
	*/
	public function deletework($openid=NULL,$num=NULL){

		//处理post请求中的内容
		$openid = $this->input->post('openid');
    	$num = $this->input->post('num');

		if($openid === NULL or $num === NULL){
			$data['status'] = '500';
			$data['message'] = 'miss openid/num';
		}else{

			$data = $this->Edit_model->deletework($openid,$num);

		}

    	//返回成功与否的一个结果，data保存结果
		$this->json(
      		$data
    	);

	}


	/**
	*用于删除一条教育经历
	*
	*/
	public function deleteeducation($openid=NULL,$num=NULL){

		//处理post请求中的内容
		$openid = $this->input->post('openid');
    	$num = $this->input->post('num');

		if($openid === NULL or $num === NULL){
			$data['status'] = '500';
			$data['message'] = 'miss openid/num';
		}else{

			$data = $this->Edit_model->deleteeducation($openid,$num);
		}

    	//返回成功与否的一个结果，data保存结果
		$this->json(
      		$data
    	);

	}



}