<?php

class __Mustache_7928d6fd1af39b875988b439503c621e extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="d-flex flex-column">
';
        $buffer .= $indent . '    <div class="mb-3 bg-white" data-region="all-contacts-container">
';
        $buffer .= $indent . '        <div data-region="contacts-container"  class="pt-2">
';
        $buffer .= $indent . '            <h5 class="mt-3 d-flex align-items-center">
';
        $buffer .= $indent . '                <span class="mr-1">
';
        $buffer .= $indent . '                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                        <circle cx="12" cy="8" r="3.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></circle>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12.25 19.25H6.94953C5.77004 19.25 4.88989 18.2103 5.49085 17.1954C6.36247 15.7234 8.23935 14 12.25 14"></path>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.75 17.75L16 19.25L19.25 14.75"></path>
';
        $buffer .= $indent . '                    </svg>
';
        $buffer .= $indent . '                </span>
';
        $buffer .= $indent . '                ';
        $value = $context->find('str');
        $buffer .= $this->sectionAe27671d8d1750e9af3adcc5df1cbf0d($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            </h5>
';
        $buffer .= $indent . '            <div class="list-group" data-region="list"></div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div data-region="non-contacts-container" class="pt-2">
';
        $buffer .= $indent . '            <h5 class="mt-3 d-flex align-items-center">
';
        $buffer .= $indent . '                <span class="mr-1">
';
        $buffer .= $indent . '                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                        <circle cx="12" cy="8" r="3.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></circle>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12.25 19.25H6.94953C5.77004 19.25 4.88989 18.2103 5.49085 17.1954C6.36247 15.7234 8.23935 14 12.25 14"></path>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.25 19.25L15.75 15.75"></path>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.25L19.25 15.75"></path>
';
        $buffer .= $indent . '                    </svg>
';
        $buffer .= $indent . '                </span>
';
        $buffer .= $indent . '                ';
        $value = $context->find('str');
        $buffer .= $this->section7c04418fb1ac10c2f8bbc38e19a7e6f3($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            </h5>
';
        $buffer .= $indent . '            <div class="list-group" data-region="list"></div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="my-2 px-2">
';
        $buffer .= $indent . '            <button class="btn btn-sm btn-secondary w-100" data-action="load-more-users">
';
        $buffer .= $indent . '                <span data-region="button-text">';
        $value = $context->find('str');
        $buffer .= $this->section64bd7db84b8533b07dee79cd437a0887($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '                <span data-region="loading-icon-container" class="hidden">';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= '</span>
';
        $buffer .= $indent . '            </button>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div data-region="messages-container">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <h5 class="mt-3 d-flex align-items-center">
';
        $buffer .= $indent . '            <span class="mr-1">
';
        $buffer .= $indent . '                <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.75 6.75C4.75 5.64543 5.64543 4.75 6.75 4.75H17.25C18.3546 4.75 19.25 5.64543 19.25 6.75V14.25C19.25 15.3546 18.3546 16.25 17.25 16.25H14.625L12 19.25L9.375 16.25H6.75C5.64543 16.25 4.75 15.3546 4.75 14.25V6.75Z"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M9.5 11C9.5 11.2761 9.27614 11.5 9 11.5C8.72386 11.5 8.5 11.2761 8.5 11C8.5 10.7239 8.72386 10.5 9 10.5C9.27614 10.5 9.5 10.7239 9.5 11Z"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12.5 11C12.5 11.2761 12.2761 11.5 12 11.5C11.7239 11.5 11.5 11.2761 11.5 11C11.5 10.7239 11.7239 10.5 12 10.5C12.2761 10.5 12.5 10.7239 12.5 11Z"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M15.5 11C15.5 11.2761 15.2761 11.5 15 11.5C14.7239 11.5 14.5 11.2761 14.5 11C14.5 10.7239 14.7239 10.5 15 10.5C15.2761 10.5 15.5 10.7239 15.5 11Z"></path>
';
        $buffer .= $indent . '                </svg>
';
        $buffer .= $indent . '            </span>
';
        $buffer .= $indent . '            ';
        $value = $context->find('str');
        $buffer .= $this->sectionD01943ab4af9e11b8162452fa104dec4($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        </h5>
';
        $buffer .= $indent . '        <div class="list-group" data-region="list"></div>
';
        $buffer .= $indent . '        <div class="my-3 px-2">
';
        $buffer .= $indent . '            <button class="btn btn-sm btn-secondary w-100" data-action="load-more-messages">
';
        $buffer .= $indent . '                <span data-region="button-text">';
        $value = $context->find('str');
        $buffer .= $this->section64bd7db84b8533b07dee79cd437a0887($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '                <span data-region="loading-icon-container" class="hidden">';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= '</span>
';
        $buffer .= $indent . '            </button>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="hidden rui-message-container-md mt-3" data-region="no-results-container"><p class="small text-muted">';
        $value = $context->find('str');
        $buffer .= $this->section4fff29ce050a3086d17820b3f0d560b4($context, $indent, $value);
        $buffer .= '</p></div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function sectionAe27671d8d1750e9af3adcc5df1cbf0d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' contacts, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' contacts, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7c04418fb1ac10c2f8bbc38e19a7e6f3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' noncontacts, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' noncontacts, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section64bd7db84b8533b07dee79cd437a0887(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' loadmore, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' loadmore, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD01943ab4af9e11b8162452fa104dec4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' messages, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' messages, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4fff29ce050a3086d17820b3f0d560b4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' noresults, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' noresults, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
