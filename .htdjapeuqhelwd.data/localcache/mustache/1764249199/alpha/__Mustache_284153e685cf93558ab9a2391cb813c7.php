<?php

class __Mustache_284153e685cf93558ab9a2391cb813c7 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div
';
        $buffer .= $indent . '    class="view-conversation hidden h-100"
';
        $buffer .= $indent . '    aria-hidden="true"
';
        $buffer .= $indent . '    data-region="view-conversation"
';
        $buffer .= $indent . '    data-user-id="';
        $value = $this->resolveValue($context->findDot('loggedinuser.id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-midnight="';
        $value = $this->resolveValue($context->findDot('loggedinuser.midnight'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-message-poll-min="';
        $value = $this->resolveValue($context->find('messagepollmin'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-message-poll-max="';
        $value = $this->resolveValue($context->find('messagepollmax'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    data-message-poll-after-max="';
        $value = $this->resolveValue($context->find('messagepollaftermax'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '    style="overflow-y: auto; overflow-x: hidden"
';
        $buffer .= $indent . '>
';
        $buffer .= $indent . '    <div class="conversation-content-container position-relative h-100" data-region="content-container" style="overflow-y: auto; overflow-x: hidden">
';
        $buffer .= $indent . '        <div class="rui-content-message-container hidden h-100" data-region="content-message-container" role="log" style="overflow-y: auto; overflow-x: hidden">
';
        $buffer .= $indent . '            <div class="rui-additional-info sticky-top z-index-1 hidden" data-region="contact-request-sent-message-container">
';
        $buffer .= $indent . '                <span class="badge-sq badge-info mb-1">';
        $value = $context->find('str');
        $buffer .= $this->sectionCa904a119b3dac50271d2b70edc496a4($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '                <span class="badge-sq badge-light mx-0" data-region="text" style="max-width: 252px;"></span>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '            <div class="mt-3 mx-3 p-3 alert alert-warning hidden" data-region="self-conversation-message-container">
';
        $buffer .= $indent . '                <h4 class="d-flex align-items-center">
';
        $buffer .= $indent . '                    <svg class="mr-2" width="22" height="22" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.75 11.75C5.75 11.1977 6.19772 10.75 6.75 10.75H17.25C17.8023 10.75 18.25 11.1977 18.25 11.75V17.25C18.25 18.3546 17.3546 19.25 16.25 19.25H7.75C6.64543 19.25 5.75 18.3546 5.75 17.25V11.75Z"></path>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.75 10.5V10.3427C7.75 8.78147 7.65607 7.04125 8.74646 5.9239C9.36829 5.2867 10.3745 4.75 12 4.75C13.6255 4.75 14.6317 5.2867 15.2535 5.9239C16.3439 7.04125 16.25 8.78147 16.25 10.3427V10.5"></path>
';
        $buffer .= $indent . '                    </svg>
';
        $buffer .= $indent . '                    <span>';
        $value = $context->find('str');
        $buffer .= $this->sectionE25923aa4be0179138e2662b61384260($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '                </h4>
';
        $buffer .= $indent . '                <p class="ml-4" data-region="text" style="margin-left: 32px;">';
        $value = $context->find('str');
        $buffer .= $this->section3ccb8d9c909989e8235c137f4161b0e4($context, $indent, $value);
        $buffer .= '</p>
';
        $buffer .= $indent . '           </div>
';
        $buffer .= $indent . '            <div class="hidden text-center p-3" data-region="more-messages-loading-icon-container">';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context);
        }
        $buffer .= '</div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="p-4 w-100 h-100 hidden position-absolute" data-region="confirm-dialogue-container" style="top: 0; z-index: 3; background: rgba(0, 0, 0, 0.3);">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_body_confirm_dialogue')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="px-2 pb-2 pt-0" data-region="content-placeholder">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_body_placeholder')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function sectionCa904a119b3dac50271d2b70edc496a4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' contactrequestsent, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' contactrequestsent, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE25923aa4be0179138e2662b61384260(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' selfconversation, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' selfconversation, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3ccb8d9c909989e8235c137f4161b0e4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' selfconversationdefaultmessage, core_message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' selfconversationdefaultmessage, core_message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
