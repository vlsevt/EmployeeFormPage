## ICD0007 Projekti testid

### Testide käivitamine
`php testideFailiNimi.php`

### Veakoodide seletused

`N01` Probleem võrguühendusega. Üks võimalus on see, et server ei käi oodatud aadressil.

`N02` Server vastas veaga. See juhtub siis, kui küsitud faili ei leita või Php skript lõpetab veaga.
Vea tuvastamisel võib abiks olla infost serveri konsoolis. Selle info leiate sellest aknast, kust serveri käima panite.

`N03` Server ei vastanud määratud aja jooksul. See juhtub siis, kui rakenduse kood on liiga aeglane või saadeti vigane päring.

`C01` Üldine viga, mille puhul peaks veateade ise piisav olema.

`C02` Võrreldavad väärtused ei ole võrdsed. Esmalt peaks testist välja lugema, millist väärtust test ootab. Seejärel peaks otsustama, kas see on põhjendatud ootus. Kas see ootus vastab ülesande kirjeldusele? Kui see on selge, siis jääb vaid üle selgeks teha, miks teie programm teisiti käitub.

`C03` Otsitavad sõne ei leita otsitavast tekstist. Probleemi lahendamine on analoogiline `C02` lahendamisega.

`C04` Leiti sõne, mida ei peaks otsitavas tekstis olema. Probleemi lahendamine on analoogiline `C02` lahendamisega.

`C05` Otsitavad sõne peaks leiduma vaid üks kord. Leiti rohkem või vähem. Probleemi lahendamine on analoogiline `C02` lahendamisega.

`C06` See viga võib juhtuda list-ide võrdlemisel. Oodatakse, et mingis listis on nõutud elemendid aga nende järjekord ei ole täpselt määratud.

`C07` Test ootab, et valikute hulgas (_select_) on valik (_option_) testis antud väärtusega aga teie programmi väljundist sellist ei leitud.

`D01` Test ootab, et programm kuvas lehe, millel on nimetatud id (<body id=...). All on mõned põhjused, miks viga võis juhtuda.
- lehele on id panemata jäänud või on vale.
- link viitas valesse kohta.
- programm kuvas vale lehe.
- programm kuvas vea.

`H01` Viga programmi poolt väljastatavas Html-is. Teie programm väljastab Html koodi ja brauser näitab selle väljundi põhjal mingit pilti ka siis, kui see Html ei olnud korrektne. Test on rangem ja nõuab, et Html oleks korrektne (nt. kõik tag-id pannakse kinni). Kui teie programm väljastas Html-i mis polnud korrektne, siis annab test sellest teada ja ütleb ka milliselt realt viga leiti. Siin on loomulikult juttu väljundi ridadest, mitte teie programmi ridadest. Probleemi lahendamisel võib kasuks tulla `Html väljundi vaatamine`.

`H02` Lingi _href_ atribuut või vormi _action_ atribuut sisaldab keelatud sümboleid. Veebi aadressis ei tohi olla näiteks tühikuid. Probleemi lahendamiseks peaksite probleemsed sümbolid eemaldama. Üks võimalus nendest sümbolitest lahti saada, on info kodeerimine urlencode() funktsiooniga.

`H03` Test ootas, et näiteks lingile vajutades navigeeriti kindlale aadressile aga tegelikult see nii ei olnud. Probleemi lahendamiseks peaks selgeks tegema, millist käitumist test ootab. Kui see on selge, siis jääb vaid üle selgeks teha, miks teie programm teisiti käitub.

`H04` Test otsib, praeguselt lehe __tekstist__ kindlat sõne. Teksti all on mõeldud seda teksti, mida kasutaja brauserist näeb, mitte Html lähtekoodi. Praegune leht on see, kuhu testi abil on navigeeritud. Kui otsitud sõne ei leita, siis on võimalus, et see on pisut teisiti kirjutatud või puudub üldse. Lisaks on võimalus, et teie programm ei väljastanud õiget lehtegi. Näiteks test ootas, et nimekirja lehel on kindel väärtus aga teie programm näitas hoopis vormi lehte. Probleemi lahendamisel võib kasuks tulla `Html väljundi vaatamine`.

`H05` Test otsib, praeguse lehe __Html lähtekoodist__ kindlat sõne. Probleemi lahendamine on analoogiline `H04` lahendamisega.

`H06` Teie lehel on mitu sisestuse elementi (_input_) sama sama nimega ja test ei suuda neid eristatda. 

`W02` Link pole relatiivne. Relatiivne link ei alga kaldkriipsuga.

`W03` Test ootab, et praegusel lehel on link millel on _id_ atribuut testis määratud väärtusega.
Probleemi lahendamisel võib kasuks tulla `Html väljundi vaatamine`.

`W04` Test ootab, et praegusel lehel on link mille sisuks on tekst testis määratud väärtusega.
Probleemi lahendamisel võib kasuks tulla `Html väljundi vaatamine`.

`W05` Test ootab, et praegusel lehel on sisestuskast (input või textarea) testis määratud nimega.
Probleemi lahendamisel võib kasuks tulla `Html väljundi vaatamine`.

`W06` Test ootab, et praegusel lehel on nupp (input või button) testis määratud nimega.
Mõlema elemendi puhul on oluline, et type atribuut oleks väärtusega 'submit'.
Probleemi lahendamisel võib kasuks tulla `Html väljundi vaatamine`.

`W07` Viga juhub siis, kui test otsib lehelt mingit vormi elementi (sisestusväli, checkbox, nupp jne) aga lehel ei ole isegi form tag-i. Kõik sisestuselemendid peavad vormi sees paiknema. Vea parandamiseks tuleks sisestuselemendid form tag-iga ümbritseda.

`G01` Ootamatu viga. Test ei ole sellise olukorraga arvestanud. Siin on võimalus, et teie programm on korrektne ja viga on testis.

`J01` Pärast aadressi vahetust on rakenduse olek kadunud. Tõenäoline põhjus on lehe täielik laadimine. 

`Html väljundi vaatamine`  

Testide failis on all

    setPrintPageSourceOnError(false);

Kui kirjutate sinna **false** asemele **true**, siis väljastatab test koos veaga ka teie programmi poolt väljastatud Html-i, mille kohta viga anti. Siis jääb vaid üle selgeks teha, miks teie programm selliselt vastas.

Lisaks on võimalik testides kasutada funktsooni 

    printPageSource();

mis väljastab html-i koodi, mille teie programm väljastas **viimase** päringuga. Test teeb üldjuhul teie rakendusele rohkem, kui ühe päringu ja seega on oluline, kuhu see väljakutse kirjutada.

Lisaks on võimalik testides kasutada funktsooni

    printPageText();

mis väljastab **teksti**, mille teie programm väljastas **viimase** päringuga. Teksti all on mõeldud seda teksti, mida kasutaja brauserist näeb, mitte Html lähtekoodi.
