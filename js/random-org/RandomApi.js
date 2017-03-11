/* global RANDOM_ORG_KEY */
var randomApi = new RandomApi(RANDOM_ORG_KEY);

function RandomApi(key)
{
	this.key = key;
}

RandomApi.prototype.drawIntegers = function(min, max, n, canHaveDuplicates) {
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
	$.ajax({
		url: 'https://api.random.org/json-rpc/1/invoke',
		method: 'POST',
		contentType: 'application/json',
		dataType: "text",
		data: JSON.stringify(requestData),
		
	}).done(function(responseData) {
		console.log(responseData);
	}).fail(function() {
		console.log(attributes);
	});
}
