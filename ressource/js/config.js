$(document).ready(function() {
    $('.btn-edit').click(function(event) {
    	event.preventDefault();
        var select;
        if($(this).parent().is('td')) {
            select = 'tr';
        } else {
            select = '.thumbnail';
        }
    	var row = $(this).closest(select),
    	website = row.find('.website').text(),
    	image = row.find('.image').attr('src'),
    	url = row.find('.url').text();

    	$('#website').val(website);
    	$('#image').val(image);
    	$('#url').val(url);
    	$('#edit').val(row.data('key'));

    	$('#addAPI').modal("show");
    });

	$('.btn-add').click(function(event) {
        $('#website').val('');
        $('#image').val('');
        $('#url').val('');
        $('#edit').val('false');
    });
});
