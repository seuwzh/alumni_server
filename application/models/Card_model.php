<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Card_model extends CI_Model{

	public function __construct(){
		$this->load->database();
	}

    private function get_work($cardid){
        $query = $this->db->get_where('Work',array('openid'=>$cardid))->result_array();
        return $query;
    }

    private function get_education($cardid){
        $query = $this->db->get_where('Education',array('openid'=>$cardid))->result_array();
        return $query;
    }

    private function get_personal($cardid){

        $query = $this->db->get_where('Personal',array('openid'=>$cardid))->result_array();
        return $query;
    }

    private function get_personalinfor($cardid){

        $query = $this->db->get_where('PersonalInfor',array('openid'=>$cardid))->result_array();
        return $query;
    }


    public function read_card($openid,$cardid){

        $query = $this->db
        ->select('state')
        ->get_where('Friend',array('openid'=>$openid,'friendid'=>$cardid))->result_array();

        if($query[0]['state'] === '1'){

            $data['education'] = $this->get_education($cardid);
            $data['work'] = $this->get_work($cardid);
            $data['personal'] = $this->get_personal($cardid);
            $data['personalinfor'] = $this->get_personalinfor($cardid);
            $data['state'] = $query[0]['state'];

        }elseif ($query[0]['state'] === '0' or $query[0]['state'] === null) {

            $data['education'] = $this->get_education($cardid);
            $data['work'] = $this->get_work($cardid);
            $data['personalinfor'] = $this->get_personalinfor($cardid);
            $data['state'] = '0';

        }elseif ($query[0]['state'] === '4') {

            $this->db->delete('Friend',array('openid'=>$openid,'friendid'=>$cardid));
            $this->db->insert('Friend',array('openid'=>$openid,'friendid'=>$cardid,'state'=>'0'));

            $data['education'] = $this->get_education($cardid);
            $data['work'] = $this->get_work($cardid);
            $data['personalinfor'] = $this->get_personalinfor($cardid);
            $data['state'] = '4';
        }elseif ($query[0]['state'] === '5') {

            $this->db->delete('Friend',array('openid'=>$openid,'friendid'=>$cardid));
            $this->db->insert('Friend',array('openid'=>$openid,'friendid'=>$cardid,'state'=>'1'));

            $data['education'] = $this->get_education($cardid);
            $data['work'] = $this->get_work($cardid);
            $data['personal'] = $this->get_personal($cardid);
            $data['personalinfor'] = $this->get_personalinfor($cardid);
            $data['state'] = '5';
        }elseif ($query[0]['state'] === '2') {

            $data['education'] = $this->get_education($cardid);
            $data['work'] = $this->get_work($cardid);
            $data['personal'] = $this->get_personal($cardid);
            $data['personalinfor'] = $this->get_personalinfor($cardid);
            $data['state'] = '2';
        }elseif ($query[0]['state'] === '3') {

            $data['education'] = $this->get_education($cardid);
            $data['work'] = $this->get_work($cardid);
            $data['personalinfor'] = $this->get_personalinfor($cardid);
            $data['state'] = '3';
        }else{
            $data = 'error';
        }

        return $data;

    }

}