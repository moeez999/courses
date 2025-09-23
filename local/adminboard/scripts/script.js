const basicDetailsElement = document.querySelector(".basicDetails");
const body = document.body;

async function fetchAllData() {
    debugger
  try {
      debugger
    // Fetch both courses and teacher details in parallel
    const [coursesResponse, teachersResponse] = await Promise.all([
      fetch('./courses.php'),
      fetch('./teachersDetails.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
      })
    ]);

    // Process the responses once both fetches are complete
    const coursesData = await coursesResponse.json();
    const teachersData = await teachersResponse.json();

    // Now you can process both data together
    const totalLevels = coursesData.totalLevels;
    const teachers = teachersData.teachers;

    // **************************************** */ 
    // Dynamically create constants for each level
    for (let i = 1; i <= totalLevels; i++) {
      const constantName = `level${i}StatusElement`;
      const element = document.querySelector(`.level${i}Status`);

      if (element) {
        // Dynamically create a constant for each level and assign the element
        window[constantName] = element; // Assign to global scope for access (e.g., level1StatusElement)
      }
    }


    // **************************************** */

    teachers.forEach((ele) => {
      const { image, name, backgroundColor } = ele.teacher;

      const basicDetails = `
  <div class="col01" >
    <div class="teacher" style="--t-bg-color: ${backgroundColor}">
      <div class="profile">
        <img src=${image} alt="" />
      </div>
      <h1>${name}</h1>
    </div>

    <div class="basic-info">
      ${ele.basicDetail.map((e, key) => {
        const { activos, attendence, groups, retention, dayAndTime } = e;
        return (
          `<div class="col01" data-id=${key}>
      <div class="group">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10 0C4.48622 0 0 4.48622 0 10C0 15.5138 4.48622 20 10 20C15.5138 20 20 15.5138 20 10C20 4.48622 15.5138 0 10 0ZM15.589 7.36842L9.19799 13.7093C8.82205 14.0852 8.22055 14.1103 7.81955 13.7343L4.43609 10.6516C4.03509 10.2757 4.01002 9.64912 4.3609 9.24812C4.73684 8.84712 5.36341 8.82205 5.76441 9.19799L8.44611 11.6541L14.1604 5.93985C14.5614 5.53885 15.188 5.53885 15.589 5.93985C15.99 6.34085 15.99 6.96742 15.589 7.36842Z" fill="white"/>
</svg>
      </div>
      <div class="days-and-time">
        <p>${dayAndTime?.red?.time.slice(0, -2)} <span>${dayAndTime?.red?.time.slice(-2)}</span></p>
        ${dayAndTime?.red?.days?.map(e => `<div class="redBox">${e}</div>`).join("")}
        <p>${dayAndTime?.blue?.time.slice(0, -2)} <span>${dayAndTime?.red?.time.slice(-2)}</span></p>
        ${dayAndTime?.blue?.days?.map(e => `<div class="blueBox">${e}</div>`).join("")}
      </div>
      <div class="attendence">
        <h1>${attendence}</h1>
      </div>
      <div class="activos" style="--activos-border-color: ${activos > 8 ? "#04AA29" : activos > 5 ? "#F0BD07" : "#F04438"}; --activos-bg-color: ${activos > 8 ? "rgba(4, 170, 41, 0.1)" : activos > 5 ? "rgba(240, 189, 7, 0.1)" : "rgba(240, 68, 56, 0.1)"};">
        <h1>${activos}</h1>
      </div>
      <div class="groups">
        <h1>${groups.toLowerCase() == 'teachers cohort' ? 'TC' : groups}</h1>
      </div>
      <div class="monthlyRetention">
        <h1>${retention}</h1>
      </div>
    </div>`
        )
      }).join("")}</div></div>`;

      function levelRender(element) {
        return `<div class="mainCall">
        ${element?.map((level) => {
          return `<div class="col01">
        ${level.status?.map((status) => {
            if (status === "completed") {
              return `
      <div class="completed">
        <svg
          width="20"
          height="20"
          viewBox="0 0 20 20"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <g clip-path="url(#clip0_43_1199)">
            <path
              d="M10 0C4.48622 0 0 4.48622 0 10C0 15.5138 4.48622 20 10 20C15.5138 20 20 15.5138 20 10C20 4.48622 15.5138 0 10 0ZM15.589 7.36842L9.19799 13.7093C8.82205 14.0852 8.22055 14.1103 7.81955 13.7343L4.43609 10.6516C4.03509 10.2757 4.01002 9.64912 4.3609 9.24812C4.73684 8.84712 5.36341 8.82205 5.76441 9.19799L8.44611 11.6541L14.1604 5.93985C14.5614 5.53885 15.188 5.53885 15.589 5.93985C15.99 6.34085 15.99 6.96742 15.589 7.36842Z"
              fill="white"
            />
          </g>
          <defs>
            <clipPath id="clip0_43_1199">
              <rect width="20" height="20" fill="white" />
            </clipPath>
          </defs>
        </svg>
      </div>`;
            } else if (status === "notStarted") {
              return `
      <div class="notStarted">
        <div class="innerCircle"></div>
      </div>`;
            } else {
              return `
      <div class="inProgress">
        <h1>${status}</h1>
        <div
          class="progressBar"
          style="--data-percentage: ${status}"
        ></div>
      </div>`;
            }
          }).join('')
            } </div > `
        }).join('')}
</div>`
      }

      basicDetailsElement.insertAdjacentHTML("beforeend", basicDetails);
      // Loop through each level and insert the HTML dynamically
      for (let i = 1; i <= totalLevels; i++) { // Loop up to totalLevels
        const levelKey = `level${i.toString().padStart(2, '0')}`; // Format i with two digits (e.g., '01', '02', etc.)
        const levelKeyy = `level${i}`; // Format i with two digits (e.g., '01', '02', etc.)
        const levelStatusElement = window[`${levelKeyy}StatusElement`]; // Access the element dynamically by its name

        if (levelStatusElement) {
          const levelData = ele[levelKey]; // Access the data dynamically for the level
          const renderedHTML = levelRender(levelData); // Render the HTML using your `levelRender` function
          levelStatusElement.insertAdjacentHTML("beforeend", renderedHTML); // Insert the HTML into the element
        }
      }
    })

    // ***************************
    const startLevel = 1; // Starting level number (1 for level1Collapse, mobileLevel1Collapse, etc.)

    const inner_elements = {}
    // Dynamically generating the `highlighted`, `levelXCollapseAndExpand`, `levelXCollapse`, `levelX_closeEye`, `levelX_openEye`, and `mobileLevelXCollapse` elements and adding them to `elements`

    for (let i = startLevel; i <= totalLevels; i++) {
      inner_elements[`level${i}CollapseAndExpand`] = document.querySelector(`.level${i}CollapseAndExpand`);
      inner_elements[`level${i}Status`] = document.querySelector(`.level${i}Status`);
      inner_elements[`mobileLevel01Collapse`] = document.querySelectorAll(`.mobileLevel01Collapse`);
      inner_elements.level01Collapse = document.querySelectorAll(`.level01Collapse`);
      inner_elements.closeEye = document.querySelectorAll(".closeEye");
      inner_elements.openEye = document.querySelectorAll(".openEye");
    }

    function CollapseElements(mainElement, secondElement, thirdElement, closeEye, openEye) {
      mainElement.classList.toggle("collapse");
      secondElement.classList.toggle("collapse");
      thirdElement.classList.toggle("collapse");

      if (mainElement.classList.contains("collapse")) {
        closeEye.classList.add("hide");
        openEye.classList.remove("hide");
      } else {
        closeEye.classList.remove("hide");
        openEye.classList.add("hide");
      }
    }

    for (let i = 1; i <= totalLevels; i++) {
      inner_elements[`level${i}CollapseAndExpand`].addEventListener("click", () => CollapseElements(inner_elements[`level${i}Status`], inner_elements.level01Collapse[i - 1], inner_elements.mobileLevel01Collapse[i - 1], inner_elements.closeEye[i - 1], inner_elements.openEye[i - 1]));
    }

    // for (let i = startLevel; i <= totalLevels; i++) {
    //   // For highlighted elements (levelXStatus)
    //   const highlightedKey = `highlighted${(i + 2).toString().padStart(2, '0')}`; // Dynamic key like highlighted02, highlighted03
    //   const highlightedSelector = `.mainLayout main .bottom-part .details .level${i + 1}Status .mainCall .col01`;
    //   inner_elements[highlightedKey] = document.querySelectorAll(highlightedSelector); // Dynamically add to elements object


    //   // For levelXCollapseAndExpand elements
    //   const collapseExpandKey = `level${i}CollapseAndExpand`; // Dynamic key like level1CollapseAndExpand
    //   const collapseExpandSelector = `.level${i}CollapseAndExpand`;
    //   inner_elements[collapseExpandKey] = document.querySelector(collapseExpandSelector); // Dynamically add to elements object


    //   // For levelXCollapse elements
    //   const collapseKey = `level${(i).toString().padStart(2, '0')}Collapse`; // Dynamic key like level01Collapse, level02Collapse
    //   const collapseSelector = `.level${(i).toString().padStart(2, '0')}Collapse`;
    //   inner_elements[collapseKey] = document.querySelector(collapseSelector); // Dynamically add to elements object


    //   // For levelX_closeEye and levelX_openEye elements
    //   const closeEyeKey = `level${(i).toString().padStart(2, '0')}_closeEye`; // Dynamic key like level01_closeEye
    //   const openEyeKey = `level${(i).toString().padStart(2, '0')}_openEye`; // Dynamic key like level01_openEye

    //   const closeEyeSelector = `.level${(i)}CollapseAndExpand .closeEye`;
    //   const openEyeSelector = `.level${(i)}CollapseAndExpand .openEye`;

    //   inner_elements[closeEyeKey] = document.querySelector(closeEyeSelector); // Dynamically add to elements object
    //   inner_elements[openEyeKey] = document.querySelector(openEyeSelector); // Dynamically add to elements object

    //   // For mobileLevelXCollapse elements
    //   const mobileCollapseKey = `mobileLevel${(i).toString().padStart(2, '0')}Collapse`; // Dynamic key like mobileLevel01Collapse, mobileLevel02Collapse
    //   const mobileCollapseSelector = `.mobileLevel${(i).toString().padStart(2, '0')}Collapse`;
    //   inner_elements[mobileCollapseKey] = document.querySelector(mobileCollapseSelector); // Dynamically add to elements object
    // }

    // // ***********************************
    // console.log("inner_elements", inner_elements);
    // for (let i = 1; i <= totalLevels; i++) {
    //   const formattedLevelWithZero = i < 10 ? `0${i}` : i; // Format as '01', '02', ..., '10'
    //   const formattedLevelWithoutZero = i; // Format as '1', '2', ..., '10'

    //   // Use `elements` object to get references to the relevant elements for each level
    //   const levelStatusElement = inner_elements[`level${formattedLevelWithoutZero}Status`];
    //   const levelCollapseElement = inner_elements[`level${formattedLevelWithZero}Collapse`];
    //   const mobileLevelCollapseElement = inner_elements[`mobileLevel${formattedLevelWithZero}Collapse`];
    //   const levelCloseEyeElement = inner_elements[`level${formattedLevelWithZero}_closeEye`];
    //   const levelOpenEyeElement = inner_elements[`level${formattedLevelWithZero}_openEye`];
    //   const levelCollapseAndExpandElement = inner_elements[`level${formattedLevelWithoutZero}CollapseAndExpand`];

    //   function CollapseElements(mainElement, secondElement, thirdElement, closeEye, openEye) {
    //     mainElement.classList.toggle("collapse");
    //     secondElement.classList.toggle("collapse");
    //     thirdElement.classList.toggle("collapse");

    //     if (mainElement.classList.contains("collapse")) {
    //       closeEye.classList.add("hide");
    //       openEye.classList.remove("hide");
    //     } else {
    //       closeEye.classList.remove("hide");
    //       openEye.classList.add("hide");
    //     }
    //   }

    //   // Add event listener if all elements are available
    //   if (levelCollapseAndExpandElement && levelStatusElement && levelCollapseElement && mobileLevelCollapseElement && levelCloseEyeElement && levelOpenEyeElement) {
    //     levelCollapseAndExpandElement.addEventListener("click", () => {
    //       CollapseElements(levelStatusElement, levelCollapseElement, mobileLevelCollapseElement, levelCloseEyeElement, levelOpenEyeElement)
    //     }
    //     );
    //   }
    // }
  } catch (error) {
    console.error('Error:', error);
  }
  finally {
    callMe();
  }
}

