<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<form id="createHomeAds" onsubmit="return false" method="post" enctype="multipart/form-data">
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
                        <input class="form-control form-control-sm rounded-0" placeholder="Başlık [Dil : <?=$value->lang?>]" name="title[<?=$value->lang?>]" required>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Link [Dil : <?=$value->lang?>]" name="url[<?=$value->lang?>]" required>
                    </div>
                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Görsel Seçiniz [Dil : <?=$value->lang?>]</span>
                        </div>
                        <div class="form-control rounded-0 text-truncate" data-trigger="fileinput"><i class="fa fa-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                        <span class="input-group-append">
                            <span class=" btn btn-outline-primary rounded-0 btn-file"><span class="fileinput-new">Dosya Seç</span><span class="fileinput-exists">Değiştir</span>
                                <input type="hidden"><input type="file" name="img_url[<?=$value->lang?>]" required>
                            </span>
                            <a href="#" class="btn btn-outline-danger rounded-0 fileinput-exists" data-dismiss="fileinput">Kaldır</a>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Paylaşım Tarihi</label>
                        <input type="text" name="sharedAt[<?=$value->lang?>]" placeholder="Paylaşım Tarihi [Dil : <?=$value->lang?>]" class="form-control form-control-sm datetimepicker" data-flatpickr data-alt-input="true" data-enable-time="true" data-enable-seconds="true" value="<?= date("Y-m-d H:i:s")?>" data-default-date="<?= date("Y-m-d H:i:s") ?>" data-date-format="Y-m-d H:i:S" required>
                    </div>
                </div>
            <?php endforeach?>
        <button role="button" data-url="<?= base_url("ads/save"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnSave">Kaydet</button>
        <a href="javascript:void(0)" onclick="closeModal('#homeAdsModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>