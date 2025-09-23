<?php

class __Mustache_4947d75876376bdec031d080069d075c extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="position-relative">
';
        $buffer .= $indent . '
';
        $value = $context->find('displayteachers');
        $buffer .= $this->section8c6c1ec30f445854965edd0daf952f0d($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <a href="';
        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '/course/view.php?id=';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '">
';
        $buffer .= $indent . '        <div class="rui-course-card rui-progress-';
        $value = $this->resolveValue($context->find('progress'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= ' ';
        $value = $context->find('displayteachers');
        $buffer .= $this->section39fc98886700ceef9bc7a83c130b2bad($context, $indent, $value);
        $buffer .= ' ';
        $value = $context->find('cccsummary');
        $buffer .= $this->section37ba44babfd4ecd137dba062427f3cdb($context, $indent, $value);
        $buffer .= '" role="listitem" data-region="course-content" data-course-id="';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '">
';
        $buffer .= $indent . '
';
        $value = $context->find('hasenrolmenticons');
        $buffer .= $this->section51d4f9d8cd26dfa666d4399ca8549f79($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '            <div class="rui-course-card-wrapper">
';
        $buffer .= $indent . '                <figure class="rui-course-card-img-top" style="background-image: url(';
        $value = $this->resolveValue($context->find('image'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= ');"><span class="sr-only">';
        $value = $context->find('str');
        $buffer .= $this->section770d421ad5e692e1604f4cccb1a279f2($context, $indent, $value);
        $buffer .= ' ';
        $value = $this->resolveValue($context->find('fullname'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '</span></figure>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                <div class="rui-course-card-body">
';
        $buffer .= $indent . '                    <div class="d-flex flex-wrap">
';
        $buffer .= $indent . '                        <span class="sr-only">
';
        $buffer .= $indent . '                            ';
        $value = $context->find('str');
        $buffer .= $this->sectionC1f0f38377711c41e832dec5d81a2e6f($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                        </span>
';
        $buffer .= $indent . '
';
        $value = $context->find('visible');
        if (empty($value)) {
            
            $buffer .= $indent . '                            <div class="d-inline-flex flex-wrap mb-2">
';
            $buffer .= $indent . '                                <span class="rui-course-hidden-badge">
';
            $buffer .= $indent . '                                    <svg class="mr-1" width="16" height="16" fill="none" viewBox="0 0 24 24">
';
            $buffer .= $indent . '                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.6247 10C19.0646 10.8986 19.25 11.6745 19.25 12C19.25 13 17.5 18.25 12 18.25C11.2686 18.25 10.6035 18.1572 10 17.9938M7 16.2686C5.36209 14.6693 4.75 12.5914 4.75 12C4.75 11 6.5 5.75 12 5.75C13.7947 5.75 15.1901 6.30902 16.2558 7.09698"></path>
';
            $buffer .= $indent . '                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.25 4.75L4.75 19.25"></path>
';
            $buffer .= $indent . '                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.409 13.591C9.53033 12.7123 9.53033 11.2877 10.409 10.409C11.2877 9.5303 12.7123 9.5303 13.591 10.409"></path>
';
            $buffer .= $indent . '                                    </svg>
';
            $buffer .= $indent . '                                    ';
            $value = $context->find('str');
            $buffer .= $this->section6e27c6955cb05d4f01c4ab8799872e12($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '                                </span>
';
            $buffer .= $indent . '                            </div>
';
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                    <div class="d-flex mb-1">
';
        $buffer .= $indent . '                        <h4 class="rui-course-card-title mb-1 coursename">
';
        $buffer .= $indent . '                            <span class="sr-only">
';
        $buffer .= $indent . '                                ';
        $value = $context->find('str');
        $buffer .= $this->section812e363a880e32990e0f434e718baef5($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                            </span>
';
        $buffer .= $indent . '                            ';
        $value = $this->resolveValue($context->find('fullname'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '                        </h4>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '
';
        $value = $context->find('category');
        $buffer .= $this->section7d313c94054a7c0ebb04bcbd4ef78150($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '
';
        $value = $context->find('hasprogress');
        $buffer .= $this->section73ce2ae783c5b63e6a9d709fa464a197($context, $indent, $value);
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </a>
';
        $value = $context->find('cccsummary');
        $buffer .= $this->sectionD5a2021267930d19e3fdbe756b43f445($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '</div>';

        return $buffer;
    }

    private function sectionF3d32d026a6109fa0f1f276f386a66d7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-course-card-progress';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-course-card-progress';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section11431af2cf07846d78ed359f046a3ca9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <a href="{{config.wwwroot}}/user/profile.php?id={{{id}}}" class="rui-tooltip rui-card-contact rui-user-{{{role}}}" data-title="{{{fullname}}} - {{{role}}}">
                        <img src="{{{userpicture}}}" class="rui-card-avatar" alt="{{{fullname}}}" />
                    </a>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    <a href="';
                $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '/user/profile.php?id=';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" class="rui-tooltip rui-card-contact rui-user-';
                $value = $this->resolveValue($context->find('role'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" data-title="';
                $value = $this->resolveValue($context->find('fullname'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= ' - ';
                $value = $this->resolveValue($context->find('role'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '">
';
                $buffer .= $indent . '                        <img src="';
                $value = $this->resolveValue($context->find('userpicture'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" class="rui-card-avatar" alt="';
                $value = $this->resolveValue($context->find('fullname'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" />
';
                $buffer .= $indent . '                    </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8fe1036fd45c2073a15245aad59fcc15(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="rui-card-course-contacts {{#hasprogress}}rui-course-card-progress{{/hasprogress}}">
                {{#contacts}}
                    <a href="{{config.wwwroot}}/user/profile.php?id={{{id}}}" class="rui-tooltip rui-card-contact rui-user-{{{role}}}" data-title="{{{fullname}}} - {{{role}}}">
                        <img src="{{{userpicture}}}" class="rui-card-avatar" alt="{{{fullname}}}" />
                    </a>
                {{/contacts}}
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="rui-card-course-contacts ';
                $value = $context->find('hasprogress');
                $buffer .= $this->sectionF3d32d026a6109fa0f1f276f386a66d7($context, $indent, $value);
                $buffer .= '">
';
                $value = $context->find('contacts');
                $buffer .= $this->section11431af2cf07846d78ed359f046a3ca9($context, $indent, $value);
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8c6c1ec30f445854965edd0daf952f0d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{#hascontacts}}
            <div class="rui-card-course-contacts {{#hasprogress}}rui-course-card-progress{{/hasprogress}}">
                {{#contacts}}
                    <a href="{{config.wwwroot}}/user/profile.php?id={{{id}}}" class="rui-tooltip rui-card-contact rui-user-{{{role}}}" data-title="{{{fullname}}} - {{{role}}}">
                        <img src="{{{userpicture}}}" class="rui-card-avatar" alt="{{{fullname}}}" />
                    </a>
                {{/contacts}}
            </div>
        {{/hascontacts}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('hascontacts');
                $buffer .= $this->section8fe1036fd45c2073a15245aad59fcc15($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8c9d09748c81a521a506b699cb5a019e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-course-card-avatars';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-course-card-avatars';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section39fc98886700ceef9bc7a83c130b2bad(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{#hascontacts}}rui-course-card-avatars{{/hascontacts}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('hascontacts');
                $buffer .= $this->section8c9d09748c81a521a506b699cb5a019e($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section37ba44babfd4ecd137dba062427f3cdb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-course-card--sum';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-course-card--sum';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0cc4ce5148492264b152bb2e39813718(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                        <div class="rui-icon-container">
                            {{{.}}}
                        </div>
                    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                        <div class="rui-icon-container">
';
                $buffer .= $indent . '                            ';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '                        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section51d4f9d8cd26dfa666d4399ca8549f79(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="rui-course-card-icons">
                    {{#enrolmenticons}}
                        <div class="rui-icon-container">
                            {{{.}}}
                        </div>
                    {{/enrolmenticons}}
                </div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="rui-course-card-icons">
';
                $value = $context->find('enrolmenticons');
                $buffer .= $this->section0cc4ce5148492264b152bb2e39813718($context, $indent, $value);
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section770d421ad5e692e1604f4cccb1a279f2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'aria:courseimage, core_course';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'aria:courseimage, core_course';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC1f0f38377711c41e832dec5d81a2e6f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'aria:coursecategory, core_course';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'aria:coursecategory, core_course';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6e27c6955cb05d4f01c4ab8799872e12(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' hiddenfromstudents ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' hiddenfromstudents ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section812e363a880e32990e0f434e718baef5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'aria:coursename, core_course';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'aria:coursename, core_course';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7d313c94054a7c0ebb04bcbd4ef78150(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                        <div class="d-inline-flex mt-2">
                            <div class="rui-course-cat-badge">
                                {{{category}}}
                            </div>
                        </div>
                    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                        <div class="d-inline-flex mt-2">
';
                $buffer .= $indent . '                            <div class="rui-course-cat-badge">
';
                $buffer .= $indent . '                                ';
                $value = $this->resolveValue($context->find('category'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '                            </div>
';
                $buffer .= $indent . '                        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section73ce2ae783c5b63e6a9d709fa464a197(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="rui-course-card-progress-bar">
                    {{> block_myoverview/progress-bar}}
                </div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="rui-course-card-progress-bar">
';
                if ($partial = $this->mustache->loadPartial('block_myoverview/progress-bar')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                    ');
                }
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBbec850df83f6b2f99f25d78d2fa33e9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'aria:coursesummary, block_myoverview';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'aria:coursesummary, block_myoverview';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB09c893d2668f5edf5e843f28ad256f0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{coursecarddesclimit}}, {{{summary}}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('coursecarddesclimit'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ', ';
                $value = $this->resolveValue($context->find('summary'), $context);
                $buffer .= ($value === null ? '' : $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD5a2021267930d19e3fdbe756b43f445(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="rui-course-card-text">
            <span class="sr-only">{{#str}}aria:coursesummary, block_myoverview{{/str}}</span>
            {{#shortentext}}{{coursecarddesclimit}}, {{{summary}}}{{/shortentext}}
        </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="rui-course-card-text">
';
                $buffer .= $indent . '            <span class="sr-only">';
                $value = $context->find('str');
                $buffer .= $this->sectionBbec850df83f6b2f99f25d78d2fa33e9($context, $indent, $value);
                $buffer .= '</span>
';
                $buffer .= $indent . '            ';
                $value = $context->find('shortentext');
                $buffer .= $this->sectionB09c893d2668f5edf5e843f28ad256f0($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
