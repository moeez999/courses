<?php

class __Mustache_0e56d33877246708f0bf54e25d25c06b extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<header id="page-header" class="page-header-content flex-wrap">
';
        $value = $context->find('contextheader');
        $buffer .= $this->section6b37c3b059a1e4badca1891a0a1eca1b($context, $indent, $value);
        $buffer .= $indent . '  ';
        $value = $context->find('pageheading');
        $buffer .= $this->section02176c8ee7d3096fec933193d77df943($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '  <div class="d-flex flex-wrap">
';
        $buffer .= $indent . '      <div class="ml-auto d-flex">
';
        $buffer .= $indent . '          ';
        $value = $this->resolveValue($context->find('pageheadingbutton'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="header-actions-container ml-auto" data-region="header-actions-container">
';
        $value = $context->find('headeractions');
        $buffer .= $this->sectionC2f72bce215ee1bf673a79351b04e845($context, $indent, $value);
        $buffer .= $indent . '      </div>
';
        $buffer .= $indent . '      <div id="course-header">
';
        $buffer .= $indent . '          ';
        $value = $this->resolveValue($context->find('courseheader'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '      </div>
';
        $buffer .= $indent . '  </div>
';
        if ($partial = $this->mustache->loadPartial('core/welcome')) {
            $buffer .= $partial->renderInternal($context, $indent . '  ');
        }
        $buffer .= $indent . '</header>
';

        return $buffer;
    }

    private function section6b37c3b059a1e4badca1891a0a1eca1b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{{.}}}
  ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    ';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section02176c8ee7d3096fec933193d77df943(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<h3 class="page-sub-title">{{{pageheading}}}</h3>';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<h3 class="page-sub-title">';
                $value = $this->resolveValue($context->find('pageheading'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</h3>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC2f72bce215ee1bf673a79351b04e845(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="header-action">{{{.}}}</div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="header-action">';
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
