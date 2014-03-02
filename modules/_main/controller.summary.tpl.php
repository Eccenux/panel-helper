<h2>System wspomagający losowanie</h2>
<p>Elementy wspomagania, czyli przebieg losowania z punktu widzenia kolejnych kroków wykonywanych przez operatora systemu wspomagania losowania - <em>Panel Helper</em>.</p>
<h3>Krok 1. Przygotowanie do losowania</h3>
<p>Przygotowanie umożliwia szybkie przeprowadzenie próbnego głosowania i dobranie odpowiednich parametrów, żeby wybór był w ogóle możliwy. Gdyby losowanie następowało ze wszystkich (większości) mieszkańców, to ten krok byłby zbędny.</p>
<ul>
<li>
System prezentuje dwie wizualizacje (dla porównania):
<ul>
<li>Teoretycznego rozkładu (opracowanego na podstawie statystyk).</li>
<li>Generowanie rzeczywistego rozkładu (ankietowanych).</li>
</ul>
</li>
<li>Operator wprowadza maksymalne odchylenia dla każdego kryterium.</li>
<li>
Przykładowe kryteria wyboru odchyleń od teoretycznego rozkładu:
<ul>
<li>Jeśli zgłosi się mało osób z dziećmi, to dopuszczana jest możliwość rezygnacji z tego kryterium.</li>
<li>Jeśli rozkład wiekowy zgłoszonych będzie znacząco inny niż teoretyczny, to dopuszczany będzie wybór osoby +/- 5 lat poza granice danej grupy wiekowej.</li>
</ul>
</li>
<li>System wykonuje 3 losowania testowe, które mają wykazać, na ile sprawdzi się procedura przy zadanych odchyleniach.</li>
<li>Operator decyduje czy przeprowadzić właściwe losowanie przy zadanych kryteriach.</li>
</ul>
<h3>Krok 2. Losowanie grupy głównej i zastępczej</h3>
<ol>
<li>
Operator wprowadza kolejne profile osób - wówczas system:
<ol>
<li>Filtruje dane - wyświetla identyfikatory osób na podstawie wprowadzonego profilu.</li>
<li>W wypadku mniej niż 2 osób pasujących do profilu, system zaproponuje inne osoby (według przyjętych maksymalnych odchyleń). Lista będzie podzielona według kolejnych odchyleń (osobno odchylenie dla mniej ważnego kryterium, osobno drugiego, osobno dla obu jednocześnie).</li>
<li>Możliwość ponownego losowania profilu w wypadku braku osób spełniających wylosowane kryteria.</li>
</ol>
</li>
<li>
Operator zaznaczy wylosowaną osobę - wówczas system:
<ol>
<li>Odrzuca osoby z tej samej dzielnicy z głównej puli.</li>
<li>Pokazuje inne osoby z tej samej dzielnicy spełniające te same kryteria (do losowania osób zastępujących).</li>
<li>W wypadku mniej niż 2 osób pasujących do profilu, system zaproponuje inne osoby (według przyjętych maksymalnych odchyleń).</li>
</ol>
</li>
<li>Operator zaznaczy wylosowaną osobę zastępującą.</li>
<li>System umożliwia zaznaczenie kolejnych osób do grupy zastępczej.</li>
<li>Przed wprowadzeniem następnego profilu system pokazuje ile osób należy jeszcze wybrać z każdej grupy.</li>
</ol>
<p>Dane kontaktowe są widoczne dopiero na koniec i tylko dla operatora. Jedynie dana osoba może zweryfikować kiedy została wylosowana (zna swój identyfikator).</p>
<p>Do publicznej wiadomości podawana jest lista imion i nazwisk posortowana alfabetycznie.</p>
<h3>Krok 3. Losowanie grupy rezerwowej</h3>
<p>Z punktu widzenia systemu jedną różnicą jest kwestia dzielnic. Operator losuje i wpisuje profile z uwzględnieniem dzielnicy. System umożliwia zatem także przefiltrowanie od razu do wybranej dzielnicy. </p>
