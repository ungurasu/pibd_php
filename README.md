# pibd_php
## *Ungurasu Ioan-Andrei 435E UPB ETTI 2021*

## DBConnection.php
Acest fisier contine clasa *DBConnection*. Aceasta clasa este responsabila pentru realizarea interfetei intre utilizator si baza de date.

Instanta si conectorul catre baza de date sunt statice, pentru functionarea corecta a site-ului.

Metoda *getInstance* creeaza instanta, daca aceasta nu exista deja, si initializeaza conectorul, folosind datele pe care utilizatorul le-a furnizat in login screen, care vor fi pastrate in sesiune.

Metoda *getDB* returneaza conectorul.

## index.php
Pagina de index verifica daca utilizatorul este conectat.

Daca nu e, il redirectionam la pagina de login, si ii dam un navbar restrictionat.

Daca este, il redirectionam la homescreen, si ii dam un navbar complet.

De asemenea, pagina de index mai contine un container pentru continuturile site-ului, si o functionalitate de afisare a diverselor mesaje de status si de eroare.

## login.php

Ii dam utilizatorului un formular. Dupa ce acesta completeaza datele, incercam sa il logam.

## logout.php

Distrugem sesiunea pentru a deloga utilizatorul. Astfel, se distrug credentialele si connectorul la baza de date.

## home