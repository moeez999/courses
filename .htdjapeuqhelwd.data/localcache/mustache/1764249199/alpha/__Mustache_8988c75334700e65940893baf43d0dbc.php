<?php

class __Mustache_8988c75334700e65940893baf43d0dbc extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="filter_poodll_credsmanager">
';
        $buffer .= $indent . '    <!-- If API user then show a link + js to poke creds in -->
';
        $buffer .= $indent . '    ';
        $value = $context->find('apiuser');
        $buffer .= $this->section0be4f0e31f7a72058c7488b88fd0a7ce($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '    <!-- if no API user then the user sees a link to a page which will allow them to take a free trial -->
';
        $value = $context->find('apiuser');
        if (empty($value)) {
            
            $buffer .= $indent . '        <a href="https://poodll.com/try-poodll" target="_blank">';
            $value = $context->find('str');
            $buffer .= $this->section047e5ec145791a305b4798d2dc1d5bdc($context, $indent, $value);
            $buffer .= ' [&#x2197;]</a>
';
            $buffer .= $indent . '        <!-- a href="';
            $value = $this->resolveValue($context->find('apppath'), $context);
            $buffer .= ($value === null ? '' : $value);
            $buffer .= '/fetchcbpage.php" target="_blank">';
            $value = $context->find('str');
            $buffer .= $this->section047e5ec145791a305b4798d2dc1d5bdc($context, $indent, $value);
            $buffer .= ' [&#x2197;]</a -->
';
        }
        $buffer .= $indent . '</div>
';
        $value = $context->findDot('element.frozen');
        if (empty($value)) {
            
            $value = $context->find('js');
            $buffer .= $this->section8e52d769cf7ac4e6122b58159942caaf($context, $indent, $value);
        }

        return $buffer;
    }

    private function sectionDf9e772a4b907484287d9de35e7c2b03(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'fillcredentials, filter_poodll';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'fillcredentials, filter_poodll';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0be4f0e31f7a72058c7488b88fd0a7ce(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<a href="#" class="cloudpoodll_poke_creds">{{#str}}fillcredentials, filter_poodll{{/str}}</a>';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<a href="#" class="cloudpoodll_poke_creds">';
                $value = $context->find('str');
                $buffer .= $this->sectionDf9e772a4b907484287d9de35e7c2b03($context, $indent, $value);
                $buffer .= '</a>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section047e5ec145791a305b4798d2dc1d5bdc(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'freetrial, filter_poodll';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'freetrial, filter_poodll';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8e52d769cf7ac4e6122b58159942caaf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        require([\'jquery\'],function($) {
            //set up fetch from elsewhere
            $(".filter_poodll_credsmanager .cloudpoodll_poke_creds").on("click", function() {
                event.preventDefault();
                var apiuser = document.getElementById(\'id_s_filter_poodll_cpapiuser\');
                var apisecret = document.getElementById(\'id_s_filter_poodll_cpapisecret\');
                apiuser.value=\'{{{apiuser}}}\';
                apisecret.value=\'{{{apisecret}}}\';
            });
        });
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        require([\'jquery\'],function($) {
';
                $buffer .= $indent . '            //set up fetch from elsewhere
';
                $buffer .= $indent . '            $(".filter_poodll_credsmanager .cloudpoodll_poke_creds").on("click", function() {
';
                $buffer .= $indent . '                event.preventDefault();
';
                $buffer .= $indent . '                var apiuser = document.getElementById(\'id_s_filter_poodll_cpapiuser\');
';
                $buffer .= $indent . '                var apisecret = document.getElementById(\'id_s_filter_poodll_cpapisecret\');
';
                $buffer .= $indent . '                apiuser.value=\'';
                $value = $this->resolveValue($context->find('apiuser'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '\';
';
                $buffer .= $indent . '                apisecret.value=\'';
                $value = $this->resolveValue($context->find('apisecret'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '\';
';
                $buffer .= $indent . '            });
';
                $buffer .= $indent . '        });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
