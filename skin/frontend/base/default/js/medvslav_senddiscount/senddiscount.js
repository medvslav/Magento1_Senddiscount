
var clearErrorsSuccess;

document.observe("dom:loaded", function() {
    clearErrorsSuccess = function(){
            $$('#senddiscount_error_msg')[0].visualEffect('Fade',{duration:1});
            $$('#senddiscount_success_msg')[0].visualEffect('Fade',{duration:1});
    };
    
    
    $$('#open_senddiscount_click_button')[0].observe('click', function(){
        Dialog.confirm($$('#senddiscount')[0].innerHTML, {className:"alphacube", 
                                                        width:400,
                                                        height:400,
                                                        okLabel: "send", 
                                                        cancelLabel: "close",
                                                        zIndex:3000,
                                                        onOk:function(win){
                                                           
                                                           if(Validation.validate('senddiscount_first_name') 
                                                               && Validation.validate('senddiscount_surname')  
                                                               && Validation.validate('senddiscount_email')  
                                                               && Validation.validate('senddiscount_phone')){
                                                           
                                                               new Ajax.Request('/senddiscount/index/save', {
                                                                    method: "POST",
                                                                    asynchronous: true,
                                                                    parameters: {
                                                                        first_name: $F('senddiscount_first_name'),
                                                                        surname: $F('senddiscount_surname'),
                                                                        email: $F('senddiscount_email'),
                                                                        phone: $F('senddiscount_phone'),
                                                                        product_id: $F('senddiscount_product_id')
                                                                    },
                                                                    onCreate: function(){
                                                                        $$('#senddiscount_progress')[0].visualEffect('Appear',{duration:1, from:0, to:1} );
                                                                        $$('#senddiscount_error_msg')[0].visualEffect('Fade',{duration:1} );
                                                                        $$('#senddiscount_success_msg')[0].visualEffect('Fade',{duration:1} );
                                                                    },
                                                                    onSuccess: function(response) {
                                                                        $$('#senddiscount_progress')[0].visualEffect('Fade',{duration:1} );
                                                                        var response_obj = response.responseText.evalJSON();
                                                                        if(response_obj.errors && (response_obj.errors.length > 0)){
                                                                          var errors = '';
                                                                          for(i=0;i<response_obj.errors.length;i++){                                                                              
                                                                              errors = errors + response_obj.errors[i] + '<br />';
                                                                          }
                                                                          $$('#senddiscount_error_msg')[0].visualEffect('Appear',{duration:1} ).update(errors);
                                                                        }else if(response_obj.success && (response_obj.success.length > 0)){
                                                                          $$('#senddiscount_success_msg')[0].visualEffect('Appear',{duration:1} ).update(response_obj.success[1]);
                                                                        }
                                                                        Windows.focusedWindow.updateHeight();
                                                                    },

                                                                    onFailure: function(response) {
                                                                        $$('#senddiscount_progress')[0].visualEffect('Fade',{duration:1} );
                                                                        $$('#senddiscount_error_msg')[0].visualEffect('Appear',{duration:1, from:0, to:1} ).update("Something bad happened in the AJAX Request: " + response.status);
                                                                    }
                                                                 });
                                                             } 
                                                            Windows.focusedWindow.updateHeight();
                                                            return false;
                                                           }
                                                        }
         );
                    
    });
         
 
});