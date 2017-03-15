/**
 * Init helper with config.
 *
 * @requires Array.indexOf
 * @requires Logger
 * @requires jQuery UI
 *
 * @type DrawHistory
 */
var drawHistory = new DrawHistory({'':''
	, storageKey : 'DrawHistory'
	, maxItemsRendered : 6
	, formDataGetter: function() {
		var form = document.querySelector('#content .draw-history-profile-form');
		// null when not on search page
		if (!form) {
			return null;
		}
		// get long value of the education status
		var wyksztalcenie = $(form.wyksztalcenie).filter(':checked').attr('data-longValue');
		if (!wyksztalcenie) {
			wyksztalcenie = "";
		}
		return {
			label: 'profil',
			values: [
				new DrawHistoryValue({label: 'Płeć'
					, value: form.plec.value
					, shortValue: DrawHistoryValue.firstLetter
				}),
				new DrawHistoryValue({label: 'Dzielnica'
					, value: form.miejsce.value
					, shortValue: DrawHistoryValue.shortWords
				}),
				new DrawHistoryValue({label: 'Wiek'
					, value: DrawHistoryValue.range(form.wiek_od.value, form.wiek_do.value)
				}),
				new DrawHistoryValue({label: 'Wykształcenie'
					, value: wyksztalcenie
					, shortValue: DrawHistoryValue.firstLetter
				})
			]
		};
	}
	, labels: {'':''
		, 'time' : 'czas'
		, 'action-RandomApi' : 'losowanie 6-ciu'
		, 'action-RandomApi-verify' : 'sprawdź'
		, 'action-GroupChange' : 'grupa'
		, 'action-GroupChange-for' : 'dla'
	}
	, messages: {'':''
	}
});

function DrawHistory(config)
{
	var _self = this;

	this.config = config;
	this.LOG = new Logger('DrawHistory');

	// init store
	this.store = localforage.createInstance({
		name: config.storageKey
	});

	// data from last form submit
	this.lastFormData = null;
	$(function(){
		_self.lastFormData = config.formDataGetter();
	});

	/**
	 * The history items.
	 * @type Array
	 */
	this.history = null;
	/**
	 * Unique history id.
	 * @type String
	 */
	this.historyId = null;

	// prepare history
	$(function(){
		_self.load(function(){
			if (_self.historyId === null) {
				var startTime = new Date();
				var $dialog = _self.showPreparationDialog();
				_self.generateId(function(){
					_self.show();
					// show for a minimum of 3 seconds
					_self.delayedRun(startTime, 3000, function(){
						$dialog.dialog("close");
					});
				});
			} else {
				_self.show();
			}
		});
	});
}

/**
 * Save history to server.
 * @param {Function} onSuccess Success callback (gets server response text as a parameter).
 * @param {Function} onFailure Failure callback (gets jQuery's AJAX object as a parameter).
 */
DrawHistory.prototype.saveToServer = function(onSuccess, onFailure) {
	var LOG = this.LOG;
	$.ajax(eventHistorySaveUrl+'&display=raw', {
	'method':'post',
	'data':{
		'uuid': this.historyId,
		'data': JSON.stringify(this.history)
	}})
		.done(function(response) {
			LOG.info("history saved; response: ", response);
			if (onSuccess) {
				onSuccess(response);
			}
		})
		.fail(function(ajaxCall) {
			LOG.warn("history saving failed; response: ", ajaxCall.responseText);
			if (onFailure) {
				onFailure(ajaxCall);
			}
		})
	;
};

/**
 * Delay running callback.
 *
 * @param {Date} startTime Time you started the countdown.
 * @param {Number} minDelay The minimum [ms] you want to wait from startTime.
 *	If more time already passed then callback will be run immediately.
 * @param {Function} callback Function to run after the delay.
 * @returns {Number} 0 if running immediately or whatever `setTimeout` returns.
 */
DrawHistory.prototype.delayedRun = function(startTime, minDelay, callback) {
	var msDiff = (new Date()) - startTime;
	var extraDelay = minDelay - msDiff;
	if (extraDelay < 0) {
		callback();
		return 0;
	}
	return setTimeout(function(){
		callback();
	}, extraDelay);
};

/**
 * Show preparation, modal dialog.
 *
 * @returns {jQuery}
 */
DrawHistory.prototype.showPreparationDialog = function() {
	var $dialog = $('#history-prepare-dialog');
	$dialog.dialog({
		modal: true,
		closeOnEscape: false,
		open: function(event, ui) {
			$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
		}
	});
	return $dialog;
};

/**
 * Show history.
 */
