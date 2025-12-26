<?php

class __Mustache_c7c8982ca5a99d21ff0bee87d3e55539 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $this->resolveValue($context->findDot('output.doctype'), $context);
        $buffer .= $indent . ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '<html ';
        $value = $this->resolveValue($context->findDot('output.htmlattributes'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= ' ';
        $value = $context->find('darkmodeon');
        $buffer .= $this->sectionA9a7e73ef034d13acceee012944fd632($context, $indent, $value);
        $buffer .= '>
';
        $buffer .= $indent . '<head>
';
        $buffer .= $indent . '    <title>';
        $value = $this->resolveValue($context->findDot('output.page_title'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '</title>
';
        $buffer .= $indent . '
';
        $value = $context->find('themeauthor');
        $buffer .= $this->section3f3fbc9011d8ffffa94b332d924d42ab($context, $indent, $value);
        $buffer .= $indent . '
';
        $buffer .= $indent . '    ';
        $value = $context->find('seometadesc');
        $buffer .= $this->section911f0122e1af5e081fb765d350d5f608($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '    <meta name="theme-color" content="';
        $value = $this->resolveValue($context->find('seothemecolor'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $value = $context->find('seothemecolor');
        if (empty($value)) {
            
            $buffer .= '#fff';
        }
        $buffer .= '">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <link rel="shortcut icon" href="';
        $value = $this->resolveValue($context->findDot('output.favicon'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '" />
';
        $buffer .= $indent . '    ';
        $value = $context->find('seoappletouchicon');
        $buffer .= $this->section51d2aab02794407c1086dba01236c39c($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    ';
        $value = $this->resolveValue($context->findDot('output.standard_head_html'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '    <meta name="viewport" content="width=device-width, initial-scale=1.0">
';
        $buffer .= $indent . '
';
        $value = $context->find('fontfiles');
        if (empty($value)) {
            
            $value = $context->find('googlefonturl');
            $buffer .= $this->section927dda6b50ae9364ea2d40f00ce0d04d($context, $indent, $value);
        }
        $buffer .= $indent . '
';
        $value = $context->find('fontawesome');
        $buffer .= $this->section472f17a2e5f183439dd45bc13c0977f4($context, $indent, $value);
        $buffer .= $indent . '
';
        $value = $context->find('isfrontpage');
        $buffer .= $this->sectionDd4ff11cf5abe0e71d3634117cd2b11d($context, $indent, $value);
        $buffer .= $indent . '    
';
        $buffer .= $indent . '    
';
        $buffer .= $indent . '<!-- PWA Block 1 -->
';
        $buffer .= $indent . '<meta name="color-scheme" content="dark light">
';
        $buffer .= $indent . '<meta name="theme-color" content="#FFFFFF">
';
        $buffer .= $indent . '<meta name="mobile-web-app-capable" content="yes">
';
        $buffer .= $indent . '<meta name="application-name" content="Latingles">
';
        $buffer .= $indent . '<link rel="apple-touch-icon" href="/img/pwa/apple-touch-icon.png">
';
        $buffer .= $indent . '<link rel="stylesheet" href="/css/pwa.css">
';
        $buffer .= $indent . '<meta name="apple-mobile-web-app-capable" content="yes">
';
        $buffer .= $indent . '<meta name="apple-mobile-web-app-status-bar-style" content="black">
';
        $buffer .= $indent . '<link rel="manifest" href="/manifest.json">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<script src="/js/pwa.js" defer=""></script>
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/img/splash_screens/iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/img/splash_screens/iPhone_15_Pro__iPhone_15__iPhone_14_Pro_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/img/splash_screens/iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/img/splash_screens/iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/img/splash_screens/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/img/splash_screens/iPhone_11_Pro_Max__iPhone_XS_Max_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/img/splash_screens/iPhone_11__iPhone_XR_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)" href="/img/splash_screens/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/img/splash_screens/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/img/splash_screens/4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/img/splash_screens/12.9__iPad_Pro_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/img/splash_screens/11__iPad_Pro__10.5__iPad_Pro_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/img/splash_screens/10.9__iPad_Air_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/img/splash_screens/10.5__iPad_Air_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/img/splash_screens/10.2__iPad_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/img/splash_screens/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 744px) and (device-height: 1133px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="/img/splash_screens/8.3__iPad_Mini_landscape.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/img/splash_screens/iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/img/splash_screens/iPhone_15_Pro__iPhone_15__iPhone_14_Pro_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/img/splash_screens/iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/img/splash_screens/iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/img/splash_screens/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/img/splash_screens/iPhone_11_Pro_Max__iPhone_XS_Max_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/img/splash_screens/iPhone_11__iPhone_XR_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/img/splash_screens/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/img/splash_screens/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/img/splash_screens/4__iPhone_SE__iPod_touch_5th_generation_and_later_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/img/splash_screens/12.9__iPad_Pro_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/img/splash_screens/11__iPad_Pro__10.5__iPad_Pro_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/img/splash_screens/10.9__iPad_Air_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/img/splash_screens/10.5__iPad_Air_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/img/splash_screens/10.2__iPad_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/img/splash_screens/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_portrait.png">
';
        $buffer .= $indent . '<link rel="apple-touch-startup-image" media="screen and (device-width: 744px) and (device-height: 1133px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/img/splash_screens/8.3__iPad_Mini_portrait.png">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '<!-- End PWA Block 1 -->
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    
';
        $buffer .= $indent . '    
';
        $buffer .= $indent . '    
';
        $buffer .= $indent . '</head>
';

        return $buffer;
    }

    private function sectionA9a7e73ef034d13acceee012944fd632(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'class="dark-mode"';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'class="dark-mode"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3f3fbc9011d8ffffa94b332d924d42ab(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <!--

      Theme: alpha Moodle Theme
      Author: Marcin Czaja - Rosea Themes (rosea.io)
      Version: 2.4.4

      Copyright © 2022 - 2023

    -->
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <!--
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '      Theme: alpha Moodle Theme
';
                $buffer .= $indent . '      Author: Marcin Czaja - Rosea Themes (rosea.io)
';
                $buffer .= $indent . '      Version: 2.4.4
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '      Copyright © 2022 - 2023
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '    -->
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section911f0122e1af5e081fb765d350d5f608(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<meta name="description" content="{{seometadesc}}">';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<meta name="description" content="';
                $value = $this->resolveValue($context->find('seometadesc'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section51d2aab02794407c1086dba01236c39c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<link rel="apple-touch-icon" href="{{seoappletouchicon}}">';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<link rel="apple-touch-icon" href="';
                $value = $this->resolveValue($context->find('seoappletouchicon'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section927dda6b50ae9364ea2d40f00ce0d04d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{{googlefonturl}}}" rel="stylesheet">
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <link rel="preconnect" href="https://fonts.googleapis.com">
';
                $buffer .= $indent . '    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
';
                $buffer .= $indent . '    <link href="';
                $value = $this->resolveValue($context->find('googlefonturl'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" rel="stylesheet">
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section472f17a2e5f183439dd45bc13c0977f4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <link href="{{siteurl}}/theme/alpha/addons/fontawesome/css/all.css" rel="stylesheet">
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <link href="';
                $value = $this->resolveValue($context->find('siteurl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '/theme/alpha/addons/fontawesome/css/all.css" rel="stylesheet">
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDd4ff11cf5abe0e71d3634117cd2b11d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <!-- Swiper JS -->
    <script src="{{siteurl}}/theme/alpha/addons/swiper/swiper-bundle.min.js"></script>
    <script src="{{siteurl}}/theme/alpha/addons/tinyslider/tiny-slider.js"></script>
    <link rel="stylesheet" href="{{siteurl}}/theme/alpha/addons/tinyslider/tiny-slider.css">
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <!-- Swiper JS -->
';
                $buffer .= $indent . '    <script src="';
                $value = $this->resolveValue($context->find('siteurl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '/theme/alpha/addons/swiper/swiper-bundle.min.js"></script>
';
                $buffer .= $indent . '    <script src="';
                $value = $this->resolveValue($context->find('siteurl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '/theme/alpha/addons/tinyslider/tiny-slider.js"></script>
';
                $buffer .= $indent . '    <link rel="stylesheet" href="';
                $value = $this->resolveValue($context->find('siteurl'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '/theme/alpha/addons/tinyslider/tiny-slider.css">
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
