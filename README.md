Panel Helper
============

Dokumentacja techniczna do systemu pomocniczego wyłaniania panelu obywatelskiego - zaczynamy od Gdańska.

Założenia
---------

Założenie podstawowe:

* System ma zapewniać rozłożenie głosów zgodne z rzeczywistości, a jednocześnie pozwolić na uniknięcie stronniczości wyboru.
* Ankiety i zbieranie danych to osobny system. Można użyć nawet ankiet dostępnych w ramach Google Docs. Wstępną analizę rozkładu danych można wykonać wówczas bezpośrednio za pomocą [GoogleFormAnalysis](https://github.com/Eccenux/GoogleFormAnalysis).
* System ma wspierać losowanie, ale nie może go zastąpić. W szczególności samo losowanie jest oparte o rzut fizycznymi kostkami.

### Ankiety i zbieranie danych ###

* System musi nadawać danej osobie unikatowy numer.
* System powinien - w miarę możliwości - wysyłać ten unikatowy numer do ankietowanej osoby (dodatkowy punkt kontroli nad prawidłowością przebiegu).
* System musi zwrócić (na koniec) listę z następującymi danymi:
	* dane identyfikacyjne: identyfikator w systemie ankiet (znany tylko użytkownikowi).
	* dane kontaktowe: imię, nazwisko, e-mail lub telefon, ew. adres (dane te będą ukryte dla operatora losowania).
	* dane różnicujące (profilowe): dzielnica, płeć, grupa wiekowa, wykształcenie, dzieci (ma/nie ma).

### Losowanie - przebieg i założenia ###

1. Rozkład ma być losowany według rzeczywistych proporcji w mieście, nie według tego kto się zgłosi.
2. Losowane są na początku profile osób: płeć, grupa wiekowa, wykształcenie, dzieci (ma/nie ma). Przykład: kobieta, lat 18-24, wykształcenie średnie, nie ma dzieci.
3. Kolejne profile są losowane tak by spełnić zakładany rozkład. Przykład: mając już 5 kobiet i tylko 4 mężczyzn ostatni profil automatycznie jest męski.
4. Następnie z osób spełniających dane kryteria jest losowana konkretna osoba (konkretny identyfikator). Jej dane osobowe nie będą publicznie znane! Pozwoli to uniknąć niepotrzebnego ujawniania danych osobowych.
5. Dzielnica jest elementem odrzucającym. Czyli po wylosowaniu osoby z danej dzielnicy pozostałe losowania nie uwzględniają już tej dzielnicy.
6. Po wylosowaniu jednej osoby z danej dzielnicy (i z danym profilem) losowane są osoby zastępujące. Czyli osoby, które mogą zastąpić pierwszą jeśli ta nie będzie mogła przyjść.
7. Po zakończeniu losowania pokazywane są alfabetycznie ułożone nazwiska i imiona wylosowanych osób wraz z zastępcami.
8. Następnie wyznaczane są 3 osoby rezerwowe. Przebiega to podobnie przy czym dzielnice są wówczas losowane z góry.

System wspomagający losowanie
-----------------------------

Elementy wspomagania, czyli przebieg losowania z punktu widzenia kolejnych kroków wykonywanych przez operatora systemu wspomagania losowania - *Panel Helper*.

### Krok 1. Przygotowanie do losowania ###

Przygotowanie umożliwia szybkie przeprowadzenie próbnego głosowania i dobranie odpowiednich parametrów, żeby wybór był w ogóle możliwy. Gdyby losowanie następowało ze wszystkich (większości) mieszkańców, to ten krok byłby zbędny.

* System prezentuje dwie wizualizacje (dla porównania):
	* Teoretycznego rozkładu (opracowanego na podstawie statystyk).
	* Generowanie rzeczywistego rozkładu (ankietowanych).
* Operator wprowadza maksymalne odchylenia dla każdego kryterium.
* Przykładowe kryteria wyboru odchyleń od teoretycznego rozkładu:
	* Jeśli zgłosi się mało osób z dziećmi, to dopuszczana jest możliwość rezygnacji z tego kryterium.
	* Jeśli rozkład wiekowy zgłoszonych będzie znacząco inny niż teoretyczny, to dopuszczany będzie wybór osoby z sąsiedniej grupy wiekowej.
* System wykonuje 3 losowania testowe, które mają wykazać, na ile sprawdzi się procedura przy zadanych odchyleniach.
* Operator decyduje czy przeprowadzić właściwe losowanie przy zadanych kryteriach.

### Krok 2. Losowanie grupy głównej i zastępczej ###

1. Operator wprowadza kolejne profile osób - wówczas system:
	1. Filtruje dane - wyświetla identyfikatory osób na podstawie wprowadzonego profilu.
	2. W wypadku mniej niż 2 osób pasujących do profilu, system zaproponuje inne osoby (według przyjętych maksymalnych odchyleń). Lista będzie podzielona według kolejnych odchyleń (osobno odchylenie dla mniej ważnego kryterium, osobno drugiego, osobno dla obu jednocześnie).
	3. Możliwość ponownego losowania profilu w wypadku braku osób spełniających wylosowane kryteria.
3. Operator zaznaczy wylosowaną osobę - wówczas system:
	1. Odrzuca osoby z tej samej dzielnicy z głównej puli.
	2. Pokazuje inne osoby z tej samej dzielnicy spełniające te same kryteria (do losowania osób zastępujących).
	3. W wypadku mniej niż 2 osób pasujących do profilu, system zaproponuje inne osoby (według przyjętych maksymalnych odchyleń).
4. Operator zaznaczy wylosowaną osobę zastępującą.
5. System umożliwia zaznaczenie kolejnych osób do grupy zastępczej.
6. Przed wprowadzeniem następnego profilu system pokazuje ile osób należy jeszcze wybrać z każdej grupy.

Dane kontaktowe są widoczne dopiero na koniec i tylko dla operatora. Jedynie dana osoba może zweryfikować kiedy została wylosowana (zna swój identyfikator).

Do publicznej wiadomości podawana jest lista imion i nazwisk posortowana alfabetycznie.

### Krok 3. Losowanie grupy rezerwowej ###

Z punktu widzenia systemu jedną różnicą jest kwestia dzielnic. Operator losuje i wpisuje profile z uwzględnieniem dzielnicy. System umożliwia zatem także przefiltrowanie od razu do wybranej dzielnicy. 
