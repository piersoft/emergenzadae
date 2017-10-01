Mappa con i Defibrillatori censiti nel Comune di Lecce.

Il file update.php aggiorna il file mappaf.json (che deve essere scrivibile), quindi basta eseguirlo quando ci sono dei nuovi inserimenti.

Basta cambiare il link in update.php del dataset: https://goo.gl/sIisnN creandone uno identico come struttura relativo al proprio Comune.

La mappa si aspetta di avere nell'URL anche i parametri lat e lon.
Ad esempio: http://www.piersoft.it/emergenzadae/?lat=40.3466025&lon=18.1943455

Nel caso venga lanciata solo http://www.piersoft.it/emergenzadae/ viene inserito un marker puntato sulla piazza principale di Lecce. Nel caso di personalizzazione sul vostro Comune, sostituire in tal caso nel file index.php:

lat=parseFloat('40.35313');
lon=parseFloat('18.17257');

Con le coordinate di vostro interesse.

Attenzione!!!
I pin dei DAE sono verdi o rossi a seconda della disponibilità dichiarata dai singoli gestori locali dei DAE. E' bene precisare che il sistema non è responsabile di errori sui DAE non diponibili.
