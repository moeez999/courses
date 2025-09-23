define(['jquery','core/log','assignsubmission_cloudpoodll/cloudpoodllloader',"core/str"], function($,log,cloudpoodll,str) {
    "use strict"; // jshint ;_;

    log.debug('submission helper: initialising');

    return {

        uploadstate: false,
        togglestate: 0,
        strings: {},


        init:  function(opts) {
            this.component = opts['component'];
            this.safesave=opts['safesave'];

            this.register_controls();
            this.register_events();
            this.setup_recorder();
        },

        setup_recorder: function(){
            var that = this;
            var recorder_callback = function(evt){
                switch(evt.type){
                    case 'recording':
                        if(evt.action==='started'){
                            that.controls.updatecontrol.val();
                            //if opts safe save
                            if(that.safesave==1) {
                                that.controls.formsubmitbutton.attr('disabled', 'disabled');
                            }
                        }
                        break;
                    case 'awaitingprocessing':
                        if(that.uploadstate!='posted') {
                            that.controls.updatecontrol.val(evt.mediaurl);
                            //if opts safe save
                            if(that.safesave==1) {
                                that.controls.formsubmitbutton.removeAttr('disabled', 'disabled');
                            }
                        }
                        that.uploadstate='posted';
                        break;
                    case 'error':
                        alert('PROBLEM:' + evt.message);
                        break;
                }
            };
            cloudpoodll.init(this.component + '_therecorder',recorder_callback);
        },


        register_controls: function(){
          var that=this;
          this.controls={};
          this.controls.formsubmitbutton = $('#id_submitbutton');
          this.controls.deletebutton = $('.' + this.component + '_deletesubmissionbutton');
          this.controls.updatecontrol =  $('#' + this.component + '_updatecontrol');
          this.controls.currentcontainer =  $('.' + this.component + '_currentsubmission');
          this.controls.togglecontainer =  $('.' + this.component + '_togglecontainer');
          this.controls.togglebutton =  $('.' + this.component + '_togglecontainer .togglebutton');
          this.controls.toggletext =  $('.' + this.component + '_togglecontainer .toggletext');
            str.get_string('clicktohide',that.component).done(function(s) {
                that.strings['clicktohide']=s;
            });
            str.get_string('clicktoshow',that.component).done(function(s) {
                that.strings['clicktoshow']=s;
            });
        },

        register_events: function(){
            var that =this;
            this.controls.deletebutton.click(function(){
                if(that.controls.updatecontrol){
                    if(confirm(M.util.get_string('reallydeletesubmission',that.component))){
                        that.controls.updatecontrol.val(-1);
                        that.controls.currentcontainer.html('');
                    }
                }
            });
            this.controls.togglebutton.click(function(){that.toggle_currentsubmission(that);});
            this.controls.toggletext.click(function(){that.toggle_currentsubmission(that);});
        },

        toggle_currentsubmission: function(that){
            var doToggleState = function(){
                if(that.togglestate==0){
                    that.controls.togglebutton.removeClass('fa-toggle-off');
                    that.controls.togglebutton.addClass('fa-toggle-on');
                    that.controls.toggletext.text(that.strings['clicktohide']);
                    that.togglestate=1;
                }else{
                    that.controls.togglebutton.removeClass('fa-toggle-on');
                    that.controls.togglebutton.addClass('fa-toggle-off');
                    that.controls.toggletext.text(that.strings['clicktoshow']);
                    that.togglestate=0;
                }
            };
            that.controls.currentcontainer.toggle(
                {duration: 300, complete: doToggleState}
            );
            return false;
        }
    };//end of return object
});