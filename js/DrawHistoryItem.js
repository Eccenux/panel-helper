/**
 * History item.
 *
 * @param {DrawHistoryItem} config
 */
function DrawHistoryItem(config) {
	this.formData = config.formData;
	this.actionName = 'action' in config ? config.action : config.actionName;
	this.actionData = config.actionData;

	this.time = new Date();
	if (typeof config.time === 'object') {
		this.time = config.time;
	}
	if (typeof config.time === 'number') {
		this.time.setTime(config.time);
	}
}

DrawHistoryItem.prototype.render = function(){
	return ''
		+ this.renderForm(this.formData)
		+ '; '
		+ this.renderAction(this.actionName, this.actionData)
		+ '; '
		+ this.renderTime(this.time)
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
		var className = className = (i+1 < formData.values) ? '': 'last';
		html += "<span class='"+className+"'"
			+ "title='"+val.label+': '+val.value+"'"
			+ ">"+val.shortValue+"</span>"
		;
	}
	return html;
};

DrawHistoryItem.prototype.renderAction = function(actionName, actionData) {
	var html = "";
	html = '<b>'+drawHistory.config.labels['action-'+actionName]+'</b>: ...';
	// TODO render action data
	return html;
};

/**
 *
 * @param {Date} time
 * @returns {String}
 */
DrawHistoryItem.prototype.renderTime = function(time){
	var html = '<b>'+drawHistory.config.labels['time']+'</b>: '
		+ time.getHours()
		+ ':'
		+ time.getSeconds()
	;
	return html;
};