<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller{

	public function __construct(){

		parent::__construct();
		$this->load->model('Search_model');
		//$content_code = $this->uri->segment(3);
		//$way = $this->uri->segment(4);
	}

	/**
	*直接搜索所有信息 
	*/
	public function searchdirect(){

		$content_code = $this->input->get('content');

		if($content_code === NULL){
            $data['status'] = '500';
            $data['message'] = 'error_no_content';

        }else{
        	$content = urldecode($content_code);
    		$data = $this->Search_model->search_direct($content);
        }

		//返回成功与否的一个结果，data保存结果

		$this->json(
      		$data
    	);
	}

	public function search(){

		$content_code = $this->input->get('content');
		$way = $this->input->get('way');
		$page = $this->input->get('page');
		$limit = $this->input->get('limit');


		if($content_code===NULL or $way===NULL){
			$data['status'] = '500';
            $data['message'] = 'miss content or way';
		}else if($page===NULL or $limit===NULL){
			$data['status'] = '500';
            $data['message'] = 'miss page or limit';
		}else{

			$content = urldecode($content_code);
			$page = ($page-1)*$limit;

			//switch判断具体搜索什么方面的内容
			switch($way){
				case 'school': $data = $this->Search_model->search_school($content,$page,$limit);break;
				case 'name': $data = $this->Search_model->search_name($content,$page,$limit);break;
				case 'company': $data = $this->Search_model->search_company($content,$page,$limit);break;
				case 'job': $data = $this->Search_model->search_job($content,$page,$limit);break;
				case 'department': $data = $this->Search_model->search_department($content,$page,$limit);break;
				case 'city': $data = $this->Search_model->search_city($content,$page,$limit);break;
				case 'descr': $data = $this->Search_model->search_descr($content,$page,$limit);break;
				default: $data['message'] = 'wrong way';$data['status']='501';break;
			}
		}

		//返回成功与否的一个结果，data保存结果

		$this->json(
      		$data
    	);
	}


}