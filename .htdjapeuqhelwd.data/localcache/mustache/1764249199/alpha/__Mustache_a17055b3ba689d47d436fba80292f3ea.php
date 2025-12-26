<?php

class __Mustache_a17055b3ba689d47d436fba80292f3ea extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="container px-0">
';
        $buffer .= $indent . '    <div tabindex="0" class="file-picker fp-generallayout d-inline-flex flex-wrap w-100" role="dialog" aria-live="assertive">
';
        $buffer .= $indent . '        
';
        $buffer .= $indent . '        <div class="rui-nav-wrapper">
';
        $buffer .= $indent . '            <div role="tablist" class="rui-nav-col">
';
        $buffer .= $indent . '                    <ul class="nav nav-column flex-md-column fp-repo nav-item small" role="tab" aria-selected="false" tabindex="-1">
';
        $buffer .= $indent . '                        <li class="nav-item"><a href="#" class="nav-link" tabindex="-1"><img class="fp-repo-icon" alt=" " width="0" height="0" /><span class="fp-repo-name"></span></a></li>
';
        $buffer .= $indent . '                    </ul>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '        <div class="col pl-sm-0 pl-md-3">
';
        $buffer .= $indent . '            <div class="fp-repo-items" tabindex="0">
';
        $buffer .= $indent . '                <div class="fp-navbar clearfix icon-no-spacing p-0 mb-3">
';
        $buffer .= $indent . '                    <div class="d-inline-flex flex-wrap">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                        <div class="fp-toolbar mb-0">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                            <div class="d-inline-flex flex-wrap align-items-center">
';
        $buffer .= $indent . '                                <div class="fp-tb-back">
';
        $buffer .= $indent . '                                    <a href="#" class="btn btn-secondary btn-sm">';
        $value = $context->find('str');
        $buffer .= $this->section989182df874090b1d11afb2cecf2e6d2($context, $indent, $value);
        $buffer .= '</a>
';
        $buffer .= $indent . '                                </div>
';
        $buffer .= $indent . '                                <div class="fp-tb-search">
';
        $buffer .= $indent . '                                    <form></form>
';
        $buffer .= $indent . '                                </div>
';
        $buffer .= $indent . '                                <div class="fp-tb-refresh">
';
        $buffer .= $indent . '                                    <a title="';
        $value = $context->find('str');
        $buffer .= $this->sectionD3b22f5f9e6d0172d596a230b766ecf6($context, $indent, $value);
        $buffer .= '" class="btn btn-secondary btn-sm" href="#">
';
        $buffer .= $indent . '                                        <svg width="27" height="27" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
';
        $buffer .= $indent . '                                            <path d="M17.1265 6.87348C14.2952 4.04217 9.70478 4.04217 6.87348 6.87348C4.04217 9.70478 4.04217 14.2952 6.87348 17.1265C9.70478 19.9578 14.2952 19.9578 17.1265 17.1265C17.7603 16.4927 18.2522 15.7708 18.6023 15.0001" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                                            <path d="M19.25 19.25V15.75C19.25 15.1977 18.8023 14.75 18.25 14.75H14.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                                        </svg>
';
        $buffer .= $indent . '                                    </a>
';
        $buffer .= $indent . '                                </div>
';
        $buffer .= $indent . '                                <div class="fp-tb-logout">
';
        $buffer .= $indent . '                                    <a title="';
        $value = $context->find('str');
        $buffer .= $this->sectionDb599925a8d148af393cd4473b130b89($context, $indent, $value);
        $buffer .= '" class="btn btn-danger btn-sm" href="#">
';
        $buffer .= $indent . '                                        <svg width="27" height="27" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M15.75 8.75L19.25 12L15.75 15.25"></path>
';
        $buffer .= $indent . '                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19 12H10.75"></path>
';
        $buffer .= $indent . '                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M15.25 4.75H6.75C5.64543 4.75 4.75 5.64543 4.75 6.75V17.25C4.75 18.3546 5.64543 19.25 6.75 19.25H15.25"></path>
';
        $buffer .= $indent . '                                        </svg>
';
        $buffer .= $indent . '                                    </a>
';
        $buffer .= $indent . '                                </div>
';
        $buffer .= $indent . '                                <div class="fp-tb-manage">
';
        $buffer .= $indent . '                                    <a title="';
        $value = $context->find('str');
        $buffer .= $this->sectionFc85716b31799f2e3f077bb11406263b($context, $indent, $value);
        $buffer .= '" class="btn btn-secondary btn-sm" href="#">
