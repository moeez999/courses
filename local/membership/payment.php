<?php

/**
 * Local plugin "membership" - Lib file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once(__DIR__ . '/lib.php');
require_once($CFG->dirroot . '/login/lib.php');

global $CFG, $DB, $PAGE, $USER, $SESSION;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $key = $_POST['key'] ?? '';
    $cycle = $_POST['cycle'] ?? '';
} else {
    $key = '';
    $cycle = '';
    $planData = isset($SESSION->planData) ? $SESSION->planData : null;
    if ($planData) {
        $key = $planData['key'];
        $cycle = $planData['cycle'];
    }
}

if (empty($key) || empty($cycle)) {
    redirect($CFG->wwwroot.'/local/membership/plan.php', 'Selecciona un plan valido.');
}

$planData = get_plan_data($key, $USER->id);
if (!$planData) {
    redirect($CFG->wwwroot.'/local/membership/plan.php', 'Selecciona un plan valido.');
}
unset($_POST['key']);
unset($_POST['cycle']);
$SESSION->planData = [
  'key'  => $key,
  'cycle' => $cycle
];
$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);

if (!isloggedin()):
    $PAGE->set_title("Registro");
    $PAGE->set_heading("Registro");
else:
    $PAGE->set_title("Pago de subscripción");
    $PAGE->set_heading("Pago de subscripción");
endif;

$PAGE->set_url($CFG->wwwroot.'/local/membership/payment.php');

$cssfilename = '/local/membership/css/style.css';
$PAGE->requires->css($cssfilename);
$cssfilename = '/local/membership/css/custom.css?v=' . time();
$PAGE->requires->css($cssfilename);
$cssfilename = '/local/membership/css/owl.carousel.css';
$PAGE->requires->css($cssfilename);
$PAGE->requires->css(new moodle_url('https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/css/intlTelInput.css'));
$PAGE->requires->css(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'));

$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/sweetalert2@11'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/intlTelInput.min.js'), true);
$PAGE->requires->js(new moodle_url('https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js'), true);

$planName = $planData->planName;


$planPrice = 0;
$interval = 1;
$billingCycles = 0;
$billingCycle = '';
$billingDetails = 'sin costo';
$currency = $planData->currency;



$planCycleData = $planData->$cycle;

$planPrice = $planCycleData->price;
$interval = $planCycleData->interval;
$billingCycles = $planCycleData->billing;

$keyword = $planCycleData->keyword;
$actionKeyword = 'Suscribirse por';

if ($cycle != 'free') {
    $billingCycle = $currency . ' / ' . $interval . ' ' . $keyword;
    $billingDetails = $planPrice . ' ' . $currency . ' / ' . $interval . ' ' . $keyword;
} else {
    $actionKeyword = 'Suscribirse';
}

echo $OUTPUT->header();
?>

<div class="row page-content-wrapper" id="custom-payment">
    <?php
    if (!isloggedin()):
        include('partials/signup.php');
    else:
        //unset($SESSION->planData);
        include('partials/checkout.php');
    endif;
    ?>
    <div class="col-12 col-lg-5 mt-2">
        <h4 class="mb-2">Plan seleccionado</h4>
        <p class="rui-page-subtitle d-sm-none d-lg-block">Seleccionaste este plan entre todas las opciones</p>
        <div class="plan-information-container">
            <?php $discount = $cycle . 'Text'; ?>
            <?php if (isset($planData->planDiscounts->$cycle) && $planData->planDiscounts->$cycle > 0): ?>
              <div class="discount-plan-tag">Ahorras <?= $planData->planDiscounts->$discount ?></div>
          <?php endif; ?>
          <h3 class="plan-information-name"><?= $planName; ?></h3>
          <?php if (!empty($planData->planCohorts)): ?>
            <p class="mt-2 mb-0 d-none">Cursos incluidos:</p>
            <?php foreach ($planData->planCohorts as $planCohort): ?>
                <p class="mt-2 mb-0 d-none"><i class="fa fa-check mr-2" aria-hidden="true"></i> <span class="plan-information-course"><?= $planCohort; ?></span></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (!empty($planData->planFeatures)): ?>
            <p class="mt-2 mb-0">Obtendrás acceso a:</p>
            <?php foreach ($planData->planFeatures as $planFeature): ?>
                <p class="mt-2 mb-0"><i class="fa fa-diamond mr-2" aria-hidden="true"></i> <span class="plan-information-feature"><?= $planFeature; ?></span></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="plan-information-payment-detail mt-2" id="promotion-code-price">
        <p class="mb-0">
            Subtotal:
            <span id="subtotal"><?php echo $billingDetails; ?></span>
        </p>
        <p  class="red-text d-none" id="discount-container">
            Descuento:
            <span id="discount"></span>
        </p>
        <p class="mb-0">
            Costo Total:
            <span id="total-cost"><?php echo $billingDetails; ?></span>
        </p>
    </div>
    <div id="mobile-payment"></div>
</div>
</div>
<script>

    setTimeout(() => {
    }, 3000);


    let consentCheckbox = document.getElementById('consent-checkbox');

    let iti = false;
    const input = document.querySelector("#phone-input");
    if (input) {
     iti = window.intlTelInput(input, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/utils.js",
        initialCountry: "auto",
        geoIpLookup: function(success, failure) {
          fetch("https://ipapi.co/json")
          .then(function(res) { return res.json(); })
          .then(function(data) { success(data.country_code); })
          .catch(function() { failure(); });
      }
  }); 
 }





 const countrySelect = document.getElementById('country-input');
 const citySelect = document.getElementById('city-input');

 function fillCountrySelect() {
    fetch('/local/membership/proxy/geonames.php?endpoint=countryInfoJSON')
    .then(response => response.json())
    .then(data => {
        const countries = data.geonames;
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country.countryCode;
            option.textContent = country.countryName;
            countrySelect.appendChild(option);
        });
        ipLookupAndFill();
    })
    .catch(error => console.error('Error fetching countries:', error));
}

function fillCitySelect(countryCode, selectedCity) {
    citySelect.innerHTML = '';
    fetch(`/local/membership/proxy/geonames.php?endpoint=searchJSON&country=${countryCode}&featureCode=ADM1`)
    .then(response => response.json())
    .then(data => {
        const cities = data.geonames;
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.toponymName;
            option.textContent = city.toponymName;
            citySelect.appendChild(option);
        });

        if (selectedCity) {
            citySelect.value = selectedCity;
        }
    })
    .catch(error => console.error('Error fetching cities:', error));
}

function ipLookupAndFill() {
    fetch('https://ipapi.co/json/')
    .then(response => response.json())
    .then(data => {
        const country = data.country_code;
        const city = data.city;

        if (country) {
            countrySelect.value = country;
            fillCitySelect(country, city);
        }
    })
    .catch(error => console.error('Error in IP Lookup:', error));
}

countrySelect.addEventListener('change', function () {
    const selectedCountryCode = countrySelect.value;
    if (selectedCountryCode) {
        fillCitySelect(selectedCountryCode);
    }
});

fillCountrySelect();








let promotionCode = '';
let isPaymentMethodRequestable = false;

let phoneNumber = document.getElementById('phone-input');
let phoneNumberMsg = document.getElementById('phone-input-msg');




function validateFormInputs() {
    const inputGroups = document.querySelectorAll('.form-input-validation');
    for (let group of inputGroups) {
        const input = group.querySelector('input, select');
        const errorMsg = group.querySelector('p');

        if (input && errorMsg) {
            if (input.value.trim() === '') {
                errorMsg.classList.remove('d-none');
                input.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
                return false;
            } else {
                errorMsg.classList.add('d-none');
            }
        }
    }
    return true;
}



function validateTermsConsent() {
    if (!consentCheckbox.checked) {
        consentCheckbox.parentElement.parentElement.querySelector('p').classList.remove('d-none');
        consentCheckbox.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
        return false;
    } else {
        consentCheckbox.parentElement.parentElement.querySelector('p').classList.add('d-none');
        if (isPaymentMethodRequestable) {
          submitButton.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
      }
  }
  return true;
}
function validateNumberInput() {
    if (iti) {
        if (!iti.isValidNumber()) {
            phoneNumberMsg.classList.remove('d-none');
            phoneNumber.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
            return false;
        } else {
            phoneNumberMsg.classList.add('d-none');
            if (isPaymentMethodRequestable) {
              submitButton.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
          }
      }
  }
  return true;
}


function showWebContent1(event) {
    event.preventDefault();  // Prevent the default action (navigation)

    // Get the URL from the clicked link
    const targetUrl = event.target.href;

    // Redirect directly to the target URL
    window.location.href = targetUrl;
}



function showWebContent(event) {
    event.preventDefault();
    fetch(event.target.href)
    .then(response => response.text())
    .then(data => {
        const container = document.createElement('div');
        container.innerHTML = data;
        const titleContent = container.querySelector('main header').innerText;
        container.querySelector('main header').remove();
        const mainContent = container.querySelector('main').innerHTML;

        Swal.fire({
            title: titleContent,
            html: mainContent,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            animation: 'slide-from-top',
            showClass: {
                popup: `
                animate__animated
                animate__fadeInUp
                animate__faster
                `
            },
            hideClass: {
                popup: `
                animate__animated
                animate__fadeOutDown
                animate__faster
                `
            }
        });
    })
    .catch(() => {
        Swal.fire('Error', 'Ha ocurrido un error al cargar el contenido.', 'error');
    });
}
if (iti) {
    phoneNumber.addEventListener('input', function() {
        validateNumberInput();
    });
}


(function() {
    var isFree = <?php echo json_encode($cycle === 'free'); ?>;
    let signupPage = document.getElementById('signup-content-container');
    let checkoutPage = document.getElementById('checkout-content-container');
    if (!checkoutPage && signupPage) {
        let errorMsg = signupPage.querySelector('.alert');
        if (errorMsg) {
            setTimeout(() => {
                errorMsg.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
            }, 1000);
        }

        document.body.querySelectorAll('a.web-content').forEach(link => {
            link.addEventListener('click', showWebContent);
        });
        consentCheckbox = document.getElementById('consent-checkbox');
        consentCheckbox.addEventListener('change', function() {
            validateTermsConsent();
        });

        let signupForm = signupPage.querySelector('#signup-form');

        signupForm.addEventListener('submit', function (event) {
            if (!validateNumberInput() || !validateFormInputs() || !validateTermsConsent()) {
             event.preventDefault();
         } else {
            if (iti) {
                let phoneNumberInput = document.createElement('input');
                phoneNumberInput.type = 'hidden';
                phoneNumberInput.name = 'phonenumber';
                phoneNumberInput.value = iti.getNumber();
                signupForm.appendChild(phoneNumberInput);
            }
        }
    });

    } else {
        const mobileContainer = document.getElementById('mobile-payment');
        const desktopContainer = document.getElementById('desktop-payment');
        const breakpoint = 992;
        let isMobile;
        function initCheckout() {
            let paymentDetail = document.createElement('div');
            paymentDetail.innerHTML = `
            <div class="input-group flex-column mt-2">
            <label class="cursor-pointer user-select-none  m-0"><input type="checkbox" id="consent-checkbox">Acepto los <a href="https://latingles.com/landing/latingless-terms-and-conditions/" class="web-content">términos y condiciones</a>, <a href="https://latingles.com/landing/privacy-policy/" class="web-content">política de privacidad</a> y SMS relacionado a mis clases.</label>
            <p class="text-small red-text d-none mt-2 mb-0">Confirma que estas de acuerdo primero.</p>
            </div>
            <button class="btn btn-primary btn-action w-100 mt-3" id="submit-button" disabled><i class="d-none mr-2" aria-hidden="true"></i><span> <?= $actionKeyword; ?> <?php echo $billingDetails; ?></span></button>
            `;

            isMobile = window.innerWidth < breakpoint;
            if (isMobile) {
                mobileContainer.appendChild(paymentDetail);
            } else {
                desktopContainer.appendChild(paymentDetail);
            }

            document.body.querySelectorAll('a.web-content').forEach(link => {
                link.addEventListener('click', showWebContent1);
            });
            consentCheckbox = document.getElementById('consent-checkbox');
            consentCheckbox.addEventListener('change', function() {
                validateTermsConsent();
            });
        }

        initCheckout();

        const country = document.getElementById('country-input');
        const city = document.getElementById('city-input');
        const address = document.getElementById('address-input');

        const submitButton = document.getElementById('submit-button');

        let promotionCode = '';
        let isPaymentMethodRequestable = false;

        function updateButtonVisibility() {
            if (isPaymentMethodRequestable) {
              submitButton.disabled = false;
          } else {
              submitButton.disabled = true;
          }
      }
      let promotionCodeInput = document.getElementById('promotion-code');
      let submitCodeButton = document.getElementById('apply-code-btn');
      let dropinContainer = document.getElementById('dropin-container');
      let dropinLoader = document.getElementById('dropin-loader');

      if (!isFree) {
          submitCodeButton.addEventListener('click', function() {
            const promotionCodeInput = document.getElementById('promotion-code');
            const promotionCodeMsg = document.getElementById('promotion-code-msg');
            promotionCode = promotionCodeInput.value.trim();
            const key = "<?php echo $key; ?>";

            if (promotionCode.length < 1) {
                promotionCodeMsg.classList.remove('d-none');
            } else {
                promotionCodeMsg.classList.add('d-none');

                const formData = new FormData();
                formData.append('code', promotionCode);
                formData.append('key', key);
                fetch('/local/membership/api/discount_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Respuesta del servidor', data)
                    if (data.success) {
                        const discount = data.discount;
                        const planPrice = parseFloat('<?php echo $planPrice; ?>');
                        const currency = '<?php echo $currency; ?>';
                        const billingCycle = '<?php echo $billingCycle; ?>';
                        const subtotalElement = document.getElementById('subtotal');
                        const discountContainer = document.getElementById('discount-container');
                        const discountElement = document.getElementById('discount');
                        const totalCostElement = document.getElementById('total-cost');
                        subtotalElement.textContent = planPrice.toFixed(2) + ' ' + billingCycle;
                        discountContainer.classList.remove('d-none');
                        discountElement.textContent = discount.toFixed(2) + ' ' + billingCycle;
                        const newPrice = planPrice - discount;
                        totalCostElement.textContent = newPrice.toFixed(2) + ' ' + billingCycle;
                        Swal.fire({
                            icon: 'success',
                            title: 'Codigo promocional aplicado',
                            text: 'El descuento se ha aplicado correctamente.',
                            customClass: {
                                confirmButton: 'btn btn-primary m-2 btn-action mb-5',
                                cancelButton: 'btn btn-primary m-2 btn-action mb-5',
                                popup: 'card',
                            },
                            buttonsStyling: false
                        });
                        promotionCodeInput.disabled = true;
                        submitCodeButton.disabled = true;
                        submitCodeButton.innerHTML = 'Aplicado';
                        submitButton.querySelector('span').innerHTML = ' <?= $actionKeyword; ?> ' + newPrice.toFixed(2) + ' ' + billingCycle;

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Codigo promocional no valido',
                            text: 'El codigo promocional ingresado no es valido.',
                            customClass: {
                                confirmButton: 'btn btn-primary m-2 btn-action mb-5',
                                cancelButton: 'btn btn-primary m-2 btn-action mb-5',
                                popup: 'card',
                            },
                            buttonsStyling: false
                        });
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ha ocurrido un error.',
                        customClass: {
                            confirmButton: 'btn btn-primary m-2 btn-action mb-5',
                            cancelButton: 'btn btn-primary m-2 btn-action mb-5',
                            popup: 'card',
                        },
                        buttonsStyling: false
                    });
                });
            }
        });
}
fetch('/local/membership/api/token_handler.php')
.then(function(response) {
    return response.text();
}).then(function(clientToken) {
    braintree.dropin.create({
      authorization: clientToken,
      selector: dropinContainer,
      locale: 'es_ES',
      paypal: {
        flow: 'vault',
        buttonStyle: {
          tagline: false,
          label: 'paypal',
          color: 'blue',
          shape: 'pill',
          size: 'large'
      }
  },
  vaultManager: true,
  card: {
    cardholderName: {
      required: true
  },
  overrides: {
    fields: {
        cardholderName: {
            placeholder: 'Nombre Completo'
        },
        number: {
            placeholder: 'Numero de tarjeta'
        },
        expirationDate: {
            placeholder: 'Fecha de vencimiento (MM/AA)'
        },
        cvv: {
            placeholder: 'Codigo de seguridad'
        }
    }
}
}
}, function (err, instance) {
  if (err) {
    console.log('error trying to init dropin')
    console.error(err);
    return;
}

dropinContainer.classList.remove('d-none');
dropinLoader.remove();

instance.on('paymentMethodRequestable', function(event) {
    isPaymentMethodRequestable = true;
    updateButtonVisibility();
    let expandedElement = document.querySelector('.braintree-sheet.expanded');
    if(expandedElement && event.type == 'PayPalAccount') {
        expandedElement.classList.remove('expanded');
    }
    togglePaymentIcon(event.type);
});
instance.on('noPaymentMethodRequestable', function() {
    isPaymentMethodRequestable = false;
    updateButtonVisibility();
    togglePaymentIcon();
});
instance.isPaymentMethodRequestable() ? isPaymentMethodRequestable = true : isPaymentMethodRequestable = false;
if (isPaymentMethodRequestable) {
    instance.requestPaymentMethod(function (err, payload) {
        if (err) {
            console.error(err);
            isPaymentMethodRequestable = false;
            updateButtonVisibility();
            submitButton.disabled = false;
            submitButton.querySelector('span').innerHTML = ' Reintentar';
            return;
        }
        togglePaymentIcon(payload.type);
    });
}
updateButtonVisibility();

const cardHeader = document.querySelector('[data-braintree-id="card-sheet-header"]');
const paypalHeader = document.querySelector('[data-braintree-id="paypal-sheet-header"]');
const cardContent = document.querySelector('[data-braintree-id="card"] .braintree-sheet__content');
const paypalContent = document.querySelector('[data-braintree-id="paypal"] .braintree-sheet__content');
function initRadios() {
    let radio = document.createElement("input");
    radio.setAttribute("type", "radio");
    radio.setAttribute("name", "paymentMethod");
    let radioForCard = radio.cloneNode(true);
    let radioForPaypal = radio.cloneNode(true);
    cardHeader.insertBefore(radioForCard, cardHeader.firstChild);
    paypalHeader.insertBefore(radioForPaypal, paypalHeader.firstChild);
}
initRadios();
function toggleRadios(type, selected) {
    let radioForCard = cardHeader.querySelector('input[type="radio"]');
    let radioForPaypal = paypalHeader.querySelector('input[type="radio"]');
    if (type == 'card') {
        if (selected) {
            radioForCard.checked = true;
        }
        else {
            radioForCard.checked = false;
        }
    } else {
        if (selected) {
            radioForPaypal.checked = true;
        }
        else {
            radioForPaypal.checked = false;
        }
    }
}
let firstToggle = false;
function toggleExpanded(type) {
  updateButtonVisibility();
  let savedMethods;
  let paymentSwitch = document.body.querySelector('[data-braintree-id="toggle"]');
  let expandedElement = document.body.querySelector('.braintree-sheet.expanded');
  let paymentSelector;
  let targetContent;
  if (type == 'card') {
    paymentSelector = document.body.querySelector('[data-braintree-id="payment-options-container"] .braintree-option__card');
    targetContent = cardContent;
} else {
      paymentSelector = document.body.querySelector('[data-braintree-id="payment-options-container"] .braintree-option__paypal');
    targetContent = paypalContent;
}
if (expandedElement && expandedElement !== targetContent.parentElement) {
  expandedElement.classList.remove('expanded');
  toggleRadios(type, false);
}

if (!firstToggle) {
    firstToggle = true;
    const methodsContainer = document.querySelector('[data-braintree-id="methods-container"]');
    if (methodsContainer && methodsContainer.children.length > 0) {
        paymentSwitch.click();
    }
}
let isSelected = targetContent.parentElement.classList.toggle('expanded');
if (isSelected) {
    paymentSelector.click();
    toggleRadios(type, true);
    togglePaymentIcon(type)
} else {
    paymentSwitch.click();
    toggleRadios(type, false);
    if (!isPaymentMethodRequestable) {
        togglePaymentIcon();
    }
}
}
function togglePaymentIcon(type) {
    if (type == 'card' || type == 'CreditCard') {
        submitButton.querySelector('i').classList.remove('fab', 'fa-paypal', 'd-none');
        submitButton.querySelector('i').classList.add('fa', 'fa-credit-card-alt');
    } else if (type == 'paypal' || type == 'PayPalAccount') {
        submitButton.querySelector('i').classList.remove('fa', 'fa-credit-card-alt', 'd-none');
        submitButton.querySelector('i').classList.add('fab', 'fa-paypal');
    } else {
        submitButton.querySelector('i').classList.remove('fa', 'fab', 'fa-credit-card-alt', 'fa-paypal');
        submitButton.querySelector('i').classList.add('d-none');
    }
}
cardHeader.addEventListener('click', function() {
    toggleExpanded('card');
});

paypalHeader.addEventListener('click', function() {
    toggleExpanded('paypal');
});

function handlePayment(submitButton, checkboxButton) {
    submitButton.addEventListener('click', function () {
        if (!validateNumberInput() || !validateFormInputs() || !validateTermsConsent()) {
            return;
        }
        submitButton.disabled = true;
        submitButton.querySelector('span').innerHTML = ' Cargando...';
        instance.requestPaymentMethod(function (err, payload) {
            if (err) {
                console.error(err);
                isPaymentMethodRequestable = false;
                updateButtonVisibility();
                submitButton.disabled = false;
                submitButton.querySelector('span').innerHTML = ' Reintentar';
                return;
            }

            let expandedElement = document.querySelector('.braintree-sheet.expanded');

            if (expandedElement) {
                expandedElement.classList.remove('expanded');
            }

            console.log('Nonce:', payload.nonce);
            let formData = new FormData();
            formData.append('key', '<?php echo $key; ?>');
            formData.append('cycle', '<?php echo $cycle; ?>');
            formData.append('code', promotionCode);
            if (iti) {
                formData.append('phonenumber', iti.getNumber());
            }
            if (country) {
                formData.append('country', country.value);
            }
            if (city) {
                formData.append('city', city.value);
            }
            if (address) {
                formData.append('address', address.value);
            }
            formData.append('paymentMethod', payload.type);
            formData.append('paymentMethodNonce', payload.nonce);
            fetch('/local/membership/api/subscription_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                console.log('Respuesta del servidor:', data);
                if (data.success && data.status == 'active') {
                    submitButton.disabled = true;
                    submitButton.querySelector('span').innerHTML = ' Pagado';
                    let checkoutPage = document.getElementById('checkout-content-container');
                    checkoutPage.innerHTML = '';
                    mobileContainer.innerHTML = '';
                    desktopContainer.innerHTML = '';
                    let discountHTML = '';
                    if (data.discount != 0) {
                        discountHTML = 
                        `
                        <div class="col-12 col-md-3 mt-2">
                        <h5 class="card-title mb-0">Descuento ${ data.intervalInvoice }:</h5>
                        <p class="card-text">${ data.discountInvoice }</p>
                        </div>
                        `;
                    }
                    let billingHTML = 
                    `
                    <small>${ data.intervalInvoice } se te cobrará ${ data.priceInvoice } a partir de hoy, puedes cancelar en cualquier momento en el <a href="${ data.cancelurl }" target="_blank">Panel de Membresias</a></small>
                    `;
                    if (data.price == 0) {
                        billingHTML = 
                        `
                        <small>Esta suscripción no tiene costo, puedes cancelar en cualquier momento en el <a href="${ data.cancelurl }" target="_blank">Panel de Membresias</a></small>
                        `;
                    }

                    checkoutPage.innerHTML =
                    `
                    <div class="card">
                    <div class="card-header text-center">
                    <h2>Comprobante de pago de membresia</h2>
                    </div>
                    <div class="card-body">
                    <div class="row">
                    <div class="col-12 col-md-3 mt-2">
                    <h5 class="card-title mb-0">Nombre:</h5>
                    <p class="card-text">${ data.name }</p>
                    </div>
                    <div class="col-12 col-md-3 mt-2">
                    <h5 class="card-title mb-0">Precio:</h5>
                    <p class="card-text">${ data.originalPriceInvoice }</p>
                    </div>
                    <div class="col-12 col-md-3 mt-2">
                    <h5 class="card-title mb-0">Intervalo de cobro:</h5>
                    <p class="card-text">${ data.intervalInvoice }</p>
                    </div>
                    ${ discountHTML }
                    </div>
                    </div>
                    <div class="card-footer mt-2 text-right">
                    <p class="mb-0">Total: ${ data.priceInvoice }</p>
                    <p class="text-center mt-5 mb-2">
                    ${ billingHTML }
                    </p>
                    </div>
                    </div>
                    `;
                    Swal.fire({
                        title: 'Pago procesado',
                        text: 'Ahora estas suscrito a: <?php echo $planName; ?>.',
                        icon: 'success',
                        confirmButtonText: 'Ir a Inicio',
                        cancelButtonText: 'Mostrar comprobante',
                        showCancelButton: true,
                        customClass: {
                            confirmButton: 'btn btn-primary m-2 btn-action mb-5',
                            cancelButton: 'btn btn-primary m-2 btn-action mb-5',
                            popup: 'card',
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //window.location.href = '<?php echo $CFG->wwwroot.'/my/courses.php'; ?>';
                            window.location.href = '<?php echo $CFG->wwwroot.'/course/index.php'; ?>';
                        } else {
                            setTimeout(() => {
                                checkoutPage.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
                            }, 500);
                        }
                    });
                } else if (data.success) {
                    isPaymentMethodRequestable = false;
                    updateButtonVisibility();
                    submitButton.disabled = false;
                    submitButton.querySelector('span').innerHTML = ' Reintentar';
                    Swal.fire({
                        title: 'Error de pago',
                        text: 'Elige otro metodo de pago.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        showCancelButton: false,
                        customClass: {
                            confirmButton: 'btn btn-primary m-2 btn-action mb-5',
                            cancelButton: 'btn btn-primary m-2 btn-action mb-5',
                            popup: 'card',
                        },
                        buttonsStyling: false
                    });
                } else {
                    let errorTitle = 'Error de pago';
                    let errorDesc = 'Algo fallo en el proceso de pago.';
                    if (data.errors == 'already_subscribed') {
                        errorTitle = 'Ya estas suscrito';
                        errorDesc = 'Ya estas suscrito a <?php echo $planName; ?>.';
                    }
                    isPaymentMethodRequestable = false;
                    updateButtonVisibility();
                    submitButton.disabled = false;
                    submitButton.querySelector('span').innerHTML = ' Reintentar';
                    Swal.fire({
                        title: errorTitle,
                        text: errorDesc,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        showCancelButton: false,
                        customClass: {
                            confirmButton: 'btn btn-primary m-2 btn-action mb-5',
                            cancelButton: 'btn btn-primary m-2 btn-action mb-5',
                            popup: 'card',
                        },
                        buttonsStyling: false
                    });
                }
            })
.catch(function(error) {
    debugger
    console.error('Error al crear la suscripción:', error);
    isPaymentMethodRequestable = false;
    updateButtonVisibility();
    submitButton.disabled = false;
    submitButton.querySelector('span').innerHTML = ' Reintentar';
    Swal.fire({
        title: 'Error de pago',
        text: 'Algo fallo en el proceso de pago.',
        icon: 'error',
        confirmButtonText: 'OK',
        showCancelButton: false,
        customClass: {
            confirmButton: 'btn btn-primary m-2 btn-action mb-5',
            cancelButton: 'btn btn-primary m-2 btn-action mb-5',
            popup: 'card',
        },
        buttonsStyling: false
    });
});
});
});
}

handlePayment(submitButton, consentCheckbox);

});
});
}
})();

</script>

<?php

echo $OUTPUT->footer();