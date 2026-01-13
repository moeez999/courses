<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Modal -->
<section class="backdrop-level-1"></section>
<section class="backdrop-level-2"></section>
<section class="backdrop-level-3"></section>
<section class="backdrop-level-4"></section>
<div class="lesson-popup custom-modal" id="subscribeModal">
    <div class="popup-body">
        <div class="popup-section">
            <h1 class="popup-title">Continue learning</h1>

            <div class="teacher-list">
                <div class="teacher-card">
                    <div class="card-left-side">
                        <div class="avatar-box">
                            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
                        </div>

                        <div class="teacher-info">
                            <div class="info-header">
                                <h1>Wade Warren</h1>
                                <div class="status-point"></div>
                                <p>English</p>
                            </div>
                            <p>Trial lesson completed</p>
                        </div>
                    </div>
                    <a href="">Subscribe</a>
                </div>

                <div class="teacher-card">
                    <div class="card-left-side">
                        <div class="avatar-box">
                            <img src="https://dev.latingles.com/img/subs/3.png" alt="">
                        </div>

                        <div class="teacher-info">
                            <div class="info-header">
                                <h1>Camila</h1>
                                <div class="status-point"></div>
                                <p>English</p>
                            </div>
                            <p>Trial lesson completed</p>
                        </div>
                    </div>
                    <a href="">Subscribe</a>
                </div>

                <div class="teacher-card">
                    <div class="card-left-side">
                        <div class="avatar-box">
                            <img src="https://dev.latingles.com/img/subs/9.png" alt="">
                        </div>

                        <div class="teacher-info">
                            <div class="info-header">
                                <h1>Karen</h1>
                                <div class="status-point"></div>
                                <p>English</p>
                            </div>
                            <p>Subscription cancelled</p>
                        </div>
                    </div>
                    <a href="">Subscribe</a>
                </div>

                <div class="teacher-card">
                    <div class="card-left-side">
                        <div class="avatar-box">
                            <img src="https://dev.latingles.com/img/subs/10.png" alt="">
                        </div>

                        <div class="teacher-info">
                            <div class="info-header">
                                <h1>Marbe B.</h1>
                                <div class="status-point"></div>
                                <p>English</p>
                            </div>
                            <p>Trial lesson completed</p>
                        </div>
                    </div>
                    <a href="">Book trial lesson</a>
                </div>
            </div>
        </div>

        <div class="popup-section">
            <h1 class="popup-title">Try a first lesson</h1>

            <div class="teacher-list">
                <div class="teacher-card">
                    <div class="card-left-side">
                        <div class="avatar-box">
                            <img src="https://dev.latingles.com/img/subs/11.png" alt="">
                        </div>

                        <div class="teacher-info">
                            <div class="info-header">
                                <h1>Anne S.</h1>
                                <div class="status-point"></div>
                                <p>English</p>
                            </div>
                            <p>You've viewed their profile</p>
                        </div>
                    </div>
                    <a href="">Book trial lesson</a>
                </div>

                <div class="teacher-card">
                    <div class="card-left-side">
                        <div class="avatar-box">
                            <img src="https://dev.latingles.com/img/subs/12.png" alt="">
                        </div>

                        <div class="teacher-info">
                            <div class="info-header">
                                <h1>Anne S.</h1>
                                <div class="status-point"></div>
                                <p>English</p>
                            </div>
                            <p>You've viewed their profile</p>
                        </div>
                    </div>
                    <a href="">Book trial lesson</a>
                </div>
            </div>
        </div>
    </div>

    <div class="transfer-actions transferLessonsBTN">
        <button id="transfer-balance-or-subscription">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.99988 14H15.9999V12H3.99988L6.29288 9.70697L4.87888 8.29297L0.171875 13L4.87888 17.707L6.29288 16.293L3.99988 14ZM15.9999 5.99997H3.99988V3.99997H15.9999L13.7069 1.70697L15.1209 0.292969L19.8279 4.99997L15.1209 9.70697L13.7069 8.29297L15.9999 5.99997Z"
                    fill="#121117"></path>
            </svg>
            <span>Transfer balance or subscription</span>
        </button>
    </div>
</div>


<div class="what-would-you-like-to-do-modal custom-modal page1" id="transfer-balance-screen-1">
    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
    <div>
        <h1>What would you like to do?</h1>
        <p class="balance-line"><b>Your balance with Daniela.</b>: 4.5 lessons • $13.50</p>
    </div>
    <ul>
        <li class="action" data-open="transfer-balance-screen-2" data-close="transfer-balance-screen-1">
            <div style="display: flex; gap: 8px; margin-bottom: 14px; align-items: center">
                <img src="../img/cour/1.png" alt="" height= "32px" width="32px">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.0859 10.9931H4.08594V12.9931H16.0859L10.7929 18.2861L12.2069 19.7001L19.9139 11.9931L12.2069 4.28613L10.7929 5.70013L16.0859 10.9931Z" fill="black"/>
                </svg>
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.5" y="0.5" width="31" height="31" rx="3.5" fill="#EBEBF1"/>
                    <rect x="0.5" y="0.5" width="31" height="31" rx="3.5" stroke="#DCDCE5"/>
                    <path d="M13.9022 17.5759L13.8362 15.7059L15.4642 15.5959C16.2272 15.5519 16.8502 15.3319 17.3342 14.9359C17.8342 14.5399 18.0822 13.9609 18.0822 13.1979C18.0822 12.5529 17.8552 12.0179 17.4002 11.5919C16.9462 11.1669 16.3522 10.9539 15.6182 10.9539C15.1052 10.9539 14.6582 11.0859 14.2772 11.3499C13.9283 11.5774 13.6591 11.9081 13.5072 12.2959L10.8672 11.5479C11.1434 10.6035 11.7327 9.78115 12.5382 9.21594C13.3742 8.62894 14.4012 8.33594 15.6182 8.33594C16.6452 8.33594 17.5552 8.54894 18.3472 8.97394C19.1129 9.35994 19.7536 9.9549 20.1952 10.6899C20.6492 11.4089 20.8762 12.2449 20.8762 13.1979C20.8762 14.0779 20.6642 14.8479 20.2382 15.5079C19.8132 16.1679 19.2192 16.6809 18.4572 17.0479C17.6942 17.3999 16.8072 17.5759 15.7942 17.5759H13.9022ZM15.3322 24.3299C15.1001 24.333 14.8696 24.2898 14.6543 24.203C14.439 24.1161 14.2432 23.9872 14.0782 23.8239C13.9135 23.6554 13.7839 23.4558 13.697 23.2368C13.6101 23.0177 13.5677 22.7836 13.5722 22.5479C13.5722 22.0639 13.7422 21.6529 14.0792 21.3159C14.2408 21.1469 14.4354 21.0129 14.651 20.922C14.8665 20.8312 15.0983 20.7856 15.3322 20.7879C15.8162 20.7879 16.2272 20.9639 16.5642 21.3159C16.9162 21.6529 17.0922 22.0639 17.0922 22.5479C17.0922 23.0469 16.9162 23.4719 16.5652 23.8239C16.4053 23.9879 16.2135 24.1175 16.0016 24.2045C15.7897 24.2915 15.5622 24.3342 15.3332 24.3299H15.3322ZM13.9462 19.5779L13.8802 16.2999H16.7842L16.7182 19.5779H13.9462Z" fill="black"/>
                </svg>


            </div>
            <div class="font-w500">Switch Daniela for another tutor</div>
            <p style="margin-top: 2px" class="normal-text-li">Cancel your subscription with Daniela and use remaining balance to pay for a subscription with a new tutor</p>
        </li>
        <li class="action" data-open="transfer-balance-screen-2-x" data-close="transfer-balance-screen-1">
            <div style="display: flex; gap: 8px; margin-bottom: 14px; align-items: center">
                <div style="width: 32px; height: 32px; border-radius: 4px; border-width: 1px; background: #EBEBF1; display: flex; align-items: center; justify-content: center">
                    <img src="../course/images/person-vector.png">

                </div>
            </div>
            <div class="font-w500">Add an additional tutor</div>
            <p style="margin-top: 2px" class="normal-text-li">Keep your subscription with Daniela and start a new subscription with another tutor using your balance.</p>
        </li>
        <li class="action" data-open="how-many-lessons-you-want-modal-x" data-close="transfer-balance-screen-1">
            <div style="display: flex; gap: 8px; margin-bottom: 14px; align-items: center">
               <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.5" y="0.5" width="31" height="31" rx="3.5" fill="#EBEBF1"/>
                    <rect x="0.5" y="0.5" width="31" height="31" rx="3.5" stroke="#DCDCE5"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99988 21H21.9999V19H9.99988L12.2929 16.707L10.8789 15.293L6.17188 20L10.8789 24.707L12.2929 23.293L9.99988 21ZM21.9999 13H9.99988V11H21.9999L19.7069 8.70697L21.1209 7.29297L25.8279 12L21.1209 16.707L19.7069 15.293L21.9999 13Z" fill="black"/>
                </svg>
            </div>
            <div class="font-w500">Transfer Lessons From daniela to Bruce.</div>
        </li>
         <li class="action" data-open="transfer-remaining-balance-transfer-to" data-close="transfer-balance-screen-1">
            <div style="display: flex; gap: 8px; margin-bottom: 14px; align-items: center">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.5" y="0.5" width="31" height="31" rx="3.5" fill="#EBEBF1"/>
                <rect x="0.5" y="0.5" width="31" height="31" rx="3.5" stroke="#DCDCE5"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.0004 14.0004C18.0004 15.0613 17.579 16.0787 16.8289 16.8288C16.0787 17.579 15.0613 18.0004 14.0004 18.0004C12.9396 18.0004 11.9222 17.579 11.172 16.8288C10.4219 16.0787 10.0004 15.0613 10.0004 14.0004C10.0004 12.9396 10.4219 11.9221 11.172 11.172C11.9222 10.4218 12.9396 10.0004 14.0004 10.0004C15.0613 10.0004 16.0787 10.4218 16.8289 11.172C17.579 11.9221 18.0004 12.9396 18.0004 14.0004ZM17.0484 19.1704C15.7905 19.9122 14.3051 20.1696 12.8709 19.8946C11.4366 19.6195 10.152 18.8308 9.25764 17.6763C8.36332 16.5218 7.92077 15.0807 8.01295 13.6233C8.10512 12.1658 8.7257 10.792 9.75834 9.75932C10.791 8.72667 12.1648 8.1061 13.6223 8.01392C15.0797 7.92175 16.5208 8.3643 17.6753 9.25862C18.8298 10.1529 19.6185 11.4376 19.8936 12.8719C20.1687 14.3061 19.9112 15.7914 19.1694 17.0494L24.7794 22.6574L22.6574 24.7774L17.0484 19.1694V19.1704Z" fill="black"/>
            </svg>

            </div>
            <div class="font-w500">Find a new tutor</div>
        </li>
    </ul>
    <!-- <ul>
        <li class="transfer-from-modal-open" data-set="current-tutor">
            <div class="content">
                <div class="iconContainer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M17.1701 0.833984V7.83398H10.1701V5.83398H14.0581C13.4318 4.85289 12.5336 4.07516 11.4731 3.59555C10.4125 3.11593 9.23535 2.95515 8.08503 3.13279C6.93471 3.31043 5.86089 3.81883 4.99442 4.59602C4.12796 5.37322 3.50626 6.38567 3.20508 7.50998L1.27208 6.98998C1.6523 5.5712 2.41579 4.28449 3.47886 3.27088C4.54193 2.25728 5.86354 1.55592 7.29882 1.24368C8.7341 0.931448 10.2276 1.02039 11.6157 1.50076C13.0038 1.98113 14.2328 2.83438 15.1681 3.96698V0.833984H17.1681H17.1701ZM0.830078 17.29V10.29H7.83008V12.29H3.94308C4.56931 13.2711 5.46739 14.0489 6.52788 14.5285C7.58836 15.0082 8.76547 15.1691 9.91578 14.9916C11.0661 14.814 12.1399 14.3057 13.0065 13.5287C13.873 12.7516 14.4948 11.7392 14.7961 10.615L16.7281 11.132C16.348 12.5508 15.5846 13.8377 14.5216 14.8514C13.4586 15.8651 12.137 16.5666 10.7017 16.8789C9.26638 17.1913 7.7728 17.1024 6.38466 16.6221C4.99652 16.1418 3.76741 15.2886 2.83208 14.156V17.29H0.832078H0.830078Z"
                            fill="#FF2500"></path>
                    </svg>
                </div>

                <p>Transfer your remaining balance between your current tutors</p>
            </div>

            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>

        <li class="transfer-from-modal-open" data-set="new-tutor">
            <div class="content">
                <div class="iconContainer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M16 3.5H23V5.5H16V3.5Z" fill="#FF2500"></path>
                        <path d="M18.5 1H20.5V8H18.5V1Z" fill="#FF2500"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M14.0003 3.22296C12.097 2.78953 10.1044 2.98666 8.32292 3.78461C6.54144 4.58257 5.06768 5.93809 4.12388 7.64678C3.18007 9.35547 2.81738 11.3247 3.09049 13.2575C3.3636 15.1903 4.25771 16.982 5.638 18.3623C7.01829 19.7425 8.80993 20.6367 10.7427 20.9098C12.6756 21.1829 14.6448 20.8202 16.3535 19.8764C18.0622 18.9326 19.4177 17.4588 20.2156 15.6773C21.0136 13.8959 21.2107 11.9033 20.7773 9.99996H18.7103C19.155 11.4927 19.0892 13.0911 18.5232 14.5422C17.9572 15.9933 16.9234 17.2142 15.5855 18.0116C14.2475 18.809 12.6818 19.1374 11.1362 18.9449C9.59055 18.7523 8.15331 18.0497 7.05194 16.9483C5.95057 15.847 5.24799 14.4097 5.05541 12.8641C4.86282 11.3185 5.19123 9.75277 5.98865 8.41481C6.78607 7.07685 8.00696 6.04306 9.45806 5.47707C10.9092 4.91109 12.5076 4.84524 14.0003 5.28995V3.22296ZM16.0003 8.99996H13.0003V12H16.0003V8.99996ZM8.00031 8.99996H11.0003V12H8.00031V8.99996ZM9.05231 16.632C8.27131 16.085 7.68831 15.334 7.16831 14.555L8.83231 13.445C9.31231 14.165 9.72931 14.665 10.1983 14.993C10.6403 15.303 11.1853 15.5 12.0003 15.5C12.8153 15.5 13.3603 15.302 13.8023 14.993C14.2713 14.665 14.6883 14.166 15.1683 13.445L16.8323 14.555C16.3123 15.335 15.7293 16.085 14.9483 16.632C14.1403 17.198 13.1853 17.5 12.0003 17.5C10.8153 17.5 9.86031 17.198 9.05231 16.632Z"
                            fill="#FF2500"></path>
                    </svg>
                </div>

                <p>Transfer your remaining balance to try a new tutor</p>
            </div>

            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>

        <li class="transfer-from-modal-open" data-set="another-tutor">
            <div class="content">
                <div class="iconContainer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M1.99963 9.00001C1.99968 10.3972 2.41781 11.7623 3.20023 12.9198C3.98264 14.0773 5.09353 14.9742 6.38995 15.4951C7.68637 16.016 9.109 16.137 10.4748 15.8426C11.8405 15.5481 13.087 14.8518 14.0536 13.843L15.6206 15.096C14.3935 16.4287 12.7927 17.36 11.0276 17.7681C9.26259 18.1763 7.41545 18.0423 5.72782 17.3836C4.04018 16.7249 2.5906 15.5723 1.56866 14.0764C0.546721 12.5806 0 10.8111 0 8.99951C0 7.1879 0.546721 5.41845 1.56866 3.92259C2.5906 2.42673 4.04018 1.27409 5.72782 0.615433C7.41545 -0.043227 9.26259 -0.17725 11.0276 0.230893C12.7927 0.639035 14.3935 1.57034 15.6206 2.90301L14.0536 4.15701C13.087 3.14828 11.8405 2.45189 10.4748 2.15746C9.109 1.86304 7.68637 1.98404 6.38995 2.50491C5.09353 3.02578 3.98264 3.92268 3.20023 5.08019C2.41781 6.23771 1.99968 7.60287 1.99963 9.00001ZM9.24163 10.803L9.68963 12H11.2196L8.77163 5.70001H7.22363L4.77563 12H6.30563L6.75363 10.803H9.24163ZM8.76363 9.52501L7.99763 7.47901L7.23263 9.52501H8.76263H8.76363ZM15.9996 8.00001H17.9996V10H15.9996V12H13.9996V10H11.9996V8.00001H13.9996V6.00001H15.9996V8.00001Z"
                            fill="#FF2500"></path>
                    </svg>
                </div>

                <p>Transfer your subscription to another tutor</p>
            </div>

            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
    </ul> -->
</div>

<div class="what-would-you-like-to-do-modal transfer-to-modal custom-modal page2" id="transfer-balance-screen-2">
    <div class="backIcon backIcon-two back-modal back-action" data-open="transfer-balance-screen-1" data-close="transfer-balance-screen-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <h1 class="page2">Who would you like to switch to?</h1>

    <div class="container">
        <h4>Not subscribed yet</h4>

        <ul class="page2">
            <li class="page2 bd-down action" data-open="transfer-balance-screen-3" data-close="transfer-balance-screen-2">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/1.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Mitchell</h3>
                        <p>12 lessons left · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
            <li class="page2 action" data-open="transfer-balance-screen-3" data-close="transfer-balance-screen-2">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/2.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Bruce</h3>
                        <p>12 lessons left · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
            <li class="page2 action" data-open="transfer-balance-screen-3" data-close="transfer-balance-screen-2">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/3.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Brandon</h3>
                        <p>12 lessons left · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
            <li class="page2 action" data-open="transfer-balance-screen-3" data-close="transfer-balance-screen-2">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/4.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Pat</h3>
                        <p>12 lessons left · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
        </ul>
    </div>
     <div class="container">
        <h4>Cancelled subscriptions</h4>

        <ul class="page2">
            <li class="page2 bd-down action" data-open="transfer-balance-screen-3" data-close="transfer-balance-screen-2">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/5.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Calvin</h3>
                        <p>subscriptions Cancelled · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
            <li class="page2 action" data-open="transfer-balance-screen-3" data-close="transfer-balance-screen-2">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/6.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Lee</h3>
                        <p>subscriptions Cancelled · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="what-would-you-like-to-do-modal transfer-to-modal page3" id="transfer-balance-screen-3">
    <div class="backIcon backIcon-two back-modal back-action"  data-open="transfer-balance-screen-2" data-close="transfer-balance-screen-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
      <img src="https://dev.latingles.com/img/subs/1.png" alt="" height="48px" width="48px" style="margin-bottom: 8px;">
    <h1 class="page2">Do you want to cancel your scheduled lessons with Daniela?</h1>

    <div class="container">

        <ul class="page3" style="margin-top: 20px !important;;margin-bottom: 24px !important;">
            <label class="w-100">
                <li class="page3">
                    <div class="leftSide">
                    <div class="content">
                            <p>APR</p>
                            <h3>19</h3>
                        </div>

                        <div class="content">
                            <h3>17:00 - 17:50</h3>
                            <p>50-min lesson</p>
                        </div>
                    </div>
                    <div class="boxes">
                        <div class="box1" id="check-count">1</div>
                        <input type="checkbox" id="check-lesson-box">
                    </div>
                </li>
            </label>
        </ul>
        <div class="hidden-box" id="check-lesson-div" style="display: none">
            <p>I cancelled lesson with Karen</p>
            <p class="count">+ $1.50</p>
        </div>
        <div style="display: flex; flex-direction: column; gap: 16px;" class="w-100">
            <button disabled href="#" class="btn action show-thank-you-event" id="cancel-selected-lesson"  data-open="transfer-balance-screen-4" data-close="transfer-balance-screen-3">Cancel Selected Lessons</button>
            <a href="#" class="keep-all-button action hide-thank-you-event" style="margin-left: 0"  data-open="transfer-balance-screen-4" data-close="transfer-balance-screen-3">Keep all scheduled lessons</a>
        </div>
    </div>

</div>

