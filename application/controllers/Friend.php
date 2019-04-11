<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Friend extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Friend_model');
	}

	public function getfriend($openid=NULL,$page=NULL,$limit=NULL){

		$openid = $this->input->get('openid');
		$page = $this->input->get('page');
		$limit = $this->input->get('limit');

		if($openid === NULL or $page === NULL or $limit === NULL){
            $data['status'] = '500';
            $data['message'] = 'miss openid or page or limit';
        }else{
        	$data['status'] = '200';
            $data['message'] = 'ok';
            $page = ($page-1)*$limit;
        	$data['data'] = $this->Friend_model->get_friend($openid,$page,$limit);
        }

		//getall函数的返回类型
		$this->json(
      		$data
    	);
	}

	/**
	*基于openid获得通知信息
	* state = 4,5
	*/
	public function getinform($openid=NULL,$page=NULL,$limit=NULL){

		$openid = $this->input->get('openid');
		$page = $this->input->get('page');
		$limit = $this->input->get('limit');

		if($openid === NULL or $page === NULL or $limit === NULL){
            $data['status'] = '500';
            $data['message'] = 'miss openid or page or limit';
        }else{
        	$data['status'] = '200';
            $data['message'] = 'ok';
            $page = ($page-1)*$limit;
        	$data['data'] = $this->Friend_model->get_inform($openid,$page,$limit);
        }

		//getall函数的返回类型
		$this->json(
      		$data
    	);
	}

	/**
	*申请加为好友
	*/
	public function invite($openid=NULL,$friendid=NULL){

		$openid = $this->input->get('openid');
		$friendid = $this->input->get('friendid');
		
		if($openid === NULL or $friendid === NULL){
            $data['status'] = '500';
            $data['message'] = 'miss openid or friendid';
        }else{
        	$this->Friend_model->invite($openid,$friendid);
        	$data['status'] = '200';
            $data['message'] = 'success';
        }

		//getall函数的返回类型
		$this->json(
      		$data
    	);
	}

	/**
	*同意加为好友
	*/
	public function accept($openid=NULL,$friendid=NULL){

		$openid = $this->input->get('openid');
		$friendid = $this->input->get('friendid');
		
		if($openid === NULL or $friendid === NULL){
            $data['status'] = '500';
            $data['message'] = 'miss openid or friendid';
        }else{
        	$this->Friend_model->agree($openid,$friendid);
        	$data['status'] = '200';
            $data['message'] = 'success';
        }

		//getall函数的返回类型
		$this->json(
      		$data
    	);
	}

	/**
	*拒绝加为好友
	*/
	public function refuse($openid=NULL,$friendid=NULL){

		$openid = $this->input->get('openid');
		$friendid = $this->input->get('friendid');
		
		if($openid === NULL or $friendid === NULL){
            $data['status'] = '500';
            $data['message'] = 'miss openid or friendid';
        }else{
        	$this->Friend_model->refuse($openid,$friendid);
        	$data['status'] = '200';
            $data['message'] = 'success';
        }

		//getall函数的返回类型
		$this->json(
      		$data
    	);
	}


}