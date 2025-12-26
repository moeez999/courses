<?php

class __Mustache_b2cacc39b48450c24996666bc050cb15 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div ';
        $buffer .= ' class="';
        $blockFunction = $context->findInBlock('drawerclasses');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= ' d-print-none not-initialized"';
        $buffer .= ' data-region="fixed-drawer"';
        $buffer .= ' id="';
        $blockFunction = $context->findInBlock('id');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '"';
        $buffer .= ' data-preference="';
        $blockFunction = $context->findInBlock('drawerpreferencename');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '"';
        $buffer .= ' data-state="';
        $blockFunction = $context->findInBlock('drawerstate');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '"';
        $buffer .= ' data-forceopen="';
        $blockFunction = $context->findInBlock('forceopen');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= '0';
        }
        $buffer .= '"';
        $buffer .= ' data-close-on-resize="';
        $blockFunction = $context->findInBlock('drawercloseonresize');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= '0';
        }
        $buffer .= '"';
        $buffer .= '>
';
        $buffer .= $indent . '    <div class="drawerheader mb-4">
';
        $buffer .= $indent . '        <button
';
        $buffer .= $indent . '            class="btn btn-icon btn-danger drawertoggle icon-no-margin"
';
        $buffer .= $indent . '            data-toggler="drawers"
';
        $buffer .= $indent . '            data-action="closedrawer"
';
        $buffer .= $indent . '            data-target="';
        $blockFunction = $context->findInBlock('id');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '"
';
        $buffer .= $indent . '            data-toggle="tooltip"
';
        $buffer .= $indent . '            data-placement="';
        $blockFunction = $context->findInBlock('tooltipplacement');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= 'right';
        }
        $buffer .= '"
';
        $buffer .= $indent . '            title="';
        $blockFunction = $context->findInBlock('closebuttontext');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $value = $context->find('str');
            $buffer .= $this->section36783d1fe3b25f68270791f3280502a0($context, $indent, $value);
        }
        $buffer .= '"
';
        $buffer .= $indent . '        >
';
        $buffer .= $indent . '            <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.25 6.75L6.75 17.25"></path>
';
        $buffer .= $indent . '                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 6.75L17.25 17.25"></path>
';
        $buffer .= $indent . '            </svg>
';
        $buffer .= $indent . '        </button>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="drawercontent drag-container" data-usertour="scroller">
';
        $buffer .= $indent . '        ';
        $blockFunction = $context->findInBlock('drawercontent');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        $value = $context->find('js');
        $buffer .= $this->sectionF45c7f487d853bebb5ecf5e32aebcf32($context, $indent, $value);

        return $buffer;
    }

    private function section36783d1fe3b25f68270791f3280502a0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'closedrawer, core';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'closedrawer, core';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF45c7f487d853bebb5ecf5e32aebcf32(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'theme_alpha/drawers\']);
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . 'require([\'theme_alpha/drawers\']);
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
