<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menus extends MY_Controller
{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "menus_v";
        $this->load->model("menu_model");
        $this->load->model("page_model");
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }
    public function index()
    {
        $viewData = new stdClass();
        $items = $this->menu_model->get_all(
            array()
        );
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function datatable()
    {
        $items = $this->menu_model->getRows(
            [],
            $_POST
        );
        $data = $row = array();
        $i = (!empty($_POST['start']) ? $_POST['start'] : 0);

        foreach ($items as $item) {
            $i++;

            $proccessing = '
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary rounded-0 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    İşlemler
                </button>
                <div class="dropdown-menu rounded-0 dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item updateMenusBtn" href="javascript:void(0)" data-url="' . base_url("menus/update_form/$item->id") . '"><i class="fa fa-pen mr-2"></i>Kaydı Düzenle</a>
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="menusTable" data-url="' . base_url("menus/delete/$item->id") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);

            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("menus/isActiveSetter/{$item->id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';
            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $item->title,$item->position, $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), $proccessing);
        }



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->menu_model->rowCount(),
            "recordsFiltered" => $this->menu_model->countFiltered([], (!empty($_POST) ? $_POST : [])),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);
    }
    public function new_form()
    {
        $viewData = new stdClass();
        $top_menus = $this->menu_model->get_all();
        $viewData->top_menus = $top_menus;
        $pages = $this->page_model->get_all();
        $viewData->pages = $pages;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->settings = $this->general_model->get_all("settings", null, null, ["isActive" => 1]);
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }
    public function save()
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"] && (checkEmpty($data)["key"] != "url" && checkEmpty($data)["key"] != "page_id" && checkEmpty($data)["key"] != "top_id")) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Menü Kaydı Yapılırken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
            die();
        else :
            if (empty($data["url"]) && empty($data["page_id"])) :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Menü Güncelleştirilirken Hata Oluştu, Sayfa veya URL Bilgilerinden En Azından Bir Tanesi Doldurulmalıdır."]);
                die();
            endif;
            $getRank = $this->menu_model->rowCount();
            $data = makeJSON($data);
            $data["isActive"] = 1;
            $data["rank"] = $getRank + 1;
            $data["position"]= $this->input->post("position");
            $data["target"]= $this->input->post("target");
            $insert = $this->menu_model->add($data);
            if ($insert) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Menü Başarıyla Eklendi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Menü Eklenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function update_form($id)
    {
        $viewData = new stdClass();
        $item = $this->menu_model->get(
            array(
                "id"    => $id,
            )
        );
        $top_menus = $this->menu_model->get_all();
        $viewData->top_menus = $top_menus;
        $pages = $this->page_model->get_all();
        $viewData->pages = $pages;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
        foreach ($viewData->item as $key => $data) {
            if (isJson($data)) :
                $viewData->item->$key = json_decode($data);
            else :
                $viewData->item->$key = $data;
            endif;
        }
        $viewData->settings = $this->general_model->get_all("settings", null, null, ["isActive" => 1]);
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }
    public function update($id)
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"] && (checkEmpty($data)["key"] != "url" && checkEmpty($data)["key"] != "page_id" && checkEmpty($data)["key"] != "top_id")) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Menü Güncelleştirilirken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
            die();
        else :
            if (empty($data["url"]) && empty($data["page_id"])) :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Menü Güncelleştirilirken Hata Oluştu, Sayfa veya URL Bilgilerinden En Azından Bir Tanesi Doldurulmalıdır."]);
                die();
            endif;
            $data = makeJSON($data);
            $data["updatedAt"]= date("Y-m-d H:i:s");
            $data["position"]= $this->input->post("position");
            $data["target"]= $this->input->post("target");
            $update = $this->menu_model->update(["id" => $id], $data);
            if ($update) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Menü Başarıyla Güncelleştirildi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Menü Güncelleştirilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function delete($id)
    {
        $menu = $this->menu_model->get(["id" => $id]);
        if (!empty($menu)) :
            $delete = $this->menu_model->delete(["id"    => $id]);
            if ($delete) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Menü Başarıyla Silindi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Menü Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function rankSetter()
    {
        $rows = $this->input->post("rows");

        foreach ($rows as $row) {
            $this->menu_model->update(
                array(
                    "id" => $row["id"]
                ),
                array("rank" => $row["position"])
            );
        }
    }

    public function isActiveSetter($id)
    {
        if ($id) {
            $isActive = (intval($this->input->post("data")) === 1) ? 1 : 0;
            if ($this->menu_model->update(["id" => $id], ["isActive" => $isActive])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı"]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı"]);
            }
        }
    }
}
