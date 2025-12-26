<?php

class __Mustache_72b0a0067bef5d17933ae4adb9378696 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="form-file defaultsnext">
';
        $buffer .= $indent . '    <div class="form-inline">
';
        $buffer .= $indent . '        <input type="text" name="';
        $value = $this->resolveValue($context->find('name'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" id="';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" size="';
        $value = $this->resolveValue($context->find('size'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" value="';
        $value = $this->resolveValue($context->find('value'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" class="form-control text-ltr" ';
        $value = $context->find('readonly');
        $buffer .= $this->sectionBd6d241829fcbe59e01506b6f6c8d128($context, $indent, $value);
        $buffer .= '>
';
        $value = $context->find('showvalidity');
        $buffer .= $this->section8a58542ecb1bc3fbc051c1ec819c6520($context, $indent, $value);
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';

        return $buffer;
    }

    private function sectionBd6d241829fcbe59e01506b6f6c8d128(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'readonly';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'readonly';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFeb46fc6b1c9c293af864b6f9f935fd2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <span class="text-success mr-2">&#x2714;</span>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <span class="text-success mr-2">&#x2714;</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8a58542ecb1bc3fbc051c1ec819c6520(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#valid}}
                <span class="text-success mr-2">&#x2714;</span>
            {{/valid}}
            {{^valid}}
                <span class="text-danger mr-2">&#x2718;</span>
            {{/valid}}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('valid');
                $buffer .= $this->sectionFeb46fc6b1c9c293af864b6f9f935fd2($context, $indent, $value);
                $value = $context->find('valid');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                <span class="text-danger mr-2">&#x2718;</span>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
