define([
        'jquery',
        'jquery/ui',
        'jquery/validate',
        'mage/translate'
    ],
    function($){
        'use strict';
        return function() {
            console.log("Hi");
            $.validator.addMethod( "customvalidation", function (value, element) {
                    return !/<script\b[^>]*>([\s\S]*?)<\/script>/.test(value);
                },
                $.mage.__('SCRIPT tags are not allowed.')
            );
        }
    });