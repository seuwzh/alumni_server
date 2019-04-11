<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Query extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Query_model');
	}

	/**
	*基于openid获得个人的全部信息 
	*高危
	*仅用于测试
	*/

	public function getbase(){

		$openid = $this->input->get('openid');

		if($openid === NULL){
			$data['status'] = '500';
            $data['message'] = 'error_no_openid';
		}else{
			$data['status'] = '200';
            $data['message'] = 'ok';
            $data['data']['base'] = $this->Query_model->get_base($openid);
            $data['data']['personal'] = $this->Query_model->get_personal($openid);

		}

		$this->json(
      		$data
    	);
	}

	/*
	*这个才是getall
	*
	*/
	public function getall(){

		$openid = $this->input->get('openid');

		if($openid === NULL){
			$data['status'] = '500';
            $data['message'] = 'error_no_openid';
		}else{
			$data['status'] = '200';
            $data['message'] = 'ok';
            $data['data']['base'] = $this->Query_model->get_base($openid);
            $data['data']['personal'] = $this->Query_model->get_personal($openid);
            $data['data']['education'] = $this->Query_model->get_education($openid);
            $data['data']['work'] = $this->Query_model->get_work($openid);
            $data['data']['friend'] = $this->Query_model->get_friend($openid);

		}

		$this->json(
      		$data
    	);
	}

	/**
	*查询指定openid的教育经历
	*
	*/
	public function geteducation(){

		$openid = $this->input->get('openid');

		if($openid === NULL){
			$data['status'] = '500';
            $data['message'] = 'error_no_openid';
            $data['data'] = [];
		}else{
			$data['status'] = '200';
            $data['message'] = 'ok';
            $data['data'] = $this->Query_model->get_education($openid);

		}

		//getall函数的返回类型
		$this->json(
      		$data
    	);
	}

	/**
	*查询指定openid的工作经历
	*
	*/
	public function getwork(){

		$openid = $this->input->get('openid');

		if($openid === NULL){
			$data['status'] = '500';
            $data['message'] = 'error_no_openid';
            $data['data'] = [];
		}else{
			$data['status'] = '200';
            $data['message'] = 'ok';
            $data['data'] = $this->Query_model->get_work($openid);

		}

		$this->json(
      		$data
    	);
	}

	/*
	*查询是否已经有该用户
	*/

	public function detect(){

		$openid = $this->input->get('openid');

		$data['status'] = '200';
		$data['message'] = $this->Query_model->detect($openid);

		$this->json(
      		$data
    	);
	}

}