<div class="what-would-you-like-to-do-modal transfer-to-modal page4" id="transfer-balance-screen-4">
    <div class="backIcon backIcon-two back-modal back-action"  data-open="transfer-balance-screen-3" data-close="transfer-balance-screen-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
    <img src="https://dev.latingles.com/img/subs/1.png" alt="" height="48px" width="48px" style="margin-bottom: 8px;">
    <h1 class="page2">Choose your monthly plan with Mitchell</h1>
    <div class="light-green w-100" style="margin-top: 20px">
        <div class="left">
            <h3>Your remaining balance with Daniela ($6.00)</h3>
            <p>will be used to pay for the subscription with <br> Mitchell.</p>
        </div>
        <svg width="77" height="79" viewBox="0 0 77 79" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M45.4299 12.6526C47.5281 12.7766 49.6399 13.8296 51.382 14.981C53.7998 16.5635 55.8191 18.5139 57.7942 20.6219C61.2669 24.4422 64.2217 28.8254 66.6742 33.3916C69.2633 38.2865 71.427 43.6282 72.4665 49.1077C72.9073 51.6802 73.1845 54.288 72.7091 56.8802C72.4453 58.3012 71.9564 59.6789 70.9573 60.7378C70.3548 61.3992 69.6329 61.7003 68.8937 62.1628C67.9851 62.6805 67.1246 63.2709 66.1949 63.7433C65.2997 64.192 64.5355 64.6821 63.5249 64.8081C62.2698 64.9242 60.9954 64.7274 59.8558 64.1665C57.6382 63.263 55.7286 61.907 53.8479 60.4269C51.8594 61.2456 49.7919 61.7082 47.7014 62.1589C40.8407 63.4953 33.7182 63.7 26.7574 63.3004C22.2625 62.9757 17.6271 62.3911 13.3228 60.9799C11.9734 60.5371 10.7202 59.9958 9.66531 58.9979C9.38811 58.75 9.36116 58.4232 9.35346 58.069C9.35538 56.4649 9.40736 54.8588 9.37656 53.2528C8.25428 52.8119 6.52756 52.1368 5.99433 50.9578C5.88653 48.6216 5.92696 46.2341 5.85958 43.892C5.86151 43.2818 5.82493 42.6933 6.20416 42.1777C6.91256 41.2605 7.93281 40.796 8.97808 40.4023C8.88183 38.9971 8.98193 37.6095 9.04353 36.2061C8.53726 35.7613 7.95976 35.409 7.93473 34.6493C7.82501 32.4213 7.95013 30.1834 7.89238 27.9475C7.90971 27.3571 7.83463 26.6229 8.23888 26.1486C9.08396 25.072 10.4276 24.6134 11.6519 24.1588C13.9042 23.3872 16.2912 22.9562 18.6377 22.6058C24.1625 21.8402 29.7046 21.6532 35.2736 21.8225C35.4873 19.8799 35.9993 17.6401 37.5066 16.3017C38.8599 15.29 40.3691 14.4673 41.8378 13.6446C42.962 13.0128 44.1247 12.5601 45.4299 12.6526Z" fill="#302F3C"/>
            <path d="M45.0459 12.9291C46.8169 12.9094 48.5802 13.6593 50.1163 14.5017C52.2203 15.7161 54.1588 17.3083 55.8913 19.0246C59.0522 22.1108 61.7683 25.7519 64.138 29.4974C67.2296 34.5026 69.8129 39.9722 71.403 45.6741C72.2962 48.9728 72.9584 52.6376 72.558 56.0584C72.3327 57.8376 71.7687 59.7409 70.3673 60.9257C69.118 62.02 67.3816 62.1224 65.8359 61.776C64.1419 61.3804 62.521 60.5616 61.0715 59.5913C57.4621 57.1409 54.3398 53.7674 51.7083 50.2699C47.9449 45.3179 44.8976 39.7754 42.6319 33.9515C41.4134 30.7217 40.4547 27.4584 39.9966 24.0199C39.7271 21.849 39.6501 19.7351 40.1159 17.5859C40.4259 16.2632 40.9841 14.9248 42.0178 14.0254C42.8514 13.2617 43.939 12.9271 45.0459 12.9291Z" fill="#FFCB00"/>
            <path d="M41.4676 14.1504C40.9497 14.8137 40.4935 15.5124 40.2105 16.3154C39.4617 18.443 39.4521 20.7006 39.6176 22.9286C39.9738 26.7508 41.0806 30.5849 42.4378 34.1552C43.8834 37.883 45.6621 41.4769 47.7392 44.876C49.8875 48.3893 52.2745 51.6939 55.0927 54.6797C57.1871 56.9214 59.5626 59.051 62.2075 60.5862C64.1325 61.6589 66.1114 62.4285 68.3463 62.1825C67.2164 62.9028 66.0517 63.5563 64.8486 64.1448C64.1094 64.499 63.3798 64.6309 62.5636 64.5738C60.86 64.4892 59.3123 63.696 57.8339 62.8969C55.2044 61.3814 52.9964 59.3935 50.9193 57.1773C49.0829 55.156 47.3523 53.048 45.8065 50.7865C41.7005 44.8012 38.3491 38.0346 36.5203 30.949C35.708 27.6542 35.1362 23.9599 35.7099 20.5864C36.0063 19.0414 36.6012 17.2641 37.9102 16.3154C38.8265 15.6698 39.7909 15.0853 40.7669 14.5381C40.9998 14.4102 41.2327 14.2803 41.4676 14.1504Z" fill="#E08900"/>
            <path d="M35.2654 22.0924C35.1326 24.1984 35.3366 26.2827 35.6966 28.3552C33.0247 28.4005 30.1487 28.3651 27.5307 28.9614C26.8416 29.1543 25.9291 29.3472 25.5384 30.0243C25.2361 30.7407 25.6057 31.2603 26.1101 31.7248C25.2958 31.711 24.4873 31.7346 23.673 31.6658C19.9693 31.3567 16.1424 30.91 12.56 29.8747C11.3011 29.4869 9.88234 29.0165 8.85439 28.1525C8.41549 27.7884 7.98814 27.1802 8.27881 26.5917C8.59259 25.9324 9.35489 25.462 9.97474 25.1412C12.0961 24.0823 14.5947 23.5745 16.9067 23.1395C22.9666 22.116 29.1323 21.9035 35.2654 22.0924Z" fill="#FFCB00"/>
            <path d="M8.13086 27.7627C8.66216 28.4417 9.32821 28.8885 10.1001 29.2369C12.2658 30.2387 14.7625 30.7347 17.0917 31.148C20.4778 31.6991 23.9062 32.014 27.3347 32.0455C30.355 32.203 33.3715 32.136 36.3918 32.0042C36.3956 34.4841 36.49 36.9739 36.7787 39.4361C34.7825 39.4735 32.794 39.568 30.7977 39.4774C25.3943 39.3594 19.8907 39.011 14.5873 37.9068C12.7913 37.4876 10.8278 37.0113 9.24928 36.0075C8.80846 35.6985 8.16551 35.2261 8.18476 34.614C8.08081 32.325 8.25021 30.0517 8.13086 27.7627Z" fill="#E08900"/>
            <path d="M9.27098 36.3535C11.4097 37.5344 13.9872 38.0737 16.3627 38.5166C22.2551 39.5204 28.2977 39.7802 34.2652 39.7428C34.7484 39.7723 35.4856 39.6168 35.9091 39.7998C36.2845 42.1774 36.6406 44.5393 37.3914 46.8342C34.2979 46.9621 31.2044 47.0251 28.109 46.909C23.7277 46.7456 19.254 46.3756 14.9767 45.3423C13.4887 44.9664 11.9159 44.496 10.5896 43.6949C10.0699 43.3741 9.45193 42.8899 9.25365 42.2817C9.20938 40.3037 9.17858 38.3316 9.27098 36.3535Z" fill="#E08900"/>
            <path d="M8.97232 40.6318C9.04932 41.2459 8.94922 41.8836 9.05125 42.4859C9.4016 43.285 10.1581 43.781 10.8915 44.1707C12.5971 45.0386 14.5471 45.5425 16.4067 45.9302C20.813 46.8199 25.3579 47.0994 29.8374 47.2352C32.338 47.2804 34.8462 47.2804 37.3449 47.1368C38.061 47.121 38.6847 46.9754 39.3546 47.3277C39.1448 47.4103 38.9369 47.4989 38.7232 47.5717C37.497 47.7154 36.2688 47.7626 35.0349 47.8118C31.079 48.1169 27.0577 47.9811 23.0999 47.7705C19.6657 47.5422 16.2142 47.2568 12.8435 46.5266C10.7953 46.07 8.82217 45.5248 7.0223 44.3872C6.46597 44.027 5.93082 43.3007 6.25807 42.6118C6.65847 41.7931 7.64022 41.242 8.4237 40.872C8.60657 40.7913 8.78945 40.7106 8.97232 40.6318Z" fill="#FFCB00"/>
            <path d="M6.10938 43.9219C7.04107 44.8942 8.21917 45.3469 9.44155 45.8527C12.0076 46.701 14.6468 47.1989 17.3206 47.5198C22.9377 48.1752 28.6145 48.3385 34.2644 48.1693C35.9546 48.1299 37.6351 47.9252 39.3214 47.8878C39.3503 47.7756 39.3753 47.6654 39.4022 47.5532C39.1751 47.5571 38.9499 47.5631 38.7227 47.5709C38.9364 47.4981 39.1443 47.4095 39.3541 47.3269C39.5697 47.4942 39.7776 47.6713 39.9874 47.8445C40.6496 50.2595 41.7334 52.4678 42.9924 54.6112C41.3118 54.8631 39.6217 55.0698 37.9277 55.2017C35.0344 55.3138 32.1604 55.6091 29.2594 55.5756C23.3516 55.5264 17.3418 55.1839 11.5975 53.6704C10.1076 53.2472 8.48675 52.7631 7.17582 51.9069C6.77157 51.6136 6.1883 51.1452 6.19408 50.5921C6.1421 48.37 6.19407 46.142 6.10938 43.9219ZM9.62828 53.3791C14.3888 54.8474 19.2071 55.4477 24.1562 55.7429C26.7627 55.8649 29.346 55.9634 31.9544 55.8177C34.9247 55.6681 37.895 55.6307 40.8633 55.4162C41.9163 57.965 43.4505 60.195 45.1099 62.362C41.9509 62.8717 38.7997 62.9091 35.6177 63.1158C32.9169 63.2083 30.2258 63.1453 27.5269 63.0194C23.2746 62.7911 19.1378 62.3718 15.0164 61.2244C13.4051 60.75 11.6553 60.1615 10.2751 59.1676C9.98633 58.9373 9.61287 58.6873 9.61095 58.2681C9.53588 56.6404 9.7149 55.0107 9.62828 53.3791Z" fill="#E08900"/>
        </svg>

    </div>
    <div class="container">

        <ul class="page4" style="margin-top: 20px !important;margin-bottom: 24px !important;">
                <li class="page4 active action" data-open="transfer-balance-screen-5" data-close="transfer-balance-screen-4">
                    <div class="leftSide">

                        <div class="content">
                            <h3>1 lessons</h3>
                            <p>$20 every 4 weeks</p>
                        </div>
                    </div>
                    <div class="green">
                        Your monthly plan with Daniela 
                    </div>
                </li>
                 <li class="page4 action" data-open="transfer-balance-screen-5" data-close="transfer-balance-screen-4">
                    <div class="leftSide">

                        <div class="content">
                            <h3>2 lessons</h3>
                            <p>$40 every 4 weeks</p>
                        </div>
                    </div>
                </li>
                 <li class="page4">
                    <div class="leftSide action" data-open="transfer-balance-screen-5" data-close="transfer-balance-screen-4">

                        <div class="content">
                            <h3>3 lessons</h3>
                            <p>$60 every 4 weeks</p>
                        </div>
                    </div>
                </li>
                  <li class="page4">
                    <div class="leftSide action" data-open="transfer-balance-screen-5" data-close="transfer-balance-screen-4">

                        <div class="content">
                            <h3>4 lessons</h3>
                            <p>$80 every 4 weeks</p>
                        </div>
                    </div>
                </li>
           
        </ul>
    </div>

</div>

<div class="what-would-you-like-to-do-modal transfer-to-modal page5" id="transfer-balance-screen-5">
    <div class="backIcon backIcon-two back-modal back-action"  data-open="transfer-balance-screen-4" data-close="transfer-balance-screen-5">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
        <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z"
                    fill="#121117"></path>
            </svg>
        </div>
    </div>
    <h1 class="page2" style="margin-top: 5px;">Complete your switch to  Mitchell </h1>
    <ul class="divWithTimeline page5" style="margin-top: 20px !important;margin-bottom: 32px !important;">
        <li>
            <span>Your subscription with <b>Daniela will be cancelled</b> and you won’t be charged again.<span>
            <div class="thank-note" id="thank-you-action-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16 6H8C6.93913 6 5.92172 6.42143 5.17157 7.17157C4.42143 7.92172 4 8.93913 4 10V18H16C17.0609 18 18.0783 17.5786 18.8284 16.8284C19.5786 16.0783 20 15.0609 20 14V10C20 8.93913 19.5786 7.92172 18.8284 7.17157C18.0783 6.42143 17.0609 6 16 6ZM8 4C6.4087 4 4.88258 4.63214 3.75736 5.75736C2.63214 6.88258 2 8.4087 2 10V20H16C17.5913 20 19.1174 19.3679 20.2426 18.2426C21.3679 17.1174 22 15.5913 22 14V10C22 8.4087 21.3679 6.88258 20.2426 5.75736C19.1174 4.63214 17.5913 4 16 4H8ZM8 9H16V11H8V9ZM11 13H8V15H11V13Z" fill="#121117"/>
                </svg>
                <div>
                    <p class="open-thank-you-note">Add a thank you note</p>
                </div>
            </div>
            <textarea class="comment-box" id="show-note-box" style="max-height: 90px;
    user-select: none;
    pointer-events: none;
    height: auto;"></textarea>
            <div class="d-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24" height="24" rx="12" fill="#121117"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.26267 14.7947C7.58965 13.896 7.2632 12.7848 7.34319 11.6649C7.42318 10.5449 7.90425 9.49141 8.69816 8.6975C9.49208 7.90358 10.5456 7.42251 11.6655 7.34252C12.7854 7.26253 13.8966 7.58898 14.7953 8.262L8.262 14.7953L8.26267 14.7947ZM9.20533 15.7373C10.104 16.4094 11.2148 16.7351 12.3341 16.6547C13.4535 16.5744 14.5063 16.0934 15.2999 15.2999C16.0934 14.5063 16.5744 13.4535 16.6547 12.3341C16.7351 11.2148 16.4094 10.104 15.7373 9.20533L9.20533 15.7373ZM15.3133 8.71333C15.3045 8.70439 15.2956 8.6955 15.2867 8.68667L15.3133 8.71333ZM6 12C6 11.2121 6.15519 10.4319 6.45672 9.7039C6.75825 8.97595 7.20021 8.31451 7.75736 7.75736C8.31451 7.20021 8.97595 6.75825 9.7039 6.45672C10.4319 6.15519 11.2121 6 12 6C12.7879 6 13.5681 6.15519 14.2961 6.45672C15.0241 6.75825 15.6855 7.20021 16.2426 7.75736C16.7998 8.31451 17.2417 8.97595 17.5433 9.7039C17.8448 10.4319 18 11.2121 18 12C18 13.5913 17.3679 15.1174 16.2426 16.2426C15.1174 17.3679 13.5913 18 12 18C10.4087 18 8.88258 17.3679 7.75736 16.2426C6.63214 15.1174 6 13.5913 6 12Z" fill="white"/>
                </svg>

            </div>
        </li>
        <li>
            <span><b>Your balance with Daniela ($6.00)</b> will be used to pay for the subscription with Mitchell.<span>
            <div class="d-icon">
               <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24" height="24" rx="12" fill="#121117"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.00024 15.3333H16.0002V14H8.00024L9.52891 12.4713L8.58624 11.5286L5.44824 14.6666L8.58624 17.8046L9.52891 16.862L8.00024 15.3333ZM16.0002 9.99998H8.00024V8.66665H16.0002L14.4716 7.13798L15.4142 6.19531L18.5522 9.33331L15.4142 12.4713L14.4716 11.5286L16.0002 9.99998Z" fill="white"/>
                </svg>
            </div>
        </li>
        <li>
            <span>The 4-lesson subscription plan (<b>$20.00 every 4 weeks</b>) with Mitchell <b>will start today.</b><span>
            <div class="d-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24" height="24" rx="12" fill="#121117"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.0081 16.4748C14.8701 17.4921 13.5335 18.0001 12.0001 18.0001C11.1668 18.0001 10.3868 17.8415 9.65881 17.5255C8.95005 17.2217 8.30533 16.7862 7.75881 16.2421C7.21475 15.6957 6.77927 15.0509 6.47548 14.3421C6.15631 13.6029 5.99444 12.8053 6.00015 12.0001C6.00015 11.1668 6.15815 10.3868 6.47481 9.65881C6.77862 8.95004 7.21409 8.30532 7.75815 7.75881C8.30465 7.21476 8.94937 6.77929 9.65815 6.47548C10.3974 6.15631 11.195 5.99444 12.0001 6.00015C12.8968 5.99696 13.7827 6.19636 14.5915 6.58348C15.401 6.96653 16.1112 7.53117 16.6668 8.23348V7.33348H18.0001V10.6668H14.6668V9.33348H15.8335C15.3913 8.72287 14.8155 8.22125 14.1501 7.86681C13.4891 7.51266 12.7501 7.32933 12.0001 7.33348C10.7001 7.33348 9.59748 7.78681 8.69148 8.69148C7.78681 9.59748 7.33348 10.7001 7.33348 12.0001C7.33348 13.3001 7.78681 14.4028 8.69148 15.3081C9.59748 16.2148 10.7001 16.6668 12.0001 16.6668C13.1668 16.6668 14.1868 16.2888 15.0581 15.5335C15.9308 14.7781 16.4448 13.8221 16.6001 12.6668H17.9668C17.8001 14.1888 17.1468 15.4588 16.0081 16.4748ZM11.6275 13.8041C11.507 13.7824 11.3887 13.7499 11.2741 13.7068C11.0562 13.6246 10.8568 13.5 10.6875 13.3401C10.5321 13.1848 10.4361 13.0181 10.4008 12.8401L11.3608 12.5668C11.4055 12.6821 11.4808 12.7821 11.5875 12.8668C11.6941 12.9515 11.8341 12.9955 12.0075 13.0001C12.1675 13.0048 12.3008 12.9668 12.4075 12.8868C12.4593 12.8528 12.5018 12.8062 12.5309 12.7515C12.56 12.6967 12.5749 12.6355 12.5741 12.5735C12.5741 12.4801 12.5341 12.3955 12.4541 12.3201C12.3641 12.2322 12.2507 12.1721 12.1275 12.1468L11.5341 12.0001C11.3361 11.9494 11.1487 11.8636 10.9808 11.7468C10.8322 11.6387 10.7112 11.4971 10.6275 11.3335C10.5452 11.1585 10.5041 10.9669 10.5075 10.7735C10.5075 10.3735 10.6408 10.0601 10.9075 9.83348C11.0935 9.67548 11.3335 9.57215 11.6275 9.52481V8.80015H12.4741V9.53081C12.5661 9.54815 12.6528 9.57081 12.7341 9.60015C12.9388 9.67148 13.1121 9.78015 13.2541 9.92681C13.3961 10.0735 13.5095 10.2555 13.5941 10.4735L12.6408 10.7535C12.6015 10.6397 12.5297 10.54 12.4341 10.4668C12.319 10.375 12.1746 10.3277 12.0275 10.3335C11.8628 10.3335 11.7341 10.3715 11.6408 10.4468C11.5475 10.5221 11.5008 10.6288 11.5008 10.7668C11.5008 10.8688 11.5388 10.9535 11.6141 11.0201C11.6895 11.0821 11.7921 11.1315 11.9208 11.1668L12.5141 11.3201C12.8561 11.4048 13.1208 11.5621 13.3075 11.7935C13.4988 12.0201 13.5941 12.2801 13.5941 12.5735C13.5941 12.8355 13.5321 13.0621 13.4075 13.2535C13.2828 13.4401 13.1055 13.5848 12.8741 13.6868C12.7541 13.7401 12.6208 13.7795 12.4741 13.8048V14.6868H11.6275V13.8041Z" fill="white"/>
                </svg>
            </div>
        </li>
    </ul>
    <a href="#" class="btn action" data-open="transfer-balance-screen-6" data-close="transfer-balance-screen-5">Continue to checkout</a>

</div>

<div class="what-would-you-like-to-do-modal transfer-to-modal page6" id="transfer-balance-screen-6" style="height: 732px;">
    <div class="backIcon backIcon-two back-modal back-action"  data-open="transfer-balance-screen-5" data-close="transfer-balance-screen-6">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
    <div class="profile-details-container">
        <img src="https://dev.latingles.com/img/subs/1.png" alt="" height="64px" width="64px" style="margin-bottom: 8px;">
        <div class="container-details-profile">
                <div class="top-header">
                    <div class="teacher-text"> Daniela </div>
                    <svg width="24" height="19" viewBox="0 0 24 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_20545_58769)">
                        <g clip-path="url(#clip1_20545_58769)">
                        <mask id="mask0_20545_58769" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="-1" y="0" width="26" height="19">
                        <path d="M-0.0078125 0.25H24.0563V18.298H-0.0078125V0.25Z" fill="white"/>
                        </mask>
                        <g mask="url(#mask0_20545_58769)">
                        <path d="M-6.02344 0.25H30.0733V18.2984H-6.02344V0.25Z" fill="#000066"/>
                        <path d="M-6.02344 0.25V2.26785L26.0377 18.2984H30.0733V16.2806L-1.98784 0.25H-6.02344ZM30.0733 0.25V2.26782L-1.98784 18.2984H-6.02344V16.2805L26.0377 0.25H30.0733Z" fill="white"/>
                        <path d="M9.01686 0.25V18.2984H15.033V0.25H9.01686ZM-6.02344 6.26612V12.2822H30.0733V6.26612H-6.02344Z" fill="white"/>
                        <path d="M-6.02344 7.46934V11.079H30.0733V7.46934H-6.02344ZM10.2201 0.25V18.2984H13.8297V0.25H10.2201ZM-6.02344 18.2984L6.0088 12.2822H8.69922L-3.33302 18.2984H-6.02344ZM-6.02344 0.25L6.0088 6.26612H3.31838L-6.02344 1.59528V0.25ZM15.3506 6.26612L27.3828 0.25H30.0733L18.041 6.26612H15.3506ZM30.0733 18.2984L18.041 12.2822H20.7315L30.0733 16.9531V18.2984Z" fill="#CC0000"/>
                        </g>
                        </g>
                        </g>
                        <rect x="0.5" y="0.5" width="23" height="17.5" rx="1.5" stroke="#121117" stroke-opacity="0.56"/>
                        <defs>
                        <clipPath id="clip0_20545_58769">
                        <rect width="24" height="18.5" rx="2" fill="white"/>
                        </clipPath>
                        <clipPath id="clip1_20545_58769">
                        <rect width="24" height="18" fill="white" transform="translate(0 0.25)"/>
                        </clipPath>
                        </defs>
                    </svg>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3H4V18L12 22L20 18V3H12ZM10.5 15.414L17.207 8.707L15.793 7.293L10.5 12.586L8.207 10.293L6.793 11.707L10.5 15.414Z" fill="#121117"/>
                    </svg>

                </div>
                <div class="bottom-section">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.99964 2L9.4803 5.96133L13.7056 6.146L10.3956 8.77933L11.5263 12.854L7.99964 10.52L4.47297 12.854L5.60297 8.77867L2.29297 6.14533L6.5183 5.96133L7.99964 2Z" fill="#121117"/>
                    </svg>
                    <span class="rating">5</span>
                    <span style="margin-left: 8px">(65 reviews)</span>
                </div>
        </div>
    </div>
    <div class="duty-info" style="margin-top: 20px;">
        <div class="info-teacher">
            <div class="info-first" style="margin-left: 4px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 21L5 17.2V11.2L1 9L12 3L23 9V17H21V10.1L19 11.2V17.2L12 21ZM12 12.7L18.85 9L12 5.3L5.15 9L12 12.7ZM12 18.725L17 16.025V12.25L12 15L7 12.25V16.025L12 18.725Z" fill="#121117"/>
                </svg>
                <span style="margin-left: 4px;">17</span>
            </div>
            <span style="margin-top: 4px;" class="label-tex">Students</span>
        </div>
        <div class="info-teacher">
            <div class="info-first">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.41 12.823L6.802 8.218L4.681 8.924L1.5 5.742L4.682 4.682L5.742 1.5L8.925 4.682L8.166 6.855L12.772 11.46L11.41 12.823ZM9.41 2.338L11.12 4.048C12.7689 3.86585 14.4336 4.20078 15.8837 5.00643C17.3338 5.81208 18.4976 7.0486 19.214 8.54483C19.9304 10.0411 20.1639 11.723 19.8823 13.3578C19.6007 14.9926 18.8178 16.4994 17.642 17.6697C16.4663 18.84 14.9558 19.6158 13.3197 19.8898C11.6836 20.1637 10.0028 19.9223 8.50991 19.1989C7.01705 18.4756 5.78599 17.306 4.98713 15.8521C4.18827 14.3982 3.86113 12.732 4.051 11.084L2.347 9.38C2.11607 10.2342 1.99938 11.1152 2 12C2 17.523 6.477 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2C11.105 2 10.237 2.118 9.411 2.338H9.41ZM6.206 10.431L8.006 12.231C8.05069 13.0049 8.31927 13.7491 8.77907 14.3731C9.23887 14.9971 9.87008 15.4742 10.596 15.7461C11.3218 16.0181 12.1111 16.0733 12.8677 15.905C13.6244 15.7367 14.3159 15.3522 14.858 14.7982C15.4002 14.2442 15.7698 13.5447 15.9217 12.7846C16.0737 12.0245 16.0015 11.2366 15.714 10.5167C15.4265 9.79688 14.936 9.17607 14.3022 8.7298C13.6684 8.28353 12.9186 8.03103 12.144 8.003L10.366 6.225C11.641 5.86472 12.9995 5.93661 14.2294 6.42946C15.4592 6.92231 16.4914 7.8084 17.1648 8.94947C17.8382 10.0905 18.115 11.4224 17.9519 12.7373C17.7888 14.0522 17.1951 15.2761 16.2634 16.2182C15.3317 17.1602 14.1144 17.7673 12.8013 17.9448C11.4883 18.1223 10.1535 17.8602 9.00507 17.1994C7.85666 16.5386 6.95928 15.5163 6.45293 14.2919C5.94659 13.0675 5.85976 11.7099 6.206 10.431Z" fill="#121117"/>
                </svg>
                <span style="margin-left: 4px;">3128</span>
            </div>
            <span style="margin-top: 4px;" class="label-tex">lessons completed</span>
        </div>
        <div class="info-teacher">
            <div class="info-first">
               <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 3H7V5H3V20H21V5H17V3H14V5H10V3ZM14 8V7H10V8H7V7H5V18H19V7H17V8H14ZM9 10H7V12H9V10ZM7 14H9V16H7V14ZM13 14H11V16H13V14ZM11 10H13V12H11V10ZM17 10H15V12H17V10Z" fill="#121117"/>
                </svg>
                <span style="margin-left: 4px;">20</span>
            </div>
            <span style="margin-top: 4px;" class="label-tex">years teaching</span>
        </div>
    </div>
    <div class="lesson-heading w-100" style="margin-block: 20px;">
            4 lessons every 4 weeks
    </div>
    <div class="lesson-bill-box w-100">
        <div class="d-flex justify-content-between">
            <p class="title-lesson">4 lessons x $5.00/lesson</p>
            <p class="bill-for-it"> $20.00</p>
        </div>
        <div class="d-flex justify-content-between">
            <p class="title-lesson"> Processing fee </p>
            <p class="bill-for-it"> $0.00</p>
        </div>
        <div class="d-flex justify-content-between">
            <p class="title-lesson"> Balance with Karen</p>
            <p class="bill-for-it">  -$4.50</p>
        </div>
        <div class="d-flex justify-content-between">
            <p class="title-lesson"> Your Latingles credit</p>
            <p class="bill-for-it">  -$15.50</p>
        </div>
    </div>
    <div class="total-text d-flex justify-content-between w-100" style="margin-top: 16px; margin-bottom: 20px" >
        <p>Total</p>
        <p>$0.00</p>
    </div>
    <div class="light-blue-container w-100 d-flex align-items-center" style="margin-bottom: 20px; gap: 12px">
        <div style="height: 24px; width: 24px; min-height: 24px; min-width: 24px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.291 4.055L12 2L8.709 4.055L4.929 4.929L4.055 8.709L2 12L4.055 15.291L4.929 19.071L8.709 19.945L12 22L15.291 19.945L19.071 19.071L19.945 15.291L22 12L19.945 8.709L19.071 4.929L15.291 4.055ZM9.793 15.707L10.5 16.414L11.207 15.707L17.207 9.707L15.793 8.293L10.5 13.586L8.207 11.293L6.793 12.707L9.793 15.707Z" fill="#121117"/>
            </svg>
        </div>
        <p>You can change your tutor for free or cancel your subscription at any time</p>
    </div>
    <div class="bd-box"></div>
    <div class="review-box">
        <h3>Renews automatically every 4 weeks</h3>
        <p>
        We will charge <b>$21.00</b> to your saved payment method to add 4 lessons every <b>4 weeks</b> unless you cancel your subscription</p>
    </div>
    <div class="bd-box"></div>
    <div class="total-text" style="margin-top: 16px;">Payment Method</div>
    <div class="payment-method-dropdown w-100" style="margin-top: 16px; margin-bottom: 20px;">
        <div class="selected-value">Your Latingles Credits</div>

        <div class="options-wrapper">
            <div class="payment-options">Your Latingles Credits</div>
            <div class="payment-options">Stripe</div>
            <div class="payment-options">PayPal</div>
        </div>
    </div>
    <p style="margin-bottom: 15px">Remaining credit after payment after <b>$81.50</b></p>

    <a href="#" class="btn action" data-open="transfer-balance-screen-7" data-close="transfer-balance-screen-6">Confirm</a>

