<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stories extends MY_Controller
{
    public $viewFolder = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "stories_v";
        $this->load->model("story_model");
        $this->load->model("story_item_model");
        if (!get_active_user()) :
            redirect(base_url("login"));
        endif;
    }

    public function index()
    {
        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function datatable()
    {
        $items = $this->story_model->getRows(
            [],
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
                    <a class="dropdown-item updateStoryBtn" href="javascript:void(0)" data-url="' . base_url("stories/update_form/$item->id") . '"><i class="fa fa-pen mr-2"></i>Kaydı Düzenle</a>
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="storyTable" data-url="' . base_url("stories/delete/$item->id") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    <a class="dropdown-item" href="' . base_url("stories/upload_form/$item->id") . '"><i class="fa fa-instagram mr-2"></i>Hikayeler</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);
            $sharedAt = json_decode($item->sharedAt, true);
            foreach ($sharedAt as $key => $value) {
                $sharedAt[$key] = turkishDate("d F Y, l H:i:s", $value);
            }
            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("stories/isActiveSetter/{$item->id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';

            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $item->title,  $item->folder_name, $item->url, $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), json_encode($sharedAt, JSON_UNESCAPED_UNICODE), $proccessing);
        endforeach;



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->story_model->rowCount(),
            "recordsFiltered" => $this->story_model->countFiltered([], (!empty($_POST) ? $_POST : [])),
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
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }

    public function save()
    {
        $data = rClean($this->input->post());
        if (empty($data["title"] || empty($_FILES["img_url"]["name"]))) :
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Hikaye Kaydı Yapılırken Hata Oluştu. \"Başlık ve Görsel\" Bilgilerini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $getRank = $this->story_model->rowCount();
            $folder_name = null;
            $imgUrl = null;
            foreach ($_FILES["img_url"]["name"] as $key => $value) :
                if ($value == "") :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Hikaye Kaydı Yapılırken Hata Oluştu. Kapak Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                    die();
                endif;
                $path         = FCPATH . "uploads/$this->viewFolder/";
                $folder_name[$key] = seo($data["title"][$key]);
                $path = "$path/" . $folder_name[$key];
                if (!@mkdir($path, 0755, true)) :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Hikaye Oluşturulurken Hata Oluştu. Klasör Erişim Yetkinizin Olduğundan Emin Olup Tekrar Deneyin."]);
                    die();
                endif;

                $image = upload_picture("img_url", "uploads/$this->viewFolder/$folder_name[$key]", $key);

                if ($image["success"]) :
                    $imgUrl[$key] = $image["file_name"];
                else :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Hikaye Kaydı Yapılırken Hata Oluştu. Kapak Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                    die();
                endif;
            endforeach;
            $data = makeJSON($data);
            $data["folder_name"] = json_encode($folder_name);
            $data["img_url"] = json_encode($imgUrl);
            $data["rank"] = $getRank + 1;
            $insert = $this->story_model->add($data);
            if ($insert) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Hikaye Başarıyla Eklendi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Hikaye Eklenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }

    public function update_form($id)
    {
        $viewData = new stdClass();
        $item = $this->story_model->get(["id" => $id,]);
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
        $story = $this->story_model->get(["id" => $id]);
        $data = rClean($this->input->post());
        if (empty($data["title"])) :
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Hikaye Güncellemesi Yapılırken Hata Oluştu. Hikaye Adı Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $oldFolderName = null;
            $folder_name = null;
            foreach ($story as $key => $value) {
                if (isJson($value)) :
                    $story->$key = json_decode($value);
                else :
                    $story->$key = $value;
                endif;
            }
            if (!empty($story)) :
                /*foreach(json_decode($story->img_url,true) as $key => $value):
                    $data["img_url"][$key] = $value;
                endforeach;*/
                foreach ($data["title"] as $key => $value) :
                    $data["img_url"][$key] = $story->img_url->$key;
                    $path         = FCPATH . "uploads/$this->viewFolder/";
                    $oldFolderName[$key] = $story->folder_name->$key;

                    $folder_name[$key] = seo($data["title"][$key]);
                    if (!rename($path . $oldFolderName[$key], $path . $folder_name[$key])) :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Hikaye Güncellemesi Yapılırken Hata Oluştu. Klasör Erişim Yetkinizin Olduğundan Emin Olup Tekrar Deneyin."]);
                        die();
                    endif;
                endforeach;
                foreach ($_FILES["img_url"]["name"] as $key => $value) :
                    if (!empty($value)) :
                        $image = upload_picture("img_url", "uploads/$this->viewFolder/$folder_name[$key]", $key);
                        if ($image["success"]) :
                            $data["img_url"][$key] = $image["file_name"];
                            $url = FCPATH . "uploads/$this->viewFolder/{$oldFolderName[$key]}/{$story->img_url->$key}";
                            if (!is_dir($url) && file_exists($url)) :
                                unlink($url);
                            endif;
                        endif;
                    endif;
                endforeach;
                $data = makeJSON($data);
                $data["folder_name"] = json_encode($folder_name);
                $update = $this->story_model->update(["id" => $id], $data);
                if ($update) :
                    echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Hikaye Başarıyla Güncellendi."]);
                else :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Hikaye Güncellenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
                endif;
            endif;
        endif;
    }

    public function delete($id)
    {
        $story = $this->story_model->get(["id" => $id]);
        if (!empty($story)) :
            $path = FCPATH . "uploads/$this->viewFolder/$story->folder_name";
            rrmdir($path);
            $this->story_item_model->delete(["story_id" => $id]);
            $delete = $this->story_model->delete(["id" => $id]);
            if ($delete) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Hikaye Başarıyla Silindi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Hikaye Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }

    public function isActiveSetter($id)
    {
        if (!empty($id)) :
            $isActive = (intval($this->input->post("data")) === 1) ? 1 : 0;
            if ($this->story_model->update(["id" => $id], ["isActive" => $isActive])) :
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı"]);
            else :
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı"]);
            endif;
        endif;
    }

    public function rankSetter()
    {
        $rows = $this->input->post("rows");

        foreach ($rows as $row) {
            $this->story_model->update(
                array(
                    "id" => $row["id"]
                ),
                array("rank" => $row["position"])
            );
        }
    }

    public function detailDatatable($story_id = null)
    {
        $story = $this->story_model->get(["id" => $story_id]);
        $items = $this->story_item_model->getRows(
            [],
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
                    ';
            $proccessing .= '
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="detailTable" data-url="' . base_url("stories/fileDelete/{$item->id}/{$item->story_id}") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);

            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("stories/fileIsActiveSetter/{$item->id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';
            foreach (json_decode($story->folder_name, true) as $k => $v) :
                if ($item->lang == $k) :
                    if ($item->type == "photo") :
                        $image = '<img src="' . base_url("uploads/stories_v/{$v}/{$item->src}") . '" width="75">';
                    else :
                        $image = '<video id="my-video' . $i . '" class="video-js" controls preload="auto" width="300" height="150">';
                        $image .= '<source src="' . base_url("uploads/stories_v/{$v}/{$item->src}") . '"/>';
                        $image .= '</video>';
                    endif;
                endif;
            endforeach;
            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $image, $item->src,$item->lang, $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), turkishDate("d F Y, l H:i:s", $item->sharedAt), $proccessing);

        endforeach;



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->story_item_model->rowCount(),
            "recordsFiltered" => $this->story_item_model->countFiltered([], (!empty($_POST) ? $_POST : [])),
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
        $item = $this->story_model->get(["id" => $id]);
        $viewData->item = $item;
        foreach ($viewData->item as $key => $data) {
            if (isJson($data)) :
                $viewData->item->$key = json_decode($data);
            else :
                $viewData->item->$key = $data;
            endif;
        }
        $viewData->settings = $this->general_model->get_all("settings", null, null, ["isActive" => 1]);

        $viewData->items = $this->story_item_model->get_all(["story_id" => $id], "rank ASC");
        $viewData->folder_name = $item->folder_name;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function fileUpdate($id)
    {
        $viewData = new stdClass();
        $viewData->category = $this->uri->segment(4);
        $viewData->story = $this->story_model->get(['id' => $viewData->category]);

        $item = $this->image_model->get(
            array(
                "id"    => $id,
            )
        );
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "file_update";
        $viewData->item = $item;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function file_upload($story_id, $lang)
    {
        $story = $this->story_model->get(["id" => $story_id]);
        $folder_name = json_decode($story->folder_name, true);
        $folder_name = $folder_name[$lang];
        $image = upload_picture("file", "uploads/$this->viewFolder/{$folder_name}/", null, "mpeg|mpg|mpe|qt|mov|avi|movie|3g2|3gp|mp4|f4v|flv|webm|wmv|ogg");
        if ($image["success"]) :
            $getRank = $this->story_item_model->rowCount();
            $data = ["src" => $image["file_name"], "rank" => $getRank + 1, "story_id" => $story_id, "type" => "video", "lang" => $lang];
            $this->story_item_model->add($data);
        else :
            $image = upload_picture("file", "uploads/$this->viewFolder/{$folder_name}/");
            if ($image["success"]) :
                $getRank = $this->story_item_model->rowCount();
                $data = ["src" => $image["file_name"], "rank" => $getRank + 1, "story_id" => $story_id, "type" => "photo", "lang" => $lang];
                $this->story_item_model->add($data);
            else :
                echo $image["error"];
            endif;
        endif;
    }

    public function fileDelete($id, $parent_id)
    {

        $story = $this->story_model->get(["id" => $parent_id]);
        $fileName = $this->story_item_model->get(["id" => $id]);
        $delete = $this->story_item_model->delete(["id" => $id]);
        if ($delete) :
            $url = FCPATH . "uploads/stories_v/{$story->folder_name}/{$fileName->src}";
            if (!is_dir($url) && file_exists($url)) :
                unlink($url);
            endif;
            echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Hikaye İçeriği Başarıyla Silindi."]);
        else :
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Hikaye İçeriği Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
        endif;
    }

    public function fileIsActiveSetter($id)
    {
        if ($id) {
            $isActive = (intval($this->input->post("data")) === 1) ? 1 : 0;
            if ($this->story_item_model->update(["id" => $id], ["isActive" => $isActive])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı"]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı"]);
            }
        }
    }

    public function fileRankSetter()
    {
        $rows = $this->input->post("rows");

        foreach ($rows as $row) {
            $this->story_item_model->update(
                array(
                    "id" => $row["id"]
                ),
                array("rank" => $row["position"])
            );
        }
    }
}
