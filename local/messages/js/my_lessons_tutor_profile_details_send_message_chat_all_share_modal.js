function openShareModal() {
  var modal = document.getElementById('shareTutorModal');
  if (!modal) return;
  modal.style.display = 'flex';
  document.body.classList.add('modal_open');
}

function closeShareModal() {
  var modal = document.getElementById('shareTutorModal');
  if (!modal) return;
  modal.style.display = 'none';
  document.body.classList.remove('modal_open');
}

// Close when clicking on dimmed background
document.addEventListener('click', function (e) {
  var backdrop = document.getElementById('shareTutorModal');
  if (!backdrop) return;
  if (e.target === backdrop) {
    closeShareModal();
  }
});

function copyLink() {
  var input = document.getElementById('shareLink');
  var btn = document.getElementById('copyLinkButton');

  if (!input) return;

  var textToCopy = input.value;

  // Modern API first
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(textToCopy).then(function () {
      showCopied(btn);
    }).catch(function () {
      legacyCopy(input, btn);
    });
  } else {
    legacyCopy(input, btn);
  }
}

function legacyCopy(input, btn) {
  input.removeAttribute('readonly');
  input.select();
  input.setSelectionRange(0, 99999);
  document.execCommand('copy');
  input.setAttribute('readonly', 'readonly');
  showCopied(btn);
}

function showCopied(btn) {
  if (!btn) return;
  var original = btn.textContent;
  btn.textContent = 'Copied!';
  btn.classList.add('modal_copy_btn_success');

  setTimeout(function () {
    btn.textContent = original;
    btn.classList.remove('modal_copy_btn_success');
  }, 1200);
}