';
        $buffer .= $indent . '                                        <svg width="27" height="27" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M13.1191 5.61336C13.0508 5.11856 12.6279 4.75 12.1285 4.75H11.8715C11.3721 4.75 10.9492 5.11856 10.8809 5.61336L10.7938 6.24511C10.7382 6.64815 10.4403 6.96897 10.0622 7.11922C10.006 7.14156 9.95021 7.16484 9.89497 7.18905C9.52217 7.3524 9.08438 7.3384 8.75876 7.09419L8.45119 6.86351C8.05307 6.56492 7.49597 6.60451 7.14408 6.9564L6.95641 7.14408C6.60452 7.49597 6.56492 8.05306 6.86351 8.45118L7.09419 8.75876C7.33841 9.08437 7.3524 9.52216 7.18905 9.89497C7.16484 9.95021 7.14156 10.006 7.11922 10.0622C6.96897 10.4403 6.64815 10.7382 6.24511 10.7938L5.61336 10.8809C5.11856 10.9492 4.75 11.372 4.75 11.8715V12.1285C4.75 12.6279 5.11856 13.0508 5.61336 13.1191L6.24511 13.2062C6.64815 13.2618 6.96897 13.5597 7.11922 13.9378C7.14156 13.994 7.16484 14.0498 7.18905 14.105C7.3524 14.4778 7.3384 14.9156 7.09419 15.2412L6.86351 15.5488C6.56492 15.9469 6.60451 16.504 6.9564 16.8559L7.14408 17.0436C7.49597 17.3955 8.05306 17.4351 8.45118 17.1365L8.75876 16.9058C9.08437 16.6616 9.52216 16.6476 9.89496 16.811C9.95021 16.8352 10.006 16.8584 10.0622 16.8808C10.4403 17.031 10.7382 17.3519 10.7938 17.7549L10.8809 18.3866C10.9492 18.8814 11.3721 19.25 11.8715 19.25H12.1285C12.6279 19.25 13.0508 18.8814 13.1191 18.3866L13.2062 17.7549C13.2618 17.3519 13.5597 17.031 13.9378 16.8808C13.994 16.8584 14.0498 16.8352 14.105 16.8109C14.4778 16.6476 14.9156 16.6616 15.2412 16.9058L15.5488 17.1365C15.9469 17.4351 16.504 17.3955 16.8559 17.0436L17.0436 16.8559C17.3955 16.504 17.4351 15.9469 17.1365 15.5488L16.9058 15.2412C16.6616 14.9156 16.6476 14.4778 16.811 14.105C16.8352 14.0498 16.8584 13.994 16.8808 13.9378C17.031 13.5597 17.3519 13.2618 17.7549 13.2062L18.3866 13.1191C18.8814 13.0508 19.25 12.6279 19.25 12.1285V11.8715C19.25 11.3721 18.8814 10.9492 18.3866 10.8809L17.7549 10.7938C17.3519 10.7382 17.031 10.4403 16.8808 10.0622C16.8584 10.006 16.8352 9.95021 16.8109 9.89496C16.6476 9.52216 16.6616 9.08437 16.9058 8.75875L17.1365 8.4512C17.4351 8.05308 17.3955 7.49599 17.0436 7.1441L16.8559 6.95642C16.504 6.60453 15.9469 6.56494 15.5488 6.86353L15.2412 7.09419C14.9156 7.33841 14.4778 7.3524 14.105 7.18905C14.0498 7.16484 13.994 7.14156 13.9378 7.11922C13.5597 6.96897 13.2618 6.64815 13.2062 6.24511L13.1191 5.61336Z"></path>
';
        $buffer .= $indent . '                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M13.25 12C13.25 12.6904 12.6904 13.25 12 13.25C11.3096 13.25 10.75 12.6904 10.75 12C10.75 11.3096 11.3096 10.75 12 10.75C12.6904 10.75 13.25 11.3096 13.25 12Z"></path>
';
        $buffer .= $indent . '                                        </svg>
';
        $buffer .= $indent . '                                    </a>
';
        $buffer .= $indent . '                                </div>
';
        $buffer .= $indent . '                                <div class="fp-tb-help">
';
        $buffer .= $indent . '                                    <a title="';
        $value = $context->find('str');
        $buffer .= $this->section36b987a1ed6e8cc5076d973376c404d2($context, $indent, $value);
        $buffer .= '" class="btn btn-secondary btn-sm" href="#">
';
        $buffer .= $indent . '                                        <svg width="27" height="27" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19.25 12C19.25 16.0041 16.0041 19.25 12 19.25C7.99594 19.25 4.75 16.0041 4.75 12C4.75 7.99594 7.99594 4.75 12 4.75C16.0041 4.75 19.25 7.99594 19.25 12Z"></path>
';
        $buffer .= $indent . '                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9.75 10C9.75 10 10 7.75 12 7.75C14 7.75 14.25 9 14.25 10C14.25 10.7513 13.8266 11.5027 12.9798 11.8299C12.4647 12.0289 12 12.4477 12 13V13.25"></path>
