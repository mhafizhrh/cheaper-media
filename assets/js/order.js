$(document).ready(function() {
	$('#jenis').change(function() {
		var jenis = $('#jenis').val();
		$.ajax({
			url: 'order/jenis.php',
			data: 'jenis='+jenis,
			type: 'POST',
			dataType: 'html',
			success: function(result) {
				$('#layanan').html(result);
			}
		});
	});

	$('#layanan').change(function() {
		var layanan = $('#layanan').val();
		$.ajax({
			url: 'order/layanan.php',
			data: 'layanan='+layanan,
			type: 'POST',
			dataType: 'html',
			success: function(result) {
				$('#keterangan').html(result);
			}
		});
	});
});
// FUNC
	function rate() {
		var aing = $('#eceran').val();
		var sia = $('#jumlah').val();
		var jadi = aing * sia;
		$('#harga').html(jadi);
	}
/*	
	function submit() {
		$('#submit').html('<i class="fa fa-spinner fa-spin"></i> Submit');
		$('#submit').attr('disabled', 'disabled');
		var target = $('#target').val();
		var tipe = $('#layanan').val();
		var jumlah = $('#jumlah').val();
		$(document).ready(function() {
			$('#result').html('<center><img src="assets/images/loading.gif" width="400"></center>');
			$('#result-modal').modal('show');
		    $('#ok').html('<i class="fa fa-spinner fa-spin"></i>');
		    $('#ok').attr('disabled', 'disabled');
		});
		$.ajax({
			url: 'api/submit.php',
			data: 'target='+jenis+'&tipe='+tipe+'&jumlah='+jumlah,
			type: 'POST',
			dataType: 'html',
			success: function(result) {
				$('#result').html(result);
				$('#ok').html('OK');
				$('#ok').removeAttr('disabled');
				$('#submit').html('<i class="fa fa-shopping-cart"></i> Submit');
				$('#submit').removeAttr('disabled');
			}
		})
	}
*/
// END FUNC




