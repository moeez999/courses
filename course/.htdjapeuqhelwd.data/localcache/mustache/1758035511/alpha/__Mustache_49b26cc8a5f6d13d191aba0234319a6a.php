<?php

class __Mustache_49b26cc8a5f6d13d191aba0234319a6a extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($parent = $this->mustache->loadPartial('core/drawer')) {
            $context->pushBlockContext(array(
                'drawercontent' => array($this, 'block85a883e7952c4f353256de477003c56b'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= $indent . '
';
        $value = $context->find('js');
        $buffer .= $this->section278d5ee1b7145e87f9c48b95149b7e68($context, $indent, $value);

        return $buffer;
    }

    private function section507b9f28a10a9aed70b7b7a308c6a3ca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' search, core_search ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' search, core_search ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section278d5ee1b7145e87f9c48b95149b7e68(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  require([\'jquery\', \'core_message/message_drawer\'], function($, MessageDrawer) {
      var root = $(\'#message-drawer-{{uniqid}}, .message-drawer-toggle, .message-drawer-backdrop\');
      MessageDrawer.init(root, \'{{uniqid}}\', false);
  });
  ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '  require([\'jquery\', \'core_message/message_drawer\'], function($, MessageDrawer) {
';
                $buffer .= $indent . '      var root = $(\'#message-drawer-';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ', .message-drawer-toggle, .message-drawer-backdrop\');
';
                $buffer .= $indent . '      MessageDrawer.init(root, \'';
                $value = $this->resolveValue($context->find('uniqid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '\', false);
';
                $buffer .= $indent . '  });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block85a883e7952c4f353256de477003c56b($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '    <div id="message-drawer-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" class="message-app" data-region="message-drawer" role="region">
';
        $buffer .= $indent . '        <div class="header-container" data-region="header-container">
';
        $buffer .= $indent . '            <div class="rui-message-header-container row no-gutters justify-content-between w-100">
';
        $buffer .= $indent . '                <button class="message-drawer-toggle btn-msg-danger">
';
        $buffer .= $indent . '                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.25 6.75L6.75 17.25"></path>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6.75 6.75L17.25 17.25"></path>
';
        $buffer .= $indent . '                    </svg>
';
        $buffer .= $indent . '                </button>
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_overview_header')) {
            $buffer .= $partial->renderInternal($context, $indent . '                ');
        }
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '            <div class="d-block w-100">
';
        $buffer .= $indent . '                <hr class="rui-message-hr" />
';
        $buffer .= $indent . '                <div aria-hidden="false" data-region="view-overview">
';
        $buffer .= $indent . '                    <div class="d-flex align-items-center">
';
        $buffer .= $indent . '                        <div class="input-group">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                            <input
';
        $buffer .= $indent . '                                type="text"
';
        $buffer .= $indent . '                                class="form-control rui-message-search-input my-2 mx-3"
';
        $buffer .= $indent . '                                placeholder="';
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '                                aria-label="';
        $value = $context->find('str');
        $buffer .= $this->section507b9f28a10a9aed70b7b7a308c6a3ca($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '                                data-region="view-overview-search-input"
';
        $buffer .= $indent . '                            >
';
        $buffer .= $indent . '                        </div>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_search_header')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_settings_header')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_contacts_header')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_header')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="body-container position-relative" data-region="body-container">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_contact_body')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_contacts_body')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_body')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_group_info_body')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_overview_body')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_search_body')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_settings_body')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="position-relative" data-region="footer-container">
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_footer')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    </div>
';
    
        return $buffer;
    }
}
