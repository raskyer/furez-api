$(document).ready(function() {
	var elementNav = $('.uActionNav');
	var elementOffset = elementNav.offset().top;
	var elementWidth = elementNav.parent().width();
	var parentHeight = elementNav.parent().height();

	$(window).scroll(function () {
		var elementStop = $('#uPhpSection').offset().top - 60;
        if ($(this).scrollTop() > elementOffset && $(this).scrollTop() < elementStop) {
            elementNav.css({position: 'fixed', top: 0, width: elementWidth, height: parentHeight});
            elementNav.parent().css('height', parentHeight);
        } else {
            elementNav.css('position', 'relative');
        }
    });

	function getContent(folderName, context, that, handleParent) {
		var url = thisUrl + "folder?folder="+context+"/"+folderName;
		$.ajax({
			url: url,
			type: 'GET',
			success: function (data) {
				if(data) {
					if(!handleParent) {
						if(that.next().is('ul')) {
							that.next('ul').html('');
						}
						dataHtml = '<ul>'+data+'</ul>';
						$(dataHtml).insertAfter(that);
						var context = $(that).next().find('li').data('context');
						$(that).next().find('li').data('context', context);
					} else {
						$('.uSiteMap').html('');
						$('.uSiteMap').html(data);
					}
				}
			}
		});
	}

	function enabledBtn(bt1, bt2, bt3, bt4) {
		var btnArray = [bt1, bt2, bt3, bt4],
			btnLenght = btnArray.length;

		for(var i = 0; i < btnLenght; i ++) {
			if(btnArray[i] != false) {
				$('.btn'+(i+1)).prop('disabled', false);
			} else {
                $('.btn'+(i+1)).prop('disabled', true);
            }
		}
	}

	//Click folder structure
	$('body').on('click', '.uFolder', function() {
		$('.uSiteMap li').removeClass('active');
		$(this).addClass('active');

		var fOpen = $(this).find('.fa.fa-caret-down');
		var fClose = $(this).find('.fa.fa-caret-right');
		var children = $(this).parent().find('ul');
		var name = $(this).data('name');
		var context = $(this).data('context');

		if(fOpen.length > 0) {
			fOpen.addClass('fa-caret-right');
			fOpen.removeClass('fa-caret-down');
			children.hide();
		} else {
			enabledBtn(false, true, false, true);
			fClose.addClass('fa-caret-down');
			fClose.removeClass('fa-caret-right');
			getContent(name, context, $(this), false);
			children.show();
		}

		$('#uActiveObj').data('context', context);
		$('#uActiveObj').data('name', name);

		$('#uActiveObj').html("<i class='fa fa-folder'></i> " + $(this).text());
		$('#uActiveObjInfo').html('<p>Rights: '+$(this).data('right')+'</p>'+'<p>Owner: '+$(this).data('owner')+'</p>'+'<p>Last Update: '+$(this).data('lastupdate')+'</p>');
	});

	$('body').on('click', '.uFile', function() {
        enabledBtn(true, true, true, true);
		$('.uSiteMap li').removeClass('active');
		$(this).addClass('active');

		$('#uActiveObj').html($(this).text());
		$('#uActiveObjInfo').html('<p>Rights: '+$(this).data('right')+'</p>'+'<p>Owner: '+$(this).data('owner')+'</p>'+'<p>Last Update: '+$(this).data('lastupdate')+'</p>');

		var context = $(this).data('context');
		var name = $(this).data('name');
		$('#uActiveObj').data('context', context);
		$('#uActiveObj').data('name', name);
	});
	//

	$('body').on('click', '#showFile', function() {
		var filename = $('#uActiveObj').data('name');
		var context = $('#uActiveObj').data('context');
		var url = thisUrl+"file?filename="+context+"/"+filename;
		$.ajax({
			url: url,
			type: 'GET',
			success: function (data) {
                if(data.length == 0) {
                    $('#failureText').text('This element can\'t be cat or is empty');
                    $('#failure').modal('show');
                    return;
                }
				$('.modal-body').html("<pre>" + data + "<pre>");
				$('#catFile').modal('show');
			}
		});
	});

	$('body').on('click', '#zipFile', function() {
		var dirToZip = prompt("Where to zip on the servor ? (by default " + curDir + ")", curDir);
		if(dirToZip.length == 0) {
			return;
		}
		var filename = $('#uActiveObj').data('name');
		var context = $('#uActiveObj').data('context');
		var url = thisUrl+"zip?element="+filename+"&context="+context+"&exportdir="+dirToZip;
		$.ajax({
			url: url,
			type: 'GET',
			success: function (data) {
                data = JSON.parse(data);
                $("#"+ data[0] +"Text").html(data[1]);
                $("#"+ data[0]).modal('show');
			}
		});
	});

	$('body').on('click', '#downloadFile', function() {
        var filename = $('#uActiveObj').data('name');
        var context = $('#uActiveObj').data('context');
        $(this).parent().find('#downloadFilename').val(context+"/"+filename);
    });

	$('body').on('click', '#deleteFile', function() {
		var filename = $('#uActiveObj').data('name');
		var context = $('#uActiveObj').data('context');

		var x=window.confirm("Are you sure you want to delete "+ context + "/" + filename + " ?");
		if (x) {
		    var url = thisUrl+"delete?element="+filename+"&context="+context;
			$.ajax({
				url: url,
				type: 'GET',
				success: function (data) {
					alert(data);
					getContent('', contextRacine, $(this), true);
				}
			});
		}
	});
});
