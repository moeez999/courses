<?php

class __Mustache_02770b00865b916dfb5bedf3b71bb7a2 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '    <p class="text-center mb-2" data-region="text">';
        $value = $context->find('str');
        $buffer .= $this->section89a32bc0a45ac29a661c18d10215849e($context, $indent, $value);
        $buffer .= '</p>
';
        $buffer .= $indent . '    <button type="button" class="btn btn-dark btn-block mb-2" data-action="request-unblock">
';
        $buffer .= $indent . '        <svg class="mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.25 12C19.25 13 17.5 18.25 12 18.25C6.5 18.25 4.75 13 4.75 12C4.75 11 6.5 5.75 12 5.75C17.5 5.75 19.25 11 19.25 12Z"></path>
';
        $buffer .= $indent . '            <circle cx="12" cy="12" r="2.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></circle>
';
        $buffer .= $indent . '        </svg>
';
        $buffer .= $indent . '        <span data-region="dialogue-button-text">';
        $value = $context->find('str');
        $buffer .= $this->section800b515fafac96516c4b3273c607fadc($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '        <span class="hidden" data-region="loading-icon-container">';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= '</span>
';
        $buffer .= $indent . '    </button>
';

        return $buffer;
    }

    private function section89a32bc0a45ac29a661c18d10215849e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' youhaveblockeduser, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' youhaveblockeduser, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section800b515fafac96516c4b3273c607fadc(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' unblockuser, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' unblockuser, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
