<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="updateNewsletterEmail" onsubmit="return false" action="" method="post">
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
                        <label>E-mail </label>
                        <input class="form-control form-control-sm rounded-0" placeholder="E-mail [Dil : <?=$lang?>]" name="email[<?=$lang?>]" value="<?= $item->email->$lang; ?>" required>
                    </div>
                </div>
            <?php endforeach?>
        </div>
    <button role="button" data-url="<?= base_url("newsletter_emails/update/{$item->id}"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnUpdate">Güncelle</button>
    <a href="javascript:void(0)" onclick="closeModal('#newsletterEmailModal')" class="btn btn-sm btn-outline-danger rounded-0">İptal</a>
    </div>
</form>