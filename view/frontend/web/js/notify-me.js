/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
 */

define([
    'jquery',
    'mage/url',
    'mage/translate'
], function ($, urlBuilder, $t) {
    'use strict';

    return function (config, element) {
        $(element).on('click', function () {
            $.ajax({
                url: urlBuilder.build('coditronnotifications/front/outofstock'),
                type: 'POST',
                dataType: 'json',
                data: {
                    product_id: config.product_id,
                    product_name: config.product_name
                },
                showLoader: true,
                success: function (response) {
                    if (response.success) {
                        $(element).hide();
                        $('<div/>', {
                            'class': 'success-message',
                            'text': $t('Your request has been successfully sent.')
                        }).insertAfter(element);
                    } else {
                        $('<div/>', {
                            'class': 'error-message',
                            'text': $t('Something went wrong. Please try again later.')
                        }).insertAfter(element);
                    }
                },
                error: function () {
                    $('<div/>', {
                        'class': 'error-message',
                        'text': $t('Unable to send request. Please try again later.')
                    }).insertAfter(element);
                }
            });
        });
    };
});
