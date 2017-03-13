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
		, 'action-GroupSet' : 'grupa'
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
	this.store.getItem('history', function(value){
		_self.history = (value === null) ? [] : value;
	});
}

DrawHistory.prototype.message = function(code) {
	var txt = (code in this.config.messages) ? this.config.messages[code] : code;
	alert(txt);
};

/**
 * Save Random.org event to history.
 */
DrawHistory.prototype.saveRandomApi = function(result) {
	var historyItem = {
		formData : this.lastFormData,
		action : 'RandomApi',
		actionData : {
			random : result.random,
			signature : result.signature,
			result : result
		}
	};
	this.history.push(historyItem);
	this.store.setItem('history', this.history);
};
