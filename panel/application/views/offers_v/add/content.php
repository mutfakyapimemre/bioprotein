<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="createOffer" onsubmit="return false" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Adınız Soyadınız</label>
        <input class="form-control form-control-sm rounded-0" placeholder="Adınız Soyadınız" name="full_name" required>
    </div>
    <div class="form-group">
        <label>Telefon Numaranız</label>
        <input class="form-control form-control-sm rounded-0" placeholder="Telefon Numaranız" name="phone" required>
    </div>
    <div class="form-group">
        <label>E-mail Adresiniz</label>
        <input class="form-control form-control-sm rounded-0" placeholder="E-mail Adresiniz" name="email" required>
    </div>
    <label>Teklif Poliçesi</label>
    <select name="type" id="type" class="form-control form-control-sm rounded-0">
        <?php if (!empty($services)) : ?>
            <?php foreach ($services as $key => $value) : ?>
                <option value="<?= $value->id ?>"><?= $value->title ?></option>
            <?php endforeach ?>
        <?php endif ?>
    </select>
    <div class="form-group">
        <label>Teklif Başvurusu Notu</label>
        <textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>
    </div>
    <button role="button" data-url="<?= base_url("offers/save"); ?>" class="btn btn-sm btn-outline-primary rounded-0 btnSave">Kaydet</button>
    <a href="javascript:void(0)" onclick="closeModal('#offerModal')" class="btn btn-sm btn-outline-danger rounded-0n">İptal</a>
</form>