
$(document).ready(function() {

   let day = moment().local()
   let now = moment().local()
   let buttonLabel = moment.utc(member.localstart, 'DD MMM YYYY').local().format('MMM-DD')
   $('#buttonLabel').text(buttonLabel)

   let weekDay = {
    
     oneDay : day.format('MMM-DD'),
     secondDay : day.add(1, 'days').format('MMM-DD'),
     threeDay : day.add(1, 'days').format('MMM-DD'),
     fourthDay : day.add(1, 'days').format('MMM-DD'),
     fiveDay : day.add(1, 'days').format('MMM-DD'),
     sixDay : day.add(1, 'days').format('MMM-DD'),
     sevenDay : day.add(1, 'days').format('MMM-DD'),
   }


    // Recorre cada elemento con la clase contentDay
    $('.contentDay').each(function(index) {
        // Asigna el valor correspondiente del array si existe
        switch (index) {
            case 0:
                $(this).text(weekDay.oneDay);
                break;
            case 1:
                $(this).text(weekDay.secondDay);
                break;
            case 2:
                $(this).text(weekDay.threeDay);
                break;
            case 3:
                $(this).text(weekDay.fourthDay);
                break;
            case 4:
                $(this).text(weekDay.fiveDay);
                break;
            case 5:
                $(this).text(weekDay.sixDay);
                break;
            case 6:
                $(this).text(weekDay.sevenDay);
                break;
        
            default:
                break;
        }
    });
   
    $('#topDay').click(function() {
        for (let key in weekDay) {
            if (weekDay.hasOwnProperty(key)) {
                // Obtener la fecha actual del día correspondiente
                let currentDate = moment(weekDay[key], 'MMM-DD');
                // Sumar un día
                currentDate.add(1, 'days');
                // Actualizar el valor en el objeto weekDay
                weekDay[key] = currentDate.format('MMM-DD');
            }
        }
        
        buttonLabel = now.add(1, 'days').format('MMM DD, YYYY')
        $('#buttonLabel').text(buttonLabel)

        $('.contentDay').each(function(index) {
            // Asigna el valor correspondiente del array si existe
            switch (index) {
                case 0:
                    $(this).text(weekDay.oneDay);
                    break;
                case 1:
                    $(this).text(weekDay.secondDay);
                    break;
                case 2:
                    $(this).text(weekDay.threeDay);
                    break;
                case 3:
                    $(this).text(weekDay.fourthDay);
                    break;
                case 4:
                    $(this).text(weekDay.fiveDay);
                    break;
                case 5:
                    $(this).text(weekDay.sixDay);
                    break;
                case 6:
                    $(this).text(weekDay.sevenDay);
                    break;
            
                default:
                    break;
            }
        });
       
    });

    $('#downDay').click(function() {
        for (let key in weekDay) {
            if (weekDay.hasOwnProperty(key)) {
                // Obtener la fecha actual del día correspondiente
                let currentDate = moment(weekDay[key], 'MMM-DD');
                // Restar un día
                currentDate.subtract(1, 'days'); // Cambia a subtract para restar un día
                // Actualizar el valor en el objeto weekDay
                weekDay[key] = currentDate.format('MMM-DD');
            }
        }

        
        buttonLabel = now.subtract(1, 'days').format('MMM DD, YYYY')
        $('#buttonLabel').text(buttonLabel)
        
        $('.contentDay').each(function(index) {
            // Asigna el valor correspondiente del array si existe
            switch (index) {
                case 0:
                    $(this).text(weekDay.oneDay);
                    break;
                case 1:
                    $(this).text(weekDay.secondDay);
                    break;
                case 2:
                    $(this).text(weekDay.threeDay);
                    break;
                case 3:
                    $(this).text(weekDay.fourthDay);
                    break;
                case 4:
                    $(this).text(weekDay.fiveDay);
                    break;
                case 5:
                    $(this).text(weekDay.sixDay);
                    break;
                case 6:
                    $(this).text(weekDay.sevenDay);
                    break;
            
                default:
                    break;
            }
        });
       
    });
});
