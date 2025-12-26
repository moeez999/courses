<?php

class __Mustache_0eb0a49c3cdeb716e9cb238ab1f63196 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="hidden rui-message-header-margin w-100" aria-hidden="true" data-region="view-contacts">
';
        $buffer .= $indent . '    <div class="d-flex align-items-center w-100">
';
        $value = $context->find('isdrawer');
        $buffer .= $this->section26ca95ab700e629614e6d7323ab8c12a($context, $indent, $value);
        $buffer .= $indent . '        <h4 class="rui-message-heading ml-3">
';
        $buffer .= $indent . '            ';
        $value = $context->find('str');
        $buffer .= $this->sectionAe27671d8d1750e9af3adcc5df1cbf0d($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </h4>
';
        $buffer .= $indent . '        <div class="mr-3 ml-auto">
';
        $buffer .= $indent . '            <a href="#" data-route="view-search" class="btn-msg" role="button" aria-label="';
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '                <svg height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg"><path d="m14.5 14.5-3.75-3.75m-10.75-4.5c0-3.45178 2.79822-6.25 6.25-6.25 3.4518 0 6.25 2.79822 6.25 6.25 0 3.4518-2.7982 6.25-6.25 6.25-3.45178 0-6.25-2.7982-6.25-6.25z" fill="none" stroke="#626262" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" transform="translate(.75 .75)"/></svg>
';
        $buffer .= $indent . '            </a>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section26ca95ab700e629614e6d7323ab8c12a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="align-self-stretch">
            <a class="ml-3 d-flex align-items-center btn-msg" href="#" data-route-back role="button">
                {{> core_message/message_drawer_icon_back }}
            </a>
        </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="align-self-stretch">
';
                $buffer .= $indent . '            <a class="ml-3 d-flex align-items-center btn-msg" href="#" data-route-back role="button">
';
                if ($partial = $this->mustache->loadPartial('core_message/message_drawer_icon_back')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                ');
                }
                $buffer .= $indent . '            </a>
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAe27671d8d1750e9af3adcc5df1cbf0d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' contacts, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' contacts, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section507b9f28a10a9aed70b7b7a308c6a3ca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' search, core_search ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' search, core_search ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
