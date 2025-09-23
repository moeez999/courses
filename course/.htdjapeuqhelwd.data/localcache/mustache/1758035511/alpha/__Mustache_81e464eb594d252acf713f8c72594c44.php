<?php

class __Mustache_81e464eb594d252acf713f8c72594c44 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('hasblocks');
        $buffer .= $this->section05096309dc626874a794273e4450fa99($context, $indent, $value);

        return $buffer;
    }

    private function section245ba37b5a58f162a63e0d10700eb739(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'opendrawerblocks, core';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'opendrawerblocks, core';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1cb47d3ed9b97c6d6d496d2358bec253(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' show';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' show';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC14df02445cdd505a0208e8a56a5f32e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'blocks';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'blocks';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1bd0cc4642e36d67e46c9dd550f1fa06(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '1';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '1';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section31618380a8d2d407a8b2acf35dd449a4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'closeblockdrawer, core';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'closeblockdrawer, core';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section05096309dc626874a794273e4450fa99(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div id="drawerTogglerRight" class="drawer-toggler drawer-right-toggle ml-auto d-print-none">
        <button class="btn icon-no-margin" data-toggler="drawers" data-action="toggle" data-target="theme_alpha-drawers-blocks" data-toggle="tooltip" data-placement="right" title="{{#str}}opendrawerblocks, core{{/str}}">
            <span class="sr-only">{{#str}}opendrawerblocks, core{{/str}}</span>
            <span>
                <svg width="20" height="20" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor">
                    <path d="M22 18V6a3 3 0 00-3-3h-2a3 3 0 00-3 3v12a3 3 0 003 3h2a3 3 0 003-3z" stroke="currentColor" stroke-width="2" stroke-opacity="0.4"></path>
                    <path d="M8 3H6a4 4 0 00-4 4v10a4 4 0 004 4h2M14 12H6m0 0l3-3m-3 3l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
        </button>
    </div>
    {{< theme_alpha/drawer }}
    {{$id}}theme_alpha-drawers-blocks{{/id}}
    {{$drawerclasses}}drawer drawer-right rui-right-drawer{{#blockdraweropen}} show{{/blockdraweropen}}{{/drawerclasses}}
    {{$drawercontent}}
    <section class="d-print-none" aria-label="{{#str}}blocks{{/str}}">
        {{{ addblockbutton }}}
        {{{ sidepreblocks }}}
    </section>
    {{/drawercontent}}
    {{$drawerpreferencename}}drawer-open-block{{/drawerpreferencename}}
    {{$forceopen}}{{#forceblockdraweropen}}1{{/forceblockdraweropen}}{{/forceopen}}
    {{$drawerstate}}show-drawer-right{{/drawerstate}}
    {{$tooltipplacement}}left{{/tooltipplacement}}
    {{$drawercloseonresize}}1{{/drawercloseonresize}}
    {{$closebuttontext}}{{#str}}closeblockdrawer, core{{/str}}{{/closebuttontext}}
    {{/ theme_alpha/drawer}}
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div id="drawerTogglerRight" class="drawer-toggler drawer-right-toggle ml-auto d-print-none">
';
                $buffer .= $indent . '        <button class="btn icon-no-margin" data-toggler="drawers" data-action="toggle" data-target="theme_alpha-drawers-blocks" data-toggle="tooltip" data-placement="right" title="';
                $value = $context->find('str');
                $buffer .= $this->section245ba37b5a58f162a63e0d10700eb739($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '            <span class="sr-only">';
                $value = $context->find('str');
                $buffer .= $this->section245ba37b5a58f162a63e0d10700eb739($context, $indent, $value);
                $buffer .= '</span>
';
                $buffer .= $indent . '            <span>
';
                $buffer .= $indent . '                <svg width="20" height="20" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor">
';
                $buffer .= $indent . '                    <path d="M22 18V6a3 3 0 00-3-3h-2a3 3 0 00-3 3v12a3 3 0 003 3h2a3 3 0 003-3z" stroke="currentColor" stroke-width="2" stroke-opacity="0.4"></path>
';
                $buffer .= $indent . '                    <path d="M8 3H6a4 4 0 00-4 4v10a4 4 0 004 4h2M14 12H6m0 0l3-3m-3 3l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
';
                $buffer .= $indent . '                </svg>
';
                $buffer .= $indent . '            </span>
';
                $buffer .= $indent . '        </button>
';
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '    ';
                if ($parent = $this->mustache->loadPartial('theme_alpha/drawer')) {
                    $context->pushBlockContext(array(
                        'id' => array($this, 'blockB90e42bbf67ac5c2ad7b7ce3f7b51469'),
                        'drawerclasses' => array($this, 'blockAab616a7ad3bc963c9c8af4edc817ba8'),
                        'drawercontent' => array($this, 'block66d65e25fb753137130038e2eb5f751b'),
                        'drawerpreferencename' => array($this, 'block59146569a56c3d2642fa2e8224817be0'),
                        'forceopen' => array($this, 'block13847ba3219919ecdb2378620735177c'),
                        'drawerstate' => array($this, 'block0ea572ae0e89f9c5cc1dc5d7238a50d5'),
                        'tooltipplacement' => array($this, 'blockC945de95615645c65d6b2f192042e6ea'),
                        'drawercloseonresize' => array($this, 'blockE052079a625ca42b568ba24af19cc7eb'),
                        'closebuttontext' => array($this, 'blockC879444321d250421c3438099ae68173'),
                    ));
                    $buffer .= $parent->renderInternal($context, $indent);
                    $context->popBlockContext();
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function blockB90e42bbf67ac5c2ad7b7ce3f7b51469($context)
    {
        $indent = $buffer = '';
        $buffer .= 'theme_alpha-drawers-blocks';
    
        return $buffer;
    }

    public function blockAab616a7ad3bc963c9c8af4edc817ba8($context)
    {
        $indent = $buffer = '';
        $buffer .= 'drawer drawer-right rui-right-drawer';
        $value = $context->find('blockdraweropen');
        $buffer .= $this->section1cb47d3ed9b97c6d6d496d2358bec253($context, $indent, $value);
    
        return $buffer;
    }

    public function block66d65e25fb753137130038e2eb5f751b($context)
    {
        $indent = $buffer = '';
        $buffer .= '    <section class="d-print-none" aria-label="';
        $value = $context->find('str');
        $buffer .= $this->sectionC14df02445cdd505a0208e8a56a5f32e($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('addblockbutton'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('sidepreblocks'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '    </section>
';
    
        return $buffer;
    }

    public function block59146569a56c3d2642fa2e8224817be0($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . 'drawer-open-block';
    
        return $buffer;
    }

    public function block13847ba3219919ecdb2378620735177c($context)
    {
        $indent = $buffer = '';
        $value = $context->find('forceblockdraweropen');
        $buffer .= $this->section1bd0cc4642e36d67e46c9dd550f1fa06($context, $indent, $value);
    
        return $buffer;
    }

    public function block0ea572ae0e89f9c5cc1dc5d7238a50d5($context)
    {
        $indent = $buffer = '';
        $buffer .= 'show-drawer-right';
    
        return $buffer;
    }

    public function blockC945de95615645c65d6b2f192042e6ea($context)
    {
        $indent = $buffer = '';
        $buffer .= 'left';
    
        return $buffer;
    }

    public function blockE052079a625ca42b568ba24af19cc7eb($context)
    {
        $indent = $buffer = '';
        $buffer .= '1';
    
        return $buffer;
    }

    public function blockC879444321d250421c3438099ae68173($context)
    {
        $indent = $buffer = '';
        $value = $context->find('str');
        $buffer .= $this->section31618380a8d2d407a8b2acf35dd449a4($context, $indent, $value);
    
        return $buffer;
    }
}
