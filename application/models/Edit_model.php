<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Edit_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('string');
    }



    //增加or更新一条个人的基本信息 

    public function editbase($openid,$head_url,$real_name,$gender,$descr,$city,$birth,$phone,$wechat,$email){ 

        //查询一下当前openid的情况
        $query = $this->db->get_where('PersonalInfor',array('openid'=>$openid));

        if($query->result_array()===[]){
            $id = random_string('alnum',8);

            $this->db->insert('PersonalInfor',array('openid'=>$openid,'head_url'=>$head_url,
            'real_name'=>$real_name,'gender'=>$gender,'descr'=>$descr,'city'=>$city,
            'birth'=>$birth,'id'=>$id));

            $this->db->insert('Personal',array('openid'=>$openid,'phone'=>$phone,'wechat'=>$wechat,'email'=>$email));

            $data['status'] = '200';
            $data['message'] = 'success_insert_personalinfor';

            return $data;
        }else{
            $this->db->where(array('openid'=>$openid))->update('PersonalInfor',array('openid'=>$openid,
            'head_url'=>$head_url,'real_name'=>$real_name,'gender'=>$gender,'descr'=>$descr,
            'city'=>$city,'birth'=>$birth));
            $this->db->where(array('openid'=>$openid))->update('Personal',array('openid'=>$openid,'phone'=>$phone,
                'wechat'=>$wechat,'email'=>$email));

            $data['status'] = '200';
            $data['message'] = 'success_renew_personalinfor';

            return $data;

        }
    }

    public function editfirst($openid,$head_url,$real_name,$gender,$descr,$city,$birth,$phone,$wechat,$email,
        $education_school,$education_background,$education_department,$education_profession,$education_start_year,$education_end_year,$work_company,$work_job,$work_start_year,$work_end_year){

        $query = $this->db->get_where('PersonalInfor',array('openid'=>$openid));

        if($query->result_array()!=[]){

            $data['status'] = '502';
            $data['message'] = 'already exist';

        }else{
            $id = random_string('alnum',8);

            $this->db->insert('PersonalInfor',array('openid'=>$openid,'head_url'=>$head_url,
            'real_name'=>$real_name,'gender'=>$gender,'descr'=>$descr,'city'=>$city,
            'birth'=>$birth,'id'=>$id));

            $this->db->insert('Personal',array('openid'=>$openid,'phone'=>$phone,'wechat'=>$wechat,'email'=>$email));

            $this->db->insert('Education',array('openid'=>$openid,'school'=>$education_school,
            'background'=>$education_background,'department'=>$education_department,'profession'=>$education_profession,
            'start_year'=>$education_start_year,'end_year'=>$education_end_year));

            if($school!=NULL){
                $this->db->insert('Work',array('openid'=>$openid,'company'=>$work_company,'job'=>$work_job,'start_year'=>$work_start_year,'end_year'=>$work_end_year));
            }
            

            $data['status'] = '200';
            $data['message'] = 'success_insert_personalinfor';

        }

        return $data;

    }

    //增加一条教育经历
    public function addeducation($openid,$num,$school,$background,$department,$profession,$start_year,$end_year){ 

        if($num === NULL){

            $id = random_string('nozero',8);

            $this->db->insert('Education',array('openid'=>$openid,'school'=>$school,
            'background'=>$background,'department'=>$department,'profession'=>$profession,'start_year'=>$start_year,
            'end_year'=>$end_year,'num'=>$id));

            $data['status'] = '200';
            $data['message'] = 'success_insert_education';
            return $data;
        }
        else{
            $query = $this->db->get_where('Education',array('openid'=>$openid,'num'=>$num));

            if($query->result_array() === []){

                $data['status'] = '501';
                $data['message'] = 'wrong num';
                return $data;

            }else{

                $this->db->where(array('openid'=>$openid,'num'=>$num))->update('Education',array('openid'=>$openid,'school'=>$school,'background'=>$background,'department'=>$department,'profession'=>$profession,'start_year'=>$start_year,'end_year'=>$end_year));

                $data['status'] = '200';
                $data['message'] = 'success_renew_education';

                return $data;

            }

        }
    }

    //增加一条工作经历
    public function addwork($openid,$num,$company,$job,$start_year,$end_year){

        if($num === NULL){

            $id = random_string('nozero',8);

            $this->db->insert('Work',array('openid'=>$openid,'company'=>$company,'job'=>$job,'start_year'=>$start_year,'end_year'=>$end_year,'num'=>$id));

            $data['status'] = '200';
            $data['message'] = 'success_insert_work';
            return $data;
        }
        else{
            $query = $this->db->get_where('Work',array('openid'=>$openid,'num'=>$num));

            if($query->result_array() === []){

                $data['status'] = '501';
                $data['message'] = 'wrong num';
                return $data;

            }else{
                $this->db->where(array('openid'=>$openid,'num'=>$num))->update('Work',array('openid'=>$openid,'company'=>$company,'job'=>$job,'start_year'=>$start_year,'end_year'=>$end_year));

                $data['status'] = '200';
                $data['message'] = 'success_renew_work';
                return $data;
            }


        }
    }

    //删除一条工作经历
    public function deletework($openid,$num){

        $query = $this->db->get_where('Work',array('openid'=>$openid,'num'=>$num));

        if($query->result_array() === []){

            $data['status'] = '501';
            $data['message'] = 'wrong num';

        }else{
            $this->db->delete('Work',array('openid'=>$openid,'num'=>$num));
            $data['status'] = '200';
            $data['message'] = 'success_delete_work';
        }

        return $data;

    }

    //删除一条工作经历
    public function deleteeducation($openid,$num){

        $query = $this->db->get_where('Education',array('openid'=>$openid,'num'=>$num));

        if($query->result_array() === []){

            $data['status'] = '501';
            $data['message'] = 'wrong num';

        }else{
            $this->db->delete('Education',array('openid'=>$openid,'num'=>$num));
            $data['status'] = '200';
            $data['message'] = 'success_delete_work';
        }

        return $data;

    }


}