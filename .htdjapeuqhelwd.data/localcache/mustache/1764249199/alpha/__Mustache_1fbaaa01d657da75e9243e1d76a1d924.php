<?php

class __Mustache_1fbaaa01d657da75e9243e1d76a1d924 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="fdescription form-filetypes-descriptions w-100">
';
        $value = $context->find('hasdescriptions');
        $buffer .= $this->section57c448303fab2359bb920afec4254201($context, $indent, $value);
        $value = $context->find('hasdescriptions');
        if (empty($value)) {
            
            $buffer .= $indent . '    <p>';
            $value = $context->find('str');
            $buffer .= $this->section30129dc0794ae04b28e7bc4b7f11d4d6($context, $indent, $value);
            $buffer .= '</p>
';
        }
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section47c9b08fbb218a3d5936bafa86c8305f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <li>{{description}} <small class="text-muted muted">{{extensions}}</small></li>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <li>';
                $value = $this->resolveValue($context->find('description'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' <small class="text-muted muted">';
                $value = $this->resolveValue($context->find('extensions'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</small></li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section57c448303fab2359bb920afec4254201(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <ul class="list-unstyled unstyled">
        {{#descriptions}}
        <li>{{description}} <small class="text-muted muted">{{extensions}}</small></li>
        {{/descriptions}}
    </ul>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <ul class="list-unstyled unstyled">
';
                $value = $context->find('descriptions');
                $buffer .= $this->section47c9b08fbb218a3d5936bafa86c8305f($context, $indent, $value);
                $buffer .= $indent . '    </ul>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section30129dc0794ae04b28e7bc4b7f11d4d6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'noselection, form';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'noselection, form';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
