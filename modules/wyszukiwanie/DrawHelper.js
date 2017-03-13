/**
 * Init helper with config.
 *
 * @requires Array.indexOf
 * @requires Logger
 * @requires randomApi
 * @requires jQuery UI
 *
 * @type DrawHelper
 */
var drawHelper = new DrawHelper({
	integersToDraw: 6
	, rowNumberCell: 0	// index of the cell that contains row numbers (local)
	, keyCell: 1		// index of the cell that contains ids (global)
	, mock: false		// if true then Math.random will be used rather then Random.org API
	, tbodySelector: '#content table tbody'
	, messages: {'':''
		, 'randomorg failed' : 'Błąd losowania! Losowanie za pomocą Random.org nie powiodłow się.'
			+'\n\n'
			+'Sprawdź połączenie z Internetem i spróbuj ponownie. Informacje techniczne znajdują się w konsoli JS.'
	}
});

function DrawHelper(config)
{
	this.config = config;
	this.LOG = new Logger('DrawHelper');
}

DrawHelper.prototype.message = function(code) {
	var txt = (code in this.config.messages) ? this.config.messages[code] : code;
	alert(txt);
};

/**
 * Button click handler.
 * 
 * @param {Element} button
 */
DrawHelper.prototype.onDraw = function(button) {
	this.draw(document.querySelector(this.config.tbodySelector)).fail(function(){
		// re-enable upon failure
		$(button).button("enable");
	});
	// disable immediately
	$(button).button("disable");
};

DrawHelper.prototype.getTrimmedContents = function(cell) {
	return cell.textContent.replace(/^\s+/, '').replace(/\s+$/, '');
};

/**
 * Show only rows with given numbers.
 *
 * Note! Numbers are the ones in the `rowNumberCell` cell. Not indexs.
 * So sorting the table should not affect this.
 *
 * @param {NodeList} rows
 * @param {Array} visibleRowNumbers
 */
DrawHelper.prototype.showOnlyRows = function(rows, visibleRowNumbers) {
	for (var i = 0; i < rows.length; i++) {
		var row = rows[i];
		var cells = row.querySelectorAll('td');
		var no = parseInt(this.getTrimmedContents(cells[this.config.rowNumberCell]));
		//var id = this.getTrimmedContents(cells[this.config.keyCell]);
		if (visibleRowNumbers.indexOf(no) >= 0) {
			$(row).show();
		}
		else {
			$(row).hide();
		}
	}
};

/**
 * Draw `integersToDraw` rows from long table.
 *
 * @param {Element} tableBody Body of the table to be transformed.
 */
DrawHelper.prototype.draw = function(tableBody) {
	var deferred = $.Deferred();

	var rows = tableBody.querySelectorAll('tr');
	var LOG = this.LOG;
	// validate
	if (rows.length < this.config.integersToDraw) {
		LOG.info('not enough rows to make draw feasable');
		return;
	}

	var drawFunction = this.config.mock ? 'drawIntegersMock' : 'drawIntegers';
	// draw numbers and apply to table
	var _self = this;
	this[drawFunction](rows.length).done(function(integersArray){
		_self.showOnlyRows(rows, integersArray);
		deferred.resolve();
	}).fail(function(){
		deferred.reject();
	});

	return deferred;
};

/**
 * Draw integers based on the list length.
 *
 * @param {Number} listLength
 * @returns {jQuery.Deferred}
 *	on done(integersArray); radom integers
 *	on fail();
 */
DrawHelper.prototype.drawIntegers = function(listLength) {
	var deferred = $.Deferred();
	var _self = this;

	randomApi.drawIntegers(1, listLength,  this.config.integersToDraw, false)
		.done(function(random, signature){
			// TODO: save random&signature to local storage
			// return value
			deferred.resolve(random.data);
		})
		.fail(function(){
			// show error message
			_self.message('randomorg failed');
			// return error
			deferred.reject();
		})
	;

	return deferred;
};

/**
 * [MOCK] Draw integers based on the list length.
 *
 * @param {Number} listLength
 * @returns {jQuery.Deferred}
 *	on done(integersArray); radom integers
 *	on fail();
 */
DrawHelper.prototype.drawIntegersMock = function(listLength) {
	var deferred = $.Deferred();

	var maxRepetitions = this.config.integersToDraw * this.config.integersToDraw;

	var randomData = [];
	for (var i = 0; i < this.config.integersToDraw; i++) {
		var newInt;
		var intIsUnique = false;
		for (var repeat = 0; repeat < maxRepetitions; repeat++) {
			newInt = quickRandomInt(1, listLength);
			if (randomData.indexOf(newInt) < 0) {
				intIsUnique = true;
				break;
			}
		}
		if (!intIsUnique) {
			this.LOG.warn('reached maxRepetitions trying to get unique numbers: ', maxRepetitions);
		}
		randomData.push(newInt);
	}
	this.LOG.info("MOCKED random: ", randomData);
	deferred.resolve(randomData);

	return deferred;
};

function quickRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}