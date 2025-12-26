<?php

class __Mustache_157ad277ea4e15789315d5220e956f29 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="filemanager fp-select">
';
        $buffer .= $indent . '    <div class="fp-select-loading">
';
        $buffer .= $indent . '        <svg class="spinner" viewBox="0 0 50 50">
';
        $buffer .= $indent . '            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
';
        $buffer .= $indent . '        </svg>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <form class="form clearfix">
';
        $buffer .= $indent . '        <div class="form-group row justify-content-end no-gutters mt-0 mb-3">
';
        $buffer .= $indent . '            <button class="fp-file-download btn btn-sm btn-secondary m-1 border-0">
';
        $buffer .= $indent . '                <svg class="mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4.75 14.75V16.25C4.75 17.9069 6.09315 19.25 7.75 19.25H16.25C17.9069 19.25 19.25 17.9069 19.25 16.25V14.75"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 14.25L12 4.75"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8.75 10.75L12 14.25L15.25 10.75"></path>
';
        $buffer .= $indent . '                </svg>
';
        $buffer .= $indent . '                ';
        $value = $context->find('str');
        $buffer .= $this->section95ff3701934939e1eb7bd2c28e3ee1b9($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            </button>
';
        $buffer .= $indent . '            <button class="fp-file-delete btn btn-sm btn-danger m-1 border-0">
';
        $buffer .= $indent . '                <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M6.75 7.75L7.59115 17.4233C7.68102 18.4568 8.54622 19.25 9.58363 19.25H14.4164C15.4538 19.25 16.319 18.4568 16.4088 17.4233L17.25 7.75"/>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9.75 7.5V6.75C9.75 5.64543 10.6454 4.75 11.75 4.75H12.25C13.3546 4.75 14.25 5.64543 14.25 6.75V7.5"/>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M5 7.75H19"/>
';
        $buffer .= $indent . '                </svg>
';
        $buffer .= $indent . '            </button>
';
        $buffer .= $indent . '            <button class="fp-file-setmain btn btn-sm btn-secondary m-1 border-0">';
        $value = $context->find('str');
        $buffer .= $this->section3549061ca37b41dbbdfd8a7e234969c8($context, $indent, $value);
        $buffer .= '</button>
';
        $buffer .= $indent . '            <span class="fp-file-setmain-help col m-1">';
        $value = $this->resolveValue($context->find('helpicon'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '</span>
';
        $buffer .= $indent . '            <button class="fp-file-zip btn btn-sm btn-secondary m-1 border-0">
';
        $buffer .= $indent . '                <svg class="mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M18.25 8.75H5.75L6.57758 17.4396C6.67534 18.4661 7.53746 19.25 8.56857 19.25H15.4314C16.4625 19.25 17.3247 18.4661 17.4224 17.4396L18.25 8.75Z"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19.25 5.75C19.25 5.19772 18.8023 4.75 18.25 4.75H5.75C5.19771 4.75 4.75 5.19772 4.75 5.75V7.75C4.75 8.30228 5.19772 8.75 5.75 8.75H18.25C18.8023 8.75 19.25 8.30228 19.25 7.75V5.75Z"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9.75 13.25H14.25"></path>
';
        $buffer .= $indent . '                </svg>
';
        $buffer .= $indent . '                ';
        $value = $context->find('str');
        $buffer .= $this->sectionB38288f316bd094496a8d2cfdfaa803d($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            </button>
';
        $buffer .= $indent . '            <button class="fp-file-unzip btn btn-sm btn-secondary m-1 border-0">
';
        $buffer .= $indent . '                <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
';
        $buffer .= $indent . '                    <path d="M4.75 19.25H19.25" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                    <path d="M12 15.25V4.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                    <path d="M15.25 8.25L12 4.75L8.75 8.25" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
';
        $buffer .= $indent . '                </svg>
';
        $buffer .= $indent . '                ';
        $value = $context->find('str');
        $buffer .= $this->section2ea6a510d48e1bbe5913e221863ad2fe($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            </button>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '                <div class="fp-saveas form-group row no-gutters">
';
        $buffer .= $indent . '                    <label class="form-control-label my-0 mr-md-2 col-sm-12 col-md-4">';
        $value = $context->find('str');
        $buffer .= $this->section59a2a4641027716ff85403c2d5e94fc1($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                    <div class="col"><input class="form-control" type="text"/></div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-author form-group row no-gutters">
';
        $buffer .= $indent . '                    <label class="form-control-label my-0 mr-md-2 col-sm-12 col-md-4">';
        $value = $context->find('str');
        $buffer .= $this->section38331830086571e8a6cab1fc3e99f002($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                    <div class="col"><input class="form-control" type="text"/></div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-license form-group row no-gutters">
';
        $buffer .= $indent . '                    <div class="form-control-label my-0 mr-md-2 col-sm-12 col-md-4">
';
        $buffer .= $indent . '                        <label for="choose-license-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '                            ';
        $value = $context->find('str');
        $buffer .= $this->section56c60baa62b965c8ddfac2882a15ac40($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                        </label>
';
        $buffer .= $indent . '                        ';
        $value = $context->find('licensehelpicon');
        $buffer .= $this->sectionF799ccb794eb5635625696ee8944adc6($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                    <div class="col">
';
        $buffer .= $indent . '                        <select id="choose-license-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" class="form-control custom-select w-100"></select>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-path form-group row no-gutters">
';
        $buffer .= $indent . '                    <label class="form-control-label my-0 mr-md-2 col-sm-12 col-md-4">';
        $value = $context->find('str');
        $buffer .= $this->section8b4c2af971c52c1b1ba468197877c4cd($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                    <div class="col">
';
        $buffer .= $indent . '                        <select class="custom-select"></select>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-original form-group row no-gutters">
';
        $buffer .= $indent . '                    <label class="form-control-label my-0 mr-md-2 col-sm-12 col-md-4">';
        $value = $context->find('str');
        $buffer .= $this->sectionF7ee1a321b50fcb70dccc8007379d076($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                    <div class="col">
';
        $buffer .= $indent . '                        <span class="fp-originloading">';
        $value = $context->find('pix');
        $buffer .= $this->section17dced043cf1f9973e8ce8dcb3301054($context, $indent, $value);
        $buffer .= ' ';
        $value = $context->find('str');
        $buffer .= $this->section63f96996052a1daca324ae6efeeaf614($context, $indent, $value);
        $buffer .= '</span><span class="fp-value"></span>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="fp-reflist form-group row no-gutters">
';
        $buffer .= $indent . '                    <label class="form-control-label my-0 mr-md-2 col-sm-12 col-md-4">';
        $value = $context->find('str');
        $buffer .= $this->sectionF206846026cb9bb2070e988f807b73e6($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                    <div class="col">
';
        $buffer .= $indent . '                        <p class="fp-refcount"></p>
';
        $buffer .= $indent . '                        <span class="fp-reflistloading">
';
        $buffer .= $indent . '                            <svg class="spinner" viewBox="0 0 50 50">
';
        $buffer .= $indent . '                                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
';
        $buffer .= $indent . '                            </svg>
';
        $buffer .= $indent . '                            ';
        $value = $context->find('str');
        $buffer .= $this->section63f96996052a1daca324ae6efeeaf614($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                        </span>
';
        $buffer .= $indent . '                        <ul class="fp-value"></ul>
';
        $buffer .= $indent . '                    </div>
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '        <div class="fp-select-buttons form-group mb-0 w-100 d-inline-flex">
';
        $buffer .= $indent . '            <button class="fp-file-cancel btn-secondary btn mb-1 col-4">';
        $value = $context->find('str');
        $buffer .= $this->section96a04e644c61b56b5f76ae597e76c7fb($context, $indent, $value);
        $buffer .= '</button>
';
        $buffer .= $indent . '            <button class="fp-file-update btn-primary btn ml-2 mb-1 col justify-content-bettween">
';
        $buffer .= $indent . '                ';
        $value = $context->find('str');
        $buffer .= $this->section47d66f004044b857c042bbdf70fe2cc2($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                <svg class="ml-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M11.25 4.75L8.75 7L11.25 9.25"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12.75 19.25L15.25 17L12.75 14.75"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9.75 7H13.25C16.5637 7 19.25 9.68629 19.25 13V13.25"></path>
';
        $buffer .= $indent . '                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M14.25 17H10.75C7.43629 17 4.75 14.3137 4.75 11V10.75"></path>
';
        $buffer .= $indent . '                </svg>
';
        $buffer .= $indent . '            </button>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </form>
';
        $buffer .= $indent . '    <hr />
';
        $buffer .= $indent . '    <div class="fp-info clearfix d-inline-flex align-items-start col-12 p-0">
';
        $buffer .= $indent . '        <div class="row no-gutters w-100">
';
        $buffer .= $indent . '          <div class="fp-thumbnail col"></div>
';
        $buffer .= $indent . '          <div class="col fp-fileinfo">
';
        $buffer .= $indent . '              <div class="fp-datemodified"><p><strong>';
        $value = $context->find('str');
        $buffer .= $this->sectionA952921a53c6a683948f9263ac628367($context, $indent, $value);
        $buffer .= '</strong><br><span class="fp-value"></span></div>
';
        $buffer .= $indent . '              <div class="fp-datecreated"><strong>';
        $value = $context->find('str');
        $buffer .= $this->section354774ed3b5072eae1916c31ef69e9d1($context, $indent, $value);
        $buffer .= '</strong><br><span class="fp-value"></span></div>
';
        $buffer .= $indent . '              <div class="fp-size"><strong>';
        $value = $context->find('str');
        $buffer .= $this->sectionFf84160216bbfff3c9781f707a5a609b($context, $indent, $value);
        $buffer .= '</strong><br><span class="fp-value"></span></div>
';
        $buffer .= $indent . '              <div class="fp-dimensions"><strong>';
        $value = $context->find('str');
        $buffer .= $this->section457e300d70549c75a2a39f37e433234a($context, $indent, $value);
        $buffer .= '</strong><br><span class="fp-value"></span></div>
';
        $buffer .= $indent . '          </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section95ff3701934939e1eb7bd2c28e3ee1b9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'download';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'download';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3549061ca37b41dbbdfd8a7e234969c8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'setmainfile, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'setmainfile, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB38288f316bd094496a8d2cfdfaa803d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'zip, editor';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'zip, editor';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2ea6a510d48e1bbe5913e221863ad2fe(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'unzip';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'unzip';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section59a2a4641027716ff85403c2d5e94fc1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'name, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'name, repository';
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

    private function section56c60baa62b965c8ddfac2882a15ac40(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'chooselicense, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'chooselicense, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF799ccb794eb5635625696ee8944adc6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{>core/help_icon}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core/help_icon')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8b4c2af971c52c1b1ba468197877c4cd(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'path, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'path, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF7ee1a321b50fcb70dccc8007379d076(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'original, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'original, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section17dced043cf1f9973e8ce8dcb3301054(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'i/loading_small';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'i/loading_small';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section63f96996052a1daca324ae6efeeaf614(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'loading, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'loading, repository';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF206846026cb9bb2070e988f807b73e6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'referenceslist, repository';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'referenceslist, repository';
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

    private function section47d66f004044b857c042bbdf70fe2cc2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'update';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'update';
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
