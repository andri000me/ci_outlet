$(function() {
	$('input:file').change(function(event) {
		var file = this.files[0];
		$('.url').val(file.name);
	});
});