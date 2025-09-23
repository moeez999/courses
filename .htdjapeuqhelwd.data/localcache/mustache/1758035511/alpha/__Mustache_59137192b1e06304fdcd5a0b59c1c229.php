<?php

class __Mustache_59137192b1e06304fdcd5a0b59c1c229 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="d-flex align-items-center my-3">
';
        $value = $context->find('showrouteback');
        $buffer .= $this->section54398570c1d003f7c62e3f0942f9da28($context, $indent, $value);
        $buffer .= $indent . '    <div
';
        $buffer .= $indent . '        class="ml-0 rounded bg-pulse-grey align-self-center"
';
        $buffer .= $indent . '        style="height: 38px; width: 38px"
';
        $buffer .= $indent . '    >
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="ml-3" style="flex: 1">
';
        $buffer .= $indent . '        <div
';
        $buffer .= $indent . '            class="bg-pulse-grey w-75"
';
        $buffer .= $indent . '            style="height: 16px;"
';
        $buffer .= $indent . '        >
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div
';
        $buffer .= $indent . '        class="mr-2 bg-pulse-grey align-self-center"
';
        $buffer .= $indent . '        style="height: 20px; width: 20px"
';
        $buffer .= $indent . '    >
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section54398570c1d003f7c62e3f0942f9da28(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="align-self-stretch" >
        <a class="h-100 py-3 mr-2 d-flex align-items-center btn btn-sm" href="#" data-route-back role="button">
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
                
                $buffer .= $indent . '    <div class="align-self-stretch" >
';
                $buffer .= $indent . '        <a class="h-100 py-3 mr-2 d-flex align-items-center btn btn-sm" href="#" data-route-back role="button">
';
                if ($partial = $this->mustache->loadPartial('core_message/message_drawer_icon_back')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                $buffer .= $indent . '        </a>
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
