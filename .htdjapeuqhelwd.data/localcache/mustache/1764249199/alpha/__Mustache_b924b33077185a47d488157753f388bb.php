<?php

class __Mustache_b924b33077185a47d488157753f388bb extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="hidden view-search row no-gutters justify-content-between align-items-center w-100" ';
        $value = $context->find('isdrawer');
        if (empty($value)) {
            
            $buffer .= 'data-in-panel="true"';
        }
        $buffer .= ' aria-hidden="true" data-region="view-search">
';
        $buffer .= $indent . '    <div class="d-flex align-items-center w-100">
';
        $buffer .= $indent . '        <a
';
        $buffer .= $indent . '            class="ml-3 d-flex align-items-center btn-msg"
';
        $buffer .= $indent . '            href="#"
';
        $buffer .= $indent . '            data-route-back
';
        $buffer .= $indent . '            data-action="cancel-search"
';
        $buffer .= $indent . '            role="button"
';
        $buffer .= $indent . '        >
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_icon_back')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </a>
';
        $buffer .= $indent . '        <div class="d-flex align-items-center rui-message-search-wrapper">
';
        $buffer .= $indent . '            <input
';
        $buffer .= $indent . '                type="text"
';
        $buffer .= $indent . '                class="form-control rui-message-search-input my-2 mx-3"
';
        $buffer .= $indent . '                placeholder="';
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '                aria-label="';
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '                data-region="search-input"
';
        $buffer .= $indent . '            >
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                <button
';
        $buffer .= $indent . '                    class="rui-message-search-input-btn"
';
        $buffer .= $indent . '                    type="button"
';
        $buffer .= $indent . '                    data-action="search"
';
        $buffer .= $indent . '                    aria-label="';
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '                >
';
        $buffer .= $indent . '                    <span data-region="search-icon-container">
';
        $buffer .= $indent . '                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.75 6.75L19.25 12L13.75 17.25"></path>
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 12H4.75"></path>
';
        $buffer .= $indent . '                        </svg>
';
        $buffer .= $indent . '                    </span>
';
        $buffer .= $indent . '                    <span class="hidden" data-region="loading-icon-container">
';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context, $indent . '                        ');
        }
        $buffer .= $indent . '                    </span>
';
        $buffer .= $indent . '                </button>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

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
