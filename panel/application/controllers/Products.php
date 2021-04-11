<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends MY_Controller
{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "products_v";
        $this->load->model("product_model");
        $this->load->model("product_category_model");
        $this->load->model("product_image_model");
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }
    public function index()
    {
        $viewData = new stdClass();
        $items = $this->product_model->get_all(
            array(),
            "rank ASC"
        );
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function datatable()
    {
        $items = $this->product_model->getRows(
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
                    <a class="dropdown-item updateProductBtn" href="javascript:void(0)" data-url="' . base_url("products/update_form/$item->id") . '"><i class="fa fa-pen mr-2"></i>Kaydı Düzenle</a>
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="productTable" data-url="' . base_url("products/delete/$item->id") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    <a class="dropdown-item" href="' . base_url("products/upload_form/$item->id") . '"><i class="fa fa-image mr-2"></i>Resimler</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);
            $sharedAt = json_decode($item->sharedAt, true);
            foreach ($sharedAt as $key => $value) {
                $sharedAt[$key] = turkishDate("d F Y, l H:i:s", $value);
            }
            $checkbox1 = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("products/isNewSetter/{$item->id}") . '" data-status="' . ($item->isNew == 1 ? "checked" : null) . '" id="customSwitch1' . $i . '" type="checkbox" ' . ($item->isNew == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch1' . $i . '"></label></div>';
            $checkbox2 = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("products/isSuggestedSetter/{$item->id}") . '" data-status="' . ($item->isSuggested == 1 ? "checked" : null) . '" id="customSwitch2' . $i . '" type="checkbox" ' . ($item->isSuggested == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch2' . $i . '"></label></div>';
            $checkbox3 = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("products/isDiscountSetter/{$item->id}") . '" data-status="' . ($item->isDiscount == 1 ? "checked" : null) . '" id="customSwitch3' . $i . '" type="checkbox" ' . ($item->isDiscount == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch3' . $i . '"></label></div>';
            $checkbox4 = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("products/isActiveSetter/{$item->id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch4' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch4' . $i . '"></label></div>';

            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $item->title, $item->price, $checkbox1, $checkbox2, $checkbox3, $checkbox4, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), json_encode($sharedAt, JSON_UNESCAPED_UNICODE), $proccessing);
        }



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->product_model->rowCount(),
            "recordsFiltered" => $this->product_model->countFiltered([], (!empty($_POST) ? $_POST : [])),
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
        $viewData->categories = $this->product_category_model->get_all();
        $viewData->settings = $this->general_model->get_all("settings", null, null, ["isActive" => 1]);
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }
    public function save()
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"]) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Kaydı Yapılırken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $getRank = $this->product_model->rowCount();
            foreach ($data["title"] as $key => $value) :
                $data["url"][$key] = seo($data["title"][$key]);
                $data["content"][$key] = $_POST["content"][$key];
            endforeach;
            $data = makeJSON($data);
            $data["isActive"] = 1;
            $data["rank"] = $getRank + 1;
            $data["category_id"] = implode(",", $_POST["category_id"]);
            $insert = $this->product_model->add($data);
            if ($insert) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ürün Başarıyla Eklendi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Eklenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function update_form($id)
    {
        $viewData = new stdClass();
        $item = $this->product_model->get(
            array(
                "id"    => $id,
            )
        );
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->categories = $this->product_category_model->get_all();
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
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Güncelleştirilirken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $product = $this->product_model->get(["id" => $id]);
            foreach ($data["title"] as $key => $value) :
                $data["url"][$key] = seo($value);
                $data["content"][$key] = $_POST["content"][$key];
            endforeach;
            $data = makeJSON($data);
            $data["category_id"] = implode(",", $_POST["category_id"]);
            $update = $this->product_model->update(["id" => $id], $data);
            if ($update) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ürün Başarıyla Güncelleştirildi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Güncelleştirilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;

        endif;
    }

    public function delete($id)
    {
        $product = $this->product_model->get(["id" => $id]);
        if (!empty($product)) :
            $product_images = $this->product_image_model->get_all(["product_id" => $id]);
            $delete = $this->product_model->delete(["id"    => $id]);
            if ($delete) :
                if (!empty($product_images)) :
                    foreach ($product_images as $key => $value) :
                        if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$value->url}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$value->url}")) :
                            unlink(FCPATH . "uploads/{$this->viewFolder}/{$value->url}");
                        endif;
                    endforeach;
                endif;
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ürün Başarıyla Silindi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }

    public function rankSetter()
    {
        $rows = $this->input->post("rows");

        foreach ($rows as $row) {
            $this->product_model->update(
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
            if ($this->product_model->update(["id" => $id], ["isActive" => $isActive])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı."]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı."]);
            }
        }
    }

    public function isNewSetter($id)
    {
        if ($id) {
            $isNew = (intval($this->input->post("data")) === 1) ? 1 : 0;
            if ($this->product_model->update(["id" => $id], ["isNew" => $isNew])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı."]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı."]);
            }
        }
    }

    public function isSuggestedSetter($id)
    {
        if ($id) {
            $isSuggested = (intval($this->input->post("data")) === 1) ? 1 : 0;
            if ($this->product_model->update(["id" => $id], ["isSuggested" => $isSuggested])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı."]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı."]);
            }
        }
    }

    public function isDiscountSetter($id)
    {
        if ($id) {
            $isDiscount = (intval($this->input->post("data")) === 1) ? 1 : 0;
            if ($this->product_model->update(["id" => $id], ["isDiscount" => $isDiscount])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı."]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı."]);
            }
        }
    }

    public function detailDatatable($product_id)
    {
        $product = $this->product_model->get(["id" => $product_id]);
        $items = $this->product_image_model->getRows(
            ["product_id" => $product_id],
            $_POST
        );
        $data = $row = array();
        $i = (!empty($_POST['start']) ? $_POST['start'] : 0);

        foreach ($items as $item) :
            $i++;
            $j = $i + 1;

            $proccessing = '
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary rounded-0 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    İşlemler
                </button>
                <div class="dropdown-menu rounded-0 dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="detailTable" data-url="' . base_url("products/fileDelete/{$item->id}") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);
            $lang = $item->lang;
            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("products/fileIsActiveSetter/{$item->id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';
            $checkbox2 = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-table="detailTable" data-url="' . base_url("products/fileIsCoverSetter/{$item->id}/$item->lang") . '" data-status="' . ($item->isCover == 1 ? "checked" : null) . '" id="customSwitch2' . $i . '" type="checkbox" ' . ($item->isCover == 1 ? "checked" : null) . ' class="isCover custom-control-input" >  <label class="custom-control-label" for="customSwitch2' . $i . '"></label></div>';
            $image = '<img src="' . base_url("uploads/{$this->viewFolder}/{$item->url}") . '" width="75">';

            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $image, $item->url, $item->lang, $checkbox2, $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), $proccessing);

        endforeach;



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->product_image_model->rowCount(["product_id" => $product_id]),
            "recordsFiltered" => $this->product_image_model->countFiltered(["product_id" => $product_id], (!empty($_POST) ? $_POST : [])),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);
    }

    public function upload_form($id)
    {
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "image";
        $item = $this->product_model->get(["id" => $id]);
        $viewData->item = $item;
        foreach ($viewData->item as $key => $data) {
            if (isJson($data)) :
                $viewData->item->$key = json_decode($data);
            else :
                $viewData->item->$key = $data;
            endif;
        }
        $viewData->settings = $this->general_model->get_all("settings", null, null, ["isActive" => 1]);
        $viewData->items = $this->product_image_model->get_all(["product_id" => $id], "rank ASC");
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function fileUpdate($id, $product_id)
    {
        $viewData = new stdClass();
        $viewData->product = $this->product_model->get(['id' => $product_id]);
        $viewData->item = $this->product_image_model->get(["id" => $id, "product_id" => $viewData->product->id]);
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "file_update";
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }

    public function file_update($id, $product_id)
    {
        $data = $this->input->post();
        $product = $this->product_model->get(['id' => $product_id]);
        if ($_FILES["img_url"]["name"] !== "") :
            $image = upload_picture("img_url", "uploads/$this->viewFolder/");
            if ($image["success"]) :
                $data["img_url"] = $image["file_name"];
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Görseli Güncelleştirilirken Hata Oluştu. Ürün Kapak Görseli Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                die();
            endif;
        endif;
        $update = $this->product_image_model->update(["id" => $id], $data);
        if ($update) :
            echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ürün Görseli Başarıyla Güncelleştirildi."]);
        else :
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Görseli Güncelleştirilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
        endif;
    }

    public function file_upload($product_id, $lang)
    {
        $image = upload_picture("file", "uploads/$this->viewFolder/");
        if ($image["success"]) :
            $getRank = $this->product_image_model->rowCount();
            $this->product_image_model->add(
                array(
                    "url"           => $image["file_name"],
                    "rank"          => $getRank + 1,
                    "product_id"    => $product_id,
                    "isActive"      => 1,
                    "lang"          => $lang
                )
            );
        else :
            echo $image["error"];
        endif;
    }

    public function fileDelete($id)
    {
        $fileName = $this->product_image_model->get(["id" => $id]);
        $delete = $this->product_image_model->delete(["id" => $id]);
        if ($delete) :
            $url = FCPATH . "uploads/{$this->viewFolder}/{$fileName->url}";
            if (!is_dir($url) && file_exists($url)) :
                unlink($url);
            endif;
            echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ürün Görseli Başarıyla Silindi."]);
        else :
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Görseli Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
        endif;
    }

    public function fileIsActiveSetter($id)
    {
        if ($id) {
            $isActive = (intval($this->input->post("data")) === 1) ? 1 : 0;
            if ($this->product_image_model->update(["id" => $id], ["isActive" => $isActive])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı"]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı"]);
            }
        }
    }

    public function fileRankSetter($product_id)
    {
        $rows = $this->input->post("rows");
        foreach ($rows as $row) {
            $this->product_image_model->update(
                array(
                    "id" => $row["id"],
                    "product_id" => $product_id
                ),
                array("rank" => $row["position"])
            );
        }
    }

    public function fileIsCoverSetter($id, $lang)
    {
        if ($id && $lang) {
            $isCover = (intval($this->input->post("data")) === 1) ? 1 : 0;
            if ($this->product_image_model->update(["id" => $id], ["isCover" => $isCover, "lang" => $lang])) {
                $this->product_image_model->update(["id!=" => $id], ["isCover" => 0, "lang" => $lang]);
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı"]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı"]);
            }
        }
    }
}