</div>

<div class="what-would-you-like-to-do-modal transferComplete transfer-complete-modal custom-modal" id="transfer-balance-screen-7">
    <div class="closeIcon closeIcon-seven backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
    <div class="transferContainer">
        <div class="transferImage">
            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="22" viewBox="0 0 45 22" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.6669 11.0001L2.38991 21.2761L0.503906 19.3901L8.89391 11.0001L0.503906 2.61012L2.38991 0.724121L12.6669 11.0001ZM28.6669 11.0001L18.3899 21.2761L16.5039 19.3901L24.8939 11.0001L16.5039 2.61012L18.3899 0.724121L28.6669 11.0001ZM44.6669 11.0001L34.3899 21.2761L32.5039 19.3901L40.8939 11.0001L32.5039 2.61012L34.3899 0.724121L44.6669 11.0001Z"
                    fill="#FF2500"></path>
            </svg>
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
            <div class="numbersCountOnImage">+1</div>
        </div>
        <h1>Transfer complete</h1>
    </div>

    <div class="bottomPart">
        <div class="paragraphs">
            <p>
                Your <b>subscription with Daniela</b> has been <b>cancelled</b> and you won’t be charged again.
            </p>
            <br>
            <p>The 4-lesson subscription plan ($20.00 every 4 weeks) with Mitchell will start today.</p>
        </div>

        <div class="btns">
            <button class="btn backdrop-level-2-close closeIcon-one">Okay</button>
        </div>
    </div>
</div>

<div class="thank-you-note what-would-you-like-to-do-modal page5" id="thank-you-note" style="z-index: 7;">
    <div class="close-thank-you-note">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
    <p class="total-text">Add a thank you note to Maya to be sent after you switch</p>
    <textarea class="comment-box" id="thank-you-comment" style="margin-top: 20px"></textarea>
    <div class="container" style="margin-top: 20px;">
        <button class="btn" id="add-thank-you-note">Add a thank you note</button>
    </div>
</div>

<div class="what-would-you-like-to-do-modal transfer-to-modal custom-modal page2" id="transfer-balance-screen-2-x">
    <div class="backIcon backIcon-two back-modal back-action" data-open="transfer-balance-screen-1" data-close="transfer-balance-screen-2-x">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <h1 class="page2">Who would you like to switch to?</h1>

    <div class="container">
        <h4>Not subscribed yet</h4>

        <ul class="page2">
            <li class="page2 bd-down action" data-open="how-many-lessons-you-want-modal" data-close="transfer-balance-screen-2-x">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/1.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Mitchell</h3>
                        <p>12 lessons left · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
            <li class="page2 action" data-open="how-many-lessons-you-want-modal" data-close="transfer-balance-screen-2-x">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/2.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Bruce</h3>
                        <p>12 lessons left · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
            <li class="page2 action" data-open="how-many-lessons-you-want-modal" data-close="transfer-balance-screen-2-x">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/3.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Brandon</h3>
                        <p>12 lessons left · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
            <li class="page2 action" data-open="how-many-lessons-you-want-modal" data-close="transfer-balance-screen-2-x">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/4.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Pat</h3>
                        <p>12 lessons left · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
        </ul>
    </div>
     <div class="container">
        <h4>Cancelled subscriptions</h4>

        <ul class="page2">
            <li class="page2 bd-down action" data-open="how-many-lessons-you-want-modal" data-close="transfer-balance-screen-2-x">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/5.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Calvin</h3>
                        <p>subscriptions Cancelled · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
            <li class="page2 action" data-open="how-many-lessons-you-want-modal" data-close="transfer-balance-screen-2-x">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/6.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Lee</h3>
                        <p>subscriptions Cancelled · $2.5 per lesson</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="what-would-you-like-to-do-modal how-many-lessons-you-want-modal custom-modal"
    id="how-many-lessons-you-want-modal">
    <div class="backIcon back-action" data-close="how-many-lessons-you-want-modal" data-open="transfer-balance-screen-2-x">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-four backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z"
                    fill="#121117"></path>
            </svg>
        </div>
    </div>

    <h1>How many lessons do you want with Daniela?</h1>

    <div class="container">
        <div class="buttonGroup">
            <button class="btn decrement-lesson disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="2" viewBox="0 0 16 2" fill="none">
                    <path d="M0 0H16V2H0V0Z" fill="#6A697C"></path>
                </svg>
            </button>

            <div class="lessonCount-paragraph">
                <h1 class="lesson-count">0 lessons</h1>
                <p>$4.97 per lesson</p>
            </div>

            <button class="btn increment-lesson">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.98047 0H7.98047V7H0.980469V9H7.98047V16H9.98047V9H16.9805V7H9.98047V0Z" fill="#121117">
                    </path>
                </svg>
            </button>
        </div>

        <div class="sixLessonSelectedAndBalanceContainer">
            <div class="six-lesson-selected">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-info-icon lucide-info">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16v-4"></path>
                    <path d="M12 8h.01"></path>
                </svg>

                <p>
                    To get 6 lessons with Daniela, you'll need to pay a $0.37 price
                    difference
                </p>
            </div>

            <div class="balanceBox">
                <div class="balanceHeader">
                    <span>Balance: <strong>$29.44</strong></span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.333008 5.9999L3.66634 0.226562H10.333L13.6663 5.9999L10.333 11.7732H3.66634L0.333008 5.9999ZM6.99967 7.9999C7.53011 7.9999 8.03882 7.78918 8.41389 7.41411C8.78896 7.03904 8.99967 6.53033 8.99967 5.9999C8.99967 5.46946 8.78896 4.96075 8.41389 4.58568C8.03882 4.21061 7.53011 3.9999 6.99967 3.9999C6.46924 3.9999 5.96053 4.21061 5.58546 4.58568C5.21039 4.96075 4.99967 5.46946 4.99967 5.9999C4.99967 6.53033 5.21039 7.03904 5.58546 7.41411C5.96053 7.78918 6.46924 7.9999 6.99967 7.9999Z"
                                fill="#121117"></path>
                        </svg>
                        <strong class="balance-used">$0.00</strong> used
                    </span>
                </div>
                <div class="progress">
                    <div class="progress-fill lesson-progress" style="width: 0%;"></div>
                </div>
                <a href="#" class="show-breakdown-modal-open" id="show-breakdown-modal-open">Show breakdown</a>
            </div>
        </div>

        <a href="#" class="btn action"  data-open="transfer-balance-screen-3-x" data-close="how-many-lessons-you-want-modal">Continue</a>
    </div>
</div>

<div class="what-would-you-like-to-do-modal transfer-to-modal page3" id="transfer-balance-screen-3-x">
    <div class="backIcon backIcon-two back-modal back-action"  data-open="how-many-lessons-you-want-modal" data-close="transfer-balance-screen-3-x">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
    <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z" fill="#121117"></path>
            </svg>
        </div>
    </div>
    <h1 class="page2" style="margin-top: 8px;">Do you want to cancel your scheduled lessons with Daniela?</h1>

    <div class="container">

        <ul class="page3" style="margin-top: 20px !important;;margin-bottom: 24px !important;">
            <label class="w-100">
                <li class="page3">
                    <div class="leftSide">
                    <div class="content">
                            <p>APR</p>
                            <h3>19</h3>
                        </div>

                        <div class="content">
                            <h3>17:00 - 17:50</h3>
                            <p>50-min lesson</p>
                        </div>
                    </div>
                    <div class="boxes">
                           <div class="box1" id="check-count">1</div>
                    </div>
                </li>
            </label>
        </ul>
        <div style="display: flex; flex-direction: column; gap: 16px;" class="w-100">
            <button href="#" class="btn action show-thank-you-event" id="cancel-selected-lesson"  data-open="transfer-balance-screen-4-x" data-close="transfer-balance-screen-3-x">Continue</button>
        </div>
    </div>

</div>

<div class="what-would-you-like-to-do-modal transfer-to-modal page4" id="transfer-balance-screen-4-x">
    <div class="backIcon backIcon-two back-modal back-action"  data-open="transfer-balance-screen-3-x" data-close="transfer-balance-screen-4-x">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
    <img src="https://dev.latingles.com/img/subs/2.png" alt="" height="48px" width="48px" style="margin-bottom: 8px;">
    <h1 class="page2">To transfer lessons, you need to start a subscription with Bruce</h1>
    <p>Your first payment will happen on January 6. You can cancel anytime.</p>
    <div class="container">

        <ul class="page4" style="margin-top: 20px !important;margin-bottom: 24px !important;">
                <li class="page4 action" data-open="review-modal-screen" data-close="transfer-balance-screen-4-x">
                    <div class="leftSide">

                        <div class="content">
                            <h3>1 lessons</h3>
                            <p>$20 every 4 weeks</p>
                        </div>
                    </div>
                </li>
                 <li class="page4 action" data-open="review-modal-screen" data-close="transfer-balance-screen-4-x">
                    <div class="leftSide">

                        <div class="content">
                            <h3>2 lessons</h3>
                            <p>$40 every 4 weeks</p>
                        </div>
                    </div>
                </li>
                 <li class="page4">
                    <div class="leftSide action" data-open="review-modal-screen" data-close="transfer-balance-screen-4-x">

                        <div class="content">
                            <h3>3 lessons</h3>
                            <p>$60 every 4 weeks</p>
                        </div>
                    </div>
                </li>
                  <li class="page4">
                    <div class="leftSide action" data-open="review-modal-screen" data-close="transfer-balance-screen-4-x">

                        <div class="content">
                            <h3>4 lessons</h3>
                            <p>$80 every 4 weeks</p>
                        </div>
                    </div>
                </li>
           
        </ul>
    </div>

</div>

<div id="review-modal-screen" class="what-would-you-like-to-do-modal how-many-lessons-you-want-modal review-your-transfer-modal custom-modal">
    <div class="backIcon backIcon-six back-action" data-open="transfer-balance-screen-4-x" data-close="review-modal-screen">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-six backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z"
                    fill="#121117"></path>
            </svg>
        </div>
    </div>

    <h1 style="margin-bottom: 0px !important;">Review your transfer</h1>

    <!-- balance container -->
    <div class="container" style="margin-top: 10px !important;">
        <div class="row">
            <span>Balance with Wade Warren</span>
            <span style="font-weight: 500">$29.44</span>
        </div>
        <div class="row" style="margin-bottom: 19px">
            <span>5 lessons with Daniela</span>
            <span style="font-weight: 500">$24.84</span>
        </div>
    </div>

    <!-- balanceBox -->
    <div class="balance-box" style="margin-top: 15px !important;">
        <div class="row">
            <span class="extra-message">Price difference</span>
            <span>
                <strong class="extra-price" style="font-weight: 500">-$2.76</strong>
            </span>
        </div>
    </div>

    <div class="whatHappensNext">
        <h1 style="font-size: 20px; font-weight: 600">What happens next?</h1>
        <ul class="what-happens-next-list-content">
            <li>You'll get <span>5 lessons ($24.84) with Daniela.</span> after you pay a $2.76 difference.</li>
            <li>Your first subscription payment with Bruce will happen on January 6 (4 lessons • $20.00 every 4 weeks)</li>
            <li>All your scheduled lessons with Daniela will be cancelled but your subscription will remain active.</li>
            <li>The remaining $1.00 will be added to your Latingles credit. You’ll see it at checkout during your next payment.</li>
        </ul>
    </div>

    <button class="btn transfer-complete-modal-Open action" id="transfer-complete-modal-open" style="margin-top: 24px;" data-open="transfer-balance-screen-6-x" data-close="review-modal-screen">Continue to checkout</button>
</div>

<div class="what-would-you-like-to-do-modal transfer-to-modal page6" id="transfer-balance-screen-6-x" style="height: 732px;">
    <div class="backIcon backIcon-two back-modal back-action"  data-open="review-modal-screen" data-close="transfer-balance-screen-6-x">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
    <div class="profile-details-container">
        <img src="https://dev.latingles.com/img/subs/1.png" alt="" height="64px" width="64px" style="margin-bottom: 8px;">
        <div class="container-details-profile">
                <div class="top-header">
                    <div class="teacher-text"> Daniela </div>
                    <svg width="24" height="19" viewBox="0 0 24 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_20545_58769_u2)">
                            <g clip-path="url(#clip1_20545_58769_u2)">
                            <mask id="mask0_20545_58769_u2"
                                    style="mask-type:luminance"
                                    maskUnits="userSpaceOnUse"
                                    x="-1" y="0" width="26" height="19">
                                <path d="M-0.0078125 0.25H24.0563V18.298H-0.0078125V0.25Z" fill="white"/>
                            </mask>

                            <g mask="url(#mask0_20545_58769_u2)">
                                <path d="M-6.02344 0.25H30.0733V18.2984H-6.02344V0.25Z" fill="#000066"/>
                                <path d="M-6.02344 0.25V2.26785L26.0377 18.2984H30.0733V16.2806L-1.98784 0.25H-6.02344ZM30.0733 0.25V2.26782L-1.98784 18.2984H-6.02344V16.2805L26.0377 0.25H30.0733Z" fill="white"/>
                                <path d="M9.01686 0.25V18.2984H15.033V0.25H9.01686ZM-6.02344 6.26612V12.2822H30.0733V6.26612H-6.02344Z" fill="white"/>
                                <path d="M-6.02344 7.46934V11.079H30.0733V7.46934H-6.02344ZM10.2201 0.25V18.2984H13.8297V0.25H10.2201ZM-6.02344 18.2984L6.0088 12.2822H8.69922L-3.33302 18.2984H-6.02344ZM-6.02344 0.25L6.0088 6.26612H3.31838L-6.02344 1.59528V0.25ZM15.3506 6.26612L27.3828 0.25H30.0733L18.041 6.26612H15.3506ZM30.0733 18.2984L18.041 12.2822H20.7315L30.0733 16.9531V18.2984Z" fill="#CC0000"/>
                            </g>
                            </g>
                        </g>

                        <rect x="0.5" y="0.5" width="23" height="17.5" rx="1.5"
                                stroke="#121117" stroke-opacity="0.56"/>

                        <defs>
                            <clipPath id="clip0_20545_58769_u2">
                            <rect width="24" height="18.5" rx="2" fill="white"/>
                            </clipPath>

                            <clipPath id="clip1_20545_58769_u2">
                            <rect width="24" height="18" fill="white" transform="translate(0 0.25)"/>
                            </clipPath>
                        </defs>
                    </svg>

                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3H4V18L12 22L20 18V3H12ZM10.5 15.414L17.207 8.707L15.793 7.293L10.5 12.586L8.207 10.293L6.793 11.707L10.5 15.414Z" fill="#121117"/>
                    </svg>

                </div>
                <div class="bottom-section">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.99964 2L9.4803 5.96133L13.7056 6.146L10.3956 8.77933L11.5263 12.854L7.99964 10.52L4.47297 12.854L5.60297 8.77867L2.29297 6.14533L6.5183 5.96133L7.99964 2Z" fill="#121117"/>
                    </svg>
                    <span class="rating">5</span>
                    <span style="margin-left: 8px">(65 reviews)</span>
                </div>
        </div>
    </div>
    <div class="duty-info" style="margin-top: 20px;">
        <div class="info-teacher">
            <div class="info-first" style="margin-left: 4px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 21L5 17.2V11.2L1 9L12 3L23 9V17H21V10.1L19 11.2V17.2L12 21ZM12 12.7L18.85 9L12 5.3L5.15 9L12 12.7ZM12 18.725L17 16.025V12.25L12 15L7 12.25V16.025L12 18.725Z" fill="#121117"/>
                </svg>
                <span style="margin-left: 4px;">17</span>
            </div>
            <span style="margin-top: 4px;" class="label-tex">Students</span>
        </div>
        <div class="info-teacher">
            <div class="info-first">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.41 12.823L6.802 8.218L4.681 8.924L1.5 5.742L4.682 4.682L5.742 1.5L8.925 4.682L8.166 6.855L12.772 11.46L11.41 12.823ZM9.41 2.338L11.12 4.048C12.7689 3.86585 14.4336 4.20078 15.8837 5.00643C17.3338 5.81208 18.4976 7.0486 19.214 8.54483C19.9304 10.0411 20.1639 11.723 19.8823 13.3578C19.6007 14.9926 18.8178 16.4994 17.642 17.6697C16.4663 18.84 14.9558 19.6158 13.3197 19.8898C11.6836 20.1637 10.0028 19.9223 8.50991 19.1989C7.01705 18.4756 5.78599 17.306 4.98713 15.8521C4.18827 14.3982 3.86113 12.732 4.051 11.084L2.347 9.38C2.11607 10.2342 1.99938 11.1152 2 12C2 17.523 6.477 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2C11.105 2 10.237 2.118 9.411 2.338H9.41ZM6.206 10.431L8.006 12.231C8.05069 13.0049 8.31927 13.7491 8.77907 14.3731C9.23887 14.9971 9.87008 15.4742 10.596 15.7461C11.3218 16.0181 12.1111 16.0733 12.8677 15.905C13.6244 15.7367 14.3159 15.3522 14.858 14.7982C15.4002 14.2442 15.7698 13.5447 15.9217 12.7846C16.0737 12.0245 16.0015 11.2366 15.714 10.5167C15.4265 9.79688 14.936 9.17607 14.3022 8.7298C13.6684 8.28353 12.9186 8.03103 12.144 8.003L10.366 6.225C11.641 5.86472 12.9995 5.93661 14.2294 6.42946C15.4592 6.92231 16.4914 7.8084 17.1648 8.94947C17.8382 10.0905 18.115 11.4224 17.9519 12.7373C17.7888 14.0522 17.1951 15.2761 16.2634 16.2182C15.3317 17.1602 14.1144 17.7673 12.8013 17.9448C11.4883 18.1223 10.1535 17.8602 9.00507 17.1994C7.85666 16.5386 6.95928 15.5163 6.45293 14.2919C5.94659 13.0675 5.85976 11.7099 6.206 10.431Z" fill="#121117"/>
                </svg>
                <span style="margin-left: 4px;">3128</span>
            </div>
            <span style="margin-top: 4px;" class="label-tex">lessons completed</span>
        </div>
        <div class="info-teacher">
            <div class="info-first">
               <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 3H7V5H3V20H21V5H17V3H14V5H10V3ZM14 8V7H10V8H7V7H5V18H19V7H17V8H14ZM9 10H7V12H9V10ZM7 14H9V16H7V14ZM13 14H11V16H13V14ZM11 10H13V12H11V10ZM17 10H15V12H17V10Z" fill="#121117"/>
                </svg>
                <span style="margin-left: 4px;">20</span>
            </div>
            <span style="margin-top: 4px;" class="label-tex">years teaching</span>
        </div>
    </div>
    <div class="lesson-heading w-100" style="margin-block: 20px;">
            4 lessons every 4 weeks
    </div>
    <div class="lesson-bill-box w-100">
        <div class="d-flex justify-content-between">
            <p class="title-lesson">4 lessons x $5.00/lesson</p>
            <p class="bill-for-it"> $20.00</p>
        </div>
        <div class="d-flex justify-content-between">
            <p class="title-lesson"> Processing fee </p>
            <p class="bill-for-it"> $0.00</p>
        </div>
        <div class="d-flex justify-content-between">
            <p class="title-lesson"> Balance with Karen</p>
            <p class="bill-for-it">  -$4.50</p>
        </div>
        <div class="d-flex justify-content-between">
            <p class="title-lesson"> Your Latingles credit</p>
            <p class="bill-for-it">  -$15.50</p>
        </div>
    </div>
    <div class="total-text d-flex justify-content-between w-100" style="margin-top: 16px; margin-bottom: 20px" >
        <p>Total</p>
        <p>$0.00</p>
    </div>
    <div class="light-blue-container w-100 d-flex align-items-center" style="margin-bottom: 20px; gap: 12px">
        <div style="height: 24px; width: 24px; min-height: 24px; min-width: 24px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.291 4.055L12 2L8.709 4.055L4.929 4.929L4.055 8.709L2 12L4.055 15.291L4.929 19.071L8.709 19.945L12 22L15.291 19.945L19.071 19.071L19.945 15.291L22 12L19.945 8.709L19.071 4.929L15.291 4.055ZM9.793 15.707L10.5 16.414L11.207 15.707L17.207 9.707L15.793 8.293L10.5 13.586L8.207 11.293L6.793 12.707L9.793 15.707Z" fill="#121117"/>
            </svg>
        </div>
        <p>You can change your tutor for free or cancel your subscription at any time</p>
    </div>
    <div class="bd-box"></div>
    <div class="review-box">
        <h3>Renews automatically every 4 weeks</h3>
        <p>
        We will charge <b>$21.00</b> to your saved payment method to add 4 lessons every <b>4 weeks</b> unless you cancel your subscription</p>
    </div>
    <div class="bd-box"></div>
    <div class="total-text" style="margin-top: 16px;">Payment Method</div>
    <div class="payment-method-dropdown w-100" style="margin-top: 16px; margin-bottom: 20px;">
        <div class="selected-value">Your Latingles Credits</div>

        <div class="options-wrapper">
            <div class="payment-options">Your Latingles Credits</div>
            <div class="payment-options">Stripe</div>
            <div class="payment-options">PayPal</div>
        </div>
    </div>
    <p style="margin-bottom: 15px">Remaining credit after payment after <b>$81.50</b></p>

    <a href="#" class="btn action" data-open="transfer-balance-screen-7" data-close="transfer-balance-screen-6-x">Confirm</a>

