<?php
// ============================================================================
// Teacher-only Searchable Dropdown (cohort-filtered) + Custom Arrow SVGs
// ============================================================================

require_login();
defined('MOODLE_INTERNAL') || die();

global $DB, $PAGE;

// ---- CONFIG: set your cohort ID for "Teachers" here ----
$teachercohortid = 93; // <— CHANGE if needed

// ---- CONFIG: point to your custom arrow SVG files ----
// Use absolute paths on your server or moodle_path_to_plugin/pix/... etc.
$leftsvgpath  = __DIR__ . '/left.svg';   // e.g. __DIR__.'/pix/left.svg'
$rightsvgpath = __DIR__ . '/right.svg';  // e.g. __DIR__.'/pix/right.svg'

// Try to inline the SVGs; fall back to simple chevrons if missing.
$leftsvg  = @file_get_contents($leftsvgpath);
$rightsvg = @file_get_contents($rightsvgpath);

$leftsvg_fallback = '<svg class="teacher_time_card_searchable_dropdown_svg teacher_time_card_searchable_dropdown_svg-lg" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>';
$rightsvg_fallback = '<svg class="teacher_time_card_searchable_dropdown_svg teacher_time_card_searchable_dropdown_svg-lg" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>';

// Read current teacherid from URL (optional)
$teacherid = optional_param('teacherid', 0, PARAM_INT);

// --------------------------------------------------------------------------
// Fetch teachers: only users who are members of the teachers cohort (not deleted).
// Returns array keyed by user ID.
$sql = "
    SELECT u.id, u.username, u.firstname, u.lastname, u.email, u.picture, u.imagealt, u.emailstop
    FROM {user} u
    JOIN {cohort_members} cm ON u.id = cm.userid
    WHERE cm.cohortid = :cohortid
      AND u.deleted = 0
    ORDER BY u.lastname ASC, u.firstname ASC
";
$params = ['cohortid' => $teachercohortid];
$teachers = $DB->get_records_sql($sql, $params);

// --------------------------------------------------------------------------
// Build lightweight items for the widget (id, name, avatar URL)
$teacheritems = [];
if (!empty($teachers)) {
    foreach ($teachers as $t) {
        $up = new user_picture($t);
        $up->size = 1; // f1 (small)
        $avatarurl = $up->get_url($PAGE)->out(false);

        $teacheritems[] = [
            'id'     => (int)$t->id,
            'name'   => fullname($t),
            'avatar' => $avatarurl,
        ];
    }
}

// --------------------------------------------------------------------------
// Current label resolution
$currentname = '';
if (!empty($teachers)) {
    if ($teacherid && isset($teachers[$teacherid])) {
        $currentname = fullname($teachers[$teacherid]);
    } else {
        $first = reset($teachers);
        $teacherid = (int)$first->id;
        $currentname = fullname($first);
    }
}

$teacheritemsjson = json_encode($teacheritems, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT);
?>

