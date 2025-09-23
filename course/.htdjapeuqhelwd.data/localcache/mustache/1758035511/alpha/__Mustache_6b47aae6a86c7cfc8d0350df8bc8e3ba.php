<?php

class __Mustache_6b47aae6a86c7cfc8d0350df8bc8e3ba extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<nav id="topBar" class="rui-topbar-wrapper moodle-has-zindex">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <div class="rui-mobile-nav">
';
        $value = $context->find('topbarlogoareaon');
        $buffer .= $this->section1f393967a040d41ccbc36412f0524efb($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <button id="mobileNav" class="rui-mobile-nav-btn rui-topbar-btn">
';
        $buffer .= $indent . '            <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.75 5.75H19.25"></path>
';
        $buffer .= $indent . '                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.75 18.25H19.25"></path>
';
        $buffer .= $indent . '                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.75 12H19.25"></path>
';
        $buffer .= $indent . '            </svg>
';
        $buffer .= $indent . '        </button>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <div class="rui-topbar ';
        $value = $context->findDot('output.custom_menu');
        $buffer .= $this->section010aa6f4e08815ab4a342e2589c47bc0($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <div id="topbarLeft" class="d-inline-flex align-items-center">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '            <div class="d-inline-flex align-items-center">
';
        $buffer .= $indent . '
';
        $value = $context->find('topbarlogoareaon');
        $buffer .= $this->sectionBcb3a788b257e712017941eb2aea2fdd($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('hiddensidebar');
        if (empty($value)) {
            
            $buffer .= $indent . '                    <div class="rui-drawer-toggle ';
            $value = $context->find('topbarlogoareaon');
            $buffer .= $this->section24b0f5b3d2e215b34aad915421f4467f($context, $indent, $value);
            $buffer .= '" data-region="drawer-toggle">
';
            $buffer .= $indent . '                        <button id="mainNav" class="rui-topbar-btn nav-drawer-btn" aria-expanded="';
            $value = $context->find('navdraweropen');
            $buffer .= $this->section03a2cb78adf693fb240638cbbc7ea15e($context, $indent, $value);
            $value = $context->find('navdraweropen');
            if (empty($value)) {
                
                $buffer .= 'false';
            }
            $buffer .= '" aria-controls="nav-drawer" type="button" data-action="toggle-drawer" data-side="left" data-preference="drawer-open-nav">
';
            $buffer .= $indent . '                            <svg class="nav-drawer-btn--opened" width="18" height="18" fill="none" viewBox="0 0 24 24">
';
            $buffer .= $indent . '                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.25 6.75L4.75 12L10.25 17.25"></path>
';
            $buffer .= $indent . '                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.25 12H5"></path>
';
            $buffer .= $indent . '                            </svg>
';
            $buffer .= $indent . '                            <svg class="nav-drawer-btn--closed" width="18" height="18" fill="none" viewBox="0 0 24 24">
';
            $buffer .= $indent . '                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.75 7.75H19.25"></path>
';
            $buffer .= $indent . '                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.75 14.75H19.25"></path>
';
            $buffer .= $indent . '                            </svg>
';
            $buffer .= $indent . '                        </button>
';
            $buffer .= $indent . '                    </div>
';
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '
';
        $value = $context->findDot('output.custom_menu');
        $buffer .= $this->sectionCefeaa2a1c870dd3cb96afe51aac7537($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('topbarcustomhtml');
        $buffer .= $this->sectionAbe74d3130161e83f822dea50afcfa17($context, $indent, $value);
        $buffer .= $indent . '            <ul class="rui-icon-menu rui-icon-menu--right ';
        $value = $context->find('topbarcustomhtml');
        if (empty($value)) {
            
            $buffer .= 'ml-auto';
        }
        $buffer .= '">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                     <li class="nav-item" id="add_new_item">
';
        $buffer .= $indent . '                        <button id="openModal" class="subscribe-nav-btn" style="background: rgba(255, 255, 255, 1);border: 2.33px solid rgba(220, 220, 229, 1);padding: 9px 19.5px;border-radius: 9.33px;justify-content: center;align-items: center;font-weight: 500;font-size: 14px;line-height: 21px;color: rgba(0, 0, 0, 1);text-transform: capitalize;
';
        $buffer .= $indent . '                            ">Subscribe</button>
';
        $buffer .= $indent . '                     </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                     <li class="nav-item">
';
        $buffer .= $indent . '                            <div style="margin-top:10%;">
';
        $buffer .= $indent . '                            <a href="#" style="background: rgba(255, 255, 255, 1);border: 2.33px solid rgba(220, 220, 229, 1);padding: 9px 19.5px;border-radius: 9.33px;justify-content: center;align-items: center;font-weight: 500;font-size: 14px;line-height: 21px;color: rgba(0, 0, 0, 1);text-transform: capitalize;
';
        $buffer .= $indent . '                            ">Balance: 0</a>
';
        $buffer .= $indent . '                            <div>
';
        $buffer .= $indent . '                     </li>
';
        $buffer .= $indent . '                     <li class="nav-item">
';
        $buffer .= $indent . '                            <div style="margin-top:10%;">
';
        $buffer .= $indent . '                            <a href="#" style="background: rgba(255, 255, 255, 1);border: 2.33px solid rgba(220, 220, 229, 1);padding: 9px 19.5px;border-radius: 9.33px;justify-content: center;align-items: center;font-weight: 500;font-size: 14px;line-height: 21px;color: rgba(0, 0, 0, 1);text-transform: capitalize;
';
        $buffer .= $indent . '                            ">Refer friend</a>
';
        $buffer .= $indent . '                            <div>
';
        $buffer .= $indent . '                     </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                <li class="d-inline-flex mx-1">
';
        $buffer .= $indent . '                    ';
        $value = $this->resolveValue($context->findDot('output.render_lang_menu'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '                </li>
';
        $buffer .= $indent . '                ';
        $value = $context->find('topbaradminbtnon');
        $buffer .= $this->sectionB73038a11462b44891572bb1f4acc90a($context, $indent, $value);
        $buffer .= ' 
';
        $value = $context->find('darkmodetheme');
        $buffer .= $this->sectionCba3ade31ada94ef6526ced84cc41541($context, $indent, $value);
        $buffer .= $indent . '                <li>';
        $value = $this->resolveValue($context->findDot('output.navbar_plugin_output'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '</li>
';
        $buffer .= $indent . '                <li class="rui-icon-menu-user m-0">
';
        $buffer .= $indent . '                    ';
        $value = $this->resolveValue($context->findDot('output.user_menu'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '                </li>
';
        $buffer .= $indent . '            </ul>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '            <button class="d-flex d-md-none rui-mobile-nav-btn-close rui-topbar-btn">
';
        $buffer .= $indent . '                <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.25 6.75L6.75 17.25"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 6.75L17.25 17.25"></path>
';
        $buffer .= $indent . '                </svg>
';
        $buffer .= $indent . '            </button>
';
        $buffer .= $indent . '            
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</nav>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div style="width:100%;background:#fff;">
';
        $buffer .= $indent . '  <div style="margin:0px auto 0;padding:0 16px;box-sizing:border-box;">
';
        $buffer .= $indent . '    <div style="
';
        $buffer .= $indent . '      display:flex;align-items:center;justify-content:space-between;gap:16px;
';
        $buffer .= $indent . '      border:1px solid #e5e7eb;border-radius:12px;background:#fff;
';
        $buffer .= $indent . '      padding:10px 14px;box-sizing:border-box;">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '      <!-- Left: tabs -->
';
        $buffer .= $indent . '      <ul style="display:flex;align-items:center;gap:26px;margin:0;padding:0;list-style:none;">
';
        $buffer .= $indent . '        <!-- Each link has a data-role so script can style active/non-active -->
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#e53935;border-bottom:2px solid #fe2e0c;">
';
        $buffer .= $indent . '            Home
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/customplugin/my_lessons_tutor_profile_send_message_details.php"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Messages
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/customplugin/my_lessons.php"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            My lessons
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/customplugin/calendar_admin.php"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Calendar Admin
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/attendance/"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Attendance
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/membership/dashboard_new.php/"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Dashboard
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/adminboard/"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Groups
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/videocalling/observer.php"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Rooms
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/user/profile_new.php"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Student
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/membership/plan.php"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Plans
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/teachertimecard/index.php"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Timesheet
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/course/index.php"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Learn
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '        <li>
';
        $buffer .= $indent . '          <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/user/preferences.php"
';
        $buffer .= $indent . '             data-role="alpha2-nav-link"
';
        $buffer .= $indent . '             style="display:inline-flex;align-items:center;
';
        $buffer .= $indent . '                    padding:10px 4px 8px 4px;margin:0;text-decoration:none;
';
        $buffer .= $indent . '                    font-weight:500;font-size:14px;line-height:1;
';
        $buffer .= $indent . '                    color:#111;border-bottom:2px solid transparent;">
';
        $buffer .= $indent . '            Settings
';
        $buffer .= $indent . '          </a>
';
        $buffer .= $indent . '        </li>
';
        $buffer .= $indent . '      </ul>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '      <!-- Right: CTAs -->
';
        $buffer .= $indent . '      <div style="display:flex;align-items:center;gap:12px;flex-shrink:0;">
';
        $buffer .= $indent . '        <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/customplugin/explore_tutors.php"
';
        $buffer .= $indent . '           style="display:inline-flex;align-items:center;justify-content:center;
';
        $buffer .= $indent . '                  padding:10px 18px;border-radius:10px;background:#fff;
';
        $buffer .= $indent . '                  border:2px solid #e2e3ea;color:#0b0b0b;text-decoration:none;
';
        $buffer .= $indent . '                  font-weight:500;font-size:14px;line-height:1.1;">
';
        $buffer .= $indent . '          Find Tutors
';
        $buffer .= $indent . '        </a>
';
        $buffer .= $indent . '        <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '/local/findgroups/index.php"
';
        $buffer .= $indent . '           style="display:inline-flex;align-items:center;justify-content:center;
';
        $buffer .= $indent . '                  padding:10px 18px;border-radius:10px;background:#fff;
';
        $buffer .= $indent . '                  border:2px solid #e2e3ea;color:#0b0b0b;text-decoration:none;
';
        $buffer .= $indent . '                  font-weight:500;font-size:14px;line-height:1.1;">
';
        $buffer .= $indent . '          Find Groups
';
        $buffer .= $indent . '        </a>
';
        $buffer .= $indent . '      </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<script>
';
        $buffer .= $indent . '(function(){
';
        $buffer .= $indent . '  // Make the correct tab active on page load (matches lower nav behavior)
';
        $buffer .= $indent . '  var links = document.querySelectorAll(\'a[data-role="alpha2-nav-link"]\');
';
        $buffer .= $indent . '  if (!links.length) return;
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '  function setActive(el){
';
        $buffer .= $indent . '    // Reset all to non-active look
';
        $buffer .= $indent . '    links.forEach(function(a){
';
        $buffer .= $indent . '      a.style.color = \'#111\';
';
        $buffer .= $indent . '      a.style.fontWeight = \'500\';
';
        $buffer .= $indent . '      a.style.borderBottomColor = \'transparent\';
';
        $buffer .= $indent . '    });
';
        $buffer .= $indent . '    // Apply active look
';
        $buffer .= $indent . '    el.style.color = \'#e53935\';
';
        $buffer .= $indent . '    el.style.fontWeight = \'500\';
';
        $buffer .= $indent . '    el.style.borderBottomColor = \'#fe2e0c\';
';
        $buffer .= $indent . '  }
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '  // Pick active based on current path
';
        $buffer .= $indent . '  var here = window.location.pathname.replace(/\\/+$/,\'\'); // trim trailing slash
';
        $buffer .= $indent . '  var matched = null;
';
        $buffer .= $indent . '  links.forEach(function(a){
';
        $buffer .= $indent . '    var url = new URL(a.href, window.location.origin);
';
        $buffer .= $indent . '    var path = url.pathname.replace(/\\/+$/,\'\');
';
        $buffer .= $indent . '    if (path === here) { matched = a; }
';
        $buffer .= $indent . '  });
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '  if (matched) {
';
        $buffer .= $indent . '    setActive(matched);
';
        $buffer .= $indent . '  } else {
';
        $buffer .= $indent . '    // Fallback to Home if nothing matches
';
        $buffer .= $indent . '    setActive(links[0]);
';
        $buffer .= $indent . '  }
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '  // Optional: visual feedback before navigation (not required)
';
        $buffer .= $indent . '  links.forEach(function(a){
';
        $buffer .= $indent . '    a.addEventListener(\'click\', function(){ setActive(a); });
';
        $buffer .= $indent . '  });
';
        $buffer .= $indent . '})();
';
        $buffer .= $indent . '</script>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $value = $this->resolveValue($context->findDot('output.edit_switch'), $context);
        $buffer .= $indent . ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';

        return $buffer;
    }

    private function sectionE1b7734efa381e40cb6792ff2d8c4194(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'has-logo';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'has-logo';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9f02bdab39bdb326c592eb1133254d23(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'dark-mode-logo';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'dark-mode-logo';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB16bd79f5cd61bcf999fbd51db17d760(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<img src="{{customdmlogo}}" class="rui-custom-dmlogo" alt="{{sitename}}" />';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<img src="';
                $value = $this->resolveValue($context->find('customdmlogo'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="rui-custom-dmlogo" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" />';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF36802b2f0617b5baca1a59c2438cb62(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <span class="rui-logo {{#customdmlogo}}dark-mode-logo{{/customdmlogo}}">
                        <img src="{{customlogo}}" class="rui-custom-logo" alt="{{sitename}}" />
                        {{#customdmlogo}}<img src="{{customdmlogo}}" class="rui-custom-dmlogo" alt="{{sitename}}" />{{/customdmlogo}}
                    </span>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    <span class="rui-logo ';
                $value = $context->find('customdmlogo');
                $buffer .= $this->section9f02bdab39bdb326c592eb1133254d23($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '                        <img src="';
                $value = $this->resolveValue($context->find('customlogo'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="rui-custom-logo" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" />
';
                $buffer .= $indent . '                        ';
                $value = $context->find('customdmlogo');
                $buffer .= $this->sectionB16bd79f5cd61bcf999fbd51db17d760($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                    </span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE12c424e9358be319da6bb01c8406342(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{{ customlogotxt }}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('customlogotxt'), $context);
                $buffer .= ($value === null ? '' : $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1f393967a040d41ccbc36412f0524efb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <a id="logo" href="{{{ config.wwwroot }}}" class="d-inline-flex aabtn {{# output.should_display_navbar_logo }}has-logo{{/ output.should_display_navbar_logo }}">
                {{#customlogo}}
                    <span class="rui-logo {{#customdmlogo}}dark-mode-logo{{/customdmlogo}}">
                        <img src="{{customlogo}}" class="rui-custom-logo" alt="{{sitename}}" />
                        {{#customdmlogo}}<img src="{{customdmlogo}}" class="rui-custom-dmlogo" alt="{{sitename}}" />{{/customdmlogo}}
                    </span>
                {{/customlogo}}

                {{^customlogo}}
                    <span class="site-name">
                        {{^ customlogotxt }}{{{ sitename }}}{{/ customlogotxt }}
                        {{# customlogotxt }}{{{ customlogotxt }}}{{/ customlogotxt }}
                    </span>
                {{/customlogo}}
            </a>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <a id="logo" href="';
                $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" class="d-inline-flex aabtn ';
                $value = $context->findDot('output.should_display_navbar_logo');
                $buffer .= $this->sectionE1b7734efa381e40cb6792ff2d8c4194($context, $indent, $value);
                $buffer .= '">
';
                $value = $context->find('customlogo');
                $buffer .= $this->sectionF36802b2f0617b5baca1a59c2438cb62($context, $indent, $value);
                $buffer .= $indent . '
';
                $value = $context->find('customlogo');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                    <span class="site-name">
';
                    $buffer .= $indent . '                        ';
                    $value = $context->find('customlogotxt');
                    if (empty($value)) {
                        
                        $value = $this->resolveValue($context->find('sitename'), $context);
                        $buffer .= ($value === null ? '' : $value);
                    }
                    $buffer .= '
';
                    $buffer .= $indent . '                        ';
                    $value = $context->find('customlogotxt');
                    $buffer .= $this->sectionE12c424e9358be319da6bb01c8406342($context, $indent, $value);
                    $buffer .= '
';
                    $buffer .= $indent . '                    </span>
';
                }
                $buffer .= $indent . '            </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section010aa6f4e08815ab4a342e2589c47bc0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-topbar--custom-menu';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-topbar--custom-menu';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section78809003afd3b387d5b09e8f52115182(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-navbar-brand--img';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-navbar-brand--img';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section20ae68585704871e7ab3a11e79efeebc(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<img src="{{customdmlogo}}" class="rui-custom-dmlogo ml-2" alt="{{sitename}}" />';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<img src="';
                $value = $this->resolveValue($context->find('customdmlogo'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="rui-custom-dmlogo ml-2" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" />';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB5cfc4f1f6d6528046c187ea6b8b5a96(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<span class="site-name ml-2">{{{ customlogotxt }}}</span>';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<span class="site-name ml-2">';
                $value = $this->resolveValue($context->find('customlogotxt'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</span>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFaaa82185b3a4a1eddfa8d82c21b5592(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                            <span class="rui-logo {{#customdmlogo}}dark-mode-logo{{/customdmlogo}}">
                                <img src="{{customlogo}}" class="rui-custom-logo ml-2" alt="{{sitename}}" />
                                {{#customdmlogo}}<img src="{{customdmlogo}}" class="rui-custom-dmlogo ml-2" alt="{{sitename}}" />{{/customdmlogo}}
                            </span>
                            {{#logoandname}}<span class="site-name ml-2">{{{ customlogotxt }}}</span>{{/logoandname}}
                        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                            <span class="rui-logo ';
                $value = $context->find('customdmlogo');
                $buffer .= $this->section9f02bdab39bdb326c592eb1133254d23($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '                                <img src="';
                $value = $this->resolveValue($context->find('customlogo'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="rui-custom-logo ml-2" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" />
';
                $buffer .= $indent . '                                ';
                $value = $context->find('customdmlogo');
                $buffer .= $this->section20ae68585704871e7ab3a11e79efeebc($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                            </span>
';
                $buffer .= $indent . '                            ';
                $value = $context->find('logoandname');
                $buffer .= $this->sectionB5cfc4f1f6d6528046c187ea6b8b5a96($context, $indent, $value);
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBcb3a788b257e712017941eb2aea2fdd(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <a id="logo" href="{{{ config.wwwroot }}}/course/index.php" class="d-none d-lmd-inline-flex align-items-center rui-navbar-brand {{#customlogo}}rui-navbar-brand--img{{/customlogo}} aabtn {{# output.should_display_navbar_logo }}has-logo{{/ output.should_display_navbar_logo }}">
                        {{#customlogo}}
                            <span class="rui-logo {{#customdmlogo}}dark-mode-logo{{/customdmlogo}}">
                                <img src="{{customlogo}}" class="rui-custom-logo ml-2" alt="{{sitename}}" />
                                {{#customdmlogo}}<img src="{{customdmlogo}}" class="rui-custom-dmlogo ml-2" alt="{{sitename}}" />{{/customdmlogo}}
                            </span>
                            {{#logoandname}}<span class="site-name ml-2">{{{ customlogotxt }}}</span>{{/logoandname}}
                        {{/customlogo}}

                        {{^customlogo}}
                            <span class="site-name">
                                {{^ customlogotxt }}{{{ sitename }}}{{/ customlogotxt }}
                                    {{{ customlogotxt }}}
                            </span>
                        {{/customlogo}}
                    </a>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    <a id="logo" href="';
                $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '/course/index.php" class="d-none d-lmd-inline-flex align-items-center rui-navbar-brand ';
                $value = $context->find('customlogo');
                $buffer .= $this->section78809003afd3b387d5b09e8f52115182($context, $indent, $value);
                $buffer .= ' aabtn ';
                $value = $context->findDot('output.should_display_navbar_logo');
                $buffer .= $this->sectionE1b7734efa381e40cb6792ff2d8c4194($context, $indent, $value);
                $buffer .= '">
';
                $value = $context->find('customlogo');
                $buffer .= $this->sectionFaaa82185b3a4a1eddfa8d82c21b5592($context, $indent, $value);
                $buffer .= $indent . '
';
                $value = $context->find('customlogo');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                            <span class="site-name">
';
                    $buffer .= $indent . '                                ';
                    $value = $context->find('customlogotxt');
                    if (empty($value)) {
                        
                        $value = $this->resolveValue($context->find('sitename'), $context);
                        $buffer .= ($value === null ? '' : $value);
                    }
                    $buffer .= '
';
                    $buffer .= $indent . '                                    ';
                    $value = $this->resolveValue($context->find('customlogotxt'), $context);
                    $buffer .= ($value === null ? '' : $value);
                    $buffer .= '
';
                    $buffer .= $indent . '                            </span>
';
                }
                $buffer .= $indent . '                    </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section24b0f5b3d2e215b34aad915421f4467f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-navbar-nav--sep ml-lmd-2 pl-lmd-2';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-navbar-nav--sep ml-lmd-2 pl-lmd-2';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section03a2cb78adf693fb240638cbbc7ea15e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'true';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'true';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE8d02550eef8dd78cfe22b730ceb5426(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'tablist';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'tablist';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5749c750acb0d7477dd5257d00cc6d53(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'active';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'active';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC225dbeabea012d1739058de23648ffe(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'tab';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'tab';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section84145cfc94222b9f719134b3bf0cf718(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                require([\'core/moremenu\'], function(moremenu) {
                moremenu(document.querySelector(\'#moremenu-topbar\'));
                });
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                require([\'core/moremenu\'], function(moremenu) {
';
                $buffer .= $indent . '                moremenu(document.querySelector(\'#moremenu-topbar\'));
';
                $buffer .= $indent . '                });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCefeaa2a1c870dd3cb96afe51aac7537(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="primary-navigation">
                <nav class="moremenu navigation">




                    <ul id="moremenu-topbar" role="{{#istablist}}tablist{{/istablist}}{{^istablist}}menubar{{/istablist}}" class="nav more-nav">
                        {{{.}}}

                        <li role="none" class="dropdown dropdownmoremenu morebutton d-none" data-region="morebutton">
                            <a class="btn btn-icon btn--more nav-link p-0 {{#isactive}}active{{/isactive}}" href="#" id="moremenu-dropdown-topbar" role="{{#istablist}}tab{{/istablist}}{{^istablist}}menuitem{{/istablist}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" tabindex="-1">
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M13 12C13 12.5523 12.5523 13 12 13C11.4477 13 11 12.5523 11 12C11 11.4477 11.4477 11 12 11C12.5523 11 13 11.4477 13 12Z"></path>
                                    <path fill="currentColor" d="M13 8C13 8.55228 12.5523 9 12 9C11.4477 9 11 8.55228 11 8C11 7.44772 11.4477 7 12 7C12.5523 7 13 7.44772 13 8Z"></path>
                                    <path fill="currentColor" d="M13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16Z"></path>
                                </svg>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left" data-region="moredropdown" aria-labelledby="moremenu-dropdown-topbar" role="menu">
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            {{#js}}
                require([\'core/moremenu\'], function(moremenu) {
                moremenu(document.querySelector(\'#moremenu-topbar\'));
                });
            {{/js}}
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="primary-navigation">
';
                $buffer .= $indent . '                <nav class="moremenu navigation">
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '                    <ul id="moremenu-topbar" role="';
                $value = $context->find('istablist');
                $buffer .= $this->sectionE8d02550eef8dd78cfe22b730ceb5426($context, $indent, $value);
                $value = $context->find('istablist');
                if (empty($value)) {
                    
                    $buffer .= 'menubar';
                }
                $buffer .= '" class="nav more-nav">
';
                $buffer .= $indent . '                        ';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '                        <li role="none" class="dropdown dropdownmoremenu morebutton d-none" data-region="morebutton">
';
                $buffer .= $indent . '                            <a class="btn btn-icon btn--more nav-link p-0 ';
                $value = $context->find('isactive');
                $buffer .= $this->section5749c750acb0d7477dd5257d00cc6d53($context, $indent, $value);
                $buffer .= '" href="#" id="moremenu-dropdown-topbar" role="';
                $value = $context->find('istablist');
                $buffer .= $this->sectionC225dbeabea012d1739058de23648ffe($context, $indent, $value);
                $value = $context->find('istablist');
                if (empty($value)) {
                    
                    $buffer .= 'menuitem';
                }
                $buffer .= '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" tabindex="-1">
';
                $buffer .= $indent . '                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
';
                $buffer .= $indent . '                                    <path fill="currentColor" d="M13 12C13 12.5523 12.5523 13 12 13C11.4477 13 11 12.5523 11 12C11 11.4477 11.4477 11 12 11C12.5523 11 13 11.4477 13 12Z"></path>
';
                $buffer .= $indent . '                                    <path fill="currentColor" d="M13 8C13 8.55228 12.5523 9 12 9C11.4477 9 11 8.55228 11 8C11 7.44772 11.4477 7 12 7C12.5523 7 13 7.44772 13 8Z"></path>
';
                $buffer .= $indent . '                                    <path fill="currentColor" d="M13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16Z"></path>
';
                $buffer .= $indent . '                                </svg>
';
                $buffer .= $indent . '                            </a>
';
                $buffer .= $indent . '                            <ul class="dropdown-menu dropdown-menu-left" data-region="moredropdown" aria-labelledby="moremenu-dropdown-topbar" role="menu">
';
                $buffer .= $indent . '                            </ul>
';
                $buffer .= $indent . '                        </li>
';
                $buffer .= $indent . '                    </ul>
';
                $buffer .= $indent . '                </nav>
';
                $buffer .= $indent . '            </div>
';
                $value = $context->find('js');
                $buffer .= $this->section84145cfc94222b9f719134b3bf0cf718($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAbe74d3130161e83f822dea50afcfa17(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="rui-topbar-customfield ml-auto d-none d-lg-flex">{{{.}}}</div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="rui-topbar-customfield ml-auto d-none d-lg-flex">';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB73038a11462b44891572bb1f4acc90a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<li class="rui-icon-menu-admin rui-navbar-nav--sep ml-2">{{{output.adminheaderlinkhs}}}</li>';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<li class="rui-icon-menu-admin rui-navbar-nav--sep ml-2">';
                $value = $this->resolveValue($context->findDot('output.adminheaderlinkhs'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</li>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB8b4cd4719f0457c63c64cd48f7cca27(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' title="{{{sdarkmode}}}" ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' title="';
                $value = $this->resolveValue($context->find('sdarkmode'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCba3ade31ada94ef6526ced84cc41541(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <li class="rui-icon-menu-darkmode">
                        <button id="darkModeBtn" class="btn--darkmode" aria-checked="false" type="button" data-preference="darkmode-on" data-toggle="tooltip" data-placement="bottom" {{^sdarkmode}}title="Dark Mode" {{/sdarkmode}} {{#sdarkmode}} title="{{{sdarkmode}}}" {{/sdarkmode}}>
                            <div class="rui-dark-mode-status--on"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16ZM12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18Z" fill="currentColor" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 0H13V4.06189C12.6724 4.02104 12.3387 4 12 4C11.6613 4 11.3276 4.02104 11 4.06189V0ZM7.0943 5.68018L4.22173 2.80761L2.80752 4.22183L5.6801 7.09441C6.09071 6.56618 6.56608 6.0908 7.0943 5.68018ZM4.06189 11H0V13H4.06189C4.02104 12.6724 4 12.3387 4 12C4 11.6613 4.02104 11.3276 4.06189 11ZM5.6801 16.9056L2.80751 19.7782L4.22173 21.1924L7.0943 18.3198C6.56608 17.9092 6.09071 17.4338 5.6801 16.9056ZM11 19.9381V24H13V19.9381C12.6724 19.979 12.3387 20 12 20C11.6613 20 11.3276 19.979 11 19.9381ZM16.9056 18.3199L19.7781 21.1924L21.1923 19.7782L18.3198 16.9057C17.9092 17.4339 17.4338 17.9093 16.9056 18.3199ZM19.9381 13H24V11H19.9381C19.979 11.3276 20 11.6613 20 12C20 12.3387 19.979 12.6724 19.9381 13ZM18.3198 7.0943L21.1923 4.22183L19.7781 2.80762L16.9056 5.6801C17.4338 6.09071 17.9092 6.56608 18.3198 7.0943Z" fill="currentColor" />
                                </svg></div>
                            <div class="rui-dark-mode-status--off"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2256 2.00253C9.59172 1.94346 6.93894 2.9189 4.92893 4.92891C1.02369 8.83415 1.02369 15.1658 4.92893 19.071C8.83418 22.9763 15.1658 22.9763 19.0711 19.071C21.0811 17.061 22.0565 14.4082 21.9975 11.7743C21.9796 10.9772 21.8669 10.1818 21.6595 9.40643C21.0933 9.9488 20.5078 10.4276 19.9163 10.8425C18.5649 11.7906 17.1826 12.4053 15.9301 12.6837C14.0241 13.1072 12.7156 12.7156 12 12C11.2844 11.2844 10.8928 9.97588 11.3163 8.0699C11.5947 6.81738 12.2094 5.43511 13.1575 4.08368C13.5724 3.49221 14.0512 2.90664 14.5935 2.34046C13.8182 2.13305 13.0228 2.02041 12.2256 2.00253ZM17.6569 17.6568C18.9081 16.4056 19.6582 14.8431 19.9072 13.2186C16.3611 15.2643 12.638 15.4664 10.5858 13.4142C8.53361 11.362 8.73568 7.63895 10.7814 4.09281C9.1569 4.34184 7.59434 5.09193 6.34315 6.34313C3.21895 9.46732 3.21895 14.5326 6.34315 17.6568C9.46734 20.781 14.5327 20.781 17.6569 17.6568Z" fill="currentColor" />
                                </svg></div>
                        </button>
                    </li>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    <li class="rui-icon-menu-darkmode">
';
                $buffer .= $indent . '                        <button id="darkModeBtn" class="btn--darkmode" aria-checked="false" type="button" data-preference="darkmode-on" data-toggle="tooltip" data-placement="bottom" ';
                $value = $context->find('sdarkmode');
                if (empty($value)) {
                    
                    $buffer .= 'title="Dark Mode" ';
                }
                $buffer .= ' ';
                $value = $context->find('sdarkmode');
                $buffer .= $this->sectionB8b4cd4719f0457c63c64cd48f7cca27($context, $indent, $value);
                $buffer .= '>
';
                $buffer .= $indent . '                            <div class="rui-dark-mode-status--on"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
';
                $buffer .= $indent . '                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16ZM12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18Z" fill="currentColor" />
';
                $buffer .= $indent . '                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 0H13V4.06189C12.6724 4.02104 12.3387 4 12 4C11.6613 4 11.3276 4.02104 11 4.06189V0ZM7.0943 5.68018L4.22173 2.80761L2.80752 4.22183L5.6801 7.09441C6.09071 6.56618 6.56608 6.0908 7.0943 5.68018ZM4.06189 11H0V13H4.06189C4.02104 12.6724 4 12.3387 4 12C4 11.6613 4.02104 11.3276 4.06189 11ZM5.6801 16.9056L2.80751 19.7782L4.22173 21.1924L7.0943 18.3198C6.56608 17.9092 6.09071 17.4338 5.6801 16.9056ZM11 19.9381V24H13V19.9381C12.6724 19.979 12.3387 20 12 20C11.6613 20 11.3276 19.979 11 19.9381ZM16.9056 18.3199L19.7781 21.1924L21.1923 19.7782L18.3198 16.9057C17.9092 17.4339 17.4338 17.9093 16.9056 18.3199ZM19.9381 13H24V11H19.9381C19.979 11.3276 20 11.6613 20 12C20 12.3387 19.979 12.6724 19.9381 13ZM18.3198 7.0943L21.1923 4.22183L19.7781 2.80762L16.9056 5.6801C17.4338 6.09071 17.9092 6.56608 18.3198 7.0943Z" fill="currentColor" />
';
                $buffer .= $indent . '                                </svg></div>
';
                $buffer .= $indent . '                            <div class="rui-dark-mode-status--off"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
';
                $buffer .= $indent . '                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2256 2.00253C9.59172 1.94346 6.93894 2.9189 4.92893 4.92891C1.02369 8.83415 1.02369 15.1658 4.92893 19.071C8.83418 22.9763 15.1658 22.9763 19.0711 19.071C21.0811 17.061 22.0565 14.4082 21.9975 11.7743C21.9796 10.9772 21.8669 10.1818 21.6595 9.40643C21.0933 9.9488 20.5078 10.4276 19.9163 10.8425C18.5649 11.7906 17.1826 12.4053 15.9301 12.6837C14.0241 13.1072 12.7156 12.7156 12 12C11.2844 11.2844 10.8928 9.97588 11.3163 8.0699C11.5947 6.81738 12.2094 5.43511 13.1575 4.08368C13.5724 3.49221 14.0512 2.90664 14.5935 2.34046C13.8182 2.13305 13.0228 2.02041 12.2256 2.00253ZM17.6569 17.6568C18.9081 16.4056 19.6582 14.8431 19.9072 13.2186C16.3611 15.2643 12.638 15.4664 10.5858 13.4142C8.53361 11.362 8.73568 7.63895 10.7814 4.09281C9.1569 4.34184 7.59434 5.09193 6.34315 6.34313C3.21895 9.46732 3.21895 14.5326 6.34315 17.6568C9.46734 20.781 14.5327 20.781 17.6569 17.6568Z" fill="currentColor" />
';
                $buffer .= $indent . '                                </svg></div>
';
                $buffer .= $indent . '                        </button>
';
                $buffer .= $indent . '                    </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
