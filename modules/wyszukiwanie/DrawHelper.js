/**
 * Init helper with config.
 *
 * @requires Array.indexOf
 * @requires Logger
 * @requires randomApi
 *
 * @type DrawHelper
 */
var drawHelper = new DrawHelper({
	integersToDraw: 6
	, rowNumberCell: 0	// index of the cell that contains row numbers (local)
	, keyCell: 1		// index of the cell that contains ids (global)
	, messages: {'':''
		//, 'row not found' : 'Błąd! Nie udało się odnaleźć wylosowanej liczby!'
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

DrawHelper.prototype.showOnlyRows = function(rows, visibleRowNumbers) {
	for (var i = 0; i < rows.length; i++) {
		var row = rows[i];
		var cells = row.querySelectorAll('td');
		var no = cells[this.config.rowNumberCell];
		//var id = cells[this.config.keyCell];
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
	var rows = tableBody.querySelectorAll('tr');
	var LOG = this.LOG;
	// validate
	if (rows.length < this.config.integersToDraw) {
		LOG.info('not enough rows to make draw feasable');
		return;
	}

	// draw numbers and apply to table
	var _self = this;
	this.drawIntegers(rows.length).done(function(integersArray){
		_self.showOnlyRows(rows, integersArray);
	});
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

	randomApi.drawIntegers(1, listLength,  this.config.integersToDraw, false)
		.done(function(random, signature){
			// TODO: save random&signature to local storage
			// return value
			deferred.resolve(random.data);
		})
		.fail(function(){
			// TODO: show error message
			// return error
			deferred.reject();
		})
	;

	return deferred;
};
