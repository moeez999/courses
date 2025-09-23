<?php

class __Mustache_01ae4d69ec953d285411357fd6eee69a extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $value = $context->find('settings');
        $buffer .= $this->sectionEaa5a2a864a955259afc665c684b8433($context, $indent, $value);

        return $buffer;
    }

    private function sectionE6c04fce2fea6762873e9c4a6436446c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' privacy, message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' privacy, message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8066e0c6b8fb0c0ca2f106b49fc72a1f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' privacy_desc, message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' privacy_desc, message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6b87ba4e2052a1621e2d049c4f3ede38(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="custom-control custom-radio mb-2 ml-2">
                <input
                    type="radio"
                    name="message_blocknoncontacts"
                    class="custom-control-input"
                    id="block-noncontacts-{{uniqid}}-{{value}}"
                    value="{{value}}"
                >
                <label class="custom-control-label ml-3" for="block-noncontacts-{{uniqid}}-{{value}}">
                    {{text}}
                </label>
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="custom-control custom-radio mb-2 ml-2">
';
                $buffer .= $indent . '                <input
';
                $buffer .= $indent . '                    type="radio"
';
                $buffer .= $indent . '                    name="message_blocknoncontacts"
';
                $buffer .= $indent . '                    class="custom-control-input"
';
                $buffer .= $indent . '                    id="block-noncontacts-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '-';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"
';
                $buffer .= $indent . '                    value="';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"
';
                $buffer .= $indent . '                >
';
                $buffer .= $indent . '                <label class="custom-control-label ml-3" for="block-noncontacts-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '-';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('text'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '
';
                $buffer .= $indent . '                </label>
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section536de0f92617de273ac3373d5c1904d0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' notificationpreferences, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' notificationpreferences, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9cac6e41b8d2a2f3f442af8b75816dd0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' general, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' general, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section51d7c9c652ced0161cb587bacd669266(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'checked';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'checked';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section52fe934e9fc665fc68606e5d376063e6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' useentertosend, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' useentertosend, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEaa5a2a864a955259afc665c684b8433(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
<div class="rui-message-container-md">
    <h4>{{#str}} privacy, message {{/str}}</h4>
    <p>{{#str}} privacy_desc, message {{/str}}</p>
    <div data-preference="blocknoncontacts" class="mb-3">
        {{#privacy}}
            <div class="custom-control custom-radio mb-2 ml-2">
                <input
                    type="radio"
                    name="message_blocknoncontacts"
                    class="custom-control-input"
                    id="block-noncontacts-{{uniqid}}-{{value}}"
                    value="{{value}}"
                >
                <label class="custom-control-label ml-3" for="block-noncontacts-{{uniqid}}-{{value}}">
                    {{text}}
                </label>
            </div>
        {{/privacy}}
    </div>

    <hr />

    <div class="hidden" data-region="notification-preference-container">
        <h4>{{#str}} notificationpreferences, core_message {{/str}}</h4>
    </div>

    <hr />

    <div data-preference="entertosend">
        <h4>{{#str}} general, core {{/str}}</h4>
        <span class="switch custom-controls-stacked">
            <label class="custom-control ios-switch d-inline-flex align-items-center">
                <input class="ios-switch-control-input" type="checkbox"
                    id="enter-to-send-{{uniqid}}"
                    {{#entertosend}}checked{{/entertosend}}
                >
                <span class="ios-switch-control-indicator"></span>
                <label class="my-0" for="enter-to-send-{{uniqid}}">
                    {{#str}} useentertosend, core_message {{/str}}
                </label>
            </label>
        </span>
    </div>
</div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '<div class="rui-message-container-md">
';
                $buffer .= $indent . '    <h4>';
                $value = $context->find('str');
                $buffer .= $this->sectionE6c04fce2fea6762873e9c4a6436446c($context, $indent, $value);
                $buffer .= '</h4>
';
                $buffer .= $indent . '    <p>';
                $value = $context->find('str');
                $buffer .= $this->section8066e0c6b8fb0c0ca2f106b49fc72a1f($context, $indent, $value);
                $buffer .= '</p>
';
                $buffer .= $indent . '    <div data-preference="blocknoncontacts" class="mb-3">
';
                $value = $context->find('privacy');
                $buffer .= $this->section6b87ba4e2052a1621e2d049c4f3ede38($context, $indent, $value);
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    <hr />
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    <div class="hidden" data-region="notification-preference-container">
';
                $buffer .= $indent . '        <h4>';
                $value = $context->find('str');
                $buffer .= $this->section536de0f92617de273ac3373d5c1904d0($context, $indent, $value);
                $buffer .= '</h4>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    <hr />
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    <div data-preference="entertosend">
';
                $buffer .= $indent . '        <h4>';
                $value = $context->find('str');
                $buffer .= $this->section9cac6e41b8d2a2f3f442af8b75816dd0($context, $indent, $value);
                $buffer .= '</h4>
';
                $buffer .= $indent . '        <span class="switch custom-controls-stacked">
';
                $buffer .= $indent . '            <label class="custom-control ios-switch d-inline-flex align-items-center">
';
                $buffer .= $indent . '                <input class="ios-switch-control-input" type="checkbox"
';
                $buffer .= $indent . '                    id="enter-to-send-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"
';
                $buffer .= $indent . '                    ';
                $value = $context->find('entertosend');
                $buffer .= $this->section51d7c9c652ced0161cb587bacd669266($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                >
';
                $buffer .= $indent . '                <span class="ios-switch-control-indicator"></span>
';
                $buffer .= $indent . '                <label class="my-0" for="enter-to-send-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $buffer .= $indent . '                    ';
                $value = $context->find('str');
                $buffer .= $this->section52fe934e9fc665fc68606e5d376063e6($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                </label>
';
                $buffer .= $indent . '            </label>
';
                $buffer .= $indent . '        </span>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
