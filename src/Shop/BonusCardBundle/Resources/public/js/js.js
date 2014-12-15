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

	var cardsActions = {
		spinner: null,
		loadFlag: false,
		loadId: null,

		errorMsg: 'Произошла ошибка',
		activated: 'Карта активирована',
		spinnerParams: {
			lines: 13, // The number of lines to draw
			length: 20, // The length of each line
			width: 10, // The line thickness
			radius: 30, // The radius of the inner circle
			corners: 1, // Corner roundness (0..1)
			rotate: 0, // The rotation offset
			direction: 1, // 1: clockwise, -1: counterclockwise
			color: '#000', // #rgb or #rrggbb or array of colors
			speed: 1, // Rounds per second
			trail: 60, // Afterglow percentage
			shadow: false, // Whether to render a shadow
			hwaccel: false, // Whether to use hardware acceleration
			className: 'spinner', // The CSS class to assign to the spinner
			zIndex: 2e9, // The z-index (defaults to 2000000000)
			top: '50%', // Top position relative to parent
			left: '50%' // Left position relative to parent
		},
		init: function() {
			$('a.card-btn').append('<span class="spinner-container"></span>');
			$('a.card-btn > .spinner-container').hide();
		},
		ajax: function($this, action) {
			if($this.data('disable') || (cardsActions.loadFlag && cardsActions.loadId == $this.data("id"))) {
				return false;
			}
			cardsActions.loadFlag = true;
			cardsActions.loadId = $this.data("id");
			cardsActions.setSpinner($this);
			$.post($this.attr('href')).done(function(data){
				if(data) {
					switch(action) {
						case 'delete':
							$this.parent().slideUp();
						break;
						case 'activate':
							$this.text('Карта активирована');
							$this.data('disable', 1);
						break;
					}
				} else {
					alert(cardsActions.errorMsg);
				}
			}).fail(function() {
				alert(cardsActions.errorMsg);
			}).always(function() {
				cardsActions.stopSpinner();
				cardsActions.loadFlag = false;
			});
		},
		setSpinner: function($this) {
			if(cardsActions.spinner === null) {
				cardsActions.spinner = new Spinner(cardsActions.spinnerParams).spin();
			} else {
				cardsActions.spinner.spin();
			}
			$this.find('.spinner-container').html(cardsActions.spinner.el).show();
		},
		stopSpinner: function() {
			cardsActions.spinner.stop();
			$this.find('.spinner-container').hide();
		}
	}

	cardsActions.init();

	$(document).on('click', 'a.card-activate', function(e){
		e.stopPropagation();
		e.preventDefault();
		cardsActions.ajax($(this), 'activate');
		return false;
	});
	$(document).on('click', 'a.card-delete', function(e){
		e.stopPropagation();
		e.preventDefault();
		if(confirm("Вы подтверждаете удаление?")) {
			cardsActions.ajax($(this), 'delete');
		}
		return false;
	});
});