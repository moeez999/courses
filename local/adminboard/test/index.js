document.addEventListener("DOMContentLoaded", function() {
  debugger
  let cohortShortName = "FL1"
  let today = "Nomvember 15"
  let initRange = 19
  let alertPopu = true //visibility popup
  let globalValue = 0
  let contentPines =""


  debugger


  let dataTest = [20,50,84]
  dataTest.sort((a, b) => a - b);
  let count = 1
  dataTest.forEach(element => {
    contentPines+=` 
      <div class="containerPing" style="left:${(element < 4 ? element : element-4 )}%">
        <div class="ping-circle">
          ${count}
        </div>
        <div class="ping-item">
          <span style="position: absolute;width: max-content;font-size: 0.7em;">${element}%</span>
        </div>
    
      </div>
    `
    count++
  });
  console.log(dataTest[dataTest.length - 1])
  // loading optimized content nav
  document.querySelector(".nav-mobile").innerHTML  =`
    
  <a href="${urlHome}" class="item ${urlHome === currentUrl ? 'item--active' : ''}">
        <svg width="25" height="25" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0_741_2245)">
        <path d="M23.3529 10.4388L23.3513 10.4372L13.5612 0.647484C13.1439 0.229922 12.589 0 11.9989 0C11.4088 0 10.854 0.229781 10.4365 0.647297L0.651482 10.432C0.648201 10.4353 0.64492 10.4388 0.641639 10.4421C-0.21533 11.304 -0.21383 12.7023 0.645857 13.562C1.03858 13.955 1.55734 14.1825 2.11197 14.2064C2.13447 14.2086 2.1572 14.2096 2.18008 14.2096H2.57026V21.4143C2.57026 22.84 3.73023 24 5.15626 24H8.98642C9.37464 24 9.68954 23.6852 9.68954 23.2969V17.6484C9.68954 16.9979 10.2188 16.4687 10.8693 16.4687H13.1285C13.7791 16.4687 14.3082 16.9979 14.3082 17.6484V23.2969C14.3082 23.6852 14.623 24 15.0114 24H18.8416C20.2676 24 21.4276 22.84 21.4276 21.4144V14.2097H21.7894C22.3794 14.2097 22.9342 13.9799 23.3518 13.5624C24.2125 12.7013 24.2128 11.3005 23.3529 10.4388Z"/>
        </g>
        <defs>
        <clipPath id="clip0_741_2245">
        <rect width="24" height="24" fill="white"/>
        </clipPath>
        </defs>
        </svg>

        <span>Home</span>
    </a>


    <a href="${urlRecording}" class="item ${urlRecording === currentUrl ? 'item--active' : ''}">
        
        <svg width="25" height="25" viewBox="0 0 25 24" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_741_2249)">
            <path d="M23.2418 1.36011H2.25538C1.42028 1.36011 0.766724 2.01366 0.766724 2.81245V16.4282C0.766724 17.227 1.42028 17.9168 2.25538 17.9168H23.2781C24.0769 17.9168 24.7667 17.2633 24.7667 16.4282V2.81245C24.7304 2.01366 24.0769 1.36011 23.2418 1.36011ZM12.7486 15.6294C9.44448 15.6294 6.72134 12.9426 6.72134 9.60217C6.72134 6.29808 9.40818 3.57493 12.7486 3.57493C16.0527 3.57493 18.7758 6.26177 18.7758 9.60217C18.7758 12.9426 16.0527 15.6294 12.7486 15.6294Z" />
            <path d="M15.4717 9.6386C15.4717 10.0017 15.2902 10.3285 14.9634 10.5463L11.9498 12.3617C11.7682 12.4707 11.5867 12.507 11.4052 12.507C11.2236 12.507 11.0421 12.4707 10.8968 12.3617C10.5701 12.1802 10.3522 11.8171 10.3522 11.454V7.82317C10.3522 7.46008 10.5337 7.097 10.8968 6.91545C11.2236 6.73391 11.623 6.73391 11.9498 6.91545L14.9634 8.73089C15.2902 8.91243 15.4717 9.23921 15.4717 9.6386ZM24.7304 21.2574C24.7304 21.4389 24.5852 21.6204 24.3673 21.6204H6.9755C6.75765 22.2377 6.1041 22.6734 5.269 22.6734C4.47021 22.6734 3.78034 22.2377 3.56249 21.6204H1.45659C1.23874 21.6204 1.09351 21.4389 1.09351 21.2574C1.09351 21.0395 1.23874 20.8943 1.45659 20.8943H3.56249C3.74404 20.277 4.4339 19.8413 5.269 19.8413C6.1041 19.8413 6.75765 20.277 6.9755 20.8943H24.3673C24.5852 20.8943 24.7304 21.0395 24.7304 21.2574Z" />
            </g>
            <defs>
            <clipPath id="clip0_741_2249">
            <rect width="24" height="24" fill="white" transform="translate(0.75)"/>
            </clipPath>
            </defs>
        </svg>

        <span>Speak</span>
    </a>

    
    <a href="" class="item">
        <svg width="25" height="25" viewBox="0 0 25 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M22.1526 19.9782L18.3081 16.1338C19.4805 14.6054 20.1148 12.7324 20.1124 10.8062C20.1124 8.45308 19.196 6.24158 17.5322 4.57777C16.7162 3.75722 15.7456 3.10667 14.6765 2.66378C13.6073 2.22089 12.461 1.99446 11.3038 1.99759C8.95119 1.99759 6.73969 2.91396 5.07529 4.57777C1.64157 8.01208 1.64157 13.6004 5.07529 17.0347C5.89127 17.8553 6.86193 18.5059 7.93105 18.9488C9.00018 19.3916 10.1465 19.6181 11.3038 19.6149C13.2562 19.6149 15.1062 18.9753 16.6319 17.81L20.4764 21.6551C20.7075 21.8863 21.011 22.0024 21.3145 22.0024C21.618 22.0024 21.9214 21.8863 22.1526 21.6551C22.2627 21.545 22.3501 21.4143 22.4097 21.2704C22.4693 21.1266 22.5 20.9724 22.5 20.8167C22.5 20.6609 22.4693 20.5068 22.4097 20.3629C22.3501 20.219 22.2627 20.0883 22.1526 19.9782ZM6.75214 15.3585C4.2419 12.8482 4.2425 8.76427 6.75214 6.25403C7.34865 5.65453 8.05812 5.17926 8.83949 4.85572C9.62087 4.53218 10.4586 4.36679 11.3044 4.36913C12.15 4.36681 12.9877 4.5322 13.7689 4.85574C14.5502 5.17928 15.2596 5.65454 15.856 6.25403C16.4556 6.85045 16.9311 7.55989 17.2547 8.34127C17.5783 9.12266 17.7438 9.96048 17.7415 10.8062C17.7415 12.5258 17.0717 14.1422 15.856 15.3585C14.6403 16.5748 13.0239 17.2434 11.3038 17.2434C9.58483 17.2434 7.96784 16.5736 6.75155 15.3585H6.75214Z" />
        </svg>

        <span>Search</span>
    </a>

    
    <a href="" class="item">
        <svg width="25" height="25" viewBox="0 0 25 24" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_741_2263)">
            <path d="M12.25 0.600098C5.6332 0.600098 0.25 5.4449 0.25 11.4001C0.25 13.4817 0.9084 15.4981 2.1572 17.2417C1.9208 19.8565 1.2872 21.7977 0.3672 22.7173C0.307966 22.7766 0.268864 22.853 0.255416 22.9358C0.241968 23.0185 0.254854 23.1034 0.292254 23.1784C0.329653 23.2534 0.389677 23.3148 0.463846 23.3539C0.538015 23.3929 0.622581 23.4077 0.7056 23.3961C0.8676 23.3733 4.6308 22.8317 7.3528 21.2605C8.8984 21.8841 10.5448 22.2001 12.25 22.2001C18.8668 22.2001 24.25 17.3553 24.25 11.4001C24.25 5.4449 18.8668 0.600098 12.25 0.600098ZM6.65 13.0001C5.7676 13.0001 5.05 12.2825 5.05 11.4001C5.05 10.5177 5.7676 9.8001 6.65 9.8001C7.5324 9.8001 8.25 10.5177 8.25 11.4001C8.25 12.2825 7.5324 13.0001 6.65 13.0001ZM12.25 13.0001C11.3676 13.0001 10.65 12.2825 10.65 11.4001C10.65 10.5177 11.3676 9.8001 12.25 9.8001C13.1324 9.8001 13.85 10.5177 13.85 11.4001C13.85 12.2825 13.1324 13.0001 12.25 13.0001ZM17.85 13.0001C16.9676 13.0001 16.25 12.2825 16.25 11.4001C16.25 10.5177 16.9676 9.8001 17.85 9.8001C18.7324 9.8001 19.45 10.5177 19.45 11.4001C19.45 12.2825 18.7324 13.0001 17.85 13.0001Z" />
            </g>
            <defs>
            <clipPath id="clip0_741_2263">
            <rect width="24" height="24" fill="white" transform="translate(0.25)"/>
            </clipPath>
            </defs>
        </svg>

        <span>Message</span>
    </a>
    
    <a href="" class="item">
        <svg width="25" height="25" viewBox="0 0 25 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M21.4183 0.785156H19.1753V3.02815C19.1753 3.47675 18.8015 3.77581 18.4277 3.77581C18.0538 3.77581 17.68 3.47675 17.68 3.02815V0.785156H5.7174V3.02815C5.7174 3.47675 5.34357 3.77581 4.96974 3.77581C4.5959 3.77581 4.22207 3.47675 4.22207 3.02815V0.785156H1.97908C0.857586 0.785156 0.0351562 1.75712 0.0351562 3.02815V5.71974H23.9604V3.02815C23.9604 1.75712 22.6146 0.785156 21.4183 0.785156ZM0.0351562 7.28983V20.9721C0.0351562 22.3179 0.857586 23.2151 2.05385 23.2151H21.4931C22.6894 23.2151 24.0352 22.2431 24.0352 20.9721V7.28983H0.0351562ZM6.68936 19.8506H4.89497C4.5959 19.8506 4.29684 19.6263 4.29684 19.2524V17.3833C4.29684 17.0842 4.52114 16.7852 4.89497 16.7852H6.76413C7.06319 16.7852 7.36226 17.0095 7.36226 17.3833V19.2524C7.28749 19.6263 7.06319 19.8506 6.68936 19.8506ZM6.68936 13.1216H4.89497C4.5959 13.1216 4.29684 12.8973 4.29684 12.5235V10.6543C4.29684 10.3553 4.52114 10.0562 4.89497 10.0562H6.76413C7.06319 10.0562 7.36226 10.2805 7.36226 10.6543V12.5235C7.28749 12.8973 7.06319 13.1216 6.68936 13.1216ZM12.6707 19.8506H10.8015C10.5024 19.8506 10.2034 19.6263 10.2034 19.2524V17.3833C10.2034 17.0842 10.4277 16.7852 10.8015 16.7852H12.6707C12.9697 16.7852 13.2688 17.0095 13.2688 17.3833V19.2524C13.2688 19.6263 13.0445 19.8506 12.6707 19.8506ZM12.6707 13.1216H10.8015C10.5024 13.1216 10.2034 12.8973 10.2034 12.5235V10.6543C10.2034 10.3553 10.4277 10.0562 10.8015 10.0562H12.6707C12.9697 10.0562 13.2688 10.2805 13.2688 10.6543V12.5235C13.2688 12.8973 13.0445 13.1216 12.6707 13.1216ZM18.652 19.8506H16.7828C16.4838 19.8506 16.1847 19.6263 16.1847 19.2524V17.3833C16.1847 17.0842 16.409 16.7852 16.7828 16.7852H18.652C18.951 16.7852 19.2501 17.0095 19.2501 17.3833V19.2524C19.2501 19.6263 19.0258 19.8506 18.652 19.8506ZM18.652 13.1216H16.7828C16.4838 13.1216 16.1847 12.8973 16.1847 12.5235V10.6543C16.1847 10.3553 16.409 10.0562 16.7828 10.0562H18.652C18.951 10.0562 19.2501 10.2805 19.2501 10.6543V12.5235C19.2501 12.8973 19.0258 13.1216 18.652 13.1216Z" />
        </svg>

        <span>Schedule</span>
    </a>  
  `
console.log(dataTest[dataTest.length - 1])
function swalConfirmed(){
  Swal.fire({
    allowOutsideClick: false, // Desactiva el cierre al hacer clic fuera
    html: `
    <div style="width: 100%;">

      <select style="width: 80%; margin: auto; font-size: 0.9em; padding: 10px; margin-bottom: 30px; margin-top: 30px" class="inputSwal swal2-select">
        <option value="" default>ALphabet</option>
        <option value="">Test</option>
        <option value="">Test</option>
      </select>

      <div class="inputSwal swalModify">Target Session: <b>3</b></div>

      <p style="width: 80%; margin: auto 30px; text-align: left; font-size: 0.9em; font-weight: lighter;">
        <b>What was completion percentage of this topic</b>
      </p>

      <div class="range" style="position: relative">
        <div class="field">
          <div class="value left">0</div>
          <input type="range" min="0" max="100" value="${dataTest[dataTest.length - 1]}" steps="1" id="inputRange">
          <div id="sliderValueSpan" class="value right">100%</div>

          ${contentPines}
        </div>
      </div>

    </div>
  `,
  confirmButtonText: "Submit",

  customClass: {
    title:'titleCancel',
    popup: 'container-swal',
    confirmButton:"btn-swal btn-submit", 
  },
  didOpen: () => {
    // Seleccionar los elementos por id
    const slideValue = document.querySelector("#sliderValueSpan");
    const inputSlider = document.querySelector("#inputRange");

    let prevValue = inputSlider.value;  // Valor inicial del slider
    globalValue = prevValue

    slideValue.textContent = prevValue + "%";  // Cambiar el texto del span 
    
    // Actualizar el valor al mover el slider
    inputSlider.oninput = () => {
      let value = inputSlider.value;
      globalValue = value
      if(value != 100){

      // Si el nuevo valor es menor que el valor anterior, restaurar el valor anterior
      if (value < prevValue) {
        inputSlider.value = prevValue;
        value = prevValue; // No cambia el valor
      }
      
      }
      slideValue.textContent = value + "%";  // Cambiar el texto del span 
    };

    // Cuando el slider pierde el enfoque, ocultamos el valor
    inputSlider.onblur = () => {
      slideValue.classList.remove("show");  // Ocultar el valor
    };
  }
}).then((result) => {
  // Confirmed action
  if (result.isConfirmed) {
    if(globalValue == 100){
      swalSucces()
    }else{
      swalProgress()
      
    }
  } 
});
}


  function swalSucces(){
    Swal.fire({
      allowOutsideClick: false, // Desactiva el cierre al hacer clic fuera
      title: "Congratulations",
      width: 600,
      text: "You've succesfully completed 100% of the session. Great job guiding your students!",
      padding: "3em",
      imageUrl: `${urlMoodle}images/success.svg`,
      confirmButtonText: "Okay, thanks",
      background: "#fff url(/images/trees.png)",
      backdrop: `
        rgba(55, 55, 55, 0.4)
        url("https://i.gifer.com/6SSp.gif")
      `,
      customClass: {
        confirmButton:"btn-swal btn-submit",
      },
      didOpen: () => {
        // Aquí aplicamos las clases de los sliders si es necesario
        const rangeInput = document.querySelector('.swal2-popup input[type="range"]');
        if (rangeInput) {
          rangeInput.classList.add('custom-range-input'); // Asegúrate de que esta clase esté aplicada correctamente
        }
      }
  });
  }
  function swalProgress(){
    Swal.fire({
      allowOutsideClick: false, // Desactiva el cierre al hacer clic fuera
      width: 600,
      confirmButtonText: "Okay",
      html: `
        <div class="container-circle">
          <div class='porcentajes' style="--porcentaje: ${globalValue}; --color: forestgreen;scale: 80%;">
            <svg width="150" height="150">
              <circle r="65" cx="50%" cy="50%" pathlength="100" />
              <circle r="65" cx="50%" cy="50%" pathlength="100" />
            </svg>
            <span>${globalValue}%</span>
          </div> 
        </div>
        <h1 class="parrafo" >
            Great! you have updated the progres
        </h1>
      </div>
      <div class="parrafo">You’ve successfully updated the session progress to <b>${globalValue}%</b>. Keep up the great work!</div>`,

      customClass: {
        title:"title-left",
        text:"title-left",
        popup: 'container-swal',
        html:"title-left",
        confirmButton:"btn-swal btn-submit",
      },
  });
  }

  function swalCancel() {
    Swal.fire({
      allowOutsideClick: false, // Desactiva el cierre al hacer clic fuera
      imageUrl: `${urlMoodle}images/question.svg`,
      title:`It seems you haven't joined this session. Please select a reason for your absence`,
      html: `
        <div style="width: 100%;">
        
          <select style="/*! width: 0%; */width: 80%;margin: auto;font-size: 0.9em;padding:10px; margin-bottom:30px; margin-top:30px" name="" id="" class="inputSwal swal2-select">
              <option value="" default>Select a Reason</option>
              <option value="">Lorem, ipsum dolor.</option>
              <option value="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores, quas!</option>
          </select>
          <textarea style="/*! width: 0%; */width: 80%;margin: auto;" id="swal-textarea" class="inputSwal swal2-textarea" placeholder="Write your comments here..."></textarea>
        </div>
      `,
      focusConfirm: false,
      confirmButtonText: "Submit",
      customClass: {
        title:'titleCancel',
        popup: 'container-swal',
        confirmButton:"btn-swal btn-submit",
        
      },
      preConfirm: () => {
        return [
          // document.getElementById("swal-input1").value,
          // document.getElementById("swal-input2").value
        ];
      }
      
    });
  }
  if(alertPopu){

    Swal.fire({
      showCancelButton: true,
      width:600,
      html: `
            <div class="swalHead">
              <h1>
                Did you teach your session with ${cohortShortName} on ${today}?
              </h1>
            </div>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Impaut harum! Culpa deserunt recusandae nobis, facilis odio beatae? Culpa, harum.</p>
            
          `,
      confirmButtonColor: "#ff2500",
      cancelButtonColor: "#d33",
      allowOutsideClick: false, // Desactiva el cierre al hacer clic fuera
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      customClass: {
        title: "title-swal",
        cancelButton:"cancel-swal  btn-swal",
        popup: 'container-swal',
        confirmButton:"confirm-swal btn-swal",
        
      },
      buttonsStyling: false 
    }).then((result) => {
  
      
      // Confirmed action
      if (result.isConfirmed) {
        swalConfirmed()
      }else if (result.isDismissed) { // Use isDismissed to handle cancel
        swalCancel()
      }
    });
   
  }
});