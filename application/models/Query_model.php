<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Query_model extends CI_Model{

	public function __construct(){
		$this->load->database();
	}

    //openid最最基本的信息
	public function get_base($openid){

        $data = $this->db->get_where('PersonalInfor',array('openid'=>$openid))->result_array(0);

        return $data;
    }

    //openid的教育信息
    public function get_education($openid){

        $data = $this->db
        ->from('Education')
        ->where(array('openid'=>$openid))
        ->get()->result_array();

        return $data;
    }

    //openid的工作信息
    public function get_work($openid){

        $data = $this->db->get_where('Work',array('openid'=>$openid))->result_array();

        return $data;
    }

    //openid的个人隐私信息
    public function get_personal($openid){

        $data = $this->db->get_where('Personal',array('openid'=>$openid))->result_array(0);

        return $data;
    }

    //openid的朋友信息
    public function get_friend($openid){

        $data = $this->db->get_where('Friend',array('openid'=>$openid))->result_array();
        return $data;
    }

    //检测是否存在
    public function detect($openid){

        $query = $this->db->get_where('PersonalInfor',array('openid'=>$openid));

        if($query->result_array()===[]){
            $data = 'no';
        }else{
            $data = 'ok';
        }

        return $data;
    }
}