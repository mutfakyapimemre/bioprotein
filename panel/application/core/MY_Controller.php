<?php
class MY_Controller extends CI_Controller{

    public function __construct(){
        parent::__construct();
        if (!isAllowedViewModule()){
            redirect(base_url());
        }
        $request= $this->uri->segment(2);
        if($request=="update_form" && !isAllowedUpdateViewModule()){
            redirect(base_url());
        }
        if($request=="new_form" && !isAllowedWriteViewModule()){
            redirect(base_url());
        }
        if($request=="delete" && !isAllowedDeleteViewModule()){
            redirect(base_url());
        }

    }
}

?>
