<?php

class __Mustache_495c41b11efa9b7f59860a87e2076c7a extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $value = $context->find('showemojipicker');
        $buffer .= $this->sectionC9b996e0a4599b420525395cfcc61422($context, $indent, $value);
        $buffer .= $indent . '<div class="mt-1 row no-gutters">
';
        $buffer .= $indent . '    <textarea
';
        $buffer .= $indent . '        dir="auto"
';
        $buffer .= $indent . '        data-region="send-message-txt"
';
        $buffer .= $indent . '        class="rui-textarea form-control w-100 mx-0 mb-2"
';
        $buffer .= $indent . '        rows="4"
';
        $buffer .= $indent . '        data-auto-rows
';
        $buffer .= $indent . '        data-min-rows="4"
';
        $buffer .= $indent . '        data-max-rows="5"
';
        $buffer .= $indent . '        aria-label="';
        $value = $context->find('str');
        $buffer .= $this->section2244054c2b8c2f0af84a759e802290d0($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '        placeholder="';
        $value = $context->find('str');
        $buffer .= $this->section2244054c2b8c2f0af84a759e802290d0($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '        style="resize: none"
';
        $buffer .= $indent . '        maxlength="';
        $value = $this->resolveValue($context->find('messagemaxlength'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    ></textarea>
';
        $buffer .= $indent . '    <button
';
        $buffer .= $indent . '        class="btn btn-primary mt-1 ';
        $value = $context->find('showemojipicker');
        $buffer .= $this->section09ad747c796dbbff345fbbe5ed79ed3c($context, $indent, $value);
        $buffer .= ' ';
        $value = $context->find('showemojipicker');
        if (empty($value)) {
            
            $buffer .= 'w-100';
        }
        $buffer .= '"
';
        $buffer .= $indent . '        aria-label="';
        $value = $context->find('str');
        $buffer .= $this->sectionAb824786c8682f6171ef8d2596f84a5d($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '        data-action="send-message"
';
        $buffer .= $indent . '    >
';
        $buffer .= $indent . '        <span data-region="send-icon-container">
';
        $buffer .= $indent . '            <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.25 15.25V6.75H8.75"></path>
';
        $buffer .= $indent . '                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7L6.75 17.25"></path>
';
        $buffer .= $indent . '            </svg>
';
        $buffer .= $indent . '        </span>
';
        $buffer .= $indent . '        <span class="hidden" data-region="loading-icon-container">';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= '</span>
';
        $buffer .= $indent . '    </button>
';
        $buffer .= $indent . '
';
        $value = $context->find('showemojipicker');
        $buffer .= $this->section949cfebdd1a9e74bb00e171babb6b7cb($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function sectionC9b996e0a4599b420525395cfcc61422(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div
        class="d-block emoji-auto-complete-container w-100 hidden"
        data-region="emoji-auto-complete-container"
        aria-live="polite"
        aria-hidden="true"
    >
    </div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div
';
                $buffer .= $indent . '        class="d-block emoji-auto-complete-container w-100 hidden"
';
                $buffer .= $indent . '        data-region="emoji-auto-complete-container"
';
                $buffer .= $indent . '        aria-live="polite"
';
                $buffer .= $indent . '        aria-hidden="true"
';
                $buffer .= $indent . '    >
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2244054c2b8c2f0af84a759e802290d0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' writeamessage, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' writeamessage, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section09ad747c796dbbff345fbbe5ed79ed3c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'col mr-2';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'col mr-2';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAb824786c8682f6171ef8d2596f84a5d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' sendmessage, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' sendmessage, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5df971d582457358a4ccf481abd0509f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' toggleemojipicker, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' toggleemojipicker, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section949cfebdd1a9e74bb00e171babb6b7cb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div
            data-region="emoji-picker-container"
            class="w-100 emoji-picker-container hidden"
            aria-hidden="true"
        >
            {{> core/emoji/picker }}
        </div>
        <button
            class="btn btn-secondary mt-1"
            aria-label="{{#str}} toggleemojipicker, core {{/str}}"
            data-action="toggle-emoji-picker"
        >
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19.25 12C19.25 16.0041 16.0041 19.25 12 19.25C7.99594 19.25 4.75 16.0041 4.75 12C4.75 7.99594 7.99594 4.75 12 4.75C16.0041 4.75 19.25 7.99594 19.25 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M9.75 13.75C9.75 13.75 10 15.25 12 15.25C14 15.25 14.25 13.75 14.25 13.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M10.5 10C10.5 10.2761 10.2761 10.5 10 10.5C9.72386 10.5 9.5 10.2761 9.5 10C9.5 9.72386 9.72386 9.5 10 9.5C10.2761 9.5 10.5 9.72386 10.5 10Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M14.5 10C14.5 10.2761 14.2761 10.5 14 10.5C13.7239 10.5 13.5 10.2761 13.5 10C13.5 9.72386 13.7239 9.5 14 9.5C14.2761 9.5 14.5 9.72386 14.5 10Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div
';
                $buffer .= $indent . '            data-region="emoji-picker-container"
';
                $buffer .= $indent . '            class="w-100 emoji-picker-container hidden"
';
                $buffer .= $indent . '            aria-hidden="true"
';
                $buffer .= $indent . '        >
';
                if ($partial = $this->mustache->loadPartial('core/emoji/picker')) {
                    $buffer .= $partial->renderInternal($context, $indent . '            ');
                }
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '        <button
';
                $buffer .= $indent . '            class="btn btn-secondary mt-1"
';
                $buffer .= $indent . '            aria-label="';
                $value = $context->find('str');
                $buffer .= $this->section5df971d582457358a4ccf481abd0509f($context, $indent, $value);
                $buffer .= '"
';
                $buffer .= $indent . '            data-action="toggle-emoji-picker"
';
                $buffer .= $indent . '        >
';
                $buffer .= $indent . '            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
';
                $buffer .= $indent . '                <path d="M19.25 12C19.25 16.0041 16.0041 19.25 12 19.25C7.99594 19.25 4.75 16.0041 4.75 12C4.75 7.99594 7.99594 4.75 12 4.75C16.0041 4.75 19.25 7.99594 19.25 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
';
                $buffer .= $indent . '                <path d="M9.75 13.75C9.75 13.75 10 15.25 12 15.25C14 15.25 14.25 13.75 14.25 13.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
';
                $buffer .= $indent . '                <path d="M10.5 10C10.5 10.2761 10.2761 10.5 10 10.5C9.72386 10.5 9.5 10.2761 9.5 10C9.5 9.72386 9.72386 9.5 10 9.5C10.2761 9.5 10.5 9.72386 10.5 10Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
';
                $buffer .= $indent . '                <path d="M14.5 10C14.5 10.2761 14.2761 10.5 14 10.5C13.7239 10.5 13.5 10.2761 13.5 10C13.5 9.72386 13.7239 9.5 14 9.5C14.2761 9.5 14.5 9.72386 14.5 10Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
';
                $buffer .= $indent . '            </svg>
';
                $buffer .= $indent . '        </button>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
