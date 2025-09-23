<?php

class __Mustache_444da50affb7728f3420bc9dc9814387 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $value = $context->find('courseindex');
        $buffer .= $this->section85abadddd5d356ef94ce00b982c834ce($context, $indent, $value);

        return $buffer;
    }

    private function sectionAfaaa3dab86fd46a075d917e3ce891f0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'opendrawerindex, core';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'opendrawerindex, core';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section14c724f5a6859d4cc56d9befdffaeac5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'show';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'show';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD8c059d8e564034fcd5a4fcfed7ed8eb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'closecourseindex, core';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'closecourseindex, core';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section85abadddd5d356ef94ce00b982c834ce(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="drawer-toggler drawer-left-toggle open-nav d-print-none">
        <button class="btn icon-no-margin btn-drawer btn-drawer--left" data-toggler="drawers" data-action="toggle" data-target="theme_alpha-drawers-courseindex" data-toggle="tooltip" data-placement="right" title="{{#str}}opendrawerindex, core{{/str}}">
            <span class="sr-only">{{#str}}opendrawerindex, core{{/str}}</span>
            <svg width="16" height="16" stroke-width="2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor">
                <path d="M3 5h8M3 12h13M3 19h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
    </div>

    {{< theme_alpha/drawer-left }}

    {{$id}}theme_alpha-drawers-courseindex{{/id}}
    {{$drawerclasses}}drawer drawer-left drawer-course-left drawer-course-index {{#courseindexopen}}show{{/courseindexopen}}{{/drawerclasses}}
    {{$drawercontent}}
    {{{courseindex}}}
    {{/drawercontent}}
    {{$drawerpreferencename}}drawer-open-index{{/drawerpreferencename}}
    {{$drawerstate}}show-drawer-left{{/drawerstate}}
    {{$tooltipplacement}}left{{/tooltipplacement}}
    {{$closebuttontext}}{{#str}}closecourseindex, core{{/str}}{{/closebuttontext}}

    {{/ theme_alpha/drawer-left}}
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="drawer-toggler drawer-left-toggle open-nav d-print-none">
';
                $buffer .= $indent . '        <button class="btn icon-no-margin btn-drawer btn-drawer--left" data-toggler="drawers" data-action="toggle" data-target="theme_alpha-drawers-courseindex" data-toggle="tooltip" data-placement="right" title="';
                $value = $context->find('str');
                $buffer .= $this->sectionAfaaa3dab86fd46a075d917e3ce891f0($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '            <span class="sr-only">';
                $value = $context->find('str');
                $buffer .= $this->sectionAfaaa3dab86fd46a075d917e3ce891f0($context, $indent, $value);
                $buffer .= '</span>
';
                $buffer .= $indent . '            <svg width="16" height="16" stroke-width="2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor">
';
                $buffer .= $indent . '                <path d="M3 5h8M3 12h13M3 19h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
';
                $buffer .= $indent . '            </svg>
';
                $buffer .= $indent . '        </button>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    ';
                if ($parent = $this->mustache->loadPartial('theme_alpha/drawer-left')) {
                    $context->pushBlockContext(array(
                        'id' => array($this, 'block2da281d539e2f0957dd6a488b890184a'),
                        'drawerclasses' => array($this, 'block2819c39cf7a3d49dfbf6bfe15ea3a6fa'),
                        'drawercontent' => array($this, 'blockBd4ac622af55b0c04bbbc711cb1be0d9'),
                        'drawerpreferencename' => array($this, 'block24fc4cc7410bc884a3b9fba5f26dc7b9'),
                        'drawerstate' => array($this, 'blockBd5099c9b82bf8a4037bbd56bb374a89'),
                        'tooltipplacement' => array($this, 'blockC945de95615645c65d6b2f192042e6ea'),
                        'closebuttontext' => array($this, 'block9ac4e5859f44816b862545bc2c6e6a46'),
                    ));
                    $buffer .= $parent->renderInternal($context, $indent);
                    $context->popBlockContext();
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block2da281d539e2f0957dd6a488b890184a($context)
    {
        $indent = $buffer = '';
        $buffer .= 'theme_alpha-drawers-courseindex';
    
        return $buffer;
    }

    public function block2819c39cf7a3d49dfbf6bfe15ea3a6fa($context)
    {
        $indent = $buffer = '';
        $buffer .= 'drawer drawer-left drawer-course-left drawer-course-index ';
        $value = $context->find('courseindexopen');
        $buffer .= $this->section14c724f5a6859d4cc56d9befdffaeac5($context, $indent, $value);
    
        return $buffer;
    }

    public function blockBd4ac622af55b0c04bbbc711cb1be0d9($context)
    {
        $indent = $buffer = '';
        $buffer .= '    ';
        $value = $this->resolveValue($context->find('courseindex'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
    
        return $buffer;
    }

    public function block24fc4cc7410bc884a3b9fba5f26dc7b9($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . 'drawer-open-index';
    
        return $buffer;
    }

    public function blockBd5099c9b82bf8a4037bbd56bb374a89($context)
    {
        $indent = $buffer = '';
        $buffer .= 'show-drawer-left';
    
        return $buffer;
    }

    public function blockC945de95615645c65d6b2f192042e6ea($context)
    {
        $indent = $buffer = '';
        $buffer .= 'left';
    
        return $buffer;
    }

    public function block9ac4e5859f44816b862545bc2c6e6a46($context)
    {
        $indent = $buffer = '';
        $value = $context->find('str');
        $buffer .= $this->sectionD8c059d8e564034fcd5a4fcfed7ed8eb($context, $indent, $value);
    
        return $buffer;
    }
}
