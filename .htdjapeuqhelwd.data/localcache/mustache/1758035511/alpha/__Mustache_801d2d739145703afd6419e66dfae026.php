<?php

class __Mustache_801d2d739145703afd6419e66dfae026 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div id="googlemeet_recordings_table">
';
        $buffer .= $indent . '<h4>';
        $value = $context->find('str');
        $buffer .= $this->sectionD04b1ec102a3b1862a7b2bd8f2afcfdd($context, $indent, $value);
        $buffer .= '</h4>
';
        $buffer .= $indent . '  <table class="table table-striped table-hover table-bordered">
';
        $buffer .= $indent . '    <thead>
';
        $buffer .= $indent . '      <tr>
';
        $buffer .= $indent . '        <th style="text-align: center">';
        $value = $context->find('str');
        $buffer .= $this->sectionBe1a76c5f254995b2113cbccac2a47f8($context, $indent, $value);
        $buffer .= '</th>
';
        $buffer .= $indent . '        <th>';
        $value = $context->find('str');
        $buffer .= $this->sectionA788a2454e8106b3c2ac02e3ae27a6df($context, $indent, $value);
        $buffer .= '</th>
';
        $buffer .= $indent . '        <th>';
        $value = $context->find('str');
        $buffer .= $this->section291804084f6b6d69d78426db0b717f91($context, $indent, $value);
        $buffer .= '</th>
';
        $buffer .= $indent . '        <th style="text-align: center">';
        $value = $context->find('str');
        $buffer .= $this->section4fd85af3c955f3c642e20a2a6465129f($context, $indent, $value);
        $buffer .= '</th>
';
        $value = $context->find('visiblee');
        $buffer .= $this->sectionF0b992571aa196c32fa17101d174ed8a($context, $indent, $value);
        $buffer .= $indent . '      </tr>
';
        $buffer .= $indent . '    </thead>
';
        $buffer .= $indent . '    <tbody>
