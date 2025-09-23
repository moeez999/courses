<?php

class __Mustache_a16d4b65848ba159eb2e3681d92b7690 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="d-flex justify-content-end">
';
        $buffer .= $indent . '    <button
';
        $buffer .= $indent . '        class="btn btn-danger w-100"
';
        $buffer .= $indent . '        data-action="delete-selected-messages"
';
        $buffer .= $indent . '        data-toggle="tooltip"
';
        $buffer .= $indent . '        data-placement="top"
';
        $buffer .= $indent . '        title="';
        $value = $context->find('str');
        $buffer .= $this->section6910e05b9a1417486b5764734b1a6842($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '    >
';
        $buffer .= $indent . '        <svg class="mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 7.75L7.59115 17.4233C7.68102 18.4568 8.54622 19.25 9.58363 19.25H14.4164C15.4538 19.25 16.319 18.4568 16.4088 17.4233L17.25 7.75"></path>
';
        $buffer .= $indent . '            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 7.5V6.75C9.75 5.64543 10.6454 4.75 11.75 4.75H12.25C13.3546 4.75 14.25 5.64543 14.25 6.75V7.5"></path>
';
        $buffer .= $indent . '            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 7.75H19"></path>
';
        $buffer .= $indent . '        </svg>
';
        $buffer .= $indent . '        <span class="hidden" data-region="loading-icon-container">';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= '</span>
';
        $buffer .= $indent . '        <span class="sr-only">';
        $value = $context->find('str');
        $buffer .= $this->section6910e05b9a1417486b5764734b1a6842($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '    </button>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section6910e05b9a1417486b5764734b1a6842(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' deleteselectedmessages, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' deleteselectedmessages, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
