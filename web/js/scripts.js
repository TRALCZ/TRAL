$(document).ready(function () {
	$(".content-wrapper").css('min-height', '845px');
	$(".select2-results__group").hide();

	$('#add_nabidka_polozka').on('click', function () {

		//$(".content-wrapper").css('min-height', '1360px');
		var mh = $(".content-wrapper").css('min-height'); //735px
		var digit = parseInt(mh.replace(/\D+/g, ""));
		var nexth = parseInt(digit + 150); // 785

		$(".content-wrapper").attr('style', 'min-height:' + nexth + 'px;other-styles');

		var count = $(this).data('count');
		$('#nabidka_polozky').append('<div class="polozky-line" id="polozky-line-' + count + '">\
											<div class="col-xs-4">Název: <input type="text" name="polozka' + count + '" id="polozka' + count + '" data-polozka="' + count + '" class="polozky form-control" autocomplete="off" readonly="readonly">\
												<span class="input_close show_modal" data-polozka="' + count + '" data-toggle="modal" data-target="#w3">vyberte</span>&nbsp;\
												<span class="input_close show_konstrukter" data-polozka="' + count + '" data-toggle="konstrukter" data-target="#w4">konstrukter</span>\
												<span class="input_close" data-polozka="' + count + '">odstranit</span>\
												<!--\
												<span style="margin-left: 250px;">\
													<input type="checkbox" id="checkpopis' + count + '" class="checkpopis" style="margin: 0 0 0 0;" data-polozka="' + count + '">&nbsp;&nbsp;Opravit název\
												</span>\
												-->\
											</div>\
											<div class="col-xs-2">Kód: <input type="text" id="kod' + count + '" class="kod form-control" readonly/></div>\
											<div class="col-xs-2">Cena: <input type="text" name="cena' + count + '" id="cena' + count + '" class="cena form-control" data-cena="" readonly/></div>\
											<div class="col-xs-2">Typ ceny: <select name="typ_ceny' + count + '" id="typ_ceny' + count + '" class="typ_ceny form-control" data-polozka="' + count + '" >\
																					<option value="bez_dph">bez DPH</option>\
																					<option value="s_dph">s DPH</option>\
																					<option value="jen_zaklad">jen zaklad</option>\
																			</select>\
											</div>\
											<div class="col-xs-2">Sazba DPH: <select name="sazba_dph' + count + '" id="sazba_dph' + count + '" class="sazba_dph form-control" data-polozka="' + count + '" >\
																					<option value="0">0</option>\
																					<option value="10">10</option>\
																					<option value="15">15</option>\
																					<option value="21" selected>21</option>\
																			</select>\
											</div>\
											<div class="col-xs-2">Pocet MJ: <input type="text" name="pocet' + count + '" id="pocet' + count + '" class="pocet-mj form-control" data-polozka="' + count + '"/></div>\
											<div class="col-xs-2">Sleva: <input type="text" name="sleva' + count + '" id="sleva' + count + '" class="sleva form-control" data-polozka="' + count + '" /></div>\
											<div class="col-xs-2">Celkem: <input type="text" name="celkem' + count + '" id="celkem' + count + '" class="celkem form-control" readonly/></div>\
											<div class="col-xs-2">DPH: <input type="text" name="celkem_dph' + count + '" id="celkem_dph' + count + '" class="celkem_dph form-control" readonly/></div>\
											<div class="col-xs-2">Vcetne DPH: <input type="text" name="vcetne_dph' + count + '" id="vcetne_dph' + count + '" class="vcetne_dph form-control" readonly/></div>\
											<!-- <div class="col-xs-1">CH je zaúčtována? <input type="text" name="is_cenova_hladina' + count + '" id="is_cenova_hladina' + count + '" class="is_cenova_hladina form-control" readonly/></div>-->\
											<div class="col-xs-2"><button class="close-polozka btn btn-danger" data-id="' + count + '">X</button></div>\
											<!-- <div class="col-xs-4" style="float: left;">\
												<div class="form-group">\
													<label class="control-label">Cenová hladina modelu</label>\
													<span id="chadina-m' + count + '" ></span>\
												</div>\
											</div> -->\
											<input type="hidden" name="idpolozka' + count + '" id="idpolozka' + count + '"/>\
											<div class="polozky-under-' + count + '" style="display: none;"></div>\
									</div>');

		var count_new = parseInt(count) + 1;
		$('#add_nabidka_polozka').data('count', count_new);

		var count_polozka = $("#count_polozka").val();
		var new_count_polozka = parseInt(count_polozka) + 1;
		$("#count_polozka").val(new_count_polozka);

		//$(".content-wrapper").css('min-height', '360px');
		//alert("OK");
	});


// Close polozka
	$('#nabidka_polozky').on('click', '.close-polozka', function () {
		var id = $(this).data('id');
		//
		$("#celkem" + id).val('');
		$("#vcetne_dph" + id).val('');

		
		// Summa
		var count_polozka = $("#count_polozka").val();
		var allsum = 0; var allsum2 = 0;

		for(i=1; i<= count_polozka; i++)
		{
			if ($("#celkem" + i).length)
			{
				var sum = $("#celkem" + i).val();


				if (sum.length > 0)
				{
					sum = parseFloat(sum);
				}
				else
				{
					sum = 0;
				}
				allsum = parseFloat(allsum) + parseFloat(sum);

				var sum2 = $("#vcetne_dph" + i).val();
				if (sum2.length > 0)
				{
					sum2 = parseFloat(sum2);
				}
				else
				{
					sum2 = 0;
				}
				allsum2 = parseFloat(allsum2) + parseFloat(sum2);
			}
		}

		$("#suma-celkem").val(parseFloat(allsum).toFixed(2));
		$("#suma-vcetene-dph").val(parseFloat(allsum2).toFixed(2));
		
		// Faktura zalohova
		var suma = $("#suma-celkem").val();
		var suma_dph = $("#suma-vcetene-dph").val();
		var castka_procent = $("#castka_procent").val();
		var celkem = (castka_procent*suma / 100).toFixed(2);
		$("#fakturyzalohove-celkem").val(celkem);
		var celkem_dph = (castka_procent*suma_dph / 100).toFixed(2);
		$("#fakturyzalohove-celkem_dph").val(celkem_dph);
		
		
		
		
		
		$('#polozky-line-' + id).remove();
	});


// tree menu
	$('.tree-data-container').jstree({
		'plugins': ["wholerow"],
	});

	$('#nabidka_polozky').on('input', '.pocet-mj', function () {
		var mj = $(this).val();
		var id = $(this).data('polozka');

		var cena = $("#cena" + id).val();
		var typ_ceny = $("#typ_ceny" + id).val();
		var sazba_dph = $("#sazba_dph" + id).val();

		if (typ_ceny === 'bez_dph')
		{
			var celkem = (cena * mj).toFixed(2);
			$("#celkem" + id).val(celkem);

			var celkem_dph = ((celkem / 100) * sazba_dph).toFixed(2);
			$("#celkem_dph" + id).val(celkem_dph);

			var vcetne_dph = (parseFloat(celkem) + parseFloat(celkem_dph)).toFixed(2);
			$("#vcetne_dph" + id).val(vcetne_dph);
		}

		if (typ_ceny === 's_dph')
		{
			var vcetne_dph = (cena * mj).toFixed(2);
			$("#vcetne_dph" + id).val(vcetne_dph);

			var celkem = ((vcetne_dph * 100) / (parseFloat(100) + parseFloat(sazba_dph))).toFixed(2);
			$("#celkem" + id).val(celkem);

			var celkem_dph = (parseFloat(vcetne_dph) - parseFloat(celkem)).toFixed(2);
			$("#celkem_dph" + id).val(celkem_dph);
		}
		
		// Summa
		var count_polozka = $("#count_polozka").val();
		var allsum = 0; var allsum2 = 0;

		for(i=1; i<= count_polozka; i++)
		{
			if ($("#celkem" + i).length)
			{
				var sum = $("#celkem" + i).val();


				if (sum.length > 0)
				{
					sum = parseFloat(sum);
				}
				else
				{
					sum = 0;
				}
				allsum = parseFloat(allsum) + parseFloat(sum);

				var sum2 = $("#vcetne_dph" + i).val();
				if (sum2.length > 0)
				{
					sum2 = parseFloat(sum2);
				}
				else
				{
					sum2 = 0;
				}
				allsum2 = parseFloat(allsum2) + parseFloat(sum2);
			}
		}

		$("#suma-celkem").val(parseFloat(allsum).toFixed(2));
		$("#suma-vcetene-dph").val(parseFloat(allsum2).toFixed(2));
		
		// Faktura zalohova
		var suma = $("#suma-celkem").val();
		var suma_dph = $("#suma-vcetene-dph").val();
		var castka_procent = $("#castka_procent").val();
		var celkem = (castka_procent*suma / 100).toFixed(2);
		$("#fakturyzalohove-celkem").val(celkem);
		var celkem_dph = (castka_procent*suma_dph / 100).toFixed(2);
		$("#fakturyzalohove-celkem_dph").val(celkem_dph);

	});


	$('#nabidka_polozky').on('change', '.typ_ceny', function () {

		var id = $(this).data('polozka');
		var typ_ceny = $(this).val();

		var cena = $("#cena" + id).val();
		var mj = $("#pocet" + id).val();
		var sazba_dph = $("#sazba_dph" + id).val();

		if (typ_ceny === 'bez_dph')
		{
			var celkem = (cena * mj).toFixed(2);
			$("#celkem" + id).val(celkem);

			var celkem_dph = ((celkem / 100) * sazba_dph).toFixed(2);
			$("#celkem_dph" + id).val(celkem_dph);

			var vcetne_dph = (parseFloat(celkem) + parseFloat(celkem_dph)).toFixed(2);
			$("#vcetne_dph" + id).val(vcetne_dph);
		}

		if (typ_ceny === 's_dph')
		{
			var vcetne_dph = (cena * mj).toFixed(2);
			$("#vcetne_dph" + id).val(vcetne_dph);

			var celkem = ((vcetne_dph * 100) / (parseFloat(100) + parseFloat(sazba_dph))).toFixed(2);
			$("#celkem" + id).val(celkem);

			var celkem_dph = (parseFloat(vcetne_dph) - parseFloat(celkem)).toFixed(2);
			$("#celkem_dph" + id).val(celkem_dph);
		}
		
		// Summa
		var count_polozka = $("#count_polozka").val();
		var allsum = 0; var allsum2 = 0;

		for(i=1; i<= count_polozka; i++)
		{
			if ($("#celkem" + i).length)
			{
				var sum = $("#celkem" + i).val();


				if (sum.length > 0)
				{
					sum = parseFloat(sum);
				}
				else
				{
					sum = 0;
				}
				allsum = parseFloat(allsum) + parseFloat(sum);

				var sum2 = $("#vcetne_dph" + i).val();
				if (sum2.length > 0)
				{
					sum2 = parseFloat(sum2);
				}
				else
				{
					sum2 = 0;
				}
				allsum2 = parseFloat(allsum2) + parseFloat(sum2);
			}
		}

		$("#suma-celkem").val(parseFloat(allsum).toFixed(2));
		$("#suma-vcetene-dph").val(parseFloat(allsum2).toFixed(2));
		
		// Faktura zalohova
		var suma = $("#suma-celkem").val();
		var suma_dph = $("#suma-vcetene-dph").val();
		var castka_procent = $("#castka_procent").val();
		var celkem = (castka_procent*suma / 100).toFixed(2);
		$("#fakturyzalohove-celkem").val(celkem);
		var celkem_dph = (castka_procent*suma_dph / 100).toFixed(2);
		$("#fakturyzalohove-celkem_dph").val(celkem_dph);

	});

	$('#nabidka_polozky').on('change', '.sazba_dph', function () {

		var id = $(this).data('polozka');
		var sazba_dph = $(this).val();

		var cena = $("#cena" + id).val();
		var mj = $("#pocet" + id).val();
		var typ_ceny = $("#typ_ceny" + id).val();

		if (typ_ceny === 'bez_dph')
		{
			var celkem = (cena * mj).toFixed(2);
			$("#celkem" + id).val(celkem);

			var celkem_dph = ((celkem / 100) * sazba_dph).toFixed(2);
			$("#celkem_dph" + id).val(celkem_dph);

			var vcetne_dph = (parseFloat(celkem) + parseFloat(celkem_dph)).toFixed(2);
			$("#vcetne_dph" + id).val(vcetne_dph);
		}

		if (typ_ceny === 's_dph')
		{
			var vcetne_dph = (cena * mj).toFixed(2);
			$("#vcetne_dph" + id).val(vcetne_dph);

			var celkem = ((vcetne_dph * 100) / (parseFloat(100) + parseFloat(sazba_dph))).toFixed(2);
			$("#celkem" + id).val(celkem);

			var celkem_dph = (parseFloat(vcetne_dph) - parseFloat(celkem)).toFixed(2);
			$("#celkem_dph" + id).val(celkem_dph);
		}
		
		// Summa
		var count_polozka = $("#count_polozka").val();
		var allsum = 0; var allsum2 = 0;

		for(i=1; i<= count_polozka; i++)
		{
			if ($("#celkem" + i).length)
			{
				var sum = $("#celkem" + i).val();


				if (sum.length > 0)
				{
					sum = parseFloat(sum);
				}
				else
				{
					sum = 0;
				}
				allsum = parseFloat(allsum) + parseFloat(sum);

				var sum2 = $("#vcetne_dph" + i).val();
				if (sum2.length > 0)
				{
					sum2 = parseFloat(sum2);
				}
				else
				{
					sum2 = 0;
				}
				allsum2 = parseFloat(allsum2) + parseFloat(sum2);
			}
		}

		$("#suma-celkem").val(parseFloat(allsum).toFixed(2));
		$("#suma-vcetene-dph").val(parseFloat(allsum2).toFixed(2));
		
		// Faktura zalohova
		var suma = $("#suma-celkem").val();
		var suma_dph = $("#suma-vcetene-dph").val();
		var castka_procent = $("#castka_procent").val();
		var celkem = (castka_procent*suma / 100).toFixed(2);
		$("#fakturyzalohove-celkem").val(celkem);
		var celkem_dph = (castka_procent*suma_dph / 100).toFixed(2);
		$("#fakturyzalohove-celkem_dph").val(celkem_dph);
		
	});

	$('#nabidka_polozky').on('input', '.sleva', function () {

		var id = $(this).data('polozka');
		var sleva = $(this).val() * 1;
		var procent = parseInt(100) - parseFloat(sleva);

		var old_cena = $("#cena" + id).data('cena');
		var cena = (old_cena * procent / 100).toFixed(2);
		$("#cena" + id).val(cena);

		var mj = $("#pocet" + id).val();


		var typ_ceny = $("#typ_ceny" + id).val();
		var sazba_dph = $("#sazba_dph" + id).val();

		if (typ_ceny === 'bez_dph')
		{
			var celkem = (cena * mj).toFixed(2);
			$("#celkem" + id).val(celkem);

			var celkem_dph = ((celkem / 100) * sazba_dph).toFixed(2);
			$("#celkem_dph" + id).val(celkem_dph);

			var vcetne_dph = (parseFloat(celkem) + parseFloat(celkem_dph)).toFixed(2);
			$("#vcetne_dph" + id).val(vcetne_dph);
		}

		if (typ_ceny === 's_dph')
		{
			var vcetne_dph = (cena * mj).toFixed(2);
			$("#vcetne_dph" + id).val(vcetne_dph);

			var celkem = ((vcetne_dph * 100) / (parseFloat(100) + parseFloat(sazba_dph))).toFixed(2);
			$("#celkem" + id).val(celkem);

			var celkem_dph = (parseFloat(vcetne_dph) - parseFloat(celkem)).toFixed(2);
			$("#celkem_dph" + id).val(celkem_dph);
		}
		
		// Summa
		var count_polozka = $("#count_polozka").val();
		var allsum = 0; var allsum2 = 0;

		for(i=1; i<= count_polozka; i++)
		{
			if ($("#celkem" + i).length)
			{
				var sum = $("#celkem" + i).val();


				if (sum.length > 0)
				{
					sum = parseFloat(sum);
				}
				else
				{
					sum = 0;
				}
				allsum = parseFloat(allsum) + parseFloat(sum);

				var sum2 = $("#vcetne_dph" + i).val();
				if (sum2.length > 0)
				{
					sum2 = parseFloat(sum2);
				}
				else
				{
					sum2 = 0;
				}
				allsum2 = parseFloat(allsum2) + parseFloat(sum2);
			}
		}

		$("#suma-celkem").val(parseFloat(allsum).toFixed(2));
		$("#suma-vcetene-dph").val(parseFloat(allsum2).toFixed(2));
		
		// Faktura zalohova
		var suma = $("#suma-celkem").val();
		var suma_dph = $("#suma-vcetene-dph").val();
		var castka_procent = $("#castka_procent").val();
		var celkem = (castka_procent*suma / 100).toFixed(2);
		$("#fakturyzalohove-celkem").val(celkem);
		var celkem_dph = (castka_procent*suma_dph / 100).toFixed(2);
		$("#fakturyzalohove-celkem_dph").val(celkem_dph);
		
	});

	$('#nabidka_polozky').on('click', '.input_close', function () {

		var id = $(this).data('polozka');
		$("#polozka" + id).val('');
		$("#kod" + id).val('');
		$("#cena" + id).val('');
		$("#pocet" + id).val('');
		$("#sleva" + id).val('');
		$("#celkem" + id).val('');
		$("#celkem_dph" + id).val('');
		$("#vcetne_dph" + id).val('');

		$("#sazba_dph" + id + " option[value='21']").prop('selected', true);
		$("#typ_ceny" + id + " option[value='bez_dph']").prop('selected', true);
		
		
		// Summa
		var count_polozka = $("#count_polozka").val();
		var allsum = 0; var allsum2 = 0;

		for(i=1; i<= count_polozka; i++)
		{
			if ($("#celkem" + i).length)
			{
				var sum = $("#celkem" + i).val();


				if (sum.length > 0)
				{
					sum = parseFloat(sum);
				}
				else
				{
					sum = 0;
				}
				allsum = parseFloat(allsum) + parseFloat(sum);

				var sum2 = $("#vcetne_dph" + i).val();
				if (sum2.length > 0)
				{
					sum2 = parseFloat(sum2);
				}
				else
				{
					sum2 = 0;
				}
				allsum2 = parseFloat(allsum2) + parseFloat(sum2);
			}
		}

		$("#suma-celkem").val(parseFloat(allsum).toFixed(2));
		$("#suma-vcetene-dph").val(parseFloat(allsum2).toFixed(2));
		
		// Faktura zalohova
		var suma = $("#suma-celkem").val();
		var suma_dph = $("#suma-vcetene-dph").val();
		var castka_procent = $("#castka_procent").val();
		var celkem = (castka_procent*suma / 100).toFixed(2);
		$("#fakturyzalohove-celkem").val(celkem);
		var celkem_dph = (castka_procent*suma_dph / 100).toFixed(2);
		$("#fakturyzalohove-celkem_dph").val(celkem_dph);

	});


	$('#nabidka_polozky').on('keyup keypress', '.pocet-mj', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

	$('#nabidka_polozky').on('keyup keypress', '.sleva', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

	$('#nabidka_polozky').on('keyup keypress', '.kod', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

	$('#nabidka_polozky').on('keyup keypress', '.cena', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

	$('#nabidka_polozky').on('keyup keypress', '.celkem', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

	$('#nabidka_polozky').on('keyup keypress', '.celkem_dph', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

	$('#nabidka_polozky').on('keyup keypress', '.vcetne_dph', function (e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});


	$("#refresh").on("click", function () {
		//_selection = 'Saved'
		$.pjax.reload({container: "#boxPajax"});  //Reload GridView
	});
/*
	$("#tree-data-container").on("click", ".jstree-anchor", function () {
		var id = $(this).children(".category_link").data('id');

		//alert(id);

		$.pjax.reload({
			url: "?SeznamSearch[category_id]=" + id,
			container: "#boxPajax",
			timeout: 2000,
		});


	});
*/	
/*
	$("#tree-data-container").on("click", ".skupiny_link", function () {
		var id = $(this).data('id');

		//alert(id);
		$.pjax.reload({
			url: "?ZakaznikySearch[zakazniky_skupina_id]=" + id,
			container: "#boxPajax",
			timeout: 2000,
		});

	});
*/

	$(".CSkupiny").on("click", ".jstree-anchor", function () {
		var id = $(this).children(".category_link").data('id');

		//alert(id);

		$.pjax.reload({
			url: "?SeznamSearch[category_id]=" + id,
			container: "#boxPajax",
			timeout: 2000,
		});


	});

	$(".ZSkupiny").on("click", ".jstree-anchor", function () {
		var id = $(this).children(".skupiny_link").data('id');

		//alert(id);

		$.pjax.reload({
			url: "?ZakaznikySearch[zakazniky_skupina_id]=" + id,
			container: "#boxPajax",
			timeout: 2000,
		});


	});
	

	$("#vytvorit-popis").click(function () {

		$("#create-dvere").toggle("slow", function () {

			if ($(this).css('display') == 'none')
			{
				var mh = $(".content-wrapper").css('min-height'); //735px
				var digit = parseInt(mh.replace(/\D+/g, ""));
				var nexth = parseInt(digit - 50); // 785

				$(".content-wrapper").attr('style', 'min-height:' + nexth + 'px;other-styles');
			} else
			{
				var mh = $(".content-wrapper").css('min-height'); //735px
				var digit = parseInt(mh.replace(/\D+/g, ""));
				var nexth = parseInt(digit + 50); // 785

				$(".content-wrapper").attr('style', 'min-height:' + nexth + 'px;other-styles');
			}
		});
	});

// Modal
	
	$('#nabidka_polozky').on('click', '.show_konstrukter', function () {
		var polozka_id = $(this).data('polozka');
		//$('#submit_konstrukter').attr('data-polozka', polozka_id);
		$('#polozka_id').val(polozka_id);
		$('#modal2').modal('show');
		
    });
	
	
	
	
	$('#nabidka_polozky').on('click', '.show_modal', function () {
		var idp = $(this).data('polozka');
		//alert(idp);
		$(".modal-header").html('<span id="modal-polozka-id" style="display: none;">' + idp + '</span> <button class="close" type="button" data-dismiss="modal" aria-hidden="true">×</button>');
	});
	
	$('#select_katalog').on('click', '.show_modal', function () {
		$('#boxCenikySeznam').modal('show');
	});
	
	$('.sklady-seznam-form').on('click', '.show_modal', function () {
		$('#boxSkladySeznam').modal('show');
	});
	
	
	
	$(".nabidky-index").on('click', '#dialog_skupiny', function () {
		$('#modal-view2').modal('show');
	});
	
	$(".zakazniky-index").on('click', '#dialog_skupiny', function () {
		//alert("OK");
		$('#modal-view2').modal('show');
	});
	
	$('#nabidka_zakazniky').on('click', '.show_modal_zakazniky', function () {
		//var idp = $(this).data('polozka');
		//alert(idp);
		$('#modalZ').modal('show');
	});
	
	
	$('.modal').on('click', '.vybrat-zakaznika', function () {
		var id = $(this).data('id');
		var name = $(this).data('name');
		var ico = $(this).data('ico');
		var fulice = $(this).data('fulice');
		var fmesto = $(this).data('fmesto');
		var fpsc = $(this).data('fpsc');
		
		var address = name + ' (ICO: ' + ico + '), ' + fulice + ', ' + fmesto + ', ' + fpsc; 
		
		$('#zakazniky_name').val(address);
		$('#nabidky-zakazniky_id').val(id);
		
		$('#modalZ').modal('hide');
	});
	
	
	$('.modal').on('click', '.vybrat-item', function () {
		
		var modalpolozkaid = $("#modal-polozka-id").text();
		var polozkaid = $(this).data('id');
		var name = $(this).data('name');
		var kod = $(this).data('kod');
		var cena_old = $(this).data('cena');
		//var is_cenova_hladina = $(this).data('is_cenova_hladina');
		//var zakazniky_id = $("#zakazniky_id").val();
		var zakazniky_id = $("#nabidky-zakazniky_id").val();

		$("#idpolozka" + modalpolozkaid).val(polozkaid);
		$("#polozka" + modalpolozkaid).val(name);
		$("#kod" + modalpolozkaid).val(kod);
		//$("#is_cenova_hladina" + modalpolozkaid).val(is_cenova_hladina);

		//alert(polozkaid, zakazniky_id, cena_old, modalpolozkaid);
		
		$.ajax({
			url: "../../site/chladina-modely",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'ids': polozkaid, 'idz': zakazniky_id, 'cena': cena_old, 'modalpolozkaid': modalpolozkaid},
			cache: false,
			success: function (data)
			{
				if (!data.id > 0)
				{
					//alert("OK");
					$('#chadina-m'+ data.modalpolozkaid).html(data.res);
					
					var cena = data.cena;
					
					$("#cena" + data.modalpolozkaid).val(cena);
					$("#cena" + data.modalpolozkaid).data('cena', cena);
					$("#pocet" + data.modalpolozkaid).val('1');
					$("#sleva" + data.modalpolozkaid).val('0.00');
					$("#celkem" + data.modalpolozkaid).val(cena);

					var celkem_dph = ((cena / 100) * 21).toFixed(2);
					$("#celkem_dph" + data.modalpolozkaid).val(celkem_dph);

					var vcetne_dph = (parseFloat(cena) + parseFloat(celkem_dph)).toFixed(2);
					$("#vcetne_dph" + data.modalpolozkaid).val(vcetne_dph);
					
					//$("#is_cenova_hladina" + data.modalpolozkaid).val('Ano');
					
					
					
					// Summa
					var count_polozka = $("#count_polozka").val();
					var allsum = 0; var allsum2 = 0;

					for(i=1; i<= count_polozka; i++)
					{
						if ($("#celkem" + i).length)
						{
							var sum = $("#celkem" + i).val();


							if (sum.length > 0)
							{
								sum = parseFloat(sum);
							}
							else
							{
								sum = 0;
							}
							allsum = parseFloat(allsum) + parseFloat(sum);

							var sum2 = $("#vcetne_dph" + i).val();
							if (sum2.length > 0)
							{
								sum2 = parseFloat(sum2);
							}
							else
							{
								sum2 = 0;
							}
							allsum2 = parseFloat(allsum2) + parseFloat(sum2);
						}
					}

					$("#suma-celkem").val(parseFloat(allsum).toFixed(2));
					$("#suma-vcetene-dph").val(parseFloat(allsum2).toFixed(2));
					
					// Faktura zalohova
					var suma = $("#suma-celkem").val();
					var suma_dph = $("#suma-vcetene-dph").val();
					var castka_procent = $("#castka_procent").val();
					var celkem = (castka_procent*suma / 100).toFixed(2);
					$("#fakturyzalohove-celkem").val(celkem);
					var celkem_dph = (castka_procent*suma_dph / 100).toFixed(2);
					$("#fakturyzalohove-celkem_dph").val(celkem_dph);
					
					
					

				}
				else
				{
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná1');
			}
		});
		
		$('.modal.in').modal('hide');
		$('#btn_submit').attr('dis', false);
		
		
	});
	
	
	
	
	

	$('#nabidka_polozky').on('change', '.checkpopis', function () {
		var id = $(this).data('polozka');
		var znac = $("#checkpopis" + id).prop("checked");

		if (znac === true)
		{
			$("#polozka" + id).prop('readonly', false);
		} else if (znac === false)
		{
			$("#polozka" + id).prop('readonly', true);
		}
	});

// ARES
	$('#ares').on('click', function () {
		// zobrazíme obrázek s loaderem
		//$("#ajax_loader").show();
		
		var ico = $("#zakazniky-ico").val();
		var idz = $("#id_zakaznika_field").val();
		
		$.ajax({
			url: "../../site/check",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'ico': ico, 'idz': idz},
			cache: false,
			success: function (data) {

				if (data.count > 0) 
				{
					//alert(data.count);   
					//$(".alert").toggleClass('in out');
					$('#modal-view2').modal('show');
					$("#znac-select").text(data.id);
					$("#znac-firma").text(data.name);
				} 
				else 
				{
					
					//var ico = '27909590';
					$.ajax({
						url: "../../site/ares",
						contentType: "application/json; charset=utf-8",
						dataType: "json",
						data: "ico=" + ico,
						cache: false,
						success: function (data) {

							//alert('OK');

							$("#ajax_loader").hide();
							if (data.stav === 'ok') {

								$('#zakazniky-dic').val(data.dic);                // DIČ
								$('#zakazniky-spolehlivy_platce_dph').val(data.spolehlivy_platce_dph);                // DIČ
								
								if(data.spolehlivy_platce_dph === "Ne")
								{
									$("#zakazniky-spolehlivy_platce_dph").css("color", "red");
								}
								else
								{
									$("#zakazniky-spolehlivy_platce_dph").css("color", "");
								}
								
								$('#zakazniky-o_name').val(data.firma);    // název firmy
								//$('#select2-zakazniky-o_countries_id-container').val(cname);    // město
								//$('#zakazniky-o_countries_id').append(new Option(data.countries, cname));    // stat

								$('#select2-zakazniky-o_countries_id-container').attr("title", data.countries);    // stat
								$('#select2-zakazniky-o_countries_id-container').html('<span class="select2-selection__clear">×</span>' + data.countries);
								$("#zakazniky-o_countries_id option").each(function(){
									if ($(this).text() === data.countries)
									  $(this).attr("selected", "selected");
								  });

								$('#zakazniky-o_ulice').val(data.ulice);    // ulice včetně čísla popisného
								$('#zakazniky-o_mesto').val(data.mesto);    // město
								$('#zakazniky-o_psc').val(data.psc);                // PSČ
								//$('#zakazniky-o_countries_id').hide();                // PSČ

								if (data.jmeno !== '') {
									$("#jmeno").val(data.jmeno);    // jméno když máme živnostníka
								}
								if (data.prijmeni !== '') {
									$("#prijmeni").val(data.prijmeni);      // příjmení když máme živnostníka
								}
								//alert('Název a sídlo firmy bylo vyplněno z databáze ARES.');
							} else {
								alert('IČ firmy nebylo v databázi ARES nalezeno');
							}
						},
						error: function (data, errorThrown) {
							//alert('Požadavek selhal: '+errorThrown);
							alert('Databáze ARES není dostupná');
						}
					});
					
				}

			},
			error: function (data, errorThrown)
			{
				alert('Požadavek selhal: '+errorThrown);
				//alert('Chyba! Databáze není dostupná 2');
			}
		});
		
		
		
		
		
		
	});


	$("#f-shodne").click(function () {
		var name = $("#zakazniky-o_name").val();
		var ulice = $("#zakazniky-o_ulice").val();
		var mesto = $("#zakazniky-o_mesto").val();
		var psc = $("#zakazniky-o_psc").val();

		$('#zakazniky-f_name').val(name);
		$('#zakazniky-f_ulice').val(ulice);
		$('#zakazniky-f_mesto').val(mesto);
		$('#zakazniky-f_psc').val(psc);


	});

	$("#p-shodne").click(function () {
		var name = $("#zakazniky-o_name").val();
		var ulice = $("#zakazniky-o_ulice").val();
		var mesto = $("#zakazniky-o_mesto").val();
		var psc = $("#zakazniky-o_psc").val();
		
		$('#zakazniky-p_name').val(name);
		$('#zakazniky-p_ulice').val(ulice);
		$('#zakazniky-p_mesto').val(mesto);
		$('#zakazniky-p_psc').val(psc);


	});
	
	
	$("#zakazniky-is_fa").change(function(){
		if($(this).is(":checked"))
		{
			$("#fa_div").show();
		}
		else
		{
			$("#fa_div").hide();
		}
	});
			
	$("#zakazniky-is_pa").change(function(){
		if($(this).is(":checked"))
		{
			$("#pa_div").show();
		}
		else
		{
			$("#pa_div").hide();
		}
	});
	
	
	/* Tabs */

	$('.tabs .tab-links a').on('click', function (e) {
		var currentAttrValue = $(this).attr('href');

		// Show/Hide Tabs
		$('.tabs ' + currentAttrValue).fadeIn(400).siblings().hide();

		// Change/remove current tab to active
		$(this).parent('li').addClass('active').siblings().removeClass('active');

		e.preventDefault();
	});


// Ceniki

	$('#add_nabidka_polozka_c').on('click', function () {

		//$(".content-wrapper").css('min-height', '1360px');
		var mh = $(".content-wrapper").css('min-height'); //735px
		var digit = parseInt(mh.replace(/\D+/g, ""));
		var nexth = parseInt(digit + 150); // 785

		$(".content-wrapper").attr('style', 'min-height:' + nexth + 'px;other-styles');

		var count = $(this).data('count');
		$('#nabidka_polozky').append('<div class="polozky-line" id="polozky-line-' + count + '">\
											<div class="col-xs-4">Název: <input type="text" name="polozka' + count + '" id="polozka' + count + '" data-polozka="' + count + '" class="polozky form-control" autocomplete="off" readonly="readonly">\
												<span class="input_close show_modal" data-polozka="' + count + '" data-toggle="modal" data-target="#w3">vyberte</span>&nbsp;\
												<span class="input_close" data-polozka="' + count + '">odstranit</span>\
											</div>\
											<div class="col-xs-2">Kód: <input type="text" id="kod' + count + '" class="kod form-control" readonly/></div>\
											<div class="col-xs-2">Cena: <input type="text" name="cena' + count + '" id="cena' + count + '" class="cena form-control" data-cena=""/></div>\
											<div class="col-xs-2">Typ ceny: <input type="text" name="typ_ceny' + count + '" id="typ_ceny' + count + '" class="typ_ceny form-control" data-cena="" value="bez_dph" readonly /></div>\
											<div class="col-xs-2"><button class="close-polozka btn btn-danger" data-id="' + count + '">X</button></div>\
											<input type="hidden" name="idpolozka' + count + '" id="idpolozka' + count + '"/>\
											<div class="polozky-under-' + count + '" style="display: none;"></div>\
									</div>');

		var count_new = parseInt(count) + 1;
		$('#add_nabidka_polozka_c').data('count', count_new);

		var count_polozka = $("#count_polozka").val();
		var new_count_polozka = parseInt(count_polozka) + 1;
		$("#count_polozka").val(new_count_polozka);

		//$(".content-wrapper").css('min-height', '360px');
		//alert("OK");
	});


	$("[id^='modal-btn-']").on('click', function () {

		var id = $(this).data('id');
		var controller = $(this).data('controller'); // nabidky

		$.ajax({
			url: "../../site/log",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id': id, 'controller': controller},
			cache: false,
			success: function (data) {

				if (!data.id > 0) {
					//alert(data.controller);   
					var head = "<button class='close' type='button' data-dismiss='modal' aria-hidden='true'>×</button><span style='color: #FFF; font-weight: bold;'>Log nabídky č. " + id + "</span>";
					$('#modal').modal('show').find('.modal-dialog').find('.modal-content').find('.modal-header').html(head);
					$('#modal').find('#modal-content').html(data.table);

				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná2');
			}
		});
	});

	$(".modal-log").parent().parent().css("width", "800px").css("margin-left", "-90px");



// Int. dvere

	$('#typ1').on('change', function () {
		var id_t = this.value;
		var id_n = $("#norma1").val();
		var id_m = $("#model1").val();
		var id_o = $("#odstin1").val();
		var id_r = $("#rozmer1").val(); // 2
		var id_ot = $("#otevirani1").val(); // 2
		var id_tz = $("#typzamku1").val(); // 2
		var id_v = $("#vypln1").val();
		var id_vt = $("#ventilace1").val();

		//alert(id_r);
		//var cena_bez_dph = $("#cena_bez_dph").val();
		//var cena_s_dph = $("#cena_s_dph").val();

		$.ajax({
			url: "../../site/cena",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_t': id_t, 'id_n': id_n, 'id_m': id_m, 'id_o': id_o, 'id_r': id_r, 'id_ot': id_ot, 'id_tz': id_tz, 'id_v': id_v, 'id_vt': id_vt},
			cache: false,
			success: function (data) {

				if (!data.id > 0) {
					$('#seznam-name').val(data.name);
				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná3');
			}
		});
	});

	$('#norma1').on('change', function () {
		var id_t = $("#typ1").val(); // 2
		var id_n = this.value; // 2
		var id_m = $("#model1").val();
		var id_o = $("#odstin1").val();
		var id_r = $("#rozmer1").val(); // 2
		var id_ot = $("#otevirani1").val(); // 2
		var id_tz = $("#typzamku1").val(); // 2
		var id_v = $("#vypln1").val();
		var id_vt = $("#ventilace1").val();

		//alert(id_r);
		//var cena_bez_dph = $("#cena_bez_dph").val();
		//var cena_s_dph = $("#cena_s_dph").val();

		$.ajax({
			url: "../../site/cena",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_t': id_t, 'id_n': id_n, 'id_m': id_m, 'id_o': id_o, 'id_r': id_r, 'id_ot': id_ot, 'id_tz': id_tz, 'id_v': id_v, 'id_vt': id_vt},
			cache: false,
			success: function (data) {

				if (!data.id > 0) {

					$('#seznam-cena_bez_dph').val(data.cena_bez_dph);
					$('#seznam-cena_s_dph').val(data.cena_s_dph);

					$('#seznam-name').val(data.name);
				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná4');
			}
		});
	});

	$('#rada1').on('change', function () {
		var id_rd = this.value;
		
		$.ajax({
			url: "../../site/rada",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_rd': id_rd},
			cache: false,
			success: function (data)
			{
				$('#seznam-zakazniky_id').val(data.dodavatele_id);
				$('#seznam-dodavatele').val(data.dodavatele_name);
			},
			error: function (data, errorThrown)
			{
				alert('Požadavek selhal: '+errorThrown);
				//alert('Chyba! Databáze není dostupná 2');
			}	
		});
		
	});

	$('#model1').on('change', function () {
		
		var cpl = $("#cpl").val(); // kolvo prop
		
		var cpa = [];
		for(i = 0; i < cpl; i++)
		{
			if( $("#prplt"+i).val() !== "")
			{
				cpa[i] = $("#prplt"+i).val();
			}
		}

		var id_t = 1; // 2
		var id_n = 1; // 2
		var id_m = this.value;
		var id_o = 0;
		var id_r = 1; // 2
		var id_ot = 1; // 2
		var id_tz = 1; // 2
		var id_v = 1;
		var id_vt = 1;

		$.ajax({
			url: "../../site/cena",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_t': id_t, 'id_n': id_n, 'id_m': id_m, 'id_o': id_o, 'id_r': id_r, 'id_ot': id_ot, 'id_tz': id_tz, 'id_v': id_v, 'id_vt': id_vt, 'cpa': cpa},
			cache: false,
			success: function (data) {
			
				if (!data.id > 0) {

					$('#seznam-cena_bez_dph').val(data.cena_bez_dph);
					//$('#seznam-cena_s_dph').val(data.cena_s_dph);

					$('#vypln1').data('zkratka', data.zkratka);

					$('#seznam-name').val(data.name);

					var vypln1_div = data.vypln1_div;
					//var opt = $('#vypln1').clone(); // save the option
					if (vypln1_div === 0)
					{
						$('#vypln1_div').hide();
						$('#vypln1').val("").trigger("change");
					} else
					{
						$('#vypln1_div').show();
						$('#vypln1').val("1").trigger("change");
					}



				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná5');
			}
		});
	});

	$('#odstin1').on('change', function () {
		
		var cpl = $("#cpl").val(); // kolvo prop
		var cpa = [];
		for(i = 0; i < cpl; i++)
		{
			if( $("#prplt"+i).val() !== "")
			{
				cpa[i] = $("#prplt"+i).val();
			}
		}
		
		var id_t = $("#typ1").val(); // 2
		var id_n = $("#norma1").val(); // 2
		var id_m = $("#model1").val();
		var id_o = this.value;
		var id_r = $("#rozmer1").val(); // 2
		var id_ot = $("#otevirani1").val(); // 2
		var id_tz = $("#typzamku1").val(); // 2
		var id_v = $("#vypln1").val();
		var id_vt = $("#ventilace1").val();

		//alert(id_o);
		//var cena_bez_dph = $("#cena_bez_dph").val();
		//var cena_s_dph = $("#cena_s_dph").val();

		$.ajax({
			url: "../../site/cena",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_t': id_t, 'id_n': id_n, 'id_m': id_m, 'id_o': id_o, 'id_r': id_r, 'id_ot': id_ot, 'id_tz': id_tz, 'id_v': id_v, 'id_vt': id_vt, 'cpa': cpa},
			cache: false,
			success: function (data) {

				if (!data.id > 0) {

					$('#seznam-cena_bez_dph').val(data.cena_bez_dph);
					$('#seznam-cena_s_dph').val(data.cena_s_dph);

					$('#seznam-name').val(data.name);

				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná6');
			}
		});
	});

	$('#rozmer1').on('change', function () {
		
		var cpl = $("#cpl").val(); // kolvo prop
		var cpa = [];
		for(i = 0; i < cpl; i++)
		{
			if( $("#prplt"+i).val() !== "")
			{
				cpa[i] = $("#prplt"+i).val();
			}
		}
		
		var id_t = $("#typ1").val(); // 2
		var id_n = $("#norma1").val(); // 2
		var id_m = $("#model1").val();
		var id_o = $("#odstin1").val();
		var id_r = this.value; // 2
		var id_ot = $("#otevirani1").val(); // 2
		var id_tz = $("#typzamku1").val(); // 2
		var id_v = $("#vypln1").val();
		var id_vt = $("#ventilace1").val();

		//alert(id_r);
		//var cena_bez_dph = $("#cena_bez_dph").val();
		//var cena_s_dph = $("#cena_s_dph").val();

		$.ajax({
			url: "../../site/cena",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_t': id_t, 'id_n': id_n, 'id_m': id_m, 'id_o': id_o, 'id_r': id_r, 'id_ot': id_ot, 'id_tz': id_tz, 'id_v': id_v, 'id_vt': id_vt, 'cpa': cpa},
			cache: false,
			success: function (data) {

				if (!data.id > 0) {

					$('#seznam-cena_bez_dph').val(data.cena_bez_dph);
					$('#seznam-cena_s_dph').val(data.cena_s_dph);

					$('#seznam-name').val(data.name);

				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná7');
			}
		});
	});

	$('#otevirani1').on('change', function () {
		
		var cpl = $("#cpl").val(); // kolvo prop
		var cpa = [];
		for(i = 0; i < cpl; i++)
		{
			if( $("#prplt"+i).val() !== "")
			{
				cpa[i] = $("#prplt"+i).val();
			}
		}
		
		var id_t = $("#typ1").val(); // 2
		var id_n = $("#norma1").val(); // 2
		var id_m = $("#model1").val();
		var id_o = $("#odstin1").val();
		var id_r = $("#rozmer1").val(); // 2
		var id_ot = this.value; // 2
		var id_tz = $("#typzamku1").val(); // 2
		var id_v = $("#vypln1").val();
		var id_vt = $("#ventilace1").val();

		//alert(id_r);
		//var cena_bez_dph = $("#cena_bez_dph").val();
		//var cena_s_dph = $("#cena_s_dph").val();

		$.ajax({
			url: "../../site/cena",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_t': id_t, 'id_n': id_n, 'id_m': id_m, 'id_o': id_o, 'id_r': id_r, 'id_ot': id_ot, 'id_tz': id_tz, 'id_v': id_v, 'id_vt': id_vt, 'cpa': cpa},
			cache: false,
			success: function (data) {

				if (!data.id > 0) {

					$('#seznam-cena_bez_dph').val(data.cena_bez_dph);
					$('#seznam-cena_s_dph').val(data.cena_s_dph);

					$('#seznam-name').val(data.name);

				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná8');
			}
		});
	});

	$('#typzamku1').on('change', function () {
		
		var cpl = $("#cpl").val(); // kolvo prop
		var cpa = [];
		for(i = 0; i < cpl; i++)
		{
			if( $("#prplt"+i).val() !== "")
			{
				cpa[i] = $("#prplt"+i).val();
			}
		}
		
		var id_t = $("#typ1").val(); // 2
		var id_n = $("#norma1").val(); // 2
		var id_m = $("#model1").val();
		var id_o = $("#odstin1").val();
		var id_r = $("#rozmer1").val(); // 2
		var id_ot = $("#otevirani1").val(); // 2
		var id_tz = this.value;
		var id_v = $("#vypln1").val();
		var id_vt = $("#ventilace1").val();

		//alert(id_r);
		//var cena_bez_dph = $("#cena_bez_dph").val();
		//var cena_s_dph = $("#cena_s_dph").val();

		$.ajax({
			url: "../../site/cena",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_t': id_t, 'id_n': id_n, 'id_m': id_m, 'id_o': id_o, 'id_r': id_r, 'id_ot': id_ot, 'id_tz': id_tz, 'id_v': id_v, 'id_vt': id_vt, 'cpa': cpa},
			cache: false,
			success: function (data) {

				if (!data.id > 0) {

					$('#seznam-cena_bez_dph').val(data.cena_bez_dph);
					$('#seznam-cena_s_dph').val(data.cena_s_dph);

					$('#seznam-name').val(data.name);

				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná9');
			}
		});
	});



	$('#vypln1').on('change', function () {
		
		var cpl = $("#cpl").val(); // kolvo prop
		var cpa = [];
		for(i = 0; i < cpl; i++)
		{
			if( $("#prplt"+i).val() !== "")
			{
				cpa[i] = $("#prplt"+i).val();
			}
		}
		
		var id_t = $("#typ1").val(); // 2
		var id_n = $("#norma1").val(); // 2
		var id_m = $("#model1").val();
		var id_o = $("#odstin1").val();
		var id_r = $("#rozmer1").val(); // 2
		var id_ot = $("#otevirani1").val(); // 2
		var id_tz = $("#typzamku1").val();
		var id_v = this.value;
		var id_vt = $("#ventilace1").val();

		$.ajax({
			url: "../../site/cena",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_t': id_t, 'id_n': id_n, 'id_m': id_m, 'id_o': id_o, 'id_r': id_r, 'id_ot': id_ot, 'id_tz': id_tz, 'id_v': id_v, 'id_vt': id_vt, 'cpa': cpa},
			cache: false,
			success: function (data) {

				if (!data.id > 0) {

					$('#seznam-cena_bez_dph').val(data.cena_bez_dph);
					$('#seznam-cena_s_dph').val(data.cena_s_dph);

					$('#vypln1').data('zkratka', data.zkratka);

					$('#seznam-name').val(data.name);

				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná10');
			}
		});
	});

	$('#ventilace1').on('change', function () {
		
		var cpl = $("#cpl").val(); // kolvo prop
		var cpa = [];
		for(i = 0; i < cpl; i++)
		{
			if( $("#prplt"+i).val() !== "")
			{
				cpa[i] = $("#prplt"+i).val();
			}
		}
		
		var id_t = $("#typ1").val(); // 2
		var id_n = $("#norma1").val(); // 2
		var id_m = $("#model1").val();
		var id_o = $("#odstin1").val();
		var id_r = $("#rozmer1").val(); // 2
		var id_ot = $("#otevirani1").val(); // 2
		var id_tz = $("#typzamku1").val();
		var id_v = $("#vypln1").val();
		var id_vt = this.value;

		//alert(id_r);
		//var cena_bez_dph = $("#cena_bez_dph").val();
		//var cena_s_dph = $("#cena_s_dph").val();

		$.ajax({
			url: "../../site/cena",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_t': id_t, 'id_n': id_n, 'id_m': id_m, 'id_o': id_o, 'id_r': id_r, 'id_ot': id_ot, 'id_tz': id_tz, 'id_v': id_v, 'id_vt': id_vt, 'cpa': cpa},
			cache: false,
			success: function (data) {

				if (!data.id > 0) {

					$('#seznam-cena_bez_dph').val(data.cena_bez_dph);
					//$('#seznam-cena_s_dph').val(data.cena_s_dph);

					$('#ventilace1').data('zkratka', data.zkratka2);

					$('#seznam-name').val(data.name);

				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná11');
			}
		});
	});
	
	$('[id^="prplt"]').on('change', function () {

		var cpl = $("#cpl").val(); // kolvo prop
		var cpa = [];
		for(i = 0; i < cpl; i++)
		{
			if( $("#prplt"+i).val() !== "")
			{
				cpa[i] = $("#prplt"+i).val();
			}
		}
		
		var id_t = $("#typ1").val(); // 2
		var id_n = $("#norma1").val(); // 2
		var id_m = $("#model1").val();
		var id_o = $("#odstin1").val();
		var id_r = $("#rozmer1").val(); // 2
		var id_ot = $("#otevirani1").val(); // 2
		var id_tz = $("#typzamku1").val();
		var id_v = $("#vypln1").val();
		var id_vt = $("#ventilace1").val();

		$.ajax({
			url: "../../site/cena",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id_t': id_t, 'id_n': id_n, 'id_m': id_m, 'id_o': id_o, 'id_r': id_r, 'id_ot': id_ot, 'id_tz': id_tz, 'id_v': id_v, 'id_vt': id_vt, 'cpa': cpa},
			cache: false,
			success: function (data) {

				if (!data.id > 0) {

					$('#seznam-cena_bez_dph').val(data.cena_bez_dph);
					//$('#seznam-cena_s_dph').val(data.cena_s_dph);

					$('#vypln1').data('zkratka', data.zkratka);

					$('#seznam-name').val(data.name);

				} else {
					alert('Pozor! Databáze není dostupná');
					//alert(data.stav);
					//console.log(data);
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná10');
			}
		});
	});
	
	
	
	
	

	$('.change-zakazniky_id').on('change', function () {
	//$('.modal').on('click', '.vybrat-zakaznika', function () {

		var id = $(this).val();
		var idz = $(this).val();
		//var id = $(this).data('id');
		//var idz = $(this).data('id');
		
		if(!idz)
		{
			/*
			BootstrapDialog.alert({
				type: BootstrapDialog.TYPE_WARNING, // TYPE_DEFAULT, TYPE_INFO, TYPE_PRIMARY, TYPE_SUCCESS, TYPE_WARNING, TYPE_DANGER
				title: 'Pozor!',
				message: 'Prosím vyberte zákazníka!'
			});
			*/
		}
		else
		{
			var count = $("#count_polozka").val();
			var arr = [];
			$('.polozky-line').each(function(){
				var i = $(this).find('.polozky').data('polozka');
				var ids = $("#idpolozka" + i).val();
				var item = {};
				item ['i'] = i;
				item ['ids'] = ids;	
				arr.push(item);
			});
			
			var jsonString = JSON.stringify(arr);
			
			$.ajax({
				url: "../../site/chladina-count",
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				data: {'idz': idz, 'arr': jsonString},
				cache: false,
				success: function (data)
				{
					//alert("Test");
					if (!data.id > 0)
					{
						$.each(data, function (index, value) {
							//$.each(this, function () {
								
								var id = index;
								var new_cena_bez_dph = value;
								
								var sleva = $("#sleva" + id).val('0.00');

								var cena = new_cena_bez_dph;
								$("#cena" + id).data('cena', cena);

								$("#cena" + id).val(cena);

								var mj = $("#pocet" + id).val();


								var typ_ceny = $("#typ_ceny" + id).val();
								var sazba_dph = $("#sazba_dph" + id).val();

								if (typ_ceny === 'bez_dph')
								{
									var celkem = (cena * mj).toFixed(2);
									$("#celkem" + id).val(celkem);

									var celkem_dph = ((celkem / 100) * sazba_dph).toFixed(2);
									$("#celkem_dph" + id).val(celkem_dph);

									var vcetne_dph = (parseFloat(celkem) + parseFloat(celkem_dph)).toFixed(2);
									$("#vcetne_dph" + id).val(vcetne_dph);
								}

								if (typ_ceny === 's_dph')
								{
									var vcetne_dph = (cena * mj).toFixed(2);
									$("#vcetne_dph" + id).val(vcetne_dph);

									var celkem = ((vcetne_dph * 100) / (parseFloat(100) + parseFloat(sazba_dph))).toFixed(2);
									$("#celkem" + id).val(celkem);

									var celkem_dph = (parseFloat(vcetne_dph) - parseFloat(celkem)).toFixed(2);
									$("#celkem_dph" + id).val(celkem_dph);
								}
								
								//$("#is_cenova_hladina" + id).val('Ano');
								$('#btn_submit').attr('dis', false);
							//});
							
							
								// Summa
								var count_polozka = $("#count_polozka").val();
								var allsum = 0; var allsum2 = 0;

								for(i=1; i<= count_polozka; i++)
								{
									if ($("#celkem" + i).length)
									{
										var sum = $("#celkem" + i).val();


										if (sum.length > 0)
										{
											sum = parseFloat(sum);
										}
										else
										{
											sum = 0;
										}
										allsum = parseFloat(allsum) + parseFloat(sum);

										var sum2 = $("#vcetne_dph" + i).val();
										if (sum2.length > 0)
										{
											sum2 = parseFloat(sum2);
										}
										else
										{
											sum2 = 0;
										}
										allsum2 = parseFloat(allsum2) + parseFloat(sum2);
									}
								}

								$("#suma-celkem").val(parseFloat(allsum).toFixed(2));
								$("#suma-vcetene-dph").val(parseFloat(allsum2).toFixed(2));
		
								// Faktura zalohova
								var suma = $("#suma-celkem").val();
								var suma_dph = $("#suma-vcetene-dph").val();
								var castka_procent = $("#castka_procent").val();
								var celkem = (castka_procent*suma / 100).toFixed(2);
								$("#fakturyzalohove-celkem").val(celkem);
								var celkem_dph = (castka_procent*suma_dph / 100).toFixed(2);
								$("#fakturyzalohove-celkem_dph").val(celkem_dph);
						 });
						
					} else {
						alert('Pozor! Databáze není dostupná');
						//alert(data.stav);
						//console.log(data);
					}
				},
				error: function (data, errorThrown) {
					//alert('Požadavek selhal: '+errorThrown);
					alert('Chyba! Databáze není dostupná12');
				}
			});
			
		}

		$.ajax({
			url: "../../site/chladina",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'id': id},
			cache: false,
			success: function (data) {

				if (!data.id > 0)
				{
					$('#chadina').html(data);

				}
				else
				{
					alert('Pozor! Databáze není dostupná');
				}
			},
			error: function (data, errorThrown) {
				//alert('Požadavek selhal: '+errorThrown);
				alert('Chyba! Databáze není dostupná13');
			}
		});
		
		var count_polozka = $("#count_polozka").val();
		/*
		for (i = 1; i <= count_polozka; i++) {
			$("#is_cenova_hladina" + i).val('Ne');
		} 
		*/
	   
		$('#btn_submit').attr('dis', true);
		
	});
	
	
	
	
	
	$('#btn_submit').on('click', function(e) {
		var atr = $(this).attr('dis');
		if (atr === 'true')
		{
			/*
			e.preventDefault();
			BootstrapDialog.alert({
				type: BootstrapDialog.TYPE_WARNING,// TYPE_DEFAULT, TYPE_INFO, TYPE_PRIMARY, TYPE_SUCCESS, TYPE_WARNING, TYPE_DANGER
				title: 'Pozor!',
				message: 'Musite zaúčtovát cenovou hladinu!'
			});
			*/
			//BootstrapDialog.alert('Pozor! Musite zaúčtovát cenovou hladinu!');
			
			//alert("Pozor! Musite zaúčtovát cenovou hladinu!");
			//krajeeDialog.alert("Hold On! This is a Krajee alert!");
		}

	   
	   
	});
	
	$("#prepocitat_ceny").on('click', function () {
		var idz = $("#zakazniky_id").val();
		
		if(!idz)
		{
			BootstrapDialog.alert({
				type: BootstrapDialog.TYPE_WARNING, // TYPE_DEFAULT, TYPE_INFO, TYPE_PRIMARY, TYPE_SUCCESS, TYPE_WARNING, TYPE_DANGER
				title: 'Pozor!',
				message: 'Prosím vyberte zákazníka!'
			});
		}
		else
		{
			var count = $("#count_polozka").val();
			var arr = [];
			$('.polozky-line').each(function(){
				var i = $(this).find('.polozky').data('polozka');
				var ids = $("#idpolozka" + i).val();
				var item = {};
				item ['i'] = i;
				item ['ids'] = ids;	
				arr.push(item);
			});
			
			var jsonString = JSON.stringify(arr);
			
			$.ajax({
				url: "../../site/chladina-count",
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				data: {'idz': idz, 'arr': jsonString},
				cache: false,
				success: function (data) {
					//alert("Test");
					if (!data.id > 0)
					{
						$.each(data, function (index, value) {
							//$.each(this, function () {
								
								var id = index;
								var new_cena_bez_dph = value;
								
								var sleva = $("#sleva" + id).val('0.00');

								var cena = new_cena_bez_dph;
								$("#cena" + id).data('cena', cena);

								$("#cena" + id).val(cena);

								var mj = $("#pocet" + id).val();


								var typ_ceny = $("#typ_ceny" + id).val();
								var sazba_dph = $("#sazba_dph" + id).val();

								if (typ_ceny === 'bez_dph')
								{
									var celkem = (cena * mj).toFixed(2);
									$("#celkem" + id).val(celkem);

									var celkem_dph = ((celkem / 100) * sazba_dph).toFixed(2);
									$("#celkem_dph" + id).val(celkem_dph);

									var vcetne_dph = (parseFloat(celkem) + parseFloat(celkem_dph)).toFixed(2);
									$("#vcetne_dph" + id).val(vcetne_dph);
								}

								if (typ_ceny === 's_dph')
								{
									var vcetne_dph = (cena * mj).toFixed(2);
									$("#vcetne_dph" + id).val(vcetne_dph);

									var celkem = ((vcetne_dph * 100) / (parseFloat(100) + parseFloat(sazba_dph))).toFixed(2);
									$("#celkem" + id).val(celkem);

									var celkem_dph = (parseFloat(vcetne_dph) - parseFloat(celkem)).toFixed(2);
									$("#celkem_dph" + id).val(celkem_dph);
								}
								
								//$("#is_cenova_hladina" + id).val('Ano');
								$('#btn_submit').attr('dis', false);
							//});
						 });
						
					} else {
						alert('Pozor! Databáze není dostupná');
						//alert(data.stav);
						//console.log(data);
					}
				},
				error: function (data, errorThrown) {
					//alert('Požadavek selhal: '+errorThrown);
					alert('Chyba! Databáze není dostupná14');
				}
			});
			
		}
	});
	
	$('#skupiny-nabidky').on('change', function() {
		znac = $(this).val();
		$("#znac-select").html(znac);
	});
	
	$("#submit_vybrat_skupiny").on('click', function () {
		var id_skupina = $("#znac-select").html();
		
		var url = "/nabidky/create?skupina=" + id_skupina;    
		$(location).attr('href',url);
	});
	
	$("#submit_vybrat_zakazniky_skupina").on('click', function () {
		var id_skupina = $("#znac-select").html();
		
		var url = "/zakazniky/create?skupina=" + id_skupina;    
		$(location).attr('href',url);
	});
	
	$("#submit_go_ico").on('click', function () {
		var id_zakaznika = $("#znac-select").html();
		
		var url = "/zakazniky/update/" + id_zakaznika;    
		$(location).attr('href',url);
	});
	
	$("#submit_konstrukter").on('click', function () {

		//var polozka_id = $(this).data('polozka');
		var polozka_id = $("#polozka_id").val();
		var name = $("#seznam-name").val();
		var typ_id = 1;
		var norma_id = $("#norma1").val();
		var modely_id = $("#model1").val();
		var odstin_id = $("#odstin1").val();
		var rozmer_id = $("#rozmer1").val();
		var otevirani_id = $("#otevirani1").val();
		var typzamku_id = $("#typzamku1").val();
		var vypln_id = $("#vypln1").val();
		var ventilace_id = $("#ventilace1").val();
		
		var jednotka_id = $("#jednotka1").val();
		var cena = $("#seznam-cena_bez_dph").val();
		var carovy_kod = $("#seznam-carovy_kod").val();
		var ceniky_id = $("#ceniky1").val();
		var sklady_id = $("#sklady1").val();
		var zakazniky_id = $("#zakazniky1").val(); // Dodavatele
		var hmotnost = $("#seznam-hmotnost").val();
		var dodaci_lhuta = $("#seznam-dodaci_lhuta").val();
		var zasoba_pojistna = $("#zasoba_pojistna").val();
		
		var nabidky_zakazniky_id = $("#nabidky-zakazniky_id").val();
		
		//alert(nabidky_zakazniky_id);
		
		//var zakazniky_id = $("#zakazniky_id").val();
		
		if (modely_id === '')
		{
			BootstrapDialog.alert({
				type: BootstrapDialog.TYPE_DANGER,// TYPE_DEFAULT, TYPE_INFO, TYPE_PRIMARY, TYPE_SUCCESS, TYPE_WARNING, TYPE_DANGER
				title: 'Pozor!',
				message: 'Musíte si vybrat Model!' //'Musite zaúčtovát cenovou hladinu!'
			});
		}
		else if (odstin_id === '')
		{
			BootstrapDialog.alert({
				type: BootstrapDialog.TYPE_DANGER,// TYPE_DEFAULT, TYPE_INFO, TYPE_PRIMARY, TYPE_SUCCESS, TYPE_WARNING, TYPE_DANGER
				title: 'Pozor!',
				message: 'Musíte si vybrat Odstín!' //'Musite zaúčtovát cenovou hladinu!'
			});
		}
		else if (rozmer_id === '')
		{
			BootstrapDialog.alert({
				type: BootstrapDialog.TYPE_DANGER,// TYPE_DEFAULT, TYPE_INFO, TYPE_PRIMARY, TYPE_SUCCESS, TYPE_WARNING, TYPE_DANGER
				title: 'Pozor!',
				message: 'Musíte si vybrat Rozměr!' //'Musite zaúčtovát cenovou hladinu!'
			});
		}
		else if (otevirani_id === '')
		{
			BootstrapDialog.alert({
				type: BootstrapDialog.TYPE_DANGER,// TYPE_DEFAULT, TYPE_INFO, TYPE_PRIMARY, TYPE_SUCCESS, TYPE_WARNING, TYPE_DANGER
				title: 'Pozor!',
				message: 'Musíte si vybrat Typ otevírání dveří!' //'Musite zaúčtovát cenovou hladinu!'
			});
		}
		else if (typzamku_id === '')
		{
			BootstrapDialog.alert({
				type: BootstrapDialog.TYPE_DANGER,// TYPE_DEFAULT, TYPE_INFO, TYPE_PRIMARY, TYPE_SUCCESS, TYPE_WARNING, TYPE_DANGER
				title: 'Pozor!',
				message: 'Musíte si vybrat Typ zámku!' //'Musite zaúčtovát cenovou hladinu!'
			});
		}
		else
		{
		
			$.ajax({
				url: "../../site/konstrukter",
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				data:{ 
						'polozka_id': polozka_id,
						'name': name,
						'typ_id': typ_id,
						'norma_id': norma_id,
						'modely_id': modely_id,
						'odstin_id': odstin_id,
						'rozmer_id': rozmer_id,
						'otevirani_id': otevirani_id,
						'typzamku_id': typzamku_id,
						'vypln_id': vypln_id,
						'ventilace_id': ventilace_id,
						'cena': cena,
						'zakazniky_id': zakazniky_id,
						'carovy_kod': carovy_kod,
						'ceniky_id': ceniky_id,
						'sklady_id': sklady_id,
						'hmotnost': hmotnost,
						'dodaci_lhuta': dodaci_lhuta,
						'jednotka_id': jednotka_id,
						'zasoba_pojistna': zasoba_pojistna,
						'nabidky_zakazniky_id': nabidky_zakazniky_id
					},
				cache: false,
				success: function (data) {

					if (!data.id > 0)
					{
						var cena = data.cena_bez_dph;
						$('#polozka' + data.polozka_id ).val(data.name);

						$("#idpolozka" + data.polozka_id).val(data.insert_id);
						$("#polozka" + data.polozka_id).val(data.name);
						$("#kod" + data.polozka_id).val(data.kod);
						$("#cena" + data.polozka_id).val(cena);
						$("#cena" + data.polozka_id).data('cena', cena);
						$("#pocet" + data.polozka_id).val('1');
						$("#sleva" + data.polozka_id).val('0.00');
						$("#celkem" + data.polozka_id).val(cena);

						var celkem_dph = ((cena / 100) * 21).toFixed(2);
						$("#celkem_dph" + data.polozka_id).val(celkem_dph);

						var vcetne_dph = (parseFloat(cena) + parseFloat(celkem_dph)).toFixed(2);
						$("#vcetne_dph" + data.polozka_id).val(vcetne_dph);

						//$("#is_cenova_hladina" + data.polozka_id).val('Ano');

						//alert(data.insert_id + ' = ' + data.polozka_id);
						
						// Summa
						var count_polozka = $("#count_polozka").val();
						var allsum = 0; var allsum2 = 0;

						for(i=1; i<= count_polozka; i++)
						{
							if ($("#celkem" + i).length)
							{
								var sum = $("#celkem" + i).val();


								if (sum.length > 0)
								{
									sum = parseFloat(sum);
								}
								else
								{
									sum = 0;
								}
								allsum = parseFloat(allsum) + parseFloat(sum);

								var sum2 = $("#vcetne_dph" + i).val();
								if (sum2.length > 0)
								{
									sum2 = parseFloat(sum2);
								}
								else
								{
									sum2 = 0;
								}
								allsum2 = parseFloat(allsum2) + parseFloat(sum2);
							}
						}

						$("#suma-celkem").val(parseFloat(allsum).toFixed(2));
						$("#suma-vcetene-dph").val(parseFloat(allsum2).toFixed(2));
						
						// Faktura zalohova
						var suma = $("#suma-celkem").val();
						var suma_dph = $("#suma-vcetene-dph").val();
						var castka_procent = $("#castka_procent").val();
						var celkem = (castka_procent*suma / 100).toFixed(2);
						$("#fakturyzalohove-celkem").val(celkem);
						var celkem_dph = (castka_procent*suma_dph / 100).toFixed(2);
						$("#fakturyzalohove-celkem_dph").val(celkem_dph);
						
					}
					else
					{
						alert('Pozor! Databáze není dostupná');
						//alert(data.stav);
						//console.log(data);
					}
				},
				error: function (data, errorThrown) {
					//alert('Požadavek selhal: '+errorThrown);
					alert('Chyba! Databáze není dostupná15');
				}
			});
			
			
			
			
			$('#modal2').modal('hide');
			//$('#modal2').remove();
		    //$(this).data('bs.modal', null);
		}
	});
	/*
	var myBackup = $('#myModal').clone();

	// Delegated events because we make a copy, and the copied button does not exist onDomReady
	$('body').on('click','#submit_konstrukter',function() {
		$('#modal2').modal('hide').remove();
		var myClone = myBackup.clone();
		$('body').append(myClone);
	});
	*/
	// Summa
	var count_polozka = $("#count_polozka").val();
	var allsum = 0; var allsum2 = 0;

	for(i=1; i<= count_polozka; i++)
	{
		if ($("#celkem" + i).length)
		{
			var sum = $("#celkem" + i).val();


			if (sum.length > 0)
			{
				sum = parseFloat(sum);
			}
			else
			{
				sum = 0;
			}
			allsum = parseFloat(allsum) + parseFloat(sum);

			var sum2 = $("#vcetne_dph" + i).val();
			if (sum2.length > 0)
			{
				sum2 = parseFloat(sum2);
			}
			else
			{
				sum2 = 0;
			}
			allsum2 = parseFloat(allsum2) + parseFloat(sum2);
		}
	}

	$("#suma-celkem").val(parseFloat(allsum).toFixed(2));
	$("#suma-vcetene-dph").val(parseFloat(allsum2).toFixed(2));
	
	$(".f-vydana").on('click', function (e) {
			var idn = $(this).attr('idn');
			var form = $(this);
			var arr = [];
			$('.polozky-line').each(function(){
				var i = $(this).find('.polozky').data('polozka');
				var ids = $("#idpolozka" + i).val();
				var pocet = $("#pocet" + i).val();
				var item = {};
				item ['ids'] = ids;	
				item ['pocet'] = pocet;
				arr.push(item);
			});
			
			var jsonString = JSON.stringify(arr);
			
			$.ajax({
				url: "../../site/seznam-count",
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				data: {'arr': jsonString, 'idn': idn},
				cache: false,
				success: function (results) {
					//alert(results);
				
					if(results === 0)
					{
						BootstrapDialog.alert({
							type: BootstrapDialog.TYPE_DANGER,// TYPE_DEFAULT, TYPE_INFO, TYPE_PRIMARY, TYPE_SUCCESS, TYPE_WARNING, TYPE_DANGER
							title: 'Pozor!',
							message: 'Bohužel nemáte tolik zboží na skladě!'
						});
					}
					else
					{
						form.submit();
					}
					
					
				},
				error: function (data, errorThrown) {
					//alert('Požadavek selhal: '+errorThrown);
					alert('Chyba! Databáze není dostupná16');
				}
			});
		
		e.preventDefault();
						
		
	});
	
	$('#modal2').on('hidden', function(){
		$("#modal2").remove();
	});
	
	
	$('body').on('click', '.show_view', function () {
		
		var nid = $(this).data('nid');
		$("#nid").text(nid);

		$('#modal-view').modal('show');
		
		$.ajax({
				url: "../../nabidky/show-view",
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				data:{ 
						'nid': nid
					},
				cache: false,
				success: function (data) {
					$("#modal-view-header").html(data.cislo);
					$("#main-show-view").html(data.table);			
				},
				error: function (data, errorThrown) {
					//alert('Požadavek selhal: '+errorThrown);
					alert('Chyba! Databáze není dostupná17');
				}
			});
		
		
		
    });
	$('body').on('click', '.link-print', function () {
		alert("OK");
	});
	$('body').on('click', '.modal-btn-log', function () {
		
		var id = $(this).data('id');

		$('#modal-log').modal('show');
		/*
		$.ajax({
				url: "../../nabidky/show-view",
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				data:{ 
						'nid': nid
					},
				cache: false,
				success: function (data) {
					$("#modal-view-header").html(data.cislo);
					$("#main-show-view").html(data.table);			
				},
				error: function (data, errorThrown) {
					//alert('Požadavek selhal: '+errorThrown);
					alert('Chyba! Databáze není dostupná');
				}
			});
		*/
		
		
    });
	
	$(".online-pdf").click(function(){
		var id = $(this).data('id');

		$.ajax({
				url: "../../nabidky/print",
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				data:{ 
						'id': id
					},
				cache: false,
				success: function (data) {
					$("#modal-view-header").html(data.cislo);
					$("#main-show-view").html(data.table);			
				},
				error: function (data, errorThrown) {
					//alert('Požadavek selhal: '+errorThrown);
					alert('Chyba! Databáze není dostupná18');
				}
			});
	});
	
	// Faktura zalohova
	
	
	var suma = $("#suma-celkem").val(); // bez DPH
	var celkem = $("#fakturyzalohove-celkem").val();
	
	var suma_dph = $("#suma-vcetene-dph").val(); // vc DPH
	var celkem_dph = $("#fakturyzalohove-celkem_dph").val();
	
	if (suma > 0 && celkem > 0)
	{
		var procent = (celkem*100 / suma).toFixed(2);
	}
	else
	{
		var procent = 30;
	}
	
	var celkem = (suma*procent / 100).toFixed(2);
	var celkem_dph = (suma_dph*procent / 100).toFixed(2);
	
	$("#castka_procent").val(procent);
	$("#fakturyzalohove-celkem").val(celkem);
	$("#fakturyzalohove-celkem_dph").val(celkem_dph);
	
	$("#fakturyzalohove-celkem").on('input', function(){
		var suma = $("#suma-celkem").val();
		var suma_dph = $("#suma-vcetene-dph").val();
		var celkem = $(this).val();

		var procent = (celkem*100 / suma).toFixed(2);
		$("#castka_procent").val(procent);
		
		var celkem_dph = (suma_dph*procent / 100).toFixed(2);
		$("#fakturyzalohove-celkem_dph").val(celkem_dph);
		
	});
	
	$("#fakturyzalohove-celkem_dph").on('input', function(){
		var suma = $("#suma-celkem").val();
		var suma_dph = $("#suma-vcetene-dph").val();
		var celkem_dph = $(this).val();

		var procent = (celkem_dph*100 / suma_dph).toFixed(2);
		$("#castka_procent").val(procent);
		
		var celkem = (suma*procent / 100).toFixed(2);
		$("#fakturyzalohove-celkem").val(celkem);
		
	});
	
	$("#castka_procent").on('input', function(){
		var suma = $("#suma-celkem").val();
		var suma_dph = $("#suma-vcetene-dph").val();
		var castka_procent = $(this).val();

		var celkem = (castka_procent*suma / 100).toFixed(2);
		$("#fakturyzalohove-celkem").val(celkem);
		
		var celkem_dph = (castka_procent*suma_dph / 100).toFixed(2);
		$("#fakturyzalohove-celkem_dph").val(celkem_dph);
		
	});
	
	$("#zakazniky_de").on('click', function(){
		
		$.ajax({
				url: "../../site/zakazniky-de",
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				data: {'id': 1},
				cache: false,
				success: function (data) {
					//alert(data.insert_id);
					location.reload();
				},
				error: function (data, errorThrown) {
					//alert('Požadavek selhal: '+errorThrown+ ' '+data);
					alert('Chyba! Databáze není dostupná19');
				}
			});
		
	});
	
	$('#boxCenikySeznam').on('click', '.vybrat-dvere', function () {
		//alert("OK");
		var id = $(this).data('id');
		var name = $(this).data('name');
		var cena = $(this).data('cena');
		
		$("#cenikyseznam-name").val(name);
		$("#cenikyseznam-seznam_id").val(id);
		$("#cenikyseznam-cena").val(cena);
		
		$('.modal.in').modal('hide');
	});
	
	$('#boxSkladySeznam').on('click', '.vybrat-dvere', function () {
		//alert("OK");
		var id = $(this).data('id');
		var name = $(this).data('name');
		var cena = $(this).data('cena');
		
		$("#skladyseznam-name").val(name);
		$("#skladyseznam-seznam_id").val(id);
		$("#skladyseznam-cena").val(cena);
		
		$('.modal.in').modal('hide');
	});
	
	if($("#zakazniky-spolehlivy_platce_dph").val() === "Ne")
	{
		$(".field-zakazniky-spolehlivy_platce_dph").css("color", "red");
	}
	
	$("#btn_platce").on('click', function(){
		var dic = $("#zakazniky-dic").val();
		
		$.ajax({
			url: "../../site/platce",
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			data: {'dic': dic},
			cache: false,
			success: function (data)
			{
				$('#zakazniky-spolehlivy_platce_dph').val(data.spolehlivy_platce_dph);
				
			},
			error: function (data, errorThrown)
			{
				alert('Požadavek selhal: '+errorThrown);
				//alert('Chyba! Databáze není dostupná 2');
			}	
		});
	
	});
	
	$(".help-block").hide();
}); // jQuery