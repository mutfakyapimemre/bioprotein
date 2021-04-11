<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="updateEmail" onsubmit="return false" method="post" enctype="multipart/form-data">
    <div class="mb-3 nav-tabs-horizontal">
        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <?php foreach($settings as $key =>$value):?>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?= ($key == 0 ? 'active' : null )?>" id="lang-<?=$value->lang?>-tab" data-toggle="tab" href="#lang-<?=$value->lang?>" role="tab" aria-controls="lang-<?=$value->lang?>" aria-selected="true">Dil : <?=$value->lang?></a>
            </li>
            <?php endforeach;?>
        </ul>
        <div class="tab-content" id="myTabContent">
            <?php foreach($settings as $key =>$value):?>
                <?php $lang = $value->lang; ?>
                <div class="tab-pane fade <?= ($key == 0 ? 'show active' : null )?>" id="lang-<?=$lang?>" role="tabpanel" aria-labelledby="lang-<?=$lang?>-tab">
                    <div class="form-group">
                        <label>Protokol</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Protokol [Dil : <?=$lang?>]" name="protocol[<?=$lang?>]" value="<?= (!empty($item->protocol->$lang) ? $item->protocol->$lang : null) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>E-Posta Sunucu Bilgisi</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Hostname [Dil : <?=$lang?>]" name="host[<?=$lang?>]" value="<?= (!empty($item->host->$lang) ? $item->host->$lang : null) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Port Numarası</label>
                        <input type="text" class="form-control form-control-sm rounded-0" placeholder="Port Numarası [Dil : <?=$lang?>]" name="port[<?=$lang?>]" value="<?= (!empty($item->port->$lang) ? $item->port->$lang : null) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>E-Posta Başlık</label>
                        <input type="text" class="form-control form-control-sm rounded-0" placeholder="E-Posta Başlık [Dil : <?=$lang?>]" name="user_name[<?=$lang?>]" value="<?= (!empty($item->user_name->$lang) ? $item->user_name->$lang : null) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>E-Posta Adresi (User)</label>
                        <input type="email" class="form-control form-control-sm rounded-0" placeholder="E-Posta Adresi (User) [Dil : <?=$lang?>]" name="user[<?=$lang?>]" value="<?= (!empty($item->user->$lang) ? $item->user->$lang : null) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>E-Posta Adresine Ait Şifre</label>
                        <input type="password" class="form-control form-control-sm rounded-0" placeholder="E-Posta Adresine Ait Şifre [Dil : <?=$lang?>]" name="password[<?=$lang?>]" value="<?= (!empty($item->password->$lang) ? $item->password->$lang : null) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Kimden Gidecek (From)</label>
                        <input type="email" class="form-control form-control-sm rounded-0" placeholder="Kimden Gidecek (From) [Dil : <?=$lang?>]" name="from[<?=$lang?>]" value="<?= (!empty($item->from->$lang) ? $item->from->$lang : null) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Kime Gidecek (To)</label>
                        <input type="email" class="form-control form-control-sm rounded-0" placeholder="Kime Gidecek (To) [Dil : <?=$lang?>]" name="to[<?=$lang?>]" value="<?= (!empty($item->to->$lang) ? $item->to->$lang : null) ?>" required>
                    </div>
                </div>
            <?php endforeach?>
        </div>
    <button type="button" data-url="<?= base_url("emailsettings/update/$item->id"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnUpdate">Kaydet</button>
    <a href="javascript:void(0)" onclick="closeModal('#emailModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>