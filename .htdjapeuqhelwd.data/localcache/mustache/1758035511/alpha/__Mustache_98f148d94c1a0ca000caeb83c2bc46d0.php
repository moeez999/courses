<?php

class __Mustache_98f148d94c1a0ca000caeb83c2bc46d0 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        if ($parent = $this->mustache->loadPartial('core_message/message_drawer_view_overview_section')) {
            $context->pushBlockContext(array(
                'region' => array($this, 'block0d825094e3f87721e5aeacfebed18011'),
                'title' => array($this, 'block7c6b10869971ce2668cb1eac51f5feb2'),
                'placeholder' => array($this, 'blockE9b23ea6ffe7cff2e099ad2c26b6072a'),
                'notification' => array($this, 'block6c94626ea2fa67f542062f0b1b7d1d8b'),
                'emptymessage' => array($this, 'block77db6bd4bedc6d88cd993e6d9d6d57b6'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }

        return $buffer;
    }

    private function sectionF36d9c53138ae56f420c83046248fd3c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' individualconversations, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' individualconversations, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2aa1d110403ad6a595948cdd11dfef60(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="text-center p-2">
                <p class="text-center small">{{.}}</p>
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="text-center p-2">
';
                $buffer .= $indent . '                <p class="text-center small">';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</p>
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section088ffe8d586f44aaabcd5c09cc823693(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' noindividualconversations, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' noindividualconversations, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block0d825094e3f87721e5aeacfebed18011($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . 'view-overview-messages';
    
        return $buffer;
    }

    public function block7c6b10869971ce2668cb1eac51f5feb2($context)
    {
        $indent = $buffer = '';
        $value = $context->find('str');
        $buffer .= $this->sectionF36d9c53138ae56f420c83046248fd3c($context, $indent, $value);
    
        return $buffer;
    }

    public function blockE9b23ea6ffe7cff2e099ad2c26b6072a($context)
    {
        $indent = $buffer = '';
        $buffer .= '        <div class="text-center py-2">';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= '</div>
';
    
        return $buffer;
    }

    public function block6c94626ea2fa67f542062f0b1b7d1d8b($context)
    {
        $indent = $buffer = '';
        $value = $context->findDot('overview.notification');
        $buffer .= $this->section2aa1d110403ad6a595948cdd11dfef60($context, $indent, $value);
    
        return $buffer;
    }

    public function block77db6bd4bedc6d88cd993e6d9d6d57b6($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '        <p>';
        $value = $context->find('str');
        $buffer .= $this->section088ffe8d586f44aaabcd5c09cc823693($context, $indent, $value);
        $buffer .= '</p>
';
    
        return $buffer;
    }
}