';
        $value = $context->find('recordings');
        $buffer .= $this->sectionEcf9b2d99e97e5a4d7c3450438cc8db5($context, $indent, $value);
        $value = $context->find('recordings');
        if (empty($value)) {
            
            $buffer .= $indent . '        <tr>
';
            $buffer .= $indent . '          ';
            $value = $context->find('visible');
            $buffer .= $this->section886676e10e126606fa971b67f0e1de47($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '          ';
            $value = $context->find('visible');
            if (empty($value)) {
                
                $buffer .= '<td colspan="4">';
            }
            $buffer .= '
';
            $buffer .= $indent . '            <div>
';
            $buffer .= $indent . '              ';
            $value = $context->find('str');
            $buffer .= $this->section29ac06302b013094135e8d966ce9456b($context, $indent, $value);
            $buffer .= '
';
            $buffer .= $indent . '            </div>
';
            $buffer .= $indent . '          </td>
';
            $buffer .= $indent . '        </tr>
';
        }
        $buffer .= $indent . '    </tbody>
';
        $buffer .= $indent . '  </table>
';
        $buffer .= $indent . '  <div id="googlemeet_syncimg">
';
        $buffer .= $indent . '    ';
        $value = $context->find('pix');
        $buffer .= $this->sectionC7108c85e5da4e25c207082657380ae5($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '  </div>
';
        $buffer .= $indent . '</div>
';
        $value = $context->find('js');
        $buffer .= $this->section95e60e28ee0e168fecb91e96eb53865f($context, $indent, $value);
        $buffer .= $indent . '
';

        return $buffer;
    }

    private function sectionD04b1ec102a3b1862a7b2bd8f2afcfdd(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' recordings, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' recordings, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBe1a76c5f254995b2113cbccac2a47f8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' recording, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' recording, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA788a2454e8106b3c2ac02e3ae27a6df(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' name, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' name, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section291804084f6b6d69d78426db0b717f91(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' date, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' date, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4fd85af3c955f3c642e20a2a6465129f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' duration, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' duration, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0037cfb3e06c02dfc4006162cbf6e2d0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' visible, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' visible, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF0b992571aa196c32fa17101d174ed8a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
          <th style="text-align: center">{{# str }} visible, mod_googlemeet {{/ str }}</th>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '          <th style="text-align: center">';
                $value = $context->find('str');
                $buffer .= $this->section0037cfb3e06c02dfc4006162cbf6e2d0($context, $indent, $value);
                $buffer .= '</th>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section336c598a6ab4c73dc5f1b0c72886d2f4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/play, googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' i/play, googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionBc8633d7d308596a6efbcc44bda65972(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'color: red;';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'color: red;';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2df8ce8fc647695ddff0b159fe46e327(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/edit, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' i/edit, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6d706dd7abcde6d31bfe29d917d4fc86(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
              <span style="{{#isEnterClassTopic}}color: red;{{/isEnterClassTopic}}">{{name}}</span>
              <a href="javascript:void(0);" class="recordingeditname" data-id="{{id}}">
                {{# pix }} i/edit, core {{/ pix }}
              </a>
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '              <span style="';
                $value = $context->find('isEnterClassTopic');
                $buffer .= $this->sectionBc8633d7d308596a6efbcc44bda65972($context, $indent, $value);
                $buffer .= '">';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</span>
';
                $buffer .= $indent . '              <a href="javascript:void(0);" class="recordingeditname" data-id="';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $buffer .= $indent . '                ';
                $value = $context->find('pix');
                $buffer .= $this->section2df8ce8fc647695ddff0b159fe46e327($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '              </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC720f8e4d766685cc43781b75f776164(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' hide, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' hide, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7eb986e88bd6d2c23dd0130ab00ec999(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/hide, core, {{# str }} hide, mod_googlemeet {{/ str }} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' i/hide, core, ';
                $value = $context->find('str');
                $buffer .= $this->sectionC720f8e4d766685cc43781b75f776164($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCd233a67bdd66e4471938a742c8bc073(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' {{# pix }} i/hide, core, {{# str }} hide, mod_googlemeet {{/ str }} {{/ pix }} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' ';
                $value = $context->find('pix');
                $buffer .= $this->section7eb986e88bd6d2c23dd0130ab00ec999($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section89cde996c513253881eeae406aa021f4(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' show, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' show, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section44b8fe92f60845a32413bf7057b55610(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/show, core, {{# str }} show, mod_googlemeet {{/ str }} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' i/show, core, ';
                $value = $context->find('str');
                $buffer .= $this->section89cde996c513253881eeae406aa021f4($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section51095d57069e580fb15f365736117f13(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <td style="text-align: center">
              <a href="javascript:void(0);" class="recordinghowhide" data-id="{{id}}">
                {{#visible}} {{# pix }} i/hide, core, {{# str }} hide, mod_googlemeet {{/ str }} {{/ pix }} {{/visible}}
                {{^visible}} {{# pix }} i/show, core, {{# str }} show, mod_googlemeet {{/ str }} {{/ pix }} {{/visible}}
              </a>
            </td>
          ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <td style="text-align: center">
';
                $buffer .= $indent . '              <a href="javascript:void(0);" class="recordinghowhide" data-id="';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $buffer .= $indent . '                ';
                $value = $context->find('visible');
                $buffer .= $this->sectionCd233a67bdd66e4471938a742c8bc073($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                ';
                $value = $context->find('visible');
                if (empty($value)) {
                    
                    $buffer .= ' ';
                    $value = $context->find('pix');
                    $buffer .= $this->section44b8fe92f60845a32413bf7057b55610($context, $indent, $value);
                    $buffer .= ' ';
                }
                $buffer .= '
';
                $buffer .= $indent . '              </a>
';
                $buffer .= $indent . '            </td>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEcf9b2d99e97e5a4d7c3450438cc8db5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <tr {{^visible}} class="warning" {{/visible}}>
          <td style="text-align: center">
            <div>
              <a
                href="{{webviewlink}}"
                id="id_recordingplay"
                class="btn btn-secondary btn-small ml-0"
                onclick="this.target=\'_blank\';"
              >
              {{# pix }} i/play, googlemeet {{/ pix }}
              </a>
            </div>
          </td>
          <td>
            {{#editable}}
              <span style="{{#isEnterClassTopic}}color: red;{{/isEnterClassTopic}}">{{name}}</span>
              <a href="javascript:void(0);" class="recordingeditname" data-id="{{id}}">
                {{# pix }} i/edit, core {{/ pix }}
              </a>
            {{/editable}}
            {{^editable}}
              <span style="{{#isEnterClassTopic}}color: red;{{/isEnterClassTopic}}">{{name}}</span>
            {{/editable}}
          </td>
          <td>{{createdtimeformatted}}</td>
          <td style="text-align: center">{{duration}}</td>
          {{#visiblee}}
            <td style="text-align: center">
              <a href="javascript:void(0);" class="recordinghowhide" data-id="{{id}}">
                {{#visible}} {{# pix }} i/hide, core, {{# str }} hide, mod_googlemeet {{/ str }} {{/ pix }} {{/visible}}
                {{^visible}} {{# pix }} i/show, core, {{# str }} show, mod_googlemeet {{/ str }} {{/ pix }} {{/visible}}
              </a>
            </td>
          {{/visiblee}}
        </tr>
      ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <tr ';
                $value = $context->find('visible');
                if (empty($value)) {
                    
                    $buffer .= ' class="warning" ';
                }
                $buffer .= '>
';
                $buffer .= $indent . '          <td style="text-align: center">
';
                $buffer .= $indent . '            <div>
';
                $buffer .= $indent . '              <a
';
                $buffer .= $indent . '                href="';
                $value = $this->resolveValue($context->find('webviewlink'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"
';
                $buffer .= $indent . '                id="id_recordingplay"
';
                $buffer .= $indent . '                class="btn btn-secondary btn-small ml-0"
';
                $buffer .= $indent . '                onclick="this.target=\'_blank\';"
';
                $buffer .= $indent . '              >
';
                $buffer .= $indent . '              ';
                $value = $context->find('pix');
                $buffer .= $this->section336c598a6ab4c73dc5f1b0c72886d2f4($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '              </a>
';
                $buffer .= $indent . '            </div>
';
                $buffer .= $indent . '          </td>
';
                $buffer .= $indent . '          <td>
';
                $value = $context->find('editable');
                $buffer .= $this->section6d706dd7abcde6d31bfe29d917d4fc86($context, $indent, $value);
                $value = $context->find('editable');
                if (empty($value)) {
                    
                    $buffer .= $indent . '              <span style="';
                    $value = $context->find('isEnterClassTopic');
                    $buffer .= $this->sectionBc8633d7d308596a6efbcc44bda65972($context, $indent, $value);
                    $buffer .= '">';
                    $value = $this->resolveValue($context->find('name'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '</span>
';
                }
                $buffer .= $indent . '          </td>
';
                $buffer .= $indent . '          <td>';
                $value = $this->resolveValue($context->find('createdtimeformatted'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</td>
';
                $buffer .= $indent . '          <td style="text-align: center">';
                $value = $this->resolveValue($context->find('duration'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</td>
';
                $value = $context->find('visiblee');
                $buffer .= $this->section51095d57069e580fb15f365736117f13($context, $indent, $value);
                $buffer .= $indent . '        </tr>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section886676e10e126606fa971b67f0e1de47(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '<td colspan="5">';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '<td colspan="5">';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section29ac06302b013094135e8d966ce9456b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' thereisnorecordingtoshow, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' thereisnorecordingtoshow, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7b57f294a07601d09264a67fe7f993de(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' loading, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' loading, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC7108c85e5da4e25c207082657380ae5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/processing64, googlemeet, {{# str }} loading, mod_googlemeet {{/ str }} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' i/processing64, googlemeet, ';
                $value = $context->find('str');
                $buffer .= $this->section7b57f294a07601d09264a67fe7f993de($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section811ef916274a97618f0500840f25dbf9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' jstablesearch, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' jstablesearch, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section67fbc9610280877b0ef5c5b00e0a75d9(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' jstableperpage, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' jstableperpage, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section31b0bf1d012fef9fe8b4f391785b83d0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' jstablenorows, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' jstablenorows, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF21ca3f14ca321f2991e10bd733d5f91(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' jstableinfo, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' jstableinfo, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section624e84363c23709140505a737b61d5fa(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' jstableloading, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' jstableloading, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section148d4f50935fafd86cb677078f574b6e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' jstableinfofiltered, mod_googlemeet ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' jstableinfofiltered, mod_googlemeet ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section04d1cdb73802d4cd8f364ba978ea377a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/processing16, googlemeet, {{# str }} loading, mod_googlemeet {{/ str }} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' i/processing16, googlemeet, ';
                $value = $context->find('str');
                $buffer .= $this->section7b57f294a07601d09264a67fe7f993de($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0dc01546240a7da73836567fbc07b80f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
      $( document ).ready(function() {
        $(\'.recordingeditname\').on(\'click\', function() {
          var node = $(this).parent();
          var text = $(this).siblings(\'span\');
          var recordingid = $(this).attr(\'data-id\');

          text.hide();
          $(this).hide();

          var inputtext = document.createElement(\'input\');
          inputtext.type = \'text\';
          inputtext.className = \'form-control\';
          inputtext.id = recordingid;
          inputtext.value = text.html();
          inputtext.setAttribute(\'data-value\', text.html());
          inputtext.addEventListener(\'keydown\', recordingeditkeydown);
          inputtext.addEventListener(\'focusout\', recordingeditonfocusout);

          node.append(inputtext);
          inputtext.focus();
          inputtext.select();
        });

        function recordingeditkeydown(event) {
          var keyCode = event.which || event.keyCode;
          if (keyCode === 13) {
            event.currentTarget.removeEventListener(\'focusout\', recordingeditonfocusout);
            recordingeditperform(event.currentTarget);
            return;
          }
          if (keyCode === 27) {
            event.currentTarget.removeEventListener(\'focusout\', recordingeditonfocusout);
            recordingeditonfocusout(event.currentTarget);
          }
        }

        function recordingeditperform(element){
          element = $(element);
          var node = element.parent();
          var text = element.siblings(\'span\');
          var editbutton = element.siblings(\'a\');

          var loading = document.createElement(\'span\');
          loading.innerHTML = \'{{# pix }} i/processing16, googlemeet, {{# str }} loading, mod_googlemeet {{/ str }} {{/ pix }}\';

          text.html(element.val()).show();
          element.hide();
          node.append(loading);

          // Perform the update.
          Ajax.call([{
            methodname: \'mod_googlemeet_recording_edit_name\',
            args: {
              recordingid: element.attr(\'id\'),
              name: element.val(),
              coursemoduleid: {{ coursemoduleid }}
            }
          }])[0].then(function (response) {
            text.html(response.name).show();
            element.remove();
            loading.remove();
            editbutton.show();
            if (text.html() == \'Enter class topic\') {
            text.css(\'color\', \'red\');
            } else {
            text.css(\'color\', \'inherit\');
            }
          }).fail(Notification.exception).fail(function(){
            text.html(element.attr(\'data-value\')).show();
            element.remove();
            loading.remove();
            editbutton.show();
          });
        }

        function recordingeditonfocusout(element) {
          if(element instanceof FocusEvent){
            element = $(this);
          } else {
            element = $(element);
          }

          var node = element.parent();
          var text = element.siblings(\'span\');
          var editbutton = element.siblings(\'a\');
          element.remove();
          text.show();
          editbutton.show();
        }

        $(\'.recordinghowhide\').on(\'click\', function() {
          var recordinghowhide = $(this);
          var recordingid = recordinghowhide.attr(\'data-id\');
          var recordinghowhideoldchild = recordinghowhide.html();

          recordinghowhide.html(\'{{# pix }} i/processing16, googlemeet, {{# str }} loading, mod_googlemeet {{/ str }} {{/ pix }}\');

          Ajax.call([{
            methodname: \'mod_googlemeet_showhide_recording\',
            args: {
              recordingid: recordingid,
              coursemoduleid: {{ coursemoduleid }}
            }
          }])[0].then(function (response) {
            if (response.visible){
              recordinghowhide.html(\'{{# pix }} i/hide, core, {{# str }} hide, mod_googlemeet {{/ str }} {{/ pix }}\');
              recordinghowhide.parent().parent().removeClass(\'warning\');

              return;
            } else {
              recordinghowhide.html(\'{{# pix }} i/show, core, {{# str }} show, mod_googlemeet {{/ str }} {{/ pix }}\');
              recordinghowhide.parent().parent().addClass(\'warning\');

              return;
            }

            recordinghowhide.html(recordinghowhideoldchild);
          }).fail(Notification.exception).fail(function(){
            recordinghowhide.html(recordinghowhideoldchild);
          });
        });
      });
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '      $( document ).ready(function() {
';
                $buffer .= $indent . '        $(\'.recordingeditname\').on(\'click\', function() {
';
                $buffer .= $indent . '          var node = $(this).parent();
';
                $buffer .= $indent . '          var text = $(this).siblings(\'span\');
';
                $buffer .= $indent . '          var recordingid = $(this).attr(\'data-id\');
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '          text.hide();
';
                $buffer .= $indent . '          $(this).hide();
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '          var inputtext = document.createElement(\'input\');
';
                $buffer .= $indent . '          inputtext.type = \'text\';
';
                $buffer .= $indent . '          inputtext.className = \'form-control\';
';
                $buffer .= $indent . '          inputtext.id = recordingid;
';
                $buffer .= $indent . '          inputtext.value = text.html();
';
                $buffer .= $indent . '          inputtext.setAttribute(\'data-value\', text.html());
';
                $buffer .= $indent . '          inputtext.addEventListener(\'keydown\', recordingeditkeydown);
';
                $buffer .= $indent . '          inputtext.addEventListener(\'focusout\', recordingeditonfocusout);
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '          node.append(inputtext);
';
                $buffer .= $indent . '          inputtext.focus();
';
                $buffer .= $indent . '          inputtext.select();
';
                $buffer .= $indent . '        });
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '        function recordingeditkeydown(event) {
';
                $buffer .= $indent . '          var keyCode = event.which || event.keyCode;
';
                $buffer .= $indent . '          if (keyCode === 13) {
';
                $buffer .= $indent . '            event.currentTarget.removeEventListener(\'focusout\', recordingeditonfocusout);
';
                $buffer .= $indent . '            recordingeditperform(event.currentTarget);
';
                $buffer .= $indent . '            return;
';
                $buffer .= $indent . '          }
';
                $buffer .= $indent . '          if (keyCode === 27) {
';
                $buffer .= $indent . '            event.currentTarget.removeEventListener(\'focusout\', recordingeditonfocusout);
';
                $buffer .= $indent . '            recordingeditonfocusout(event.currentTarget);
';
                $buffer .= $indent . '          }
';
                $buffer .= $indent . '        }
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '        function recordingeditperform(element){
';
                $buffer .= $indent . '          element = $(element);
';
                $buffer .= $indent . '          var node = element.parent();
';
                $buffer .= $indent . '          var text = element.siblings(\'span\');
';
                $buffer .= $indent . '          var editbutton = element.siblings(\'a\');
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '          var loading = document.createElement(\'span\');
';
                $buffer .= $indent . '          loading.innerHTML = \'';
                $value = $context->find('pix');
                $buffer .= $this->section04d1cdb73802d4cd8f364ba978ea377a($context, $indent, $value);
                $buffer .= '\';
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '          text.html(element.val()).show();
';
                $buffer .= $indent . '          element.hide();
';
                $buffer .= $indent . '          node.append(loading);
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '          // Perform the update.
';
                $buffer .= $indent . '          Ajax.call([{
';
                $buffer .= $indent . '            methodname: \'mod_googlemeet_recording_edit_name\',
';
                $buffer .= $indent . '            args: {
';
                $buffer .= $indent . '              recordingid: element.attr(\'id\'),
';
                $buffer .= $indent . '              name: element.val(),
';
                $buffer .= $indent . '              coursemoduleid: ';
                $value = $this->resolveValue($context->find('coursemoduleid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '          }])[0].then(function (response) {
';
                $buffer .= $indent . '            text.html(response.name).show();
';
                $buffer .= $indent . '            element.remove();
';
                $buffer .= $indent . '            loading.remove();
';
                $buffer .= $indent . '            editbutton.show();
';
                $buffer .= $indent . '            if (text.html() == \'Enter class topic\') {
';
                $buffer .= $indent . '            text.css(\'color\', \'red\');
';
                $buffer .= $indent . '            } else {
';
                $buffer .= $indent . '            text.css(\'color\', \'inherit\');
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '          }).fail(Notification.exception).fail(function(){
';
                $buffer .= $indent . '            text.html(element.attr(\'data-value\')).show();
';
                $buffer .= $indent . '            element.remove();
';
                $buffer .= $indent . '            loading.remove();
';
                $buffer .= $indent . '            editbutton.show();
';
                $buffer .= $indent . '          });
';
                $buffer .= $indent . '        }
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '        function recordingeditonfocusout(element) {
';
                $buffer .= $indent . '          if(element instanceof FocusEvent){
';
                $buffer .= $indent . '            element = $(this);
';
                $buffer .= $indent . '          } else {
';
                $buffer .= $indent . '            element = $(element);
';
                $buffer .= $indent . '          }
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '          var node = element.parent();
';
                $buffer .= $indent . '          var text = element.siblings(\'span\');
';
                $buffer .= $indent . '          var editbutton = element.siblings(\'a\');
';
                $buffer .= $indent . '          element.remove();
';
                $buffer .= $indent . '          text.show();
';
                $buffer .= $indent . '          editbutton.show();
';
                $buffer .= $indent . '        }
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '        $(\'.recordinghowhide\').on(\'click\', function() {
';
                $buffer .= $indent . '          var recordinghowhide = $(this);
';
                $buffer .= $indent . '          var recordingid = recordinghowhide.attr(\'data-id\');
';
                $buffer .= $indent . '          var recordinghowhideoldchild = recordinghowhide.html();
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '          recordinghowhide.html(\'';
                $value = $context->find('pix');
                $buffer .= $this->section04d1cdb73802d4cd8f364ba978ea377a($context, $indent, $value);
                $buffer .= '\');
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '          Ajax.call([{
';
                $buffer .= $indent . '            methodname: \'mod_googlemeet_showhide_recording\',
';
                $buffer .= $indent . '            args: {
';
                $buffer .= $indent . '              recordingid: recordingid,
';
                $buffer .= $indent . '              coursemoduleid: ';
                $value = $this->resolveValue($context->find('coursemoduleid'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '          }])[0].then(function (response) {
';
                $buffer .= $indent . '            if (response.visible){
';
                $buffer .= $indent . '              recordinghowhide.html(\'';
                $value = $context->find('pix');
                $buffer .= $this->section7eb986e88bd6d2c23dd0130ab00ec999($context, $indent, $value);
                $buffer .= '\');
';
                $buffer .= $indent . '              recordinghowhide.parent().parent().removeClass(\'warning\');
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '              return;
';
                $buffer .= $indent . '            } else {
';
                $buffer .= $indent . '              recordinghowhide.html(\'';
                $value = $context->find('pix');
                $buffer .= $this->section44b8fe92f60845a32413bf7057b55610($context, $indent, $value);
                $buffer .= '\');
';
                $buffer .= $indent . '              recordinghowhide.parent().parent().addClass(\'warning\');
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '              return;
';
                $buffer .= $indent . '            }
';
                $buffer .= $indent . '
';
                $buffer .= $indent . '            recordinghowhide.html(recordinghowhideoldchild);
';
                $buffer .= $indent . '          }).fail(Notification.exception).fail(function(){
';
                $buffer .= $indent . '            recordinghowhide.html(recordinghowhideoldchild);
';
                $buffer .= $indent . '          });
';
                $buffer .= $indent . '        });
';
                $buffer .= $indent . '      });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section95e60e28ee0e168fecb91e96eb53865f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
  require([
    \'jquery\',
    \'core/ajax\',
    \'core/notification\'
    ], function($, Ajax, Notification) {

    {{^hascapability}}
      new JSTable("#googlemeet_recordings_table table", {
        sortable: false,
        searchable: true,
        perPage: 5,
        perPageSelect: false,
        labels: {
          placeholder: "{{# str }} jstablesearch, mod_googlemeet {{/ str }}",
          perPage: "{{# str }} jstableperpage, mod_googlemeet {{/ str }}",
          noRows: "{{# str }} jstablenorows, mod_googlemeet {{/ str }}",
          info: "{{# str }} jstableinfo, mod_googlemeet {{/ str }}",
          loading: "{{# str }} jstableloading, mod_googlemeet {{/ str }}",
          infoFiltered: "{{# str }} jstableinfofiltered, mod_googlemeet {{/ str }}"
        },
      });
    {{/hascapability}}

    {{#hascapability}}
      $( document ).ready(function() {
        $(\'.recordingeditname\').on(\'click\', function() {
          var node = $(this).parent();
          var text = $(this).siblings(\'span\');
          var recordingid = $(this).attr(\'data-id\');

          text.hide();
          $(this).hide();

          var inputtext = document.createElement(\'input\');
          inputtext.type = \'text\';
          inputtext.className = \'form-control\';
          inputtext.id = recordingid;
          inputtext.value = text.html();
          inputtext.setAttribute(\'data-value\', text.html());
          inputtext.addEventListener(\'keydown\', recordingeditkeydown);
          inputtext.addEventListener(\'focusout\', recordingeditonfocusout);

          node.append(inputtext);
          inputtext.focus();
          inputtext.select();
        });

        function recordingeditkeydown(event) {
          var keyCode = event.which || event.keyCode;
          if (keyCode === 13) {
            event.currentTarget.removeEventListener(\'focusout\', recordingeditonfocusout);
            recordingeditperform(event.currentTarget);
            return;
          }
          if (keyCode === 27) {
            event.currentTarget.removeEventListener(\'focusout\', recordingeditonfocusout);
            recordingeditonfocusout(event.currentTarget);
          }
        }

        function recordingeditperform(element){
          element = $(element);
          var node = element.parent();
          var text = element.siblings(\'span\');
          var editbutton = element.siblings(\'a\');

          var loading = document.createElement(\'span\');
          loading.innerHTML = \'{{# pix }} i/processing16, googlemeet, {{# str }} loading, mod_googlemeet {{/ str }} {{/ pix }}\';

          text.html(element.val()).show();
          element.hide();
          node.append(loading);

          // Perform the update.
          Ajax.call([{
            methodname: \'mod_googlemeet_recording_edit_name\',
            args: {
              recordingid: element.attr(\'id\'),
              name: element.val(),
              coursemoduleid: {{ coursemoduleid }}
            }
          }])[0].then(function (response) {
            text.html(response.name).show();
            element.remove();
            loading.remove();
            editbutton.show();
            if (text.html() == \'Enter class topic\') {
            text.css(\'color\', \'red\');
            } else {
            text.css(\'color\', \'inherit\');
            }
          }).fail(Notification.exception).fail(function(){
            text.html(element.attr(\'data-value\')).show();
            element.remove();
            loading.remove();
            editbutton.show();
          });
        }

        function recordingeditonfocusout(element) {
          if(element instanceof FocusEvent){
            element = $(this);
          } else {
            element = $(element);
          }

          var node = element.parent();
          var text = element.siblings(\'span\');
          var editbutton = element.siblings(\'a\');
          element.remove();
          text.show();
          editbutton.show();
        }

        $(\'.recordinghowhide\').on(\'click\', function() {
          var recordinghowhide = $(this);
          var recordingid = recordinghowhide.attr(\'data-id\');
          var recordinghowhideoldchild = recordinghowhide.html();

          recordinghowhide.html(\'{{# pix }} i/processing16, googlemeet, {{# str }} loading, mod_googlemeet {{/ str }} {{/ pix }}\');

          Ajax.call([{
            methodname: \'mod_googlemeet_showhide_recording\',
            args: {
              recordingid: recordingid,
              coursemoduleid: {{ coursemoduleid }}
            }
          }])[0].then(function (response) {
            if (response.visible){
              recordinghowhide.html(\'{{# pix }} i/hide, core, {{# str }} hide, mod_googlemeet {{/ str }} {{/ pix }}\');
              recordinghowhide.parent().parent().removeClass(\'warning\');

              return;
            } else {
              recordinghowhide.html(\'{{# pix }} i/show, core, {{# str }} show, mod_googlemeet {{/ str }} {{/ pix }}\');
              recordinghowhide.parent().parent().addClass(\'warning\');

              return;
            }

            recordinghowhide.html(recordinghowhideoldchild);
          }).fail(Notification.exception).fail(function(){
            recordinghowhide.html(recordinghowhideoldchild);
          });
        });
      });
    {{/hascapability}}
  });
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '  require([
';
                $buffer .= $indent . '    \'jquery\',
';
                $buffer .= $indent . '    \'core/ajax\',
';
                $buffer .= $indent . '    \'core/notification\'
';
                $buffer .= $indent . '    ], function($, Ajax, Notification) {
';
                $buffer .= $indent . '
';
                $value = $context->find('hascapability');
                if (empty($value)) {
                    
                    $buffer .= $indent . '      new JSTable("#googlemeet_recordings_table table", {
';
                    $buffer .= $indent . '        sortable: false,
';
                    $buffer .= $indent . '        searchable: true,
';
                    $buffer .= $indent . '        perPage: 5,
';
                    $buffer .= $indent . '        perPageSelect: false,
';
                    $buffer .= $indent . '        labels: {
';
                    $buffer .= $indent . '          placeholder: "';
                    $value = $context->find('str');
                    $buffer .= $this->section811ef916274a97618f0500840f25dbf9($context, $indent, $value);
                    $buffer .= '",
';
                    $buffer .= $indent . '          perPage: "';
                    $value = $context->find('str');
                    $buffer .= $this->section67fbc9610280877b0ef5c5b00e0a75d9($context, $indent, $value);
                    $buffer .= '",
';
                    $buffer .= $indent . '          noRows: "';
                    $value = $context->find('str');
                    $buffer .= $this->section31b0bf1d012fef9fe8b4f391785b83d0($context, $indent, $value);
                    $buffer .= '",
';
                    $buffer .= $indent . '          info: "';
                    $value = $context->find('str');
                    $buffer .= $this->sectionF21ca3f14ca321f2991e10bd733d5f91($context, $indent, $value);
                    $buffer .= '",
';
                    $buffer .= $indent . '          loading: "';
                    $value = $context->find('str');
                    $buffer .= $this->section624e84363c23709140505a737b61d5fa($context, $indent, $value);
                    $buffer .= '",
';
                    $buffer .= $indent . '          infoFiltered: "';
                    $value = $context->find('str');
                    $buffer .= $this->section148d4f50935fafd86cb677078f574b6e($context, $indent, $value);
                    $buffer .= '"
';
                    $buffer .= $indent . '        },
';
                    $buffer .= $indent . '      });
';
                }
                $buffer .= $indent . '
';
                $value = $context->find('hascapability');
                $buffer .= $this->section0dc01546240a7da73836567fbc07b80f($context, $indent, $value);
                $buffer .= $indent . '  });
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
