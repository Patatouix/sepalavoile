/*
 * Fichier JS de réservation des Events
 */

//import du coeur et des plugins nécessaires de FullCalendar
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

//construction du calendrier à l'ouverture de la modale
$('#modal_disponibilite').on('shown.bs.modal', function () {

  var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin ],
        initialView: 'dayGridMonth',
        events: creneaux,  //la variable creneaux a été construite dans le fichier de template _creneaux_for_calendar
        eventDidMount: function(info) {
          //dans cette fonction on peut modifier le rendu du creneau
        },
        eventTimeFormat: {
          //ici on modifie comment s'affiche l'heure des créneaux
          hour: '2-digit',
          minute: '2-digit',
          meridiem: false
        }
    });

  calendar.render();
});