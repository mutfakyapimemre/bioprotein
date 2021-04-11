<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="createMenus" onsubmit="return false" method="post" enctype="multipart/form-data">
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
                        <label>Menü Adı</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Menü Adı [Dil : <?= $value->lang ?>]" name="title[<?= $value->lang ?>]" required>
                    </div>
                    <div class="form-group">
                        <label>Menü URL (Sayfa Eklemek İstiyorsanız Boş Bırakmanız Gerekir.)</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Menü URL [Dil : <?= $value->lang ?>]" name="url[<?= $value->lang ?>]">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="form-group">
            <label>Sayfa Linki</label>
            <select class="form-control form-control-sm rounded-0" name="page_id" required>
                <option value="">Sayfa Seçiniz.</option>
                <?php foreach ($pages as $page) : ?>
                    <option value="<?= $page->id; ?>"><?= $page->title; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label>Üst Menü</label>
            <select class="form-control form-control-sm rounded-0" name="top_id" required>
                <option value="">Ana Menü Olarak Belirle.</option>
                <?php foreach ($top_menus as $menu) : ?>
                    <option value="<?= $menu->id; ?>"><?= $menu->title; ?> - <?=$menu->position?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label>Menü Pozisyonu</label>
            <select class="form-control form-control-sm rounded-0" name="position" required>
                <option value="HEADER">HEADER MENÜ</option>
                <option value="HEADER_RIGHT">HEADER SAĞ MENÜ</option>
				<option value="MOBILE">MOBİL MENÜ</option>
                <option value="FOOTER">FOOTER MENÜ</option>
            </select>
        </div>
        <div class="form-group">
            <label>Menü Açılış Türü</label>
            <select class="form-control form-control-sm rounded-0" name="target" required>
                <option value="_self">Varsayılan</option>
                <option value="_blank">Yeni Sekme</option>
                <option value="_parent">Sayfayı ana frame'de aç</option>
                <option value="_top">Sayfayı pencerenin gövdesinde aç</option>
            </select>
        </div>
        <button role="button" data-url="<?= base_url("menus/save"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnSave">Kaydet</button>
        <a href="javascript:void(0)" onclick="closeModal('#menusModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>