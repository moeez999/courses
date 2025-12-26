<?php

class __Mustache_de6c00c6c8736d7ed68aadbb8b407175 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<header id="page-header" class="page-header-content flex-wrap">
';
        $buffer .= $indent . '    ';
        $value = $context->find('contextheader');
        $buffer .= $this->section3af9b2605bda93f5fa3140e97b34f57d($context, $indent, $value);
        $buffer .= '
';
        $value = $context->find('courseheader');
        $buffer .= $this->section938b165a247f9808bf885ad5af85810a($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <div class="ml-auto d-flex">
';
        $buffer .= $indent . '    ';
        $value = $this->resolveValue($context->find('pageheadingbutton'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <div class="header-actions-container ml-md-auto" data-region="header-actions-container">
';
        $value = $context->find('headeractions');
        $buffer .= $this->section5687f3dc8aee5ceccc6b8b2b5ffadb38($context, $indent, $value);
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</header>';

        return $buffer;
    }

    private function section3af9b2605bda93f5fa3140e97b34f57d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{{contextheader}}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('contextheader'), $context);
                $buffer .= ($value === null ? '' : $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section938b165a247f9808bf885ad5af85810a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div id="course-header">{{{courseheader}}}</div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div id="course-header">';
                $value = $this->resolveValue($context->find('courseheader'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5687f3dc8aee5ceccc6b8b2b5ffadb38(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="header-action ml-2">{{{.}}}</div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="header-action ml-2">';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
