<?php

/**
 * Local plugin "membership" - Signup partial file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$sesskey = sesskey();

$googleUrl = new moodle_url('/auth/oauth2/login.php', array(
    'wantsurl' => new moodle_url('/local/membership/payment.php'),
    'authprovider' => 'google',
    'id' => '4',
    'sesskey' => $sesskey
));




$loginUrl = new moodle_url('/login/index.php', array('wantsurl' => new moodle_url('/local/membership/payment.php')));

$error = optional_param('error', '', PARAM_ALPHANUM);
?>
<div class="col-12 col-lg-7 mt-2" id="signup-content-container">
    <a href="<?= $loginUrl->out() ?>" class="btn btn-secondary btn-signup w-100 mb-2"><img src="/local/membership/img/latingles.png" width="32px" height="32px"> Iniciar sesión con Latingles</a>
    <a href="<?= $googleUrl->out() ?>" class="btn btn-secondary btn-signup w-100"><img src="/local/membership/img/google.png" width="32px" height="32px"> Registrarse / Iniciar sesión con Google</a>

    <div class="login-divider mt-3 mb-3">
        <hr> 
        <span>O</span>
        <hr>
    </div>

    <form action="/local/membership/signup.php" method="post" id="signup-form">
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label for="firstname">Nombre</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="col-md-6">
                <label for="lastname">Apellido</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="username">Nombre de usuario</label>
            <input type="text" class="form-control" id="username" name="username" required>
            <?php if ($error == 'usernameexists'): ?>
               <div class="alert alert-danger mt-2">El nombre de usuario ya está en uso.</div>
           <?php endif; ?>
       </div>
       <div class="form-group mb-3">
        <label for="email">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" required>
        <?php if ($error == 'emailexists'): ?>
           <div class="alert alert-danger mt-2">El correo electrónico ya está en uso.</div>
       <?php endif; ?>
   </div>
   <div class="form-group mb-3">
    <label for="password">Contraseña</label>
    <input type="password" class="form-control" id="password" name="password" required>
</div>
<div class="form-group mb-3">
    <label for="phone-input">Numero de telefono</label>
    <input type="tel" class="form-control w-100" id="phone-input" name="phonenumber">
    <p class="text-small red-text d-none mt-2 mb-0" id="phone-input-msg">Ingresa tu numero.</p>
</div>
<div class="form-group d-flex mb-3">
    <label class="mr-2">Género (opcional)</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="gender" id="male" value="male">
        <label class="form-check-label" for="male">Hombre</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="gender" id="female" value="female">
        <label class="form-check-label" for="female">Mujer</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="gender" id="nonbinary" value="nonbinary">
        <label class="form-check-label" for="nonbinary">No binario</label>
    </div>
</div>
<div class="input-group flex-column mt-2">
    <label class="cursor-pointer user-select-none  m-0"><input type="checkbox" id="consent-checkbox">Acepto los <a href="https://latingles.com/landing/latingless-terms-and-conditions/" class="web-content">términos y condiciones</a>, <a href="https://latingles.com/landing/privacy-policy/" class="web-content">política de privacidad</a> y SMS relacionado a mis clases.</label>
    <p class="text-small red-text d-none mt-2 mb-0">Confirma que estas de acuerdo primero.</p>
</div>
<input type="hidden" name="wantsurl" value="/local/membership/payment.php">
<button type="submit" class="btn btn-primary btn-action w-100 mt-3">Registrarse</button>
</form>
</div>
