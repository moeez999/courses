document.addEventListener('DOMContentLoaded', function() {
    // Obtener el contenedor con la clase 'rui-course-card-deck'
    document.getElementById('contenido'); // Suponemos que hay solo uno, si no, puedes usar un bucle
    document.getElementById('titlepreview'); // Suponemos que hay solo uno, si no, puedes usar un bucle
    // document.getElementsByClassName("course_category_tree")
    // document.querySelector(".course_category_tree").style.display = "none"; // Suponemos que hay solo uno, si no, puedes usar un bucle
    document.getElementById("page-header").style.display = "none"; // Suponemos que hay solo uno, si no, puedes usar un bucle
    // document.getElementById("action_bar").style.display = "none"; // Suponemos que hay solo uno, si no, puedes usar un bucle
    // document.querySelector(".tertiary-navigation").classList.remove("d-inline-flex"); // Suponemos que hay solo uno, si no, puedes usar un bucle
    // document.querySelector(".tertiary-navigation").style.display = "none"; // Suponemos que hay solo uno, si no, puedes usar un bucle
    document.querySelector(".rui-breadcrumbs").style.display = "none"; // Suponemos que hay solo uno, si no, puedes usar un bucle
     

    // Make sure the function is available globally
    // window.joinClass = joinClass;
    
    // if(coursecat[0] != undefined){
    //     coursecat[0].innerHTML = ""
    // }
    let lastActiveCourse 
    // cursosArray.forEach((element,index) => {
    //     if(element.inscrito == true){
            
    //         lastActiveCourse = element.fullname
    //         console.log(lastActiveCourse)
    //     }
    // });
 
    
    function verify(obj, name){
        let bol = false;  // Inicializamos bol como false para el caso en que no se encuentre el nombre
        
        // Usamos un bucle clásico para poder usar 'return' correctamente
        for (let i = 0; i < obj.length; i++) {
            if (obj[i].fullname === name) {
                // Verificamos si está inscrito
                if (obj[i].inscrito === true) {
                    bol = true;  // Si está inscrito, devolvemos true
                    return bol;  // Sale de la función inmediatamente
                } else {
                    bol = false;  // Si no está inscrito, también devolvemos true
                    return bol;  // Sale de la función inmediatamente
                }
            }
        }
        
        return bol;  // Si no encuentra el 'name', devuelve false
    }

    function getLink(obj, name) {
        let link;
        // Recorremos todos los cursos
        for (let i = 0; i < obj.length; i++) {
            if (obj[i].fullname === name) {
               link = obj[i].id
            }
        }
        return link;
    }
    
    
    let datos = [];

    // Iterar sobre todos los hijos (divs con clase 'position-relative')
    
    let contentswitc = ''
    // switch (lastActiveCourse) {
    //     case "Level 2":
    //     case "Level 1":
    //         title.innerHTML += `
    //             Levels of Begginer-A1
    //         `;
    //         cursosArray.forEach((element, index) => {
    //             if (element.fullname == "Level 2" || element.fullname == "Level 1") {
    //                 contentswitc += `
    //                     <div class="preview_item" style="--bgcolor:#747c27">  
    //                         ${element.inscrito == false ? "<div class='blocked'><i class='fas fa-lock'></i></div>" : ""}
    //                         <div class="headCard">
    //                             <h2 style="color:white">${element.fullname}</h2>
    //                             <p>${element.summary}</p>
    //                         </div>
    //                         <a style="width:100%;text-align:center" href="${urlC}=${element.id}">
    //                             <button class="buttonhref">View ${element.fullname}</button>
    //                         </a>
    //                     </div>
    //                 `;
    //             }
    //         });
    //         preview.innerHTML += contentswitc;
    //         break;

    //     case "Level 4":
    //     case "Level 3":
    //         title.innerHTML += `
    //                 Levels of Elementary-A2
    //         `;
    //         cursosArray.forEach((element, index) => {
    //             if (element.fullname == "Level 4" || element.fullname == "Level 3") {
    //                 contentswitc += `
    //                     <div class="preview_item" style="--bgcolor:#747c27">  
    //                         ${element.inscrito == false ? "<div class='blocked'><i class='fas fa-lock'></i></div>" : ""}
    //                         <div class="headCard">
    //                             <h2 style="color:white">${element.fullname}</h2>
    //                             <p>${element.summary}</p>
    //                         </div>
    //                         <a style="width:100%;text-align:center" href="${urlC}=${element.id}">
    //                             <button class="buttonhref">View ${element.fullname}</button>
    //                         </a>
    //                     </div>
    //                 `;
    //             }
    //         });
    //         preview.innerHTML += contentswitc;
    //         break;

    //     case "Level 6":
    //     case "Level 5":
    //         title.innerHTML += `
    //                 Levels of Intermediate-B1
    //         `;
    //         cursosArray.forEach((element, index) => {
    //             if (element.fullname == "Level 5" || element.fullname == "Level 6") {
    //                 contentswitc += `
    //                     <div class="preview_item" style="--bgcolor:#7d315f">  
    //                         ${element.inscrito == false ? "<div class='blocked'><i class='fas fa-lock'></i></div>" : ""}
    //                         <div class="headCard">
    //                             <h2 style="color:white">${element.fullname}</h2>
    //                             <p>${element.summary}</p>
    //                         </div>
    //                         <a style="width:100%;text-align:center" href="${urlC}=${element.id}">
    //                             <button class="buttonhref">View ${element.fullname}</button>
    //                         </a>
    //                     </div>
    //                 `;
    //             }
    //         });
    //         preview.innerHTML += contentswitc;
    //         break;
            
    //     case "Level 7":
    //     case "Level 8":
    //         title.innerHTML += `
    //                 Levels of Upper Int-B2
    //         `;
    //         cursosArray.forEach((element, index) => {
    //             if (element.fullname == "Level 8" || element.fullname == "Level 7") {
    //                 contentswitc += `
    //                     <div class="preview_item" style="--bgcolor:#7d315f">  
    //                         ${element.inscrito == false ? "<div class='blocked'><i class='fas fa-lock'></i></div>" : ""}
    //                         <div class="headCard">
    //                             <h2 style="color:white">${element.fullname}</h2>
    //                             <p>${element.summary}</p>
    //                         </div>
    //                         <a style="width:100%;text-align:center" href="${urlC}=${element.id}">
    //                             <button class="buttonhref">View ${element.fullname}</button>
    //                         </a>
    //                     </div>
    //                 `;
    //             }
    //         });
    //         preview.innerHTML += contentswitc;
    //         break;
        
    //     case "Level 9":
    //     case "Level 10":
    //         title.innerHTML += `
    //                 Levels of Advanced-C1
    //         `;
    //         cursosArray.forEach((element, index) => {
    //             if (element.fullname == "Level 10" || element.fullname == "Level 9") {
    //                 contentswitc += `
    //                     <div class="preview_item" style="--bgcolor:#015e89">  
    //                         ${element.inscrito == false ? "<div class='blocked'><i class='fas fa-lock'></i></div>" : ""}
    //                         <div class="headCard">
    //                             <h2 style="color:white">${element.fullname}</h2>
    //                             <p>${element.summary}</p>
    //                         </div>
    //                         <a style="width:100%;text-align:center" href="${urlC}=${element.id}">
    //                             <button class="buttonhref">View ${element.fullname}</button>
    //                         </a>
    //                     </div>
    //                 `;
    //             }
    //         });
    //         preview.innerHTML += contentswitc;
    //         break;

    //     default:
    //         console.log("nada");
    //         break;
    // }

    // let cards = document.getElementsByClassName("itemClick")
    // for (let i = 0; i < cards.length; i++) {
    //     const element = cards[i];

    //     element.addEventListener("click",()=>{

    //         preview.innerHTML = ""
    //         title.innerHTML = ""
    //         let content = ""
    //         switch (i) {
    //             case 0:
    //                 title.innerHTML += `
                    
    //                             Levels of Begginer-A1
                            
    //                 `
    //                 cursosArray.forEach((element,index) => {
    //                     if(element.fullname == "Level 2" || element.fullname == "Level 1"){
                            
    //                         content += `
    //                             <div class="preview_item" style="--bgcolor:#747c27">  
    //                                 ${element.inscrito == false ? "<div class='blocked'><i class='fas fa-lock'></i></div>" : ""}

    //                             <div class="headCard">
    //                                     <h2 style="color:white">${element.fullname}</h2>
    //                                     <p>${element.summary}</p>
    //                                 </div>
    //                             <a style="width:100%;text-align:center" href="${urlC}=${element.id}">
    //                                 <button class="buttonhref">View ${element.fullname}</button>
    //                             </a>
    //                         </div>
    //                         `
    //                     }
    //                 });
    //                 preview.innerHTML += content


    //                 break;
                    
    //             case 1:
    //                 title.innerHTML += `
                    
    //                             Levels of Elementary-A2
                            
    //                 `
    //                 cursosArray.forEach((element,index) => {
    //                     if( element.fullname == "Level 4" || element.fullname == "Level 3"){
                            
    //                         content += `
    //                         <div class="preview_item" style="--bgcolor:#747c27">  
    //                                 ${element.inscrito == false ? "<div class='blocked'><i class='fas fa-lock'></i></div>" : ""}

    //                             <div class="headCard">
    //                                     <h2 style="color:white">${element.fullname}</h2>
    //                                     <p>${element.summary}</p>
    //                                 </div>
    //                             <a style="width:100%;text-align:center" href="${urlC}=${element.id}">
    //                                 <button class="buttonhref">View ${element.fullname}</button>
    //                             </a>
    //                         </div>
    //                         `
    //                     }
    //                 });
    //                 preview.innerHTML += content


    //                 break;
                    
                    
    //             case 2:
    //                 title.innerHTML += `
                    
    //                             Levels of Intermediate-B1
                            
    //                 `
    //                 cursosArray.forEach((element,index) => {
    //                     if(element.fullname == "Level 5" || element.fullname == "Level 6"){
                            
    //                         content += `
    //                         <div class="preview_item"  style="--bgcolor:#7d315f">  
    //                                 ${element.inscrito == false ? "<div class='blocked'><i class='fas fa-lock'></i></div>" : ""}

    //                             <div class="headCard">
    //                                     <h2 style="color:white">${element.fullname}</h2>
    //                                     <p>${element.summary}</p>
    //                                 </div>
    //                             <a style="width:100%;text-align:center" href="${urlC}=${element.id}">
    //                                 <button class="buttonhref">View ${element.fullname}</button>
    //                             </a>
    //                         </div>
    //                         `
    //                     }
    //                 });
    //                 preview.innerHTML += content


    //                 break;
            
    //                 case 3:
    //                     title.innerHTML += `
                        
    //                                 Levels of Upper Int-B2
                                
    //                     `
    //                     cursosArray.forEach((element,index) => {
    //                     if(element.fullname == "Level 8" || element.fullname == "Level 7"){
                            
    //                         content += `
    //                         <div class="preview_item" style="--bgcolor:#7d315f">  
    //                                 ${element.inscrito == false ? "<div class='blocked'><i class='fas fa-lock'></i></div>" : ""}

    //                             <div class="headCard">
    //                                     <h2 style="color:white">${element.fullname}</h2>
    //                                     <p>${element.summary}</p>
    //                                 </div>
    //                             <a style="width:100%;text-align:center" href="${urlC}=${element.id}">
    //                                 <button class="buttonhref">View ${element.fullname}</button>
    //                             </a>
    //                         </div>
    //                         `
    //                     }
    //                 });
    //                     preview.innerHTML += content
    
    
    //                     break;
                        
    //                 case 4:
    //                     title.innerHTML += `
                        
    //                                 Levels of Advanced-C1
                                
    //                     `
                       
    //                     cursosArray.forEach((element,index) => {
    //                         if(element.fullname == "Level 10"|| element.fullname == "Level 9"){
                                
    //                             content += `
    //                             <div class="preview_item" style="--bgcolor:#015e89">  
    //                                 ${element.inscrito == false ? "<div class='blocked'><i class='fas fa-lock'></i></div>" : ""}

    //                                 <div class="headCard">
    //                                     <h2 style="color:white">${element.fullname}</h2>
    //                                     <p>${element.summary}</p>
    //                                 </div>
    //                                 <a style="width:100%;text-align:center" href="${urlC}=${element.id}">
    //                                     <button class="buttonhref">View ${element.fullname}</button>
    //                                 </a>
    //                             </div>
    //                             `
    //                         }
    //                     });
    //                     preview.innerHTML += content
    
    
    //                     break;
                
    //             default:
    //                 break;
    //         }
    //     })
    // }

    
    // let cardsslide = document.getElementsByClassName("swiper-slide")
   
});
