<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<form id="createEmail" onsubmit="return false" method="post" enctype="multipart/form-data">
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
                <div class="tab-pane fade <?= ($key == 0 ? 'show active' : null )?>" id="lang-<?=$value->lang?>" role="tabpanel" aria-labelledby="lang-<?=$value->lang?>-tab">
                    <div class="form-group">
                        <label>Protokol</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Protokol [Dil : <?=$value->lang?>]" name="protocol[<?=$value->lang?>]" required>
                    </div>
                    <div class="form-group">
                        <label>E-Posta Sunucu Bilgisi</label>
                        <input class="form-control form-control-sm rounded-0" placeholder="Hostname [Dil : <?=$value->lang?>]" name="host[<?=$value->lang?>]" required>
                    </div>
                    <div class="form-group">
                        <label>Port Numarası</label>
                        <input type="text" class="form-control form-control-sm rounded-0" placeholder="Port Numarası [Dil : <?=$value->lang?>]" name="port[<?=$value->lang?>]" required>
                    </div>
                    <div class="form-group">
                        <label>E-Posta Başlık</label>
                        <input type="text" class="form-control form-control-sm rounded-0" placeholder="E-Posta Başlık [Dil : <?=$value->lang?>]" name="user_name[<?=$value->lang?>]" required>
                    </div>
                    <div class="form-group">
                        <label>E-Posta Adresi (User)</label>
                        <input type="email" class="form-control form-control-sm rounded-0" placeholder="E-Posta Adresi (User) [Dil : <?=$value->lang?>]" name="user[<?=$value->lang?>]" required>
                    </div>
                    <div class="form-group">
                        <label>E-Posta Adresine Ait Şifre</label>
                        <input type="password" class="form-control form-control-sm rounded-0" placeholder="E-Posta Adresine Ait Şifre [Dil : <?=$value->lang?>]" name="password[<?=$value->lang?>]" required>
                    </div>
                    <div class="form-group">
                        <label>Kimden Gidecek (From)</label>
                        <input type="email" class="form-control form-control-sm rounded-0" placeholder="Kimden Gidecek (From) [Dil : <?=$value->lang?>]" name="from[<?=$value->lang?>]" required>
                    </div>
                    <div class="form-group">
                        <label>Kime Gidecek (To)</label>
                        <input type="email" class="form-control form-control-sm rounded-0" placeholder="Kime Gidecek (To) [Dil : <?=$value->lang?>]" name="to[<?=$value->lang?>]" required>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <button data-url="<?= base_url("emailsettings/save"); ?>" type="button" class="btn btn-sm btn-outline-primary rounded-0 btnSave">Kaydet</button>
        <a href="javascript:void(0)" onclick="closeModal('#emailModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>