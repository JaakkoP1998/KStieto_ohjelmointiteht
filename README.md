# KSTieto ohjelmointitehtävä
Sisältää koodit KStiedon ohjelmointitehtävän Back- ja Front-endiin.
Kansiossa KSTieto on back-endin PHP-koodi. KSTietoFront sisältää Vue.js koodit src-kansiosta.

Back-end toteutettiin käyttäen XAMPP-ohjelmistopakettia.
Tietokantana käytettiin mySQL-tietokantaa, joka tuli valmiiksi asennettuna XAMPP:in myötä.
Front-end toteutettiin käyttäen nodea. Tässä repossa on oleellisimmat front-endin koodit,
mutta myös koko front-end projekti löytyy reposta https://github.com/JaakkoP1998/KStieto_ohjelmointiteht_front.

### Muita työkaluja käytetty: 
- PHP tutoriaalit käytiin läpi Bro Code -youtubekanavan tutoriaalit.
- Vue:en tutustuttiin vuen omalla guidella.
- ChatGPT:tä käytettiin apuna CORS-asetuksien säädössä php-puolella.
- ChatGPT:tä on myös käytetty kommenttien päivityksessä käyttöliittymässä.

Tehtävän tekemiseen meni yhteensä noin 14 tuntia. 
Tehtävään meni enemmän aikaa varmaan koska PHP ja Vue oli itselleni vielä uusia tehtävää aloittaessa.
Toteutuksessa keskityin enemmän ominaisuuksiin ja jätin ulkomuodon oletukseksi. 
SQL puolella minulla oli käytössä 3 taulukkoa, users, comment ja admins. 
comment-taulukossa tuli pieni virhe nimeämisessä, sillä "comments" olisi ollut osuvampi nimi.
Taulukossa users oli id, username, password. 
Comment-taulukossa oli rivit id, userid (yhdisti kommentin käyttäjään), public (0 = ei julkinen, 1 = julkinen) 
ja content (varsinainen kommentti). Admin taulukossa (id, name, password) 
oli yksi ylläpitäjä, jota käytettiin periaatteessa vain 
salasanan tarkistukseen kun haluttiin kirjautua ylläpitäjänä käyttöliittymässä.


Eniten vaikeuksia koin järjestelmän ylläpitäjän toteutuksessa. 
Omasta mielestä ylläpitäjää ei ehkä välttämättä kannata toteuttaa 
samassa käyttöliittymässä kuin muiden käyttäjien. Ylläpitäjän koodia myös front-endissä olisi voinut
jakaa useampaan komponenttiin, joka olisi varmaan tehnyt tämän osuudesta luettavampaa.
Back-end puolella CORS-asetuksien kanssa oli myös hankaluuksia, mutta kun nämä saatiin kertaalleen kuntoon
sen kanssa ei enään tullut ongelmia.

Onnistumisia oli taas muun PHP-koodin kanssa. PHP oli tuntemattomaksi kieleksi erittäin nopeasti omaksuttavissa
ja myös Vueen oli aika nopea päästä sisään. Pidin myös paljon Vuen bind-ominaisuuksista, jolloinka ei tarvinnut
luoda isoja effect-hookkeja jos haluttiin esimerkiksi lomakkeen arvo kiinnittää muuttujaan.