<!DOCTYPE html>
<html lang="en">

<?php

require_once($CFG->dirroot . '/config.php');
require_login();

global $DB, $PAGE;

/** Collect unique teacher user IDs from cohorts */
$userids = $DB->get_fieldset_sql("
    SELECT DISTINCT uid FROM (
        SELECT cohortmainteacher AS uid FROM {cohort}
         WHERE cohortmainteacher IS NOT NULL AND cohortmainteacher > 0
        UNION
        SELECT cohortguideteacher AS uid FROM {cohort}
         WHERE cohortguideteacher IS NOT NULL AND cohortguideteacher > 0
    ) t
");

/** Fetch user records */
$teachers_js = [];

if ($userids) {
    list($insql, $params) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
    $fields = "id, firstname, lastname, picture, imagealt,
               firstnamephonetic, lastnamephonetic, middlename, alternatename";

    $teachers = $DB->get_records_select(
        'user',
        "id $insql AND deleted = 0 AND suspended = 0",
        $params,
        'firstname ASC, lastname ASC',
        $fields
    );

    foreach ($teachers as $t) {
        $pic = new user_picture($t);
        $pic->size = 50;

        $teachers_js[] = [
            'id'     => (int)$t->id,
            'name'   => fullname($t, true),
            'avatar' => $pic->get_url($PAGE)->out(false),
        ];
    }
}

/* =====================================================
 * STUDENTS = ALL MEMBERS OF ALL COHORTS
 * ===================================================== */
$students_js = [];

/** Get all unique cohort members */
$studentids = $DB->get_fieldset_sql("
    SELECT DISTINCT userid
      FROM {cohort_members}
");

if ($studentids) {
    list($insql, $params) = $DB->get_in_or_equal($studentids, SQL_PARAMS_NAMED);
    $students = $DB->get_records_select(
        'user',
        "id $insql AND deleted = 0 AND suspended = 0",
        $params,
        'firstname ASC, lastname ASC',
        'id, firstname, lastname, picture, imagealt, firstnamephonetic, lastnamephonetic, middlename, alternatename'
    );

    foreach ($students as $s) {
        $pic = new user_picture($s);
        $pic->size = 50;

        $students_js[] = [
            'id'     => (int)$s->id,
            'name'   => fullname($s, true),
            'avatar' => $pic->get_url($PAGE)->out(false),
        ];
    }
}

/* =====================================================
 * ADMIN = CURRENT LOGGED-IN USER
 * ===================================================== */
$admin_js = [];
global $USER;
if ($USER && !empty($USER->id)) {
    $pic = new user_picture($USER);
    $pic->size = 50;
    $admin_js[] = [
        'id'     => (int)$USER->id,
        'name'   => fullname($USER, true),
        'avatar' => $pic->get_url($PAGE)->out(false),
    ];
}
?>

<head>
    <meta charset="UTF-8">
    <title>Profile Role Dropdown</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
    /* ===== BACKDROP ===== */
    .backdrop-level-profile-role {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .2);
        opacity: 0;
        visibility: hidden;
        transition: .2s;
        z-index: 3;
    }

    .backdrop-level-profile-role.active {
        opacity: 1;
        visibility: visible;
    }

    /* ===== DROPDOWN ===== */
    .profile-role-dropdown-section {
        position: fixed;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: .2s;
        z-index: 4;
    }

    .profile-role-dropdown-section.active {
        opacity: 1;
        visibility: visible;
        pointer-events: all;
    }

    .profile-role-dropdown-card {
        width: 452px;
        background: #fff;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, .15);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* ===== TABS ===== */
    .profile-role-dropdown-tabs {
        display: flex;
        gap: 8px;
    }

    .profile-role-dropdown-tab {
        flex: 1;
        padding: 14px;
        border-radius: 12px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 2px solid rgba(0, 0, 0, .12);
        background: #fff;
    }

    .profile-role-dropdown-tab.active {
        border-color: #000;
    }

    .profile-role-dropdown-radio {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #dcdce5;
        background: #fff;
        position: relative;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: border-color 0.2s;
    }

    .profile-role-dropdown-tab.active .profile-role-dropdown-radio {
        border-color: #121117;
    }

    .profile-role-dropdown-radio::after {
        content: '';
        position: absolute;
        width: 8px;
        height: 8px;
        background: #121117;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: opacity 0.2s;
    }

    .profile-role-dropdown-tab.active .profile-role-dropdown-radio::after {
        opacity: 1;
    }

    /* ===== CONTENT ===== */
    .profile-role-hidden {
        display: none !important;
    }

    .profile-role-dropdown-search input {
        width: 100%;
        height: 48px;
        border-radius: 12px;
        border: 2px solid rgba(0, 0, 0, .12);
        padding: 0 12px;
        background: transparent;
    }

    .profile-role-dropdown-reset-wrapper {
        text-align: right;
    }

    .profile-role-dropdown-reset-wrapper button {
        background: transparent;
        border: 1px solid #e6e6e9;
        padding: 6px 10px;
        color: #232323;
        border-radius: 8px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        border: none;
        align-items: center;
        gap: 6px;
        transition: background-color 0.2s, border-color 0.2s;
    }

    .profile-role-dropdown-user-list {
        border: 1px solid #eee;
        border-radius: 8px;
        height: 300px;
        overflow-y: auto;
        padding: 8px;
    }

    .profile-role-dropdown-user-list::-webkit-scrollbar {
        width: 0px;
    }

    .profile-role-dropdown-user-list::-webkit-scrollbar-track {
        background-color: #f1f1f1;
    }

    .profile-role-dropdown-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        border-radius: 8px;
        cursor: pointer;
    }

    .profile-role-dropdown-user:hover {
        background: #f5f5f5;
    }

    .profile-role-dropdown-user img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
    }

    .profile-role-dropdown-user input[type="radio"] {
        display: none;
    }

    .profile-role-custom-radio {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #dcdce5;
        background: #fff;
        flex-shrink: 0;
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: border-color 0.2s;
    }

    .profile-role-custom-radio::after {
        content: '';
        width: 8px;
        height: 8px;
        background: #121117;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .profile-role-dropdown-user input[type="radio"]:checked+.profile-role-custom-radio {
        border-color: #121117;
    }

    .profile-role-dropdown-user input[type="radio"]:checked+.profile-role-custom-radio::after {
        opacity: 1;
    }

    .profile-role-dropdown-user span {
        flex: 1;
    }
    </style>
