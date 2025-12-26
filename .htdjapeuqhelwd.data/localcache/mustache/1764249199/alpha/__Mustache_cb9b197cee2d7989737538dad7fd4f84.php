<?php

class __Mustache_cb9b197cee2d7989737538dad7fd4f84 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<button class="btn btn-sm btn-secondary ml-2" type="button" id="dropdownFiltersButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="';
        $value = $context->find('str');
        $buffer .= $this->sectionF2207032852bc806cdc43df3b3b11324($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '    <svg width="20" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
';
        $buffer .= $indent . '        <path d="M4.75 7C4.33579 7 4 7.33579 4 7.75C4 8.16421 4.33579 8.5 4.75 8.5V7ZM19.25 8.5C19.6642 8.5 20 8.16421 20 7.75C20 7.33579 19.6642 7 19.25 7V8.5ZM4.75 8.5H19.25V7H4.75V8.5Z" fill="currentColor"></path>
';
        $buffer .= $indent . '        <path d="M6.75 11C6.33579 11 6 11.3358 6 11.75C6 12.1642 6.33579 12.5 6.75 12.5V11ZM17.25 12.5C17.6642 12.5 18 12.1642 18 11.75C18 11.3358 17.6642 11 17.25 11V12.5ZM6.75 12.5H17.25V11H6.75V12.5Z" fill="currentColor"></path>
';
        $buffer .= $indent . '        <path d="M8.75 15C8.33579 15 8 15.3358 8 15.75C8 16.1642 8.33579 16.5 8.75 16.5V15ZM15.25 16.5C15.6642 16.5 16 16.1642 16 15.75C16 15.3358 15.6642 15 15.25 15V16.5ZM8.75 16.5H15.25V15H8.75V16.5Z" fill="currentColor"></path>
';
        $buffer .= $indent . '    </svg>
';
        $buffer .= $indent . '    <span data-region="filter-button-label" class="ml-2">
';
        $buffer .= $indent . '        ';
        $value = $context->find('filtersapplied');
        $buffer .= $this->section43ec75dbf834c55551894ca0e30f2c71($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $context->find('filtersapplied');
        if (empty($value)) {
            
            $buffer .= ' ';
            $value = $context->find('str');
            $buffer .= $this->sectionF2207032852bc806cdc43df3b3b11324($context, $indent, $value);
            $buffer .= ' ';
        }
        $buffer .= '
';
        $buffer .= $indent . '    </span>
';
        $buffer .= $indent . '</button>
';
        $buffer .= $indent . '<div class="filters-dropdown dropdown-menu dropdown-menu-right moodle-has-zindex" aria-labelledby="dropdownFiltersButton">
';
        $buffer .= $indent . '    <div id="filters" class="reportbuilder-filters-sidebar" data-region="report-filters">
';
        $buffer .= $indent . '        <div class="p-3">
';
        $value = $context->find('filtersform');
        $buffer .= $this->section8fec6d905b258a7c95a67a64716534e3($context, $indent, $value);
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';
        $value = $context->find('js');
        $buffer .= $this->sectionF3941a3b6a7a03ae9a589d7d62d7f5e1($context, $indent, $value);

        return $buffer;
    }

    private function sectionF2207032852bc806cdc43df3b3b11324(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' filters, moodle ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' filters, moodle ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4541cddf8328ee80893decc4dfaf9643(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' filtersappliedx, core_reportbuilder, {{filtersapplied}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' filtersappliedx, core_reportbuilder, ';
                $value = $this->resolveValue($context->find('filtersapplied'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section43ec75dbf834c55551894ca0e30f2c71(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' {{#str}} filtersappliedx, core_reportbuilder, {{filtersapplied}} {{/str}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' ';
                $value = $context->find('str');
                $buffer .= $this->section4541cddf8328ee80893decc4dfaf9643($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8fec6d905b258a7c95a67a64716534e3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="reportbuilder-filters-wrapper" data-region="filters-form">
                    {{{filtersform}}}
                </div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="reportbuilder-filters-wrapper" data-region="filters-form">
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('filtersform'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF3941a3b6a7a03ae9a589d7d62d7f5e1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    require([\'core_reportbuilder/filters\'], function(filters) {
        filters.init({{id}}, {{contextid}});
    });
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    require([\'core_reportbuilder/filters\'], function(filters) {
';
                $buffer .= $indent . '        filters.init(';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ', ';
                $value = $this->resolveValue($context->find('contextid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ');
';
                $buffer .= $indent . '    });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
