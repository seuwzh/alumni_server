<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Card_model');
	}


	public function readcard(){

		$openid = $this->input->get('openid');
		$cardid = $this->input->get('cardid');

		if($openid === NULL or $cardid === NULL){
			$data['status'] = '500';
            $data['message'] = 'miss openid or cardid';
		}else{
			$data['status'] = '200';
            $data['message'] = 'ok';
            $data['data'] = $this->Card_model->read_card($openid,$cardid);

		}

		//getall函数的返回类型
		$this->json(
      		$data
    	);
	}

}