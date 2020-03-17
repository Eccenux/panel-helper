Panel Helper
============

Panel Helper, to system pomocniczy do wyłaniania panelu obywatelskiego - zaczynamy od Gdańska.

Założenia
---------

Założenie podstawowe:

* System ma zapewniać rozłożenie profili statystycznych osób zgodne ze statystyką dla całego miasta, a jednocześnie pozwolić na uniknięcie stronniczości wyboru.
* Ankiety i zbieranie danych to osobny system. Można użyć nawet ankiet dostępnych w ramach Google Docs. Natomiast analizę rozkładu statystycznego można wykonać za pomocą [GoogleFormAnalysis](https://github.com/Eccenux/GoogleFormAnalysis).
* System ma wspierać losowanie, ale z założenia nie może go zastąpić. W szczególności samo losowanie jest oparte o rzut fizycznymi kostkami.

### Ankiety i zbieranie danych ###

* System musi nadawać danej osobie unikatowy numer.
* System powinien - w miarę możliwości - wysyłać ten unikatowy numer do ankietowanej osoby (dodatkowy punkt kontroli nad prawidłowością przebiegu).
* System musi zwrócić (na koniec) listę z następującymi danymi:
	* dane identyfikacyjne: identyfikator w systemie ankiet (znany tylko użytkownikowi).
	* dane kontaktowe: imię, nazwisko, e-mail lub telefon, ew. adres (dane te będą ukryte dla operatora losowania).
	* dane różnicujące (profilowe): region, płeć, data urodzenia (lub wiek), wykształcenie.

### Losowanie - przebieg i założenia ###

Przykład przygotowanie profili (poza Panel Helperem): 
1. Rozkład ma być losowany według rzeczywistych proporcji w mieście, nie według tego kto się zgłosi.
2. Losowane są na początku profile osób: region, płeć, grupa wiekowa, wykształcenie. Przykład: śródmieście, kobieta, lat 18-24, wykształcenie średnie, nie ma dzieci.
3. Kolejne profile są losowane tak by spełnić zakładany rozkład. Przykład: mając już 5 kobiet i tylko 4 mężczyzn ostatni profil automatycznie jest męski.

Przebieg losowania w PH:
1. Przygotowane profile można wprowadzić do bazy danych.
2. Operator wchodzi w Wyszukiwanie &rarr; w puli.
3. Na podstawie profili wyszukiwane są osoby spełniające ten profil.
4. Następnie z osób spełniających dane kryteria jest losowana konkretna osoba (konkretny identyfikator). Jej dane osobowe nie będą publicznie znane! Pozwoli to uniknąć niepotrzebnego ujawniania danych osobowych.
5. Od razu losowane są również osoby zastępujące (spełniające ten sam profil). Czyli osoby, które mogą zastąpić pierwszą jeśli ta nie będzie mogła przyjść.
6. Następnie wyznaczane są dodatkowe osoby rezerwowe. Przebiega to podobnie jak dla grupy głównej.

Po zakończeniu losowania pokazywane są alfabetycznie ułożone nazwiska i imiona wylosowanych osób wraz z zastępcami.

System wspomagający losowanie
-----------------------------

Elementy wspomagania, czyli przebieg losowania z punktu widzenia kolejnych kroków wykonywanych przez operatora systemu wspomagania losowania - *Panel Helper*.

### Krok 1. Przygotowanie do losowania ###

Podczas przygotowania należy ustalić, które kryteria mogą zostać spełnione w trakcie losowania. Jeśli np. do panelu zgłosiło się mało osób z wykształceniem średnim, to można pominąć parametr wykształcenie.

System prezentuje dwie wizualizacje (dla porównania):
* Teoretycznego rozkładu (opracowanego na podstawie danych statystycznych).
* Rzeczywistego rozkładu (z danych profilowych z ankiet).

Operator decyduje jakie kryteria zostaną użyte przy losowaniu i tworzy profile statystyczne używane później przy losowaniu.

Na tym etapie administrator ustawia panel w tryb testowy, umożliwiając przejrzenie całego systemu. Dlatego dane osobowe powinny być zanonimizowane (można też na ten moment usunąć zawartość tabeli *personal*).   

### Krok 2. Losowanie grupy głównej i zastępczej ###

#### Przygotowanie przed wejściem na żywo ####

1. Administrator ustawia panel w tryb losowania i resetuje wybór z testowych losowań.
2. Administrator wprowadza do systemu prawdziwe dane z rejestracji.
3. Administrator wprowadza profile do bazy danych.
4. Operator wchodzi w *Wyszukiwanie &rarr; w puli*. Operator musi upewnić się, że "Przydział do grup" jest pusty. Jeśli nie, musi niezwłocznie powiadomić administratora.
5. Operator wchodzi w *Historia &rarr; Historia działań* i czyści swoją historię.

#### Etap na żywo ####

1. Operator wchodzi w *Wyszukiwanie &rarr; w puli*.
	1. Upewnia się, że "Przydział do grup" jest pusty (wszyscy powinni być *w puli*).
	2. Upewnia się, że "Historia działań" jest pusta.
2. Operator wprowadza profil jako kryteria wyszukiwania. Operator ma swobodę rezygnacji z dowolnych kryteriów (ignorowania ich).
3. Wyświetlane są wszystkie dopasowane profile.
4. Operator może zignorować jeden z parametrów statystycznych w wypadku zbyt małej liczby osób do przeprowadzenia losowania.
5. Komisja losowania wykonuje rzut kostką losując osobę z listy.
6. Operator przenosi wylosowaną osobę do grupy głównej.
7. Z tej samej listy losowana jest *przynajmniej* 1 osoba do grupy zastępczej.

Dane kontaktowe są widoczne dopiero na koniec i tylko dla operatora. Jedynie dana osoba może zweryfikować kiedy została wylosowana (zna swój identyfikator).

### Krok 3. Wyniki ###

1. Administrator przełącza system w tryb wyników. Blokowana jest możliwość zmiany grupy i staje się możliwe wyświetlenie listy wylosowanych.
2. Do publicznej wiadomości podawana jest lista imion i nazwisk posortowana alfabetycznie.
3. Operator ma możliwość podejrzenia danych kontaktowych tych osób, aby powiadomić ich i upewnić się, że będą na spotkaniach. 
4. Istnieje możliwość wyświetlenia statystyk dla poszczególnych grup (sprawdzenia ostatecznego rozkładu).

Plany na przyszłość
-------------------

1. Możliwość ładowania profili przez Operatora.
2. Możliwość resetowania stanu przez administratora (przeniesienie wszystkich puli). W ramach panelu administracyjnego, a nie w bazie.
3. Możliwość zdalnego podłączenia się do witryny przez użytkowników w celu bezpośredniego kontrolowania prawidłowości losowania (wyświetlanie historii zmian, możliwość sprawdzenia historii random.org). Ma ułatwić podejrzenie rzeczy, które słabo widać przy transmisji na żywo.
4. Automatyczna symulacja losowania przy określonych odchyleniach.