<style>
/* ====== Teacher dropdown (no Tailwind needed) ====== */
.teacher_time_card_searchable_dropdown_wrap{display:flex;align-items:center;gap:8px}
.teacher_time_card_searchable_dropdown_btn{
  display:inline-flex;align-items:center;justify-content:center;
  height:40px;padding:0 12px;border:1px solid #e5e7eb;border-radius:10px;
  background:#fff;cursor:pointer;line-height:1;user-select:none
}
.teacher_time_card_searchable_dropdown_iconbtn{
  width:40px;height:40px;padding:0;border:1px solid #e5e7eb;border-radius:10px;background:#fff;cursor:pointer
}
.teacher_time_card_searchable_dropdown_btn:hover,
.teacher_time_card_searchable_dropdown_iconbtn:hover{background:#f9fafb}

.teacher_time_card_searchable_dropdown_label{font-weight:600;font-size:14px;margin-right:6px}

/* dropdown panel */
.teacher_time_card_searchable_dropdown_panel{
  position:absolute;z-index:9999;width:450px;max-width:92vw;display:none
}
.teacher_time_card_searchable_dropdown_card{
  background:#fff;border:1px solid #e5e7eb;border-radius:12px;
  box-shadow:0 8px 32px rgba(18,17,23,.15),0 16px 48px rgba(18,17,23,.15);
  overflow:hidden
}
.teacher_time_card_searchable_dropdown_head{padding:12px}
.teacher_time_card_searchable_dropdown_search{
  width:100%;height:44px;border:1px solid #e5e7eb;border-radius:10px;padding:0 12px;font-size:14px
}
.teacher_time_card_searchable_dropdown_list{
  max-height:360px;overflow:auto;padding:6px
}
.teacher_time_card_searchable_dropdown_row{
  display:flex;align-items:center;gap:12px;width:100%;
  padding:10px 12px;border-radius:6px;background:transparent;border:0;cursor:pointer;text-align:left
}
.teacher_time_card_searchable_dropdown_row:hover{background:#f3f4f6}
.teacher_time_card_searchable_dropdown_avatar{
  width:40px;height:40px;border-radius:8px;object-fit:cover;background:#f5f5f5
}
.teacher_time_card_searchable_dropdown_name{font-size:14px;color:#111}

/* backdrop */
#teacher_time_card_searchable_dropdown_backdrop{
  position:fixed;inset:0;background:rgba(0,0,0,.15);display:none
}

/* small chevrons (fallback style) */
.teacher_time_card_searchable_dropdown_svg{width:16px;height:16px;stroke:#111;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.teacher_time_card_searchable_dropdown_svg-lg{width:18px;height:18px}

/* Optional: normalize inline external SVG icon sizing */
.teacher_time_card_searchable_dropdown_iconbtn svg{width:18px;height:18px;display:block;margin:auto}
</style>

<div class="teacher_time_card_searchable_dropdown_wrap" id="teacher_time_card_searchable_dropdown_container">
  <button type="button" class="teacher_time_card_searchable_dropdown_iconbtn" id="teacher_time_card_searchable_dropdown_backbtn" aria-label="Previous teacher" <?php echo empty($teachers) ? 'disabled' : ''; ?>>
    <?php
      // Inline the provided left arrow SVG (or fallback)
      if (!empty($leftsvg)) {
          // Render inline so it inherits button color/size via CSS
          echo $leftsvg;
      } else {
          echo $leftsvg_fallback;
      }
    ?>
  </button>

  <button type="button" class="teacher_time_card_searchable_dropdown_btn" id="teacher_time_card_searchable_dropdown_trigger" aria-haspopup="listbox" aria-expanded="false" <?php echo empty($teachers) ? 'disabled' : ''; ?>>
    <span class="teacher_time_card_searchable_dropdown_label" id="teacher_time_card_searchable_dropdown_current_label"><?php echo s($currentname ?: ''); ?></span>
    <svg class="teacher_time_card_searchable_dropdown_svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
  </button>

  <button type="button" class="teacher_time_card_searchable_dropdown_iconbtn" id="teacher_time_card_searchable_dropdown_nextbtn" aria-label="Next teacher" <?php echo empty($teachers) ? 'disabled' : ''; ?>>
    <?php
      // Inline the provided right arrow SVG (or fallback)
      if (!empty($rightsvg)) {
          echo $rightsvg;
      } else {
          echo $rightsvg_fallback;
      }
    ?>
  </button>

  <!-- dropdown panel (ported to body) -->
  <div class="teacher_time_card_searchable_dropdown_panel" id="teacher_time_card_searchable_dropdown_dropdown">
    <div class="teacher_time_card_searchable_dropdown_card">
      <div class="teacher_time_card_searchable_dropdown_head">
        <input type="text" id="teacher_time_card_searchable_dropdown_search" class="teacher_time_card_searchable_dropdown_search" placeholder="Search teacher…">
      </div>
      <div id="teacher_time_card_searchable_dropdown_list" class="teacher_time_card_searchable_dropdown_list" role="listbox" aria-label="Teachers list"></div>
    </div>
  </div>
</div>

<div id="teacher_time_card_searchable_dropdown_backdrop" aria-hidden="true"></div>

<script>
(function(){
  // Data from PHP (teachers only — cohort filtered)
  const TEACHERS = <?php echo $teacheritemsjson ?: '[]'; ?>;
  let currentId = <?php echo (int)$teacherid; ?>;

  const qs = (sel, root=document) => root.querySelector(sel);

  const trigger   = qs('#teacher_time_card_searchable_dropdown_trigger');
  const label     = qs('#teacher_time_card_searchable_dropdown_current_label');
  const backBtn   = qs('#teacher_time_card_searchable_dropdown_backbtn');
  const nextBtn   = qs('#teacher_time_card_searchable_dropdown_nextbtn');
  const panel     = qs('#teacher_time_card_searchable_dropdown_dropdown');
  const list      = qs('#teacher_time_card_searchable_dropdown_list');
  const searchInp = qs('#teacher_time_card_searchable_dropdown_search');
  const backdrop  = qs('#teacher_time_card_searchable_dropdown_backdrop');

  let isOpen = false;
  let ported = false;

  function idxById(id){ return TEACHERS.findIndex(t => t.id === id); }
  function byId(id){ return TEACHERS.find(t => t.id === id) || null; }

  function setLabelById(id){
    const t = byId(id);
    if(t){ label.textContent = t.name; }
  }

  function renderList(filter=''){
    const q = filter.trim().toLowerCase();
    list.innerHTML = '';
    const items = TEACHERS.filter(t => t.name.toLowerCase().includes(q));
    if (!items.length){
      const empty = document.createElement('div');
      empty.style.padding = '14px 16px';
      empty.style.color = '#666';
      empty.textContent = 'No matches found';
      list.appendChild(empty);
      return;
    }
    items.forEach(t=>{
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'teacher_time_card_searchable_dropdown_row';
      btn.setAttribute('role','option');
      btn.innerHTML = `
        <img class="teacher_time_card_searchable_dropdown_avatar" src="${t.avatar}" alt="${t.name}">
        <div class="teacher_time_card_searchable_dropdown_name">${t.name}</div>
      `;
      btn.addEventListener('click', () => selectTeacher(t.id));
      list.appendChild(btn);
    });
  }

  function ensurePortaled(){
    if (!ported){
      document.body.appendChild(panel);
      ported = true;
    }
  }

  function positionPanel(){
    if (!isOpen) return;
    const rect = trigger.getBoundingClientRect();
    const gap = 8;
    const width = Math.min(450, window.innerWidth * 0.92);
    let left = rect.left + window.scrollX;
    let top  = rect.bottom + gap + window.scrollY;
    left = Math.max(window.scrollX + 8, Math.min(left, window.scrollX + window.innerWidth - width - 8));
    panel.style.left = left + 'px';
    panel.style.top  = top + 'px';
    panel.style.width = width + 'px';
  }

  function openPanel(){
    if (!TEACHERS.length) return;
    ensurePortaled();
    isOpen = true;
    panel.style.display = 'block';
    backdrop.style.display = 'block';
    renderList('');
    searchInp.value = '';
    setTimeout(()=> searchInp && searchInp.focus(), 0);
    window.addEventListener('scroll', positionPanel, true);
    window.addEventListener('resize', positionPanel);
    positionPanel();
    trigger && trigger.setAttribute('aria-expanded', 'true');
  }

  function closePanel(){
    isOpen = false;
    panel.style.display = 'none';
    backdrop.style.display = 'none';
    window.removeEventListener('scroll', positionPanel, true);
    window.removeEventListener('resize', positionPanel);
    trigger && trigger.setAttribute('aria-expanded', 'false');
  }

  function navigateToTeacher(id){
    const url = new URL(window.location.href);
    url.searchParams.set('teacherid', String(id));
    window.location.href = url.toString();
  }

  function selectTeacher(id){
    setLabelById(id);
    closePanel();
    navigateToTeacher(id);
  }

  // Init label (if currentId not in set, show first teacher)
  if (!byId(currentId) && TEACHERS.length){
    currentId = TEACHERS[0].id;
  }
  if (TEACHERS.length){
    setLabelById(currentId);
  } else if (label){
    label.textContent = '';
  }

  trigger && trigger.addEventListener('click', (e)=>{
    e.stopPropagation();
    isOpen ? closePanel() : openPanel();
  });

  searchInp && searchInp.addEventListener('input', (e)=> renderList(e.target.value || ''));

  document.addEventListener('click', (e)=>{
    if (!isOpen) return;
    if (!panel.contains(e.target) && !trigger.contains(e.target)) closePanel();
  });

  backdrop && backdrop.addEventListener('click', closePanel);

  backBtn && backBtn.addEventListener('click', ()=>{
    if (!TEACHERS.length) return;
    const i = idxById(currentId);
    const p = (i - 1 + TEACHERS.length) % TEACHERS.length;
    navigateToTeacher(TEACHERS[p].id);
  });

  nextBtn && nextBtn.addEventListener('click', ()=>{
    if (!TEACHERS.length) return;
    const i = idxById(currentId);
    const n = (i + 1) % TEACHERS.length;
    navigateToTeacher(TEACHERS[n].id);
  });

})();
</script>
