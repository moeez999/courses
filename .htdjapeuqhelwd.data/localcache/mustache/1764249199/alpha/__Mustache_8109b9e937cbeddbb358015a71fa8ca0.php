<?php

class __Mustache_8109b9e937cbeddbb358015a71fa8ca0 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="rui-setting-heading-wrapper ';
        $value = $context->find('description');
        $buffer .= $this->section9e4d3460d4da6be1c00cd4984eb15f06($context, $indent, $value);
        $buffer .= ' ">
';
        $value = $context->find('title');
        $buffer .= $this->sectionA2b5b53391af941b7515f326e3362edf($context, $indent, $value);
        $value = $context->find('description');
        $buffer .= $this->section0a3f1a9b0ce75ff82aee55b0bccdcbcf($context, $indent, $value);
        $buffer .= $indent . '</div>';

        return $buffer;
    }

    private function section9e4d3460d4da6be1c00cd4984eb15f06(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-setting-heading--desc';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-setting-heading--desc';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA2b5b53391af941b7515f326e3362edf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <h4 class="rui-setting-heading mb-1">{{{title}}}</h4>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <h4 class="rui-setting-heading mb-1">';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</h4>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0a3f1a9b0ce75ff82aee55b0bccdcbcf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="rui-setting-desc">{{{descriptionformatted}}}</div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="rui-setting-desc">';
                $value = $this->resolveValue($context->find('descriptionformatted'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
