<?php

class __Mustache_4cdccad534cce9c8b356757961ef93f9 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="popover-region collapsed" data-region="popover-region-messages">
';
        $buffer .= $indent . '    <a id="message-drawer-toggle-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" class="rui-topbar-special-btn" href="#" role="button" aria-label="';
        $value = $context->find('str');
        $buffer .= $this->section7e98df9a875ae7452f53a15048ab9749($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '            <svg width="18" height="18" stroke-width="2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor"><path d="M8 10h8M8 14h4M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12c0 1.821.487 3.53 1.338 5L2.5 21.5l4.5-.838A9.955 9.955 0 0012 22z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
';
        $buffer .= $indent . '            <span class="';
        $value = $context->find('unreadcount');
        if (empty($value)) {
            
            $buffer .= 'hidden';
        }
        $buffer .= ' rui-unreadcount" arial-label="';
        $value = $this->resolveValue($context->find('unreadcount'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" data-region="count-container">';
        $value = $this->resolveValue($context->find('unreadcount'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '</span>
';
        $buffer .= $indent . '    </a>
';
        if ($partial = $this->mustache->loadPartial('core_message/message_jumpto')) {
            $buffer .= $partial->renderInternal($context, $indent . '    ');
        }
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';
        $value = $context->find('js');
        $buffer .= $this->section9cfc2f7c40dd8d474c4175bc8276b8fb($context, $indent, $value);

        return $buffer;
    }

    private function section7e98df9a875ae7452f53a15048ab9749(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'messages, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'messages, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9cfc2f7c40dd8d474c4175bc8276b8fb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require(
[
    \'jquery\',
    \'core_message/message_popover\'
],
function(
    $,
    Popover
) {
    var toggle = $(\'#message-drawer-toggle-{{uniqid}}, .message-drawer-toggle, .message-drawer-backdrop\');
    Popover.init(toggle);
});
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . 'require(
';
                $buffer .= $indent . '[
';
                $buffer .= $indent . '    \'jquery\',
';
                $buffer .= $indent . '    \'core_message/message_popover\'
';
                $buffer .= $indent . '],
';
                $buffer .= $indent . 'function(
';
                $buffer .= $indent . '    $,
';
                $buffer .= $indent . '    Popover
';
                $buffer .= $indent . ') {
';
                $buffer .= $indent . '    var toggle = $(\'#message-drawer-toggle-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ', .message-drawer-toggle, .message-drawer-backdrop\');
';
                $buffer .= $indent . '    Popover.init(toggle);
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
