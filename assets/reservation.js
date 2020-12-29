/*
 * Fichier JS de réservation des Events
 */

//import du coeur et des plugins nécessaires de FullCalendar
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

//construction du calendrier
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin ],
        initialView: 'dayGridMonth',
        //tableau des events qui s'afficheront dans le calendrier
        events: produits
    });

  calendar.render();
});