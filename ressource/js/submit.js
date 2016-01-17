function preLine(idPre) {
	var pre = document.getElementById('pre'+idPre);

    pre.innerHTML = '<span class="line-number"></span>' + pre.innerHTML + '<span class="cl"></span>';
    var num = pre.innerHTML.split(/\n/).length;
    for(var j = 0; j < num; j++) {
        var line_num = pre.getElementsByTagName('span')[0];
        line_num.innerHTML += '<span>' + (j + 1) + '</span>';
    }
}

var idPre = 0;
//GET CMD
$('#uTerminalForm').submit(function(event) {
	event.preventDefault();
	var that = $(this);
	var dataForm = $(this).serializeArray();
	if(dataForm[0]['value'] === "clear") {
		$('.uTerminal').html('');
		that.trigger('reset');
		return;
	}
	var url = thisUrl + "cmd";
	$.ajax({
		url: url,
		type: 'GET',
		data: dataForm,
		success: function (data) {
			that.trigger('reset');
			$('.uTerminal').append('<p> > '+ dataForm[0]['value'] +'</p>');
			$('.uTerminal').append('<pre id="pre'+ idPre +'">'+ data +'</pre>');
			$('.uTerminal').scrollTop($(".uTerminal"))[0].scrollHeight;
			preLine(idPre);
            idPre++;
		}
	});
});

//SQL
function restoreSqlForm(submit, rawSql, commandForm, statusConnect) {
	for(var i = 1; i < 4; i ++) {
		$('#uSQL'+i).prop('disabled',false);
		$('#uSQL'+i).css('background', '#fff');
	}

	submit.val('Connect');
	submit.removeClass('btn-danger');
	submit.addClass('btn-default');

	rawSql.prop('disabled', true);
	rawSql.css('background', '#777');

	statusConnect.addClass('label-default');
	statusConnect.removeClass('label-success');
	statusConnect.text('Unconnected');

	commandForm.find('input').prop('disabled', true);
	$('.occasionalData').remove();
}

$('#uSQLConnectForm').submit(function(event) {
	event.preventDefault();
	var dataForm = $(this).serialize();

	var submit = $('#uSQLSubmit'),
	rawSql = $('#rawSql'),
	commandForm = $('#uSQLCommandForm'),
	statusConnect = $('#uStatusConnect');

	if(!dataForm.length > 0) {
		restoreSqlForm(submit, rawSql, commandForm, statusConnect);
		return;
	}

	var url = thisUrl + "SQL/connect";
	$.ajax({
		url: url,
		type: 'GET',
		data: dataForm,
		success: function (data) {
			data = JSON.parse(data);
			$('#successText').text(data[0]);
			$('#success').modal('show');

			statusConnect.addClass('label-success');
			statusConnect.removeClass('label-danger label-default');
			statusConnect.text('Success!');

			submit.val('Disconnect');
			submit.removeClass('btn-default');
			submit.addClass('btn-danger');

			var template = '<div class="occasionalData"><h4>Database to check:</h4><div class="form-group">';
			for(var i = 0; i < data[1].length; i++) {
				template = template + '<input type="radio" name="database" value="'+ data[1][i] +'"> '+data[1][i]+'<br>';
			}
			template = template + '</div></div>';

			commandForm.prepend(template);

			rawSql.prop('disabled', false);
			rawSql.css('background', '#fff');
			rawSql.css('color', '#333');

			commandForm.find('input').prop('disabled', false);
			
			for(var i = 1; i < 4; i++) {
				$('#uSQL'+i).prop('disabled',true);
				$('#uSQL'+i).css('background', '#777');
				$('#uSQL'+i).css('border', '1px solid #777');
			}
		},
		error: function(data, status, err) {
			$('#failureText').html(data.status + ' ' + err + '<br>' + data.responseText);
			$('#failure').modal('show');

			statusConnect.addClass('label-danger');
			statusConnect.removeClass('label-default label-success');
			statusConnect.text('Bad Credentials');

			for(var i = 1; i < 4; i ++) {
				$('#uSQL'+i).prop('disabled',false);
				$('#uSQL'+i).css('border', '1px solid red');
			}
		}
	});
});

$('#uSQLCommandForm').submit(function(event) {
	event.preventDefault();
	var dataForm = $(this).serialize();

	var url = thisUrl + "SQL/execute";
	$.ajax({
		url: url,
		type: 'GET',
		data: dataForm,
		success: function (data) {
			if(!$.isArray(data)) {
				$('#uRawResult').html('<p>'+ data +'</p>');
			}

			data = JSON.parse(data);
			var nbColumn = data[0].length;
			var template = '<thead><tr>';
			for(var i = 0; i < nbColumn; i++) {
				template = template + '<th>' + i + '</th>';
			}
			template = template + '</tr></thead><tbody>';
			for(var i = 0; i < data.length; i++) {
				template = template + '<tr>';
				for(var x = 0; x < data[i].length; x++) {
					template = template + '<td>' + data[i][x] + '</td>';
				}
				template = template + '</tr>';
			}
			template = template + '</tbody>';
			$('#uRawResult').html(template);
		}
	});
});
