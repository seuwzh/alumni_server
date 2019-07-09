<?php

class Upload extends CI_Controller {

    public function __construct()
    {
        parent::__construct();//调用父类中的构造函数
        $this->load->helper(array('form', 'url'));//加载辅助函数，帮助生成上传页面的form的起始标签
    }

    public function index()
    {
        $this->load->view('upload_form');//加载文件上传页面
    }

    public function do_upload()//执行上传的关键函数
    {
        $config['upload_path']      = './public/';//文件即将上传到的目录路径  ，注意这里经常出错
        $config['allowed_types']    = 'gif|jpg|png';//允许上的文件 MIME 类型
        $config['max_size']     = 100;//允许上传文件大小的最大值（单位 KB），设置为 0 表示无限制
        $config['max_width']        = 1024;//图片的最大宽度（单位为像素），设置为 0 表示无限制
        $config['max_height']       = 768;//图片的最小高度（单位为像素），设置为 0 表示无限制

        $this->load->library('upload', $config);//初始化文件上传类，其中$this->load->library('类名');

        if ( ! $this->upload->do_upload('userfile'))//如果不满足条件
        {
            $error = array('error' => $this->upload->display_errors());//获取错误信息
            print_r($error);//打印错误信息
            //$this->load->view('upload_form', $error);手册中给出的，未使用
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());//把上传文件的相关数据赋给$data变量

            $this->load->view('upload_success', $data);//加载上传成功页面，将上传文件的相关数据一并加载
        }
    }
}
?>