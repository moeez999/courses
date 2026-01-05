let dateSelect = null; 
let timeSelect = null; 
let dateTimeUTC = null 
let boolsend = false
let tempData = null
let idEdit = null
let seding = false
let refresh = false
let edit = false
let getOptionsRepeat = null
// .format('YYYY-MM-DD HH:mm:ss')


let currentNow = moment().tz(timeZone);
// console.log('hora actual',currentNow)
let currentDate = currentNow.format('YYYY-MM-DD');
let minutCompare = currentNow.format('mm');
let currentTime = currentNow.set('minute', 0).format('HH:mm');
moment.locale('es'); // Esto afecta a todos los momentos creados después

// getData()
$(function(){
      // Schedule dropdown
      $('#my_lessons_schedule_btn').on('click', function(e){
        e.stopPropagation();
        $('#my_lessons_schedule_menu').toggle();
      });
      $(document).on('click', function(){
        $('#my_lessons_schedule_menu').hide();
      });
      $('.my_lessons_schedule_option').on('click', function(){
        var type = $(this).data('type');
        // console.log('Selected schedule type:', type);
        $('#my_lessons_schedule_menu').hide();
      });

      // Tab switching
      $('#my_lessons_tabs .my_lessons_tab_item').on('click', function(){
        var tgt = $(this).data('target');
        $('.my_lessons_tab_item').removeClass('active');
        $(this).addClass('active');
        $('.my_lessons_tab_content').hide();
        $(tgt).show();
      });

      // 3-dot menu in Lessons tab
      $('.my_lessons_lesson_card .my_lessons_menu_icon').on('click', function(e){

        e.stopPropagation();
        // hide any open menus
        $('.my_lessons_card_menu').hide();
        // show this card’s menu
        $(this).closest('.my_lessons_lesson_card').find('.my_lessons_card_menu').show();
      });
      // click outside closes menus
      $(document).on('click', function(){
        $('.my_lessons_card_menu').hide();
      });
      // menu actions
      $('.my_lessons_card_menu li').on('click', function(){
        var action = $(this).text().trim();
        // console.log('Lesson action:', action);
        $(this).closest('.my_lessons_card_menu').hide();
      });
    });



