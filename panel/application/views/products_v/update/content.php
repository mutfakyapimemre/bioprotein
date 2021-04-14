<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="updateProduct" onsubmit="return false" method="post" enctype="multipart/form-data">
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
                        <input class="form-control form-control-sm rounded-0" placeholder="Başlık [Dil : <?= $lang ?>]" name="title[<?= $lang ?>]" value="<?= !empty($item->title->$lang) ? $item->title->$lang : null; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Dış URL</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Dış URL [Dil : <?= $lang ?>]" name="external_url[<?= $lang ?>]" value="<?= !empty($item->external_url->$lang) ? $item->external_url->$lang : null; ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label>Fiyat</label>
                                <input class="form-control form-control-sm rounded-0" placeholder="Başlık [Dil : <?= $lang ?>]" name="price[<?= $lang ?>]" value="<?= !empty($item->price->$lang) ? $item->price->$lang : null; ?>" required min="0">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label>İndirim Oranı (%)</label>
                                <input class="form-control form-control-sm rounded-0" placeholder="İndirim Oranı (%) [Dil : <?= $lang ?>]" name="discount[<?= $lang ?>]" value="<?= !empty($item->discount->$lang) ? $item->discount->$lang : null; ?>" required min="0" max="100" type="number">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Açıklama</label>
                        <textarea name="content[<?= $lang ?>]" class="m-0 tinymce" required><?= !empty($item->content->$lang) ? $item->content->$lang : null; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Paylaşım Tarihi</label>
                        <input type="text" name="sharedAt[<?= $lang ?>]" placeholder="Paylaşım Tarihi [Dil : <?= $lang ?>]" class="form-control form-control-sm datetimepicker" data-flatpickr data-alt-input="true" data-enable-time="true" data-enable-seconds="true" value="<?= (!empty($item->sharedAt->$lang) ? $item->sharedAt->$lang : date("Y-m-d H:i:s")) ?>" data-default-date="<?= (!empty($item->sharedAt->$lang) ? $item->sharedAt->$lang : date("Y-m-d H:i:s")) ?>" data-date-format="Y-m-d H:i:S" required>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="form-group">
            <label>Ürün Kategorisi</label>
            <?php $selectedCategories = explode(",", $item->category_id) ?>
            <select class="rounded-0 tagsInput" multiple name="category_id[]" required>
                <?php foreach ($categories as $category) : ?>
                    <option <?= (in_array($category->id, $selectedCategories) ? "selected" : null) ?> value="<?= $category->id; ?>"><?= $category->title; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <button role="button" data-url="<?= base_url("products/update/$item->id"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnUpdate">Güncelle</button>
        <a href="javascript:void(0)" onclick="closeModal('#productModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>