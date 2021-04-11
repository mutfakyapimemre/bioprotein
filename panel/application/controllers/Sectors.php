<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sectors extends MY_Controller
{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "sectors_v";
        $this->load->model("sector_model");
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }
    public function index()
    {
        $viewData = new stdClass();
        $items = $this->sector_model->get_all(
            array(),
            "rank ASC"
        );
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function datatable()
    {
        $items = $this->sector_model->getRows(
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
                    <a class="dropdown-item updateSectorBtn" href="javascript:void(0)" data-url="' . base_url("sectors/update_form/$item->id") . '"><i class="fa fa-pen mr-2"></i>Kaydı Düzenle</a>
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="sectorsTable" data-url="' . base_url("sectors/delete/$item->id") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);
            $sharedAt = json_decode($item->sharedAt, true);
            foreach ($sharedAt as $key => $value) {
                $sharedAt[$key] = turkishDate("d F Y, l H:i:s", $value);
            }
            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("sectors/isActiveSetter/{$item->id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';
            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $item->title, $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), json_encode($sharedAt, JSON_UNESCAPED_UNICODE), $proccessing);
        }



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->sector_model->rowCount(),
            "recordsFiltered" => $this->sector_model->countFiltered([], (!empty($_POST) ? $_POST : [])),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);
    }




    public function new_form()
    {
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->settings = $this->general_model->get_all("settings", null, null, ["isActive" => 1]);
        $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }
    public function save()
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"]) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Sektör Kaydı Yapılırken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $getRank = $this->sector_model->rowCount();
            foreach ($_FILES["img_url"]["name"] as $key => $value) :
                if ($value == "") :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Sektör Eklenirken Hata Oluştu. Sektör Görseli Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                    die();
                endif;
                $image = upload_picture("img_url", "uploads/$this->viewFolder", $key);
                if ($image["success"]) :
                    $data["img_url"][$key] = $image["file_name"];
                else :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Sektör Kaydı Yapılırken Hata Oluştu. Sektör Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                    die();
                endif;
            endforeach;
            $data = makeJSON($data);
            $data["isActive"] = 1;
            $data["rank"] = $getRank + 1;
            $insert = $this->sector_model->add($data);
            if ($insert) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Sektör Başarıyla Eklendi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Sektör Eklenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function update_form($id)
    {
        $viewData = new stdClass();
        $item = $this->sector_model->get(
            array(
                "id" => $id
            )
        );
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
        $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }
    public function update($id)
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"]) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Sektör Güncelleştirilirken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $sector = $this->sector_model->get(["id" => $id]);
            foreach (json_decode($sector->img_url, true) as $key => $value) :
                $data["img_url"][$key] = $value;
            endforeach;
            foreach ($_FILES["img_url"]["name"] as $key => $value) :
                if (!empty($value)) :
                    $image = upload_picture("img_url", "uploads/$this->viewFolder", $key);
                    if ($image["success"]) :
                        $data["img_url"][$key] = $image["file_name"];
                        if (!empty($sector->img_url)) :
                            foreach (json_decode($sector->img_url, true) as $key => $value) :
                                if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$value}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$value}")) :
                                    unlink(FCPATH . "uploads/{$this->viewFolder}/{$value}");
                                endif;
                            endforeach;
                        endif;
                    else :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Sektör Güncelleştirilirken Hata Oluştu. Sektör Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                        die();
                    endif;
                endif;
            endforeach;
            $data = makeJSON($data);
            $update = $this->sector_model->update(["id" => $id], $data);
            if ($update) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Sektör Başarıyla Güncelleştirildi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Sektör Güncelleştirilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;

        endif;
    }
    public function delete($id)
    {
        $sector = $this->sector_model->get(["id" => $id]);
        if (!empty($sector)) :
            $delete = $this->sector_model->delete(["id"    => $id]);
            if ($delete) :
                if (!empty($sector->img_url)) :
                    foreach (json_decode($sector->img_url, true) as $key => $value) :
                        if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$value}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$value}")) :
                            unlink(FCPATH . "uploads/{$this->viewFolder}/{$value}");
                        endif;
                    endforeach;
                endif;
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Sektör Başarıyla Silindi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Sektör Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function rankSetter()
    {
        $rows = $this->input->post("rows");

        foreach ($rows as $row) {
            $this->sector_model->update(
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
            if ($this->sector_model->update(["id" => $id], ["isActive" => $isActive])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı"]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı"]);
            }
        }
    }
}
