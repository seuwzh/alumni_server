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

        $self_city =
        $this->db
        ->get_where('PersonalInfor',array('openid'=>$openid))->result_array();
        $city = $self_city[0]['city'];


        $self_department =
        $this->db
        ->get_where('Education',array('openid'=>$openid))->result_array();
        $department = $self_department[0]['department'];

        /*
         * 新版本
         * @query_city: 用于模糊搜索城市相同的人
         * @query_department: 用于搜索相同学院的人
         * @temp_data: 用于暂时存储信息结果
         */

        $openid_array = array();

        $query_city =
            $this->db
            ->limit($limit,$page)
            ->from('PersonalInfor')
            ->like('PersonalInfor.city',$city,'both')
            ->get()->result_array();

        $query_department =
            $this->db
                ->limit($limit,$page)
                ->from('Education')
                ->like('Education.department',$department,'both')
                ->get()->result_array();

        foreach ($query_department as $key){
            $temp['openid'] = $key['openid'];
            $temp['same'] = '同学院';
            array_push($openid_array,$temp);
        }

        foreach ($query_city as $key){
            $temp['openid'] = $key['openid'];
            $temp['same'] = '同城市';
            array_push($openid_array,$temp);
        }

        array_unique($openid_array);

        /*
         * 获取数据，为count服务
         */

        $count_city =
            $this->db
                ->from('PersonalInfor')
                ->like('PersonalInfor.city',$city,'both')
                ->count_all_results();

        $count_department =
            $this->db
                ->from('Education')
                ->like('Education.department',$department,'both')
                ->count_all_results();



        //获得朋友的openid列表，在首页屏蔽这些内容

        $friend_array_before =
            $this->db
                ->select('Friend.friendid')
                ->from('Friend')
                ->where(array('Friend.openid'=>$openid,'Friend.state'=>'1'))
                ->get()->result_array();

        $friend_array = array();

        foreach ($friend_array_before as $key){
            array_push($friend_array,$key['friendid']);
        }

        //数组格式，用于存放信息和进行array_push
        $temp_data = array();

        foreach ($openid_array as $key){

            $temp_openid = $key['openid'];
            //array_push($temp_data,$temp_openid);

            //查询是否有工作，决定是否返回工作
            $query_work = $this->db->get_where('Work',array('openid'=>$temp_openid))->result_array();

            if($query_work===[]){
                $temp =
                    $this->db
                    ->select(array('PersonalInfor.openid','PersonalInfor.real_name','PersonalInfor.head_url','PersonalInfor.descr','Education.school','Education.department','PersonalInfor.city'))
                    ->from('PersonalInfor')
                    ->where(array('PersonalInfor.openid'=>$temp_openid))//查询的条件
                    ->join('Education','Education.openid =  PersonalInfor.openid')
                    ->order_by('Education.end_year','DESC')
                    ->get()->result_array();

                if($temp[0]['openid']===$openid) continue;

                if(in_array($temp[0]['openid'],$friend_array)) continue;

                if($temp[0] !== []) $temp[0]['same'] = $key['same'];

                array_push($temp_data,$temp[0]);

            }else{
                $temp =
                    $this->db
                        ->select(array('PersonalInfor.openid','PersonalInfor.real_name','PersonalInfor.head_url','PersonalInfor.descr','Education.school','Education.department','PersonalInfor.city','Work.company','Work.job'))
                        ->from('PersonalInfor')
                        ->where(array('PersonalInfor.openid'=>$temp_openid))//查询的条件
                        ->join('Education','Education.openid =  PersonalInfor.openid')
                        ->join('Work','Work.openid =  PersonalInfor.openid')
                        ->order_by('Work.end_year','DESC')
                        ->get()->result_array();

                if($temp[0]['openid']===$openid) continue;

                if(in_array($temp[0]['openid'],$friend_array)) continue;

                if($temp[0] !== []) $temp[0]['same'] = $key['same'];

                array_push($temp_data,$temp[0]);
            }

        }

        $temp_data = array_unique($temp_data,SORT_REGULAR);
        shuffle($temp_data);

        $data['count'] =$count_city+$count_department;

        $data['list'] = array_values($temp_data);


        return $data;
    }

}