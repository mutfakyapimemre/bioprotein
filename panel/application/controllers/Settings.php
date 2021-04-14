<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends MY_Controller
{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "settings_v";
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
        $this->load->model("settings_model");
    }

    public function index()
    {
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->languages = $this->general_model->get_all("languages");
        $viewData->item = $this->general_model->get("settings");
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function datatable()
    {
        $items = $this->settings_model->getRows(
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
                    <a class="dropdown-item updateSettingsBtn" href="javascript:void(0)" data-url="' . base_url("settings/update_form/$item->id") . '"><i class="fa fa-pen mr-2"></i>Kaydı Düzenle</a>
                    <a class="dropdown-item updateSettingsJsonbtn" href="javascript:void(0)" data-url="' . base_url("settings/json_form/$item->id") . '"><i class="fa fa-language mr-2"></i>Dil Sabitlerini Düzenle</a>
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="settingsTable" data-url="' . base_url("settings/delete/$item->id") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);

            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("settings/isActiveSetter/{$item->id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';
            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $item->company_name, $item->lang, $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), $proccessing);
        }



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->settings_model->rowCount(),
            "recordsFiltered" => $this->settings_model->countFiltered([], (!empty($_POST) ? $_POST : [])),
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
        $viewData->languages = $this->general_model->get_all("languages");
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function save()
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"] && (checkEmpty($data)["key"] == "phone_1" || checkEmpty($data)["key"] === "company_name" || checkEmpty($data)["key"] === "email")) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Kaydı Yapılırken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            if (empty($_FILES["logo"]["name"])) :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Eklenirken Hata Oluştu. Logo Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                die();
            endif;
            if (empty($_FILES["mobile_logo"]["name"])) :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Eklenirken Hata Oluştu. Mobil Logo Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                die();
            endif;
            if (empty($_FILES["favicon"]["name"])) :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Eklenirken Hata Oluştu. Favicon Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                die();
            endif;
            $logo = upload_picture("logo", "uploads/$this->viewFolder");
            $mobile_logo = upload_picture("mobile_logo", "uploads/$this->viewFolder");
            $favicon = upload_picture("favicon", "uploads/$this->viewFolder");
            $getRank = $this->settings_model->rowCount();
            if ($logo["success"]) :
                $data["logo"] = $logo["file_name"];
                if ($mobile_logo["success"]) :
                    $data["mobile_logo"] = $mobile_logo["file_name"];
                    if ($favicon["success"]) :
                        $data["address"] = $this->input->post("address");
                        $data["favicon"] = $favicon["file_name"];
                        $data["isActive"] = 1;
                        $data["rank"] = $getRank + 1;
                        $data["map"] = htmlspecialchars(html_entity_decode($this->input->post("map")));
                        $insert = $this->settings_model->add($data);
                        if ($insert) :
                            $content = file_get_contents(FCPATH . "assets/language/language.json", "r");
                            $create = fopen(FCPATH . "assets/language/" . $data["lang"] . ".json", "w");
                            $create = fwrite($create, $content);
                            echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ayar Başarıyla Eklendi."]);
                        else :
                            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Eklenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
                        endif;
                    else :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Eklenirken Hata Oluştu. Favicon Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                    endif;
                else :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Eklenirken Hata Oluştu. Mobil Logo Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                endif;
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Eklenirken Hata Oluştu. Logo Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }

    public function update_form($id)
    {
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->languages = $this->general_model->get_all("languages");
        $viewData->item = $this->general_model->get("settings", null, ["id" => $id]);
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function update($id)
    {
        $settings = $this->settings_model->get(["id" => $id]);
        if (!empty($settings)) :
            $data = rClean($this->input->post());
            if (checkEmpty($data)["error"] && (checkEmpty($data)["key"] == "phone_1" || checkEmpty($data)["key"] === "company_name" || checkEmpty($data)["key"] === "email")) :
                $key = checkEmpty($data)["key"];
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Güncelleştirilirken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
            else :
                if (!empty($_FILES["logo"]["name"])) :
                    $image = upload_picture("logo", "uploads/$this->viewFolder");
                    if ($image["success"]) :
                        $data["logo"] = $image["file_name"];
                        if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$settings->logo}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$settings->logo}")) :
                            unlink(FCPATH . "uploads/{$this->viewFolder}/{$settings->logo}");
                        endif;
                    else :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Güncelleştirilirken Hata Oluştu. Logo Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                        die();
                    endif;
                endif;
                if (!empty($_FILES["mobile_logo"]["name"])) :
                    $image = upload_picture("mobile_logo", "uploads/$this->viewFolder");
                    if ($image["success"]) :
                        $data["mobile_logo"] = $image["file_name"];
                        if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$settings->mobile_logo}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$settings->mobile_logo}")) :
                            unlink(FCPATH . "uploads/{$this->viewFolder}/{$settings->mobile_logo}");
                        endif;
                    else :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Güncelleştirilirken Hata Oluştu. Mobil Logo Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                        die();
                    endif;
                endif;
                if (!empty($_FILES["favicon"]["name"])) :
                    $image = upload_picture("favicon", "uploads/$this->viewFolder");
                    if ($image["success"]) :
                        $data["favicon"] = $image["file_name"];
                        if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$settings->favicon}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$settings->favicon}")) :
                            unlink(FCPATH . "uploads/{$this->viewFolder}/{$settings->favicon}");
                        endif;
                    else :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Güncelleştirilirken Hata Oluştu. Favicon Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                        die();
                    endif;
                endif;
                $data["address"] = $this->input->post("address");
                $data["map"] = $this->input->post("map");
                $update = $this->general_model->update("settings", ["id" => $id], $data);
                if ($update) :
                    echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ayar Başarıyla Güncelleştirildi."]);
                else :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Güncelleştirilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
                endif;
            endif;
        endif;
    }

    public function json_form($id)
    {
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "json";
        $viewData->item = $this->general_model->get("settings", null, ["id" => $id]);
        if (!file_exists(FCPATH . "assets/language/" . $viewData->item->lang . ".json")) :
            $content = file_get_contents(FCPATH . "assets/language/language.json", "r");
            $create = fopen(FCPATH . "assets/language/" . $viewData->item->lang . ".json", "w");
            $create = fwrite($create, $content);
        endif;
        $viewData->content = json_decode(file_get_contents(FCPATH . "assets/language/" . $viewData->item->lang . ".json", "r"));
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }

    public function update_json($id)
    {
        $item = $this->general_model->get("settings", null, ["id" => $id]);
        $data = $this->input->post();
        $create = fopen(FCPATH . "assets/language/" . $item->lang . ".json", "w");
        $create = fwrite($create, json_encode($data, JSON_UNESCAPED_UNICODE));
        if ($create) :
            echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Dil Sabitleri Başarıyla Güncelleştirildi."]);
        else :
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Dil Sabitleri Güncelleştirilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
        endif;
    }

    public function uploadImage()
    {
        $image = upload_picture("file", "uploads/tinyMCE");
        if ($image["success"]) {
            $filename = $image["file_name"];
            echo json_encode(['location' => base_url("uploads/tinyMCE/{$filename}")]);
        } else {
            // Notify editor that the upload failed
            header("HTTP/1.1 500 Server Error");
        }
    }
    public function delete($id)
    {
        $settings = $this->settings_model->get(["id" => $id]);
        if (!empty($settings)) :
            $delete = $this->settings_model->delete(["id" => $id]);
            if ($delete) :
                if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$settings->logo}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$settings->logo}")) :
                    unlink(FCPATH . "uploads/{$this->viewFolder}/{$settings->logo}");
                endif;
                if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$settings->mobile_logo}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$settings->mobile_logo}")) :
                    unlink(FCPATH . "uploads/{$this->viewFolder}/{$settings->mobile_logo}");
                endif;
                if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$settings->favicon}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$settings->favicon}")) :
                    unlink(FCPATH . "uploads/{$this->viewFolder}/{$settings->favicon}");
                endif;
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ayar Başarıyla Silindi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ayar Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }

    public function rankSetter()
    {
        $rows = $this->input->post("rows");

        foreach ($rows as $row) {
            $this->settings_model->update(
                array(
                    "id" => $row["id"]
                ),
                array("rank" => $row["position"] + 1)
            );
        }
    }
}
