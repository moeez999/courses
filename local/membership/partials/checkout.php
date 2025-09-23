<?php

/**
 * Local plugin "membership" - Checkout partial file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$user_phonenumber = $DB->get_field('user', 'phone2', array('id' => $USER->id));

$phonenumber = $user_phonenumber ? $user_phonenumber : '';
?>

<div class="col-12 col-lg-7 mt-2" id="checkout-content-container">
	<h4 class="mb-2">Metodo de pago</h4>
	<p class="rui-page-subtitle">Todas las transacciones son seguras.</p>
	<div id="transaction-container"></div>

	<div id="dropin-loader" class="card-form-loader mb-2">
		<div class="spinner-form">
		</div>
	</div>
	<div id="dropin-container" class="d-none">
	</div>
	<?php if ($cycle != 'free'): ?>
		<a data-toggle="collapse" href="#promotion-code-container" role="button" aria-expanded="false" aria-controls="promotion-code-container">¿Tienes un codigo promocional?</a>
		<div class="collapse" id="promotion-code-container">
			<div class="card card-body">
				<div class="input-group mt-2">
					<input type="text" class="form-control" id="promotion-code" placeholder="Codigo promocional">
					<div class="input-group-append">
						<button class="btn btn-primary" type="button" id="apply-code-btn">Aplicar</button>
					</div>
				</div>
				<p class="text-small red-text d-none mt-2 mb-0" id="promotion-code-msg">Ingresa un codigo promocional valido.</p>
			</div>
		</div>
	<?php endif; ?>
	<?php if (empty($phonenumber)) : ?>
		<div class="input-group mt-2 mb-2">
			<label for="phone-input">Numero de telefono</label>
			<input type="tel" class="form-control w-100" id="phone-input" name="phonenumber">
			<p class="text-small red-text d-none mt-2 mb-0" id="phone-input-msg">Ingresa tu numero.</p>
		</div>
	<?php endif; ?>


	<div class="input-group form-input-validation mt-2 mb-2">
		<label for="country-input">País</label>
		<select class="form-control w-100" id="country-input" name="country"></select>
		<p class="text-small red-text d-none mt-2 mb-0" id="country-input-msg">Ingresa tu país.</p>
	</div>

	<div class="input-group form-input-validation mt-2 mb-2">
		<label for="city-input">Ciudad</label>
		<select class="form-control w-100" id="city-input" name="city"></select>
		<p class="text-small red-text d-none mt-2 mb-0" id="address-input-msg">Ingresa tu ciudad.</p>
	</div>

	<div class="input-group form-input-validation mt-2 mb-2">
		<label for="address-input">Dirección</label>
		<input type="text" class="form-control w-100" id="address-input" name="address" >
		<p class="text-small red-text d-none mt-2 mb-0" id="address-input-msg">Ingresa tu dirección.</p>
	</div>
	<div id="desktop-payment"></div>
</div>