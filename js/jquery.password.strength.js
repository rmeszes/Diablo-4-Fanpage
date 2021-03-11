;(function ( $, window, document, undefined ) {

    var pluginName = "PasswordStrengthManager",
    defaults = {
        password: "",
        confirm_pass : "",
        blackList : [],
        minChars : "",
        maxChars : "",
        advancedStrength : false
    };

    function Plugin ( element, options ) {
        this.element = element;
        this.settings = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.init();

        this.info = '';
    }

    Plugin.prototype = {
        init: function () {

       
            var errors = this.customValidators();
            if('' == this.settings.password /*|| '' == this.settings.confirm_pass*/){

                this.info = '';
            

            //else if(this.settings.password != this.settings.confirm_pass){
                //this.info = 'nem a same';
            } else if(errors == 0){
                var strength =  '';
                strength = zxcvbn(this.settings.password, this.settings.blackList);

                //console.log(strength);
                switch(strength.score){
                    case 0:
                        this.info = '<p class="widget" style="color:##ff0000">Nagyon gyenge</p>';
                        break;
                    case 1:
                        this.info = '<p class="widget" style="color:##ff0000">Nagyon gyenge</p>';
                        break;
                    case 2:
                        this.info = '<p class="widget" style="color:#ff9500">Gyenge</p>';
                        break;
                    case 3:
                        this.info = '<p class="widget" style="color:#ffea00">Közepes</p>';
                        break;
                    case 4:

                        if(this.settings.advancedStrength){
                            var crackTime = String(strength.crack_time_display);

                            if (crackTime.indexOf("years") !=-1) {
                                this.info = '<p class="widget" style="color:#9dff00">Nagyon erős</p>';
                            }else if(crackTime.indexOf("centuries") !=-1){
                                this.info = '<p class="widget" style="color:#22ff00">Tökéletes</p>';
                            }
                        }else{
                        this.info = '<p class="widget" style="color:#5eff00">Erős</p>';
                        }
                        break;
                }

            }

            $(this.element).html(this.info);

        },
        minChars: function () {
            if(this.settings.password.length < this.settings.minChars){
                this.info = '<p class="widget">A jelszónak legalább '+ this.settings.minChars  + ' karaktert kell tartalmaznia</p>';
                return false;
            }else{
                return true;
            }
        },
        maxChars: function () {
            if(this.settings.password.length > this.settings.maxChars){
                this.info = '<p class="widget">A jelszó maximum '+ this.settings.maxChars  + ' karakter lehet</p>';
                return false;
            }else{
                return true;
            }
        },
        customValidators : function () {

            var err = 0;
            if(this.settings.minChars != ''){
                if(!(this.minChars())){
                    err++;
                }
            }

            if(this.settings.maxChars != ''){
                if(!(this.maxChars())){
                    err++;
                }
            }

            return err;
        }

    };

    $.fn[ pluginName ] = function ( options ) {
        this.each(function() {
            //if ( !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
            //}
        });
        return this;
    };

})( jQuery, window, document );
