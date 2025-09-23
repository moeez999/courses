<?php

class __Mustache_d50a8459f74b6a8b6043a06dffe20c80 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="form-group ';
        $value = $context->find('error');
        $buffer .= $this->section4d4b829e8a762a460d7710f0a2273a46($context, $indent, $value);
        $buffer .= ' fitem ';
        $value = $context->find('advanced');
        $buffer .= $this->sectionB2a3879159edb3a7a33a1d8394a2c556($context, $indent, $value);
        $buffer .= ' ';
        $value = $this->resolveValue($context->findDot('element.extraclasses'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '" ';
        $value = $context->findDot('element.groupname');
        $buffer .= $this->sectionE32dd8819580c2040e2441120199ff04($context, $indent, $value);
        $buffer .= '>
';
        $buffer .= $indent . '    <label class="col-form-label ';
        $value = $context->findDot('element.hiddenlabel');
        $buffer .= $this->sectionBd3e0eae730f027ebaa2c5d8144fd11d($context, $indent, $value);
        $buffer .= '" for="';
        $value = $this->resolveValue($context->findDot('element.id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('label'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= ' ';
        $value = $this->resolveValue($context->find('helpbutton'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $context->find('required');
        $buffer .= $this->section6730a2a52e5db7c4c879bfb59a643823($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $context->find('advanced');
        $buffer .= $this->sectionD92257332197853b576700177e3b14f5($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '    </label>
';
        $buffer .= $indent . '    <span data-fieldtype="';
        $value = $this->resolveValue($context->findDot('element.type'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $blockFunction = $context->findInBlock('element');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= $indent . '            <!-- Element goes here -->
';
        }
        $buffer .= $indent . '    </span>
';
        $value = $context->find('error');
        $buffer .= $this->sectionF937196ce29025b9f53615a4853b068a($context, $indent, $value);
        $buffer .= $indent . '</div>
';
        $value = $context->find('js');
        $buffer .= $this->section5e3e2402022649a7456d563a4d4a94cd($context, $indent, $value);

        return $buffer;
    }

    private function section4d4b829e8a762a460d7710f0a2273a46(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'has-danger';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'has-danger';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB2a3879159edb3a7a33a1d8394a2c556(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'advanced';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'advanced';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE32dd8819580c2040e2441120199ff04(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'data-groupname="{{.}}"';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'data-groupname="';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBd3e0eae730f027ebaa2c5d8144fd11d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'sr-only';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'sr-only';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5197bd4c78ccebd47c9f052795fcb4e4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'required';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'required';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1a62044b8b32f10f428bdf36250d9aac(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'req, core, {{#str}}required{{/str}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'req, core, ';
                $value = $context->find('str');
                $buffer .= $this->section5197bd4c78ccebd47c9f052795fcb4e4($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6730a2a52e5db7c4c879bfb59a643823(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<span class="initialism text-danger icon-required" title="{{#str}}required{{/str}}">{{#pix}}req, core, {{#str}}required{{/str}}{{/pix}}</span>';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<span class="initialism text-danger icon-required" title="';
                $value = $context->find('str');
                $buffer .= $this->section5197bd4c78ccebd47c9f052795fcb4e4($context, $indent, $value);
                $buffer .= '">';
                $value = $context->find('pix');
                $buffer .= $this->section1a62044b8b32f10f428bdf36250d9aac($context, $indent, $value);
                $buffer .= '</span>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD92257332197853b576700177e3b14f5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<span class="initialism text-info icon-info" title="{{#str}}advanced{{/str}}">!</span>';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<span class="initialism text-info icon-info" title="';
                $value = $context->find('str');
                $buffer .= $this->sectionB2a3879159edb3a7a33a1d8394a2c556($context, $indent, $value);
                $buffer .= '">!</span>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC734baf9488de14a7bb5ad592b23e531(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' style="display: inline-flex;"';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' style="display: inline-flex;"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF937196ce29025b9f53615a4853b068a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="form-control-feedback invalid-feedback badge-sq badge-danger w-auto my-0 mx-2 {{^error}}d-none{{/error}}" id="{{element.iderror}}" {{#error}} style="display: inline-flex;"{{/error}}>
        <svg class="mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.9522 16.3536L10.2152 5.85658C10.9531 4.38481 13.0539 4.3852 13.7913 5.85723L19.0495 16.3543C19.7156 17.6841 18.7487 19.25 17.2613 19.25H6.74007C5.25234 19.25 4.2854 17.6835 4.9522 16.3536Z"></path>
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10V12"></path>
            <circle cx="12" cy="16" r="1" fill="currentColor"></circle>
        </svg>
        {{{error}}}
    </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="form-control-feedback invalid-feedback badge-sq badge-danger w-auto my-0 mx-2 ';
                $value = $context->find('error');
                if (empty($value)) {
                    
                    $buffer .= 'd-none';
                }
                $buffer .= '" id="';
                $value = $this->resolveValue($context->findDot('element.iderror'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" ';
                $value = $context->find('error');
                $buffer .= $this->sectionC734baf9488de14a7bb5ad592b23e531($context, $indent, $value);
                $buffer .= '>
';
                $buffer .= $indent . '        <svg class="mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
';
                $buffer .= $indent . '            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.9522 16.3536L10.2152 5.85658C10.9531 4.38481 13.0539 4.3852 13.7913 5.85723L19.0495 16.3543C19.7156 17.6841 18.7487 19.25 17.2613 19.25H6.74007C5.25234 19.25 4.2854 17.6835 4.9522 16.3536Z"></path>
';
                $buffer .= $indent . '            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10V12"></path>
';
                $buffer .= $indent . '            <circle cx="12" cy="16" r="1" fill="currentColor"></circle>
';
                $buffer .= $indent . '        </svg>
';
                $buffer .= $indent . '        ';
                $value = $this->resolveValue($context->find('error'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD51d59cf174abfd59abe29508608fc20(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{element.id}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->findDot('element.id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5e3e2402022649a7456d563a4d4a94cd(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'theme_alpha/form-display-errors\'], function(module) {
    module.enhance({{#quote}}{{element.id}}{{/quote}});
});
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . 'require([\'theme_alpha/form-display-errors\'], function(module) {
';
                $buffer .= $indent . '    module.enhance(';
                $value = $context->find('quote');
                $buffer .= $this->sectionD51d59cf174abfd59abe29508608fc20($context, $indent, $value);
                $buffer .= ');
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
