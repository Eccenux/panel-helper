Panel Helper
============

Panel Helper, to system pomocniczy do wyłaniania panelu obywatelskiego - zaczynamy od Gdańska.

Założenia
---------

Założenie podstawowe:

* System ma zapewniać rozłożenie głosów zgodne z rzeczywistości, a jednocześnie pozwolić na uniknięcie stronniczości wyboru.
* Ankiety i zbieranie danych to osobny system. Można użyć nawet ankiet dostępnych w ramach Google Docs. Natomiast analizę rozkładu statystycznego można wykonać za pomocą [GoogleFormAnalysis](https://github.com/Eccenux/GoogleFormAnalysis).
* System ma wspierać losowanie, ale nie może go zastąpić. W szczególności samo losowanie jest oparte o rzut fizycznymi kostkami.

### Ankiety i zbieranie danych ###

* System musi nadawać danej osobie unikatowy numer.
* System powinien - w miarę możliwości - wysyłać ten unikatowy numer do ankietowanej osoby (dodatkowy punkt kontroli nad prawidłowością przebiegu).
* System musi zwrócić (na koniec) listę z następującymi danymi:
	* dane identyfikacyjne: identyfikator w systemie ankiet (znany tylko użytkownikowi).
	* dane kontaktowe: imię, nazwisko, e-mail lub telefon, ew. adres (dane te będą ukryte dla operatora losowania).
	* dane różnicujące (profilowe): dzielnica, płeć, rok urodzenia (lub wiek), wykształcenie, dzieci (ma/nie ma).

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

1. System prezentuje dwie wizualizacje (dla porównania):
	* Teoretycznego rozkładu (opracowanego na podstawie statystyk).
	* Rzeczywistego rozkładu (z danych profilowych z ankiet).
2. Operator wprowadza maksymalne odchylenia dla każdego kryterium.
3. Przykładowe kryteria wyboru odchyleń od teoretycznego rozkładu:
	* Jeśli zgłosi się mało osób z dziećmi, to dopuszczana jest możliwość rezygnacji z tego kryterium.
	* Jeśli rozkład wiekowy zgłoszonych będzie znacząco inny niż teoretyczny, to dopuszczany będzie wybór osoby +/- 5 lat poza granice danej grupy wiekowej.
4. System wykonuje 3 losowania testowe, które mają wykazać, na ile sprawdzi się procedura przy zadanych odchyleniach.
5. Operator decyduje czy przeprowadzić właściwe losowanie przy zadanych kryteriach.

Jedynie punkt 1 z powyższych jest obecnie zrealizowany (ze względu małą liczbę zgłoszeń). Operator nie musi też z góry wprowadzać odchyleń.

### Krok 2. Losowanie grupy głównej i zastępczej ###

1. Operator wprowadza profil jako kryteria wyszukiwania. Operator ma swobodę rezygnacji z dowolnych kryteriów (ignorowania ich).
2. Wyświetlane są wszystkie dopasowane profile.
3. Operator może zmienić kryteria lub ponownie wylosować profil w wypadku zbyt małej liczby osób do przeprowadzenia losowania.
4. Operator przenosi wylosowaną osobę do grupy głównej.
5. Z tej samej listy losowana jest przynajmniej 1 osoba do grupy zastępczej.
6. Jeśli dzielnica jest wyczerpana, to pozostałe osoby można przenieść do grupy roboczej.

Dane kontaktowe są widoczne dopiero na koniec i tylko dla operatora. Jedynie dana osoba może zweryfikować kiedy została wylosowana (zna swój identyfikator).

### Krok 3. Losowanie grupy rezerwowej ###

Z punktu widzenia systemu jedną różnicą jest kwestia dzielnic. Operator losuje i wpisuje profile z uwzględnieniem dzielnicy. System umożliwia zatem także przefiltrowanie od razu do wybranej dzielnicy. 

### Krok 4. Wyniki ###

1. System jest przełączany w tryb wyników. Blokowana jest możliwość zmiany grupy i staje się możliwe wyświetlenie listy wylosowanych.
2. Do publicznej wiadomości podawana jest lista imion i nazwisk posortowana alfabetycznie.
3. Operator ma możliwość podejrzenia danych kontaktowych tych osób, aby powiadomić ich i upewnić się, że będą na spotkaniach. 
4. Istnieje możliwość wyświetlenia statystyk dla poszczególnych grup (sprawdzenia ostatecznego rozkładu).

Plany na przyszłość
-------------------

1. Możliwość zmiany trybu z losowania na wyniki przez administratora.
2. Możliwość zmiany grupy dla wielu osób jednocześnie (aby przenieść masowo do grupy roboczej).
3. Możliwość resetowania stanu przez administratora (przeniesienie wszystkich puli).
4. Śledzenie zmian grupy w historii zmian i wyświetlanie tej historii w celu sprawdzenia prawidłowości losowania.
5. Automatyczna symulacja losowania przy określonych odchyleniach.