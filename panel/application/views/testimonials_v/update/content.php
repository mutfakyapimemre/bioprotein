<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="updateTestimonial" onsubmit="return false" method="post" enctype="multipart/form-data">
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
                        <label>Ad Soyad</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Ad Soyad [Dil : <?= $lang ?>]" name="full_name[<?= $lang ?>]" value="<?= !empty($item->full_name->$lang) ? $item->full_name->$lang : null; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Şirket Adı</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Şirket Adı [Dil : <?= $lang ?>]" name="company[<?= $lang ?>]" value="<?= !empty($item->company->$lang) ? $item->company->$lang : null; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Başlık</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Başlık [Dil : <?= $lang ?>]" name="title[<?= $lang ?>]" value="<?= !empty($item->company->$lang) ? $item->title->$lang : null; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Ziyaretçi Notu</label>
                        <textarea class="form-control form-control-sm rounded-0 tinymce" name="content[<?= $lang ?>]" placeholder="Bizimle ilgili mesaj... [Dil : <?= $lang ?>]" required><?= !empty($item->content->$lang) ? $item->content->$lang : null; ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-3 image_upload_container">
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
                        <label>Paylaşım Tarihi</label>
                        <input type="text" name="sharedAt[<?= $lang ?>]" placeholder="Paylaşım Tarihi [Dil : <?= $lang ?>]" class="form-control form-control-sm datetimepicker" data-flatpickr data-alt-input="true" data-enable-time="true" data-enable-seconds="true" value="<?= (!empty($item->sharedAt->$lang) ? $item->sharedAt->$lang : null) ?>" data-default-date="<?= (!empty($item->sharedAt->$lang) ? $item->sharedAt->$lang : null) ?>" data-date-format="Y-m-d H:i:S" required>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <button data-url="<?= base_url("testimonials/update/$item->id"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnUpdate">Güncelle</button>
        <a href="javascript:void(0)" onclick="closeModal('#testimonialModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>