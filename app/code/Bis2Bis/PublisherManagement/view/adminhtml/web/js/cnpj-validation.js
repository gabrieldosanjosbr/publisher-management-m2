require(
    [
        'Magento_Ui/js/lib/validation/validator',
        'jquery',
        'mage/translate'
    ], function(validator, $){
        validator.addRule(
            'cnpj-validation',
            function (value) {
                console.log((/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/.test(value)));
                return (/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/.test(value));
            },
            $.mage.__('CNPJ field invalid.')
        );
    });
