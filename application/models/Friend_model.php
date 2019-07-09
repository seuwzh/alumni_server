<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Friend_model extends CI_Model{

	public function __construct(){
		$this->load->database();
	}

	/*public function get_all_friend($openid){

        $query = $this->db
        ->from('Friend')
        ->join('PersonalInfor','Friend.friendid=PersonalInfor.openid')
        ->where(array('Friend.openid'=>$openid))
        ->get();
        return $query->result_array();
    }*/

    public function get_friend($openid,$page,$limit){

        $friendid = $this->db//查询的字段
        ->where(array('Friend.openid'=>$openid,'Friend.state'=>'1'))//查询的条件
        ->from('Friend')//连表的主表
        ->select('Friend.friendid')
        ->limit($limit,$page)
        ->get()
        ->result_array();

        $temp_count = $this->db//查询的字段
        ->where(array('Friend.openid'=>$openid,'Friend.state'=>'1'))//查询的条件
        ->from('Friend')//连表的主表
        ->select('Friend.friendid')
        ->get()
        ->result_array();

        $temp_data = array();

        foreach ($friendid as $key){

            $temp_openid = $key['friendid'];

            $query_work = $this->db->get_where('Work',array('openid'=>$temp_openid))->result_array();

            if($query_work===[]){
                $temp = $this->db//查询的字段
                ->select(array('PersonalInfor.openid','PersonalInfor.real_name','PersonalInfor.head_url','PersonalInfor.city','Education.school','Education.department'))
                ->where(array('PersonalInfor.openid'=>$temp_openid))//查询的条件
                ->from('PersonalInfor')//连表的主表
                ->join('Education','Education.openid =  PersonalInfor.openid')//连接表
                ->order_by('Education.end_year','DESC')
                ->get()->result_array();//语句查询，切记->result_array()；必须的

                if($temp[0] !== []){
                    $temp[0]['company'] = $temp[0]['school'];
                    $temp[0]['job'] = $temp[0]['department'];
                    $temp[0]['friendid'] = $temp[0]['openid'];
                }else{
                    continue;
                }

                if($temp[0]['friendid']===null) continue;

                array_push($temp_data,$temp[0]);

            }else{
                $temp = $this->db//查询的字段
                ->select(array('PersonalInfor.openid','PersonalInfor.real_name','PersonalInfor.head_url','PersonalInfor.city','Work.company','Work.job'))
                ->where(array('PersonalInfor.openid'=>$temp_openid))//查询的条件
                ->from('PersonalInfor')//连表的主表
                ->join('Work','Work.openid =  PersonalInfor.openid')//连接表
                ->order_by('Work.end_year','DESC')
                ->get()->result_array();//语句查询，切记->result_array()；必须的

                if($temp[0] !== []){
                    $temp[0]['friendid'] = $temp[0]['openid'];
                }else{
                    continue;
                }

                if($temp[0]['friendid']===null) continue;


                array_push($temp_data,$temp[0]);
            }

        }

        $data['result'] = $temp_data;
        $data['count'] = count($temp_count,0);

        return $data;
    }


    public function get_inform($openid,$page,$limit){


        $state = array('5', '4', '2');

        $data['result'] = $this->db
        ->limit($limit,$page)
        ->select(array('Friend.friendid','PersonalInfor.real_name','PersonalInfor.head_url','Friend.time','Friend.state'))
        ->where('Friend.openid',$openid)
        ->where_in('state',$state)
        ->from('Friend')
        ->join('PersonalInfor','PersonalInfor.openid =  Friend.friendid')
        ->get()->result_array();

        $data['count'] = $this->db
        ->select(array('Friend.friendid','PersonalInfor.real_name','PersonalInfor.head_url','Friend.time','Friend.state'))
        ->where('Friend.openid',$openid)
        ->where_in('state',$state)
        ->from('Friend')
        ->join('PersonalInfor','PersonalInfor.openid =  Friend.friendid')
        ->count_all_results();

        return $data;
    }


    public function invite($openid,$friendid){

        $query = $this->db->get_where('PersonalInfor',array('openid'=>$friendid));

        if($query->result_array()===[]){
            $data['status'] = '501';
            $data['message'] = '用户不存在';
        }else{
            $query = $this->db
                ->select('state')
                ->get_where('Friend',array('openid'=>$openid,'friendid'=>$friendid))->result_array();

            if($query === [] or $query[0]['state'] === '0'){
                $this->db->delete('Friend',array('openid'=>$openid,'friendid'=>$friendid));
                $this->db->insert('Friend',array('openid'=>$openid,'friendid'=>$friendid,'state'=>'3'));

                $this->db->delete('Friend',array('openid'=>$friendid,'friendid'=>$openid));
                $this->db->insert('Friend',array('openid'=>$friendid,'friendid'=>$openid,'state'=>'2'));

                $data['status'] = '200';
                $data['message'] = 'success';
            }else{
                $data['status'] = '502';
                $data['message'] = '其他情况';
            }
        }

        return $data;

    }

    public function agree($openid,$friendid){

        $this->db->delete('Friend',array('openid'=>$openid,'friendid'=>$friendid));
        $this->db->insert('Friend',array('openid'=>$openid,'friendid'=>$friendid,'state'=>'1'));

        $this->db->delete('Friend',array('openid'=>$friendid,'friendid'=>$openid));
        $this->db->insert('Friend',array('openid'=>$friendid,'friendid'=>$openid,'state'=>'5'));

    }

    public function refuse($openid,$friendid){

        $this->db->delete('Friend',array('openid'=>$openid,'friendid'=>$friendid));
        $this->db->insert('Friend',array('openid'=>$openid,'friendid'=>$friendid,'state'=>'0'));

        $this->db->delete('Friend',array('openid'=>$friendid,'friendid'=>$openid));
        $this->db->insert('Friend',array('openid'=>$friendid,'friendid'=>$openid,'state'=>'4'));

    }


}