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
	, formSelector : '#content #search'
	, storageKey : 'DrawHistory'
	, formDataGetter: function() {
		var form = document.querySelector('#content #search');
		return {
			label: 'profil',
			values: [
				new DrawHistoryValue({label: 'Płeć'
					, value: form.plec.value
					, shortValue: DrawHistoryValue.firstLetter
				}),
				new DrawHistoryValue({label: 'Dzielnica'
					, value: form.miejsce.value
					, shortValue: DrawHistoryValue.firstLetter
				}),
				new DrawHistoryValue({label: 'Wiek'
					, value: DrawHistoryValue.range(form.wiek_od.value, form.wiek_do.value)
				}),
				new DrawHistoryValue({label: 'Wykształcenie'
					, value: form.wyksztalcenie.value
					, shortValue: DrawHistoryValue.firstLetter
				})
			]
		};
	}
	, labels: {'':''
		, 'time' : 'czas'
		, 'action-RandomApi' : 'losowanie 6 z listy'
		, 'action-GroupChange' : 'grupa'
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

	// the history items
	this.history = null;
	$(function(){
		_self.load(function(){
			var html = _self.render();
			$('.draw-history').html(html);
		});
	});
}

/**
 * Load data from storage.
 * @param {Function} callback Optional callback.
 */
DrawHistory.prototype.load = function(callback) {
	var _self = this;
	this.store.getItem('history').then(function(value){
		_self.history = (value === null) ? [] : value;
		if (callback) {
			callback();
		}
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
};

/**
 * Show history.
 *
 * @note If you don't use callback then there will be no attempt to load data from storage.
 *
 * @param {Function} callback Optional callback.
 * @param {Boolean} secondRun If true then this is a second attempt to render history.
 */
DrawHistory.prototype.render = function(callback, secondRun) {
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
	for (var i = 0; i < this.history.length; i++) {
		var item = new DrawHistoryItem(this.history[i]);
		itemsHtml.push(item.render());
	}
	var html = "<ul><li>" + itemsHtml.join("</li>\n<li>") + "</li></ul>";
	if (callback) {
		callback(html);
	}
	return html;
};