</head>

<body>



    <section class="backdrop-level-profile-role" id="backdrop"></section>

    <section class="profile-role-dropdown-section" id="profileRoleDropdown">
        <div class="profile-role-dropdown-card">

            <!-- TABS -->
            <div class="profile-role-dropdown-tabs">
                <div class="profile-role-dropdown-tab active" data-role="admin">
                    Admin <div class="profile-role-dropdown-radio"></div>
                </div>
                <div class="profile-role-dropdown-tab" data-role="student">
                    Student <div class="profile-role-dropdown-radio"></div>
                </div>
                <div class="profile-role-dropdown-tab" data-role="teacher">
                    Teacher <div class="profile-role-dropdown-radio"></div>
                </div>
            </div>

            <!-- CONTENT -->
            <div id="listArea">

                <div class="profile-role-dropdown-search">
                    <input type="search" id="searchInput" placeholder="Search Teacher">
                </div>

                <div class="profile-role-dropdown-reset-wrapper">
                    <button id="resetBtn"><img src="./img/reset-icon.svg" alt=""> Reset</button>
                </div>

                <div class="profile-role-dropdown-user-list" id="userList"></div>

            </div>

        </div>
    </section>

    <script>
    /* ===== DATA ===== */
    const data = {
        // student: [{
        //         name: "Jane Cooper",
        //         avatar: "https://i.pravatar.cc/80?img=45"
        //     },
        //     {
        //         name: "Guy Hawkins",
        //         avatar: "https://i.pravatar.cc/80?img=12"
        //     },
        //     {
        //         name: "Devon Lane",
        //         avatar: "https://i.pravatar.cc/80?img=32"
        //     }
        // ],
        student: <?php echo json_encode($students_js, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        // teacher: [{
        //         name: "Daniela",
        //         avatar: "https://i.pravatar.cc/80?img=29"
        //     },
        //     {
        //         name: "Mary Janes",
        //         avatar: "https://i.pravatar.cc/80?img=48"
        //     },
        //     {
        //         name: "Lane",
        //         avatar: "https://i.pravatar.cc/80?img=15"
        //     },
        //     {
        //         name: "Warren",
        //         avatar: "https://i.pravatar.cc/80?img=22"
        //     },
        //     {
        //         name: "Fox",
        //         avatar: "https://i.pravatar.cc/80?img=8"
        //     }
        // ],
        teacher: <?php echo json_encode($teachers_js, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        // admin: [{
        //     name: "Admin User 1",
        //     avatar: "https://i.pravatar.cc/80?img=5"
        // }]
        admin: <?php echo json_encode($admin_js,   JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
    };

    let state = {
        role: "admin",
        search: "",
        selected: "",
        selectedUser: null
    };

    /* ===== ELEMENTS ===== */
    const dropdown = document.getElementById("profileRoleDropdown");
    const backdrop = document.getElementById("backdrop");
    const tabs = document.querySelectorAll(".profile-role-dropdown-tab");
    const listArea = document.getElementById("listArea");
    const userList = document.getElementById("userList");
    const searchInput = document.getElementById("searchInput");

    /* ===== FUNCTIONS ===== */
    function getDefaultButtonText(role) {
        if (role === "admin" && data.admin && data.admin.length > 0) {
            const admin = data.admin[0];
            return `<img src="${admin.avatar}" style="width: 23px; height: 23px; border-radius: 8px; margin-right: 8px;">
                    <span>${admin.name}</span>
                    <span class="dropdown-arrow" style="margin-left: auto;"></span>`;
        }
        const roleText = role.charAt(0).toUpperCase() + role.slice(1);
        return `<span>Select ${roleText}</span><span class="dropdown-arrow"></span>`;
    }

    function renderUsers() {
        userList.innerHTML = "";
        if (state.role === "admin") {
            // Show admin info only, no selection
            if (data.admin && data.admin.length > 0) {
                const admin = data.admin[0];
                const div = document.createElement("div");
                div.className = "profile-role-dropdown-user";
                div.innerHTML = `
                    <img src="${admin.avatar}">
                    <span>${admin.name}</span>
                `;
                userList.appendChild(div);
            } else {
                userList.innerHTML = "<p style='text-align:center;color:#777'>No admin found</p>";
            }
            return;
        }
        if (!data[state.role]) return;
        const filtered = data[state.role].filter(u =>
            u.name.toLowerCase().includes(state.search.toLowerCase())
        );
        if (!filtered.length) {
            userList.innerHTML = "<p style='text-align:center;color:#777'>No results</p>";
            return;
        }
        filtered.forEach((user, index) => {
            const label = document.createElement("label");
            label.className = "profile-role-dropdown-user";
            label.innerHTML = `
                <img src="${user.avatar}">
                <span>${user.name}</span>
                <input type="radio" name="userSelection" value="${user.name}" ${state.selected === user.name ? 'checked' : ''}>
                <div class="profile-role-custom-radio"></div>
            `;
            userList.appendChild(label);
        });
    }

    function toggleListArea() {
        if (state.role === "admin") {
            listArea.classList.add("profile-role-hidden");
        } else {
            listArea.classList.remove("profile-role-hidden");
            renderUsers();
        }
    }

    /* ===== EVENTS ===== */
    document.getElementById("openProfileRoleDropdown").onclick = () => {
        const button = document.getElementById("openProfileRoleDropdown");
        const rect = button.getBoundingClientRect();

        // Set admin as default when opening
        state.role = "admin";
        state.search = "";
        state.selected = data.admin && data.admin.length > 0 ? data.admin[0].name : "";
        state.selectedUser = data.admin && data.admin.length > 0 ? data.admin[0] : null;

        // Set tab UI
        tabs.forEach(t => t.classList.remove("active"));
        tabs[0].classList.add("active");

        // Reset button text
        if (button) {
            button.innerHTML = getDefaultButtonText("admin");
        }

        searchInput.value = "";
        toggleListArea();

        dropdown.style.top = (rect.bottom + 3) + "px";
        dropdown.style.left = (rect.right - 452) + "px";

        dropdown.classList.add("active");
        backdrop.classList.add("active");
    };

    backdrop.onclick = () => {
        dropdown.classList.remove("active");
        backdrop.classList.remove("active");
    };

    tabs.forEach(tab => {
        tab.onclick = () => {
            tabs.forEach(t => t.classList.remove("active"));
            tab.classList.add("active");

            state.role = tab.dataset.role;
            state.search = "";
            state.selected = "";
            state.selectedUser = null;
            searchInput.value = "";

            const roleText = tab.dataset.role.charAt(0).toUpperCase() + tab.dataset.role.slice(1);
            searchInput.placeholder = `Search ${roleText}`;

            // Reset button to default text for selected role
            if (document.getElementById("openProfileRoleDropdown")) {
                document.getElementById("openProfileRoleDropdown").innerHTML = getDefaultButtonText(tab
                    .dataset.role);
            }

            toggleListArea();
        };
    });

    searchInput.oninput = e => {
        state.search = e.target.value;
        renderUsers();
    };

    userList.addEventListener('change', (e) => {
        if (state.role === "admin") return; // No selection for admin
        if (e.target.type === 'radio') {
            const selectedName = e.target.value;
            const selectedUser = data[state.role].find(u => u.name === selectedName);

            state.selected = selectedName;
            state.selectedUser = selectedUser;

            // Debug payload for the selected user
            if (selectedUser) {
                console.log('Selected user payload:', {
                    id: selectedUser.id,
                    name: selectedUser.name
                });

                // 🔐 LOGIN AS SELECTED USER
                if (selectedUser && selectedUser.id) {
                    window.location.href =
                        M.cfg.wwwroot +
                        '/local/loginas.php' +
                        '?userid=' + selectedUser.id +
                        '&sesskey=' + M.cfg.sesskey;
                }
            }

            // Update the button with selected user's info
            if (selectedUser && document.getElementById("openProfileRoleDropdown")) {
                const button = document.getElementById("openProfileRoleDropdown");
                button.innerHTML = `
                    <img src="${selectedUser.avatar}" style="width: 23px; height: 23px; border-radius: 8px; margin-right: 8px;">
                    <span>${selectedUser.name}</span>
                    <span class="dropdown-arrow" style="margin-left: auto;"></span>
                `;
            }
        }
    });

    document.getElementById("resetBtn").onclick = () => {
        state.search = "";
        state.selected = "";
        state.selectedUser = null;
        searchInput.value = "";

        // Reset button to default text for current role
        if (document.getElementById("openProfileRoleDropdown")) {
            document.getElementById("openProfileRoleDropdown").innerHTML = getDefaultButtonText(state.role);
        }

        renderUsers();
    };

    /* ===== INIT ===== */
    // Set admin as default on load, but do not select admin
    state.role = "admin";
    state.search = "";
    state.selected = "";
    state.selectedUser = null;
    // Set tab UI
    tabs.forEach(t => t.classList.remove("active"));
    tabs[0].classList.add("active");
    if (document.getElementById("openProfileRoleDropdown")) {
        document.getElementById("openProfileRoleDropdown").innerHTML = getDefaultButtonText("admin");
    }
    searchInput.value = "";
    toggleListArea();
    </script>

</body>

</html>