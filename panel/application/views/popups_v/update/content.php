<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="updatePopup" onsubmit="return false" method="post" enctype="multipart/form-data">
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
                        <input class="form-control form-control-sm rounded-0" placeholder="Başlık [Dil : <?=$lang?>]" name="title[<?=$lang?>]" value="<?= !empty($item->title->$lang) ? $item->title->$lang : null ?>">
                    </div>
                    <div class="form-group">
                        <label>Açıklama</label>
                        <textarea name="content[<?=$lang?>]" class="m-0 tinymce"><?= !empty($item->content->$lang) ? $item->content->$lang : null; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Paylaşım Tarihi</label>
                        <input type="text" name="sharedAt[<?=$lang?>]" placeholder="Paylaşım Tarihi [Dil : <?=$lang?>]" class="form-control form-control-sm datetimepicker" data-flatpickr data-alt-input="true" data-enable-time="true" data-enable-seconds="true" value="<?= (!empty($item->sharedAt->$lang) ? $item->sharedAt->$lang : date("Y-m-d H:i:s")) ?>" data-default-date="<?= (!empty($item->sharedAt->$lang) ? $item->sharedAt->$lang : date("Y-m-d H:i:s")) ?>" data-date-format="Y-m-d H:i:S" required>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="form-group">
            <label>Hedef Sayfa</label>
            <select name="page" class="form-control form-control-sm rounded-0">
                <?php foreach (get_page_list() as $page => $value) : ?>
                    <option <?= ($page == $item->page) ? "selected" : ""; ?> value="<?= $page; ?>">
                        <?= $value; ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <button role="button" data-url="<?= base_url("popups/update/{$item->id}"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnUpdate">Güncelle</button>
        <a href="javascript:void(0)" onclick="closeModal('#popupModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>