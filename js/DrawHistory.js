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
	, messages: {'':''
	}
});

function DrawHistory(config)
{
	this.config = config;
	this.LOG = new Logger('DrawHistory');
}

DrawHistory.prototype.message = function(code) {
	var txt = (code in this.config.messages) ? this.config.messages[code] : code;
	alert(txt);
};
