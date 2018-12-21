# examentool

Trelloboard:

https://trello.com/b/iY9vLZ8i/examenafname

Stappenplan voor opzetten van de back-end:
Installeer PHP met MongoDB Plugin:
1.	Ga naar deze site: https://sourceforge.net/projects/wampserver/files/WampServer%203/
2.	Download de laatste versie (groene download knop)
3.	Run installer.
4.	Start Wamp.
5.	Rechts onder in je taakbalk, klik op het wamp icoon (linker muisklik)
 

6.Ga in het menu naar PHP:
 
 
7. Ga naar versie:
 
8. Zet de versie naar 7.1.16
 


9. Ga naar deze site: http://pecl.php.net/package/mongodb/1.5.2/windows
10. Download deze versie: “7.1 Thread Safe (TS) x64”
 
11. Open de php_mongodb zip file.
12. Plaats de php_mongodb.dll file in “C:\wamp64\bin\php\php7.1.16\ext” (De wamp64 kan ook op andere plaatsen staan dan de C:\ schijf, aanhankelijk van waar je Wamp installeert)
13. Open het bestand php.ini in de folder “C:\wamp64\bin\php\php7.1.16.
14. Zoek naar de tekst “extension=php_shmop.dll”, plaats de lijn hieronder deze tekst “extension=php_mongodb.dll” en sla het bestand op(en sluit het bestand na opslaan).
15. Ga naar “C:\wamp64\bin\apache\apache2.4.33\bin” En open het php.ini bestand, en voer daar ook stap 14. Uit.
16. Rechts onder in je taakbalk, klik op het wamp icoon (rechter muisklik), en click exit.
17. Start wamp weer op.


Installeer MongoDB
1.	Ga naar de site van mongoDB
2.	Select bij Version: 4.0.3, OS passend bij draaiende OS, en Package naar MIS
3.	Download
4.	Execute het .msi bestand.
5.	In de installatie kies voor de Custom optie bij de Setup Type
6.	Loop de installer door, en install.

Installeer Composer en download project
1.	Ga naar de site van composer. 
2.	Klik op de download knop.
3.	Bovenaan in de sectie “Windows Installer” klik op de “Composer-Setup.exe” link.
4.	Run de Composer-Setup.exe. Zorg ervoor dat je bij de PHP versie in de installer php 7.1.16 selecteert van je Wamp installatie!!!! (C:\wamp64\bin\php\php7.1.16\php.exe)
5.	Maak de installation af.
6.	Download de zip bestand van de server verzie (word aangeleverd)
7.	Pak deze uit in een map (liefste in je www folder in wamp)
8.	Ga met cmd naar de root van de folder
9.	Run de volgende lijst aan commands in volgorde (allemaal zonder quotes): 
10.	“composer update” 
11.	“php artisan migrate:fresh”
12.	“php artisan db:seed”
13.	Voer daarna het volgende command uit en laat deze draaien (is de server die de backend draait): “php -S localhost:8000 -t public”

De back-end zou nu volledig moeten werken
