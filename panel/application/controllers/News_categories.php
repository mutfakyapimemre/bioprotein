<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News_categories extends MY_Controller
{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "news_categories_v";
        $this->load->model("news_category_model");
        $this->load->model("news_model");
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }
    public function index()
    {
        $viewData = new stdClass();
        $items = $this->news_category_model->get_all(
            array()
        );
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function datatable()
    {
        $items = $this->news_category_model->getRows(
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
                    <a class="dropdown-item updateNewsCategoryBtn" href="javascript:void(0)" data-url="' . base_url("news_categories/update_form/$item->id") . '"><i class="fa fa-pen mr-2"></i>Kaydı Düzenle</a>
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="newsCategoryTable" data-url="' . base_url("news_categories/delete/$item->id") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);

            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("news_categories/isActiveSetter/{$item->id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';
            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $item->title, $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), $proccessing);
        }



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->news_category_model->rowCount(),
            "recordsFiltered" => $this->news_category_model->countFiltered([], (!empty($_POST) ? $_POST : [])),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);
    }
    public function new_form()
    {
        $viewData = new stdClass();
        $item = $this->news_category_model->get_all();
        $viewData->categories = $item;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->settings = $this->general_model->get_all("settings", null, null, ["isActive" => 1]);
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }
    public function save()
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"]) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Haber Kategorisi Kaydı Yapılırken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $getRank = $this->news_category_model->rowCount();
            if (!empty($_FILES)) :
                foreach ($_FILES["img_url"]["name"] as $key => $value) :
                    if ($value == "") :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Haber Kategorisi Eklenirken Hata Oluştu. Haber Görseli Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                        die();
                    endif;
                    $image = upload_picture("img_url", "uploads/$this->viewFolder", $key);
                    if ($image["success"]) :
                        $data["img_url"][$key] = $image["file_name"];
                    else :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Haber Kategorisi Kaydı Yapılırken Hata Oluştu. Haber Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                        die();
                    endif;
                endforeach;
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Haber Kategorisi Kaydı Yapılırken Hata Oluştu. Haber Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                die();
            endif;
            foreach ($data["title"] as $key => $value) :
                $data["seo_url"][$key] = seo($value . "-" . time());
            endforeach;
            $data = makeJSON($data);
            $data["isActive"] = 1;
            $data["rank"] = $getRank + 1;
            $insert = $this->news_category_model->add($data);
            if ($insert) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Haber Kategorisi Başarıyla Eklendi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Haber Kategorisi Eklenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function update_form($id)
    {
        $viewData = new stdClass();
        $item = $this->news_category_model->get(
            array(
                "id"    => $id,
            )
        );
        $category = $this->news_category_model->get_all();
        $viewData->categories = $category;
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
        if (checkEmpty($data)["error"]) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Haber Kategorisi Güncelleştirilirken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $news_category = $this->news_category_model->get(["id" => $id]);
            if (!empty($news_category->img_url)) :
                foreach (json_decode($news_category->img_url, true) as $key => $value) :
                    $data["img_url"][$key] = $value;
                endforeach;
            endif;
            foreach ($_FILES["img_url"]["name"] as $key => $value) :
                if (!empty($value)) :
                    $image = upload_picture("img_url", "uploads/$this->viewFolder", $key);
                    if ($image["success"]) :
                        $data["img_url"][$key] = $image["file_name"];
                        if (!empty($news_category->img_url)) :
                            foreach (json_decode($news_category->img_url, true) as $key => $value) :
                                if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$value}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$value}")) :
                                    unlink(FCPATH . "uploads/{$this->viewFolder}/{$value}");
                                endif;
                            endforeach;
                        endif;
                    else :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Haber Kategorisi Güncelleştirilirken Hata Oluştu. Haber Kategorisi Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                        die();
                    endif;
                endif;
            endforeach;
            foreach ($data["title"] as $key => $value) :
                $data["seo_url"][$key] = seo($value . "-" . time());
            endforeach;
            $data = makeJSON($data);
            $update = $this->news_category_model->update(["id" => $id], $data);
            if ($update) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Haber Kategorisi Başarıyla Güncelleştirildi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Haber Kategorisi Güncelleştirilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function delete($id)
    {
        $news_category = $this->news_category_model->get(["id" => $id]);
        if (!empty($news_category)) :
            $delete = $this->news_category_model->delete(["id"    => $id]);
            if ($delete) :
                if (!empty($news_category->img_url)) :
                    foreach (json_decode($news_category->img_url, true) as $key => $value) :
                        if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$value}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$value}")) :
                            unlink(FCPATH . "uploads/{$this->viewFolder}/{$value}");
                        endif;
                    endforeach;
                endif;
                /**
                 * Remove Category News
                 */
                $news = $this->news_model->get_all();
                if (!empty($news)) :
                    foreach ($news as $key => $value) :
                        if ($value->category_id == $id) :
                            $this->news_model->delete(["id" => $value->id]);
                            if (!empty($news->img_url)) :
                                foreach (json_decode($value->img_url, true) as $key => $value) :
                                    if (!is_dir(FCPATH . "uploads/news_v/{$value}") && file_exists(FCPATH . "uploads/news_v/{$value}")) :
                                        unlink(FCPATH . "uploads/news_v/{$value}");
                                    endif;
                                endforeach;
                            endif;
                        endif;
                    endforeach;
                endif;
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Haber Kategorisi Başarıyla Silindi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Haber Kategorisi Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function rankSetter()
    {
        $rows = $this->input->post("rows");

        foreach ($rows as $row) {
            $this->news_category_model->update(
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
            if ($this->news_category_model->update(["id" => $id], ["isActive" => $isActive])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı"]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı"]);
            }
        }
    }
}
