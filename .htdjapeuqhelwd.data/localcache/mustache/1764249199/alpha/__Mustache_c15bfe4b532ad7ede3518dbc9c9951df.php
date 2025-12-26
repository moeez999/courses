<?php

class __Mustache_c15bfe4b532ad7ede3518dbc9c9951df extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $value = $context->find('hasnavbar');
        $buffer .= $this->sectionCb544675748c4d67faaca87e564cb60c($context, $indent, $value);

        return $buffer;
    }

    private function sectionCb544675748c4d67faaca87e564cb60c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      <div class="rui-breadcrumbs">
        <div id="page-navbar" class="breadcrumbs-container">
            {{{navbar}}}
        </div>
      </div>
      ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '      <div class="rui-breadcrumbs">
';
                $buffer .= $indent . '        <div id="page-navbar" class="breadcrumbs-container">
';
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->find('navbar'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '      </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
