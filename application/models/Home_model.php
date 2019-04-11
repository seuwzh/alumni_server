<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Home_model extends CI_Model{

	public function __construct(){
		$this->load->database();
	}

    //openid最最基本的信息
	public function get_news($openid,$page,$limit){

        $data = 
        $this->db
        ->limit($limit,$page)
        ->get('News')
        ->result_array();

        return $data;
    }

    public function get_cards($openid,$page,$limit){

        $query_city = 
        $this->db
        ->get_where('PersonalInfor',array('openid'=>$openid))->result_array();
        $city = $query_city[0]['city'];


        $query_company = 
        $this->db
        ->get_where('Work',array('openid'=>$openid))->result_array();
        $company = $query_company[0]['company'];

        $data['data'] =
        $this->db
        ->select(array('PersonalInfor.openid','PersonalInfor.real_name','PersonalInfor.head_url','PersonalInfor.descr','Education.school','Education.department','PersonalInfor.city','Work.company','Work.job'))
        ->limit($limit,$page)
        ->from('PersonalInfor')
        ->like('city',$city,'both')
        ->join('Work','Work.openid =  PersonalInfor.openid')
        ->join('Education','Education.openid =  PersonalInfor.openid')
        ->get()->result_array();

        $data['count'] =
            $this->db
                ->from('PersonalInfor')
                ->or_like('Work.company',$company,'both')
                ->or_like('PersonalInfor.city',$city,'both')
                ->join('Work','Work.openid =  PersonalInfor.openid')
                ->join('Education','Education.openid =  PersonalInfor.openid')
                ->count_all_results();
        return $data;
    }

}