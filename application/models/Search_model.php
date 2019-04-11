<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Search_model extends CI_Model{

	public function __construct(){
		$this->load->database();
	}

    //直接查找，返回数目 
	public function search_direct($content){
        
        $data['status'] = '200';
        $data['message'] = 'ok'; 
        $data['data']['school'] = $this->db->from('Education')->like('school',$content,'both')->count_all_results();
        $data['data']['name'] = $this->db->from('PersonalInfor')->like('real_name',$content,'both')->count_all_results();
        $data['data']['company'] = $this->db->from('Work')->like('company',$content,'both')->count_all_results();
        $data['data']['job'] = $this->db->from('Work')->like('job',$content,'both')->count_all_results();
        $data['data']['department'] = $this->db->from('Education')->like('department',$content,'both')->count_all_results();
        $data['data']['descr'] = $this->db->from('PersonalInfor')->like('descr',$content,'both')->count_all_results();
        $data['data']['city'] = $this->db->from('PersonalInfor')->like('city',$content,'both')->count_all_results();

        return $data;
    }

    //查找学校 
    public function search_school($content,$page,$limit){

        $data['status'] = '200';
        $data['message'] = 'ok';
        $data['data']['count'] = $this->db->from('Education')->like('school',$content,'both')->count_all_results();
        $data['data']['content'] = 
        $this->db
        ->select(array('PersonalInfor.openid','PersonalInfor.real_name','Education.school','Education.department','PersonalInfor.city','Work.company','Work.job'))
        ->limit($limit,$page)
        ->from('Education')
        ->like('school',$content,'both')
        ->join('PersonalInfor','PersonalInfor.openid =  Education.openid')
        ->join('Work','Work.openid =  Education.openid')
        ->get()->result_array();

        return $data;
    }

    //查找姓名
    public function search_name($content,$page,$limit){

        $data['status'] = '200';
        $data['message'] = 'ok';
        $data['data']['count'] = $this->db->from('PersonalInfor')->like('real_name',$content,'both')->count_all_results();
        $data['data']['content'] = 
        $this
        ->db
        ->select(array('PersonalInfor.openid','PersonalInfor.real_name','Education.school','Education.department','PersonalInfor.city','Work.company','Work.job'))
        ->limit($limit,$page)
        ->from('PersonalInfor')
        ->like('real_name',$content,'both')
        ->join('Education','Education.openid =  PersonalInfor.openid')
        ->join('Work','Work.openid =  PersonalInfor.openid')
        ->get()->result_array();

        return $data;
    }

    //查找公司
    public function search_company($content,$page,$limit){
        
        $data['status'] = '200';
        $data['message'] = 'ok';
        $data['data']['count'] = $this->db->from('Work')->like('company',$content,'both')->count_all_results();
        $data['data']['content'] = 
        $this->db
        ->select(array('PersonalInfor.openid','PersonalInfor.real_name','Education.school','Education.department','PersonalInfor.city','Work.company','Work.job'))
        ->limit($limit,$page)
        ->from('Work')
        ->like('company',$content,'both')
        ->join('PersonalInfor','PersonalInfor.openid =  Work.openid')
        ->join('Education','Education.openid =  Work.openid')
        ->get()->result_array();

        return $data;
    }

    //查找岗位
    public function search_job($content,$page,$limit){
        
        $data['status'] = '200';
        $data['message'] = 'ok';
        $data['data']['count'] = $this->db->from('Work')->like('job',$content,'both')->count_all_results();
        $data['data']['content'] = 
        $this->db
        ->select(array('PersonalInfor.openid','PersonalInfor.real_name','Education.school','Education.department','PersonalInfor.city','Work.company','Work.job'))
        ->limit($limit,$page)
        ->from('Work')
        ->like('job',$content,'both')
        ->join('PersonalInfor','PersonalInfor.openid =  Work.openid')
        ->join('Education','Education.openid =  Work.openid')
        ->get()->result_array();

        return $data;
    }

    //查找学院
    public function search_department($content,$page,$limit){
        
        $data['status'] = '200';
        $data['message'] = 'ok';
        $data['data']['count'] = $this->db->from('Education')->like('department',$content,'both')->count_all_results();
        $data['data']['content'] = 
        $this->db
        ->select(array('PersonalInfor.openid','PersonalInfor.real_name','Education.school','Education.department','PersonalInfor.city','Work.company','Work.job'))
        ->limit($limit,$page)
        ->from('Education')
        ->like('department',$content,'both')
        ->join('PersonalInfor','PersonalInfor.openid =  Education.openid')
        ->join('Work','Work.openid =  Education.openid')
        ->get()->result_array();

        return $data;
    }

    //查找描述
    public function search_descr($content,$page,$limit){
        
        $data['status'] = '200';
        $data['message'] = 'ok';
        $data['data']['count'] = $this->db->from('PersonalInfor')->like('descr',$content,'both')->count_all_results();
        $data['data']['content'] = 
        $this->db
        ->select(array('PersonalInfor.openid','PersonalInfor.real_name','Education.school','Education.department','PersonalInfor.city','Work.company','Work.job'))
        ->limit($limit,$page)
        ->from('PersonalInfor')
        ->like('descr',$content,'both')
        ->join('Education','Education.openid =  PersonalInfor.openid')
        ->join('Work','Work.openid =  PersonalInfor.openid')
        ->get()->result_array();

        return $data;
    }

    //查找城市
    public function search_city($content,$page,$limit){
        
        $data['status'] = '200';
        $data['message'] = 'ok';
        $data['data']['count'] = $this->db->from('PersonalInfor')->like('city',$content,'both')->count_all_results();
        $data['data']['content'] = 
        $this->db
        ->select(array('PersonalInfor.openid','PersonalInfor.real_name','Education.school','Education.department','PersonalInfor.city','Work.company','Work.job'))
        ->limit($limit,$page)
        ->from('PersonalInfor')
        ->like('city',$content,'both')
        ->join('Education','Education.openid =  PersonalInfor.openid')
        ->join('Work','Work.openid =  PersonalInfor.openid')
        ->get()->result_array();

        return $data;
    }



   
}