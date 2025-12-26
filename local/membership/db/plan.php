<?php

/**
 * Local plugin "membership" - Plan file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once(__DIR__ . '/lib.php');

global $CFG, $DB, $PAGE, $USER;

$PAGE->set_context(context_system::instance());
$PAGE->set_title("Planes de Subscripción");
$PAGE->set_heading("Ha Llegado el Momento de Hablar Inglés");
$PAGE->set_url($CFG->wwwroot.'/local/membership/plan.php');

$cssfilename = '/local/membership/css/style.css?v=' . time();
$PAGE->requires->css($cssfilename);
$cssfilename = '/local/membership/css/owl.carousel.css';
$PAGE->requires->css($cssfilename);
$PAGE->requires->css(new moodle_url('https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css'));

$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js'), true);

echo $OUTPUT->header();
echo html_writer::tag('p', 'Elige el mejor horario y plan para ti', array('class' => 'rui-page-subtitle'));

?>
<style>
  body {
    background-color: #f6f6f6;
  }
  .rui-breadcrumbs {
    display: none;
  }
  .wrapper-cohort {
    background-color: #f6f6f6;
    padding-top: 45px;
  }
  .page-header-content {
    margin: 0;
  }
  .rui-page-title {
    margin: auto !important;
    color: #000000;
    text-align: center;
  }
  .rui-page-subtitle {
    text-align: center;
    color: #767676;
    margin-bottom: 1em;
    font-size: 20px;
  }
  .swiper-container {
    overflow-x: visible;
    width: 75%;
    height: auto;
    margin-left: auto;
    margin-right: auto
  }
  @media (min-width: 950px) {
    .swiper-container {
      width: 90%;
    }
  }
  .swiper-wrapper {
    height: auto;
  }
  .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  #page-local-membership-plan .related-plans-section-two {
    overflow-x: hidden;
  }
  #page {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }
  .hidden-important {
    display: none !important;
  }
</style>

<div class="enterprice-plan-section">
  <?php if (!empty(get_config('local_membership', 'noofmembershipplans'))) {
    $availableCycles = [];

    $noOfMembershipPlans = get_config('local_membership', 'noofmembershipplans');


    for ($key = 1; $key <= $noOfMembershipPlans; $key++) {
      $monthlyFee = get_config('local_membership', 'membershipmonthlyfee' . $key);
      $biannuallyFee = get_config('local_membership', 'membershipbiannuallyfee' . $key);
      $annualFee = get_config('local_membership', 'membershipyearlyfee' . $key);

      if (empty($monthlyFee) && empty($biannuallyFee) && empty($annualFee)) {
        $availableCycles[] = 'free';
      } else {
        if ($monthlyFee > 0) {
          $availableCycles[] = 'monthly';
        }
        if ($biannuallyFee > 0) {
          $availableCycles[] = 'biannually';
        }
        if ($annualFee > 0) {
          $availableCycles[] = 'yearly';
        }
      }
    }
    $availableCycles = array_unique($availableCycles);
    ?>

    <div class="row cycle-row">
      <div class="cycle-options-wrapper">
        <div class="cycle-options-container">
          <?php if (in_array('yearly', $availableCycles)) : ?>
            <button class="btn btn-info cycle-option" data-cycle="yearly">Anual</button>
          <?php endif; ?>
          <?php if (in_array('biannually', $availableCycles)) : ?>
            <button class="btn btn-info cycle-option" data-cycle="biannually">Semestral</button>
          <?php endif; ?>
          <?php if (in_array('monthly', $availableCycles)) : ?>
            <button class="btn btn-info cycle-option" data-cycle="monthly">Mensual</button>
          <?php endif; ?>
          <?php if (in_array('free', $availableCycles)) : ?>
            <button class="btn btn-info cycle-option" data-cycle="free">Gratuito</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php } else { ?>
    <div class="row">
      <div class="col-12">
        <div class="card text-center">
          <div class="card-header pb-0"><h3>Sin planes</h3></div>
          <div class="card-body"><p>Actualmente no hay planes, vuelve luego.</p></div>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="related-plans-section related-plans-section-two">
    <div class="swiper-container slide-content">
      <?php if (!empty(get_config('local_membership', 'noofmembershipplans'))) { ?>
        <div class="swiper-wrapper">

          <?php
          for ($key = 1; $key <= get_config('local_membership', 'noofmembershipplans'); $key++) {
            $planData = get_plan_data($key, $USER->id);
            ?>

            <div class="swiper-slide mb-3 membership-tier" 
            data-all="true"
            data-free="<?= ($planData->isFree ? 'true' : 'false'); ?>"
            data-monthly="<?= ($planData->isMonthly ? 'true' : 'false'); ?>" 
            data-biannually="<?= ($planData->isBiannually ? 'true' : 'false'); ?>" 
            data-yearly="<?= ($planData->isYearly ? 'true' : 'false'); ?>">
            <div class="related-plans-in-con">
              <div class="related-plans-in-content">
                <center>
                  <h2 class="plan-title">
                    <span><?= $planData->planName; ?></span>
                    <?php if ($planData->planDiscounts->biannually > 0): ?>
                      <span class="discount-tag hidden" data-cycle="biannually">Ahorras <?= $planData->planDiscounts->biannuallyText ?></span>
                    <?php endif; ?>
                    <?php if ($planData->planDiscounts->yearly > 0): ?>
                      <span class="discount-tag hidden" data-cycle="yearly">Ahorras <?= $planData->planDiscounts->yearlyText ?></span>
                    <?php endif; ?>
                  </h2>
                  <?php if (!$planData->isFree) { ?>
                    <?php if ($planData->isMonthly) { ?>
                      <div class="membership-tier-payment-details hidden" data-cycle="monthly">
                        <p class="price mb-1">
                          $<?= $planData->monthly->price ?> <small> / <?= $planData->monthly->interval ?> <?= $planData->monthly->keyword ?></small>
                        </p>
                        <?php if ($planData->planDiscounts->yearly > 0 && $planData->planDiscounts->biannually > 0): ?>
                          <p class="discount mb-1">
                            *Ahorra con plan anual (<?= $planData->planDiscounts->yearlyText ?>) o semestral (<?= $planData->planDiscounts->biannuallyText ?>)
                          </p>
                          <?php elseif ($planData->planDiscounts->yearly > 0): ?>
                            <p class="discount mb-1">
                              *Ahorra con plan anual (<?= $planData->planDiscounts->yearlyText ?>)
                            </p>
                            <?php elseif ($planData->planDiscounts->biannually > 0): ?>
                              <p class="discount mb-1">
                                *Ahorra con plan semestral (<?= $planData->planDiscounts->biannuallyText ?>)
                              </p>
                            <?php endif; ?>
                          </div>
                        <?php } ?>
                        <?php if ($planData->isBiannually) { ?>
                          <div class="membership-tier-payment-details hidden" data-cycle="biannually">
                            <?php if ($planData->planDiscounts->biannually > 0): ?>
                              <p class="discount-price mb-0"><s>$<?= $planData->planDiscounts->biannuallyPrice ?></s></p>
                            <?php endif; ?>
                            <p class="price mb-1">
                              $<?= $planData->biannually->price ?> <small> / <?= $planData->biannually->interval ?> <?= $planData->biannually->keyword ?></small>
                            </p>
                            <?php if ($planData->planDiscounts->yearly > 0): ?>
                              <p class="discount mb-1">
                                *Ahorra con plan anual (<?= $planData->planDiscounts->yearlyText ?>)
                              </p>
                            <?php endif; ?>
                          </div>
                        <?php } ?>

                        <?php if ($planData->isYearly) { ?>
                          <div class="membership-tier-payment-details hidden" data-cycle="yearly">
                            <?php if ($planData->planDiscounts->yearly > 0): ?>
                              <p class="discount-price mb-0"><s>$<?= $planData->planDiscounts->yearlyPrice ?></s></p>
                            <?php endif; ?>
                            <p class="price mb-1">
                              $<?= $planData->yearly->price ?> <small> / <?= $planData->yearly->interval ?> <?= $planData->yearly->keyword ?></small>
                            </p>
                          </div>
                        <?php } ?>
                      <?php } else { ?>
                        <div class="membership-tier-payment-details hidden" data-cycle="free">
                          <p class="price mb-1">Gratuito / <small>de por vida</small></p>
                        </div>
                      <?php } ?>
                      <?php
                      $schedules = $planData->schedules;
                      //print_r($schedules);
                      ?>


                      <?php if (isset($planData->schedules['days']) && isset($planData->schedules['time'])): ?>
                      <p class="mb-0">
                        <?= $planData->schedules['days']; ?> - <?= $planData->schedules['time']; ?>
                      </p>
                    <?php endif; ?>

                    <?php if (isset($planData->schedules['tutordays']) && isset($planData->schedules['tutortime'])): ?>
                    <?php if ($planData->schedules['tutordays'] !== $planData->schedules['days']): ?>
                      <p class="mb-0">
                        <?php if ($planData->schedules['tutortime'] !== $planData->schedules['time']): ?>
                          <?= $planData->schedules['tutordays']; ?> - <?= $planData->schedules['tutortime']; ?>
                        <?php endif; ?>
                      </p>
                      <?php else: ?>
                        <?php if (isset($planData->schedules['days']) && isset($planData->schedules['time']) && $planData->schedules['tutortime'] !== $planData->schedules['time']): ?>
                        <p class="mb-0">
                         y 
                         <?= $planData->schedules['tutortime']; ?>
                       </p>
                     <?php endif; ?>
                   <?php endif; ?>
                 <?php endif; ?>




                 <?php if ($planData->haveStartDate): ?>
                  <p class="mb-0">Inicio: <?= $planData->startDate ?></p>
                <?php endif; ?>
                <?php if ($planData->haveDescription) { ?>
                  <div class="includes-plan-description-part">
                    <p><?= $planData->planDescription; ?></p>
                  </div>
                <?php } ?>
              </center>
              <hr>

              <?php if (!empty($planData->planCohorts)): ?>
                <div class="includes-plan-points-part d-none">
                  <h5>Grupos incluidos:</h5>
                  <ul>
                    <?php foreach ($planData->planCohorts as $planCohort): ?>
                      <li><i class="fa fa-check" aria-hidden="true"></i><?= $planCohort; ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>

              <?php if (!empty($planData->planFeatures)): ?>
                <div class="includes-plan-points-part plan-features">
                  <h5>Beneficios</h5>
                  <ul>
                    <?php foreach ($planData->planFeatures as $planFeature): ?>
                      <li><i class="fa fa-check" aria-hidden="true"></i><?= $planFeature; ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>

            </div>
            <form method="POST" action="<?= $CFG->wwwroot."/local/membership/payment.php"; ?>" class="payment-form">
              <input type="hidden" name="key" value="<?= $key; ?>">
              <input type="hidden" name="cycle" id="cycle-value">
              <center>
                <div class="plan-btn-part">
                  <button class="btn btn-info plan-action-btn" type="submit" <?= $planData->status == 1 ? 'disabled' : ''; ?>>
                    <?= $planData->statusText; ?>
                  </button>
                </div>
              </center>
            </form>

          </div>
        </div>
      <?php } ?>
    </div>
  <?php } ?>
</div>
</div>

<script>
  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 3,
    spaceBetween: 20,
    loop: true,
    grabCursor: false,
    mousewheel: {
      forceToAxis: true
    },
    touchEventsTarget: 'container',
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      520: {
        slidesPerView: 1,
      },
      950: {
        slidesPerView: 3,
      },
    },
  });

  document.querySelectorAll('.cycle-option').forEach(function(button) {
    button.addEventListener('click', function() {
      var cycle = this.getAttribute('data-cycle');

      document.querySelectorAll('.cycle-option').forEach(function(btn) {
        btn.classList.remove('active');
      });
      this.classList.add('active');

      document.querySelectorAll('.swiper-slide').forEach(function(slide) {
        slide.querySelector('#cycle-value').value = cycle;
        slide.classList.add('hidden-important');
        if (slide.getAttribute('data-' + cycle) == 'true') {
          slide.classList.remove('hidden-important');

          slide.querySelectorAll('.membership-tier-payment-details').forEach(function(paymentDetail) {
            paymentDetail.classList.add('hidden');
          });
          slide.querySelectorAll('.discount-tag').forEach(function(paymentDetail) {
            paymentDetail.classList.add('hidden');
          });

          slide.querySelector('.membership-tier-payment-details[data-cycle="' + cycle + '"]').classList.remove('hidden');
          if (slide.querySelector('.discount-tag[data-cycle="' + cycle + '"]')) {
            slide.querySelector('.discount-tag[data-cycle="' + cycle + '"]').classList.remove('hidden');
          }
        }
      });
      swiper.update();
    });
  });
  function initializeCycle() {
    var cycles = ['yearly', 'biannually', 'monthly', 'free'];
    for (var i = 0; i < cycles.length; i++) {
      if (document.querySelector('.cycle-option[data-cycle="' + cycles[i] + '"]')) {
        document.querySelector('.cycle-option[data-cycle="' + cycles[i] + '"]').click();
        break;
      }
    }
  }

  initializeCycle();
</script>


</div>

<?php
echo $OUTPUT->footer();
?>
