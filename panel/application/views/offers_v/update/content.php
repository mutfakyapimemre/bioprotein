<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="updateOffer" onsubmit="return false" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Adınız Soyadınız</label>
        <input class="form-control form-control-sm rounded-0" placeholder="Adınız Soyadınız" name="full_name" minlength="2" maxlength="70" value="<?= $item->full_name ?>" required>
    </div>
    <div class="form-group">
        <label>Telefon Numaranız</label>
        <input class="form-control form-control-sm rounded-0" placeholder="Telefon Numaranız" name="phone" minlength="11" maxlength="19" value="<?= $item->phone ?>" required>
    </div>
    <div class="form-group">
        <label>E-mail Adresiniz</label>
        <input class="form-control form-control-sm rounded-0" type="email" placeholder="E-mail Adresiniz" name="email" value="<?= $item->email ?>" required>
    </div>
    <div class="form-group">
        <label>Teklif Poliçesi</label>
        <select name="type" id="type" class="form-control form-control-sm rounded-0">
            <?php if (!empty($services)) : ?>
                <?php foreach ($services as $key => $value) : ?>
                    <option value="<?= $value->id ?>" <?= ($item->type == $value->id ? "selected" : null) ?>><?= $value->title ?></option>
                <?php endforeach ?>
            <?php endif ?>
        </select>
    </div>
    <div class="form-group">
        <label>Teklif Notu</label>
        <textarea name="message" id="message" cols="30" rows="10" class="form-control"><?= $item->message ?></textarea>
    </div>
    <button role="button" data-url="<?= base_url("offers/update/$item->id"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnUpdate">Güncelle</button>
    <a href="javascript:void(0)" onclick="closeModal('#offerModal')" class="btn btn-sm btn-outline-danger rounded-0n">İptal</a>
</form>