

<!--<button id="membership_withdraw_edit_btn">Edit Withdrawal</button>-->

<div id="membership_withdraw_backdrop"></div>

<div id="membership_withdraw_modal">
  <div class="membership_withdraw_modal_header">
    <h2>Verify your withdrawal to proceed</h2>
    <button class="membership_withdraw_close" aria-label="Close">&times;</button>
  </div>
  <div class="membership_withdraw_modal_body">
    <p>
      To help us make sure it’s really you, please enter a 6-digit verification code we sent to
      <strong>Admin</strong>
    </p>
    <div class="membership_withdraw_code_inputs">
      <input type="tel" maxlength="1" class="membership_withdraw_code_input" pattern="[0-9]*" autocomplete="one-time-code" />
      <input type="tel" maxlength="1" class="membership_withdraw_code_input" pattern="[0-9]*" autocomplete="one-time-code" />
      <input type="tel" maxlength="1" class="membership_withdraw_code_input" pattern="[0-9]*" autocomplete="one-time-code" />
      <input type="tel" maxlength="1" class="membership_withdraw_code_input" pattern="[0-9]*" autocomplete="one-time-code" />
      <input type="tel" maxlength="1" class="membership_withdraw_code_input" pattern="[0-9]*" autocomplete="one-time-code" />
      <input type="tel" maxlength="1" class="membership_withdraw_code_input" pattern="[0-9]*" autocomplete="one-time-code" />
    </div>
    <div class="membership_withdraw_note">
      <span>ℹ️</span>
      <p style="margin:0;">Please keep this window open until you have entered the code.</p>
    </div>
  </div>
  <div class="membership_withdraw_modal_footer">
    <button id="membership_withdraw_proceed_btn">Proceed</button>
    <button id="membership_withdraw_request_btn">Request a new code</button>
  </div>
</div>

<script>
  (function() {
    // Helpers
    function $(sel, ctx) { return (ctx || document).querySelector(sel); }
    function $all(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

    // Elementos
    var backdrop = $('#membership_withdraw_backdrop');
    var modal = $('#membership_withdraw_modal');
    var closeBtns = $all('.membership_withdraw_close');
    var proceedBtn = $('#membership_withdraw_proceed_btn');
    var requestBtn = $('#membership_withdraw_request_btn');
    var editBtn = $('#membership_withdraw_edit_btn'); // Si existe
    var inputs = $all('.membership_withdraw_code_input');

    // Abrir modal
    function openWithdrawModal() {
      if (!backdrop || !modal) return;
      // reset inputs
      inputs.forEach(function(i) { i.value = ''; });
      // mostrar
      backdrop.style.display = 'block';
      modal.style.display = 'block';
      // foco primer input
      if (inputs[0]) inputs[0].focus();
    }

    // Cerrar modal
    function closeWithdrawModal() {
      if (!backdrop || !modal) return;
      backdrop.style.display = 'none';
      modal.style.display = 'none';
    }

    // Eventos de inputs (solo números + auto-avance)
    function onInput(e) {
      var el = e.target;
      var val = (el.value || '').replace(/\D/g, ''); // solo dígitos
      el.value = val.slice(0, 1);
      if (el.value.length === 1) {
        // ir al siguiente input
        var idx = inputs.indexOf(el);
        if (idx > -1 && idx < inputs.length - 1) {
          inputs[idx + 1].focus();
        }
      }
    }

    // Backspace / flechas
    function onKeydown(e) {
      var el = e.target;
      var idx = inputs.indexOf(el);
      if (idx === -1) return;

      if ((e.key === 'Backspace' || e.keyCode === 8) && el.value === '' && idx > 0) {
        inputs[idx - 1].focus();
      }
      if (e.key === 'ArrowLeft' && idx > 0) {
        inputs[idx - 1].focus();
      }
      if (e.key === 'ArrowRight' && idx < inputs.length - 1) {
        inputs[idx + 1].focus();
      }
    }

    // Botones
    function onProceed() {
      var code = inputs.map(function(i){ return i.value; }).join('');
      if (code.length < 6) {
        alert('Please enter the 6-digit code.');
        if (inputs[0]) inputs[0].focus();
        return;
      }
      // TODO: AJAX de verificación
      // console.log('Verificando código:', code);
    }

    function onRequest() {
      alert('Requesting a new code...');
      // TODO: AJAX para pedir nuevo código
    }

    // Listeners
    inputs.forEach(function(i) {
      i.addEventListener('input', onInput);
      i.addEventListener('keydown', onKeydown);
    });

    if (proceedBtn) proceedBtn.addEventListener('click', onProceed);
    if (requestBtn) requestBtn.addEventListener('click', onRequest);

    // Cerrar por botón X o clic en backdrop
    closeBtns.forEach(function(b) { b.addEventListener('click', closeWithdrawModal); });
    if (backdrop) backdrop.addEventListener('click', closeWithdrawModal);

    // Abrir por botón externo (si existe)
    if (editBtn) editBtn.addEventListener('click', openWithdrawModal);

    // Si quieres abrir automáticamente en cierto caso:
    // openWithdrawModal();
  })();
</script>

