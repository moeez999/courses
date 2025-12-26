<?php

class __Mustache_676d822cc8b86d9acf775fac10f00d37 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="filter pb-2 mb-2" data-filter-for="';
        $value = $this->resolveValue($context->find('name'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '    <div class="filter-header d-flex align-items-start justify-content-between">
';
        $buffer .= $indent . '        <div class="filter-name">
';
        $buffer .= $indent . '            <label class="mb-0">';
        $value = $this->resolveValue($context->find('name'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';

        return $buffer;
    }
}
