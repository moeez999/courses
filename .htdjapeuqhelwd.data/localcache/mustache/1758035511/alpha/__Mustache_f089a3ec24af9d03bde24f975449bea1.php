<?php

class __Mustache_f089a3ec24af9d03bde24f975449bea1 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<span class="loading-icon">
';
        $buffer .= $indent . '    <svg class="spinner" viewBox="0 0 50 50" width="30" height="30">
';
        $buffer .= $indent . '        <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
';
        $buffer .= $indent . '    </svg>
';
        $buffer .= $indent . '</span>
';

        return $buffer;
    }
}