DrawHistory.prototype.show = function() {
	var $container = $('.draw-history');
	var shortHistory = true;
	if ($container.hasClass('draw-history-full')) {
		shortHistory = false;
	}
	var html = shortHistory ? this.render(this.config.maxItemsRendered) : this.render(-1);
	$container.html(html);
	$('a[data-RandomApi-result]', $container).click(function(){
		var $dialog = $('#randomApi-verify-dialog');
		var result = JSON.parse(this.getAttribute('data-RandomApi-result'));
		$('[data-id="serialNumber"]', $dialog).text(result.random.serialNumber);
		$('[data-id="min"]', $dialog).text(result.random.min);
		$('[data-id="max"]', $dialog).text(result.random.max);
		$('[data-id="result"]', $dialog).text(result.random.data.join(', '));
		$('[name="random"]', $dialog).val(JSON.stringify(result.random));
		$('[name="signature"]', $dialog).val(result.signature);
		$dialog.dialog({
			modal: true
		});
	});
};

/**
 * Load data from storage.
 * @param {Function} callback Optional callback.
 */
DrawHistory.prototype.load = function(callback) {
	var _self = this;
	_self.store.getItem('historyId').then(function(value){
		_self.historyId = value;
		_self.store.getItem('history').then(function(value){
			_self.history = (value === null) ? [] : value;
			if (callback) {
				callback();
			}
		});
	});
};

/**
 * Generate and save unique id for the history.
 * @param {Function} callback Optional callback.
 */
DrawHistory.prototype.generateId = function(callback) {
	var _self = this;
	randomApi.generateUUIDs(1).done(function(random){
		_self.historyId = random.data[0];
		_self.store.setItem('historyId', _self.historyId).then(function(){
			if (callback) {
				callback();
			}
		});
	});
};

/**
 * Show message to the user.
 * @param {String} code Message code.
 */
DrawHistory.prototype.message = function(code) {
	var txt = (code in this.config.messages) ? this.config.messages[code] : code;
	alert(txt);
};

/**
 * Save Random.org event to history.
 * @param {Object} result Result object from Random.org API
 * (it's expected to contain at least `random` and `signature`)
 */
DrawHistory.prototype.saveRandomApi = function(result) {
	var historyItem = {
		time : new Date(),
		formData : this.lastFormData,
		actionName : 'RandomApi',
		actionData : {
			random : result.random,
			signature : result.signature,
			result : result
		}
	};
	this.history.push(historyItem);
	this.store.setItem('history', this.history);
	this.saveToServer();
	this.show();
};

/**
 * Save group change event to history.
 * @param {String} grupName Choosen group.
 * @param {String} registrationId Human ID.
 * @param {Number} profileId DB ID.
 */
DrawHistory.prototype.saveGroupChange = function(grupName, registrationId, profileId) {
	var historyItem = {
		time : new Date(),
		formData : this.lastFormData,
		actionName : 'GroupChange',
		actionData : {
			grupName : grupName,
			registrationId : registrationId,
			profileId : profileId
		}
	};
	// replace last if group changes for the same person
	if (this.history.length) {
		var lastItem = this.history.pop();
		if (lastItem.actionName != 'GroupChange'
			|| lastItem.actionData.profileId != historyItem.actionData.profileId
		) {
			this.history.push(lastItem);	// lastItem is different - re-push it
		}
	}
	// save new item
	this.history.push(historyItem);
	this.store.setItem('history', this.history);
	this.saveToServer();
	this.show();
};

/**
 * Show history.
 *
 * @note If you don't use callback then there will be no attempt to load data from storage.
 *
 * @param {Number} maxItems Maximum items to be rendered (oldest items will be skipped).
 * @param {Function} callback Optional callback.
 * @param {Boolean} secondRun If true then this is a second attempt to render history.
 */
DrawHistory.prototype.render = function(maxItems, callback, secondRun) {
	// just to be sure it's loaded
	var _self = this;
	if (this.history === null) {
		if (secondRun || !callback) {
			this.LOG.error('unable to render - loading history failed');
			if (callback) {
				callback(null);
			}
			return null;
		}
		this.load(function(){
			_self.render(true);
		});
	}
	// render items
	var itemsHtml = [];
	var startItem = 0;
	var shortHistory = true;
	if (maxItems < 0) {
		shortHistory = false;
	}
	if (shortHistory && this.history.length > maxItems) {
		startItem = this.history.length - maxItems;
		itemsHtml.push('...');
	}
	for (var i = startItem; i < this.history.length; i++) {
		var item = new DrawHistoryItem(this.history[i]);
		itemsHtml.push(item.render());
	}
	var html = "<ul><li>" + itemsHtml.join("</li>\n<li>") + "</li></ul>";
	if (callback) {
		callback(html);
	}
	return html;
};
