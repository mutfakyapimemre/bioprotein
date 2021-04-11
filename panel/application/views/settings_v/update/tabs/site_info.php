<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<div class="tab-pane fade show active" id="site-informations" role="tabpanel" aria-labelledby="site-informations-tab">
    <div class="row">
        <div class="form-group col-md-12">
            <label>Şirket Adı</label>
            <input class="form-control form-control-sm rounded-0" placeholder="Şirketin ya da Sitenizin adı" name="company_name" value="<?= $item->company_name; ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label>Slogan</label>
            <input class="form-control form-control-sm rounded-0" placeholder="Sloganınız" name="slogan" value="<?= $item->slogan; ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Telefon 1</label>
            <input class="form-control form-control-sm rounded-0" placeholder="Telefon numaranız" name="phone_1" value="<?= $item->phone_1; ?>" required>
            <?php if (isset($form_error)) { ?>
                <small
                class="float-right input-form-error"> <?= form_error("phone_1"); ?></small>
            <?php } ?>
        </div>
        <div class="form-group col-md-6">
            <label>Telefon 2</label>
            <input class="form-control form-control-sm rounded-0" placeholder="Diğer telefon numaranız (opsiyonel)" name="phone_2" value="<?= $item->phone_2; ?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Fax 1</label>
            <input class="form-control form-control-sm rounded-0" placeholder="Fax numaranız" name="fax_1" value="<?= $item->fax_1; ?>">
        </div>
        <div class="form-group col-md-6">
            <label>Fax 2</label>
            <input class="form-control form-control-sm rounded-0" placeholder="Diğer fax numaranız (opsiyonel)" name="fax_2" value="<?= $item->fax_2; ?>">
        </div>
    </div>
</div>