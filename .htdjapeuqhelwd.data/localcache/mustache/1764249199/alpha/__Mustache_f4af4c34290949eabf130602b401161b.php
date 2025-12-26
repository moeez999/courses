<?php

class __Mustache_f4af4c34290949eabf130602b401161b extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($parent = $this->mustache->loadPartial('core_form/element-template')) {
            $context->pushBlockContext(array(
                'element' => array($this, 'block65344f25adeccc6b11c43683ba445d45'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }

        return $buffer;
    }


    public function block65344f25adeccc6b11c43683ba445d45($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '        <div class="form-control-static">';
        $value = $this->resolveValue($context->findDot('element.html'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '</div>
';
    
        return $buffer;
    }
}
