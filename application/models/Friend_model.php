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

        $data['result'] = $this->db//查询的字段
        ->limit($limit,$page)
        ->select(array('Friend.friendid','PersonalInfor.real_name','PersonalInfor.head_url','PersonalInfor.city','Work.company','Work.job'))
        ->where(array('Friend.openid'=>$openid,'Friend.state'=>'1'))//查询的条件
        ->from('Friend')//连表的主表
        ->join('PersonalInfor','PersonalInfor.openid =  Friend.friendid')//连接表
        ->join('Personal','Personal.openid =  Friend.friendid')//连接表
        ->join('Work','Work.openid =  Friend.friendid')//连接表
        ->get()->result_array();//语句查询，切记->result_array()；必须的

        $data['count'] = $this->db
        ->select(array('Friend.friendid','PersonalInfor.real_name','PersonalInfor.head_url','PersonalInfor.city','Work.company','Work.job'))
        ->where(array('Friend.openid'=>$openid,'Friend.state'=>'1'))
        ->from('Friend')
        ->join('PersonalInfor','PersonalInfor.openid =  Friend.friendid')
        ->join('Personal','Personal.openid =  Friend.friendid')
        ->join('Work','Work.openid =  Friend.friendid')
        ->count_all_results();

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

        $this->db->delete('Friend',array('openid'=>$openid,'friendid'=>$friendid));
        $this->db->insert('Friend',array('openid'=>$openid,'friendid'=>$friendid,'state'=>'3'));

        $this->db->delete('Friend',array('openid'=>$friendid,'friendid'=>$openid));
        $this->db->insert('Friend',array('openid'=>$friendid,'friendid'=>$openid,'state'=>'2'));

    }

    public function agree($openid,$friendid){

        $this->db->delete('Friend',array('openid'=>$openid,'friendid'=>$friendid));
        $this->db->insert('Friend',array('openid'=>$openid,'friendid'=>$friendid,'state'=>'1'));

        $this->db->delete('Friend',array('openid'=>$friendid,'friendid'=>$openid));
        $this->db->insert('Friend',array('openid'=>$friendid,'friendid'=>$openid,'state'=>'1'));
        $this->db->insert('Friend',array('openid'=>$friendid,'friendid'=>$openid,'state'=>'5'));

    }

    public function refuse($openid,$friendid){

        $this->db->delete('Friend',array('openid'=>$openid,'friendid'=>$friendid));
        $this->db->insert('Friend',array('openid'=>$openid,'friendid'=>$friendid,'state'=>'0'));

        $this->db->delete('Friend',array('openid'=>$friendid,'friendid'=>$openid));
        $this->db->insert('Friend',array('openid'=>$friendid,'friendid'=>$openid,'state'=>'0'));
        $this->db->insert('Friend',array('openid'=>$friendid,'friendid'=>$openid,'state'=>'4'));

    }


    /*
    *这四个暂时被getionform替代了
    */
    /*public function get_inviting($openid){

        $data = $this->db
        ->select(array('Friend.friendid','PersonalInfor.real_name','PersonalInfor.head_url','Friend.time','Friend.state'))
        ->where(array('Friend.openid'=>$openid,'Friend.state'=>'3'))
        ->from('Friend')
        ->join('PersonalInfor','PersonalInfor.openid =  Friend.friendid')
        ->get()->result_array();
        return $data;
    }

    public function get_invited($openid){

        $data = $this->db
        ->select(array('Friend.friendid','PersonalInfor.real_name','PersonalInfor.head_url','Friend.time','Friend.state'))
        ->where(array('Friend.openid'=>$openid,'Friend.state'=>'2'))
        ->from('Friend')
        ->join('PersonalInfor','PersonalInfor.openid =  Friend.friendid')
        ->get()->result_array();
        return $data;
    }

    public function get_refused($openid){

        $data = $this->db
        ->select(array('Friend.friendid','PersonalInfor.real_name','PersonalInfor.head_url','Friend.time','Friend.state'))
        ->where(array('Friend.openid'=>$openid,'Friend.state'=>'4'))
        ->from('Friend')
        ->join('PersonalInfor','PersonalInfor.openid =  Friend.friendid')
        ->get()->result_array();
        return $data;
    }

    public function get_agreed($openid){

        $data = $this->db
        ->select(array('Friend.friendid','PersonalInfor.real_name','PersonalInfor.head_url','Friend.time','Friend.state'))
        ->where(array('Friend.openid'=>$openid,'Friend.state'=>'5'))
        ->from('Friend')
        ->join('PersonalInfor','PersonalInfor.openid =  Friend.friendid')
        ->get()->result_array();
        return $data;
    }*/



}