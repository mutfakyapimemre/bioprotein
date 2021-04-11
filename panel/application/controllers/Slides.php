<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Slides extends MY_Controller
{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "slides_v";
        $this->load->model("slide_model");
        $this->load->helper("text");
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }
    public function datatable()
    {
        $items = $this->slide_model->getRows(
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
                    <a class="dropdown-item updateSlideBtn" href="javascript:void(0)" data-url="' . base_url("slides/update_form/$item->id") . '"><i class="fa fa-pen mr-2"></i>Kaydı Düzenle</a>
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="sliderTable" data-url="' . base_url("slides/delete/$item->id") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);
            $sharedAt = json_decode($item->sharedAt, true);
            foreach ($sharedAt as $key => $value) {
                $sharedAt[$key] = turkishDate("d F Y, l H:i:s", $value);
            }
            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("slides/isActiveSetter/{$item->id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';
            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $item->title, $item->description,  $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), json_encode($sharedAt, JSON_UNESCAPED_UNICODE), $proccessing);
        }



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->slide_model->rowCount(),
            "recordsFiltered" => $this->slide_model->countFiltered([], (!empty($_POST) ? $_POST : [])),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);
    }
    public function index()
    {
        $viewData = new stdClass();
        $items = $this->slide_model->get_all(
            array(),
            "rank ASC"
        );
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function new_form()
    {
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->settings = $this->general_model->get_all("settings", null, null, ["isActive" => 1]);
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }
    public function save()
    {
        $data = rClean($this->input->post());
        foreach ($data["title"] as $key => $value) :
            if (!empty($data["allowButton"][$key]) && $data["allowButton"][$key] == "on" && (empty($data["button_caption"][$key]) || empty($data["button_url"][$key]))) :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Slayt Kaydı Yapılırken Hata Oluştu. Buton Başlık ve URL Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
                die();
            else :
                $data["allowButton"][$key] = (!empty($data["allowButton"][$key]) && $data["allowButton"][$key] == "on") ? 1 : 0;
            endif;
        endforeach;
        $getRank = $this->slide_model->rowCount();
        foreach ($_FILES["img_url"]["name"] as $key => $value) :
            if ($value == "") :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Slayt Eklenirken Hata Oluştu. Slayt Görseli Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                die();
            endif;
            $image = upload_picture("img_url", "uploads/$this->viewFolder", $key);
            if ($image["success"]) :
                $data["img_url"][$key] = $image["file_name"];
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Slayt Kaydı Yapılırken Hata Oluştu. Slayt Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                die();
            endif;
        endforeach;
        foreach ($data["description"] as $key => $value) :
            $data["description"][$key] = $_POST["description"][$key];
        endforeach;
        $data = makeJSON($data);
        $data["isActive"] = 1;
        $data["rank"] = $getRank + 1;
        $insert = $this->slide_model->add($data);
        if ($insert) :
            echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Slayt Başarıyla Eklendi."]);
        else :
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Slayt Eklenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
        endif;
    }
    public function update_form($id)
    {
        $viewData = new stdClass();
        $item = $this->slide_model->get(
            array(
                "id"    => $id,
            )
        );
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;
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
        $slide = $this->slide_model->get(["id" => $id]);
        foreach ($data["title"] as $key => $value) :
            if (!empty($data["allowButton"][$key]) && $data["allowButton"][$key] == "on" && (empty($data["button_caption"][$key]) || empty($data["button_url"][$key]))) :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Slayt Kaydı Yapılırken Hata Oluştu. Buton Başlık ve URL Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
                die();
            else :
                $data["allowButton"][$key] = (!empty($data["allowButton"][$key]) && $data["allowButton"][$key] == "on") ? 1 : 0;
            endif;
        endforeach;
        foreach (json_decode($slide->img_url, true) as $key => $value) :
            $data["img_url"][$key] = $value;
        endforeach;
        foreach ($_FILES["img_url"]["name"] as $key => $value) :
            if (!empty($value)) :
                $image = upload_picture("img_url", "uploads/$this->viewFolder", $key);
                if ($image["success"]) :
                    $data["img_url"][$key] = $image["file_name"];
                    if (!empty($slide->img_url)) :
                        foreach (json_decode($slide->img_url, true) as $key => $value) :
                            if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$value}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$value}")) :
                                unlink(FCPATH . "uploads/{$this->viewFolder}/{$value}");
                            endif;
                        endforeach;
                    endif;
                else :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Slayt Güncelleştirilirken Hata Oluştu. Slayt Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                    die();
                endif;
            endif;
        endforeach;
        foreach ($data["description"] as $key => $value) :
            $data["description"][$key] = $_POST["description"][$key];
        endforeach;

        $data = makeJSON($data);
        $update = $this->slide_model->update(["id" => $id], $data);
        if ($update) :
            echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Slayt Başarıyla Güncelleştirildi."]);
        else :
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Slayt Güncelleştirilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
        endif;
    }
    public function delete($id)
    {
        $slide = $this->slide_model->get(["id" => $id]);
        if (!empty($slide)) :
            $delete = $this->slide_model->delete(["id"    => $id]);
            if (!empty($slide->img_url)) :
                foreach (json_decode($slide->img_url, true) as $key => $value) :
                    if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$value}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$value}")) :
                        unlink(FCPATH . "uploads/{$this->viewFolder}/{$value}");
                    endif;
                endforeach;
            endif;
            if ($delete) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Slayt Başarıyla Silindi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Slayt Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function rankSetter()
    {
        $rows = $this->input->post("rows");

        foreach ($rows as $row) {
            $this->slide_model->update(
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
            if ($this->slide_model->update(["id" => $id], ["isActive" => $isActive])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı"]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı"]);
            }
        }
    }
}
