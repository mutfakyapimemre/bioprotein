<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="updateMenus" onsubmit="return false" action="" method="post">
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
                        <label>Menü Adı </label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Menü Adı [Dil : <?= $lang ?>]" name="title[<?= $lang ?>]" value="<?= (!empty($item->title->$lang) ? $item->title->$lang : null); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Menü URL (Sayfa Eklemek İstiyorsanız Boş Bırakmanız Gerekir.)</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Menü URL [Dil : <?= $lang ?>]" name="url[<?= $lang ?>]" value="<?= (!empty($item->url->$lang) ? $item->url->$lang : null); ?>">
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="form-group">
            <label>Sayfa Linki (URL Eklemek İstiyorsanız Boş Bırakmanız Gerekir.)</label>
            <select class="form-control form-control-sm rounded-0" name="page_id" required>
                <option value="">Sayfa Seçiniz.</option>
                <?php foreach ($pages as $page) : ?>
                    <option value="<?= $page->id; ?>" <?=($item->page_id == $page->id ? "selected" : null)?>><?= $page->title; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label>Üst Menü </label>
            <select class="form-control form-control-sm rounded-0" name="top_id" required>
                <option value="">Ana Menü Olarak Belirle.</option>
                <?php foreach ($top_menus as $menu) : ?>
                    <option value="<?= $menu->id; ?>" <?=($item->top_id == $menu->id ? "selected" : null)?>><?= $menu->title; ?> - <?=$menu->position?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label>Menü Pozisyonu</label>
            <select class="form-control form-control-sm rounded-0" name="position" required>
                <option value="HEADER" <?=($item->position == "HEADER" ? "selected" : null)?>>HEADER MENÜ</option>
                <option value="HEADER_RIGHT" <?=($item->position == "HEADER_RIGHT" ? "selected" : null)?>>HEADER SAĞ MENÜ</option>
				<option value="MOBILE" <?=($item->position == "MOBILE" ? "selected" : null)?>>MOBİL MENÜ</option>
                <option value="FOOTER" <?=($item->position == "FOOTER" ? "selected" : null)?>>FOOTER MENÜ</option>
            </select>
        </div>
        <div class="form-group">
            <label>Menü Açılış Türü</label>
            <select class="form-control form-control-sm rounded-0" name="target" required>
                <option value="_self" <?=($item->target == "_self" ? "selected" : null)?>>Varsayılan</option>
                <option value="_blank" <?=($item->target == "_blank" ? "selected" : null)?>>Yeni Sekme</option>
                <option value="_parent" <?=($item->target == "_parent" ? "selected" : null)?>>Sayfayı ana frame'de aç</option>
                <option value="_top" <?=($item->target == "_top" ? "selected" : null)?>>Sayfayı pencerenin gövdesinde aç</option>
            </select>
        </div>
        <button role="button" data-url="<?= base_url("menus/update/{$item->id}"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnUpdate">Güncelle</button>
        <a href="javascript:void(0)" onclick="closeModal('#menusModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>