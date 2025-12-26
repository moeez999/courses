<?php

class __Mustache_99f114099d2de1ff22c64c40f88c0fad extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="d-md-inline-flex w-100">
';
        $buffer .= $indent . '    <div class="rui-nav--admin-container">
';
        $buffer .= $indent . '        <ul class="rui-nav--admin nav nav-column flex-md-column" role="tablist">
';
        $buffer .= $indent . '        <!-- First the top most node and immediate children -->
';
        $buffer .= $indent . '            <li class="nav-item">
';
        $buffer .= $indent . '                <a class="nav-link active" href="#link';
        $value = $this->resolveValue($context->findDot('node.key'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" data-toggle="tab" role="tab" aria-selected="true">';
        $value = $this->resolveValue($context->findDot('node.text'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '</a>
';
        $buffer .= $indent . '            </li>
';
        $buffer .= $indent . '        <!-- Now the first level children with sub nodes -->
';
        $value = $context->findDot('node.children');
        $buffer .= $this->section3ec6b444648e9400078ed1673345a94f($context, $indent, $value);
        $buffer .= $indent . '        </ul>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <div class="col tab-content px-0">
';
        $buffer .= $indent . '        <div class="tab-pane active" id="link';
        $value = $this->resolveValue($context->findDot('node.key'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" role="tabpanel">
';
        $buffer .= $indent . '            <div class="container rui-settings-container ml-md-4 px-0">
';
        $buffer .= $indent . '                <div class="row">
';
        $buffer .= $indent . '                    <div class="col-sm-12 col-md-3 pt-5">
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                    <div class="col">
';
        $buffer .= $indent . '                        <ul class="list-unstyled rui-list-admin-links">
';
        $value = $context->findDot('node.children');
        $buffer .= $this->section36d38874b141b882b8109709daaa9926($context, $indent, $value);
        $buffer .= $indent . '                        </ul>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '
';
        $value = $context->findDot('node.children');
        $buffer .= $this->section75f3e9558d27e3e7182bc6dba8df1b65($context, $indent, $value);
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '        </div>
';
        $value = $context->findDot('node.children');
        $buffer .= $this->section16aa31225df8275f1859864c8233954f($context, $indent, $value);
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>';

        return $buffer;
    }

    private function section25e708e678a90153ddf2c70b6a90e9f7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{^is_short_branch}}
                        <li class="nav-item">
                            <a class="nav-link" href="#link{{key}}" data-toggle="tab" role="tab" aria-selected="false" tabindex="-1">{{text}}</a>
                        </li>
                    {{/is_short_branch}}
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('is_short_branch');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                        <li class="nav-item">
';
                    $buffer .= $indent . '                            <a class="nav-link" href="#link';
                    $value = $this->resolveValue($context->find('key'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-toggle="tab" role="tab" aria-selected="false" tabindex="-1">';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '</a>
';
                    $buffer .= $indent . '                        </li>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCfc2ab05a77f9ab5f6662c004c3b99cb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                {{#display}}
                    {{^is_short_branch}}
                        <li class="nav-item">
                            <a class="nav-link" href="#link{{key}}" data-toggle="tab" role="tab" aria-selected="false" tabindex="-1">{{text}}</a>
                        </li>
                    {{/is_short_branch}}
                {{/display}}
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('display');
                $buffer .= $this->section25e708e678a90153ddf2c70b6a90e9f7($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3ec6b444648e9400078ed1673345a94f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#children.count}}
                {{#display}}
                    {{^is_short_branch}}
                        <li class="nav-item">
                            <a class="nav-link" href="#link{{key}}" data-toggle="tab" role="tab" aria-selected="false" tabindex="-1">{{text}}</a>
                        </li>
                    {{/is_short_branch}}
                {{/display}}
            {{/children.count}}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->findDot('children.count');
                $buffer .= $this->sectionCfc2ab05a77f9ab5f6662c004c3b99cb($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section906410a0ec191fc2f21c801d97817b2e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                        <li><a href="{{{action}}}">{{text}}</a></li>
                                    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                                        <li><a href="';
                $value = $this->resolveValue($context->find('action'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '">';
                $value = $this->resolveValue($context->find('text'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</a></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section36d38874b141b882b8109709daaa9926(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                {{^children.count}}
                                    {{#display}}
                                        <li><a href="{{{action}}}">{{text}}</a></li>
                                    {{/display}}
                                {{/children.count}}
                            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->findDot('children.count');
                if (empty($value)) {
                    
                    $value = $context->find('display');
                    $buffer .= $this->section906410a0ec191fc2f21c801d97817b2e($context, $indent, $value);
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF8578bcfdbac5f107b65d64c35e0bc39(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<h4><a class="badge badge-secondary" href="';
                $value = $this->resolveValue($context->find('action'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">';
                $value = $this->resolveValue($context->find('text'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</a></h4>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE2636ed0abcb943510fd2f38963a0af5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                                {{> core/settings_link_page_single }}
                                            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core/settings_link_page_single')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                                                ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE6949e1ce49d6793c71e8b84e874cfba(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                        {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                                    </div>
                                    <div class="col">
                                        <ul class="list-unstyled rui-list-admin-links">
                                            {{#children}}
                                                {{> core/settings_link_page_single }}
                                            {{/children}}
                                        </ul>
                                    </div>
                                </div>
                            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                                <hr>
';
                $buffer .= $indent . '                                <div class="row">
';
                $buffer .= $indent . '                                    <div class="col-sm-12 col-md-3">
';
                $buffer .= $indent . '                                        ';
                $value = $context->find('action');
                $buffer .= $this->sectionF8578bcfdbac5f107b65d64c35e0bc39($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                                        ';
                $value = $context->find('action');
                if (empty($value)) {
                    
                    $buffer .= '<h4 class="badge badge-light">';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '</h4>';
                }
                $buffer .= '
';
                $buffer .= $indent . '                                    </div>
';
                $buffer .= $indent . '                                    <div class="col">
';
                $buffer .= $indent . '                                        <ul class="list-unstyled rui-list-admin-links">
';
                $value = $context->find('children');
                $buffer .= $this->sectionE2636ed0abcb943510fd2f38963a0af5($context, $indent, $value);
                $buffer .= $indent . '                                        </ul>
';
                $buffer .= $indent . '                                    </div>
';
                $buffer .= $indent . '                                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEa31d16a65e03b7abb9fd8db1388e12c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                            {{#is_short_branch}}
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                        {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                                    </div>
                                    <div class="col">
                                        <ul class="list-unstyled rui-list-admin-links">
                                            {{#children}}
                                                {{> core/settings_link_page_single }}
                                            {{/children}}
                                        </ul>
                                    </div>
                                </div>
                            {{/is_short_branch}}
                        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('is_short_branch');
                $buffer .= $this->sectionE6949e1ce49d6793c71e8b84e874cfba($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAcc555bc7cb6739a6ea3788e670d8ad8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                        {{#children.count}}
                            {{#is_short_branch}}
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                        {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                                    </div>
                                    <div class="col">
                                        <ul class="list-unstyled rui-list-admin-links">
                                            {{#children}}
                                                {{> core/settings_link_page_single }}
                                            {{/children}}
                                        </ul>
                                    </div>
                                </div>
                            {{/is_short_branch}}
                        {{/children.count}}
                    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->findDot('children.count');
                $buffer .= $this->sectionEa31d16a65e03b7abb9fd8db1388e12c($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section75f3e9558d27e3e7182bc6dba8df1b65(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{#display}}
                        {{#children.count}}
                            {{#is_short_branch}}
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                        {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                                    </div>
                                    <div class="col">
                                        <ul class="list-unstyled rui-list-admin-links">
                                            {{#children}}
                                                {{> core/settings_link_page_single }}
                                            {{/children}}
                                        </ul>
                                    </div>
                                </div>
                            {{/is_short_branch}}
                        {{/children.count}}
                    {{/display}}
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('display');
                $buffer .= $this->sectionAcc555bc7cb6739a6ea3788e670d8ad8($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9bea4e2a2c8e34e8326486ead858734c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                            {{^children.count}}
                                                <li><a href="{{{action}}}">{{text}}</a></li>
                                            {{/children.count}}
                                        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->findDot('children.count');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                                                <li><a href="';
                    $value = $this->resolveValue($context->find('action'), $context);
                    $buffer .= ($value === null ? '' : $value);
                    $buffer .= '">';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '</a></li>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFdb1978ed2df2d5daa0368e707ed63c6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                        {{#display}}
                                            {{^children.count}}
                                                <li><a href="{{{action}}}">{{text}}</a></li>
                                            {{/children.count}}
                                        {{/display}}
                                    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('display');
                $buffer .= $this->section9bea4e2a2c8e34e8326486ead858734c($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD515a2da18fbbccd4f69b486e89c6f10(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                                    {{> core/settings_link_page_single }}
                                                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core/settings_link_page_single')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                                                    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF4dd51a892c9f9b6a5f1e941b32c2d09(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3 mt-1">
                                            {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                            {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <ul class="list-unstyled rui-list-admin-links">
                                                {{#children}}
                                                    {{> core/settings_link_page_single }}
                                                {{/children}}
                                            </ul>
                                        </div>
                                    </div>
                                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                                    <hr>
';
                $buffer .= $indent . '                                    <div class="row">
';
                $buffer .= $indent . '                                        <div class="col-sm-12 col-md-3 mt-1">
';
                $buffer .= $indent . '                                            ';
                $value = $context->find('action');
                $buffer .= $this->sectionF8578bcfdbac5f107b65d64c35e0bc39($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                                            ';
                $value = $context->find('action');
                if (empty($value)) {
                    
                    $buffer .= '<h4 class="badge badge-light">';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '</h4>';
                }
                $buffer .= '
';
                $buffer .= $indent . '                                        </div>
';
                $buffer .= $indent . '                                        <div class="col-sm-12 col-md-9">
';
                $buffer .= $indent . '                                            <ul class="list-unstyled rui-list-admin-links">
';
                $value = $context->find('children');
                $buffer .= $this->sectionD515a2da18fbbccd4f69b486e89c6f10($context, $indent, $value);
                $buffer .= $indent . '                                            </ul>
';
                $buffer .= $indent . '                                        </div>
';
                $buffer .= $indent . '                                    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCf751128410aed5c26b1d779877d44ce(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                {{#children.count}}
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3 mt-1">
                                            {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                            {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <ul class="list-unstyled rui-list-admin-links">
                                                {{#children}}
                                                    {{> core/settings_link_page_single }}
                                                {{/children}}
                                            </ul>
                                        </div>
                                    </div>
                                {{/children.count}}
                            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->findDot('children.count');
                $buffer .= $this->sectionF4dd51a892c9f9b6a5f1e941b32c2d09($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section01eb665764253ca31b93815b7e22e718(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                            {{#display}}
                                {{#children.count}}
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3 mt-1">
                                            {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                            {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <ul class="list-unstyled rui-list-admin-links">
                                                {{#children}}
                                                    {{> core/settings_link_page_single }}
                                                {{/children}}
                                            </ul>
                                        </div>
                                    </div>
                                {{/children.count}}
                            {{/display}}
                        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('display');
                $buffer .= $this->sectionCf751128410aed5c26b1d779877d44ce($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9fe6de88b5368b40183bd01eca8f6135(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="tab-pane" id="link{{key}}" role="tabpanel">
                    <div class="container rui-settings-container ml-md-4 px-0">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 mt-1">
                                {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <ul class="list-unstyled rui-list-admin-links">
                                    {{#children}}
                                        {{#display}}
                                            {{^children.count}}
                                                <li><a href="{{{action}}}">{{text}}</a></li>
                                            {{/children.count}}
                                        {{/display}}
                                    {{/children}}
                                </ul>
                            </div>
                        </div>
                        {{#children}}
                            {{#display}}
                                {{#children.count}}
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3 mt-1">
                                            {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                            {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <ul class="list-unstyled rui-list-admin-links">
                                                {{#children}}
                                                    {{> core/settings_link_page_single }}
                                                {{/children}}
                                            </ul>
                                        </div>
                                    </div>
                                {{/children.count}}
                            {{/display}}
                        {{/children}}
                    </div>
                </div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="tab-pane" id="link';
                $value = $this->resolveValue($context->find('key'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" role="tabpanel">
';
                $buffer .= $indent . '                    <div class="container rui-settings-container ml-md-4 px-0">
';
                $buffer .= $indent . '                        <div class="row">
';
                $buffer .= $indent . '                            <div class="col-sm-12 col-md-3 mt-1">
';
                $buffer .= $indent . '                                ';
                $value = $context->find('action');
                $buffer .= $this->sectionF8578bcfdbac5f107b65d64c35e0bc39($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                                ';
                $value = $context->find('action');
                if (empty($value)) {
                    
                    $buffer .= '<h4 class="badge badge-light">';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '</h4>';
                }
                $buffer .= '
';
                $buffer .= $indent . '                            </div>
';
                $buffer .= $indent . '                            <div class="col-sm-12 col-md-9">
';
                $buffer .= $indent . '                                <ul class="list-unstyled rui-list-admin-links">
';
                $value = $context->find('children');
                $buffer .= $this->sectionFdb1978ed2df2d5daa0368e707ed63c6($context, $indent, $value);
                $buffer .= $indent . '                                </ul>
';
                $buffer .= $indent . '                            </div>
';
                $buffer .= $indent . '                        </div>
';
                $value = $context->find('children');
                $buffer .= $this->section01eb665764253ca31b93815b7e22e718($context, $indent, $value);
                $buffer .= $indent . '                    </div>
';
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section16aa31225df8275f1859864c8233954f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#children.count}}
                <div class="tab-pane" id="link{{key}}" role="tabpanel">
                    <div class="container rui-settings-container ml-md-4 px-0">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 mt-1">
                                {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <ul class="list-unstyled rui-list-admin-links">
                                    {{#children}}
                                        {{#display}}
                                            {{^children.count}}
                                                <li><a href="{{{action}}}">{{text}}</a></li>
                                            {{/children.count}}
                                        {{/display}}
                                    {{/children}}
                                </ul>
                            </div>
                        </div>
                        {{#children}}
                            {{#display}}
                                {{#children.count}}
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3 mt-1">
                                            {{#action}}<h4><a class="badge badge-secondary" href="{{action}}">{{text}}</a></h4>{{/action}}
                                            {{^action}}<h4 class="badge badge-light">{{text}}</h4>{{/action}}
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <ul class="list-unstyled rui-list-admin-links">
                                                {{#children}}
                                                    {{> core/settings_link_page_single }}
                                                {{/children}}
                                            </ul>
                                        </div>
                                    </div>
                                {{/children.count}}
                            {{/display}}
                        {{/children}}
                    </div>
                </div>
            {{/children.count}}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->findDot('children.count');
                $buffer .= $this->section9fe6de88b5368b40183bd01eca8f6135($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
