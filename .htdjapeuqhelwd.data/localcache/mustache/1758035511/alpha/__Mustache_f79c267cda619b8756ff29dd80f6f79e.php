<?php

class __Mustache_f79c267cda619b8756ff29dd80f6f79e extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="rui-messageselected d-flex align-items-center justify-content-between my-3 mx-3 hidden" data-action="confirm-delete-selected-messages">
';
        $buffer .= $indent . '    <div class="badge mr-3">
';
        $buffer .= $indent . '      <span>';
        $value = $context->find('str');
        $buffer .= $this->section90c3e2f09f9135ab908454d2e6d60d5b($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '      <span class="ml-2" data-region="message-selected-court">1</span>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <button type="button" class="btn-msg" aria-label="';
        $value = $context->find('str');
        $buffer .= $this->section9a2ea9d448b950c6ba5068f1d0ea6171($context, $indent, $value);
        $buffer .= '" data-action="cancel-edit-mode">
';
        $buffer .= $indent . '        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.25 6.75L6.75 17.25"></path>
';
        $buffer .= $indent . '            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 6.75L17.25 17.25"></path>
';
        $buffer .= $indent . '        </svg>
';
        $buffer .= $indent . '    </button>
';
        $buffer .= $indent . '</div>';

        return $buffer;
    }

    private function section90c3e2f09f9135ab908454d2e6d60d5b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' messagesselected:, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' messagesselected:, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9a2ea9d448b950c6ba5068f1d0ea6171(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' cancelselection, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' cancelselection, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
