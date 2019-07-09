<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Query extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Query_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
	}

	/**
	*基于openid获得个人的全部信息获取信息
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

	/*
	 * @长期用于测试的接口
	 * @2019.4.21
	 */
	public function test(){
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxebacdf49b73f338b&secret=4daee58bdef643b2ff1b29e8c219715a';
        $data = file_get_contents($url);

	    $this->json(
	        $data
        );
    }

    /*
     * 获得token
     */
    public function gettoken(){
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxebacdf49b73f338b&secret=4daee58bdef643b2ff1b29e8c219715a';
        $data = file_get_contents($url);

        $this->json(
            $data
        );
    }

    /*
     * 东南大学院系专业返回接口
     */
    public function department(){
        $data['1'] = '建筑学院';
        $data['2'] = '机械工程学院';
        $data['3'] = '能源与环境学院';
        $data['4'] = '信息科学与工程学院';
        $data['5'] = '土木工程学院';
        $data['6'] = '电子科学与工程学院';
        $data['7'] = '数学学院';
        $data['8'] = '自动化学院';
        $data['9'] = '物理学院';
        $data['10'] = '生物科学与医学工程学院';
        $data['11'] = '材料科学与工程学院';
        $data['12'] = '人文学院';
        $data['13'] = '经济管理学院';
        $data['14'] = '电气工程学院';
        $data['15'] = '外国语学院';
        $data['16'] = '化学化工学院';
        $data['17'] = '交通学院';
        $data['18'] = '仪器科学与工程学院';
        $data['19'] = '艺术学院';
        $data['20'] = '法学院';
        $data['21'] = '医学院';
        $data['22'] = '公共卫生学院';
        $data['23'] = '吴健雄学院';
        $data['24'] = '海外教育学院';
        $data['25'] = '软件学院';
        $data['26'] = '微电子学院';
        $data['27'] = '马克思主义学院';
        $data['28'] = '网络空间安全学院';
        $data['29'] = '人工智能学院';
        $data['30'] = '东南大学雷恩研究生学院';
        $data['31'] = '东南大学—蒙纳士大学苏州联合研究生院';
        $data['32'] = '其他';

        $this->json(
            $data
        );
    }
    /*
     * 文件上传测试内容
     *
     */

    public function upload()
    {
        $config['upload_path']      = '../../public/upload';
        $config['allowed_types']    = 'gif|jpg|png';
        $config['max_size']     = 100;
        $config['max_width']    = 1024;
        $config['max_height']   = 768;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('userfile'))
        {
            $data = 'fail';
        }else{
            $data = array('upload_data' => $this->upload->data());
        }

        $this->json(
            $data
        );
    }


}