</div>

<div class="what-would-you-like-to-do-modal how-many-lessons-you-want-modal custom-modal"
    id="how-many-lessons-you-want-modal-x">
    <div class="backIcon back-action" data-close="how-many-lessons-you-want-modal-x" data-open="transfer-balance-screen-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-four backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z"
                    fill="#121117"></path>
            </svg>
        </div>
    </div>

    <h1>How many lessons do you want with Daniela?</h1>

    <div class="container">
        <div class="buttonGroup">
            <button class="btn decrement-lesson disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="2" viewBox="0 0 16 2" fill="none">
                    <path d="M0 0H16V2H0V0Z" fill="#6A697C"></path>
                </svg>
            </button>

            <div class="lessonCount-paragraph">
                <h1 class="lesson-count">0 lessons</h1>
                <p>$4.97 per lesson</p>
            </div>

            <button class="btn increment-lesson">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.98047 0H7.98047V7H0.980469V9H7.98047V16H9.98047V9H16.9805V7H9.98047V0Z" fill="#121117">
                    </path>
                </svg>
            </button>
        </div>

        <div class="sixLessonSelectedAndBalanceContainer">
            <div class="six-lesson-selected">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-info-icon lucide-info">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16v-4"></path>
                    <path d="M12 8h.01"></path>
                </svg>

                <p>
                    To get 6 lessons with Daniela, you'll need to pay a $0.37 price
                    difference
                </p>
            </div>

            <div class="balanceBox">
                <div class="balanceHeader">
                    <span>Balance: <strong>$29.44</strong></span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.333008 5.9999L3.66634 0.226562H10.333L13.6663 5.9999L10.333 11.7732H3.66634L0.333008 5.9999ZM6.99967 7.9999C7.53011 7.9999 8.03882 7.78918 8.41389 7.41411C8.78896 7.03904 8.99967 6.53033 8.99967 5.9999C8.99967 5.46946 8.78896 4.96075 8.41389 4.58568C8.03882 4.21061 7.53011 3.9999 6.99967 3.9999C6.46924 3.9999 5.96053 4.21061 5.58546 4.58568C5.21039 4.96075 4.99967 5.46946 4.99967 5.9999C4.99967 6.53033 5.21039 7.03904 5.58546 7.41411C5.96053 7.78918 6.46924 7.9999 6.99967 7.9999Z"
                                fill="#121117"></path>
                        </svg>
                        <strong class="balance-used">$0.00</strong> used
                    </span>
                </div>
                <div class="progress">
                    <div class="progress-fill lesson-progress" style="width: 0%;"></div>
                </div>
                <a href="#" class="show-breakdown-modal-open" id="show-breakdown-modal-open">Show breakdown</a>
            </div>
        </div>

        <a href="#" class="btn action"  data-open="transfer-balance-screen-3-2x" data-close="how-many-lessons-you-want-modal-x">Continue</a>
    </div>
</div>

<div class="what-would-you-like-to-do-modal transfer-to-modal page3" id="transfer-balance-screen-3-2x">
    <div class="backIcon backIcon-two back-modal back-action"  data-open="how-many-lessons-you-want-modal-x" data-close="transfer-balance-screen-3-2x">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-one backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>
    <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z" fill="#121117"></path>
            </svg>
        </div>
    </div>
    <h1 class="page2" style="margin-top: 8px;">Do you want to cancel your scheduled lessons with Daniela?</h1>

    <div class="container">

        <ul class="page3" style="margin-top: 20px !important;;margin-bottom: 24px !important;">
            <label class="w-100">
                <li class="page3">
                    <div class="leftSide">
                    <div class="content">
                            <p>APR</p>
                            <h3>19</h3>
                        </div>

                        <div class="content">
                            <h3>17:00 - 17:50</h3>
                            <p>50-min lesson</p>
                        </div>
                    </div>
                    <div class="boxes">
                           <div class="box1" id="check-count">1</div>
                    </div>
                </li>
            </label>
        </ul>
        <div style="display: flex; flex-direction: column; gap: 16px;" class="w-100">
            <button href="#" class="btn action show-thank-you-event" id="cancel-selected-lesson"  data-open="review-modal-screen-x" data-close="transfer-balance-screen-3-2x">Continue</button>
        </div>
    </div>

</div>

<div id="review-modal-screen-x" class="what-would-you-like-to-do-modal how-many-lessons-you-want-modal review-your-transfer-modal custom-modal">
    <div class="backIcon backIcon-six back-action" data-open="transfer-balance-screen-3-2x" data-close="review-modal-screen-x">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-six backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z"
                    fill="#121117"></path>
            </svg>
        </div>
    </div>

    <h1 style="margin-bottom: 0px !important;">Review your transfer</h1>

    <!-- balance container -->
    <div class="container" style="margin-top: 10px !important;">
        <div class="row">
            <span>Balance with Wade Warren</span>
            <span style="font-weight: 500">$29.44</span>
        </div>
        <div class="row" style="margin-bottom: 19px">
            <span>5 lessons with Daniela</span>
            <span style="font-weight: 500">$24.84</span>
        </div>
    </div>

    <!-- balanceBox -->
    <div class="balance-box" style="margin-top: 15px !important;">
        <div class="row">
            <span class="extra-message">Price difference</span>
            <span>
                <strong class="extra-price" style="font-weight: 500">-$2.76</strong>
            </span>
        </div>
    </div>

    <div class="whatHappensNext">
        <h1 style="font-size: 20px; font-weight: 600">What happens next?</h1>
        <ul class="what-happens-next-list-content">
            <li>You'll get <span>5 lessons ($24.84) with Daniela.</span> after you pay a $2.76 difference.</li>
            <li>Your first subscription payment with Bruce will happen on January 6 (4 lessons • $20.00 every 4 weeks)</li>
            <li>All your scheduled lessons with Daniela will be cancelled but your subscription will remain active.</li>
            <li>The remaining $1.00 will be added to your Latingles credit. You’ll see it at checkout during your next payment.</li>
        </ul>
    </div>

    <button class="btn transfer-complete-modal-Open action" id="transfer-complete-modal-open" style="margin-top: 24px;" data-open="transfer-balance-screen-7" data-close="review-modal-screen-x">Confirm</button>
</div>

<div id="review-modal-screen-2-x" class="what-would-you-like-to-do-modal how-many-lessons-you-want-modal review-your-transfer-modal custom-modal">
    <div class="backIcon backIcon-six back-action" data-open="choose-your-trial-lesson-duration-modal" data-close="review-modal-screen-2-x">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-six backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z"
                    fill="#121117"></path>
            </svg>
        </div>
    </div>

    <h1 style="margin-bottom: 0px !important;">Review your transfer</h1>

    <!-- balance container -->
    <div class="container" style="margin-top: 10px !important;">
        <div class="row">
            <span>Balance with Wade Warren</span>
            <span style="font-weight: 500">$29.44</span>
        </div>
        <div class="row" style="margin-bottom: 19px">
            <span>5 lessons with Daniela</span>
            <span style="font-weight: 500">$24.84</span>
        </div>
    </div>

    <!-- balanceBox -->
    <div class="balance-box" style="margin-top: 15px !important;">
        <div class="row">
            <span class="extra-message">Remaining balance with Daniela</span>
            <span>
                <strong class="extra-price" style="font-weight: 500">-$2.76</strong>
            </span>
        </div>
    </div>

    <div class="whatHappensNext">
        <h1 style="font-size: 20px; font-weight: 600">What happens next?</h1>
        <ul class="what-happens-next-list-content">
            <li>You'll get <span>5 lessons ($24.84) with Daniela.</span> after you pay a $2.76 difference.</li>
            <li>Your first subscription payment with Bruce will happen on January 6 (4 lessons • $20.00 every 4 weeks)</li>
            <li>All your scheduled lessons with Daniela will be cancelled but your subscription will remain active.</li>
            <li>The remaining $1.00 will be added to your Latingles credit. You’ll see it at checkout during your next payment.</li>
        </ul>
    </div>

    <button class="btn action" style="margin-top: 24px;" data-open="transfer-balance-screen-7" data-close="review-modal-screen-2-x">Confirm</button>
</div>
<!-- new closed -->

<div class="what-would-you-like-to-do-modal transfer-from-modal custom-modal" id="transfer-from-modal">
    <div class="backIcon backIcon-one back-modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-two backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <h1>Transfer from</h1>

    <ul>
        <li class="transfer-to-modal-open">
            <div class="leftSide">
                <div class="imageContainer">
                    <img src="https://dev.latingles.com/img/subs/2.png" alt="">
                </div>

                <div class="content">
                    <h3>Wade Warren</h3>
                    <p>29$ to transfer</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="transfer-to-modal-open">
            <div class="leftSide">
                <div class="imageContainer">
                    <img src="https://dev.latingles.com/img/subs/9-1.png" alt="">
                </div>

                <div class="content">
                    <h3>Karen V.</h3>
                    <p>38$ to transfer</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="transfer-to-modal-open">
            <div class="leftSide">
                <div class="imageContainer">
                    <img src="https://dev.latingles.com/img/subs/12-1.png" alt="">
                </div>

                <div class="content">
                    <h3>David</h3>
                    <p>134$ to transfer</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
    </ul>
</div>


<div class="show-break-down-modal custom-modal" id="show-break-down-modal">
    <div class="closeIcon closeIcon-five backdrop-level-3-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="content">
        <div class="shortDetail">
            <div class="imageContainer">
                <img src="https://dev.latingles.com/img/subs/1.png" alt="">
            </div>

            <div class="titleAndPrice">
                <h1>Your balance with Daniela</h1>
                <p>Price per lesson: $7.36</p>
            </div>
        </div>

        <div class="details">
            <ul>
                <li>
                    <p>4 unscheduled lessons</p>
                    <h1>$29.44</h1>
                </li>
                <li>
                    <p>0 scheduled lessons</p>
                    <h1>$0.00</h1>
                </li>
                <li>
                    <p>Amount used for transfer</p>
                    <h1 class="amount-used">-$29.44</h1>
                </li>
            </ul>

            <div class="divider"></div>

            <div class="total">
                <h1 class="remaining-balance-text-change">Amount to pay</h1>

                <p class="remaining-balance greenColor redColor">$0.37</p>
            </div>
        </div>

        <button class="backdrop-level-3-close closeIcon-five">Close</button>
    </div>
</div>


<div class="what-would-you-like-to-do-modal transfer-remaining-balance-transfer-to custom-modal"
    id="transfer-remaining-balance-transfer-to">
    <div class="backIcon back-modal back-action" data-open="transfer-balance-screen-1" data-close="transfer-remaining-balance-transfer-to">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-nine backdrop-level-2-close ">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <h1>Choose a tutor for your trial lesson</h1>

    <span>Recommended</span>

    <div class="recommendedContainer">
        <div class="tutors-info-container">
            <div class="tutor-profile">
                <img src="https://dev.latingles.com/img/subs/9-1.png" alt="">
                <div class="tutor-profile-content">
                    <div class="name-country">
                        <p>Karen V.</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.291 2.055L10 0L6.709 2.055L2.929 2.929L2.055 6.709L0 10L2.055 13.291L2.929 17.071L6.709 17.945L10 20L13.291 17.945L17.071 17.071L17.945 13.291L20 10L17.945 6.709L17.071 2.929L13.291 2.055ZM7.793 13.707L8.5 14.414L9.207 13.707L15.207 7.707L13.793 6.293L8.5 11.586L6.207 9.293L4.793 10.707L7.793 13.707Z"
                                fill="#121117"></path>
                        </svg>
                        <img src="https://dev.latingles.com/img/subs/flag/1.png" alt="">
                    </div>
                    <div class="rate-amount">
                        <div class="leftSide">
                            <div class="rating">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                    fill="none">
                                    <path
                                        d="M6 0L7.48067 3.96133L11.706 4.146L8.396 6.77933L9.52667 10.854L6 8.52L2.47334 10.854L3.60333 6.77867L0.293335 4.14533L4.51867 3.96133L6 0Z"
                                        fill="#121117"></path>
                                </svg>
                                <span>5</span>
                            </div>
                            <p>131 reviews</p>
                        </div>
                        <div class="rightSide">
                            <h3>$26.68</h3>
                            <p>50 min lesson</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="super-tutor-tag">Super tutor</div>
            <div class="aboutTutor">
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                        <path
                            d="M11 18L4 14.2V8.2L0 6L11 0L22 6V14H20V7.1L18 8.2V14.2L11 18ZM11 9.7L17.85 6L11 2.3L4.15 6L11 9.7ZM11 15.725L16 13.025V9.25L11 12L6 9.25V13.025L11 15.725Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>English tutor</span>
                </div>
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8 8C7.20435 8 6.44129 7.68393 5.87868 7.12132C5.31607 6.55871 5 5.79565 5 5C5 4.20435 5.31607 3.44129 5.87868 2.87868C6.44129 2.31607 7.20435 2 8 2C8.79565 2 9.55871 2.31607 10.1213 2.87868C10.6839 3.44129 11 4.20435 11 5C11 5.79565 10.6839 6.55871 10.1213 7.12132C9.55871 7.68393 8.79565 8 8 8ZM3 5C3 3.67392 3.52678 2.40215 4.46447 1.46447C5.40215 0.526784 6.67392 0 8 0C9.32608 0 10.5979 0.526784 11.5355 1.46447C12.4732 2.40215 13 3.67392 13 5C13 6.32608 12.4732 7.59785 11.5355 8.53553C10.5979 9.47322 9.32608 10 8 10C6.67392 10 5.40215 9.47322 4.46447 8.53553C3.52678 7.59785 3 6.32608 3 5ZM16 18V12H0V18H16Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>59 students ⸱ 5,065 lessons</span>
                </div>
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7 0H5V2H0V4H8.015C7.96808 5.52045 7.51432 7.00051 6.701 8.286L3.707 5.293L2.293 6.707L5.459 9.873C5.162 10.185 4.853 10.473 4.541 10.738C3.4667 11.6408 2.26553 12.3807 0.976 12.934C0.877766 12.9756 0.778748 13.0152 0.679 13.053L0.667 13.057L1 14L1.334 14.943L1.338 14.941L1.345 14.939L1.37 14.929C1.49896 14.8816 1.62667 14.831 1.753 14.777C3.22972 14.1446 4.6049 13.2974 5.834 12.263C6.184 11.966 6.533 11.641 6.873 11.287L8.293 12.707L9.707 11.293L8.144 9.73C9.31489 8.04408 9.96605 6.052 10.017 4H12V2H7V0ZM15.253 17L14.656 15.404H11.34L10.74 17H8.7L11.964 8.6H14.028L17.293 17H15.253ZM12.998 10.973L14.018 13.7H11.977L12.997 10.973H12.998Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>Speaks English (Native) +4</span>
                </div>
            </div>
            <div class="btns">
                <button class="btn action bd-2px book-balance-btn" data-open="choose-your-trial-lesson-duration-modal" data-close="transfer-remaining-balance-transfer-to">
                    Book with my balance
                </button>
                <a href="../local/customplugin/my_lessons_tutor_profile.php" class="btn bd-2px-light book-balance-btn">View profile</a>
            </div>
        </div>

        <div class="tutors-info-container">
            <div class="tutor-profile">
                <img src="https://dev.latingles.com/img/subs/12-1.png" alt="">
                <div class="tutor-profile-content">
                    <div class="name-country">
                        <p>Cameron Williamson</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.291 2.055L10 0L6.709 2.055L2.929 2.929L2.055 6.709L0 10L2.055 13.291L2.929 17.071L6.709 17.945L10 20L13.291 17.945L17.071 17.071L17.945 13.291L20 10L17.945 6.709L17.071 2.929L13.291 2.055ZM7.793 13.707L8.5 14.414L9.207 13.707L15.207 7.707L13.793 6.293L8.5 11.586L6.207 9.293L4.793 10.707L7.793 13.707Z"
                                fill="#121117"></path>
                        </svg>
                        <img src="https://dev.latingles.com/img/subs/flag/1.png" alt="">
                    </div>
                    <div class="rate-amount">
                        <div class="leftSide">
                            <div class="rating">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                    fill="none">
                                    <path
                                        d="M6 0L7.48067 3.96133L11.706 4.146L8.396 6.77933L9.52667 10.854L6 8.52L2.47334 10.854L3.60333 6.77867L0.293335 4.14533L4.51867 3.96133L6 0Z"
                                        fill="#121117"></path>
                                </svg>
                                <span>0</span>
                            </div>
                            <p>93 reviews</p>
                        </div>
                        <div class="rightSide">
                            <h3>$27.60</h3>
                            <p>50 min lesson</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="super-tutor-tag">Super tutor</div>
            <div class="aboutTutor">
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                        <path
                            d="M11 18L4 14.2V8.2L0 6L11 0L22 6V14H20V7.1L18 8.2V14.2L11 18ZM11 9.7L17.85 6L11 2.3L4.15 6L11 9.7ZM11 15.725L16 13.025V9.25L11 12L6 9.25V13.025L11 15.725Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>English tutor</span>
                </div>
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8 8C7.20435 8 6.44129 7.68393 5.87868 7.12132C5.31607 6.55871 5 5.79565 5 5C5 4.20435 5.31607 3.44129 5.87868 2.87868C6.44129 2.31607 7.20435 2 8 2C8.79565 2 9.55871 2.31607 10.1213 2.87868C10.6839 3.44129 11 4.20435 11 5C11 5.79565 10.6839 6.55871 10.1213 7.12132C9.55871 7.68393 8.79565 8 8 8ZM3 5C3 3.67392 3.52678 2.40215 4.46447 1.46447C5.40215 0.526784 6.67392 0 8 0C9.32608 0 10.5979 0.526784 11.5355 1.46447C12.4732 2.40215 13 3.67392 13 5C13 6.32608 12.4732 7.59785 11.5355 8.53553C10.5979 9.47322 9.32608 10 8 10C6.67392 10 5.40215 9.47322 4.46447 8.53553C3.52678 7.59785 3 6.32608 3 5ZM16 18V12H0V18H16Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>59 students ⸱ 5,065 lessons</span>
                </div>
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7 0H5V2H0V4H8.015C7.96808 5.52045 7.51432 7.00051 6.701 8.286L3.707 5.293L2.293 6.707L5.459 9.873C5.162 10.185 4.853 10.473 4.541 10.738C3.4667 11.6408 2.26553 12.3807 0.976 12.934C0.877766 12.9756 0.778748 13.0152 0.679 13.053L0.667 13.057L1 14L1.334 14.943L1.338 14.941L1.345 14.939L1.37 14.929C1.49896 14.8816 1.62667 14.831 1.753 14.777C3.22972 14.1446 4.6049 13.2974 5.834 12.263C6.184 11.966 6.533 11.641 6.873 11.287L8.293 12.707L9.707 11.293L8.144 9.73C9.31489 8.04408 9.96605 6.052 10.017 4H12V2H7V0ZM15.253 17L14.656 15.404H11.34L10.74 17H8.7L11.964 8.6H14.028L17.293 17H15.253ZM12.998 10.973L14.018 13.7H11.977L12.997 10.973H12.998Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>Speaks English (Native) +4</span>
                </div>
            </div>
            <div class="btns">
                <button class="btn action bd-2px book-balance-btn" data-open="choose-your-trial-lesson-duration-modal" data-close="transfer-remaining-balance-transfer-to">
                    Book with my balance
                </button>
                <a href="../local/customplugin/my_lessons_tutor_profile.php" class="btn bd-2px-light book-balance-btn">View profile</a>
            </div>
        </div>

        <div class="tutors-info-container">
            <div class="tutor-profile">
                <img src="https://dev.latingles.com/img/subs/14.png" alt="">
                <div class="tutor-profile-content">
                    <div class="name-country">
                        <p>Dianne Russell</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.291 2.055L10 0L6.709 2.055L2.929 2.929L2.055 6.709L0 10L2.055 13.291L2.929 17.071L6.709 17.945L10 20L13.291 17.945L17.071 17.071L17.945 13.291L20 10L17.945 6.709L17.071 2.929L13.291 2.055ZM7.793 13.707L8.5 14.414L9.207 13.707L15.207 7.707L13.793 6.293L8.5 11.586L6.207 9.293L4.793 10.707L7.793 13.707Z"
                                fill="#121117"></path>
                        </svg>
                        <img src="https://dev.latingles.com/img/subs/flag/2.png" alt="">
                    </div>
                    <div class="rate-amount">
                        <div class="leftSide">
                            <div class="rating">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                    fill="none">
                                    <path
                                        d="M6 0L7.48067 3.96133L11.706 4.146L8.396 6.77933L9.52667 10.854L6 8.52L2.47334 10.854L3.60333 6.77867L0.293335 4.14533L4.51867 3.96133L6 0Z"
                                        fill="#121117"></path>
                                </svg>
                                <span>5</span>
                            </div>
                            <p>27 reviews</p>
                        </div>
                        <div class="rightSide">
                            <h3>$19.32</h3>
                            <p>50 min lesson</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="super-tutor-tag">Super tutor</div>
            <div class="aboutTutor">
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                        <path
                            d="M11 18L4 14.2V8.2L0 6L11 0L22 6V14H20V7.1L18 8.2V14.2L11 18ZM11 9.7L17.85 6L11 2.3L4.15 6L11 9.7ZM11 15.725L16 13.025V9.25L11 12L6 9.25V13.025L11 15.725Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>English tutor</span>
                </div>
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8 8C7.20435 8 6.44129 7.68393 5.87868 7.12132C5.31607 6.55871 5 5.79565 5 5C5 4.20435 5.31607 3.44129 5.87868 2.87868C6.44129 2.31607 7.20435 2 8 2C8.79565 2 9.55871 2.31607 10.1213 2.87868C10.6839 3.44129 11 4.20435 11 5C11 5.79565 10.6839 6.55871 10.1213 7.12132C9.55871 7.68393 8.79565 8 8 8ZM3 5C3 3.67392 3.52678 2.40215 4.46447 1.46447C5.40215 0.526784 6.67392 0 8 0C9.32608 0 10.5979 0.526784 11.5355 1.46447C12.4732 2.40215 13 3.67392 13 5C13 6.32608 12.4732 7.59785 11.5355 8.53553C10.5979 9.47322 9.32608 10 8 10C6.67392 10 5.40215 9.47322 4.46447 8.53553C3.52678 7.59785 3 6.32608 3 5ZM16 18V12H0V18H16Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>59 students ⸱ 5,065 lessons</span>
                </div>
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7 0H5V2H0V4H8.015C7.96808 5.52045 7.51432 7.00051 6.701 8.286L3.707 5.293L2.293 6.707L5.459 9.873C5.162 10.185 4.853 10.473 4.541 10.738C3.4667 11.6408 2.26553 12.3807 0.976 12.934C0.877766 12.9756 0.778748 13.0152 0.679 13.053L0.667 13.057L1 14L1.334 14.943L1.338 14.941L1.345 14.939L1.37 14.929C1.49896 14.8816 1.62667 14.831 1.753 14.777C3.22972 14.1446 4.6049 13.2974 5.834 12.263C6.184 11.966 6.533 11.641 6.873 11.287L8.293 12.707L9.707 11.293L8.144 9.73C9.31489 8.04408 9.96605 6.052 10.017 4H12V2H7V0ZM15.253 17L14.656 15.404H11.34L10.74 17H8.7L11.964 8.6H14.028L17.293 17H15.253ZM12.998 10.973L14.018 13.7H11.977L12.997 10.973H12.998Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>Speaks English (Native) +4</span>
                </div>
            </div>
            <div class="btns">
                <button class="btn action bd-2p" data-open="choose-your-trial-lesson-duration-modal" data-close="transfer-remaining-balance-transfer-to">
                    Book with my balance
                </button>
                <a href="../local/customplugin/my_lessons_tutor_profile.php" class="btn bd-2px-light book-balance-btn">View profile</a>
            </div>
        </div>

        <div class="tutors-info-container">
            <div class="tutor-profile">
                <img src="https://dev.latingles.com/img/subs/18.png" alt="">
                <div class="tutor-profile-content">
                    <div class="name-country">
                        <p>Ralph Edwards</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.291 2.055L10 0L6.709 2.055L2.929 2.929L2.055 6.709L0 10L2.055 13.291L2.929 17.071L6.709 17.945L10 20L13.291 17.945L17.071 17.071L17.945 13.291L20 10L17.945 6.709L17.071 2.929L13.291 2.055ZM7.793 13.707L8.5 14.414L9.207 13.707L15.207 7.707L13.793 6.293L8.5 11.586L6.207 9.293L4.793 10.707L7.793 13.707Z"
                                fill="#121117"></path>
                        </svg>
                        <img src="https://dev.latingles.com/img/subs/flag/3.png" alt="">
                    </div>
                    <div class="rate-amount">
                        <div class="leftSide">
                            <div class="rating">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                    fill="none">
                                    <path
                                        d="M6 0L7.48067 3.96133L11.706 4.146L8.396 6.77933L9.52667 10.854L6 8.52L2.47334 10.854L3.60333 6.77867L0.293335 4.14533L4.51867 3.96133L6 0Z"
                                        fill="#121117"></path>
                                </svg>
                                <span>5</span>
                            </div>
                            <p>23 reviews</p>
                        </div>
                        <div class="rightSide">
                            <h3>$16.56</h3>
                            <p>50 min lesson</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="super-tutor-tag">Super tutor</div>
            <div class="aboutTutor">
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                        <path
                            d="M11 18L4 14.2V8.2L0 6L11 0L22 6V14H20V7.1L18 8.2V14.2L11 18ZM11 9.7L17.85 6L11 2.3L4.15 6L11 9.7ZM11 15.725L16 13.025V9.25L11 12L6 9.25V13.025L11 15.725Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>English tutor</span>
                </div>
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8 8C7.20435 8 6.44129 7.68393 5.87868 7.12132C5.31607 6.55871 5 5.79565 5 5C5 4.20435 5.31607 3.44129 5.87868 2.87868C6.44129 2.31607 7.20435 2 8 2C8.79565 2 9.55871 2.31607 10.1213 2.87868C10.6839 3.44129 11 4.20435 11 5C11 5.79565 10.6839 6.55871 10.1213 7.12132C9.55871 7.68393 8.79565 8 8 8ZM3 5C3 3.67392 3.52678 2.40215 4.46447 1.46447C5.40215 0.526784 6.67392 0 8 0C9.32608 0 10.5979 0.526784 11.5355 1.46447C12.4732 2.40215 13 3.67392 13 5C13 6.32608 12.4732 7.59785 11.5355 8.53553C10.5979 9.47322 9.32608 10 8 10C6.67392 10 5.40215 9.47322 4.46447 8.53553C3.52678 7.59785 3 6.32608 3 5ZM16 18V12H0V18H16Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>59 students ⸱ 5,065 lessons</span>
                </div>
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7 0H5V2H0V4H8.015C7.96808 5.52045 7.51432 7.00051 6.701 8.286L3.707 5.293L2.293 6.707L5.459 9.873C5.162 10.185 4.853 10.473 4.541 10.738C3.4667 11.6408 2.26553 12.3807 0.976 12.934C0.877766 12.9756 0.778748 13.0152 0.679 13.053L0.667 13.057L1 14L1.334 14.943L1.338 14.941L1.345 14.939L1.37 14.929C1.49896 14.8816 1.62667 14.831 1.753 14.777C3.22972 14.1446 4.6049 13.2974 5.834 12.263C6.184 11.966 6.533 11.641 6.873 11.287L8.293 12.707L9.707 11.293L8.144 9.73C9.31489 8.04408 9.96605 6.052 10.017 4H12V2H7V0ZM15.253 17L14.656 15.404H11.34L10.74 17H8.7L11.964 8.6H14.028L17.293 17H15.253ZM12.998 10.973L14.018 13.7H11.977L12.997 10.973H12.998Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>Speaks English (Native) +4</span>
                </div>
            </div>
            <div class="btns">
                <button class="btn action bd-2px book-balance-btn" data-open="choose-your-trial-lesson-duration-modal" data-close="transfer-remaining-balance-transfer-to">
                    Book with my balance
                </button>
                <a href="../local/customplugin/my_lessons_tutor_profile.php" class="btn bd-2px-light book-balance-btn">View profile</a>
            </div>
        </div>

        <div class="tutors-info-container">
            <div class="tutor-profile">
                <img src="https://dev.latingles.com/img/subs/3.png" alt="">
                <div class="tutor-profile-content">
                    <div class="name-country">
                        <p>Savannah Nguyen</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.291 2.055L10 0L6.709 2.055L2.929 2.929L2.055 6.709L0 10L2.055 13.291L2.929 17.071L6.709 17.945L10 20L13.291 17.945L17.071 17.071L17.945 13.291L20 10L17.945 6.709L17.071 2.929L13.291 2.055ZM7.793 13.707L8.5 14.414L9.207 13.707L15.207 7.707L13.793 6.293L8.5 11.586L6.207 9.293L4.793 10.707L7.793 13.707Z"
                                fill="#121117"></path>
                        </svg>
                        <img src="https://dev.latingles.com/img/subs/flag/2.png" alt="">
                    </div>
                    <div class="rate-amount">
                        <div class="leftSide">
                            <div class="rating">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                    fill="none">
                                    <path
                                        d="M6 0L7.48067 3.96133L11.706 4.146L8.396 6.77933L9.52667 10.854L6 8.52L2.47334 10.854L3.60333 6.77867L0.293335 4.14533L4.51867 3.96133L6 0Z"
                                        fill="#121117"></path>
                                </svg>
                                <span>5</span>
                            </div>
                            <p>15 reviews</p>
                        </div>
                        <div class="rightSide">
                            <h3>$13.80</h3>
                            <p>50 min lesson</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="super-tutor-tag">Super tutor</div>
            <div class="aboutTutor">
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                        <path
                            d="M11 18L4 14.2V8.2L0 6L11 0L22 6V14H20V7.1L18 8.2V14.2L11 18ZM11 9.7L17.85 6L11 2.3L4.15 6L11 9.7ZM11 15.725L16 13.025V9.25L11 12L6 9.25V13.025L11 15.725Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>English tutor</span>
                </div>
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8 8C7.20435 8 6.44129 7.68393 5.87868 7.12132C5.31607 6.55871 5 5.79565 5 5C5 4.20435 5.31607 3.44129 5.87868 2.87868C6.44129 2.31607 7.20435 2 8 2C8.79565 2 9.55871 2.31607 10.1213 2.87868C10.6839 3.44129 11 4.20435 11 5C11 5.79565 10.6839 6.55871 10.1213 7.12132C9.55871 7.68393 8.79565 8 8 8ZM3 5C3 3.67392 3.52678 2.40215 4.46447 1.46447C5.40215 0.526784 6.67392 0 8 0C9.32608 0 10.5979 0.526784 11.5355 1.46447C12.4732 2.40215 13 3.67392 13 5C13 6.32608 12.4732 7.59785 11.5355 8.53553C10.5979 9.47322 9.32608 10 8 10C6.67392 10 5.40215 9.47322 4.46447 8.53553C3.52678 7.59785 3 6.32608 3 5ZM16 18V12H0V18H16Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>59 students ⸱ 5,065 lessons</span>
                </div>
                <div class="row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7 0H5V2H0V4H8.015C7.96808 5.52045 7.51432 7.00051 6.701 8.286L3.707 5.293L2.293 6.707L5.459 9.873C5.162 10.185 4.853 10.473 4.541 10.738C3.4667 11.6408 2.26553 12.3807 0.976 12.934C0.877766 12.9756 0.778748 13.0152 0.679 13.053L0.667 13.057L1 14L1.334 14.943L1.338 14.941L1.345 14.939L1.37 14.929C1.49896 14.8816 1.62667 14.831 1.753 14.777C3.22972 14.1446 4.6049 13.2974 5.834 12.263C6.184 11.966 6.533 11.641 6.873 11.287L8.293 12.707L9.707 11.293L8.144 9.73C9.31489 8.04408 9.96605 6.052 10.017 4H12V2H7V0ZM15.253 17L14.656 15.404H11.34L10.74 17H8.7L11.964 8.6H14.028L17.293 17H15.253ZM12.998 10.973L14.018 13.7H11.977L12.997 10.973H12.998Z"
                            fill="#4D4C5C"></path>
                    </svg>
                    <span>Speaks English (Native) +4</span>
                </div>
            </div>
            <div class="btns">
                <button class="btn action bd-2px book-balance-btn" data-open="choose-your-trial-lesson-duration-modal" data-close="transfer-remaining-balance-transfer-to">
                    Book with my balance
                </button>
                <a href="../local/customplugin/my_lessons_tutor_profile.php" class="btn bd-2px-light book-balance-btn">View profile</a>
            </div>
        </div>
    </div>

    <div class="exploreTutorContainer">
        <div class="exploreTutorContent">
            <h1>Want to view more recommended tutors?</h1>
            <a class="transfer-complete-modal-open-v1" href="../local/customplugin/explore_tutors.php">
                Explore tutors
            </a>
        </div>
    </div>
