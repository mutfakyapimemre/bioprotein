<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="createProductCategory" onsubmit="return false" method="post" enctype="multipart/form-data">
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
                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Görsel Seçiniz [Dil : <?= $value->lang ?>]</span>
                        </div>
                        <div class="form-control rounded-0 text-truncate" data-trigger="fileinput"><i class="fa fa-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                        <span class="input-group-append">
                            <span class=" btn btn-outline-primary rounded-0 btn-file"><span class="fileinput-new">Dosya Seç</span><span class="fileinput-exists">Değiştir</span>
                                <input type="hidden"><input type="file" name="img_url[<?= $value->lang ?>]" required>
                            </span>
                            <a href="#" class="btn btn-outline-danger rounded-0 fileinput-exists" data-dismiss="fileinput">Kaldır</a>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="form-group">
                <label>Üst Kategorisi</label>
                <?php if (!empty($categories)) : ?>
                    <select name="top_id" id="top_id" class="form-control">
                        <option value="">Üst Kategori Seçiniz.</option>
                        <?php foreach ($categories as $key => $value) : ?>
                            <option value="<?= $value->id ?>"><?= $value->title ?></option>
                        <?php endforeach ?>
                    </select>
                <?php endif ?>
            </div>
        </div>
        <button role="button" data-url="<?= base_url("product_categories/save"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnSave">Kaydet</button>
        <a href="javascript:void(0)" onclick="closeModal('#productCategoryModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>