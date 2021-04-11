<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="updateGallery" onsubmit="return false" method="post">
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
                        <label>Galeri Adı</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Galeri Adı [Dil : <?= $lang ?>]" name="title[<?= $lang ?>]" value="<?= (!empty($item->title->$lang) ? $item->title->$lang : null); ?>" required>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <picture>
                                <img src="<?= get_picture("$viewFolder/{$item->gallery_type}/".(!empty($item->folder_name->$lang) ? $item->folder_name->$lang : null), (!empty($item->img_url->$lang) ? $item->img_url->$lang : null)) ?>" class="img-fluid" alt="<?= (!empty($item->title->$lang) ? $item->title->$lang : null) ?>">
                            </picture>
                        </div>
                        <div class="col-9">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Galeri Kapak Görseli</span>
                                </div>
                                <div class="form-control rounded-0 text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
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
                        <label>Paylaşım Tarihi</label>
                        <input type="text" name="sharedAt[<?= $lang ?>]" placeholder="Paylaşım Tarihi" class="form-control form-control-sm datetimepicker" data-flatpickr data-alt-input="true" data-enable-time="true" data-enable-seconds="true" value="<?= (!empty($item->sharedAt->$lang) ? $item->sharedAt->$lang : null) ?>" data-default-date="<?= (!empty($item->sharedAt->$lang) ? $item->sharedAt->$lang : null) ?>" data-date-format="Y-m-d H:i:S" required>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <button data-url="<?= base_url("galleries/update/$item->id/$item->gallery_type"); ?>" type="button" class="btn btn-sm btn-outline-primary rounded-0 btnUpdate">Güncelle</button>
        <a href="javascript:void(0)" onclick="closeModal('#galleryModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
</form>