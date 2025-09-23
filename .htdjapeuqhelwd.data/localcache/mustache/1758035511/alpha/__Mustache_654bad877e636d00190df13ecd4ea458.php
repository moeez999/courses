<?php

class __Mustache_654bad877e636d00190df13ecd4ea458 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="hidden h-100" data-region="view-contacts" aria-hidden="true" data-user-id="';
        $value = $this->resolveValue($context->findDot('loggedinuser.id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '    <div class="d-flex flex-column h-100">
';
        $buffer .= $indent . '        <div>
';
        $buffer .= $indent . '            <ul class="nav nav-tabs mt-0 mb-2 mx-3 justify-content-between" role="tablist">
';
        $buffer .= $indent . '                <li class="col pl-0 pr-1">
';
        $buffer .= $indent . '                    <a
';
        $buffer .= $indent . '                        id="contacts-tab-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                        class="w-100 nav-link active d-inline-block text-center"
';
        $buffer .= $indent . '                        href="#contacts-tab-panel-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                        data-toggle="tab"
';
        $buffer .= $indent . '                        data-action="show-contacts-section"
';
        $buffer .= $indent . '                        role="tab"
';
        $buffer .= $indent . '                        aria-controls="contacts-tab-panel-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                        aria-selected="true"
';
        $buffer .= $indent . '                    >
';
        $buffer .= $indent . '                        ';
        $value = $context->find('str');
        $buffer .= $this->sectionAe27671d8d1750e9af3adcc5df1cbf0d($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                    </a>
';
        $buffer .= $indent . '                </li>
';
        $buffer .= $indent . '                <li class="col pr-0 pl-1">
';
        $buffer .= $indent . '                    <a
';
        $buffer .= $indent . '                        id="requests-tab-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                        class="w-100 nav-link d-inline-block text-center"
';
        $buffer .= $indent . '                        href="#requests-tab-panel-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                        data-toggle="tab"
';
        $buffer .= $indent . '                        data-action="show-requests-section"
';
        $buffer .= $indent . '                        role="tab"
';
        $buffer .= $indent . '                        aria-controls="requests-tab-panel-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                        aria-selected="false"
';
        $buffer .= $indent . '                    >
';
        $buffer .= $indent . '                        ';
        $value = $context->find('str');
        $buffer .= $this->section38df214956e16c7bc931fc8d9a19cd80($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                        <sup class="badge-msg ';
        $value = $context->find('contactrequestcount');
        if (empty($value)) {
            
            $buffer .= 'hidden';
        }
        $buffer .= '"
';
        $buffer .= $indent . '                        data-region="contact-request-count"
';
        $buffer .= $indent . '                        aria-label="';
        $value = $context->find('str');
        $buffer .= $this->section805e650638aa325ee8db2b322ff4bb8f($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '                            ';
        $value = $this->resolveValue($context->find('contactrequestcount'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '
';
        $buffer .= $indent . '                        </sup>
';
        $buffer .= $indent . '                    </a>
';
        $buffer .= $indent . '                </li>
';
        $buffer .= $indent . '            </ul>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="tab-content d-flex flex-column h-100">
';
        $buffer .= $indent . '            ';
        if ($parent = $this->mustache->loadPartial('core_message/message_drawer_view_contacts_body_section_contacts')) {
            $context->pushBlockContext(array(
                'rootclasses' => array($this, 'blockBe8d2206c503159a2c37c030e7297e98'),
                'rootattributes' => array($this, 'block3047c7df26ea71872130586e25c52067'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '            ';
        if ($parent = $this->mustache->loadPartial('core_message/message_drawer_view_contacts_body_section_requests')) {
            $context->pushBlockContext(array(
                'rootclasses' => array($this, 'blockC5cb524ab1657f28c3a13af51d79e7fd'),
                'rootattributes' => array($this, 'block1377f27b265ae29f491bde1e76664c3a'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
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

    private function section38df214956e16c7bc931fc8d9a19cd80(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' requests ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' requests ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section805e650638aa325ee8db2b322ff4bb8f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' pendingcontactrequests, core_message, {{contactrequestcount}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' pendingcontactrequests, core_message, ';
                $value = $this->resolveValue($context->find('contactrequestcount'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function blockBe8d2206c503159a2c37c030e7297e98($context)
    {
        $indent = $buffer = '';
        $buffer .= 'tab-pane fade show active h-100';
    
        return $buffer;
    }

    public function block3047c7df26ea71872130586e25c52067($context)
    {
        $indent = $buffer = '';
        $buffer .= '                    id="contacts-tab-panel-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                    data-section="contacts"
';
        $buffer .= $indent . '                    role="tabpanel"
';
        $buffer .= $indent . '                    aria-labelledby="contacts-tab-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
    
        return $buffer;
    }

    public function blockC5cb524ab1657f28c3a13af51d79e7fd($context)
    {
        $indent = $buffer = '';
        $buffer .= 'tab-pane fade h-100';
    
        return $buffer;
    }

    public function block1377f27b265ae29f491bde1e76664c3a($context)
    {
        $indent = $buffer = '';
        $buffer .= '                    id="requests-tab-panel-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                    data-section="requests"
';
        $buffer .= $indent . '                    role="tabpanel"
';
        $buffer .= $indent . '                    aria-labelledby="requests-tab-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
    
        return $buffer;
    }
}
