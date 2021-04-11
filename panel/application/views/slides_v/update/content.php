<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="updateSlide" onsubmit="return false" method="post" enctype="multipart/form-data">
    <div class="mb-3 nav-tabs-horizontal">
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <?php foreach ($settings as $key => $value) : ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?= ($key == 0 ? 'active' : null) ?>" id="lang-<?= $value->lang ?>-tab" data-toggle="tab" href="#lang-<?= $value->lang ?>" role="tab" aria-controls="lang-<?= $value->lang ?>" aria-selected="true">Dil : <?= $value->lang ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content" id="myTabContent">
            <?php foreach ($settings as $key => $value) : ?>
                <?php $lang = $value->lang; ?>
                <div class="tab-pane fade <?= ($key == 0 ? 'show active' : null) ?>" id="lang-<?= $lang ?>" role="tabpanel" aria-labelledby="lang-<?= $lang ?>-tab">
                    <div class="form-group">
                        <label>Başlık</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Başlık [Dil : <?= $lang ?>]" name="title[<?= $lang ?>]" value="<?= !empty($item->title->$lang) ? $item->title->$lang : null; ?>">
                    </div>
                    <div class="form-group">
                        <label>Açıklama</label>
                        <textarea name="description[<?= $lang ?>]" class="m-0 tinymce"><?= !empty($item->description->$lang) ? $item->description->$lang : null; ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <picture>
                                <img src="<?= get_picture($viewFolder, (!empty($item->img_url->$lang) ? $item->img_url->$lang : null)); ?>" alt="" class="img-fluid">
                            </picture>
                        </div>
                        <div class="col-9">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Görsel Seçiniz [Dil : <?= $lang ?>]</span>
                                </div>
                                <div class="form-control rounded-0 text-truncate" data-trigger="fileinput"><i class="fa fa-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                <span class="input-group-append">
                                    <span class=" btn btn-outline-primary rounded-0 btn-file"><span class="fileinput-new">Dosya Seç</span><span class="fileinput-exists">Değiştir</span>
                                        <input type="hidden"><input type="file" name="img_url[<?= $lang ?>]">
                                    </span>
                                    <a href="#" class="btn btn-outline-danger rounded-0 fileinput-exists" data-dismiss="fileinput">Kaldır</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Buton Kullanımı [Dil : <?= $lang ?>]</label><br>
                        <div class="custom-control custom-switch"><input data-id="<?= $item->id ?>" name="allowButton[<?= $lang ?>]" data-status="<?= (!empty($item->allowButton->$lang) && $item->allowButton->$lang) ? "checked" : ""; ?>" id="customSwitch<?= $item->id ?><?= $lang ?>" type="checkbox" <?= (!empty($item->allowButton->$lang) && $item->allowButton->$lang) ? "checked" : null; ?> class="custom-control-input button_usage_btn"> <label class="custom-control-label" for="customSwitch<?= $item->id ?><?= $lang ?>"></label></div>
						<div class="button-information-container" style="display : <?= (!empty($item->allowButton->$lang) && $item->allowButton->$lang) ? "block" : "none"; ?>">
                        <div class="form-group">
                            <label>Buton Başlık</label>
                            <input class="form-control form-control-sm rounded-0" placeholder="Butonun Üzerindeki Yazı [Dil : <?= $lang ?>]" name="button_caption[<?= $lang ?>]" value="<?= (!empty($item->button_caption->$lang) ? $item->button_caption->$lang : null); ?>">
                        </div>
                        <div class="form-group">
                            <label>URL Bilgisi</label>
                            <input class="form-control form-control-sm rounded-0" placeholder="Butona Basıldığında Gidilecek Olan URL Bilgisi [Dil : <?= $lang ?>]" name="button_url[<?= $lang ?>]" value="<?= (!empty($item->button_url->$lang) ? $item->button_url->$lang : null); ?>">
                        </div>
                    </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Paylaşım Tarihi</label>
                        <input type="text" name="sharedAt[<?= $lang ?>]" placeholder="Paylaşım Tarihi [Dil : <?= $lang ?>]" value="<?= (!empty($item->sharedAt->$lang) ? $item->sharedAt->$lang : date("Y-m-d H:i:s")) ?>" class="form-control form-control-sm datetimepicker" data-flatpickr data-alt-input="true" data-enable-time="true" data-enable-seconds="true" data-default-date="<?= (!empty($item->sharedAt->$lang) ? $item->sharedAt->$lang : date("Y-m-d H:i:s")) ?>" data-date-format="Y-m-d H:i:S">
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <button role="button" data-url="<?= base_url("slides/update/$item->id"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnUpdate">Güncelle</button>
        <a href="javascript:void(0)" onclick="closeModal('#slideModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>