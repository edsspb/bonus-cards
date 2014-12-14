jQuery(function($){
	var cardsSeries = {
		nothingFound: 'Нет записей',
		errolLoad: 'Произошла ошибка',
		idElem: null,
		seriesUrl: $('input[name="card_series_get"]').val(),
		spinner: null,
		successFlag: false,
		loadFlag: false,
		hideFlag: false,
		init: function() {
			var $this = $('#makecardsform_series');
			$this.wrap('<span></span>');
			var $wrapper = $this.parent('span');
			cardsSeries.idElem = $this.attr('id');
			$wrapper.append('<div id="'+cardsSeries.idElem+'_btn"></div>');
			$wrapper.append('<div id="'+cardsSeries.idElem+'_list"></div>');
			cardsSeries.hideSeries();
		},
		loadSeries: function() {
			var $list = $('#'+cardsSeries.idElem+'_list');

			if(cardsSeries.hideFlag) {
				return false;
			}

			if(cardsSeries.loadFlag || cardsSeries.successFlag) {
				$list.show();
				return false;
			}

			if($list.children('div').length) {
				$list.find('div').remove();
			}

			$list.append('<div></div>');
			$listContent = $list.children('div');
			if(cardsSeries.spinner === null) {
				cardsSeries.spinner = new Spinner().spin();
			} else {
				cardsSeries.spinner.spin();
			}
			$listContent.html(cardsSeries.spinner.el).css('height', 100);
			cardsSeries.ajax($listContent);
			$list.show();
		},
		ajax: function($listContent) {
			cardsSeries.loadFlag = true;
			$.post(cardsSeries.seriesUrl).done(function(data) {
				cardsSeries.successFlag = true;
				if(data.length) {
					$listContent.css('height', 'auto')
					$listContent.html('<ul></ul>');
					$.each(data, function(key, value) {
						$listContent.find('ul').append('<li data-value="'+value+'">'+value+'</li>');
					});
				} else {
					$listContent.html('<p>'+cardsSeries.nothingFound+'</p>');
				}
			}).fail(function() {
				cardsSeries.successFlag = false;
				$listContent.html('<p>'+cardsSeries.errolLoad+'</p>');
			}).always(function() {
				cardsSeries.spinner.stop();
				cardsSeries.loadFlag = false;
			});
		},
		hideSeries: function() {
			if($('#'+cardsSeries.idElem+'_list').length) {
				$('#'+cardsSeries.idElem+'_list').hide();
			}
		},
		setHideFlag: function() {
			cardsSeries.hideFlag = true;
			setTimeout(function(){
				cardsSeries.hideFlag = false;
			}, 100);
		},
		setSelectedSeries: function($this) {
			$('#'+cardsSeries.idElem).val($this.data('value'));
		}
	}

	cardsSeries.init();
	$('html').click(function(e) {
		if($('#makecardsform_series_list:visible').length) {
			cardsSeries.hideSeries();
			cardsSeries.setHideFlag();
		}
	});
	$(document).on('focus', '#makecardsform_series', function(){
		cardsSeries.hideSeries();
	});
	$(document).on('click', '#makecardsform_series_btn', function(e){
		e.stopPropagation();
		cardsSeries.loadSeries();
		return false;
	});
	$(document).on('click', '#makecardsform_series_list li', function(e){
		e.stopPropagation();
		cardsSeries.setSelectedSeries($(this));
		return false;
	});
});