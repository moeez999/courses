<?php

class __Mustache_eca47177eed5ff167e4e609101ececf7 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="alert alert-warning alert-block fade in ';
        $value = $this->resolveValue($context->find('extraclasses'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= ' ';
        $value = $context->find('closebutton');
        $buffer .= $this->section9a45551939d86d0dd69a8848155bac9b($context, $indent, $value);
        $buffer .= '" ';
        $value = $context->find('announce');
        $buffer .= $this->section9475860da7a90ce0c1cbee01b0f651f9($context, $indent, $value);
        $buffer .= '>
';
        $buffer .= $indent . '    ';
        $value = $this->resolveValue($context->find('message'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '    ';
        $value = $context->find('closebutton');
        $buffer .= $this->section828da0348907df74d4c84264c95baeb2($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section9a45551939d86d0dd69a8848155bac9b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'alert--close';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'alert--close';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9475860da7a90ce0c1cbee01b0f651f9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' role="alert" data-aria-autofocus="true"';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' role="alert" data-aria-autofocus="true"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section62fce6eb1e22a38c9f1bd33645ed3cc6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'dismissnotification, core';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'dismissnotification, core';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section828da0348907df74d4c84264c95baeb2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{!
    }}<button type="button" class="close" data-dismiss="alert">
        <span class="sr-only">{{#str}}dismissnotification, core{{/str}}</span>
    </button>{{!
    }}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<button type="button" class="close" data-dismiss="alert">
';
                $buffer .= $indent . '        <span class="sr-only">';
                $value = $context->find('str');
                $buffer .= $this->section62fce6eb1e22a38c9f1bd33645ed3cc6($context, $indent, $value);
                $buffer .= '</span>
';
                $buffer .= $indent . '    </button>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
