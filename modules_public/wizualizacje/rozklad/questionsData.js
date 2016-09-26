/**
	Pytania (tylko użyte):
	* [select-one] jednokrotny wybór = wybierz z listy
	* [select-many] wielokrotny wybór
	* [grid] siatka
	* [text] tekst = tekst akapitu
*/
var questionsData =
[
	{
		title:"Sygnatura czasowa"
		, displayTitle:"Liczba odpowiedzi dziennych"
		, type: 'date'
	},
	{
		title:"Miejsce zamieszkania"
		, type: 'select-one'
		, other: false
		, options:
			['Warszawa','miasto','wie\u015b']
	},
	{
		title:"Płeć"
		, type: 'select-one'
		, other: false
		, options:
		["kobieta"
		,"mężczyzna"]
	},
	{
		title:"Wiek"
		, type: 'select-one'
		, other: false
		, options:
		["16-24"
		,"25-39"
		,"40-64"
		,"więcej niż 65 lat"]
	},
	{
		title:"Wykształcenie"
		, type: 'select-one'
		, other: false
		, options:
		["podstawowe"
		,"średnie"
		,"wyższe"]
	}
];