$(document).ready(function () {
  // Helper: get Monday of the week
  function getMonday(d) {
    d = moment(d).tz(timeZone);
    var day = d.day(),
        diff = d.date() - day + (day === 0 ? -6 : 1);
    d.date(diff).hours(0).minutes(0).seconds(0).milliseconds(0);
    return d;
  }

  // Global State
  var today = moment().tz(timeZone).hours(0).minutes(0).seconds(0).milliseconds(0);
  var currentMonday = getMonday(today);

  function pad(num) {
    return num < 10 ? '0' + num : num;
  }

  function resetModal(){
    // reset
    edit= false
    idEdit = null
    repeat.active =false
    repeat.repeatOn = null;
    repeat.repeatEvery = 1;
    repeat.type = null;
    Object.keys(daysActive).forEach(key => daysActive[key] = false);
    repeat.weekDays = daysActive;
    $('.customrec_day_btn').hide()
    $('#deleteEvent').empty()
    $('.customrec_day_btn').removeClass('active')
    activeRepeat = false
    typeRepeat = null;
    $('#titleModalEvent').text('Management')
    repeat.end = 'Never'
    $('#selectoPicker').css('background-color', '#1635e5');

    recInt = 1;
    $('#customrec_interval').text(recInt);
    $('#customrec_period_val').text('...');
    $('.conference_modal_repeat_btn').contents().filter(function() {
      return this.nodeType === 3; // Nodo de texto
    }).first().replaceWith('Does not repeat');
    
    $('#conferenceCohortsDropdown').contents().filter(function() {
      return this.nodeType === 3; // Nodo de texto
    }).first().replaceWith('XX#');
    
    $('#conferenceTeachersDropdown').html('Select Teacher<span style="float:right; font-size:1rem;">▼</span>')
    delete repeat.repeatOn;

    // Obtener el primero que esté marcado
    const firstChecked = $('input[name="customrec_end"]').first();

    // Desmarcar todos
    $('input[name="customrec_end"]').prop('checked', false);
    $('.conference_modal_attendees_list').empty()
    // Volver a marcar solo el primero encontrado
    firstChecked.prop('checked', true);
    $('#customrec_end_date_btn').attr('disabled', true);
    $('#customrec_end_date_btn').removeClass('enabled')
    $('.conference_modal_cohort_list').empty();
    $('.conference_modal_attendee').empty();
    idCohortsModal = [];
    idTeachersModal = [];

  }

  let weekCurrent = 0

  function autoCompleteForm(item, time, cellDate){
    edit = true
    idEdit = item.id
    refresh = true
    let idCohortsGet = [];
    let idTeachersGet = [];
    $('.conference_modal_cohort_list').empty();
    $('#sendDataButton').css('background-color', 'gray');
    Promise.all([
      fetch(`${apiUrlMoodle}getcohorts.php?idplanificaction=${item.id}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
      }).then(r => {
        if (!r.ok) throw new Error('Error en cohorts');
        return r.json();
      }),

      fetch(`${apiUrlMoodle}getteachers.php?idplanificaction=${item.id}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
      }).then(r => {
        if (!r.ok) throw new Error('Error en teachers');
        return r.json();
      }),
      
      fetch(`${apiUrlMoodle}optoinsrepeat.php?idplanificaction=${item.id}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
      }).then(r => {
        if (!r.ok) throw new Error('Error en teachers');
        return r.json();
      })
    ])
    .then(([cohorts, teachers, optionsRepeat]) => {
      // Mantén tus asignaciones intactas
      refresh = false
      idCohortsGet = cohorts;
      idTeachersGet = teachers;
      getOptionsRepeat = optionsRepeat;
      if(optionsRepeat){
        $('.conference_modal_repeat_btn').html(`
          Repeat
          <span style="float:right; font-size:1rem;">▼</span>
        `)
        let opt = null;
        if (optionsRepeat) {
          const keys = Object.keys(optionsRepeat || {});
          if (Array.isArray(optionsRepeat)) {
            opt = optionsRepeat[0] || null;
          } else if (keys.length === 1 && typeof optionsRepeat[keys[0]] === 'object') {
            opt = optionsRepeat[keys[0]];
          } else {
            opt = optionsRepeat;
          }
        }

        if (opt) {
          // Activar repetición si hay tipo
          repeat.active = !!opt.type;

          // Tipo de repetición (e.g. 'day', 'week', 'month', ...)
          repeat.type = opt.type || null;

          // Cada cuántos (string -> number, con fallback a 1)
          repeat.repeatEvery = parseInt(opt.repeatevery, 10) || 1;

          // Días de la semana (API entrega "1"/"0")
          repeat.weekDays = {
            mon: opt.monday   == "1",
            tue: opt.tuesday  == "1",
            wed: opt.wednesday== "1",
            thu: opt.thursday == "1",
            fri: opt.friday   == "1",
            sat: opt.saturday == "1",
            sun: opt.sunday   == "1",
          };

          // Condición de finalización
          if (opt.never == "1") {
            repeat.end = "Never";
            repeat.repeatOn = null;
          } else if (opt.repeaton) {
            // Hasta una fecha específica
            repeat.end = "date";
            repeat.repeatOn = opt.repeaton; // deja el valor tal cual lo envía el API
          } else if (opt.repeatafter) {
            // Después de N ocurrencias
            repeat.end = String(opt.repeatafter);
            repeat.repeatOn = null;
          } else {
            // Fallback sensato
            repeat.end = "Never";
            repeat.repeatOn = null;
          }

          // (Opcional) sincroniza variables que usas al enviar
          if (typeof repeatEveryCount !== 'undefined') repeatEveryCount = repeat.repeatEvery;
          if (typeof daysActive !== 'undefined')       daysActive       = repeat.weekDays;
          if (typeof typeRepeat !== 'undefined')       typeRepeat       = repeat.type;
          if (typeof activeRepeat !== 'undefined')     activeRepeat     = repeat.active;

          $('#customrec_interval').text(repeat.repeatEvery);
          if(repeat.type == 'week'){
            $('#customrec_period_val').text('Week');
            
            const days = ["mon","tue","wed","thu","fri","sat","sun"];

            days.forEach(day => {
              const btn = $(`.customrec_day_btn[data-day="${day}"]`);
              if (repeat.weekDays[day]) {
                btn.addClass("active").show();
              } else {
                btn.show();
              }
            });

          }else{
            $('.customrec_day_btn').hide();
            $('#customrec_period_val').text('Day');
          }
          if(repeat.repeatOn != null){
            $('#customrec_end_never').prop('checked', false);
            $('#customrec_end_on').prop('checked', true);
            
            const formattedDate = moment
            .unix(parseInt(repeat.repeatOn, 10))   // lo pasas de segundos a fecha
            .tz(timeZone)                          // aplicas la zona horaria actual
            .format("MMM DD,YYYY");                // formato: Sep 27,2024
            $('#customrec_end_date_btn').prop('disabled', false);
            $('#customrec_end_date_btn').addClass('enabled');

          $('#customrec_end_date_btn').text(formattedDate);

          }
          // $('#customrec_period_val').text(repeat.end === 'Never' ? '...' : repeat.end);
        }
        
      }

      // Cambia el color solo cuando ambas respuestas llegaron
      $('#sendDataButton').css('background-color', '#fe2e0c');

      // --- AHORA recorre cohortList y pinta SOLO los que coinciden ---
      // Limpia la lista antes de pintar (si quieres)
      $('.conference_modal_cohort_list').empty();
      console.log('cohortList', cohortList);
      Object.values(idCohortsGet).forEach(c => {
        const cohortid = String(c.id);
          Object.values(cohortList).forEach(m => {
            if(m.id == cohortid) {
              idCohortsModal.push(cohortid);
              const shortname = c.shortname ?? '';
              const fullname  = c.name ?? '';
              $('.conference_modal_cohort_list').append(`
                <li data-cohort="${cohortid}">
                  <span class="conference_modal_cohort_chip">${shortname}</span>
                  <span class="conference_modal_attendee_name">${fullname}</span>
                  <span class="conference_modal_remove">&times;</span>
                </li>
              `);
            }
          })

      });

      // Limpia la lista de asistentes (si quieres limpiar antes)
      $('.conference_modal_attendees_list').empty();


      // Recorre lo que devolvió la API (idTeachersGet) y solo pinta si coincide con teachersList (PHP)
      Object.values(idTeachersGet).forEach(t => {
        const teacherId = t.iduserteacher;

        Object.values(teachersList).forEach(m => {
          if (String(m.id) === teacherId) {
            idTeachersModal.push(teacherId);

            // Evita duplicados
            // if ($('.conference_modal_attendees_list li[data-teacher="'+teacherId+'"]').length > 0) return;
            // Nombre a mostrar (prioriza datos del fetch; no modificamos nada)
            const full =
              [t.firstname, t.lastname].filter(Boolean).join(' ') ||
              t.fullname || t.name ||
              [m.firstname, m.lastname].filter(Boolean).join(' ') ||
              m.username || m.email || `User ${teacherId}`;

            // Avatar (si tu API no trae imagen, usa un placeholder de Moodle)
            const avatar =
              t.profileimageurlsmall || t.profileimageurl ||
              m.profileimageurlsmall || m.profileimageurl ||
              (window.M && M.cfg && M.cfg.wwwroot ? `${M.cfg.wwwroot}/pix/u/f2.png` : '');

            // Inserta en la lista
            $('.conference_modal_attendees_list').append(`
              <li data-teacher="${teacherId}" class="conference_modal_attendee">
                <img src="${avatar}" class="calendar_admin_details_create_cohort_teacher_avatar" width="35" height="35" alt="${full}" title="${full}">
                <span>${full}</span>
                <span class="conference_modal_icon user">👤</span>
                <span class="conference_modal_remove">&times;</span>
              </li>
            `);

            // Si manejas un array de seleccionados:
            if (Array.isArray(window.idTeachersModal)) {
              idTeachersModal.push(teacherId);
            }
          }
        });
      });

    })
    .catch(error => {
      console.error('❌ Error al obtener datos:', error);
    });

    $('#titleModalEvent').text('Edit Event: #' + item.id)
    // --- Botón de borrar evento ---
    $('#deleteEvent').html(`
      <button style="background:none;border:none;margin-top:8px;" id="deleteEventBtn" class="delete-btn" title="Eliminar evento">
        <i style='color:red' class="fa fa-trash"></i>
      </button>
    `);

    $('#deleteEventBtn').off('click').on('click', function() {
      Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
              
          if (!item || !item.id) {
            console.error('❌ No se encontró item.id para borrar');
            return;
          }


          fetch(`${apiUrlMoodle}deleteclass.php`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ idplanificaction: item.id })
          })
          .then(response => {
            if (!response.ok) throw new Error('Error en deleteclass.php');
            return response.json();
          })
          .then(res => {
            console.log('✅ Evento eliminado:', res);

            
            getData();
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeOut();
            resetModal();
          })
          .catch(err => {
            console.error('❌ Error eliminando evento:', err);
            alert('No se pudo eliminar el evento');
          });
        }
      });
    });


    $('#selectoPicker').css('background-color', item.color);
    dateSelect = cellDate
    timeSelect = time

    // Mantengo tu cálculo original de tempData a partir del calendario:
    tempData = moment.tz(`${dateSelect}T${timeSelect}`, 'YYYY-MM-DDTHH:mm', timeZone);

    dateTimeUTC = tempData.clone().utc().toISOString();
    
    // -------------------------------------------
    // START (normaliza desde item.startdate si viene)  // NUEVO
    // -------------------------------------------
    if (item && item.startdate != null && item.startdate !== '') {             // NUEVO
      if ((typeof item.startdate === 'string' && /^\d+$/.test(item.startdate)) || typeof item.startdate === 'number') {
        const n  = Number(item.startdate);
        const ms = n < 1e12 ? n * 1000 : n;
        startTimeEvent = new Date(ms).toISOString();
      } else {
        const d = new Date(item.startdate);
        if (isNaN(d.getTime())) throw new Error('Formato de fecha inválido: ' + item.startdate);
        startTimeEvent = d.toISOString();
      }
    } else {                                                                   // NUEVO: fallback a tu tempData
      startTimeEvent = dateTimeUTC;                                            // NUEVO
    }

    // -------------------------------------------
    // FINISH (usa item.finishdate o +1h de start) // (tu bloque original, intacto)
    // -------------------------------------------
    if (item.finishdate != null && item.finishdate !== '') {
      if ((typeof item.finishdate === 'string' && /^\d+$/.test(item.finishdate)) || typeof item.finishdate === 'number') {
        const n  = Number(item.finishdate);
        const ms = n < 1e12 ? n * 1000 : n;
        finishTimeEvent = new Date(ms).toISOString();
      } else {
        const d = new Date(item.finishdate);
        if (isNaN(d.getTime())) throw new Error('Formato de fecha inválido: ' + item.finishdate);
        finishTimeEvent = d.toISOString();
      }
    } else {
      finishTimeEvent = new Date(new Date(startTimeEvent).getTime() + 60*60*1000).toISOString();
    }

    // Para mostrar (en local)                                                 
    // Para mostrar con timezone específico
    const startDisplay  = moment(startTimeEvent).tz(timeZone);
    const finishDisplay = moment(finishTimeEvent).tz(timeZone);

    // -------------------------------------------
    // SIN QUITAR NADA: ahora sincronizo UI y variables
    // con lo obtenido de item.startdate/finishdate
    // -------------------------------------------

    // CAMBIO: la fecha del botón desde startDisplay (no desde tempData)
    $('#conferenceTabContent .conference_modal_date_btn').first().text(startDisplay.format('D, MMM YYYY')); // CAMBIO

    // CAMBIO: las horas desde start/finish calculados
    $('#conferenceTabContent .conference_modal_time_btn').eq(0).text(startDisplay.format("HH:mm")); // CAMBIO
    $('#conferenceTabContent .conference_modal_time_btn').eq(1).text(finishDisplay.format("HH:mm")); // CAMBIO
    $('#conferenceTabContent .conference_modal_time_btn').eq(0).addClass('selected');
    $('#conferenceTabContent .conference_modal_time_btn').eq(1).addClass('selected');
    $('#conferenceTabContent .conference_modal_time_btn').text();

    // NUEVO: alinear también los selects/base internos con startTimeEvent
    dateSelect = startDisplay.format('YYYY-MM-DD');                             // NUEVO
    timeSelect = startDisplay.format('HH:mm');                                  // NUEVO
    tempData   = moment.tz(`${dateSelect}T${timeSelect}`, 'YYYY-MM-DDTHH:mm', timeZone); // NUEVO

    // CAMBIO: el param que envías como "inicio" debe ser el normalizado de item
    dateTimeUTC = new Date(startTimeEvent).toISOString();                       // CAMBIO

    let dateTime = moment.tz(`${dateSelect}T${timeSelect}`, 'YYYY-MM-DDTHH:mm', timeZone).toDate();
  }

  function renderWeek(startDate, week) {
    weekCurrent = week
    var days = [];
    const start = moment(startDate).tz(timeZone);
    const nowMoment = moment().tz(timeZone).startOf('day');
    const compareDays = start.diff(nowMoment, 'days');
    for (let i = 0; i < 7; i++) {
      let day = start.clone().add(i, 'days');
      days.push(day);
    }

    let rangeStr = days[0].format('MMMM DD') + '–' + days[6].format('DD, YYYY');
    $('.my_lessons_calendar_date').text(rangeStr);

    $('.calendar-day-header').each(function (i) {
      var day = days[i];
      var weekday = day.format('dddd');
      var dayNumber = day.format('DD');
      var label = `${weekday} ${dayNumber}`;

      $(this).text(label);
      $(this).attr('data-date', day.format('YYYY-MM-DD'));
      $(this).find('.line_time').remove();
      $(this).css('position', '');

      $('tbody tr').each(function(rowIndex) {
        $(this).find('td').each(function(colIndex) {
          if (days[colIndex]) {
            $(this).attr('data-date', days[colIndex].format('YYYY-MM-DD'));
            // $(this).attr('data-day-week', days[colIndex].format('ddd'));
          }
        });
      });
    });

    $('.calendar-day-header, tbody tr td').removeClass('highlight-today');
    $('.line_time').remove();

    var todayCol = -1;
    var currentRealToday = moment.tz(timeZone).startOf('day');

    days.forEach(function (day, i) {
      if (day.isSame(currentRealToday, 'day')) {
        todayCol = i;
      }
    });

    if (todayCol !== -1) {
      $('.calendar-day-header').eq(todayCol).addClass('highlight-today');
      $('tbody tr').each(function () {
        var $tds = $(this).find('td');
        if ($tds.length === 1) {
          $tds.addClass('highlight-today');
        } else if ($tds.length > todayCol) {
          $tds.eq(todayCol).addClass('highlight-today');
        }
      });

      var now = moment.tz(timeZone);
      var nowMinutes = now.hours() * 60 + now.minutes();

      var $rows = $('.my_lessons_calendar_table tbody tr');
      var placed = false;

      $rows.each(function (rowIdx) {
        var $th = $(this).find('th').first();
        var startTime = $th.text().trim();
        var match = startTime.match(/^(\d{1,2}):(\d{2})$/);
        if (!match) return;

        var startMoment = moment.tz(match[1] + ':' + match[2], 'H:mm', timeZone);
        var startTotal = startMoment.hours() * 60 + startMoment.minutes();

        var $nextRow = $rows.eq(rowIdx + 1);
        var nextTime = $nextRow.length ? $nextRow.find('th').first().text().trim() : null;
        var endTotal;

        if (nextTime) {
          var nextMatch = nextTime.match(/^(\d{1,2}):(\d{2})$/);
          if (nextMatch) {
            var endMoment = moment.tz(nextMatch[1] + ':' + nextMatch[2], 'H:mm', timeZone);
            endTotal = endMoment.hours() * 60 + endMoment.minutes();
          } else {
            endTotal = startTotal + 60;
          }
        } else {
          endTotal = startTotal + 60;
        }

        // Puedes usar startTotal, endTotal y nowMinutes aquí si quieres mostrar una línea de tiempo
      });
    }

    $('td[data-date][data-time]').each(function () {
      $(this).find('.my_lessons_calendar_event_wrapper').remove();
    });
    

    // foreach events
    Object.values(dataplanification).forEach(item => {
      if (!item.startdate || !item.finishdate || item.idplanificaction) return;
      const startMoment = moment.unix(item.startdate).utc().tz(timeZone);
      const finishMoment = moment.unix(item.finishdate).utc().tz(timeZone);
      const durationInHours = Math.ceil(moment.duration(finishMoment.diff(startMoment)).asHours());
      const color = item.color;
      const idplanification = item.id;

      const current = startMoment.clone();

      for (let i = 0; i < durationInHours; i++) {
        const cellDate = current.format('YYYY-MM-DD');
        const cellTime = current.format('HH:mm');

        $(`td[data-date="${cellDate}"][data-time="${cellTime}"]`).each(function () {
          const $cell = $(this);
          
          // Crear o usar contenedor para eventos en esa celda
          let $wrapper = $cell.find('.my_lessons_calendar_event_wrapper');
          if ($wrapper.length === 0) {
            $wrapper = $('<div class="my_lessons_calendar_event_wrapper"></div>');
            $cell.append($wrapper);
          }

          const $eventCalendar = $(`
            <div data-bs-toggle="tooltip" title="Evento ${item.id}" class="my_lessons_calendar_event my_lessons_event_weekly" style="background-color:${color}">
              ${
                i === 0
                  ? `
                  <i class="fas fa-video-camera my_lessons_event_icon"></i>
                  <div class="my_lessons_event_time">${startMoment.format('HH:mm')}–${finishMoment.format('HH:mm')}</div>`
                  : ''
              }
            </div>
          `);

          $wrapper.append($eventCalendar);

          $eventCalendar.off('click').on('click', function () {
            resetModal()
            $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
            autoCompleteForm(item,cellTime,cellDate)
          });
        });

        current.add(1, 'hour');
      }
    });

    // foreach repeat events
    Object.values(dataplanification).forEach(item => {
      if (!item.startdate || !item.finishdate || !item.idplanificaction) return;
      const startMoment = moment.unix(item.startdate).utc().tz(timeZone);
      const finishMoment = moment.unix(item.finishdate).utc().tz(timeZone);
      let endevent = null;
      if (item.repeaton) {
        endevent = moment.unix(item.repeaton);
      }
      const durationInHours = Math.ceil(moment.duration(finishMoment.diff(startMoment)).asHours());
      const color = item.color;
      const idplanification = item.id;
      const current = startMoment.clone();
      

      if (item.type === 'week') {
        const startOfCalendarWeek = days[0].clone().startOf('isoWeek'); // lunes de la semana mostrada
        const startOfEventWeek = startMoment.clone().startOf('isoWeek'); // lunes del evento
        const diffInWeeks = startOfCalendarWeek.diff(startOfEventWeek, 'weeks');

        if (diffInWeeks < 0) return; // Evento aún no comienza
        if (endevent && moment.unix(item.repeaton).isBefore(startOfCalendarWeek)) return; // Evento ya terminó
        if (diffInWeeks % parseInt(item.repeatevery) !== 0) return;

        for (let i = 0; i < durationInHours; i++) {
          const cellTime = current.format('HH:mm');
          const dayKey = current.format('ddd').toLowerCase(); // ej: 'wed'

          $(`td[data-time="${cellTime}"]`).each(function () {
            const cellDay = $(this).attr('data-day'); // ej: "wed", "thu", etc.
            const cellDate = moment($(this).attr('data-date'));

            // console.log(cellDay, item[cellDay])
            if (item[cellDay] !== "1") return;

            const eventStartDate = startMoment.clone().startOf('day');
            if (cellDate.isBefore(eventStartDate, 'day')) return;
            if (endevent && endevent.isBefore(cellDate, 'day')) return;

            const $cell = $(this);
            let $wrapper = $cell.find('.my_lessons_calendar_event_wrapper');
            if ($wrapper.length === 0) {
              $wrapper = $('<div class="my_lessons_calendar_event_wrapper"></div>');
              $cell.append($wrapper);
            }

            const $eventCalendar = $(`
              <div data-bs-toggle="tooltip" title="Evento ${item.id}" class="my_lessons_calendar_event my_lessons_event_weekly" style="background-color:${color}">
                ${
                  i === 0
                    ? `
                    <i class="fas fa-video-camera my_lessons_event_icon"></i>
                    <div class="my_lessons_event_time">${startMoment.format('HH:mm')}–${finishMoment.format('HH:mm')}</div>`
                    : ''
                }
              </div>
            `);

            $wrapper.append($eventCalendar);

            $eventCalendar.off('click').on('click', function () {
              resetModal()
              $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
              autoCompleteForm(item, cellTime,cellDate)
            });
          });

          current.add(1, 'hour');
        }
      }

      
      
      if (item.type === 'day') {
        // Asegúrate de que startMoment/finishMoment también se hayan creado con tz(timeZone)
        // ej.: const startMoment = moment.unix(item.startdate).tz(timeZone);

        const eventStartDate = moment.unix(item.startdate).tz(timeZone).startOf('day');
        const repeatEvery = parseInt(item.repeatevery, 10);

        // repeaton en la MISMA zona (y al inicio/fin de día según tu lógica)
        // aquí lo dejamos inclusivo: permite el último día igual a repeaton
        const endevent = item.repeaton
          ? moment.unix(item.repeaton).tz(timeZone).startOf('day')
          : null;

        for (let i = 0; i < durationInHours; i++) {
          const currentHour = startMoment.clone().add(i, 'hours');
          const cellTime = currentHour.format('HH:mm');

          $(`td[data-time="${cellTime}"]`).each(function () {
            // data-date es 'YYYY-MM-DD' → parsea con formato + TZ
            const cellDateMoment = moment.tz($(this).attr('data-date'), 'YYYY-MM-DD', timeZone).startOf('day');

            if (cellDateMoment.isBefore(eventStartDate, 'day')) return;
            if (endevent && cellDateMoment.isAfter(endevent, 'day')) return;

            const diffInDays = cellDateMoment.diff(eventStartDate, 'days');
            if (repeatEvery > 0 && (diffInDays % repeatEvery) !== 0) return;

            const $cell = $(this);
            let $wrapper = $cell.find('.my_lessons_calendar_event_wrapper');
            if ($wrapper.length === 0) {
              $wrapper = $('<div class="my_lessons_calendar_event_wrapper"></div>');
              $cell.append($wrapper);
            }

            const $eventCalendar = $(`
              <div data-bs-toggle="tooltip" title="Evento ${item.id}" class="my_lessons_calendar_event my_lessons_event_daily" style="background-color:${color}">
                ${
                  i === 0
                    ? `
                    <i class="fas fa-video-camera my_lessons_event_icon"></i>
                    <div class="my_lessons_event_time">${startMoment.format('HH:mm')}–${finishMoment.format('HH:mm')}</div>`
                    : ''
                }
              </div>
            `);

            $wrapper.append($eventCalendar);

            $eventCalendar.off('click').on('click', function () {
              resetModal();
              $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
              const celldate = $(this).parent().parent().attr('data-date');
              autoCompleteForm(item, cellTime, celldate);
            });
          });
        }
      }


    });

    $(`td[data-date="${currentDate}"][data-time="${currentTime}"]`).each(function () {
      const $cell = $(this);
      const $line = $(`
        <span class="line_time">
          <span class="circle"></span>
        </span>
      `);
      $cell.append($line);
      let porcentual = Math.round((minutCompare / 60) * 100);
      $line.css({ top: `${porcentual}%` });
    });
  }

  function getData() {
    // console.log('run')
    fetch(`${apiUrlMoodle}saveclass.php`, {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' },
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Error en la solicitud');
      }
      return response.json();
    })
    .then(data => {
      // console.log('📥 Datos actualizados:', data);
      dataplanification = data;
      console.log(dataplanification)
      // Elimina entradas anteriores
      $('.my_lessons_calendar_event').remove();

      // Renderiza de nuevo la semana actual con los datos nuevos
      renderWeek(currentMonday, weekCurrent);
    })
    .catch(error => {
      console.error('❌ Error al obtener datos:', error);
    });
  }

    // Initial render
    renderWeek(currentMonday, 0);

    
      // Prev week
    $('#prevWeek').click(function () {
      currentMonday = moment(currentMonday).tz(timeZone).subtract(7, 'days');
      renderWeek(currentMonday, weekCurrent - 1);
    });

    // Next week
    $('#nextWeek').click(function () {
      currentMonday = moment(currentMonday).tz(timeZone).add(7, 'days');
      renderWeek(currentMonday, weekCurrent + 1);
    });

    // Today
    $('#todayBtn').click(function () {
      today = moment().tz(timeZone).startOf('day');
      currentMonday = getMonday(today);
      renderWeek(currentMonday, 0);
    });

    function toggleFeedback() {
      if ($('#exampleModal').hasClass('show')) {
          // Si ya está abierto, lo cerramos
          $('#exampleModal').modal('hide');
      } else {
          // Si está cerrado, lo abrimos
          $('#exampleModal').modal('show');
      }
  }

    // Optional: Auto-update line every minute (uncomment to use)
    // setInterval(function() { renderWeek(currentMonday); }, 60000);
      $('.my_lessons_calendar_slot_empty').on('click', function(){
          if ($(this).find('div').length > 0) {
            // Tiene contenido, no hacer nada
            e.stopPropagation();
            return;
          }
          dateSelect = $(this).attr('data-date')

          timeSelect = $(this).attr('data-time')
          tempData = moment.tz(`${dateSelect}T${timeSelect}`, 'YYYY-MM-DDTHH:mm', timeZone);

          dateTimeUTC = tempData.clone().utc().toISOString();
          
          startTimeEvent = dateTimeUTC;
          finishTimeEvent = tempData.clone().add(1, 'hour').utc().toISOString();

          
          $('#conferenceTabContent .conference_modal_date_btn').first().text(tempData.format('D, MMM YYYY'));
          $('#conferenceTabContent .conference_modal_time_btn').eq(0).text(tempData.format("HH:mm"));
          $('#conferenceTabContent .conference_modal_time_btn').eq(1).text(tempData.clone().add(1,'hour').format("HH:mm"));
          $('#conferenceTabContent .conference_modal_time_btn').eq(0).addClass('selected');
          $('#conferenceTabContent .conference_modal_time_btn').eq(1).addClass('selected');
          $('#conferenceTabContent .conference_modal_time_btn').text();
          let dateTime = moment.tz(`${dateSelect}T${timeSelect}`, 'YYYY-MM-DDTHH:mm', timeZone).toDate();
          // [0, 17, 2000] as month are 0-indexed
          const [hour, minutes, seconds] = [
            dateTime.getHours(),
            dateTime.getMinutes(),
            dateTime.getSeconds(),
          ];
          const nextHour = (hour + 1) % 24; // Asegura que no pases de 23
          $('#label-hour').text(`${dateTime.toDateString()}`);
          resetModal();
          $('#calendar_admin_details_create_cohort_modal_backdrop').fadeIn();
          
      })
      

      // send conference
      $('.conference_modal_btn').on('click', function(e) {
        if (moment(startTimeEvent).isAfter(finishTimeEvent)) return
        // if(idTeachersModal.length == 0 || idCohortsModal.length == 0) return
        e.preventDefault();
        let startOn = $('#conferenceTabContent .conference_modal_date_btn').first().text().trim();
        let startTime = $('#conferenceTabContent .conference_modal_time_btn').eq(0).text().trim();
        let endTime = $('#conferenceTabContent .conference_modal_time_btn').eq(1).text().trim();
        let timezone = $('#conferenceTabContent .conference_modal_timezone').val();
        
        let attendees = [];
        $('#conferenceTabContent .conference_modal_attendee').each(function() {
          let cohort = $(this).find('.conference_modal_attendee_name').text().trim();
          let email = $(this).find('span').eq(1).text().trim();
          if(cohort) attendees.push(cohort);
          else if(email) attendees.push(email);
        });

        const selectedOption = $('input[name="customrec_end"]:checked').attr('id');
        let result = '';

        if (selectedOption === 'customrec_end_never') {
          result = 'Never';
        } else if (selectedOption === 'customrec_end_on') {
          const date = $('#customrec_end_date_btn').text();
          result = 'date';
        } else if (selectedOption === 'customrec_end_after') {
          const occurrences = $('#customrec_occ_val').text();
          result = occurrences;
        } else {
          result = 'No end condition selected.';
        }
        if (result == 'date' && !repeat.repeatOn ) return
        repeat.repeatEvery = repeatEveryCount
        repeat.weekDays = daysActive
        repeat.type = typeRepeat
        repeat.active = activeRepeat

        repeat.end = result
        let bgColor = $('#selectoPicker').css('background-color');
        let confData = {
          edit: edit,
          id: idEdit,
          repeat: repeat,
          timezone: timezone,
          cohorts: idCohortsModal,
          teachers: idTeachersModal,
          color:bgColor,
          startTimeEvent:startTimeEvent,
          finishTimeEvent:finishTimeEvent
        };
        // alert(JSON.stringify(confData))
        // console.log(confData)
        // return
        if (seding) return; // ya se está enviando, no hacer nada
        if (refresh) return; // ya se está enviando, no hacer nada
        seding = true; // marcar como en envío
        // console.log(confData)

        // luego ejecutar el fetch
        fetch(`${apiUrlMoodle}saveclass.php`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(confData)
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Error en la solicitud');
          }
          // console.log(repeat)
          // console.log(repeat)
          return response.json();
        })
        .then(result => {
          // console.log('✅ Resultado del backend:', result);

          getData();
          $('#calendar_admin_details_create_cohort_modal_backdrop').fadeOut();
          resetModal();

        })
        .catch(error => {
          console.error('❌ Error al guardar:', error);
        })
        .finally(() => {
          seding = false; // liberar la bandera
        });

      });

      

    $('#reconection').click(()=>{
      sendData()
    })
  });




$(function() {
  // Only one open at a time
  $(document).on('click', '.tutor-action-dot', function(e) {
    e.stopPropagation();
    // Close other open menus
    $('.tutor-action-menu').hide();
    // Show this one
    var $menu = $(this).next('.tutor-action-menu');
    $menu.css('display', 'block');
  });

  // Hide menu on click outside
  $(document).on('click', function() {
    $('.tutor-action-menu').hide();
  });

  // Prevent closing when clicking inside the menu
  $(document).on('click', '.tutor-action-menu', function(e) {
    e.stopPropagation();
  });
});
