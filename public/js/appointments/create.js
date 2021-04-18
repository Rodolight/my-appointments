let $specialty, $doctor, $date, $moHours, $afHours, $btnSave;
let iRadio;

const noHoursAlert = `<div class="alert alert-danger" role="alert">
                        <strong>Lo sentimos!</strong> No se encontraron horas disponibles para el médico en la fecha seleccionada.
                      </div>`
// FUNCION PRINCIPAL
$(function () {
  $specialty = $('#specialty');
  $doctor =  $('#doctor');
  $date = $('#date');
  $moHours = $('#mohours');
  $afHours = $('#afhours');
  $hours = $('#hours');
  
   $specialty.change( () =>{
     const specialtyId =  $specialty.val();
     const url = `/api/specialties/${specialtyId}/doctors`;
     // retornar el JSON
     if(specialtyId != ''){
       $.getJSON(url, onDoctorsLoaded);
     }

   });

   $date.change(loadHours);
   $doctor.change(loadHours);
 });

 // FUNCIONES ALTERNAS

   function onDoctorsLoaded(doctors){
    let htmlOptions = "";
    doctors.forEach(doctor =>{
       htmlOptions += `<option value ="${doctor.id}">${doctor.name}</option>`;
    });
    $doctor.html(htmlOptions);
    loadHours();
   
   }

   function loadHours(){
    if($doctor.val() != null ){
       const selectedDate = $date.val();
       const doctorId = $doctor.val();
       const url = `/api/schedule/hours?date=${selectedDate}&doctor_id=${doctorId}`;
      
       $.getJSON(url,displayHours); 

    }
   }

   function displayHours(data){

    
    $moHours.html('');
    $afHours.html('');

    if(!data.morning && !data.afternoon || data.morning.length===0 && data.afternoon.length===0){
        $hours.html(noHoursAlert);
        return;
    }

    let htmlHours1 = '';
    let htmlHours2 = '';
     iRadio = 0;

    if(data.morning){
        const morning_intervals = data.morning;
      
        morning_intervals.forEach( interval =>{
            htmlHours1 += getRadioIntervalHtml(interval);
        });
    }

    if(data.afternoon){
        const afternoon_intervals = data.afternoon;

        afternoon_intervals.forEach( interval =>{
            htmlHours2 += getRadioIntervalHtml(interval);
        });
    }
    
     $moHours.html(htmlHours1);
     $afHours.html(htmlHours2);
     $hours.html('');
   }

   function getRadioIntervalHtml(interval){
     const text = `${interval.start} - ${interval.end}`;  
      
     return `
             <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="interval${iRadio}" name="schedule_time" class="custom-control-input" value="${interval.start}" required>
              <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
             </div> 
            `
   }