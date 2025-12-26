<?php

class __Mustache_9fb3893b2eb939ed4aa51a6d29a3902b extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div id="filemanager-';
        $value = $this->resolveValue($context->find('client_id'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '" class="filemanager w-100 fm-loading">
';
        $buffer .= $indent . '    <div class="fp-navbar">
';
        $buffer .= $indent . '        <div class="filemanager-toolbar justify-content-between w-100 d-flex">
';
        $buffer .= $indent . '            <div class="fp-toolbar d-inline-flex">
';
        $buffer .= $indent . '                <div class="fp-btn-add">
';
        $buffer .= $indent . '                    <a role="button" title="';
        $value = $context->find('str');
        $buffer .= $this->section2199cd8f36d25b2b56c614f17a73e7ef($context, $indent, $value);
        $buffer .= '" class="icon-no-margin btn btn-icon btn-secondary" href="#">
';
        $buffer .= $indent . '                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
';
        $buffer .= $indent . '                            <path d="M12.75 4.75H7.75C6.64543 4.75 5.75 5.64543 5.75 6.75V17.25C5.75 18.3546 6.64543 19.25 7.75 19.25H16.25C17.3546 19.25 18.25 18.3546 18.25 17.25V10.25M12.75 4.75V8.25C12.75 9.35457 13.6454 10.25 14.75 10.25H18.25M12.75 4.75L18.25 10.25" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                        </svg>
';
        $buffer .= $indent . '                    </a>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-btn-mkdir">
';
        $buffer .= $indent . '                    <a role="button" title="';
        $value = $context->find('str');
        $buffer .= $this->section9099f5cbeac660faacb4383ade7124ac($context, $indent, $value);
        $buffer .= '" class="icon-no-margin btn btn-icon btn-secondary" href="#">
';
        $buffer .= $indent . '                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.25 19.25H6.75C5.64543 19.25 4.75 18.3546 4.75 17.25V7.75H17.25C18.3546 7.75 19.25 8.64543 19.25 9.75V12.25"></path>
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 7.5L12.5685 5.7923C12.2181 5.14977 11.5446 4.75 10.8127 4.75H6.75C5.64543 4.75 4.75 5.64543 4.75 6.75V11"></path>
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14.75V19.25"></path>
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.25 17L14.75 17"></path>
';
        $buffer .= $indent . '                        </svg>
';
        $buffer .= $indent . '                    </a>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-btn-download">
';
        $buffer .= $indent . '                    <a role="button" title="';
        $value = $context->find('str');
        $buffer .= $this->section291e454e0bb653a31e73daf4b9470a20($context, $indent, $value);
        $buffer .= '" class="icon-no-margin btn btn-icon btn-info" href="#">
';
        $buffer .= $indent . '                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.75 14.75V16.25C4.75 17.9069 6.09315 19.25 7.75 19.25H16.25C17.9069 19.25 19.25 17.9069 19.25 16.25V14.75"></path>
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14.25L12 4.75"></path>
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.75 10.75L12 14.25L15.25 10.75"></path>
';
        $buffer .= $indent . '                        </svg>
';
        $buffer .= $indent . '                    </a>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-btn-delete">
';
        $buffer .= $indent . '                    <a role="button" title="';
        $value = $context->find('str');
        $buffer .= $this->section8f92e409dad2d31675245b12b8825d4e($context, $indent, $value);
        $buffer .= '" class="con-no-margin btn btn-icon btn-danger" href="#">
';
        $buffer .= $indent . '                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 7.75L7.59115 17.4233C7.68102 18.4568 8.54622 19.25 9.58363 19.25H14.4164C15.4538 19.25 16.319 18.4568 16.4088 17.4233L17.25 7.75"></path>
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 7.5V6.75C9.75 5.64543 10.6454 4.75 11.75 4.75H12.25C13.3546 4.75 14.25 5.64543 14.25 6.75V7.5"></path>
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7.75H19"></path>
';
        $buffer .= $indent . '                        </svg>
';
        $buffer .= $indent . '                    </a>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <span class="fp-img-downloading">
';
        $buffer .= $indent . '                    <span class="sr-only">';
        $value = $context->find('str');
        $buffer .= $this->section2d03965ea53b60ac982e741c28cc2332($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '                    <svg class="spinner" viewBox="0 0 50 50">
';
        $buffer .= $indent . '                        <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
';
        $buffer .= $indent . '                    </svg>
';
        $buffer .= $indent . '                </span>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '            <div class="fp-viewbar btn-group">
';
        $buffer .= $indent . '                <a title="';
        $value = $context->find('str');
        $buffer .= $this->section8d897e2029e0713d9863f86d172c49e7($context, $indent, $value);
        $buffer .= '" class="fp-vb-icons icon-no-margin btn btn-icon btn-secondary" href="#">
';
        $buffer .= $indent . '                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.75 5.75C4.75 5.19772 5.19772 4.75 5.75 4.75H9.25C9.80228 4.75 10.25 5.19772 10.25 5.75V9.25C10.25 9.80228 9.80228 10.25 9.25 10.25H5.75C5.19772 10.25 4.75 9.80228 4.75 9.25V5.75Z"/>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.75 14.75C4.75 14.1977 5.19772 13.75 5.75 13.75H9.25C9.80228 13.75 10.25 14.1977 10.25 14.75V18.25C10.25 18.8023 9.80228 19.25 9.25 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V14.75Z"/>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.75 5.75C13.75 5.19772 14.1977 4.75 14.75 4.75H18.25C18.8023 4.75 19.25 5.19772 19.25 5.75V9.25C19.25 9.80228 18.8023 10.25 18.25 10.25H14.75C14.1977 10.25 13.75 9.80228 13.75 9.25V5.75Z"/>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.75 14.75C13.75 14.1977 14.1977 13.75 14.75 13.75H18.25C18.8023 13.75 19.25 14.1977 19.25 14.75V18.25C19.25 18.8023 18.8023 19.25 18.25 19.25H14.75C14.1977 19.25 13.75 18.8023 13.75 18.25V14.75Z"/>
';
        $buffer .= $indent . '                    </svg>
';
        $buffer .= $indent . '                </a>
';
        $buffer .= $indent . '                <a title="';
        $value = $context->find('str');
        $buffer .= $this->section913e83f954c7f484e98975f529e8af70($context, $indent, $value);
        $buffer .= '" class="fp-vb-details icon-no-margin btn btn-icon btn-secondary" href="#">
';
        $buffer .= $indent . '                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
';
        $buffer .= $indent . '                        <path d="M7.75 5.75H16.25" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                        <path d="M7.75 18.25H16.25" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                        <path d="M4.75 12H19.25" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                    </svg>
';
        $buffer .= $indent . '                </a>
';
        $buffer .= $indent . '                <a title="';
        $value = $context->find('str');
        $buffer .= $this->section90ef4b20fa82eba65cbf016de97c3b30($context, $indent, $value);
        $buffer .= '" class="fp-vb-tree icon-no-margin btn btn-icon btn-secondary" href="#">
';
        $buffer .= $indent . '                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.25 17.25V9.75C19.25 8.64543 18.3546 7.75 17.25 7.75H4.75V17.25C4.75 18.3546 5.64543 19.25 6.75 19.25H17.25C18.3546 19.25 19.25 18.3546 19.25 17.25Z"/>
';
        $buffer .= $indent . '                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 7.5L12.5685 5.7923C12.2181 5.14977 11.5446 4.75 10.8127 4.75H6.75C5.64543 4.75 4.75 5.64543 4.75 6.75V11"/>
';
        $buffer .= $indent . '                    </svg>
';
        $buffer .= $indent . '                </a>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="fp-pathbar breadcrumb mx-1 my-2 border-top pt-2">
';
        $buffer .= $indent . '            <span class="fp-path-folder breadcrumb-item"><a class="fp-path-folder-name aalink" href="#"></a></span>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="filemanager-loading mdl-align">
';
        $buffer .= $indent . '        <svg class="spinner" viewBox="0 0 50 50">
';
        $buffer .= $indent . '            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
';
        $buffer .= $indent . '        </svg>
';
        $buffer .= $indent . '        <span class="sr-only">';
        $value = $context->find('str');
        $buffer .= $this->section2d03965ea53b60ac982e741c28cc2332($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="filemanager-container mt-2" >
';
        $buffer .= $indent . '        <div class="fm-content-wrapper">
';
        $buffer .= $indent . '            <div class="fp-content"></div>
';
        $buffer .= $indent . '            <div class="fm-empty-container">
';
        $buffer .= $indent . '                <div class="dndupload-message">';
        $value = $context->find('str');
        $buffer .= $this->section82e1630d35fb2f54f03106f301cc9794($context, $indent, $value);
        $buffer .= '<br/><div class="dndupload-arrow"></div></div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '            <div class="dndupload-target">';
        $value = $context->find('str');
        $buffer .= $this->section817ed8a776cf9616bf285ae687c42aba($context, $indent, $value);
        $buffer .= '<br/><div class="dndupload-arrow"></div></div>
';
        $buffer .= $indent . '            <div class="dndupload-progressbars"></div>
';
        $buffer .= $indent . '            <div class="dndupload-uploadinprogress">
';
        $buffer .= $indent . '                <svg class="spinner" viewBox="0 0 50 50">
';
        $buffer .= $indent . '                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
';
        $buffer .= $indent . '                </svg>
';
        $buffer .= $indent . '                <span class="sr-only">';
        $value = $context->find('str');
        $buffer .= $this->section2d03965ea53b60ac982e741c28cc2332($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="filemanager-updating">
';
        $buffer .= $indent . '            <svg class="spinner" viewBox="0 0 50 50">
';
        $buffer .= $indent . '                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
';
        $buffer .= $indent . '            </svg>
';
        $buffer .= $indent . '            <span class="sr-only">';
        $value = $context->find('str');
        $buffer .= $this->section2d03965ea53b60ac982e741c28cc2332($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <div class="fp-restrictions mt-2">
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('restrictions'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '        <span class="dnduploadnotsupported-message"> - ';
        $value = $context->find('str');
        $buffer .= $this->section7335a6ebf55b03b6dc095f5c592b75d1($context, $indent, $value);
        $value = $this->resolveValue($context->find('helpicon'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section2199cd8f36d25b2b56c614f17a73e7ef(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'addfile, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'addfile, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9099f5cbeac660faacb4383ade7124ac(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'makeafolder';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'makeafolder';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section291e454e0bb653a31e73daf4b9470a20(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'download, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'download, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8f92e409dad2d31675245b12b8825d4e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'delete';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'delete';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2d03965ea53b60ac982e741c28cc2332(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'loadinghelp';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'loadinghelp';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8d897e2029e0713d9863f86d172c49e7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'displayicons, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'displayicons, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section913e83f954c7f484e98975f529e8af70(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'displaydetails, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'displaydetails, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section90ef4b20fa82eba65cbf016de97c3b30(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'displaytree, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'displaytree, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section82e1630d35fb2f54f03106f301cc9794(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'dndenabled_inbox';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'dndenabled_inbox';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section817ed8a776cf9616bf285ae687c42aba(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'droptoupload';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'droptoupload';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7335a6ebf55b03b6dc095f5c592b75d1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'dndnotsupported_insentence';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'dndnotsupported_insentence';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
