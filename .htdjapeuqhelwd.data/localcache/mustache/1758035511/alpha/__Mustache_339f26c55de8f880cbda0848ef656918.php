<?php

class __Mustache_339f26c55de8f880cbda0848ef656918 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div id="searchinput-navbar-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" class="simplesearchform m-0">
';
        $buffer .= $indent . '    <div id="searchform-navbar">
';
        $buffer .= $indent . '        <form autocomplete="off" action="';
        $value = $this->resolveValue($context->find('action'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '" method="get" accept-charset="utf-8" class="mform form-inline searchform-navbar">
';
        $value = $context->find('hiddenfields');
        $buffer .= $this->section04b8ae4b53b0a507223620372a841e3e($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '                    <div class="search-input-group d-inline-flex justify-content-between w-100">
';
        $buffer .= $indent . '                        <label for="searchinput-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '                            <span class="sr-only">';
        $value = $this->resolveValue($context->find('searchstring'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '                        </label>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                        <span class="search-input-icon">
';
        $buffer .= $indent . '                            <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.25 19.25L15.5 15.5M4.75 11C4.75 7.54822 7.54822 4.75 11 4.75C14.4518 4.75 17.25 7.54822 17.25 11C17.25 14.4518 14.4518 17.25 11 17.25C7.54822 17.25 4.75 14.4518 4.75 11Z"></path>
';
        $buffer .= $indent . '                            </svg>
';
        $buffer .= $indent . '                        </span>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                        <input type="text"
';
        $buffer .= $indent . '                        id="searchinput-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                        class="search-input w-100"
';
        $buffer .= $indent . '                        placeholder="';
        $value = $this->resolveValue($context->find('searchstring'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '"
';
        $buffer .= $indent . '                        aria-label="';
        $value = $this->resolveValue($context->find('searchstring'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '"
';
        $buffer .= $indent . '                        name="';
        $value = $this->resolveValue($context->find('inputname'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '"
';
        $buffer .= $indent . '                        data-region="input"
';
        $buffer .= $indent . '                        autocomplete="off"
';
        $buffer .= $indent . '                        >
';
        $buffer .= $indent . '                        <button type="submit" class="search-input-btn">
';
        $buffer .= $indent . '                            <svg width="22" height="22" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.75 6.75L19.25 12L13.75 17.25"></path>
';
        $buffer .= $indent . '                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H4.75"></path>
';
        $buffer .= $indent . '                            </svg>
';
        $buffer .= $indent . '                            <span class="sr-only">';
        $value = $this->resolveValue($context->find('searchstring'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '</span>
';
        $buffer .= $indent . '                        </button>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        </form>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';
        $value = $context->find('js');
        $buffer .= $this->sectionA81dd799000f8202e6b292154d307518($context, $indent, $value);

        return $buffer;
    }

    private function section04b8ae4b53b0a507223620372a841e3e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <input type="hidden" name="{{ name }}" value="{{ value }}">
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <input type="hidden" name="';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" value="';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA81dd799000f8202e6b292154d307518(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require(
[
    \'jquery\',
],
function(
    $
) {
    var uniqid = "{{uniqid}}";
    var container = $(\'#searchinput-navbar-\' + uniqid);
    var opensearch = container.find(\'[data-action="opensearch"]\');
    var input = container.find(\'[data-region="input"]\');
    var submit = container.find(\'[data-action="submit"]\');

    submit.on(\'click\', function(e) {
        if (input.val() === \'\') {
            e.preventDefault();
        }
    });
    container.on(\'hidden.bs.collapse\', function() {
        opensearch.removeClass(\'d-none\');
        input.val(\'\');
    });
    container.on(\'show.bs.collapse\', function() {
        opensearch.addClass(\'d-none\');
    });
    container.on(\'shown.bs.collapse\', function() {
        input.focus();
    });
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
                $buffer .= $indent . '],
';
                $buffer .= $indent . 'function(
';
                $buffer .= $indent . '    $
';
                $buffer .= $indent . ') {
';
                $buffer .= $indent . '    var uniqid = "';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '";
';
                $buffer .= $indent . '    var container = $(\'#searchinput-navbar-\' + uniqid);
';
                $buffer .= $indent . '    var opensearch = container.find(\'[data-action="opensearch"]\');
';
                $buffer .= $indent . '    var input = container.find(\'[data-region="input"]\');
';
                $buffer .= $indent . '    var submit = container.find(\'[data-action="submit"]\');
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    submit.on(\'click\', function(e) {
';
                $buffer .= $indent . '        if (input.val() === \'\') {
';
                $buffer .= $indent . '            e.preventDefault();
';
                $buffer .= $indent . '        }
';
                $buffer .= $indent . '    });
';
                $buffer .= $indent . '    container.on(\'hidden.bs.collapse\', function() {
';
                $buffer .= $indent . '        opensearch.removeClass(\'d-none\');
';
                $buffer .= $indent . '        input.val(\'\');
';
                $buffer .= $indent . '    });
';
                $buffer .= $indent . '    container.on(\'show.bs.collapse\', function() {
';
                $buffer .= $indent . '        opensearch.addClass(\'d-none\');
';
                $buffer .= $indent . '    });
';
                $buffer .= $indent . '    container.on(\'shown.bs.collapse\', function() {
';
                $buffer .= $indent . '        input.focus();
';
                $buffer .= $indent . '    });
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
