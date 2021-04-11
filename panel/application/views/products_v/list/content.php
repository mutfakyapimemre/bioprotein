<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid mt-xl-50 mt-lg-30 mt-15 bg-white p-3">
	<div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<h4 class="mb-3">
				Ürün Listesi
				<a href="javascript:void(0)" data-url="<?= base_url("products/new_form"); ?>" class="btn btn-sm btn-outline-primary rounded-0 float-right createProductBtn"> <i class="fa fa-plus"></i> Yeni Ekle</a>
			</h4>
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<form id="filter_form" onsubmit="return false">
				<div class="d-flex flex-wrap">
					<label for="search" class="flex-fill mx-1">
						<input class="form-control form-control-sm rounded-0" placeholder="Arama Yapmak İçin Metin Girin." type="text" onkeypress="return runScript(event,'productTable')" name="search">
					</label>
					<label for="clear_button" class="mx-1">
						<button class="btn btn-sm btn-outline-danger rounded-0 " onclick="clearFilter('filter_form','productTable')" id="clear_button" data-toggle="tooltip" data-placement="top" data-title="Filtreyi Temizle" data-original-title="" title=""><i class="fa fa-eraser"></i></button>
					</label>
					<label for="search_button" class="mx-1">
						<button class="btn btn-sm btn-outline-success rounded-0 " onclick="reloadTable('productTable')" id="search_button" data-toggle="tooltip" data-placement="top" data-title="Ürün Ara"><i class="fa fa-search"></i></button>
				</div>
			</form>
			<table class="table table-hover table-striped table-bordered content-container productTable">
				<thead>
					<th class="order"><i class="fa fa-reorder"></i></th>
					<th class="order"><i class="fa fa-reorder"></i></th>
					<th class="w50">#id</th>
					<th>Başlık</th>
					<th>Fiyat</th>
					<th>Yeni Ürün</th>
					<th>Önerilen Ürün</th>
					<th>İndirimli Ürün</th>
					<th>Durumu</th>
					<th>Oluşturulma Tarihi</th>
					<th>Güncelleme Tarihi</th>
					<th>Paylaşım Tarihi</th>
					<th class="nosort">İşlem</th>
				</thead>
				<tbody>

				</tbody>
			</table>
			<script>
				function obj(d) {
					let appendeddata = {};
					$.each($("#filter_form").serializeArray(), function() {
						d[this.name] = this.value;
					});
					return d;
				}
				$(document).ready(function() {
					TableInitializerV2("productTable", obj, {}, "<?= base_url("products/datatable") ?>", "<?= base_url("products/rankSetter") ?>", true);

				});
			</script>
		</div>
	</div>
</div>

<div id="productModal"></div>

<script>
	$(document).ready(function() {
		$(document).on("click", ".createProductBtn", function(e) {
			e.preventDefault();
			e.stopImmediatePropagation();
			let url = $(this).data("url");
			$('#productModal').iziModal('destroy');
			createModal("#productModal", "Yeni Ürün Ekle", "Yeni Ürün Ekle", 600, true, "20px", 0, "#e20e17", "#fff", 1040, function() {
				$.post(url, {}, function(response) {
					$("#productModal .iziModal-content").html(response);
					TinyMCEInit();
					flatPickrInit();
					$(".tagsInput").select2({
						placeholder: 'Ürün Kategorisi Seçiniz.',
						width: 'resolve',
						theme: "classic",
						tags: false,
						tokenSeparators: [',', ' '],
						multiple: true
					});
				});
			});
			openModal("#productModal");
			$("#productModal").iziModal("setFullscreen", false);
		});
		$(document).on("click", ".btnSave", function(e) {
			e.preventDefault();
			e.stopImmediatePropagation();
			let url = $(this).data("url");
			let formData = new FormData(document.getElementById("createProduct"));
			createAjax(url, formData, function() {
				closeModal("#productModal");
				$("#productModal").iziModal("setFullscreen", false);
				reloadTable("productTable");
			});
		});
		$(document).on("click", ".updateProductBtn", function(e) {
			e.preventDefault();
			e.stopImmediatePropagation();
			$('#productModal').iziModal('destroy');
			let url = $(this).data("url");
			createModal("#productModal", "Ürün Düzenle", "Ürün Düzenle", 600, true, "20px", 0, "#e20e17", "#fff", 1040, function() {
				$.post(url, {}, function(response) {
					$("#productModal .iziModal-content").html(response);
					TinyMCEInit();
					flatPickrInit();
					$(".tagsInput").select2({
						placeholder: 'Ürün Kategorisi Seçiniz.',
						width: 'resolve',
						theme: "classic",
						tags: false,
						tokenSeparators: [',', ' '],
						multiple: true
					});
				});
			});
			openModal("#productModal");
			$("#productModal").iziModal("setFullscreen", false);
		});
		$(document).on("click", ".btnUpdate", function(e) {
			e.preventDefault();
			e.stopImmediatePropagation();
			let url = $(this).data("url");
			let formData = new FormData(document.getElementById("updateProduct"));
			createAjax(url, formData, function() {
				closeModal("#productModal");
				$("#productModal").iziModal("setFullscreen", false);
				reloadTable("productTable");
			});
		});
	});
</script>