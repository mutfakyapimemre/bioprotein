<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public $viewFolder = "";
    //public $user;
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "dashboard_v";
        //$this->user = get_active_user();
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }
    public function index()
    {
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function makeWebp()
    {
        rWebp2(str_replace("panel\\", "", FCPATH) . "public/images");
        //rWebp2(str_replace("panel/","",FCPATH)."public/images");
    }

    public function phpinfo()
    {
        phpinfo();
    }
}
