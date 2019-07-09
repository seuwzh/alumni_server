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

    private function deal_content($openid){

        $query_work = $this->db->get_where('Work',array('openid'=>$openid))->result_array();

        if($query_work===[]){
            $result =
                $this->db
                    ->select(array('PersonalInfor.openid','PersonalInfor.real_name','PersonalInfor.head_url','PersonalInfor.descr','Education.school','Education.department','PersonalInfor.city'))
                    ->from('PersonalInfor')
                    ->where(array('PersonalInfor.openid'=>$openid))//查询的条件
                    ->join('Education','Education.openid =  PersonalInfor.openid')
                    ->order_by('Education.end_year','DESC')
                    ->get()->result_array();

        }else{
            $result =
                $this->db
                    ->select(array('PersonalInfor.openid','PersonalInfor.real_name','PersonalInfor.head_url','PersonalInfor.descr','Education.school','Education.department','PersonalInfor.city','Work.company','Work.job'))
                    ->from('PersonalInfor')
                    ->where(array('PersonalInfor.openid'=>$openid))//查询的条件
                    ->join('Education','Education.openid =  PersonalInfor.openid')
                    ->join('Work','Work.openid =  PersonalInfor.openid')
                    ->order_by('Work.end_year','DESC')
                    ->get()->result_array();

        }

        return $result;
    }

    private function deal_all($temp_data){

        $openid_all = array();
        $deal = array();

        foreach ($temp_data as $key){
            $temp_openid = $key['openid'];
            array_push($openid_all,$temp_openid);
        }

        $openid_array = array_values(array_unique($openid_all));

        foreach ($openid_array as $temp_openid){

            $temp = $this->deal_content($temp_openid);

            array_push($deal,$temp[0]);

        }

        return $deal;

    }

    //查找学校 
    public function search_school($content,$page,$limit){

        $data['status'] = '200';
        $data['message'] = 'ok';

        $temp_count = $this->db->from('Education')->like('school',$content,'both')->get()->result_array();
        $temp_data = $this->db->from('Education')->like('school',$content,'both')->limit($limit,$page)->get()->result_array();

        $deal = $this->deal_all($temp_data);

        $data['deal'] = $deal;
        $data['temp_data'] = $temp_data;

        $data['data']['content'] = $deal;
        $data['data']['count'] = count($temp_count,0);

        return $data;
    }

    //查找姓名
    public function search_name($content,$page,$limit){

        $data['status'] = '200';
        $data['message'] = 'ok';

        $temp_count = $this->db->from('PersonalInfor')->like('real_name',$content,'both')->get()->result_array();
        $temp_data = $this->db->from('PersonalInfor')->like('real_name',$content,'both')->limit($limit,$page)->get()->result_array();

        $deal = $this->deal_all($temp_data);

        $data['data']['content'] = $deal;
        $data['data']['count'] = count($temp_count,0);

        return $data;
    }

    //查找公司
    public function search_company($content,$page,$limit){
        
        $data['status'] = '200';
        $data['message'] = 'ok';


        $temp_count = $this->db->from('Work')->like('company',$content,'both')->get()->result_array();
        $temp_data = $this->db->from('Work')->like('company',$content,'both')->limit($limit,$page)->get()->result_array();

        $deal = $this->deal_all($temp_data);

        $data['data']['content'] = $deal;
        $data['data']['count'] = count($temp_count,0);

        return $data;
    }

    //查找岗位
    public function search_job($content,$page,$limit){
        
        $data['status'] = '200';
        $data['message'] = 'ok';


        $temp_count = $this->db->from('Work')->like('job',$content,'both')->get()->result_array();
        $temp_data = $this->db->from('Work')->like('job',$content,'both')->limit($limit,$page)->get()->result_array();

        $deal = $this->deal_all($temp_data);

        $data['data']['content'] = $deal;
        $data['data']['count'] = count($temp_count,0);

        return $data;
    }

    //查找学院
    public function search_department($content,$page,$limit){
        
        $data['status'] = '200';
        $data['message'] = 'ok';


        $temp_count = $this->db->from('Education')->like('department',$content,'both')->get()->result_array();
        $temp_data = $this->db->from('Education')->like('department',$content,'both')->limit($limit,$page)->get()->result_array();

        $deal = $this->deal_all($temp_data);

        $data['data']['content'] = $deal;
        $data['data']['count'] = count($temp_count,0);

        return $data;
    }

    //查找描述
    public function search_descr($content,$page,$limit){
        
        $data['status'] = '200';
        $data['message'] = 'ok';


        $temp_count = $this->db->from('PersonalInfor')->like('descr',$content,'both')->get()->result_array();
        $temp_data = $this->db->from('PersonalInfor')->like('descr',$content,'both')->limit($limit,$page)->get()->result_array();

        $deal = $this->deal_all($temp_data);

        $data['data']['content'] = $deal;
        $data['data']['count'] = count($temp_count,0);

        return $data;
    }

    //查找城市
    public function search_city($content,$page,$limit){
        
        $data['status'] = '200';
        $data['message'] = 'ok';


        $temp_count = $this->db->from('PersonalInfor')->like('city',$content,'both')->get()->result_array();
        $temp_data = $this->db->from('PersonalInfor')->like('city',$content,'both')->limit($limit,$page)->get()->result_array();

        $deal = $this->deal_all($temp_data);

        $data['data']['content'] = $deal;
        $data['data']['count'] = count($temp_count,0);

        return $data;
    }



   
}