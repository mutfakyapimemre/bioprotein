<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="createProduct" onsubmit="return false" action="" method="post" enctype="multipart/form-data">
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
                <div class="tab-pane fade <?= ($key == 0 ? 'show active' : null) ?>" id="lang-<?= $value->lang ?>" role="tabpanel" aria-labelledby="lang-<?= $value->lang ?>-tab">
                    <div class="form-group">
                        <label>Başlık</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Başlık [Dil : <?= $value->lang ?>]" name="title[<?= $value->lang ?>]" required>
                    </div>
                    <div class="form-group">
                        <label>Dış URL</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Dış URL [Dil : <?= $value->lang ?>]" name="external_url[<?= $value->lang ?>]" required>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label>Fiyat</label>
                                <input class="form-control form-control-sm rounded-0" placeholder="Fiyat [Dil : <?= $value->lang ?>]" name="price[<?= $value->lang ?>]" required min="0">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label>İndirim Oranı (%)</label>
                                <input class="form-control form-control-sm rounded-0" type="number" placeholder="İndirim Oranı (%) [Dil : <?= $value->lang ?>]" name="discount[<?= $value->lang ?>]" required min="0" max="100">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Açıklama</label>
                        <textarea name="content[<?= $value->lang ?>]" class="m-0 tinymce" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Paylaşım Tarihi</label>
                        <input type="text" name="sharedAt[<?= $value->lang ?>]" placeholder="Paylaşım Tarihi [Dil : <?= $value->lang ?>]" class="form-control form-control-sm datetimepicker" data-flatpickr data-alt-input="true" data-enable-time="true" data-enable-seconds="true" value="<?= date("Y-m-d H:i:s") ?>" data-default-date="<?= date("Y-m-d H:i:s") ?>" data-date-format="Y-m-d H:i:S" required>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="form-group">
            <label>Ürün Kategorisi</label>
            <select class="rounded-0 tagsInput" multiple name="category_id[]" required>
                <option value="">Ürün Kategorisi Seçiniz.</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category->id; ?>"><?= $category->title; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <button role="button" data-url="<?= base_url("products/save"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnSave">Kaydet</button>
        <a href="javascript:void(0)" onclick="closeModal('#productModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>