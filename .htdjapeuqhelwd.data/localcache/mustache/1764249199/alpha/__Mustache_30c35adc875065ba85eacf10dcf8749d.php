<?php

class __Mustache_30c35adc875065ba85eacf10dcf8749d extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="file-picker fp-select">
';
        $buffer .= $indent . '    <div class="fp-select-loading">
';
        $buffer .= $indent . '            <span class="sr-only">';
        $value = $context->find('str');
        $buffer .= $this->section2d03965ea53b60ac982e741c28cc2332($context, $indent, $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '            <svg class="spinner" viewBox="0 0 50 50">
';
        $buffer .= $indent . '                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
';
        $buffer .= $indent . '            </svg>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="fp-container">
';
        $buffer .= $indent . '        <form>
';
        $buffer .= $indent . '            <div class="alert alert-secondary px-4">
';
        $buffer .= $indent . '                <div class="form-check fp-linktype-2 custom-control custom-radio custom-control-inline">
';
        $buffer .= $indent . '                    <div class="form-check-label">
';
        $buffer .= $indent . '                        <input class="form-check-input custom-control-input" type="radio">
';
        $buffer .= $indent . '                        <label class="custom-control-label ml-2">';
        $value = $context->find('str');
        $buffer .= $this->section138cb6f5f895f3f2505b606eb4326b1b($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="form-check fp-linktype-1 custom-control custom-radio custom-control-inline">
';
        $buffer .= $indent . '                    <div class="form-check-label">
';
        $buffer .= $indent . '                        <input class="form-check-input custom-control-input" type="radio">
';
        $buffer .= $indent . '                        <label class="custom-control-label ml-2">';
        $value = $context->find('str');
        $buffer .= $this->section6d8c94c2a0f941cb449ca32e5896d53c($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="form-check fp-linktype-4 custom-control custom-radio custom-control-inline">
';
        $buffer .= $indent . '                    <div class="form-check-label">
';
        $buffer .= $indent . '                        <input class="form-check-input custom-control-input" type="radio">
';
        $buffer .= $indent . '                        <label class="custom-control-label ml-2">';
        $value = $context->find('str');
        $buffer .= $this->section1779e048b12c344235a36a361246b66d($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="form-check fp-linktype-8 custom-control custom-radio custom-control-inline">
';
        $buffer .= $indent . '                    <div class="form-check-label">
';
        $buffer .= $indent . '                        <input class="form-check-input custom-control-input" type="radio">
';
        $buffer .= $indent . '                        <label class="custom-control-label ml-2">';
        $value = $context->find('str');
        $buffer .= $this->section03be6ed2da61d2dfc3bd107eb3c80a92($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '            <div class="fp-saveas form-group row no-gutters">
';
        $buffer .= $indent . '                <label class="form-control-label my-0 mr-md-2 col-sm-12 col-md-4">';
        $value = $context->find('str');
        $buffer .= $this->sectionC83d1eff67053c68bf40e50b3499273e($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                <div class="col"><input class="form-control" type="text"></div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '            <div class="fp-setauthor form-group row no-gutters">
';
        $buffer .= $indent . '                <label class="form-control-label my-0 mr-md-2 col-sm-12 col-md-4">';
        $value = $context->find('str');
        $buffer .= $this->section38331830086571e8a6cab1fc3e99f002($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                <div class="col"><input class="form-control" type="text"></div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '            <div class="fp-setlicense form-group row no-gutters">
';
        if ($partial = $this->mustache->loadPartial('core/filemanager_chooselicense')) {
            $buffer .= $partial->renderInternal($context, $indent . '                ');
        }
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '            <div class="form-group row">
';
        $buffer .= $indent . '                <div class="fp-select-buttons form-group mb-0 w-100 d-inline-flex">
';
        $buffer .= $indent . '                    <button class="fp-select-cancel btn-secondary btn mb-1 col-4">';
        $value = $context->find('str');
        $buffer .= $this->section96a04e644c61b56b5f76ae597e76c7fb($context, $indent, $value);
        $buffer .= '</button>
';
        $buffer .= $indent . '                    <button class="fp-select-confirm btn-primary btn ml-2 mb-1 col justify-content-bettween">';
        $value = $context->find('str');
        $buffer .= $this->section8d1e8b5df863535233c5ae53c44b0cca($context, $indent, $value);
        $buffer .= '</button>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '        </form>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <hr />
';
        $buffer .= $indent . '    <div class="fp-info clearfix d-inline-flex align-items-start col-12 p-0">
';
        $buffer .= $indent . '        <div class="row no-gutters w-100">
';
        $buffer .= $indent . '            <div class="fp-thumbnail col"></div>
';
        $buffer .= $indent . '            <div class="col fp-fileinfo">
';
        $buffer .= $indent . '                <div class="fp-datemodified"><strong>';
        $value = $context->find('str');
        $buffer .= $this->sectionA952921a53c6a683948f9263ac628367($context, $indent, $value);
        $buffer .= '</strong><br /><span class="fp-value"></span></div>
';
        $buffer .= $indent . '                <div class="fp-datecreated"><strong>';
        $value = $context->find('str');
        $buffer .= $this->section354774ed3b5072eae1916c31ef69e9d1($context, $indent, $value);
        $buffer .= '</strong><br /><span class="fp-value"></span></div>
';
        $buffer .= $indent . '                <div class="fp-size"><strong>';
        $value = $context->find('str');
        $buffer .= $this->sectionFf84160216bbfff3c9781f707a5a609b($context, $indent, $value);
        $buffer .= '</strong><br /><span class="fp-value"></span></div>
';
        $buffer .= $indent . '                <div class="fp-license"><strong>';
        $value = $context->find('str');
        $buffer .= $this->sectionF56322876b792ceb41c801f4476eedc2($context, $indent, $value);
        $buffer .= '</strong><br /><span class="fp-value"></span></div>
';
        $buffer .= $indent . '                <div class="fp-author"><strong>';
        $value = $context->find('str');
        $buffer .= $this->section38331830086571e8a6cab1fc3e99f002($context, $indent, $value);
        $buffer .= '</strong><br /><span class="fp-value"></span></div>
';
        $buffer .= $indent . '                <div class="fp-dimensions"><strong>';
        $value = $context->find('str');
        $buffer .= $this->section457e300d70549c75a2a39f37e433234a($context, $indent, $value);
        $buffer .= '</strong><br /><span class="fp-value" dir="ltr"></span></div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</div>
';

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

    private function section138cb6f5f895f3f2505b606eb4326b1b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'makefileinternal, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'makefileinternal, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6d8c94c2a0f941cb449ca32e5896d53c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'makefilelink, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'makefilelink, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1779e048b12c344235a36a361246b66d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'makefilereference, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'makefilereference, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section03be6ed2da61d2dfc3bd107eb3c80a92(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'makefilecontrolledlink, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'makefilecontrolledlink, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC83d1eff67053c68bf40e50b3499273e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'saveas, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'saveas, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section38331830086571e8a6cab1fc3e99f002(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'author, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'author, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section96a04e644c61b56b5f76ae597e76c7fb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'cancel';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'cancel';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8d1e8b5df863535233c5ae53c44b0cca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'getfile, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'getfile, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA952921a53c6a683948f9263ac628367(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'lastmodified, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'lastmodified, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section354774ed3b5072eae1916c31ef69e9d1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'datecreated, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'datecreated, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFf84160216bbfff3c9781f707a5a609b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'size, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'size, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF56322876b792ceb41c801f4476eedc2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'license, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'license, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section457e300d70549c75a2a39f37e433234a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'dimensions, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'dimensions, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
