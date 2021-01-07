/*
 * Fichier JS de réservation des Events
 */

//import du coeur et des plugins nécessaires de FullCalendar
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import frLocale from '@fullcalendar/core/locales/fr';

//construction du calendrier à l'ouverture de la modale
$('#modal_disponibilite').on('shown.bs.modal', function () {

  var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin ],
        initialView: 'dayGridMonth',
        locale: frLocale,
        events: creneaux,  //la variable creneaux a été construite dans le fichier de template
        eventDidMount: function(info) {
          //dans cette fonction on peut modifier le rendu du creneau
        },
        eventTimeFormat: {
          //ici on modifie comment s'affiche l'heure des créneaux
          hour: '2-digit',
          minute: '2-digit',
          meridiem: false
        },
        validRange: function(nowDate) {
          return {
            start: nowDate,
          };
        }
    });

  calendar.render();
});