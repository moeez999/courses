<?php

class __Mustache_cfc0e1004460d73893da207f7fcedef8 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="rui-login-layout 
';
        $buffer .= $indent . '        ';
        $value = $context->find('loginlayoutimg');
        $buffer .= $this->sectionFae2e673aab9f27c06408ea1443e7dfd($context, $indent, $value);
        $buffer .= ' 
';
        $buffer .= $indent . '        ';
        $value = $context->find('loginlayoutimg');
        if (empty($value)) {
            
            $buffer .= 'rui-login-layout-simple';
        }
        $buffer .= ' 
';
        $buffer .= $indent . '        ';
        $value = $context->find('loginlogooutside');
        $buffer .= $this->section2f8037f28a0eb1fa35d2b2c37d3c9283($context, $indent, $value);
        $buffer .= ' 
';
        $buffer .= $indent . '        ';
        $value = $context->find('loginlayout1');
        $buffer .= $this->sectionC1e15dfdcabb04e68c281485556042d6($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $context->find('loginlayout2');
        $buffer .= $this->sectionD0da84c782719be6e34d02bb0f01be84($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $context->find('loginlayout3');
        $buffer .= $this->section18b534f24a03a4391946c1f51b854472($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $context->find('loginlayout4');
        $buffer .= $this->sectionD876a3aff3d0c0634f093d41158002e9($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $context->find('loginlayout5');
        $buffer .= $this->section29ff704ed8f80fea4ffde99c6c0ba9ab($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        ">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $value = $context->find('cansignup');
        $buffer .= $this->section4c9e203267b8d8c76553b61c830b3aa0($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $value = $context->find('loginlayoutimg');
        $buffer .= $this->sectionEe8640f8e152cf479225e46d6b2cbd03($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('loginlogooutside');
        $buffer .= $this->section5648c52be0c25f2ba14e32e131ac4372($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('loginhtmlcontent1');
        $buffer .= $this->section8b519503053752c96ef96a88c644205c($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('loginlayoutimg');
        $buffer .= $this->section54a0550db6819289534ecb1970547b39($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('loginlayoutimg');
        $buffer .= $this->sectionA3539aa03a16bba120c3a557fb675274($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '<div class="rui-login-box">
';
        $buffer .= $indent . '    <div class="rui-login-content">
';
        $value = $context->find('cansignup');
        $buffer .= $this->sectionEea1ed30e48185de5a755493672e64a6($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <div class="rui-loginpage-intro">
';
        $value = $context->find('loginlogooutside');
        if (empty($value)) {
            
            $buffer .= $indent . '                <div class="rui-loginpage-intro-logo ';
            $value = $context->find('customlogindmlogo');
            $buffer .= $this->section9f02bdab39bdb326c592eb1133254d23($context, $indent, $value);
            $buffer .= ' ">
';
            $value = $context->find('customloginlogo');
            $buffer .= $this->section6eace7c02b06d79590c468bc2f3beb1c($context, $indent, $value);
            $buffer .= $indent . '
';
            $value = $context->find('customloginlogo');
            if (empty($value)) {
                
                $value = $context->find('logourl');
                $buffer .= $this->sectionCf7d462e4ae082ad14f470def20cac43($context, $indent, $value);
                $buffer .= $indent . '
';
                $value = $context->find('logourl');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                            <a href="';
                    $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                    $buffer .= ($value === null ? '' : $value);
                    $buffer .= '">
';
                    $buffer .= $indent . '                                <h2>';
                    $value = $this->resolveValue($context->find('sitename'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '</h2>
';
                    $buffer .= $indent . '                            </a>
';
                }
            }
            $buffer .= $indent . '                </div>
';
        }
        $buffer .= $indent . '
';
        $value = $context->find('loginintrotext');
        $buffer .= $this->sectionDaa09534cb1a02048b62e6ece5c27478($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '
';
        $value = $context->find('error');
        $buffer .= $this->section933ce9572b034298e4d285f7ea3a4498($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('loginidprovtop');
        $buffer .= $this->section61edd752a216efa880fe2dde846501ca($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <div class="rui-login-form">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '            <form action="';
        $value = $this->resolveValue($context->find('loginurl'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" method="post" id="login">
';
        $buffer .= $indent . '                <input id="anchor" type="hidden" name="anchor" value="">
';
        $buffer .= $indent . '                <script>
';
        $buffer .= $indent . '                    document.getElementById(\'anchor\').value = location.hash;
';
        $buffer .= $indent . '                </script>
';
        $buffer .= $indent . '                <input type="hidden" name="logintoken" value="';
        $value = $this->resolveValue($context->find('logintoken'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '                <div class="form-group mb-2">
';
        $buffer .= $indent . '                    <label for="username" class="sr-only">
';
        $value = $context->find('canloginbyemail');
        if (empty($value)) {
            
            $buffer .= $indent . '                            ';
            $value = $context->find('str');
            $buffer .= $this->section27e9419edc620e0e1872d2a6521f1533($context, $indent, $value);
            $buffer .= '
';
        }
        $value = $context->find('canloginbyemail');
        $buffer .= $this->section1e043cbc642d77f2f4cb8aed5b9ceeaa($context, $indent, $value);
        $buffer .= $indent . '                    </label>
';
        $buffer .= $indent . '                    <input type="text" name="username" id="username" ';
        $buffer .= 'class="form-control form-control--username" ';
        $buffer .= 'value="';
        $value = $this->resolveValue($context->find('username'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" ';
        $buffer .= 'placeholder="';
        $value = $context->find('canloginbyemail');
        if (empty($value)) {
            
            $value = $context->find('cleanstr');
            $buffer .= $this->sectionFea69428308e6a733cfeebf7670bdc01($context, $indent, $value);
        }
        $value = $context->find('canloginbyemail');
        $buffer .= $this->section118ece6c412804f669c845b43ecc9a01($context, $indent, $value);
        $buffer .= '" ';
        $buffer .= 'autocomplete="username">
';
        $value = $context->find('rememberusername');
        $buffer .= $this->section9ccd7214b3989d576097cc1a7b668780($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '                </div>
';
        $buffer .= $indent . '                <div class="form-group my-1">
';
        $buffer .= $indent . '                    <label for="password" class="sr-only">';
        $value = $context->find('str');
        $buffer .= $this->sectionE056be559d6d01a9bd2bf6f760f8e3e3($context, $indent, $value);
        $buffer .= '</label>
';
        $buffer .= $indent . '                    <input type="password" name="password" id="password" value="" ';
        $buffer .= 'class="form-control form-control--password" ';
        $buffer .= 'placeholder="';
        $value = $context->find('cleanstr');
        $buffer .= $this->section4e50d9b1632f258e8c10be3e2ed759be($context, $indent, $value);
        $buffer .= '" ';
        $buffer .= 'autocomplete="current-password">
';
        $buffer .= $indent . '                    <span class="rui-show-password-btn rui-show-password-btn--hidden" id="togglePassword">
';
        $buffer .= $indent . '                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.25 12C19.25 13 17.5 18.25 12 18.25C6.5 18.25 4.75 13 4.75 12C4.75 11 6.5 5.75 12 5.75C17.5 5.75 19.25 11 19.25 12Z"></path>
';
        $buffer .= $indent . '                            <circle cx="12" cy="12" r="2.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></circle>
';
        $buffer .= $indent . '                        </svg>
';
        $buffer .= $indent . '                    </span>
';
        $buffer .= $indent . '                </div>
';
        $value = $context->find('hideforgotpassword');
        if (empty($value)) {
            
            $buffer .= $indent . '                    <div class="w-100 text-center">
';
            $buffer .= $indent . '                        <a class="rui-login-forgot-btn" href="';
            $value = $this->resolveValue($context->find('forgotpasswordurl'), $context);
            $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
            $buffer .= '">';
            $value = $context->find('str');
            $buffer .= $this->section6aa95a7e496f5307b40bee7262bd9321($context, $indent, $value);
            $buffer .= '</a>
';
            $buffer .= $indent . '                    </div>
';
        }
        $buffer .= $indent . '                ';
        $value = $this->resolveValue($context->find('logininfobox'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '                <button type="submit" class="btn btn-lg btn-primary btn-block mt-3" id="loginbtn">';
        $value = $context->find('str');
        $buffer .= $this->sectionB15dee8971ab065bf4d6402b60d852be($context, $indent, $value);
        $buffer .= '</button>
';
        $buffer .= $indent . '            </form>
';
        $buffer .= $indent . '        </div><!-- .rui-login-form -->
';
        $buffer .= $indent . '
';
        $value = $context->find('loginidprovtop');
        if (empty($value)) {
            
            $value = $context->find('hasidentityproviders');
            $buffer .= $this->sectionE42690251cfc0a3486b867f189fb7478($context, $indent, $value);
        }
        $buffer .= $indent . '
';
        $buffer .= $indent . '        <div class="rui-login-additional-btns">
';
        $value = $context->find('canloginasguest');
        $buffer .= $this->sectionF36b0d394a2e9b714e6f8f26176c07bd($context, $indent, $value);
        $buffer .= $indent . '        </div><!-- .rui-additional-btns -->
';
        $buffer .= $indent . '
';
        $value = $context->find('cansignup');
        $buffer .= $this->sectionFfb26604630b5981f8433074367a2fb2($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('loginhtmlblockbottom');
        $buffer .= $this->sectionB04a755359b8decd99f921ec3a015a80($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('instructions');
        $buffer .= $this->sectionC57e734f8756db360cd536f10f79013c($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('loginlayoutimg');
        if (empty($value)) {
            
            $value = $context->find('loginhtmlcontent3');
            $buffer .= $this->section9629e66a46d9a0ade8169700e014717f($context, $indent, $value);
            $buffer .= $indent . '
';
            $value = $context->find('loginfootercontent');
            $buffer .= $this->section8870855cdcd93bd920a015acd41a4013($context, $indent, $value);
        }
        $buffer .= $indent . '    </div><!-- .rui-login-content -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</div><!-- .rui-login-box -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $value = $context->find('maintenance');
        $buffer .= $this->section930aebc1634e5f15f371ff056c4205fb($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('loginlayoutimg');
        $buffer .= $this->sectionE07730468bce6a85be028569c6c04566($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('loginlayoutimg');
        $buffer .= $this->section54a0550db6819289534ecb1970547b39($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('loginlayoutimg');
        $buffer .= $this->section9043df10a525c4dae20b27fb95e8cd66($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '<button type="button" class="btn btn-xs btn-dark btn--cookie" ';
        $buffer .= ' data-modal="alert" ';
        $buffer .= ' data-modal-title-str=\'["cookiesenabled", "core"]\' ';
        $buffer .= ' data-modal-content-str=\'["cookiesenabled_help_html", "core"]\' ';
        $buffer .= '>
';
        $buffer .= $indent . '    <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
';
        $buffer .= $indent . '        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V15"></path>
';
        $buffer .= $indent . '        <circle cx="12" cy="9" r="1" fill="currentColor"></circle>
';
        $buffer .= $indent . '        <circle cx="12" cy="12" r="7.25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></circle>
';
        $buffer .= $indent . '    </svg>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <span class="ml-1">';
        $value = $context->find('str');
        $buffer .= $this->sectionFcb729cc74d31bce5e3746aa60b79a2e($context, $indent, $value);
        $buffer .= '</span></button>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '</div><!-- .login layout -->
';
        $buffer .= $indent . '
';
        $value = $context->find('js');
        $buffer .= $this->section09809d8efd02426f89327b1e00eb5c27($context, $indent, $value);
        $buffer .= $indent . '<script>
';
        $buffer .= $indent . '    const togglePassword = document.querySelector("#togglePassword");
';
        $buffer .= $indent . '    const password = document.querySelector("#password");
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    togglePassword.addEventListener("click", function() {
';
        $buffer .= $indent . '        // toggle the type attribute
';
        $buffer .= $indent . '        const type = password.getAttribute("type") === "password" ? "text" : "password";
';
        $buffer .= $indent . '        password.setAttribute("type", type);
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '        // toggle the icon
';
        $buffer .= $indent . '        this.classList.toggle("rui-show-password-btn--hidden");
';
        $buffer .= $indent . '    });
';
        $buffer .= $indent . '</script>
';
        $buffer .= $indent . '
';
        $value = $this->resolveValue($context->find('logincustomfooterhtml'), $context);
        $buffer .= $indent . ($value === null ? '' : $value);
        $buffer .= '
';

        return $buffer;
    }

    private function sectionFae2e673aab9f27c06408ea1443e7dfd(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-login-layout-img';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-login-layout-img';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2f8037f28a0eb1fa35d2b2c37d3c9283(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-login--logo-outsite';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-login--logo-outsite';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC1e15dfdcabb04e68c281485556042d6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-login-layout--1';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-login-layout--1';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD0da84c782719be6e34d02bb0f01be84(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-login-layout--2';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-login-layout--2';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section18b534f24a03a4391946c1f51b854472(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-login-layout--3';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-login-layout--3';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD876a3aff3d0c0634f093d41158002e9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-login-layout--4';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-login-layout--4';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section29ff704ed8f80fea4ffde99c6c0ba9ab(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'rui-login-layout--5';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'rui-login-layout--5';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6c3bb486c714d0c054c8294443f797d4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<span class="rui-login-calabel mr-2">{{{stringca}}}</span>';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<span class="rui-login-calabel mr-2">';
                $value = $this->resolveValue($context->find('stringca'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</span>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section47f819a53e4575a4e7767be1939ab3bf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'startsignup';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'startsignup';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE001b861e0b5a00b44f02a1751dae58a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="rui-login-top-btn">
                <form action="{{signupurl}}" method="get" id="signup">
                    {{#stringca}}<span class="rui-login-calabel mr-2">{{{stringca}}}</span>{{/stringca}} <button type="submit" class="btn-link--clean">{{#str}}startsignup{{/str}}</button>
                </form>
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="rui-login-top-btn">
';
                $buffer .= $indent . '                <form action="';
                $value = $this->resolveValue($context->find('signupurl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" method="get" id="signup">
';
                $buffer .= $indent . '                    ';
                $value = $context->find('stringca');
                $buffer .= $this->section6c3bb486c714d0c054c8294443f797d4($context, $indent, $value);
                $buffer .= ' <button type="submit" class="btn-link--clean">';
                $value = $context->find('str');
                $buffer .= $this->section47f819a53e4575a4e7767be1939ab3bf($context, $indent, $value);
                $buffer .= '</button>
';
                $buffer .= $indent . '                </form>
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4c9e203267b8d8c76553b61c830b3aa0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{#customsignupoutside}}
            <div class="rui-login-top-btn">
                <form action="{{signupurl}}" method="get" id="signup">
                    {{#stringca}}<span class="rui-login-calabel mr-2">{{{stringca}}}</span>{{/stringca}} <button type="submit" class="btn-link--clean">{{#str}}startsignup{{/str}}</button>
                </form>
            </div>
        {{/customsignupoutside}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('customsignupoutside');
                $buffer .= $this->sectionE001b861e0b5a00b44f02a1751dae58a($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEe8640f8e152cf479225e46d6b2cbd03(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="rui-login-wrapper">
            <div class="rui-login-top-wrapper">
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="rui-login-wrapper">
';
                $buffer .= $indent . '            <div class="rui-login-top-wrapper">
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section981089df6c14b48a079295955714b0e8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="rui-login-top">
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="rui-login-top">
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAe4fc5ca808fc1e29e44cd754ca385bf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <a href="{{{ config.wwwroot }}}"><img src="{{customloginlogo}}" title="{{sitename}}" alt="{{sitename}}" class="rui-login-logo img-fluid" /></a>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    <a href="';
                $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '"><img src="';
                $value = $this->resolveValue($context->find('customloginlogo'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" title="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="rui-login-logo img-fluid" /></a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section137322d57e4c88980701719d508da71f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                        <a href="{{{ config.wwwroot }}}"><img src="{{logourl}}" title="{{sitename}}" alt="{{sitename}}" class="rui-login-logo img-fluid" /></a>
                    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                        <a href="';
                $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '"><img src="';
                $value = $this->resolveValue($context->find('logourl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" title="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="rui-login-logo img-fluid" /></a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8618e343996175e8eea317f67d10daab(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        </div>';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        </div>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5648c52be0c25f2ba14e32e131ac4372(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="rui-login-logo-container my-6">
            {{#loginlayoutimg}}
                <div class="rui-login-top">
            {{/loginlayoutimg}}
            <div>
                {{#customloginlogo}}
                    <a href="{{{ config.wwwroot }}}"><img src="{{customloginlogo}}" title="{{sitename}}" alt="{{sitename}}" class="rui-login-logo img-fluid" /></a>
                {{/customloginlogo}}

                {{^customloginlogo}}
                    {{#logourl}}
                        <a href="{{{ config.wwwroot }}}"><img src="{{logourl}}" title="{{sitename}}" alt="{{sitename}}" class="rui-login-logo img-fluid" /></a>
                    {{/logourl}}

                    {{^logourl}}
                        <a href="{{{ config.wwwroot }}}">
                            <h1 class="rui-login-logo-name">{{sitename}}</h1>
                        </a>
                    {{/logourl}}
                {{/customloginlogo}}
            </div>
            {{#loginlayoutimg}}
        </div>{{/loginlayoutimg}}
</div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="rui-login-logo-container my-6">
';
                $value = $context->find('loginlayoutimg');
                $buffer .= $this->section981089df6c14b48a079295955714b0e8($context, $indent, $value);
                $buffer .= $indent . '            <div>
';
                $value = $context->find('customloginlogo');
                $buffer .= $this->sectionAe4fc5ca808fc1e29e44cd754ca385bf($context, $indent, $value);
                $buffer .= $indent . '
';
                $value = $context->find('customloginlogo');
                if (empty($value)) {
                    
                    $value = $context->find('logourl');
                    $buffer .= $this->section137322d57e4c88980701719d508da71f($context, $indent, $value);
                    $buffer .= $indent . '
';
                    $value = $context->find('logourl');
                    if (empty($value)) {
                        
                        $buffer .= $indent . '                        <a href="';
                        $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                        $buffer .= ($value === null ? '' : $value);
                        $buffer .= '">
';
                        $buffer .= $indent . '                            <h1 class="rui-login-logo-name">';
                        $value = $this->resolveValue($context->find('sitename'), $context);
                        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                        $buffer .= '</h1>
';
                        $buffer .= $indent . '                        </a>
';
                    }
                }
                $buffer .= $indent . '            </div>
';
                $value = $context->find('loginlayoutimg');
                $buffer .= $this->section8618e343996175e8eea317f67d10daab($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8b519503053752c96ef96a88c644205c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="rui-login-html-1">
        {{{loginhtmlcontent1}}}
    </div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="rui-login-html-1">
';
                $buffer .= $indent . '        ';
                $value = $this->resolveValue($context->find('loginhtmlcontent1'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section54a0550db6819289534ecb1970547b39(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    </div>
    </div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    </div>
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA3539aa03a16bba120c3a557fb675274(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="rui-login-wrapper row no-gutters align-items-center justify-content-center w-100">
        <div class="rui-login-container row no-gutters">

';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="rui-login-wrapper row no-gutters align-items-center justify-content-center w-100">
';
                $buffer .= $indent . '        <div class="rui-login-container row no-gutters">
';
                $buffer .= $indent . '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section78c7558fe34a1190743ac70d6d336ab2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' tocreatenewaccount ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' tocreatenewaccount ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEea1ed30e48185de5a755493672e64a6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="sr-only">
                <a href="{{signupurl}}">{{#str}} tocreatenewaccount {{/str}}</a>
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="sr-only">
';
                $buffer .= $indent . '                <a href="';
                $value = $this->resolveValue($context->find('signupurl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">';
                $value = $context->find('str');
                $buffer .= $this->section78c7558fe34a1190743ac70d6d336ab2($context, $indent, $value);
                $buffer .= '</a>
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9f02bdab39bdb326c592eb1133254d23(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'dark-mode-logo';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'dark-mode-logo';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section873cd556d58ed3a3a108eaa8803cb7b7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<h2><img src="{{customlogindmlogo}}" alt="{{sitename}}" class="rui-custom-dmlogo ml-2 img-fluid" /></h2>';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<h2><img src="';
                $value = $this->resolveValue($context->find('customlogindmlogo'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="rui-custom-dmlogo ml-2 img-fluid" /></h2>';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6eace7c02b06d79590c468bc2f3beb1c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                        <a href="{{{ config.wwwroot }}}">
                            <h2><img src="{{customloginlogo}}" title="{{sitename}}" alt="{{sitename}}" class="rui-login-logo img-fluid" /></h2>
                            {{#customlogindmlogo}}<h2><img src="{{customlogindmlogo}}" alt="{{sitename}}" class="rui-custom-dmlogo ml-2 img-fluid" /></h2>{{/customlogindmlogo}}
                        </a>
                    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                        <a href="';
                $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '">
';
                $buffer .= $indent . '                            <h2><img src="';
                $value = $this->resolveValue($context->find('customloginlogo'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" title="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="rui-login-logo img-fluid" /></h2>
';
                $buffer .= $indent . '                            ';
                $value = $context->find('customlogindmlogo');
                $buffer .= $this->section873cd556d58ed3a3a108eaa8803cb7b7($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                        </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCf7d462e4ae082ad14f470def20cac43(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                            <a href="{{{ config.wwwroot }}}">
                                <h2><img src="{{logourl}}" title="{{sitename}}" alt="{{sitename}}" class="rui-login-logo img-fluid" /></h2>
                            </a>
                        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                            <a href="';
                $value = $this->resolveValue($context->findDot('config.wwwroot'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '">
';
                $buffer .= $indent . '                                <h2><img src="';
                $value = $this->resolveValue($context->find('logourl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" title="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" alt="';
                $value = $this->resolveValue($context->find('sitename'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" class="rui-login-logo img-fluid" /></h2>
';
                $buffer .= $indent . '                            </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDaa09534cb1a02048b62e6ece5c27478(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="rui-loginpage-intro-content mb-3 text-center">
                    {{{loginintrotext}}}
                </div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="rui-loginpage-intro-content mb-3 text-center">
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('loginintrotext'), $context);
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

    private function section933ce9572b034298e4d285f7ea3a4498(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="loginerrors mt-3">
                <a href="#" id="loginerrormessage" class="accesshide">{{error}}</a>
                <div class="alert alert-danger" role="alert" data-aria-autofocus="true">{{error}}</div>
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="loginerrors mt-3">
';
                $buffer .= $indent . '                <a href="#" id="loginerrormessage" class="accesshide">';
                $value = $this->resolveValue($context->find('error'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</a>
';
                $buffer .= $indent . '                <div class="alert alert-danger" role="alert" data-aria-autofocus="true">';
                $value = $this->resolveValue($context->find('error'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</div>
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE384f0e9b1fcc321a1a78dba1d43f63f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' potentialidps, auth ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' potentialidps, auth ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5fc38b71bab296fb0efdd08834d72587(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{name}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCf42e0b69c7a42c2f09de64b78693a8c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                        <img src="{{iconurl}}" alt="" width="24" height="24" />
                                    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                                        <img src="';
                $value = $this->resolveValue($context->find('iconurl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" alt="" width="24" height="24" />
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1118cee0a8ae3559b5fcf310a7e9e687(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                            <div class="rui-potentialidp w-100 mt-1">
                                <a href="{{url}}" title={{#quote}}{{name}}{{/quote}} class="btn btn-outline-secondary mt-1 w-100">
                                    {{#iconurl}}
                                        <img src="{{iconurl}}" alt="" width="24" height="24" />
                                    {{/iconurl}}
                                    <span class="rui-potentialidp--name ml-3">{{name}}</span>
                                </a>
                            </div>
                        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                            <div class="rui-potentialidp w-100 mt-1">
';
                $buffer .= $indent . '                                <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" title=';
                $value = $context->find('quote');
                $buffer .= $this->section5fc38b71bab296fb0efdd08834d72587($context, $indent, $value);
                $buffer .= ' class="btn btn-outline-secondary mt-1 w-100">
';
                $value = $context->find('iconurl');
                $buffer .= $this->sectionCf42e0b69c7a42c2f09de64b78693a8c($context, $indent, $value);
                $buffer .= $indent . '                                    <span class="rui-potentialidp--name ml-3">';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</span>
';
                $buffer .= $indent . '                                </a>
';
                $buffer .= $indent . '                            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section75cd88d39f31b40c2d25d6ba04a8008c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="rui-potentialidplist mt-3 text-center">
                    <p class="small text-center">{{#str}} potentialidps, auth {{/str}}</p>
                    <div class="row no-gutters mt-1">
                        {{#identityproviders}}
                            <div class="rui-potentialidp w-100 mt-1">
                                <a href="{{url}}" title={{#quote}}{{name}}{{/quote}} class="btn btn-outline-secondary mt-1 w-100">
                                    {{#iconurl}}
                                        <img src="{{iconurl}}" alt="" width="24" height="24" />
                                    {{/iconurl}}
                                    <span class="rui-potentialidp--name ml-3">{{name}}</span>
                                </a>
                            </div>
                        {{/identityproviders}}
                    </div>
                    <hr class="hr-small" />
                </div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="rui-potentialidplist mt-3 text-center">
';
                $buffer .= $indent . '                    <p class="small text-center">';
                $value = $context->find('str');
                $buffer .= $this->sectionE384f0e9b1fcc321a1a78dba1d43f63f($context, $indent, $value);
                $buffer .= '</p>
';
                $buffer .= $indent . '                    <div class="row no-gutters mt-1">
';
                $value = $context->find('identityproviders');
                $buffer .= $this->section1118cee0a8ae3559b5fcf310a7e9e687($context, $indent, $value);
                $buffer .= $indent . '                    </div>
';
                $buffer .= $indent . '                    <hr class="hr-small" />
';
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section61edd752a216efa880fe2dde846501ca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{#hasidentityproviders}}
                <div class="rui-potentialidplist mt-3 text-center">
                    <p class="small text-center">{{#str}} potentialidps, auth {{/str}}</p>
                    <div class="row no-gutters mt-1">
                        {{#identityproviders}}
                            <div class="rui-potentialidp w-100 mt-1">
                                <a href="{{url}}" title={{#quote}}{{name}}{{/quote}} class="btn btn-outline-secondary mt-1 w-100">
                                    {{#iconurl}}
                                        <img src="{{iconurl}}" alt="" width="24" height="24" />
                                    {{/iconurl}}
                                    <span class="rui-potentialidp--name ml-3">{{name}}</span>
                                </a>
                            </div>
                        {{/identityproviders}}
                    </div>
                    <hr class="hr-small" />
                </div>
            {{/hasidentityproviders}}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('hasidentityproviders');
                $buffer .= $this->section75cd88d39f31b40c2d25d6ba04a8008c($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section27e9419edc620e0e1872d2a6521f1533(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' username ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' username ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section22141a6741c33f407ef6171795337eec(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' usernameemail ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' usernameemail ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1e043cbc642d77f2f4cb8aed5b9ceeaa(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                            {{#str}} usernameemail {{/str}}
                        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                            ';
                $value = $context->find('str');
                $buffer .= $this->section22141a6741c33f407ef6171795337eec($context, $indent, $value);
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFea69428308e6a733cfeebf7670bdc01(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'username';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'username';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section983b6843353faa33a83a9ec3069863a3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'usernameemail';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'usernameemail';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section118ece6c412804f669c845b43ecc9a01(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{#cleanstr}}usernameemail{{/cleanstr}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('cleanstr');
                $buffer .= $this->section983b6843353faa33a83a9ec3069863a3($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD5af950717b4bc1fe6d28fa56d2272cc(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'checked="checked" ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'checked="checked" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAde9318c94c2f3a55f9a22a57e193ad0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' rememberusername, admin ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' rememberusername, admin ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9ccd7214b3989d576097cc1a7b668780(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                        <div class="rui-rememberpass mt-1 text-right">
                            <label class="custom-control ios-switch pr-0">
                                <input class="ios-switch-control-input form-check-input" type="checkbox" name="rememberusername" id="rememberusername" value="1" {{#username}}checked="checked" {{/username}} />
                                <span class="ios-switch-control-indicator"></span>
                                <label class="rui-rememberusername-text my-0" for="rememberusername">{{#str}} rememberusername, admin {{/str}}</label>
                            </label>
                        </div>
                    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                        <div class="rui-rememberpass mt-1 text-right">
';
                $buffer .= $indent . '                            <label class="custom-control ios-switch pr-0">
';
                $buffer .= $indent . '                                <input class="ios-switch-control-input form-check-input" type="checkbox" name="rememberusername" id="rememberusername" value="1" ';
                $value = $context->find('username');
                $buffer .= $this->sectionD5af950717b4bc1fe6d28fa56d2272cc($context, $indent, $value);
                $buffer .= ' />
';
                $buffer .= $indent . '                                <span class="ios-switch-control-indicator"></span>
';
                $buffer .= $indent . '                                <label class="rui-rememberusername-text my-0" for="rememberusername">';
                $value = $context->find('str');
                $buffer .= $this->sectionAde9318c94c2f3a55f9a22a57e193ad0($context, $indent, $value);
                $buffer .= '</label>
';
                $buffer .= $indent . '                            </label>
';
                $buffer .= $indent . '                        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE056be559d6d01a9bd2bf6f760f8e3e3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' password ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' password ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4e50d9b1632f258e8c10be3e2ed759be(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'password';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'password';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6aa95a7e496f5307b40bee7262bd9321(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'forgotten';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'forgotten';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB15dee8971ab065bf4d6402b60d852be(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'login';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'login';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE42690251cfc0a3486b867f189fb7478(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <hr class="hr-small" />
                <div class="rui-potentialidplist mt-3 text-center">
                    <p class="small text-center">{{#str}} potentialidps, auth {{/str}}</p>
                    <div class="row no-gutters mt-1">
                        {{#identityproviders}}
                            <div class="rui-potentialidp w-100 mt-1">
                                <a href="{{url}}" title={{#quote}}{{name}}{{/quote}} class="btn btn-outline-secondary mt-1 w-100">
                                    {{#iconurl}}
                                        <img src="{{iconurl}}" alt="" width="24" height="24" />
                                    {{/iconurl}}
                                    <span class="rui-potentialidp--name ml-3">{{name}}</span>
                                </a>
                            </div>
                        {{/identityproviders}}
                    </div>
                </div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <hr class="hr-small" />
';
                $buffer .= $indent . '                <div class="rui-potentialidplist mt-3 text-center">
';
                $buffer .= $indent . '                    <p class="small text-center">';
                $value = $context->find('str');
                $buffer .= $this->sectionE384f0e9b1fcc321a1a78dba1d43f63f($context, $indent, $value);
                $buffer .= '</p>
';
                $buffer .= $indent . '                    <div class="row no-gutters mt-1">
';
                $value = $context->find('identityproviders');
                $buffer .= $this->section1118cee0a8ae3559b5fcf310a7e9e687($context, $indent, $value);
                $buffer .= $indent . '                    </div>
';
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section93e4b62aaf677bf7878b06c5ac540671(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'someallowguest';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'someallowguest';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section017c9686023b74877131737c59ff1162(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'loginguest';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'loginguest';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF36b0d394a2e9b714e6f8f26176c07bd(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <hr class="hr-small" />
                <div class="rui-canloginasguest mt-2" title="{{#str}}someallowguest{{/str}}">
                    <p class="small text-center">{{#str}}someallowguest{{/str}}</p>
                    <form action="{{loginurl}}" method="post" id="guestlogin">
                        <input type="hidden" name="logintoken" value="{{logintoken}}">
                        <input type="hidden" name="username" value="guest" />
                        <input type="hidden" name="password" value="guest" />
                        <button class="btn btn-sm btn-outline-secondary w-100" type="submit" id="loginguestbtn">{{#str}}loginguest{{/str}}</button>
                    </form>
                </div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <hr class="hr-small" />
';
                $buffer .= $indent . '                <div class="rui-canloginasguest mt-2" title="';
                $value = $context->find('str');
                $buffer .= $this->section93e4b62aaf677bf7878b06c5ac540671($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '                    <p class="small text-center">';
                $value = $context->find('str');
                $buffer .= $this->section93e4b62aaf677bf7878b06c5ac540671($context, $indent, $value);
                $buffer .= '</p>
';
                $buffer .= $indent . '                    <form action="';
                $value = $this->resolveValue($context->find('loginurl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" method="post" id="guestlogin">
';
                $buffer .= $indent . '                        <input type="hidden" name="logintoken" value="';
                $value = $this->resolveValue($context->find('logintoken'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $buffer .= $indent . '                        <input type="hidden" name="username" value="guest" />
';
                $buffer .= $indent . '                        <input type="hidden" name="password" value="guest" />
';
                $buffer .= $indent . '                        <button class="btn btn-sm btn-outline-secondary w-100" type="submit" id="loginguestbtn">';
                $value = $context->find('str');
                $buffer .= $this->section017c9686023b74877131737c59ff1162($context, $indent, $value);
                $buffer .= '</button>
';
                $buffer .= $indent . '                    </form>
';
                $buffer .= $indent . '                </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section25691dba241246d679ec810645ea6dd8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<hr class="hr-small" />';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<hr class="hr-small" />';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDed7d4dfcbae5fa7e35363db4b4fb007(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                            <p class="small">{{{stringca}}}</p>
                        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                            <p class="small">';
                $value = $this->resolveValue($context->find('stringca'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</p>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFfb26604630b5981f8433074367a2fb2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{^customsignupoutside}}
                <div class="rui-login-createaccount my-4 text-center">
                    {{#canloginasguest}}<hr class="hr-small" />{{/canloginasguest}}
                    <form action="{{signupurl}}" method="get" id="signup">
                        {{#stringca}}
                            <p class="small">{{{stringca}}}</p>
                        {{/stringca}}
                        <button type="submit" class="btn btn-info w-100">{{#str}}startsignup{{/str}}</button>
                    </form>
                </div>
            {{/customsignupoutside}}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('customsignupoutside');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                <div class="rui-login-createaccount my-4 text-center">
';
                    $buffer .= $indent . '                    ';
                    $value = $context->find('canloginasguest');
                    $buffer .= $this->section25691dba241246d679ec810645ea6dd8($context, $indent, $value);
                    $buffer .= '
';
                    $buffer .= $indent . '                    <form action="';
                    $value = $this->resolveValue($context->find('signupurl'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" method="get" id="signup">
';
                    $value = $context->find('stringca');
                    $buffer .= $this->sectionDed7d4dfcbae5fa7e35363db4b4fb007($context, $indent, $value);
                    $buffer .= $indent . '                        <button type="submit" class="btn btn-info w-100">';
                    $value = $context->find('str');
                    $buffer .= $this->section47f819a53e4575a4e7767be1939ab3bf($context, $indent, $value);
                    $buffer .= '</button>
';
                    $buffer .= $indent . '                    </form>
';
                    $buffer .= $indent . '                </div>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB04a755359b8decd99f921ec3a015a80(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="rui-login-bottom-block">
                {{{loginhtmlblockbottom}}}
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="rui-login-bottom-block">
';
                $buffer .= $indent . '                ';
                $value = $this->resolveValue($context->find('loginhtmlblockbottom'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC57e734f8756db360cd536f10f79013c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="rui-hasinstructions-desc alert alert-info">
                {{{instructions}}}
            </div><!-- .rui-hasinstructions-desc -->
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="rui-hasinstructions-desc alert alert-info">
';
                $buffer .= $indent . '                ';
                $value = $this->resolveValue($context->find('instructions'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '            </div><!-- .rui-hasinstructions-desc -->
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9629e66a46d9a0ade8169700e014717f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="rui-login-html-3">
                    {{{loginhtmlcontent3}}}
                </div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="rui-login-html-3">
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('loginhtmlcontent3'), $context);
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

    private function section8870855cdcd93bd920a015acd41a4013(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                <div class="rui-login-footer-content text-center mb-2">
                    <hr class="hr-small" />
                    {{{loginfootercontent}}}
                </div>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                <div class="rui-login-footer-content text-center mb-2">
';
                $buffer .= $indent . '                    <hr class="hr-small" />
';
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('loginfootercontent'), $context);
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

    private function sectionA0f57f9988f6ef94f3119d4e15f5b78b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'sitemaintenance, core_admin';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'sitemaintenance, core_admin';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section930aebc1634e5f15f371ff056c4205fb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="rui-maintenance alert alert-warning wrapper-md my-4 p-5">
        <h2>{{#str}}sitemaintenance, core_admin{{/str}}</h2>
        <div class="rui-maintenance-desc">
            {{{maintenance}}}
        </div>
    </div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="rui-maintenance alert alert-warning wrapper-md my-4 p-5">
';
                $buffer .= $indent . '        <h2>';
                $value = $context->find('str');
                $buffer .= $this->sectionA0f57f9988f6ef94f3119d4e15f5b78b($context, $indent, $value);
                $buffer .= '</h2>
';
                $buffer .= $indent . '        <div class="rui-maintenance-desc">
';
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->find('maintenance'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '        </div>
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCe78dfd96ff4a3d7b400717a56db0454(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="rui-login-additional-content">
                {{{loginhtmlcontent2}}}
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="rui-login-additional-content">
';
                $buffer .= $indent . '                ';
                $value = $this->resolveValue($context->find('loginhtmlcontent2'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE07730468bce6a85be028569c6c04566(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="rui-login-bg-container" style="background-image: url(\'{{loginbg}}\');">
        {{#loginhtmlcontent2}}
            <div class="rui-login-additional-content">
                {{{loginhtmlcontent2}}}
            </div>
        {{/loginhtmlcontent2}}
    </div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="rui-login-bg-container" style="background-image: url(\'';
                $value = $this->resolveValue($context->find('loginbg'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '\');">
';
                $value = $context->find('loginhtmlcontent2');
                $buffer .= $this->sectionCe78dfd96ff4a3d7b400717a56db0454($context, $indent, $value);
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6adba27f3b0ac9e498cf0ff6f546f425(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="rui-login-footer rui-login-footer-content">
                {{{loginhtmlcontent3}}}
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="rui-login-footer rui-login-footer-content">
';
                $buffer .= $indent . '                ';
                $value = $this->resolveValue($context->find('loginhtmlcontent3'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC6399af2b211488dfbf44af5cde966df(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="rui-login-footer text-center">
                {{{loginfootercontent}}}
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="rui-login-footer text-center">
';
                $buffer .= $indent . '                ';
                $value = $this->resolveValue($context->find('loginfootercontent'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9043df10a525c4dae20b27fb95e8cd66(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="rui-login-wrapper">
        {{#loginhtmlcontent3}}
            <div class="rui-login-footer rui-login-footer-content">
                {{{loginhtmlcontent3}}}
            </div>
        {{/loginhtmlcontent3}}

        {{#loginfootercontent}}
            <div class="rui-login-footer text-center">
                {{{loginfootercontent}}}
            </div>
        {{/loginfootercontent}}

    </div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="rui-login-wrapper">
';
                $value = $context->find('loginhtmlcontent3');
                $buffer .= $this->section6adba27f3b0ac9e498cf0ff6f546f425($context, $indent, $value);
                $buffer .= $indent . '
';
                $value = $context->find('loginfootercontent');
                $buffer .= $this->sectionC6399af2b211488dfbf44af5cde966df($context, $indent, $value);
                $buffer .= $indent . '
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFcb729cc74d31bce5e3746aa60b79a2e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'cookiesnotice';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'cookiesnotice';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section691cc2f9954bba7bfc6c89b209875ecc(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            var userNameField = document.getElementById(\'username\');
            if (userNameField.value.length == 0) {
                userNameField.focus();
            } else {
                document.getElementById(\'password\').focus();
            }
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            var userNameField = document.getElementById(\'username\');
';
                $buffer .= $indent . '            if (userNameField.value.length == 0) {
';
                $buffer .= $indent . '                userNameField.focus();
';
                $buffer .= $indent . '            } else {
';
                $buffer .= $indent . '                document.getElementById(\'password\').focus();
';
                $buffer .= $indent . '            }
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEb31e0a905855a4df03d13e2bbd239e8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        document.getElementById(\'loginerrormessage\').focus();
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        document.getElementById(\'loginerrormessage\').focus();
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF134befbc907907019eac63cfee377f3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            Submit.init("loginguestbtn");
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            Submit.init("loginguestbtn");
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section09809d8efd02426f89327b1e00eb5c27(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{^error}}
        {{#autofocusform}}
            var userNameField = document.getElementById(\'username\');
            if (userNameField.value.length == 0) {
                userNameField.focus();
            } else {
                document.getElementById(\'password\').focus();
            }
        {{/autofocusform}}
    {{/error}}
    {{#error}}
        document.getElementById(\'loginerrormessage\').focus();
    {{/error}}
    require([\'core_form/submit\'], function(Submit) {
        Submit.init("loginbtn");
        {{#canloginasguest}}
            Submit.init("loginguestbtn");
        {{/canloginasguest}}
    });
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('error');
                if (empty($value)) {
                    
                    $value = $context->find('autofocusform');
                    $buffer .= $this->section691cc2f9954bba7bfc6c89b209875ecc($context, $indent, $value);
                }
                $value = $context->find('error');
                $buffer .= $this->sectionEb31e0a905855a4df03d13e2bbd239e8($context, $indent, $value);
                $buffer .= $indent . '    require([\'core_form/submit\'], function(Submit) {
';
                $buffer .= $indent . '        Submit.init("loginbtn");
';
                $value = $context->find('canloginasguest');
                $buffer .= $this->sectionF134befbc907907019eac63cfee377f3($context, $indent, $value);
                $buffer .= $indent . '    });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