</div>
<!-- sep -->
<div class="what-would-you-like-to-do-modal choose-your-trial-lesson-duration-modal custom-modal"
    id="choose-your-trial-lesson-duration-modal">
    <div class="backIcon back-modal back-action" data-close="choose-your-trial-lesson-duration-modal" data-open="transfer-remaining-balance-transfer-to">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-ten backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <h1 style="padding-inline: 0px !important;">Choose your trial lesson duration</h1>

    <div class="trialContainer">
        <div class="trial review-your-transfer-modal-open action" data-close="choose-your-trial-lesson-duration-modal" data-open="review-modal-screen-2-x">
            <div class="leftSide">
                <img src="https://dev.latingles.com/img/subs/icons/Vector.png" alt="">
                <h1>25 minute trial lesson</h1>
                <span>18$</span>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <div class="trial review-your-transfer-modal-open action" data-close="choose-your-trial-lesson-duration-modal" data-open="review-modal-screen-2-x" style="border-bottom: none;">
            <div class="leftSide" data-close="choose-your-trial-lesson-duration-modal" data-open="review-modal-screen-2-x">
                <img src="https://dev.latingles.com/img/subs/icons/image.png" alt="">
                <h1>50 minute trial lesson</h1>
                <span>27$</span>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                    fill="#121117"></path>
            </svg>
        </div>
    </div>
</div>
<div class="balance-modal custom-modal" id="balanceModal">
    <div class="topPart">
        <div class="teacherBox active">
            <div class="imageContainer">
                <img src="https://dev.latingles.com/img/subs/1.png" alt="">
            </div>
            <p>Dinela : 11</p>
        </div>
        <div class="teacherBox">
            <div class="imageContainer">
                <img src="https://dev.latingles.com/img/subs/2.png" alt="">
            </div>
            <p>Wade Warren : 1</p>
        </div>
        <div class="teacherBox">
            <div class="imageContainer">
                <img src="https://dev.latingles.com/img/subs/13.png" alt="">
            </div>
            <p>Albert : 1</p>
        </div>
        <div class="teacherBox">
            <div class="imageContainer">
                <img src="https://dev.latingles.com/img/subs/19.png" alt="">
            </div>
            <p>Daniela : 0</p>
        </div>
        <div class="teacherBox">
            <div class="imageContainer">
                <img src="https://dev.latingles.com/img/subs/9.png" alt="">
            </div>
            <p>Karen : 0</p>
        </div>
    </div>
    <div class="bottomPart">
        <div class="box01 active">
            <div class="lesson">
                <h1>5 lessons</h1>
                <p>to schedule</p>
            </div>

            <div class="progress">
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="outlineBlock"></div>
                <div class="outlineBlock"></div>
                <div class="outlineBlock"></div>
                <div class="outlineBlock"></div>
                <div class="outlineBlock"></div>
            </div>

            <div class="btns">
                <a href="">Shedule Lesson</a>
                <button class="transfer-balance-or-subscription-modol-open outline-button"
                    id="transfer-balance-or-subscription-modol-open">
                    Transfer lessons or subscription
                </button>
            </div>

            <div class="bottomDetail">
                <div class="left">
                    <p>Your plan: <span>12 lessons / 4 weeks</span></p>
                    <p>Renews on: <span>December 10</span></p>
                </div>

                <a href="">Manage</a>
            </div>
        </div>

        <div class="box01">
            <div class="lesson">
                <h1>12 lessons</h1>
                <p>to schedule</p>
            </div>

            <div class="fullBlank progress">
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="colorBlock"></div>
                <div class="outlineBlock"></div>
                <div class="outlineBlock"></div>
                <div class="outlineBlock"></div>
                <div class="outlineBlock"></div>
                <div class="outlineBlock"></div>
            </div>

            <div class="btns">
                <a href="">Shedule Lesson</a>
                <button class="transfer-balance-or-subscription-modol-open outline-button">
                    Transfer lessons or subscription
                </button>
            </div>

            <div class="bottomDetail">
                <div class="left">
                    <p>Your plan: <span>0 lessons / 2 weeks</span></p>
                    <p>Renews on: <span>January 20</span></p>
                </div>

                <a href="">Manage</a>
            </div>
        </div>

        <div class="box01">
            <div class="lesson">
                <h1>1 trial lessons</h1>
                <p>to schedule</p>
            </div>

            <div class="btns">
                <a href="">Shedule Lesson</a>
                <button class="outline-button">
                    Try Another Teacher
                </button>
            </div>
        </div>

        <div class="box01">
            <div class="lesson">
                <h1>0 lessons</h1>
                <p>to schedule</p>
            </div>

            <div class="btns">
                <button class="outline-button">Add Extra Lessons</button>
            </div>
        </div>

        <div class="box01">
            <div class="lesson">
                <h1>0 lessons</h1>
                <p>to schedule</p>
            </div>

            <div class="btns">
                <div class="warning-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9 16C9.91925 16 10.8295 15.8189 11.6788 15.4672C12.5281 15.1154 13.2997 14.5998 13.9497 13.9497C14.5998 13.2997 15.1154 12.5281 15.4672 11.6788C15.8189 10.8295 16 9.91925 16 9C16 8.08075 15.8189 7.17049 15.4672 6.32122C15.1154 5.47194 14.5998 4.70026 13.9497 4.05025C13.2997 3.40024 12.5281 2.88463 11.6788 2.53284C10.8295 2.18106 9.91925 2 9 2C7.14348 2 5.36301 2.7375 4.05025 4.05025C2.7375 5.36301 2 7.14348 2 9C2 10.8565 2.7375 12.637 4.05025 13.9497C5.36301 15.2625 7.14348 16 9 16ZM18 9C18 7.8181 17.7672 6.64778 17.3149 5.55585C16.8626 4.46392 16.1997 3.47177 15.364 2.63604C14.5282 1.80031 13.5361 1.13738 12.4442 0.685084C11.3522 0.232792 10.1819 0 9 0C7.8181 0 6.64778 0.232792 5.55585 0.685084C4.46392 1.13738 3.47177 1.80031 2.63604 2.63604C1.80031 3.47177 1.13737 4.46392 0.685083 5.55585C0.232792 6.64778 0 7.8181 0 9C0 11.3869 0.948212 13.6761 2.63604 15.364C4.32387 17.0518 6.61305 18 9 18C11.3869 18 13.6761 17.0518 15.364 15.364C17.0518 13.6761 18 11.3869 18 9ZM9.938 7V13H8.066V7H9.938ZM9.746 5.92C9.53 6.128 9.282 6.232 9.002 6.232C8.714 6.232 8.466 6.128 8.258 5.92C8.05 5.704 7.946 5.456 7.946 5.176C7.94348 5.03712 7.96992 4.89924 8.02364 4.77114C8.07736 4.64304 8.15718 4.52754 8.258 4.432C8.35428 4.33214 8.46992 4.25296 8.59784 4.19932C8.72577 4.14567 8.86329 4.11868 9.002 4.12C9.282 4.12 9.53 4.224 9.746 4.432C9.84683 4.52754 9.92664 4.64304 9.98036 4.77114C10.0341 4.89924 10.0605 5.03712 10.058 5.176C10.058 5.456 9.954 5.704 9.746 5.92Z"
                            fill="#121117"></path>
                    </svg>
                    <p>Subscription Cancelled</p>
                </div>
                <button class="red-button resubscribe-lesson-modal-open">
                    Resubscribe
                </button>
            </div>
        </div>
    </div>
</div>
<div class="what-would-you-like-to-do-modal transfer-subscription-from-modal custom-modal"
    id="transfer-subscription-from-modal">
    <div class="backIcon backIcon-eleven back-modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-eleven backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <h1>Transfer subscription from</h1>

    <div class="headingAndLists">
        <h4>Active subscriptions</h4>
        <ul>
            <li class="transfer-subscription-to-modal-open">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/2.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Daniela</h3>
                        <p>40$ to transfer</p>
                        <p>4 lessons per week · $50.65 every 4 week</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
            <li class="transfer-subscription-to-modal-open">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/9-1.png" alt="">
                    </div>

                    <div class="content">
                        <h3>Karen V.</h3>
                        <p>38$ to transfer</p>
                        <p>4 lessons per week · $50.65 every 4 week</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
            <li class="transfer-subscription-to-modal-open">
                <div class="leftSide">
                    <div class="imageContainer">
                        <img src="https://dev.latingles.com/img/subs/12-1.png" alt="">
                    </div>

                    <div class="content">
                        <h3>David</h3>
                        <p>134$ to transfer</p>
                        <p>4 lessons per week · $50.65 every 4 week</p>
                    </div>
                </div>
                <div class="rightArrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                            fill="#121117"></path>
                    </svg>
                </div>
            </li>
        </ul>
    </div>
</div>


<div class="what-would-you-like-to-do-modal transfer-subscription-to-modal custom-modal"
    id="transfer-subscription-to-modal">
    <div class="backIcon backIcon-twelve back-modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-twelve backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <h1>Transfer subscription to</h1>

    <ul>
        <li class="also-transfer-remaining-balance-modal-open">
            <div class="leftSide">
                <div class="imageContainer">
                    <img src="https://dev.latingles.com/img/subs/15.png" alt="">
                </div>

                <div class="content">
                    <h3>Jonas</h3>
                    <p>40$ to transfer</p>
                    <p>trail lesson completed · $7.65 per lesson</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="also-transfer-remaining-balance-modal-open">
            <div class="leftSide">
                <div class="imageContainer">
                    <img src="https://dev.latingles.com/img/subs/13.png" alt="">
                </div>

                <div class="content">
                    <h3>Albert</h3>
                    <p>38$ to transfer</p>
                    <p>trail lesson completed · $5 per lesson</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="also-transfer-remaining-balance-modal-open">
            <div class="leftSide">
                <div class="imageContainer">
                    <img src="https://dev.latingles.com/img/subs/14.png" alt="">
                </div>

                <div class="content">
                    <h3>Lucia B.</h3>
                    <p>134$ to transfer</p>
                    <p>trail lesson completed · $4 per lesson</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
    </ul>
</div>

<div class="what-would-you-like-to-do-modal how-many-lessons-you-want-modal also-transfer-remaining-balance-modal custom-modal"
    id="also-transfer-remaining-balance-modal">
    <div class="backIcon backIcon-thirteen back-modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-thirteen backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/2.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z"
                    fill="#121117"></path>
            </svg>
        </div>
    </div>

    <h1>Do you want to also transfer your remaining balance from Daniela?</h1>

    <ul>
        <li class="how-many-lessons-you-want-modal-open">
            <div class="leftSide">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M17.1701 0.833984V7.83398H10.1701V5.83398H14.0581C13.4318 4.85289 12.5336 4.07516 11.4731 3.59555C10.4125 3.11593 9.23535 2.95515 8.08503 3.13279C6.93471 3.31043 5.86089 3.81883 4.99442 4.59602C4.12796 5.37322 3.50626 6.38567 3.20508 7.50998L1.27208 6.98998C1.6523 5.5712 2.41579 4.28449 3.47886 3.27088C4.54193 2.25728 5.86354 1.55592 7.29882 1.24368C8.7341 0.931448 10.2276 1.02039 11.6157 1.50076C13.0038 1.98113 14.2328 2.83438 15.1681 3.96698V0.833984H17.1681H17.1701ZM0.830078 17.29V10.29H7.83008V12.29H3.94308C4.56931 13.2711 5.46739 14.0489 6.52788 14.5285C7.58836 15.0082 8.76547 15.1691 9.91578 14.9916C11.0661 14.814 12.1399 14.3057 13.0065 13.5287C13.873 12.7516 14.4948 11.7392 14.7961 10.615L16.7281 11.132C16.348 12.5508 15.5846 13.8377 14.5216 14.8514C13.4586 15.8651 12.137 16.5666 10.7017 16.8789C9.26638 17.1913 7.7728 17.1024 6.38466 16.6221C4.99652 16.1418 3.76741 15.2886 2.83208 14.156V17.29H0.832078H0.830078Z"
                        fill="#FF2500"></path>
                </svg>

                <div class="content">
                    <h3>Yes, transfer balance and subscription</h3>
                    <p>
                        Transfer both your balance and subscription from daniela to
                        jonas
                    </p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="why-need-to-transfer-subscription-modal-open">
            <div class="leftSide">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M1.99963 9.00001C1.99968 10.3972 2.41781 11.7623 3.20023 12.9198C3.98264 14.0773 5.09353 14.9742 6.38995 15.4951C7.68637 16.016 9.109 16.137 10.4748 15.8426C11.8405 15.5481 13.087 14.8518 14.0536 13.843L15.6206 15.096C14.3935 16.4287 12.7927 17.36 11.0276 17.7681C9.26259 18.1763 7.41545 18.0423 5.72782 17.3836C4.04018 16.7249 2.5906 15.5723 1.56866 14.0764C0.546721 12.5806 0 10.8111 0 8.99951C0 7.1879 0.546721 5.41845 1.56866 3.92259C2.5906 2.42673 4.04018 1.27409 5.72782 0.615433C7.41545 -0.043227 9.26259 -0.17725 11.0276 0.230893C12.7927 0.639035 14.3935 1.57034 15.6206 2.90301L14.0536 4.15701C13.087 3.14828 11.8405 2.45189 10.4748 2.15746C9.109 1.86304 7.68637 1.98404 6.38995 2.50491C5.09353 3.02578 3.98264 3.92268 3.20023 5.08019C2.41781 6.23771 1.99968 7.60287 1.99963 9.00001ZM9.24163 10.803L9.68963 12H11.2196L8.77163 5.70001H7.22363L4.77563 12H6.30563L6.75363 10.803H9.24163ZM8.76363 9.52501L7.99763 7.47901L7.23263 9.52501H8.76263H8.76363ZM15.9996 8.00001H17.9996V10H15.9996V12H13.9996V10H11.9996V8.00001H13.9996V6.00001H15.9996V8.00001Z"
                        fill="#FF2500"></path>
                </svg>

                <div class="content">
                    <h3>No, only transfer subcription</h3>
                    <p>keep your remaining balace with Daniela</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
    </ul>
