/*
 * Fichier JS de réservation des Events
 */

//import du coeur et des plugins nécessaires de FullCalendar
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import frLocale from '@fullcalendar/core/locales/fr';

//construction du calendrier au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin ],
        initialView: 'dayGridMonth',
        locale: frLocale,
        events: creneaux,  //la variable creneaux a été construite dans le fichier de template _creneaux_for_calendar
        eventDidMount: function(info) {
          //dans cette fonction on peut modifier le rendu du creneau
          if (info.event.extendedProps.reservable) {
            //ajout des éléments nécessaires pour ouvrir la modale
            info.el.dataset.toggle = 'modal';
            info.el.dataset.target = '#modal_reservation';
            //ajout des données propres au créneau, pour pouvoir les injecter plus tard dans la modale
            info.el.dataset.debut = info.event.extendedProps.debut;
            info.el.dataset.fin = info.event.extendedProps.fin;
            info.el.dataset.creneauId = info.event.extendedProps.creneauId;
            info.el.dataset.places = info.event.extendedProps.places;
            //rend l'élément "cliquable"
            info.el.style.cursor = 'pointer';
          }
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

//remplissage de la modale avec les valeurs du créneau cliqué
$('#modal_reservation').on('show.bs.modal', function (event) {
  console.log('click !')
  var creneau = $(event.relatedTarget) // Button that triggered the modal
  var debut = creneau.data('debut')
  var fin = creneau.data('fin')
  var creneauId = creneau.data('creneauId')
  var places = creneau.data('places'); // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.creneau-debut').text('Début : Le ' + debut)
  modal.find('.creneau-fin').text('Fin : Le ' + fin)
  modal.find('#reservation_creneau_id').val(creneauId);
  modal.find('#reservation_quantite').attr('max', places);
})