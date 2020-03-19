DROP FUNCTION IF EXISTS make_anon_string;
DROP FUNCTION IF EXISTS make_letter_string;

CREATE FUNCTION make_anon_string (some_string varchar(8000))
RETURNS varchar(8000)
return
replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(
replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(
replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(
some_string
, '0', '0'), '1', '0'), '2', '0'), '3', '0'), '4', '0'), '5', '0'), '6', '0'), '7', '0'), '8', '0'), '9', '0')
, 'ą', 'a'), 'b', 'a'), 'c', 'a'), 'ć', 'a'), 'd', 'a'), 'e', 'a'), 'ę', 'a'), 'f', 'a'), 'g', 'a'), 'h', 'a'), 'i', 'a'), 'j', 'a'), 'k', 'a'), 'l', 'a'), 'ł', 'a'), 'm', 'a'), 'n', 'a'), 'ń', 'a'), 'o', 'a'), 'ó', 'a'), 'p', 'a'), 'q', 'a'), 'r', 'a'), 's', 'a'), 'ś', 'a'), 't', 'a'), 'u', 'a'), 'v', 'a'), 'w', 'a'), 'x', 'a'), 'y', 'a'), 'z', 'a'), 'ź', 'a'), 'ż', 'a')
, 'Ą', 'A'), 'B', 'A'), 'C', 'A'), 'Ć', 'A'), 'D', 'A'), 'E', 'A'), 'Ę', 'A'), 'F', 'A'), 'G', 'A'), 'H', 'A'), 'I', 'A'), 'J', 'A'), 'K', 'A'), 'L', 'A'), 'Ł', 'A'), 'M', 'A'), 'N', 'A'), 'Ń', 'A'), 'O', 'A'), 'Ó', 'A'), 'P', 'A'), 'Q', 'A'), 'R', 'A'), 'S', 'A'), 'Ś', 'A'), 'T', 'A'), 'U', 'A'), 'V', 'A'), 'W', 'A'), 'X', 'A'), 'Y', 'A'), 'Z', 'A'), 'Ź', 'A'), 'Ż', 'A')
;

CREATE FUNCTION make_letter_string (some_string varchar(8000))
RETURNS varchar(8000)
return
replace(replace(replace(replace(replace(replace(replace(replace(replace(replace(
some_string
, '0', 'o'), '1', 'q'), '2', 'w'), '3', 'e'), '4', 'r'), '5', 't'), '6', 'y'), '7', 'u'), '8', 'i'), '9', 'p')
;

UPDATE personal
	SET
		`imie`	    =make_anon_string(`imie`	),
		`nazwisko`	=make_anon_string(`nazwisko`),
		`nr_tel`	=make_anon_string(`nr_tel`	),
		`e_mail`	=make_anon_string(`e_mail`	),
		
		`ankieta_id`=make_letter_string(7*`id`+1234)
;

UPDATE profile
	SET
		`ankieta_id`=make_letter_string(7*`id`+1234)
;


/*
SELECT * FROM personal;
*/