<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Galleries extends MY_Controller
{
    public $viewFolder = "";

    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "galleries_v";
        $this->load->model("gallery_model");
        $this->load->model("image_model");
        $this->load->model("video_model");
        $this->load->model("video_url_model");
        $this->load->model("file_model");
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
        $items = $this->gallery_model->getRows(
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
                    <a class="dropdown-item updateGalleryBtn" href="javascript:void(0)" data-url="' . base_url("galleries/update_form/$item->id") . '"><i class="fa fa-pen mr-2"></i>Kaydı Düzenle</a>
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="galleryTable" data-url="' . base_url("galleries/delete/$item->id") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    <a class="dropdown-item" href="' . base_url("galleries/upload_form/$item->id") . '"><i class="fa ' . ($item->gallery_type == "images" ? "fa-image" : ($item->gallery_type == "videos" ? "fa-video" : "fa-file")) . ' mr-2"></i>' . ($item->gallery_type == "images" ? "Resimler" : ($item->gallery_type == "videos" || $item->gallery_type == "video_urls" ? "Videolar" : "Dosyalar")) . '</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);

            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("galleries/isActiveSetter/{$item->id}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';
            $sharedAt = json_decode($item->sharedAt, true);
            foreach ($sharedAt as $key => $value) {
                $sharedAt[$key] = turkishDate("d F Y, l H:i:s", $value);
            }
            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $item->title, $item->gallery_type, $item->folder_name, $item->url, $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), json_encode($sharedAt, JSON_UNESCAPED_UNICODE), $proccessing);
        endforeach;



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->gallery_model->rowCount(),
            "recordsFiltered" => $this->gallery_model->countFiltered([], (!empty($_POST) ? $_POST : [])),
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
        if (checkEmpty($data)["error"]) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Kaydı Yapılırken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $getRank = $this->gallery_model->rowCount();
            $gallery_type = $this->input->post("gallery_type");
            $folder_name = null;
            $url = null;
            $imgUrl = null;
            if (!empty($_FILES)) :
                foreach ($_FILES["img_url"]["name"] as $key => $value) :
                    if ($value == "") :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Kaydı Yapılırken Hata Oluştu. Kapak Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                        die();
                    endif;
                    $path         = FCPATH . "uploads/$this->viewFolder/";
                    $folder_name[$key] = seo($data["title"][$key]);
                    $path = "$path/$gallery_type/" . $folder_name[$key];
                    if (!@mkdir($path, 0755, true)) :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Oluşturulurken Hata Oluştu. Klasör Erişim Yetkinizin Olduğundan Emin Olup Tekrar Deneyin."]);
                        die();
                    endif;

                    $image = upload_picture("img_url", "uploads/$this->viewFolder/$gallery_type/$folder_name[$key]", $key);

                    if ($image["success"]) :
                        $url[$key] =  seo($data["title"][$key]);
                        $imgUrl[$key] = $image["file_name"];
                    else :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Kaydı Yapılırken Hata Oluştu. Kapak Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                        die();
                    endif;
                endforeach;
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Kaydı Yapılırken Hata Oluştu. Kapak Görseli Seçtiğinizden Emin Olup Tekrar Deneyin."]);
                die();
            endif;
            $gallery_type = $data["gallery_type"];
            $data = makeJSON($data);
            $data["folder_name"] = json_encode($folder_name);
            $data["url"] = json_encode($url);
            $data["img_url"] = json_encode($imgUrl);
            $data["rank"] = $getRank + 1;
            $data["gallery_type"] = $gallery_type;
            $insert = $this->gallery_model->add($data);
            if ($insert) :
                echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Galeri Başarıyla Eklendi."]);
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Eklenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }

    public function update_form($id)
    {
        $viewData = new stdClass();
        $item = $this->gallery_model->get(["id" => $id,]);
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

    public function update($id, $gallery_type)
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"]) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Güncellemesi Yapılırken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
        else :
            $gallery = $this->gallery_model->get(["id" => $id]);
            $oldFolderName = null;
            $folder_name = null;
            foreach ($gallery as $key => $value) {
                if (isJson($value)) :
                    $gallery->$key = json_decode($value);
                else :
                    $gallery->$key = $value;
                endif;
            }
            if (!empty($gallery)) :
                foreach ($data["title"] as $key => $value) :
                    $data["img_url"][$key] = !empty($gallery->img_url->$key) ? $gallery->img_url->$key : null;
                    $data["url"][$key] = !empty($gallery->url->$key) ? seo($gallery->url->$key) : seo($data["title"][$key]);
                    $path         = FCPATH . "uploads/$this->viewFolder/";
                    $oldFolderName[$key] = !empty($gallery->folder_name->$key) ? $gallery->folder_name->$key : seo($data["title"][$key]);

                    $folder_name[$key] = seo($data["title"][$key]);
                    $path = "$path/$gallery_type/";
                    if (!file_exists($path . $oldFolderName[$key])) :
                        if (!@mkdir($path . $oldFolderName[$key], 0755, true)) :
                            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Oluşturulurken Hata Oluştu. Klasör Erişim Yetkinizin Olduğundan Emin Olup Tekrar Deneyin."]);
                            die();
                        endif;
                    endif;
                    if (!rename($path . $oldFolderName[$key], $path . $folder_name[$key])) :
                        echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Güncellemesi Yapılırken Hata Oluştu. Klasör Erişim Yetkinizin Olduğundan Emin Olup Tekrar Deneyin."]);
                        die();
                    endif;
                endforeach;
                foreach ($_FILES["img_url"]["name"] as $key => $value) :
                    if (!empty($value)) :
                        $image = upload_picture("img_url", "uploads/$this->viewFolder/$gallery_type/$folder_name[$key]", $key);
                        if ($image["success"]) :
                            $data["url"][$key] =  seo($data["title"][$key]);
                            $data["img_url"][$key] = $image["file_name"];
                            if (!empty($gallery->img_url)) :
                                foreach ((array)$gallery->img_url as $key => $value) :
                                    if (!is_dir(FCPATH . "uploads/{$this->viewFolder}/$gallery_type/$folder_name[$key]/{$value}") && file_exists(FCPATH . "uploads/{$this->viewFolder}/$gallery_type/$folder_name[$key]/{$value}")) :
                                        unlink(FCPATH . "uploads/{$this->viewFolder}/$gallery_type/$folder_name[$key]/{$value}");
                                    endif;
                                endforeach;
                            endif;
                        endif;
                    endif;
                endforeach;
                $data = makeJSON($data);
                $data["folder_name"] = json_encode($folder_name);
                $update = $this->gallery_model->update(["id" => $id], $data);
                if ($update) :
                    echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Galeri Başarıyla Güncellendi."]);
                else :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Güncellenirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
                endif;
            endif;
        endif;
    }

    public function delete($id)
    {
        $gallery = $this->gallery_model->get(["id" => $id]);
        if (!empty($gallery)) :
            if (!$gallery->isCover) :
                if ($gallery->gallery_type != "video_urls") :
                    if ($gallery->gallery_type == "images") :
                        $model = "image_model";
                    elseif ($gallery->gallery_type == "videos") :
                        $model = "video_model";
                    else :
                        $model = "file_model";
                    endif;
                    $folder_name = json_decode($gallery->folder_name, true);
                    foreach ($folder_name as $key => $value) :
                        $path = FCPATH . "uploads/$this->viewFolder/$gallery->gallery_type/{$folder_name[$key]}";
                        rrmdir($path);
                    endforeach;

                else :
                    $model = "video_url_model";
                endif;
                $this->$model->delete(["gallery_id" => $id]);
                $delete = $this->gallery_model->delete(["id" => $id]);
                if ($delete) :
                    echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Galeri Başarıyla Silindi."]);
                else :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
                endif;
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri Silinirken Hata Oluştu. Sabit Galeriyi Silemezsiniz, Lütfen Tekrar Deneyin."]);
            endif;
        endif;
    }

    public function isActiveSetter($id)
    {
        if (!empty($id)) :
            $isActive = (intval($this->input->post("data")) === 1) ? 1 : 0;
            if ($this->gallery_model->update(["id" => $id], ["isActive" => $isActive])) :
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
            $this->gallery_model->update(
                array(
                    "id" => $row["id"]
                ),
                array("rank" => $row["position"])
            );
        }
    }

    public function detailDatatable($gallery_type, $gallery_id, $folder_name = null)
    {
        $gallery = $this->gallery_model->get(["id" => $gallery_id]);
        $folder_name = json_decode($gallery->folder_name, true);
        $modelName = ($gallery_type == "images" ? "image_model" : ($gallery_type == "files" ? "file_model" : ($gallery_type == "videos" ? "video_model" : "video_url_model")));
        $items = $this->$modelName->getRows(
            ["gallery_id" => $gallery_id],
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
                <a href="javascript:void(0)" data-url="' . base_url("galleries/fileUpdate/{$item->id}/{$gallery_id}") . '" class="dropdown-item updateGalleryItemBtn"><i class="fa fa-pen"></i> Açıklama Ekle</a>
                    <a class="dropdown-item remove-btn" href="javascript:void(0)" data-table="detailTable" data-url="' . base_url("galleries/fileDelete/{$item->id}/{$item->gallery_id}/{$gallery_type}") . '"><i class="fa fa-trash mr-2"></i>Kaydı Sil</a>
                    </div>
            </div>';



            //array_push($renkler,$renk->negotiation_stage_color);
            $lang = $item->lang;
            $checkbox = '<div class="custom-control custom-switch"><input data-id="' . $item->id . '" data-url="' . base_url("galleries/fileIsActiveSetter/{$item->id}/{$gallery_type}") . '" data-status="' . ($item->isActive == 1 ? "checked" : null) . '" id="customSwitch' . $i . '" type="checkbox" ' . ($item->isActive == 1 ? "checked" : null) . ' class="my-check custom-control-input" >  <label class="custom-control-label" for="customSwitch' . $i . '"></label></div>';
            if ($gallery_type == "images") :
                $image = '<img src="' . base_url("uploads/galleries_v/{$gallery_type}/{$folder_name[$lang]}/{$item->url}") . '" width="75">';
            elseif ($gallery_type == "files") :
                $image = '<a href="' . base_url("uploads/galleries_v/{$gallery_type}/{$folder_name[$lang]}/{$item->url}") . '" download><i class="fa fa-download fa-2x"></i></a>';
            elseif ($gallery_type == "videos") :
                $image = '<video id="my-video' . $i . '" playsinline controls preload="auto" width="300" height="150" data-poster="' . get_picture("galleries_v/{$gallery_type}/{$folder_name[$lang]}", $item->img_url) . '">';
                if ($gallery_type == "videos") :
                    $image .= '<source src="' . base_url("uploads/galleries_v/{$gallery_type}/{$folder_name[$lang]}/{$item->url}") . '"/>';
                endif;
                $image .= '</video>';
            else :
                $image = htmlspecialchars_decode($item->url);
            endif;
            $data[] = array($item->rank, '<i class="fa fa-arrows" data-id="' . $item->id . '"></i>', $item->id, $image, $item->url, $item->lang, $checkbox, turkishDate("d F Y, l H:i:s", $item->createdAt), turkishDate("d F Y, l H:i:s", $item->updatedAt), turkishDate("d F Y, l H:i:s", $item->sharedAt), $proccessing);

        endforeach;



        $output = array(
            "draw" => (!empty($_POST['draw']) ? $_POST['draw'] : 0),
            "recordsTotal" => $this->$modelName->rowCount(["gallery_id" => $gallery_id]),
            "recordsFiltered" => $this->$modelName->countFiltered(["gallery_id" => $gallery_id], (!empty($_POST) ? $_POST : [])),
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
        $item = $this->gallery_model->get(["id" => $id]);
        $viewData->item = $item;
        $viewData->gallery_type = $item->gallery_type;
        foreach ($viewData->item as $key => $data) {
            if (isJson($data)) :
                $viewData->item->$key = json_decode($data);
            else :
                $viewData->item->$key = $data;
            endif;
        }
        $viewData->settings = $this->general_model->get_all("settings", null, null, ["isActive" => 1]);
        if ($item->gallery_type == "images") :
            $viewData->items = $this->image_model->get_all(["gallery_id" => $id], "rank ASC");
        elseif ($item->gallery_type == "files") :
            $viewData->items = $this->file_model->get_all(["gallery_id" => $id], "rank ASC");
        elseif ($item->gallery_type == "videos") :
            $viewData->items = $this->video_model->get_all(["gallery_id" => $id], "rank ASC");
        else :
            $viewData->items = $this->video_url_model->get_all(["gallery_id" => $id], "rank ASC");
        endif;
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function fileUpdate($id, $gallery_id)
    {
        $viewData = new stdClass();
        $viewData->gallery = $this->gallery_model->get(['id' => $gallery_id]);
        if ($viewData->gallery->gallery_type == "images") :
            $viewData->item = $this->image_model->get(["id" => $id, "gallery_id" => $viewData->gallery->id]);
        elseif ($viewData->gallery->gallery_type == "files") :
            $viewData->item = $this->file_model->get(["id" => $id, "gallery_id" => $viewData->gallery->id]);
        elseif ($viewData->gallery->gallery_type == "videos") :
            $viewData->item = $this->video_model->get(["id" => $id, "gallery_id" => $viewData->gallery->id]);
        else :
            $viewData->item = $this->video_url_model->get(["id" => $id, "gallery_id" => $viewData->gallery->id]);
        endif;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "file_update";
        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/content", $viewData);
    }

    public function file_update($id, $gallery_id)
    {
        $data = $this->input->post();
        $gallery = $this->gallery_model->get(['id' => $gallery_id]);
        if ($gallery->gallery_type == "images") :
            $model = "image_model";
        elseif ($gallery->gallery_type == "files") :
            $model = "file_model";
        elseif ($gallery->gallery_type == "videos") :
            $model = "video_model";
        else :
            $model = "video_url_model";
        endif;
        if ($_FILES["img_url"]["name"] !== "") :
            $image = upload_picture("img_url", "uploads/$this->viewFolder/$gallery->gallery_type");
            if ($image["success"]) :
                $data["img_url"] = $image["file_name"];
            else :
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri İçeriği Güncelleştirilirken Hata Oluştu. İçerik Kapak Görseli Seçtiğinizden Emin Olup, Lütfen Tekrar Deneyin."]);
                die();
            endif;
        endif;
        $update = $this->$model->update(["id" => $id], $data);
        if ($update) :
            echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Galeri İçeriği Başarıyla Güncelleştirildi."]);
        else :
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri İçeriği Güncelleştirilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
        endif;
    }

    public function file_upload($gallery_id, $gallery_type, $lang)
    {
        $gallery = $this->gallery_model->get(["id" => $gallery_id]);
        $gallery->folder_name = json_decode($gallery->folder_name, true);
        if ($gallery_type != "video_urls") :
            if ($gallery_type == "images") :
                $image = upload_picture("file", "uploads/$this->viewFolder/images/{$gallery->folder_name[$lang]}/");
                if ($image["success"]) :
                    $getRank = $this->image_model->rowCount();
                    $this->image_model->add(
                        array(
                            "url"           => $image["file_name"],
                            "rank"          => $getRank + 1,
                            "gallery_id"    => $gallery_id,
                            "isActive"      => 1,
                            "lang"          => $lang
                        )
                    );
                else :
                    echo $image["error"];
                endif;
            elseif ($gallery_type == "videos") :
                $image = upload_picture("file", "uploads/$this->viewFolder/videos/{$gallery->folder_name[$lang]}/", null, "mpeg|mpg|mpe|qt|mov|avi|movie|3g2|3gp|mp4|f4v|flv|webm|wmv|ogg");
                if ($image["success"]) :
                    $getRank = $this->video_model->rowCount();
                    $this->video_model->add(
                        array(
                            "url"           => $image["file_name"],
                            "rank"          => $getRank + 1,
                            "gallery_id"    => $gallery_id,
                            "isActive"      => 1,
                            "lang"          => $lang
                        )
                    );
                else :
                    echo $image["error"];
                endif;
            else :
                $image = upload_picture("file", "uploads/$this->viewFolder/files/{$gallery->folder_name[$lang]}/", null, "*");
                if ($image["success"]) :
                    $getRank = $this->file_model->rowCount();
                    $this->file_model->add(
                        array(
                            "url"           => $image["file_name"],
                            "rank"          => $getRank + 1,
                            "gallery_id"    => $gallery_id,
                            "isActive"      => 1,
                            "lang"          => $lang
                        )
                    );
                else :
                    echo $image["error"];
                endif;
            endif;
        else :
            $data = $this->input->post();
            if (checkEmpty($data)["error"]) :
                $key = checkEmpty($data)["key"];
                echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri İçeriği Kayıt Edilirken Hata Oluştu. \"{$key}\" Bilgisini Doldurduğunuzdan Emin Olup Tekrar Deneyin."]);
            else :
                $getRank = $this->video_url_model->rowCount();
                $data["url"] = htmlspecialchars(html_entity_decode($_POST["url"][$lang]));
                $data["rank"] = $getRank + 1;
                $data["isActive"] = 1;
                $data["gallery_id"] = $gallery_id;
                $data["lang"] = $lang;
                if ($this->video_url_model->add($data)) :
                    echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Galeri İçeriği Başarıyla Kayıt Edildi."]);
                else :
                    echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri İçeriği Kayıt Edilirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
                endif;
            endif;
        endif;
    }

    public function fileDelete($id, $parent_id, $gallery_type)
    {

        $modelName = ($gallery_type == "images" ? "image_model" : ($gallery_type == "files" ? "file_model" : ($gallery_type == "videos" ? "video_model" : "video_url_model")));
        $gallery = $this->gallery_model->get(["id" => $parent_id]);
        $fileName = $this->$modelName->get(["id" => $id]);
        $delete = $this->$modelName->delete(["id" => $id]);
        if ($delete) :
            if ($gallery_type == "images") :
                $url = FCPATH . "uploads/galleries_v/images/{$gallery->url}/{$fileName->url}";
                if (!is_dir($url) && file_exists($url)) :
                    unlink($url);
                endif;
            elseif ($gallery_type == "videos") :
                $url = FCPATH . "uploads/galleries_v/videos/{$gallery->url}/{$fileName->url}";
                $url2 = FCPATH . "uploads/galleries_v/videos/{$gallery->url}/{$fileName->img_url}";
                if (!is_dir($url) && file_exists($url)) :
                    unlink($url);
                endif;
                if (!is_dir($url2) && file_exists($url2)) :
                    unlink($url2);
                endif;
            elseif ($gallery_type == "files") :
                $url = FCPATH . "uploads/galleries_v/files/{$gallery->url}/{$fileName->url}";
                if (!is_dir($url) && file_exists($url)) :
                    unlink($url);
                endif;
            endif;
            echo json_encode(["success" => true, "title" => "Başarılı!", "message" => "Galeri İçeriği Başarıyla Silindi."]);
        else :
            echo json_encode(["success" => false, "title" => "Başarısız!", "message" => "Galeri İçeriği Silinirken Hata Oluştu, Lütfen Tekrar Deneyin."]);
        endif;
    }

    public function fileIsActiveSetter($id, $gallery_type)
    {
        if ($id && $gallery_type) {
            $modelName = ($gallery_type == "images" ? "image_model" : ($gallery_type == "files" ? "file_model" : ($gallery_type == "videos" ? "video_model" : "video_url_model")));
            $isActive = (intval($this->input->post("data")) === 1) ? 1 : 0;
            if ($this->$modelName->update(["id" => $id], ["isActive" => $isActive])) {
                echo json_encode(["success" => True, "title" => "İşlem Başarıyla Gerçekleşti", "msg" => "Güncelleme İşlemi Yapıldı"]);
            } else {
                echo json_encode(["success" => False, "title" => "İşlem Başarısız Oldu", "msg" => "Güncelleme İşlemi Yapılamadı"]);
            }
        }
    }

    public function fileRankSetter($gallery_type, $gallery_id)
    {
        $modelName = ($gallery_type == "images" ? "image_model" : ($gallery_type == "files" ? "file_model" : ($gallery_type == "videos" ? "video_model" : "video_url_model")));
        $rows = $this->input->post("rows");

        foreach ($rows as $row) {
            $this->$modelName->update(
                array(
                    "id" => $row["id"],
                    "gallery_id" => $gallery_id
                ),
                array("rank" => $row["position"])
            );
        }
    }
}
