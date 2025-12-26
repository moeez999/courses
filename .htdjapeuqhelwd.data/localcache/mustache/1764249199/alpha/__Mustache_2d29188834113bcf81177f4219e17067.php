<?php

class __Mustache_2d29188834113bcf81177f4219e17067 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('collapseable');
        $buffer .= $this->section44895750f7e02fd3d8458c2ac8274d4d($context, $indent, $value);
        $value = $context->find('collapseable');
        if (empty($value)) {
            
            $buffer .= $indent . '    <legend>';
            $value = $this->resolveValue($context->find('header'), $context);
            $buffer .= ($value === null ? '' : $value);
            $buffer .= '</legend>
';
        }
        $buffer .= $indent . '<div id="';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= 'container" class="fcontainer ';
        $value = $context->find('collapseable');
        $buffer .= $this->sectionFf0fe0910fea799e597d74360fc85a68($context, $indent, $value);
        $buffer .= ' ';
        $value = $context->find('collapsed');
        if (empty($value)) {
            
            $buffer .= 'show';
        }
        $buffer .= '">
';

        return $buffer;
    }

    private function section3d743337d1ee557b470226701b73da47(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'false';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'false';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7df0e231697f3a9dfdd1138e1b79a2b0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'collapsed';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'collapsed';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section44895750f7e02fd3d8458c2ac8274d4d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <legend class="d-flex align-items-center">
        <div class="position-relative d-flex ftoggler align-items-center w-100">
            <a data-toggle="collapse"
                href="#{{id}}container"
                role="button"
                aria-expanded="{{#collapsed}}false{{/collapsed}}{{^collapsed}}true{{/collapsed}}"
                aria-controls="{{id}}container"
                class="fheader {{#collapsed}}collapsed{{/collapsed}}"
                >            
                <h3 class="d-flex align-self-stretch align-items-center mb-0" aria-hidden="true">
                    {{{header}}}
                </h3>
            </a>
            {{{helpbutton}}}
        </div>
        
    </legend>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <legend class="d-flex align-items-center">
';
                $buffer .= $indent . '        <div class="position-relative d-flex ftoggler align-items-center w-100">
';
                $buffer .= $indent . '            <a data-toggle="collapse"
';
                $buffer .= $indent . '                href="#';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= 'container"
';
                $buffer .= $indent . '                role="button"
';
                $buffer .= $indent . '                aria-expanded="';
                $value = $context->find('collapsed');
                $buffer .= $this->section3d743337d1ee557b470226701b73da47($context, $indent, $value);
                $value = $context->find('collapsed');
                if (empty($value)) {
                    
                    $buffer .= 'true';
                }
                $buffer .= '"
';
                $buffer .= $indent . '                aria-controls="';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= 'container"
';
                $buffer .= $indent . '                class="fheader ';
                $value = $context->find('collapsed');
                $buffer .= $this->section7df0e231697f3a9dfdd1138e1b79a2b0($context, $indent, $value);
                $buffer .= '"
';
                $buffer .= $indent . '                >            
';
                $buffer .= $indent . '                <h3 class="d-flex align-self-stretch align-items-center mb-0" aria-hidden="true">
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('header'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '                </h3>
';
                $buffer .= $indent . '            </a>
';
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->find('helpbutton'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '        
';
                $buffer .= $indent . '    </legend>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFf0fe0910fea799e597d74360fc85a68(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'collapseable collapse ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'collapseable collapse ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
