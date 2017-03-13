/* global RANDOM_ORG_KEY */
var randomApi = new RandomApi(RANDOM_ORG_KEY);

function RandomApi(key)
{
	this.key = key;
	this.LOG = new Logger('RandomApi');
}

/**
 * Generate n random integers in given min-max range.
 *
 * @param {type} min Minimum value.
 * @param {type} max Maximum value.
 * @param {type} n Number of integers to get.
 * @param {type} canHaveDuplicates If true than
 * @returns {jQuery.Deferred}
 *	on done(random, signature); where random.data is an array of the n radom integers
 *	on fail(textStatus, errorThrown); where:
 *		textStatus can be e.g.: "error", "timeout", "abort", or "parsererror"
 *		errorThrown can be e.g.: "Internal Server Error" or an actual text that the server responded with.
 */
RandomApi.prototype.drawIntegers = function(min, max, n, canHaveDuplicates) {
	var deferred = $.Deferred();
	var LOG = this.LOG;

	var requestData = {
		"jsonrpc": "2.0",
		"method": "generateSignedIntegers",
		"params": {
			"apiKey": this.key,
			"n": n,
			"min": min,
			"max": max,
			"replacement": canHaveDuplicates,
			"base": 10	// standard, base-10, numbers
		},
		"id": 123	 // whatever
	};
	LOG.info("request: ", requestData);
	$.ajax({
		url: 'https://api.random.org/json-rpc/1/invoke',
		method: 'POST',
		contentType: 'application/json',
		dataType: "text",
		data: JSON.stringify(requestData)
	}).done(function(responseText) {
		try {
			var responseData = JSON.parse(responseText);
			LOG.info("response random: ", responseData.result.random);
			LOG.info("response signature: ", responseData.result.signature);
			LOG.info("quota information: "
				,'\n\tbits used: '+ responseData.result.bitsUsed
				,'\n\tbits left: '+ responseData.result.bitsLeft
				,'\n\trequests left (absolute): '+ responseData.result.requestsLeft
				,'\n\tsimilar requests left (bits u./l.): '+ responseData.result.bitsLeft/responseData.result.bitsUsed
			);
		} catch(e) {
			LOG.error('unable to parse response: ', responseText);
			LOG.error('error message: ', e.message);
			deferred.reject("parsererror", responseText);
		}
		deferred.resolve(responseData.result.random, responseData.result.signature, responseData);
		//deferred.reject("fake-parsererror", responseText);
	}).fail(function(jqXHR, textStatus, errorThrown) {
		LOG.warn('request failed: ', attributes);
		deferred.reject(textStatus, errorThrown);
	});

	return deferred;
};
