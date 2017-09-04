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
		, other: true
		, options:
			['ANIOŁKI','BRĘTOWO','BRZEŹNO','CHEŁM','JASIEŃ','KOKOSZKI','KRAKOWIEC-GÓRKI ZACHODNIE','LETNICA','MATARNIA','MŁYNISKA','NOWY PORT','OLIWA','OLSZYNKA','ORUNIA-ŚW.WOJCIECH-LIPCE','OSOWA','PIECKI-MIGOWO','PRZERÓBKA','PRZYMORZE MAŁE','PRZYMORZE WIELKIE','RUDNIKI','SIEDLCE','ŚRÓDMIEŚCIE','STOGI','STRZYŻA','SUCHANINO','UJEŚCISKO-ŁOSTOWICE','VII DWÓR','WRZESZCZ DOLNY','WRZESZCZ GÓRNY','WYSPA SOBIESZEWSKA','WZGÓRZE MICKIEWICZA','ŻABIANKA-WEJHERA-JELITKOWO-TYSIĄCLECIA','ZASPA MŁYNIEC','ZASPA ROZSTAJE']
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
		["18-24"
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
