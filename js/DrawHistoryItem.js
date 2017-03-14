/**
 * History item.
 *
 * @param {DrawHistoryItem} config
 */
function DrawHistoryItem(config) {
	this.formData = config.formData;
	this.actionName = config.actionName;
	this.actionData = config.actionData;

	this.time = new Date();
	if (typeof config.time === 'object') {	// assuming Date Object
		this.time = config.time;
	}
	if (typeof config.time === 'string') {	// assuming ISO or other Date recognized string
		this.time = new Date(config.time);
	}
	if (typeof config.time === 'number') {	// assuming UNIX timestamp
		this.time.setTime(config.time);
	}
}

DrawHistoryItem.prototype.render = function(){
	return ''
		+ this.renderTime(this.time)
		+ '; '
		+ this.renderAction(this.actionName, this.actionData)
		+ '; '
		+ this.renderForm(this.formData)
	;
};

/**
 * Render form data information.
 * @param {Object} formData
 * @returns {String} html
 */
DrawHistoryItem.prototype.renderForm = function(formData){
	var html = "";
	html += '<b>'+formData.label+'</b>: ';
	for (var i = 0; i < formData.values.length; i++) {
		/**
		 * @type DrawHistoryValue
		 */
		var val = formData.values[i];
		if (!val.value.length) {
			continue;
		}
		var className = (i+1 < formData.values.length) ? '': 'last';
		html += "<span class='profile-data "+className+"'"
			+ "title='"+val.label+': '+val.value+"'"
			+ ">"+val.shortValue+"</span>"
		;
	}
	return html;
};

DrawHistoryItem.prototype.renderAction = function(actionName, actionData) {
	var html = "";
	html = '<b>'+drawHistory.config.labels['action-'+actionName]+'</b>: ';
	// render action data
	if (actionName == 'RandomApi') {
		html += '<a href="#verify" data-RandomApi-result="'+JSON.stringify(actionData.result).replace(/"/g, "&quot;")+'">'
				+drawHistory.config.labels['action-RandomApi-verify']
			+'</a>'
			+' (nr '+actionData.random.serialNumber+')'
		;
	} else {
		html += actionData.grupName
			+ " (" + drawHistory.config.labels['action-GroupChange-for'] + " " + actionData.registrationId + ")"
		;
	}
	return html;
};

/**
 * Zero pad two digit number.
 * @param {Number} value One or two digit number.
 * @returns {String}
 */
DrawHistoryItem.prototype.formatTwoDigit = function(value){
	if (value < 10) {
		return "0" + value;
	}
	return "" + value;
};

/**
 *
 * @param {Date} time
 * @returns {String}
 */
DrawHistoryItem.prototype.renderTime = function(time){
	var html = ''//'<b>'+drawHistory.config.labels['time']+'</b>: '
		+ this.formatTwoDigit(time.getHours())
		+ ':'
		+ this.formatTwoDigit(time.getMinutes())
		+ ':'
		+ this.formatTwoDigit(time.getSeconds())
	;
	return html;
};