';
        $buffer .= $indent . '                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M12.5 16C12.5 16.2761 12.2761 16.5 12 16.5C11.7239 16.5 11.5 16.2761 11.5 16C11.5 15.7239 11.7239 15.5 12 15.5C12.2761 15.5 12.5 15.7239 12.5 16Z"></path>
';
        $buffer .= $indent . '                                        </svg>
';
        $buffer .= $indent . '                                    </a>
';
        $buffer .= $indent . '                                </div>
';
        $buffer .= $indent . '                                <div class="fp-tb-message"></div>
';
        $buffer .= $indent . '                            </div>
';
        $buffer .= $indent . '                        </div>
';
        $buffer .= $indent . '                        <div class="fp-viewbar btn-group">
';
        $buffer .= $indent . '                            <a role="button" title="';
        $value = $context->find('str');
        $buffer .= $this->section8d897e2029e0713d9863f86d172c49e7($context, $indent, $value);
        $buffer .= '" class="fp-vb-icons btn btn-secondary btn-sm" href="#">
';
        $buffer .= $indent . '                                <svg width="26" height="26" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.75 5.75C4.75 5.19772 5.19772 4.75 5.75 4.75H9.25C9.80228 4.75 10.25 5.19772 10.25 5.75V9.25C10.25 9.80228 9.80228 10.25 9.25 10.25H5.75C5.19772 10.25 4.75 9.80228 4.75 9.25V5.75Z"/>
';
        $buffer .= $indent . '                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.75 14.75C4.75 14.1977 5.19772 13.75 5.75 13.75H9.25C9.80228 13.75 10.25 14.1977 10.25 14.75V18.25C10.25 18.8023 9.80228 19.25 9.25 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V14.75Z"/>
';
        $buffer .= $indent . '                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.75 5.75C13.75 5.19772 14.1977 4.75 14.75 4.75H18.25C18.8023 4.75 19.25 5.19772 19.25 5.75V9.25C19.25 9.80228 18.8023 10.25 18.25 10.25H14.75C14.1977 10.25 13.75 9.80228 13.75 9.25V5.75Z"/>
';
        $buffer .= $indent . '                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.75 14.75C13.75 14.1977 14.1977 13.75 14.75 13.75H18.25C18.8023 13.75 19.25 14.1977 19.25 14.75V18.25C19.25 18.8023 18.8023 19.25 18.25 19.25H14.75C14.1977 19.25 13.75 18.8023 13.75 18.25V14.75Z"/>
';
        $buffer .= $indent . '                                </svg>
';
        $buffer .= $indent . '                            </a>
';
        $buffer .= $indent . '                            <a role="button" title="';
        $value = $context->find('str');
        $buffer .= $this->section913e83f954c7f484e98975f529e8af70($context, $indent, $value);
        $buffer .= '" class="fp-vb-details btn btn-secondary btn-sm" href="#">
';
        $buffer .= $indent . '                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
';
        $buffer .= $indent . '                                    <path d="M7.75 5.75H16.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                                    <path d="M7.75 18.25H16.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                                    <path d="M4.75 12H19.25" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                                </svg>
';
        $buffer .= $indent . '                            </a>
';
        $buffer .= $indent . '                            <a role="button" title="';
        $value = $context->find('str');
        $buffer .= $this->section90ef4b20fa82eba65cbf016de97c3b30($context, $indent, $value);
        $buffer .= '" class="fp-vb-tree btn btn-secondary btn-sm" href="#">
';
        $buffer .= $indent . '                                <svg width="26" height="26" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.25 17.25V9.75C19.25 8.64543 18.3546 7.75 17.25 7.75H4.75V17.25C4.75 18.3546 5.64543 19.25 6.75 19.25H17.25C18.3546 19.25 19.25 18.3546 19.25 17.25Z"></path>
';
        $buffer .= $indent . '                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 7.5L12.5685 5.7923C12.2181 5.14977 11.5446 4.75 10.8127 4.75H6.75C5.64543 4.75 4.75 5.64543 4.75 6.75V11"></path>
';
        $buffer .= $indent . '                                </svg>
';
        $buffer .= $indent . '                            </a>
';
        $buffer .= $indent . '                        </div>
';
        $buffer .= $indent . '                        <div class="fp-clear-left"></div>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                    <div class="fp-pathbar breadcrumb mx-1 my-2">
';
        $buffer .= $indent . '                        <span class="fp-path-folder breadcrumb-item"><a class="fp-path-folder-name aalink" href="#"></a></span>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-content"></div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section989182df874090b1d11afb2cecf2e6d2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'back, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'back, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD3b22f5f9e6d0172d596a230b766ecf6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'refresh, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'refresh, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDb599925a8d148af393cd4473b130b89(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'logout, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'logout, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFc85716b31799f2e3f077bb11406263b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'manageurl, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'manageurl, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section36b987a1ed6e8cc5076d973376c404d2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'help, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'help, repository';
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

}