</div>
<div class="what-would-you-like-to-do-modal how-many-lessons-you-want-modal why-need-to-transfer-subscription-modal custom-modal"
    id="why-need-to-transfer-subscription-modal">
    <div class="backIcon backIcon-fourteen back-modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-fourteen backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/15.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z"
                    fill="#121117"></path>
            </svg>
        </div>
    </div>

    <div class="headingAndPera">
        <h1>Why do you need to transfer your subscription?</h1>
        <p>We won't share this with your tutor</p>
    </div>

    <ul>
        <li class="transfer-subscription-review-transfer-modal-open">
            <div class="leftSide">
                <img src="https://dev.latingles.com/img/subs/icons/garbage.png" alt="">

                <div class="content">
                    <p>I have too many unused lessons</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="transfer-subscription-review-transfer-modal-open">
            <div class="leftSide">
                <img src="https://dev.latingles.com/img/subs/icons/time.png" alt="">

                <div class="content">
                    <p>I don't have time for lessons</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="transfer-subscription-review-transfer-modal-open">
            <div class="leftSide">
                <img src="https://dev.latingles.com/img/subs/icons/calender.png" alt="">

                <div class="content">
                    <p>My tutor isn't available</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="transfer-subscription-review-transfer-modal-open">
            <div class="leftSide">
                <img src="https://dev.latingles.com/img/subs/icons/expensive.png" alt="">

                <div class="content">
                    <p>It's too expensive</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="transfer-subscription-review-transfer-modal-open">
            <div class="leftSide">
                <img src="https://dev.latingles.com/img/subs/icons/doNotLike.png" alt="">

                <div class="content">
                    <p>I'd like to try another tutor</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="transfer-subscription-review-transfer-modal-open">
            <div class="leftSide">
                <img src="https://dev.latingles.com/img/subs/icons/outside.png" alt="">

                <div class="content">
                    <p>I'll study with my tutor outside Latingles</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
        <li class="transfer-subscription-review-transfer-modal-open">
            <div class="leftSide">
                <img src="https://dev.latingles.com/img/subs/icons/menu.png" alt="">

                <div class="content">
                    <p>Something else</p>
                </div>
            </div>
            <div class="rightArrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16" viewBox="0 0 10 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.99991 7.99997L2.29291 15.707L0.878906 14.293L7.17191 7.99997L0.878906 1.70697L2.29291 0.292969L9.99991 7.99997Z"
                        fill="#121117"></path>
                </svg>
            </div>
        </li>
    </ul>
</div>
<div class="how-many-lessons-you-want-modal transfer-subscription-review-transfer-modal custom-modal"
    id="transfer-subscription-review-transfer-modal">
    <div class="backIcon backIcon-fifteen back-modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="closeIcon closeIcon-fifteen backdrop-level-2-close">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                fill="#121117"></path>
        </svg>
    </div>

    <div class="ProfileTransferComponent">
        <!-- first image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/1.png" alt="">
        </div>

        <!-- Second Image -->
        <div class="imageContainer">
            <img src="https://dev.latingles.com/img/subs/15.png" alt="">
        </div>

        <!-- between arrow -->
        <div class="rightArrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.72363 5.32876H0.723633V6.66209H8.72363L5.19497 10.1908L6.13763 11.1334L11.2756 5.99542L6.13763 0.857422L5.19497 1.80009L8.72363 5.32876Z"
                    fill="#121117"></path>
            </svg>
        </div>
    </div>

    <h1>Choose a tutor for your trial lesson</h1>

    <div class="englishWithContainer">
        <div class="englishWithDaniela">
            <h2>English with Daniela</h2>
            <p>4 lessons • $33.27 every 4 weeks</p>
            <span>Ends on April 15</span>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M13.5105 18.129L13.5105 0.129028L10.5105 0.129028L10.5105 18.129L2.57104 10.1895L0.450042 12.3105L12.0105 23.871L23.571 12.3105L21.45 10.1895L13.5105 18.129Z"
                fill="#121117"></path>
        </svg>
        <div class="englishWithDaniela">
            <h2>English with Jonas</h2>
            <p>4 lessons • $33.27 every 4 weeks</p>
            <span>Starts on April 15</span>
        </div>
    </div>
    <div class="whatHappensNext">
        <h1>What happens next?</h1>
        <ul>
            <li>
                You'll get <span>1 lesson ($8.28) with Jonas today.</span>
            </li>
            <li>
                Your <span>first subscription payment with Daniela</span> will
                happen on <span>April 15</span> (4 lessons <span>•</span> $33.12
                every 4 weeks)
            </li>
            <li>
                <span>Your subscription with Daniela</span> will be cancelled. You
                still have 1 lesson ($7.36) with Daniela - schedule it before
                <span>April 15</span> or it will expire.
            </li>
            <li>
                The remaining <span>$6.44</span> will be added to your latingles
                credit. You'll see it at checkout during your next payment.
            </li>
        </ul>
    </div>
    <a href="#" class="btn transfer-complete-modal-open-v1">Confirm transfer</a>
</div>
<!-- CSS -->
<style>
.backdrop-level-4,
.backdrop-level-1,
.backdrop-level-2,
.backdrop-level-3 {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background-color: rgb(0 0 0 / 20%);
    z-index: 3;
    visibility: hidden;
    opacity: 0;
}

.backdrop-level-2 {
    z-index: 4;
}

.backdrop-level-3 {
    z-index: 5;
}
.backdrop-level-4 {
    z-index: 6;

}

.backdrop-level-4.active,
.backdrop-level-1.active,
.backdrop-level-2.active,
.backdrop-level-3.active {
    visibility: visible;
    opacity: 1;
}

.backdrop-level-1.active,
.backdrop-level-2.active,
.backdrop-level-3.active {
    visibility: visible;
    opacity: 1;
}

.close-thank-you-note:hover,
.closeIcon:hover {
    background-color: rgba(0, 0, 0, 0.05);
    transform: rotate(180deg);
}

.backIcon:hover {
    background: rgba(0, 0, 0, 0.03);
}

.bd-2px-light {
    border: 2px solid #DCDCE5 !important;
}
.bd-2px {
    border: 2px solid #121117 !important;
}

.trial.review-your-transfer-modal-open {
    padding-inline: 24px !important;
    margin-inline: -24px;
    width: calc(100% + 48px) !important;
}

.book-balance-btn:hover,
.review-your-transfer-modal-open:hover,
.what-would-you-like-to-do-modal ul li:hover {
    background: rgba(0, 0, 0, 0.03) !important;
}

.lesson-popup .transferLessonsBTN button:hover {
    background: rgba(0, 0, 0, 0.03);
}


.how-many-lessons-you-want-modal .container .buttonGroup .btn:hover {
    background: rgba(0, 0, 0, 0.03);
}
.what-would-you-like-to-do-modal.page6 .btn:hover,
.what-would-you-like-to-do-modal.page5 .btn:hover,
.what-would-you-like-to-do-modal.page3 .btn:hover,
.transfer-complete-modal-Open:hover,
.transfer-remaining-balance-transfer-to .btn:hover,

.review-your-transfer-modal .btn:hover,
.transfer-remaining-balance-transfer-to .btn:hover,
.transfer-remaining-balance-transfer-to .btn:hover,
.choose-your-trial-lesson-duration-modal .btn:hover,
.transfer-subscription-review-transfer-modal .btn:hover,
.transfer-remaining-balance-transfer-to .btn:hover,
.review-your-transfer-modal .btn:hover,
.show-break-down-modal .btn:hover,
.review-your-transfer-modal .btn:hover,
.cancel-modal-open:hover,
.show-break-down-modal .btn:hover,
.how-many-lessons-you-want-modal .container .btn:hover,
.transfer-subscription-review-transfer-modal .btn:hover,
.red-button:hover {
    background: rgba(255, 88, 60, 1);
}

.lesson-popup {
    position: fixed;
    top: 54px;
    right: 35rem;
    width: 583px;
    height: 417px;
    border-radius: 8px;
    border: 1px solid rgba(244, 244, 248, 1);
    background: rgba(255, 255, 255, 1);
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    padding: 32px 37px 16px 38px;
    display: flex;
    gap: 16px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 4;
    cursor: auto;
    visibility: hidden;
    opacity: 0;
    pointer-events: none;

}

.lesson-popup.active {
    visibility: visible;
    opacity: 1;
    pointer-events: unset;
}

.lesson-popup .popup-body {
    width: 100%;
    height: 305px;
    overflow: auto;
    display: flex;
    gap: 24px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    border-bottom: 1px solid rgba(220, 220, 229, 1);
}

.lesson-popup .popup-body::-webkit-scrollbar {
    display: none;
    /* Chrome, Safari, Opera */
}

.lesson-popup .popup-body .popup-section {
    width: 100%;
    display: flex;
    gap: 17px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}


.lesson-popup .popup-body .popup-section h1.popup-title {
    font-weight: 500;
    font-size: 18px;
    line-height: 24px;
    color: rgba(77, 76, 92, 1);
    margin-bottom: 0;
}

.lesson-popup .popup-body .popup-section .teacher-list {
    width: 100%;
    display: flex;
    gap: 16px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.lesson-popup .popup-body .popup-section .teacher-list .teacher-card {
    width: 100%;
    display: flex;
    gap: 10px;
    justify-content: space-between;
    align-items: center;
}

.lesson-popup .popup-body .popup-section .teacher-list .teacher-card .card-left-side {
    display: flex;
    gap: 16px;
    justify-content: flex-start;
    align-items: center;
}

.lesson-popup .popup-body .popup-section .teacher-list .teacher-card a {
    border-radius: 8px;
    padding: 9px 22.51px;
    border: 2px solid rgba(18, 17, 23, 1);
    font-weight: 500;
    font-size: 14px;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(18, 17, 23, 1);
}

.lesson-popup .popup-body .popup-section .teacher-list .teacher-card .card-left-side .avatar-box img {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    border: unset;
}

.lesson-popup .popup-body .popup-section .teacher-list .teacher-card .card-left-side .teacher-info {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    padding: 0;
    gap: 0;
}

.lesson-popup .popup-body .popup-section .teacher-list .teacher-card .card-left-side .teacher-info .info-header {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
}

.lesson-popup .popup-body .popup-section .teacher-list .teacher-card .card-left-side .teacher-info .info-header h1 {
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
    margin-bottom: 0;
}

.lesson-popup .popup-body .popup-section .teacher-list .teacher-card .card-left-side .teacher-info .info-header .status-point {
    width: 3px;
    height: 3px;
    border-radius: 50%;
    background-color: rgba(18, 17, 23, 1);
}

.lesson-popup .popup-body .popup-section .teacher-list .teacher-card .card-left-side .teacher-info .info-header p {
    font-weight: 300;
    font-size: 16px;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
    margin-bottom: 0;
}

.lesson-popup .popup-body .popup-section .teacher-list .teacher-card .card-left-side .teacher-info p {
    font-family: "Figtree", sans-serif;
    font-weight: 400;
    font-size: 14px;
    line-height: 20px;
    color: rgba(106, 105, 124, 1);
    margin-bottom: 0;
}

.lesson-popup .transferLessonsBTN button {
    padding: 11px 20px;
    outline: unset;
    border: unset;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    background: transparent;
    cursor: pointer;
    border-radius: 10px;
}

.lesson-popup .transferLessonsBTN button span {
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 18px;
    line-height: 25.71px;
    text-decoration: underline;
    color: rgba(18, 17, 23, 1);
}


.what-would-you-like-to-do-modal,
.transfer-subscription-review-transfer-modal {
    width: 504px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 1);
    border: 1px solid rgba(244, 244, 248, 1);
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    padding: 48px 0;
    position: relative;
    display: flex;
    gap: 31px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    min-height: 619px;
    max-height: 90vh;
    pointer-events: none;
    visibility: hidden;
    opacity: 0;
    overflow: auto;
    z-index: 5;
}
.what-would-you-like-to-do-modal {
    padding: 48px 24px;
}
.what-would-you-like-to-do-modal .close-thank-you-note,
.what-would-you-like-to-do-modal .closeIcon,
.what-would-you-like-to-do-modal .backIcon,
.show-break-down-modal .closeIcon,
.transfer-subscription-review-transfer-modal .closeIcon,
.transfer-subscription-review-transfer-modal .backIcon,
.back-icon,
.close-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    position: absolute;
    top: 8px;
    right: 8px;
}
.font-w500 {
    font-weight: 500;
}

.what-would-you-like-to-do-modal {
    color: #121117;
}
.what-would-you-like-to-do-modal h1 {
    font-weight: 600;
    font-size: 28px;
    color: #121117;
    padding: 0;
    margin-bottom: 0;
}

.what-would-you-like-to-do-modal ul {
    width: 100%;
    display: flex;
    gap: 12px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    padding: 0 !important;
    margin-bottom: 0 !important;

}

.what-would-you-like-to-do-modal .keep-all-button {
    width: 100%;
    height: 48;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: 2px solid #121117;
    font-weight: 600;
    font-size: 16px;
    color: #121117;
    cursor: pointer;
}

.what-would-you-like-to-do-modal .keep-all-button:hover {
    background: rgba(0, 0, 0, 0.05);
}
.what-would-you-like-to-do-modal ul li {
    padding: 16px 24px;
    /* border-bottom: 1px solid rgba(220, 220, 229, 1); */
    cursor: pointer;
    border: 2px solid #0000001F;
    width: 100%;
    /* min-height: 152px; */
    gap: 16px;
    border-radius: 8px;
    border-width: 2px;
}
.bd-down {
    border-bottom: 1px solid #DCDCE5 !important;
    border-radius: 0px !important; 

}
.what-would-you-like-to-do-modal.page2 {
    padding-inline: 0;
    padding-block: 56px 10px;
    gap: 20px;
}
.what-would-you-like-to-do-modal.page6::-webkit-scrollbar,
.what-would-you-like-to-do-modal.page5::-webkit-scrollbar,
.what-would-you-like-to-do-modal.page2::-webkit-scrollbar {
    width: 0;
    display: none;
}

.what-would-you-like-to-do-modal ul li.page2 .leftSide {
    justify-content: left;
}
.what-would-you-like-to-do-modal h1 {
    padding-inline: 24px;
}
.what-would-you-like-to-do-modal ul.page2 {
    gap: 0px;
}
.what-would-you-like-to-do-modal ul li.page2 {
    padding: 0;
    padding-inline: 24px;
    border: none;
    display: flex;
    height: 80px;
    align-items: center;
    justify-content: space-between;
}

.what-would-you-like-to-do-modal.page3 input[type="checkbox"] {
  accent-color: #121117;
}

.what-would-you-like-to-do-modal.page3 .hidden-box .count {
    background: #DCDCE5;
    border-radius: 4px;
    border: 2px solid #DCDCE5;
    padding: 5px;
    font-size: 14px;
    font-weight: 500;

}
.what-would-you-like-to-do-modal.page3 .hidden-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: -13px; 
    margin-bottom: 22px; 
    border-bottom: 1px solid #0000001F; 
    width: 100%; 
    height: 40px;
}

.what-would-you-like-to-do-modal.page3 input {
    cursor: pointer;
    height: 20px;
    width: 20px;
    background: transparent;
    border-radius: 4px;
    border: 2px solid #DCDCE5;
}

.what-would-you-like-to-do-modal.page4 .light-green p {
    font-weight: 400;
    font-size: 14px;
    color: #121117;
}
.what-would-you-like-to-do-modal.page4 .light-green h3 {
    font-weight: 600;
    font-size: 15px;
    color: #121117;
}
.what-would-you-like-to-do-modal.page4 .light-green {
    height: 102px;
    padding-inline: 16px;
    display: flex;
    align-items: center;
    background: #D8F8F280;
    border-radius: 8px;
}

#cancel-selected-lesson:disabled {
    background: #DCDCE5 !important;
    border: 2px solid #A8A8B6 !important;
    cursor: not-allowed;
    opacity: 0.6;
}

.what-would-you-like-to-do-modal.page4 ul.page4 li.active {
    border: 2px solid #121117;
}
.what-would-you-like-to-do-modal.page4 ul.page {
    gap: 20px;
}

.what-would-you-like-to-do-modal.page4 .green {
    height: 24px;
    border-radius: 4px;
    padding-inline: 10px;
    display: flex;
    align-items: center;
    background: #067560;
    font-weight: 500;
    font-size: 13px;
    color: #fff;
}
.what-would-you-like-to-do-modal.page4 ul li .leftSide .content p {
    font-size: 16px;
}
.what-would-you-like-to-do-modal.page4 ul li .leftSide .content h3 {
    font-size: 18px;
}
.comment-box {
  border-radius: 8px;
  border: 1px solid #14145226;
  height: 150px;
  resize: none; /* prevents user from resizing */
  overflow-y: auto;
}
.what-would-you-like-to-do-modal.page6,
.what-would-you-like-to-do-modal.page5,
.what-would-you-like-to-do-modal.page4,
.what-would-you-like-to-do-modal.page3 {
    padding: 80px 24px 24px 24px;
    min-height: 0;
    gap: 0px;
}

