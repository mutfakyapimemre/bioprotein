<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_categories extends MY_Controller
{
    public $viewFolder = "";
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "product_categories_v";
        $this->load->model("product_category_model");
        $this->load->model("product_model");
        if (!get_active_user()) {
            redirect(base_url("login"));
        }
    }
    public function index()
    {
        $viewData = new stdClass();
        $items = $this->product_category_model->get_all(
            array()
        );
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
    public function datatable()
    {
        $items = $this->product_category_model->getRows(
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
                    <a class="dropdown-item updateProductCategoryBtn" href="javascript:void(0)" data-url="' . base_url("product_categories/update_form/$item->category_id") . '"><i class="fa fa-pen mr-2"></i>Kaydı Düzenle</a>
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="productCategoryTable" data-url="' . base_url("product_categories/delete/$item->category_id") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);

            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->category_id . '" data-url="' . base_url("product_categories/isActiveSetter/{$item->category_id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';
            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->category_id . '"></i>', $item->category_id, $item->title, (!empty($item->product_category) ? $item->product_category : "<strong class='text-danger'>Ana Kategori</strong>"), $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), $proccessing);
        }



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->product_category_model->rowCount(),
            "recordsFiltered" => $this->product_category_model->countFiltered([], (!empty($_POST) ? $_POST : [])),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);
    }
    public function new_form()
    {
        $viewData = new stdClass();
        $item = $this->product_category_model->get_all();
        $viewData->categories = $item;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";
        $viewData->settings = $this->general_model->get_all("settings", null, null, ["isActive" => 1]);
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }
    public function save()
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"] && checkEmpty($data)["key"] != "top_id") :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Kategorisi Kaydı Yapılırken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $getRank = $this->product_category_model->rowCount();
            foreach ($data["title"] as $key => $value) :
                $data["seo_url"][$key] = seo($value . "-" . time());
            endforeach;
            if (!empty($_FILES)) :
                foreach ($_FILES["img_url"]["name"] as $key => $value) :
                    if ($value == "") :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Kategorisi Eklenirken Hata Oluştu. Ürün Kategorisi Görseli Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                        die();
                    endif;
                    $image = upload_picture("img_url", "uploads/$this->viewFolder", $key);
                    if ($image["success"]) :
                        $data["img_url"][$key] = $image["file_name"];
                    else :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Kategorisi Kaydı Yapılırken Hata Oluştu. Ürün Kategorisi Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                        die();
                    endif;
                endforeach;
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Kategorisi Kaydı Yapılırken Hata Oluştu. Ürün Kategorisi Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                die();
            endif;
            $data = makeJSON($data);
            $data["isActive"] = 1;
            $data["rank"] = $getRank + 1;
            $insert = $this->product_category_model->add($data);
            if ($insert) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ürün Kategorisi Başarıyla Eklendi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Kategorisi Eklenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function update_form($id)
    {
        $viewData = new stdClass();
        $item = $this->product_category_model->get(
            array(
                "id"    => $id,
            )
        );
        $category = $this->product_category_model->get_all(["id!=" => $item->id]);
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
        if (checkEmpty($data)["error"] && checkEmpty($data)["key"] != "top_id") :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Kategorisi Güncelleştirilirken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $product_category = $this->product_category_model->get(["id" => $id]);
            if (!empty($product_category->img_url)) :
                foreach (json_decode($product_category->img_url, true) as $key => $value) :
                    $data["img_url"][$key] = $value;
                endforeach;
            endif;
            foreach ($_FILES["img_url"]["name"] as $key => $value) :
                if (!empty($value)) :
                    $image = upload_picture("img_url", "uploads/$this->viewFolder", $key);
                    if ($image["success"]) :
                        $data["img_url"][$key] = $image["file_name"];
                        if (!empty($product_category->img_url)) :
                            foreach (json_decode($product_category->img_url, true) as $key => $value) :
                                if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/{$value}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/{$value}")) :
                                    unlink(FCPATH . "uploads/{$this->viewFolder}/{$value}");
                                endif;
                            endforeach;
                        endif;
                    else :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Kategorisi Güncelleştirilirken Hata Oluştu. Ürün Kategorisi Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                        die();
                    endif;
                endif;
            endforeach;
            foreach ($data["title"] as $key => $value) :
                $data["seo_url"][$key] = seo($value . "-" . time());
            endforeach;
            $data = makeJSON($data);
            $update = $this->product_category_model->update(["id" => $id], $data);
            if ($update) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ürün Kategorisi Başarıyla Güncelleştirildi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Kategorisi Güncelleştirilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function delete($id)
    {
        $product_category = $this->product_category_model->get(["id" => $id]);
        if (!empty($product_category)) :
            $delete = $this->product_category_model->delete(["id"    => $id]);
            if ($delete) :
                /**
                 * Remove Category From Product
                 */
                $products = $this->product_model->get_all();
                if (!empty($products)) :
                    foreach ($products as $key => $value) :
                        $selectedCategories = explode(",", $value->category_id);
                        if (in_array($id, $selectedCategories)) :
                            if (($key = array_search($id, $selectedCategories)) !== false) :
                                unset($selectedCategories[$key]);
                                $this->product_model->update(["id" => $value->id], ["category_id" => implode(",", $selectedCategories)]);
                            endif;
                        endif;
                    endforeach;
                endif;
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Ürün Kategorisi Başarıyla Silindi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Ürün Kategorisi Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }
    public function rankSetter()
    {
        $rows = $this->input->post("rows");

        foreach ($rows as $row) {
            $this->product_category_model->update(
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
            if ($this->product_category_model->update(["id" => $id], ["isActive" => $isActive])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı"]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı"]);
            }
        }
    }
}
