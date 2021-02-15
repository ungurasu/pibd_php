# pibd_php
*Ungurasu Ioan-Andrei 435E UPB ETTI 2021*

- [pibd_php](#pibd-php)
    * [DBConnection.php](#dbconnectionphp)
    * [index.php](#indexphp)
    * [login.php](#loginphp)
    * [logout.php](#logoutphp)
    * [home.php](#homephp)
    * [show-table.php](#show-tablephp)
    * [deletea-ction.php](#deletea-ctionphp)
    * [update-form.php](#update-formphp)
    * [update-action.php](#update-actionphp)

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

## home.php

Contine cateva propozitii despre proiect.

## show-table.php

Interogam baza de date si cream un formular cu o lista cu toate tablele. Il intrebam pe utilizator pe care vrea sa il vizualizeze.

Cream un tabel cu datele din tabel, si cu un buton de delete si un buton de update pentru fiecare row.

Baza de date este interogata, astfel incat sa gasim foreign key restraint-urile si sa putem sa aratam datele referentiate din alte tabele adiacente.

## deletea-ction.php

Primim prin GET tabelul din care stergem, campul de PK, si PK-ul dupa care vom sterge.

## update-form.php

Primim prin GET tabelul din care updatam, campul de PK, si PK-ul dupa care updatam.

Generam un formular pentru fiecare camp (in afara de PK), precompletat cu datele deja existente in row-ul pe care vrem sa il updatam.

## update-action.php

Primim prin GET tabelul din care updatam, campul de PK, si PK-ul dupa care updatam.

Primim prin POST continuturile campurilor.

Interogam baza de date ca sa vedem ce campuri are tabelul si construim o instructiune sql, luand informatiile necesare din GET si din POST.