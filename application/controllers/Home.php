<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Home_model');
	}

	/*
	*获取首页内容
	*
	*/
	public function similar(){

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
        	$data['data'] = $this->Home_model->get_cards($openid,$page,$limit);
        }

		$this->json(
      		$data
    	);
	}

	/**
	*校友新闻
	*/

	public function news(){

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
        	$data['data'] = $this->Home_model->get_news($openid,$page,$limit);
        }

		$this->json(
      		$data
    	);
	}

}