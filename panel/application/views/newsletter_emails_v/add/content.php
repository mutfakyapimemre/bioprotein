<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<form id="createNewsletterEmail" onsubmit="return false" method="post" enctype="multipart/form-data">
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
                        <label>E-mail</label>
                        <input class="form-control form-control-sm rounded-0" type="email" placeholder="E-mail [Dil : <?=$value->lang?>]" name="email[<?=$value->lang?>]" required>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    <button role="button" data-url="<?= base_url("newsletter_emails/save"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnSave">Kaydet</button>
    <a href="javascript:void(0)"  onclick="closeModal('#newsletterEmailModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>