.what-would-you-like-to-do-modal.page6 h1,
.what-would-you-like-to-do-modal.page5 h1,
.what-would-you-like-to-do-modal.page4 h1,
.what-would-you-like-to-do-modal.page1 h1,
.what-would-you-like-to-do-modal.page3 h1 {
    padding-inline: 0px;
}
.what-would-you-like-to-do-modal ul li.page4,
.what-would-you-like-to-do-modal ul li.page3 {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.what-would-you-like-to-do-modal ul li.page3 .boxes {
    display: flex;
    gap: 8px;
}

.what-would-you-like-to-do-modal ul li.page3 .box1 {
    background: #DCDCE5;
    border-radius: 4px;
    height: 22px;
    width: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: "Figtree", sans-serif;
    font-weight: 600;
    font-size: 12px;
    color: #121117;

}

.what-would-you-like-to-do-modal.page6 ul li,
.what-would-you-like-to-do-modal.page5 ul li {
    cursor:default;
}

.what-would-you-like-to-do-modal.page5 ul li:hover {
    background: transparent;
}
.what-would-you-like-to-do-modal.page5 ul li .thank-note:hover {
    cursor: pointer;
    background: rgba(0, 0, 0, 0.03);
}
.what-would-you-like-to-do-modal.page5 ul li .thank-note{
    height: 40px;
    border-radius: 8px;
    border: 2px solid #14145226;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 204px;
    gap: 8px;
    font-size: 14px;
    color: #121117;
    font-weight: 600;
    font-family: "Figtree", sans-serif;
    margin-top: 12px;
}

.what-would-you-like-to-do-modal.page5 ul li .d-icon {
    position: absolute;
    top: 0;
    left: 0;
    transform: translateX(-50%);
}

.what-would-you-like-to-do-modal.page6,
.what-would-you-like-to-do-modal.page5 {
    overflow-x: hidden;
}

.what-would-you-like-to-do-modal.page5 ul {
    gap: 32px;
}
.what-would-you-like-to-do-modal.page5 ul li {
    border: none;
    padding-block:0;
    padding-inline: 27px 16px;
    position: relative;
}

.what-would-you-like-to-do-modal.page5 ul.divWithTimeline {
    margin-left: 11px !important;
    border-left: 2px solid #DCDCE5;
    
}

.normal-text-li {
    font-size: 14px;
}
.what-would-you-like-to-do-modal ul li .content {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 14px;
    background-color: transparent;
}

.what-would-you-like-to-do-modal ul li .content .iconContainer {
    width: 25px;
    flex-shrink: 0;
}

.what-would-you-like-to-do-modal ul li .content svg {
    width: 100%;
}

.what-would-you-like-to-do-modal ul li .content p {
    font-size: 14px;
    line-height: 24px;
    font-weight: 400;
    color: rgba(18, 17, 23, 1);
}

.what-would-you-like-to-do-modal ul li .rightArrow {
    width: 24px;
    height: 24px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.what-would-you-like-to-do-modal.active,
.transfer-subscription-review-transfer-modal.active {
    pointer-events: auto;
    visibility: visible;
    opacity: 1;

}

.what-would-you-like-to-do-modal .backIcon,
.transfer-subscription-review-transfer-modal .backIcon,
.back-icon {
    right: unset;
    left: 8px;
}

.what-would-you-like-to-do-modal .closeIcon,
.what-would-you-like-to-do-modal .backIcon,
.show-break-down-modal .closeIcon,
.transfer-subscription-review-transfer-modal .closeIcon,
.transfer-subscription-review-transfer-modal .backIcon,
.back-icon,
.close-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    position: absolute;
    top: 8px;
    right: 8px;
}

.what-would-you-like-to-do-modal ul li .leftSide .imageContainer {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    border: 1px solid rgba(18, 17, 23, 0.06);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.what-would-you-like-to-do-modal ul li .leftSide .imageContainer img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.what-would-you-like-to-do-modal ul li .leftSide {
    display: flex;
    gap: 14px;
    justify-content: center;
    align-items: center;
}

.what-would-you-like-to-do-modal ul li .leftSide .content {
    flex-direction: column;
    align-items: flex-start;
    gap: 0px;
}

.what-would-you-like-to-do-modal ul li .leftSide .content h3 {
    margin-bottom: 0;
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    color: rgba(0, 0, 0, 1);
}

.what-would-you-like-to-do-modal ul li .leftSide .content p {
    font-weight: 500;
    font-size: 14px;
    line-height: 24px;
    color: rgba(0, 0, 0, 0.7);
}

.what-would-you-like-to-do-modal .container {
    width: 100% !important;
    display: flex !important;
    ;
    flex-direction: column !important;
    justify-content: flex-start !important;
    align-items: flex-start !important;
    gap: 4px !important;
    padding: 0 !important;
    max-width: 100% !important;
}

.what-would-you-like-to-do-modal .container h4 {
   padding: 0 24px;
    font-weight: 500;
    font-size: 14px;
    line-height: 24px;
    color: rgba(77, 76, 92, 1);
}

#transfer-balance-screen-3-2x.what-would-you-like-to-do-modal .ProfileTransferComponent,
#transfer-balance-screen-3-x.what-would-you-like-to-do-modal .ProfileTransferComponent,
.what-would-you-like-to-do-modal.page5 .ProfileTransferComponent,
.how-many-lessons-you-want-modal .ProfileTransferComponent {
    width: 104px;
    height: 48px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    gap: 8px;
}

#transfer-balance-screen-3-2x.what-would-you-like-to-do-modal .ProfileTransferComponent .imageContainer,
#transfer-balance-screen-3-x.what-would-you-like-to-do-modal .ProfileTransferComponent .imageContainer,
.what-would-you-like-to-do-modal.page5 .ProfileTransferComponent .imageContainer,
.how-many-lessons-you-want-modal .ProfileTransferComponent .imageContainer {
    width: 48px;
    height: 48px;
    border-radius: 4px;
    border: 1px solid rgba(18, 17, 23, 0.06);
    display: flex;
    justify-content: center;
    align-items: center;
}
#transfer-balance-screen-3-2x.what-would-you-like-to-do-modal .ProfileTransferComponent .imageContainer img,
#transfer-balance-screen-3-x.what-would-you-like-to-do-modal .ProfileTransferComponent .imageContainer img,
.what-would-you-like-to-do-modal.page5 .ProfileTransferComponent .imageContainer img,
.how-many-lessons-you-want-modal .ProfileTransferComponent .imageContainer img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#transfer-balance-screen-3-2x.what-would-you-like-to-do-modal .ProfileTransferComponent .rightArrow,
#transfer-balance-screen-3-x.what-would-you-like-to-do-modal .ProfileTransferComponent .rightArrow,
.what-would-you-like-to-do-modal.page5 .ProfileTransferComponent .rightArrow,
.how-many-lessons-you-want-modal .ProfileTransferComponent .rightArrow {
    position: absolute;
    top: 20%;
    left: 35%;
    width: 26px;
    height: 26px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 4px;
    border: 1px solid rgba(220, 220, 229, 1);
    background: rgba(244, 244, 248, 1);
    padding: 5px;
}

#transfer-balance-screen-3-2x.what-would-you-like-to-do-modal .ProfileTransferComponent .rightArrow svg,
#transfer-balance-screen-3-x.what-would-you-like-to-do-modal .ProfileTransferComponent .rightArrow svg,
.what-would-you-like-to-do-modal.page5 .ProfileTransferComponent .rightArrow svg,
.how-many-lessons-you-want-modal .ProfileTransferComponent .rightArrow svg {
    width: 10.55px;
    height: 10.28px;
    border: unset;
}
.profile-details-container {
    display: flex;
    gap: 16px;
}
.container-details-profile {
    display: flex;
    flex-direction: column;
    padding-block: 8px;
}
.top-header {
    display: flex;
    gap: 8px;
    align-items: center;
}
.profile-details-container .rating {
     font-family: "Figtree", sans-serif;
     font-weight: 600;
}
.profile-details-container .bottom-section {
    display: flex;
    align-items: center;
}
.duty-info {
    display: flex;
    gap: 60px;
}
.info-first {
    font-weight: 500;
    font-style: Medium;
    font-size: 17px;
    color: #121117;
}
.label-tex {
    font-family: "Figtree", sans-serif;
    font-weight: 400;
    font-size: 12px;
    color: #121117
}
.lesson-heading {
    display: flex;
    align-items: center;
    min-height: 58px;
    border-top: 1px solid #DCDCE5;
    border-bottom: 1px solid #DCDCE5;
    font-weight: 600;
    font-size: 15px;
}
.lesson-bill-box {
    display: flex;
    gap: 12px;
    flex-direction: column;
}
.title-lesson {
    font-weight: 400;
    font-size: 15px;
}
.bill-for-it {
    font-family: "Figtree", sans-serif;
    font-weight: 600;
    font-size: 16px;
}
.total-text {
    font-weight: 600;
    font-size: 20px;
}
.light-blue-container {
    background: #D8F8F280;
    padding-inline: 16px;
    padding-block: 12px;
    height: 72px;
    border-radius: 8px;
    font-size: 14px;
}
.bd-box {
    border-bottom: 1px solid #DCDCE5;
    height: 1px;
    width: 100%;
}
.review-box {
    background: #F4F4F8;
    padding: 14px 12px;
    margin-block: 16px;
    font-size: 14px;
    border-radius: 8px;
    
    h3 {
        font-size: 14px;
        font-weight: 600;
    }
    p {
        font-weight: 400;
    }
}
/* payment method drodpdown */
.payment-method-dropdown {
  border: 1px solid #ddd;
  border-radius: 8px;
  background: #fff;
  cursor: pointer;
  user-select: none;
  position: relative;
  font-family: Arial, sans-serif;
}

.selected-value {
  padding: 10px 12px;
}

/* Dropdown list */
.options-wrapper {
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  border: 1px solid #ddd;
  border-radius: 8px;
  background: #fff;
  margin-top: 4px;
  display: none;
  z-index: 10;
}

.payment-options {
  padding: 10px 12px;
  border-bottom: 1px solid #eee;
}

.payment-options:last-child {
  border-bottom: none;
}

.payment-options:hover {
  background: rgba(0, 0, 0, 0.05);
}

/* payment method drodpdown */
.how-many-lessons-you-want-modal h1 {
    font-size: 28px;
    font-weight: 600;
    color: rgba(18, 17, 23, 1);
    margin-bottom: 16px;
    padding: 0;

}

.how-many-lessons-you-want-modal .container {
    width: 100% !important;
    max-width: 456px !important;
    height: 410px !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: flex-end !important;
    align-items: center !important;
    gap: 48px !important;
    margin-top: 1.5rem !important;
}

.teacher-text {
    font-weight: 500;
    font-size: 18px;
    color:#121117;
}

.how-many-lessons-you-want-modal .container .buttonGroup {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.how-many-lessons-you-want-modal .container .buttonGroup .btn.disabled {
    pointer-events: none;
    background: rgba(220, 220, 229, 1);
    border-color: rgba(168, 168, 182, 1);
}

.how-many-lessons-you-want-modal .container .btn.disabled {
    border-color: rgba(168, 168, 182, 1);
    background: rgba(220, 220, 229, 1);
    color: rgba(106, 105, 124, 1);
    pointer-events: none;
}

.how-many-lessons-you-want-modal .container .buttonGroup .btn {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    padding: 8px;
    border: 2px solid rgba(18, 17, 23, 1);
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    background-color: transparent;
}

.how-many-lessons-you-want-modal .container .buttonGroup .btn svg {
    width: 16px;
    height: 16px;
    color: rgba(18, 17, 23, 1);
}

.how-many-lessons-you-want-modal .container .buttonGroup .lessonCount-paragraph {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 4px;
}

.how-many-lessons-you-want-modal .container .buttonGroup .lessonCount-paragraph h1 {
    font-size: 39px;
    font-weight: 700;
    line-height: 52px;
    color: rgba(18, 17, 23, 1);
    margin-bottom: unset;
}

.how-many-lessons-you-want-modal .container .buttonGroup .lessonCount-paragraph p {
    font-size: 16px;
    font-weight: 500;
    line-height: 24px;
    color: rgba(77, 76, 92, 1);
}

.how-many-lessons-you-want-modal .container .sixLessonSelectedAndBalanceContainer {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 12px;
}

.how-many-lessons-you-want-modal .container .six-lesson-selected {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 34px;
    padding: 15px 12px;
    background: rgba(255, 245, 194, 1);
    border-radius: 4px;
    display: none;
}

.how-many-lessons-you-want-modal .container .six-lesson-selected p {
    font-size: 14px;
    color: rgba(18, 17, 23, 1);
    font-weight: 500;
    margin-bottom: 0;
}

.how-many-lessons-you-want-modal .container .balanceBox {
    width: 100%;
    min-height: 90px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    padding: 12px;
    border-radius: 4px;
    border: 1px solid rgba(220, 220, 229, 1);
    background: rgba(244, 244, 248, 1);
}

.how-many-lessons-you-want-modal .container .balanceBox .balanceHeader {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.how-many-lessons-you-want-modal .container .balanceBox .balanceHeader span {
    font-size: 14px;
    font-weight: 400;
    line-height: 20px;
    letter-spacing: 0.07px;
}

.how-many-lessons-you-want-modal .container .balanceBox .balanceHeader span strong {
    font-size: 14px;
    font-weight: 600;
}

.how-many-lessons-you-want-modal .container .balanceBox .progress {
    width: 100%;
    height: 8px;
    border: 2px solid rgba(6, 117, 96, 1);
    background: rgba(255, 255, 255, 1);
}

.how-many-lessons-you-want-modal .container .balanceBox .progress .lesson-progress {
    width: 0%;
    height: 100%;
    background: rgba(6, 117, 96, 1);
}

.how-many-lessons-you-want-modal .container .balanceBox a {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    font-weight: 600;
    line-height: 20px;
    letter-spacing: 0.07px;
    text-decoration: underline solid;
    text-decoration-skip-ink: auto;
    text-underline-offset: 1px;
    color: rgba(18, 17, 23, 1);
}

.how-many-lessons-you-want-modal {
    padding: 60px 24px 24px;
    gap: 8px;
}

.what-would-you-like-to-do-modal.page6 .btn,
.what-would-you-like-to-do-modal.page5 .btn,
.what-would-you-like-to-do-modal.page3 .btn,
.how-many-lessons-you-want-modal .container .btn,
.transfer-subscription-review-transfer-modal .btn,
.red-button {
    width: 100%;
    height: 48px;
    border-radius: 8px;
    border: 2px solid rgba(18, 17, 23, 1);
    background: rgba(255, 37, 0, 1);
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 18px;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(255, 255, 255, 1);
    cursor: pointer;
    flex-shrink: 0;
}

.show-break-down-modal.active {
    visibility: visible;
    opacity: 1;
    pointer-events: unset;
}

.show-break-down-modal {
    width: 400px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 1);
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    padding: 48px 24px 24px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    visibility: hidden;
    opacity: 0;
    pointer-events: none;
    overflow: auto;
    z-index: 8;
}

.show-break-down-modal .content {
    width: 100%;
    display: flex;
    gap: 16px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.show-break-down-modal .content .shortDetail {
    width: 100%;
    display: flex;
    gap: 12px;
    justify-content: flex-start;
    align-items: center;
}

.show-break-down-modal .content .shortDetail .imageContainer {
    width: 48px;
    height: 48px;
    border-radius: 4px;
    border: 1px solid rgba(18, 17, 23, 0.06);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.show-break-down-modal .content .shortDetail .imageContainer img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.show-break-down-modal .content .shortDetail .titleAndPrice {
    display: flex;
    gap: 2px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.show-break-down-modal .content .shortDetail .titleAndPrice h1 {
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.show-break-down-modal .content .shortDetail .titleAndPrice p {
    font-weight: 500;
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.07px;
    color: rgba(77, 76, 92, 1);
}

.show-break-down-modal .content .details {
    width: 100%;
    border: 1px solid rgba(220, 220, 229, 1);
    border-radius: 4px;
    display: flex;
    gap: 12px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 12px;
}

.show-break-down-modal .content .details ul {
    width: 100%;
    display: flex;
    gap: 12px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.show-break-down-modal .content .details ul li {
    width: 100%;
    display: flex;
    gap: 8px;
    justify-content: space-between;
    align-items: center;
}

.show-break-down-modal .content .details ul li p {
    font-weight: 400;
    font-size: 16px;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.show-break-down-modal .content .details ul li h1 {
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.show-break-down-modal .content .details .divider {
    width: 100%;
    height: 1px;
    background: rgba(220, 220, 229, 1);
}

.show-break-down-modal .content .details .total {
    width: 100%;
    display: flex;
    gap: 8px;
    justify-content: space-between;
    align-items: center;
}

.show-break-down-modal .content .details .total h1 {
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.show-break-down-modal .content .details .total p.redColor {
    background: rgba(255, 37, 0, 0.1);
    color: rgba(255, 37, 0, 1);
}

.show-break-down-modal .content button {
    width: 100%;
    height: 48.29px;
    border-radius: 8px;
    background: rgba(255, 37, 0, 1);
    border: 2px solid rgba(18, 17, 23, 1);
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 18px;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(255, 255, 255, 1);
    cursor: pointer;
}

.review-your-transfer-modal {
    justify-content: space-between;
    z-index: 11 !important;
}

.review-your-transfer-modal .btn {
    width: 100%;
    height: 48.29px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 77px;
    border-radius: 8px;
    border: 2px solid rgba(18, 17, 23, 1);
    background: rgba(255, 37, 0, 1);
    font-size: 18px;
    font-weight: 600;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(255, 255, 255, 1);
    flex-shrink: 0;
    cursor: pointer;
    font-family: "Poppins", sans-serif;
}

.review-your-transfer-modal .whatHappensNext {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 20px;
    margin-top: 24px;
}


.review-your-transfer-modal .whatHappensNext h1 {
    font-size: 18px;
    font-weight: 500;
    line-height: 24px;
    color: rgba(0, 0, 0, 1);
    margin-bottom: unset;
    padding: 0;
}

.review-your-transfer-modal .whatHappensNext ul {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding: 0 24px !important;
}

.review-your-transfer-modal .whatHappensNext ul li {
    width: 100%;
    list-style: disc;
    font-size: 16px;
    font-weight: 400;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
    display: list-item;
    border: none;
    padding: 0;
    cursor: auto;
}

.review-your-transfer-modal .balance-box {
    width: 100%;
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    margin-top: 12px;
}

.review-your-transfer-modal .balance-box .row {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0;
}

.review-your-transfer-modal .balance-box .row span {
    font-size: 16px;
    font-weight: 400;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.review-your-transfer-modal .container {
    width: 100%;
    height: auto !important;
    border-bottom: 1px solid rgba(220, 220, 229, 1);
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 16px !important;
    padding: 0 0 19px 0;
}

.review-your-transfer-modal .container .row {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.review-your-transfer-modal .container .row span {
    font-size: 16px;
    font-weight: 400;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.transferComplete {
    padding: 0;
    z-index: 12 !important;
    min-height: 471px;
    overflow: hidden;
    gap: 24px !important;
}

.transferComplete .transferContainer {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    background: rgba(255, 233, 229, 0.5);
    width: calc(100% - 48px);
    margin-top: 70px;
    padding: 20px 24px;
    height: auto;
    margin-inline: 24px;
    border-radius: 20px;
}

.transferComplete .transferContainer .transferImage {
    width: 216px;
    height: 64px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    position: relative;
    margin-bottom: 20px;
}

.transferComplete .transferContainer .transferImage img {
    width: 64px;
    height: 64px;
    border-radius: 4px;
    flex-shrink: 1;
    border: 1px solid rgba(18, 17, 23, 0.06);
}

.transferComplete .transferContainer .transferImage svg {
    /* width: 44.16px; */
    height: 24px;
}

.transferComplete .transferContainer .transferImage .numbersCountOnImage {
    width: 32px;
    height: 32px;
    border-radius: 4px;
    border: 2px solid rgba(18, 17, 23, 1);
    padding: 4px;
    background: var(--second-primary, rgba(255, 37, 0, 1));
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    bottom: -10px;
    right: -20px;
    font-size: 13.91px;
    font-weight: 600;
    line-height: 24px;
    color: rgba(255, 255, 255, 1);
}

.transferComplete .transferContainer h1 {
    font-size: 38px;
    font-weight: 600;
    color: rgba(18, 17, 23, 1);
    padding: 0;
}

.transferComplete .bottomPart {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 24px;
    padding: 0 24px 24.43px;
}

.transferComplete .bottomPart .paragraphs {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
}

.transferComplete .bottomPart p {
    font-size: 16px;
    font-weight: 400;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.transferComplete .bottomPart .btns {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 13px;
}

.transferComplete .bottomPart .btns .btn {
    width: 100%;
    height: 48.29px;
    border-radius: 8px;
    border: 2px solid rgba(18, 17, 23, 1);
    padding: 11.14px;
    background: rgba(255, 37, 0, 1);
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 18px;
    font-weight: 600;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(255, 255, 255, 1);
    cursor: pointer;
    font-family: "Poppins", sans-serif;
}

.transferComplete .bottomPart .btns .btn:nth-child(2) {
    background: transparent;
    color: rgba(18, 17, 23, 1);
}

.transfer-remaining-balance-transfer-to {
    width: 504px;
    max-height: 619px;
    padding: 56px 24px 0;
    gap: 0 !important;
}

.transfer-remaining-balance-transfer-to {
    z-index: 5;
}

.save-a-payment-card-modal.active,
.transfer-remaining-balance-transfer-to.active {
    pointer-events: auto;
    visibility: visible;
    opacity: 1;
}

#choose-your-trial-lesson-duration-modal {
    min-height: 423px !important;
    height: 423px !important;
    overflow: hidden;
}
.save-a-payment-card-modal,
.transfer-remaining-balance-transfer-to {
    max-width: 504px;
    width: 90%;
    max-height: 601px;
    height: 90dvh;
    border-radius: 8px;
    background: rgba(255, 255, 255, 1);
    border: 1px solid rgba(244, 244, 248, 1);
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 56px 24px 21px;
    display: flex;
    gap: 15px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    pointer-events: none;
    visibility: hidden;
    opacity: 0;
    z-index: 9;
}

.transfer-remaining-balance-transfer-to h1 {
    padding: 0;
    margin-bottom: 24px;
}

.transfer-remaining-balance-transfer-to span {
    font-size: 14px;
    font-weight: 500;
    line-height: 24px;
    color: rgba(77, 76, 92, 1);
    margin-bottom: 8px;
}

.transfer-remaining-balance-transfer-to .recommendedContainer {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    overflow: auto;
    padding: 0 24px 20px;
    gap: 6px;
}

.transfer-remaining-balance-transfer-to .recommendedContainer::-webkit-scrollbar {
    width: 0;
    display: none;
}

.transfer-remaining-balance-transfer-to .tutors-info-container {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 12px;
    border: 1px solid rgba(220, 220, 229, 1);
    border-radius: 8px;
    padding: 16px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile {
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 16px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile img {
    width: 64px;
    height: 64px;
    border-radius: 4px;
    border: 1px solid rgba(18, 17, 23, 0.06);
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 12px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .name-country {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .name-country p {
    font-size: 16.5px;
    font-weight: 500;
    line-height: 32px;
    letter-spacing: 0.3px;
    color: rgba(18, 17, 23, 1);
    margin: 0;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .name-country svg {
    width: 20px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .name-country img {
    width: 24px;
    height: auto;
    border-radius: 2px;
    border: 1px solid rgba(18, 17, 23, 0.56);
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .rate-amount {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 48px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .rate-amount .leftSide {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .rate-amount .leftSide .rating {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 4px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .rate-amount .leftSide .rating svg {
    width: 11.41px;
    height: 10.85px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .rate-amount .leftSide .rating span {
    font-size: 20px;
    font-weight: 500;
    line-height: 24px;
    letter-spacing: 0.35px;
    color: rgba(18, 17, 23, 1);
    margin: 0;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .rate-amount .leftSide p {
    font-size: 14px;
    font-weight: 400;
    line-height: 20px;
    letter-spacing: 0.07px;
    color: rgba(18, 17, 23, 1);
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .rate-amount .rightSide {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .rate-amount .rightSide h3 {
    font-size: 16.25px;
    font-weight: 500;
    line-height: 24px;
    letter-spacing: 0.35px;
    color: rgba(18, 17, 23, 1);
}

.transfer-remaining-balance-transfer-to .tutors-info-container .tutor-profile .tutor-profile-content .rate-amount .rightSide p {
    font-size: 14px;
    font-weight: 400;
    line-height: 20px;
    letter-spacing: 0.07px;
    color: rgba(18, 17, 23, 1);
}

.transfer-remaining-balance-transfer-to .tutors-info-container .super-tutor-tag {
    width: 89px;
    height: 24px;
    border-radius: 4px;
    background: rgba(255, 235, 243, 1);
    padding: 2px 8px;
    font-size: 14px;
    font-weight: 600;
    line-height: 20px;
    color: rgba(18, 17, 23, 1);
    font-family: "Figtree", sans-serif;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .aboutTutor {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 4px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .aboutTutor .row {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin: 0;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .aboutTutor .row svg {
    width: 22px;
    height: 18px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .aboutTutor .row span {
    font-size: 16px;
    font-weight: 400;
    line-height: 24px;
    color: rgba(77, 76, 92, 1);
    margin: 0;
}

.transfer-remaining-balance-transfer-to .exploreTutorContainer {
    width: 100%;
    padding: 12px 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(255, 255, 255, 1);
    position: relative;
    bottom: 8px;
}

.transfer-remaining-balance-transfer-to .exploreTutorContainer .exploreTutorContent {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 6px;
    border-radius: 8px;
    border: 1px solid rgba(220, 220, 229, 1);
    padding: 12px 16px;
    background: rgba(255, 255, 255, 1);
}

.transfer-remaining-balance-transfer-to .exploreTutorContainer h1 {
    font-size: 18px;
    font-weight: 500;
    line-height: 32px;
    color: rgba(18, 17, 23, 1);
    margin-bottom: unset;
}

.confirm-payment-modal button,
.save-a-payment-card-modal form button,
.transfer-remaining-balance-transfer-to .exploreTutorContainer a,
.transfer-remaining-balance-transfer-to .exploreTutorContainer button {
    width: 100%;
    height: 48.29px;
    border-radius: 8px;
    background: rgba(255, 37, 0, 1);
    border: 2px solid rgba(18, 17, 23, 1);
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 18px;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(255, 255, 255, 1);
    cursor: pointer;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .btns {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 12px;
}

.transfer-remaining-balance-transfer-to .tutors-info-container .btns .btn {
    width: 100%;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 2px solid rgba(18, 17, 23, 1);
    border-radius: 8px;
    padding: 10px 0;
    font-size: 14px;
    font-weight: 500;
    line-height: 20px;
    letter-spacing: 0.17px;
    color: rgba(18, 17, 23, 1);
    background: transparent;
    font-family: "Poppins", sans-serif;
    cursor: pointer;
}

.transfer-remaining-balance-transfer-to .exploreTutorContainer a,
.transfer-remaining-balance-transfer-to .exploreTutorContainer button {
    height: 40px;
}

.save-a-payment-card-modal.active,
.transfer-remaining-balance-transfer-to.active {
    pointer-events: auto;
    visibility: visible;
    opacity: 1;
}

.choose-your-trial-lesson-duration-modal h1 {
    font-size: 28px;
    font-weight: 600;
    color: rgba(18, 17, 23, 1);
}

.choose-your-trial-lesson-duration-modal .trialContainer {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    gap: 1px;
}

.choose-your-trial-lesson-duration-modal .trialContainer .trial {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 24px;
    border-bottom: 1px solid rgba(220, 220, 229, 1);
    cursor: pointer;
}

.choose-your-trial-lesson-duration-modal .trialContainer .trial .leftSide {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
}

.choose-your-trial-lesson-duration-modal .trialContainer .trial svg {
    width: 9.12px;
    height: 15.41px;
}

.choose-your-trial-lesson-duration-modal .trialContainer .trial .leftSide img {
    width: 24px;
    height: 24px;
    margin-bottom: 14px;
}

.choose-your-trial-lesson-duration-modal .trialContainer .trial .leftSide h1 {
    font-size: 16px;
    font-weight: 500;
    line-height: 24px;
    color: rgba(0, 0, 0, 1);
    margin-bottom: unset;
    padding: 0;
}

.choose-your-trial-lesson-duration-modal .trialContainer .trial .leftSide span Specificity: (0, 4, 1) {
    font-size: 14px;
    font-weight: 400;
    line-height: 24px;
    color: rgba(0, 0, 0, 70%);
}

.choose-your-trial-lesson-duration-modal.active {
    z-index: 10;
}

/* balance modal */

.balance-modal.active {
    visibility: visible;
    opacity: 1;
    pointer-events: unset;
}

.balance-modal {
    position: absolute;
    top: 54px;
    right: 27.5rem;
    width: 390px;
    min-height: 324px;
    border-radius: 8px;
    border: 1px solid rgba(244, 244, 248, 1);
    box-shadow: 0px 8px 32px 0px rgba(18, 17, 23, 0.15), 0px 16px 48px 0px rgba(18, 17, 23, 0.15);
    background: rgba(255, 255, 255, 1);
    padding: 24px 0 0;
    z-index: 4;
    cursor: auto;
    visibility: hidden;
    opacity: 0;
    pointer-events: none;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: stretch;
}

.balance-modal p {
    margin-bottom: 0;
}

.balance-modal .topPart {
    width: 100%;
    overflow: auto;
    padding: 0 20px;
    display: flex;
    gap: 8px;
    justify-content: flex-start;
    align-items: center;
}

.balance-modal .topPart::-webkit-scrollbar {
    display: none;
}

.balance-modal .topPart .teacherBox.active {
    border: 2px solid rgba(0, 0, 0, 1);
}

.balance-modal .topPart .teacherBox {
    border-radius: 8.93px;
    background: rgba(255, 255, 255, 1);
    border: 2px solid rgba(0, 0, 0, 0.12);
    padding: 6px;
    display: flex;
    gap: 6px;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    cursor: pointer;
}

.balance-modal .topPart .teacherBox .imageContainer {
    width: 32px;
    height: 32px;
    border-radius: 85px;
    border: 1px solid rgba(18, 17, 23, 0.06);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.balance-modal .topPart .teacherBox.active p {
    color: rgba(18, 17, 23, 1) !important;
    margin-bottom: 0;
}

.balance-modal .topPart .teacherBox .imageContainer img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.balance-modal .bottomPart {
    padding: 20px 21px 24px 24px;
    position: relative;
    width: 100%;
    display: flex;
    gap: 10px;
    flex-direction: column;
    justify-content: stretch;
    align-items: flex-start;
    flex: 1;
}

.balance-modal .bottomPart .box01.active {
    display: flex;
}

.balance-modal .bottomPart .box01 {
    width: 100%;
    display: flex;
    gap: 20px;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-start;
    display: none;
    flex: 1;
}

.balance-modal .bottomPart .box01 .lesson {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.balance-modal .bottomPart .box01 .lesson h1 {
    font-weight: 600;
    font-size: 28.25px;
    line-height: 42.38px;
    color: rgba(18, 17, 23, 1);
    text-transform: capitalize;
}

.balance-modal .bottomPart .box01 .lesson p {
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    color: rgba(77, 76, 92, 1);
}

.balance-modal .bottomPart .box01 .progress {
    width: 100%;
    display: flex;
    gap: 2.55px;
    justify-content: center;
    align-items: center;
}

.balance-modal .bottomPart .box01 .progress .colorBlock {
    width: 27px;
    height: 8px;
    background: rgba(6, 117, 96, 1);
}

.balance-modal .bottomPart .box01 .progress .outlineBlock {
    width: 27px;
    height: 8px;
    border: 1px solid rgba(6, 117, 96, 1);
}

.balance-modal .bottomPart .box01 .btns {
    width: 100%;
    display: flex;
    gap: 12.71px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 12px;
}

.balance-modal .bottomPart .box01 .btns a,
.outline-button {
    width: 100%;
    padding: 9.14px;
    border-radius: 8px;
    border: 2px solid rgba(18, 17, 23, 1);
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 14px;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(18, 17, 23, 1);
    outline: unset;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent;
}

.balance-modal .bottomPart .box01 .btns a,
.outline-button {
    width: 100%;
    padding: 9.14px;
    border-radius: 8px;
    border: 2px solid rgba(18, 17, 23, 1);
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 14px;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(18, 17, 23, 1);
    outline: unset;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent;
}

.balance-modal .bottomPart .bottomDetail {
    width: 100%;
    display: flex;
    gap: 10px;
    justify-content: space-between;
    align-items: center;
    margin-top: 12.71px;
    border-top: 1px dashed rgba(77, 76, 92, 1);
    padding: 16px 0 1px;
}

.balance-modal .bottomPart .bottomDetail .left {
    display: flex;
    gap: 4px;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.balance-modal .bottomPart .bottomDetail .left p {
    font-weight: 600;
    font-size: 14px;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
    margin-bottom: 0;
}

.balance-modal .bottomPart .bottomDetail .left p span {
    font-weight: 300;
}

.balance-modal .bottomPart .bottomDetail a {
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    text-decoration: underline;
    color: rgba(18, 17, 23, 1);
}

.balance-modal .bottomPart .box01 {
    width: 100%;
    display: flex;
    gap: 20px;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-start;
    display: none;
    flex: 1;
}

.balance-modal .bottomPart .box01 .lesson {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.balance-modal .bottomPart .box01 .lesson h1 {
    font-weight: 600;
    font-size: 28.25px;
    line-height: 42.38px;
    color: rgba(18, 17, 23, 1);
    text-transform: capitalize;
    margin-bottom: 0;
}

.balance-modal .bottomPart .box01 .lesson p {
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    color: rgba(77, 76, 92, 1);
    margin-bottom: 0;
}

.balance-modal .bottomPart .box01 .progress.fullBlank {
    gap: 0;
    border: 1px solid rgba(6, 117, 96, 1);
}

.balance-modal .bottomPart .box01 .progress {
    width: 100%;
    display: flex;
    gap: 2.55px;
    justify-content: center;
    align-items: center;
    background-color: transparent;
}

.balance-modal .bottomPart .box01 .progress.fullBlank .colorBlock {
    background: transparent;
}

.balance-modal .bottomPart .box01 .btns a,
.outline-button {
    width: 100%;
    padding: 9.14px;
    border-radius: 8px;
    border: 2px solid rgba(18, 17, 23, 1);
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 14px;
    line-height: 25.71px;
    letter-spacing: 0.09px;
    color: rgba(18, 17, 23, 1);
    outline: unset;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent;
}

.what-would-you-like-to-do-modal .headingAndLists {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
}

.what-would-you-like-to-do-modal .headingAndLists h4 {
    padding: 0 24px;
    font-weight: 500;
    font-size: 14px;
    line-height: 24px;
    color: rgba(77, 76, 92, 1);
}

.also-transfer-remaining-balance-modal,
.why-need-to-transfer-subscription-modal {
    padding: 60px 0 24px;
}

.also-transfer-remaining-balance-modal h1 {
    padding: 0 24px;
}

.why-need-to-transfer-subscription-modal::-webkit-scrollbar {
    width: 0;
    display: none;
}

.also-transfer-remaining-balance-modal .ProfileTransferComponent,
.why-need-to-transfer-subscription-modal .ProfileTransferComponent,
.why-need-to-transfer-subscription-modal .headingAndPera {
    margin: 0 24px;
}

.why-need-to-transfer-subscription-modal ul li .leftSide .content p {
    font-size: 16px;
    line-height: 24px;
}

.transfer-subscription-review-transfer-modal .whatHappensNext ul {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding: 0 24px;
    gap: 16px;
}

.transfer-subscription-review-transfer-modal .whatHappensNext ul li {
    width: 100%;
    list-style: disc;
    font-size: 16px;
    font-weight: 400;
    line-height: 24px;
    color: rgba(18, 17, 23, 1);
}

.transfer-subscription-review-transfer-modal .whatHappensNext h1 {
    font-size: 18px;
    font-weight: 600;
    line-height: 24px;
    color: rgba(0, 0, 0, 1);
    margin-bottom: unset;
}

.transfer-subscription-review-transfer-modal h1 {
    font-size: 28px;
    font-weight: 600;
    color: rgba(18, 17, 23, 1);
    margin: 0;
}

.transfer-subscription-review-transfer-modal .englishWithContainer {
    width: 230px;
    height: 232px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 18px;
    margin-top: 19px;
}

.transfer-subscription-review-transfer-modal .englishWithContainer .englishWithDaniela {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    gap: 4px;
}

.transfer-subscription-review-transfer-modal .englishWithContainer .englishWithDaniela h2 {
    font-size: 16px;
    font-weight: 500;
    line-height: 24px;
    color: rgba(0, 0, 0, 1);
    margin-bottom: 0;
}

.transfer-subscription-review-transfer-modal .englishWithContainer .englishWithDaniela p {
    font-size: 14px;
    font-weight: 500;
    line-height: 24px;
    color: rgba(0, 0, 0, 70%);
    margin-bottom: 0;
}

.transfer-subscription-review-transfer-modal .englishWithContainer .englishWithDaniela span {
    font-size: 14px;
    font-weight: 500;
    line-height: 24px;
    color: rgba(0, 0, 0, 70%);
}

.transfer-subscription-review-transfer-modal .englishWithContainer svg {
    width: 23.74px;
    height: 23.12px;
}
</style>

<style>
/* new styles */
#what-would-you-like-to-do-modal {
    
}
</style>
<!-- new styles -->

<!-- jQuery to Toggle Modal -->
<script>
$(document).ready(function() {
    // Show the modal on button click
    $('#openModal').on('click', function(e) {
        e.stopPropagation(); // stop bubbling so the document handler doesn't immediately close it
        $('#balanceModal').removeClass('active');

        $('#subscribeModal').addClass('active');
        $('.backdrop-level-1').addClass('active');
    });

    $('#openBalance').on('click', function(e) {
        e.stopPropagation(); // stop bubbling so the document handler doesn't immediately close it
        $('#subscribeModal').removeClass('active');

        $('#balanceModal').addClass('active');
        $('.backdrop-level-1').addClass('active');
    });

    // Close modal if user clicks anywhere outside of it
    $(document).on('click', function(e) {
        const $modal = $('#subscribeModal');
        const $balanceModal = $('#balanceModal');

        // if the target of the click isn't the modal nor a descendant of the modal
        if (!$modal.is(e.target) && $modal.has(e.target).length === 0 || $balanceModal.is(e.target) &&
            $balanceModal.has(e.target).length === 0) {
            $modal.removeClass('active');
            $balanceModal.removeClass('active');
            $('.backdrop-level-1').removeClass('active');
        }
    });
    // added js below
    $('#transfer-balance-or-subscription').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-balance-screen-1').addClass('active');
        $('.backdrop-level-3').addClass('active');
    });
    // $('.closeIcon').on('click', function(e) {
    //     e.stopPropagation(); // prevent bubbling
    //     $('.backdrop-level-3').removeClass('active');
    // });
    // $('#transfer-balance-or-subscription-modol-open').on('click', function(e) {
    //     e.stopPropagation(); // prevent bubbling
    //     $('#what-would-you-like-to-do-modal').addClass('active');
    //     $('.backdrop-level-3').addClass('active');
    // });
    $('.action').on('click', function () {
        const openId = $(this).data('open');
        const closeId = $(this).data('close');

        if (openId) {
            $('#' + openId).addClass('active');
        }

        if (closeId) {
            $('#' + closeId).removeClass('active');
        }
    });
     $('.back-action').on('click', function () {
        const openId = $(this).data('open');
        const closeId = $(this).data('close');

        if (openId) {
            $('#' + openId).addClass('active');
        }

        if (closeId) {
            $('#' + closeId).removeClass('active');
        }
    });

    $('.open-thank-you-note').on('click', function (){
        $('#' + 'thank-you-note').addClass('active');
        $('.' + 'backdrop-level-4').addClass('active');
    })
    $('.close-thank-you-note').on('click', function (){
        $('#' + 'thank-you-note').removeClass('active');
        $('.' + 'backdrop-level-4').removeClass('active');
    })
    $('#check-lesson-box').on('change', function () {
        if ($(this).is(':checked')) {
            // CHECKED
            $('#check-count').hide();
            $('#check-lesson-div').show();
            $('#cancel-selected-lesson').prop('disabled', false);
        } else {
            // UNCHECKED
            $('#check-count').show();
            $('#check-lesson-div').hide();
            $('#cancel-selected-lesson').prop('disabled', true);
        }
    });

    $('.show-thank-you-event').on('click', function () {
        $('#thank-you-action-box').show();
        $('#show-note-box').hide();
    })
    $('.hide-thank-you-event').on('click', function () {
        $('#thank-you-action-box').hide();
        $('#show-note-box').hide();
    })
    
    $('#add-thank-you-note').on('click', function () {
        $('#show-note-box').text($('#thank-you-comment').val());
        $('#show-note-box').show();
        $('#thank-you-action-box').hide();
        $('#' + 'thank-you-note').removeClass('active');
        $('.' + 'backdrop-level-4').removeClass('active');
    })

    // added js above

    $('.closeIcon-one').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('.what-would-you-like-to-do-modal').removeClass('active');
        $('.backdrop-level-3').removeClass('active');
    });

    // Make sure your HTML trigger has something like: data-set="Wade Warren"
    $(document).on('click', '.transfer-from-modal-open', function(e) {
        e.stopPropagation();

        // read the data attribute and stash it
        const tutor = this.getAttribute('data-set'); // e.g., "Wade Warren"
        if (tutor) localStorage.setItem('tutor', tutor);
        if (tutor === "new-tutor") {
            $('#transfer-from-modal').addClass('active');
        } else if (tutor === "current-tutor") {
            $('#transfer-from-modal').addClass('active');
        } else if (tutor === "another-tutor") {
            $('#transfer-subscription-from-modal').addClass('active');
        }

    });


    $('.backIcon-one').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling so doc click doesn't immediately close it
        $('#transfer-from-modal').removeClass('active');
    });
    $('.closeIcon-two').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-from-modal').removeClass('active');
    });
    $('.transfer-to-modal-open').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling so doc click doesn't immediately close it
        let tutor = localStorage.getItem('tutor');

        if (tutor === "new-tutor") {
            $('#transfer-remaining-balance-transfer-to').addClass('active');
        } else if (tutor === "current-tutor") {
            $('#transfer-to-modal').addClass('active');
        } else if (tutor === "another-tutor") {
            $('#transfer-subscription-from-modal').addClass('active');
        }

    });

    $('.backIcon-two').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling so doc click doesn't immediately close it
        $('#transfer-to-modal').removeClass('active');
    });



    $('.closeIcon-three').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-to-modal').removeClass('active');
    });
    $('.closeIcon-four').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-to-modal').removeClass('active');
    });
    $('.how-many-lessons-you-want-modal-open').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#how-many-lessons-you-want-modal').addClass('active');
    });
    $('.backIcon-three').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling so doc click doesn't immediately close it
        $('#how-many-lessons-you-want-modal').removeClass('active');
    });
    $('.closeIcon-four').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#how-many-lessons-you-want-modal').removeClass('active');
    });

    $('.show-breakdown-modal-open').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#show-break-down-modal').addClass('active');
    });

    $('.closeIcon-five').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#show-break-down-modal').removeClass('active');
    });
    $('.review-your-transfer-modal-open').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        // $('#review-your-transfer-modal').addClass('active');
    });

    $('.closeIcon-six').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#review-your-transfer-modal').removeClass('active');
    });
    $('.backIcon-six').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#review-your-transfer-modal').removeClass('active');
    });

    $('.transfer-complete-modal-Open').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-complete-modal').addClass('active');
    });
    $('.closeIcon-seven').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-complete-modal').removeClass('active');
    });

    $('.close-eight').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-complete-modal').removeClass('active');
    });

    $('.closeIcon-nine').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-remaining-balance-transfer-to').removeClass('active');
    });
    $('.backIcon-nine').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-remaining-balance-transfer-to').removeClass('active');
        $('#choose-your-trial-lesson-duration-modal').removeClass('active');
    });

    $('.closeIcon-ten').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#choose-your-trial-lesson-duration-modal').removeClass('active');
    });
    $('.backIcon-ten').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#choose-your-trial-lesson-duration-modal').removeClass('active');
        // $('#transfer-remaining-balance-transfer-to').removeClass('active');
    });
    $('.closeIcon-eleven').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-subscription-from-modal').removeClass('active');
    });
    $('.backIcon-eleven').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-subscription-from-modal').removeClass('active');
        // $('#transfer-remaining-balance-transfer-to').removeClass('active');
    });

    $('.closeIcon-twelve').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-subscription-to-modal').removeClass('active');
    });
    $('.backIcon-twelve').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-subscription-to-modal').removeClass('active');
    });

    $('.closeIcon-thirteen').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#also-transfer-remaining-balance-modal').removeClass('active');
    });
    $('.backIcon-thirteen').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#also-transfer-remaining-balance-modal').removeClass('active');
        $('#choose-your-trial-lesson-duration-modal').removeClass('active');
    });
    $('.backIcon-fourteen').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#why-need-to-transfer-subscription-modal').removeClass('active');
    });
    $('.closeIcon-fourteen').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#why-need-to-transfer-subscription-modal').removeClass('active');
    });

    $('.closeIcon-fifteen').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-subscription-review-transfer-modal').removeClass('active');
    });




    $('.backIcon-fifteen').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-subscription-review-transfer-modal').removeClass('active');
        $('#why-need-to-transfer-subscription-modal').removeClass('active');
        //  $('#choose-your-trial-lesson-duration-modal').removeClass('active');
    });



    $('.choose-your-trial-lesson-duration-modal-open').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#choose-your-trial-lesson-duration-modal').addClass('active');
    });
    $('.transfer-subscription-to-modal-open').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-subscription-to-modal').addClass('active');
    });

    $('.also-transfer-remaining-balance-modal-open').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#also-transfer-remaining-balance-modal').addClass('active');
    });
    $('.why-need-to-transfer-subscription-modal-open').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#why-need-to-transfer-subscription-modal').addClass('active');
    });
    $('.transfer-subscription-review-transfer-modal-open').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('#transfer-subscription-review-transfer-modal').addClass('active');
    });

    $('.closeIcon').on('click', function(e) {
        e.stopPropagation(); // prevent bubbling
        $('.custom-modal').removeClass('active');
        $('.backdrop-level-1').removeClass('active');
        $('.backdrop-level-2').removeClass('active');
        $('.backdrop-level-3').removeClass('active');
    });

    // ------- config / state -------
    const Variable = {
        totalLesson: 0,
        is6Lessons: false,
        balance: 29.44, // current balance shown in the UI
        stepsBeforeTopUp: 5, // first 5 lessons covered by balance
        maxLessons: 6
    };

    // ------- element map to your modal -------
    const modalRoot = document.getElementById("how-many-lessons-you-want-modal");

    const elements = {
        // buttons
        HowManyLessonsYouWantModalIncrementLesson: modalRoot.querySelector(".increment-lesson"),
        HowManyLessonsYouWantModalDecrementLesson: modalRoot.querySelector(".decrement-lesson"),
        reviewYourTransferModalOpen: modalRoot.querySelectorAll(".review-your-transfer-modal-open"),

        // text / numbers
        HowManyLessonsYouWantModalLessonCount: modalRoot.querySelector(".lesson-count"),
        HowManyLessonsYouWantModalBalanceUsed: modalRoot.querySelector(".balance-used"),

        // progress bar
        HowManyLessonsYouWantModalLessonProgress: modalRoot.querySelector(".lesson-progress"),

        // special states
        HowManyLessonsYouWantModalSixLessonSelected: modalRoot.querySelector(".six-lesson-selected"),
    };

    // convenience: progress border container
    const progressContainer = modalRoot.querySelector(".progress");

    // ------- helpers -------
    const clamp = (num, min, max) => Math.max(min, Math.min(max, num));

    function updateVisuals() {
        // lesson text
        elements.HowManyLessonsYouWantModalLessonCount.textContent =
            `${Variable.totalLesson} ${Variable.totalLesson === 1 ? "lesson" : "lessons"}`;

        // progress width: first 5 steps fill 0% -> 100%
        const widthPct = Math.min(Variable.totalLesson, Variable.stepsBeforeTopUp) * 100 / Variable
            .stepsBeforeTopUp;
        elements.HowManyLessonsYouWantModalLessonProgress.style.width = `${widthPct}%`;

        // balance used = proportion of balance consumed within first 5 lessons
        const used = (Math.min(Variable.totalLesson, Variable.stepsBeforeTopUp) * (Variable.balance / Variable
            .stepsBeforeTopUp));
        elements.HowManyLessonsYouWantModalBalanceUsed.textContent = `$${Number(used).toFixed(2)}`;

        // enable/disable decrement at zero
        if (Variable.totalLesson === 0) {
            elements.HowManyLessonsYouWantModalDecrementLesson.classList.add("disabled");
        } else {
            elements.HowManyLessonsYouWantModalDecrementLesson.classList.remove("disabled");
        }

        // enable Continue CTA once > 0
        elements.reviewYourTransferModalOpen[0]?.classList.toggle("disabled", Variable.totalLesson === 0);

        // 6th lesson visual state
        const isSix = Variable.totalLesson > Variable.stepsBeforeTopUp;
        Variable.is6Lessons = isSix;

        if (isSix) {
            // show yellow info box
            elements.HowManyLessonsYouWantModalSixLessonSelected.style.display = "flex";

            // swap progress color + border to brown (matches your previous code)
            elements.HowManyLessonsYouWantModalLessonProgress.style.backgroundColor = "rgba(149, 98, 7, 1)";
            progressContainer.style.borderColor = "rgba(149, 98, 7, 1)";

            // lock increment at 6
            elements.HowManyLessonsYouWantModalIncrementLesson.classList.add("disabled");
        } else {
            // hide yellow info, restore defaults
            elements.HowManyLessonsYouWantModalSixLessonSelected.style.display = "none";
            elements.HowManyLessonsYouWantModalLessonProgress.style.backgroundColor = "";
            progressContainer.style.borderColor = "rgba(6, 117, 96, 1)";
            elements.HowManyLessonsYouWantModalIncrementLesson.classList.remove("disabled");
        }
    }

    function increment() {
        Variable.totalLesson = clamp(Variable.totalLesson + 1, 0, Variable.maxLessons);
        updateVisuals();
    }

    function decrement() {
        Variable.totalLesson = clamp(Variable.totalLesson - 1, 0, Variable.maxLessons);
        updateVisuals();
    }

    // ------- wire up listeners (your module's logic, adapted to selectors) -------
    function SetupLessonCountListener() {
        // initial UI state
        elements.HowManyLessonsYouWantModalDecrementLesson.classList.add("disabled");
        elements.reviewYourTransferModalOpen[0]?.classList.add("disabled");
        updateVisuals();

        elements.HowManyLessonsYouWantModalIncrementLesson.addEventListener("click", () => {
            if (Variable.totalLesson < Variable.maxLessons) increment();
        });

        elements.HowManyLessonsYouWantModalDecrementLesson.addEventListener("click", () => {
            if (Variable.totalLesson > 0) decrement();
        });
    }
    SetupLessonCountListener();

    // init when modal becomes active the first time
    // let lessonsListenerAttached = false;
    // const observer = new MutationObserver(() => {
    //     debugger;
    //     // const isActive = modalRoot.classList.contains("active");
    //     const isActive = true;
    //     if (isActive && !lessonsListenerAttached) {
    //         SetupLessonCountListener();
    //         lessonsListenerAttached = true;
    //     }
    // });
    // observer.observe(modalRoot, {
    //     attributes: true,
    //     attributeFilter: ["class"]
    // });
});

</script>
<script>
    $(document).ready(function() {
    const $dropdown = $('.payment-method-dropdown');
    const $selectedValue = $dropdown.find('.selected-value');
    const $optionsWrapper = $dropdown.find('.options-wrapper');
    const $options = $dropdown.find('.payment-options');

    // Toggle dropdown
    $selectedValue.on('click', function (e) {
    e.stopPropagation(); // prevent document click
    $optionsWrapper.toggle();
    });

    // Select option
    $options.on('click', function (e) {
    e.stopPropagation();
    $selectedValue.text($(this).text());
    $optionsWrapper.hide();
    });

    // Close on outside click
    $(document).on('click', function () {
    $optionsWrapper.hide();
    });

    });
</script>