debugger
fetchAllData();

function callMe() {
  // DOM elements
  const elements = {
    scrollContainer: document.querySelector('.details .leftSide'),
    dim: document.querySelector(".dim"),
    teacherManagementDim: document.querySelector(".teacherManagementDim"),
    settingIcon: document.querySelector(".settingIcon"),
    teacherCloseIcon: document.querySelector(".teacher-management-closeIcon"),
    filters: document.querySelector(".filters"),
    closeIcon: document.querySelector(".filters .closeIcon"),
    teacherManagement: document.querySelector(".teacherManagement"),
    teacherMobileProfile: document.querySelector(".details .rightSide .teacher-profile"),
    groups: document.querySelectorAll(".groups"),
    groupSettingDim: document.querySelector(".groupSettingDim"),
    grouptSettingCloseIcon: document.querySelector(".grouptSetting-closeIcon"),
    groupSetting: document.querySelector('.groupSetting'),
    monthlyRetentionDim: document.querySelector(".monthlyRetentionDim"),
    monthlyRetentionContainer: document.querySelector(".monthlyRetentionContainer"),
    monthlyRetentionCloseIcon: document.querySelector(".monthlyRetention-closeIcon"),
    monthlyRetention: document.querySelectorAll(".monthlyRetention"),
    SessionDetailDim: document.querySelector(".SessionDetailDim"),
    SessionDetailContainer: document.querySelector(".SessionDetailContainer"),
    SessionDetailCloseIcon: document.querySelector(".SessionDetail-closeIcon"),
    completed: document.querySelectorAll(".completed"),
    inProgress: document.querySelectorAll(".inProgress"),
    teachersOfGroupDim: document.querySelector(".teachersOfGroupDim"),
    teacherOfGroup: document.querySelector(".teacherOfGroup"),
    tabs: document.querySelectorAll(".tab"),
    slider: document.querySelector(".tab-slider"),
    tabBody: document.querySelectorAll(".editMemberShipDim .center_content .content .one"),
    editMembership: document.querySelector(".editMembership"),
    editMemberShipDim: document.querySelector(".editMemberShipDim"),
    editMemberShipContainer: document.querySelector(".editMemberShipDim .center_content"),
    editMemberShipCloseIcon: document.querySelector(".editMemberShipDim .center_content .crossIcon"),

    hightlighted01: document.querySelectorAll(".mainLayout main .bottom-part .details .basicDetails .col01 .basic-info .col01"),
    hightlighted02: document.querySelectorAll(".mainLayout main .bottom-part .details .level1-info  .bottomPart  .mainCall .col01"),

    group: document.querySelectorAll(".mainLayout main .bottom-part .details .basicDetails .col01 .basic-info .col01 .group"),
    highlightedContainer: document.querySelector(".highlightedContainer"),
  }

  // Variables for mouse/touch handling
  let isDragging = false;
  let startX;
  let scrollLeft;

  // Mouse and touch events
  elements.scrollContainer.addEventListener('mousedown', (e) => {
    isDragging = true;
    elements.scrollContainer.classList.add('dragging');
    startX = e.pageX - elements.scrollContainer.offsetLeft;
    scrollLeft = elements.scrollContainer.scrollLeft;
  });

  elements.scrollContainer.addEventListener('mouseleave', () => {
    isDragging = false;
    elements.scrollContainer.classList.remove('dragging');
  });

  elements.scrollContainer.addEventListener('mouseup', () => {
    isDragging = false;
    elements.scrollContainer.classList.remove('dragging');
  });

  elements.scrollContainer.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - elements.scrollContainer.offsetLeft;
    const walk = (x - startX) * 2; // The "2" determines the scroll speed
    elements.scrollContainer.scrollLeft = scrollLeft - walk;
  });

  // Global Function
  function closePopup(element) {
    element.classList.remove("active");
  }
  function activePopup(element) {
    element.classList.add("active");
  }
  function popupAdjustAccordinScreen(addEvent, mainElement, popup, eventName) {
    addEvent.addEventListener(eventName, (event) => {
      activePopup(mainElement);
    });
  }

  function automaticallyAdjust(event) {
    activePopup(elements.teacherManagementDim);
  }


  elements.teacherMobileProfile.addEventListener("click", () => {
    elements.teacherManagementDim.classList.add("active");
  });

  document.querySelectorAll('.teacher')[0].addEventListener('click', automaticallyAdjust);


  const popupListeners = [
    { trigger: elements.settingIcon, action: () => activePopup(elements.dim) },
    { trigger: elements.closeIcon, action: () => closePopup(elements.dim) },
    { trigger: elements.dim, action: () => closePopup(elements.dim) },
    { trigger: elements.filters, action: (e) => e.stopPropagation() },
    { trigger: elements.teacherManagement, action: (e) => e.stopPropagation() },
    { trigger: elements.teacherCloseIcon, action: () => closePopup(elements.teacherManagementDim) },
    { trigger: elements.teacherManagementDim, action: () => closePopup(elements.teacherManagementDim) },
    { trigger: elements.groupSettingDim, action: () => closePopup(elements.groupSettingDim) },
    { trigger: elements.grouptSettingCloseIcon, action: () => closePopup(elements.groupSettingDim) },
    { trigger: elements.groupSetting, action: (e) => e.stopPropagation() },
    { trigger: elements.monthlyRetentionDim, action: () => closePopup(elements.monthlyRetentionDim) },
    { trigger: elements.monthlyRetentionCloseIcon, action: () => closePopup(elements.monthlyRetentionDim) },
    { trigger: elements.monthlyRetentionContainer, action: (e) => e.stopPropagation() },
    { trigger: elements.SessionDetailDim, action: () => closePopup(elements.SessionDetailDim) },
    { trigger: elements.SessionDetailCloseIcon, action: () => closePopup(elements.SessionDetailDim) },
    { trigger: elements.SessionDetailContainer, action: (e) => e.stopPropagation() },
    { trigger: elements.teachersOfGroupDim, action: () => closePopup(elements.teachersOfGroupDim) },
    { trigger: elements.editMembership, action: () => activePopup(elements.editMemberShipDim) },
    { trigger: elements.editMemberShipDim, action: () => closePopup(elements.editMemberShipDim) },
    { trigger: elements.editMemberShipCloseIcon, action: () => closePopup(elements.editMemberShipDim) },
    { trigger: elements.editMemberShipContainer, action: (e) => e.stopPropagation() },
  ];

  // Attach listeners
  popupListeners.forEach(({ trigger, action }) => {
    trigger?.addEventListener("click", action);
  });


  popupAdjustAccordinScreen(elements.groups[0], elements.groupSettingDim, elements.groupSetting, "click");
  popupAdjustAccordinScreen(elements.monthlyRetention[0], elements.monthlyRetentionDim, elements.monthlyRetentionContainer, "click");
  popupAdjustAccordinScreen(elements.completed[0], elements.SessionDetailDim, elements.SessionDetailContainer, "click");
  popupAdjustAccordinScreen(elements.inProgress[0], elements.teachersOfGroupDim, elements.teacherOfGroup, "mouseenter");


  // Tab switch
  elements.tabs.forEach((tab, index) => {
    tab.addEventListener("click", () => {
      // Remove active class from all tabs
      elements.tabs.forEach(t => t.classList.remove("active"));
      elements.tabBody.forEach(t => t.classList.remove("active"));

      // Add active class to clicked tab
      tab.classList.add("active");
      elements.tabBody[index].classList.add("active");

      // Move the slider to the clicked tab
      elements.slider.style.transform = `translateX(${index * 100}%)`;
    });
  });

  elements.group[0].addEventListener("click", () => {
    // Toggle 'active' class on the group element
    elements.group[0].classList.toggle("active");

    fetch('./courses.php')
      .then(response => response.json())
      .then(data => {
        const totalLevels = data.totalLevels; // Get the total number of levels (example with 5 levels)

        // Loop through highlighted elements starting from 03 onward dynamically
        for (let i = 1; i <= totalLevels + 1; i++) {
          const highlightedKey = `hightlighted${i.toString().padStart(2, '0')}`; // Dynamic key like hightlighted03, hightlighted04, etc.
          if (elements[highlightedKey]) {
            elements[highlightedKey][0].classList.toggle("active"); // Toggle 'active' class dynamically
          }
        }
      })
      .catch(error => {
        console.error('Error fetching totalLevels:', error);
      });

    // Toggle 'active' class on the highlightedContainer element
    elements.highlightedContainer.classList.toggle("active");
  });

  // =====================================================
  // Select dropdown elements
  const dropdowns = document.querySelectorAll(".custome-dropdown");

  // Function to close all dropdowns
  function closeAllDropdowns() {
    dropdowns.forEach(dropdown => {
      const optionsContainer = dropdown.querySelector(".dropdown-Option");
      optionsContainer.classList.remove("active");
    });
  }

  // Add event listeners for each dropdown
  dropdowns.forEach((dropdown) => {
    const displayArea = dropdown.querySelector(".displayArea");
    const optionsContainer = dropdown.querySelector(".dropdown-Option");
    const options = dropdown.querySelectorAll(".dropdown-Option p");
    const valueDisplay = dropdown.querySelector(".dropdownValueDisplay");

    // Toggle dropdown visibility
    displayArea.addEventListener("click", (event) => {
      // If the dropdown is already open, close it
      if (optionsContainer.classList.contains("active")) {
        optionsContainer.classList.remove("active");
      } else {
        // Close all other dropdowns
        closeAllDropdowns();
        // Toggle the current dropdown
        optionsContainer.classList.add("active");
      }
      // Prevent event propagation to window click listener
      event.stopPropagation();
    });

    // Handle option selection
    options.forEach(option => {
      option.addEventListener("click", () => {
        valueDisplay.innerText = option.innerText;
        optionsContainer.classList.remove("active");
      });
    });
  });

  // Close dropdowns when clicking anywhere in the window
  window.addEventListener("click", closeAllDropdowns);


}