/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery'
], function($) {
    'use strict';

    /**
     * @param {String} url
     * @param {*} fromPages
     */
    function processQuestion(url, fromPages) {
        $.ajax({
            url: url,
            cache: true,
            dataType: 'html',
            showLoader: false,
            loaderContext: $('.product.data.items')
        }).done(function(data) {
            $('#product-questionTab-container').html(data).trigger('contentUpdated');
            $('[data-role="product-questionTab"] .pages a').each(function(index, element) {
                $(element).click(function(event) { //eslint-disable-line max-nested-callbacks
                    processQuestion($(element).attr('href'), true);
                    event.preventDefault();
                });
            });
        }).complete(function() {
            if (fromPages == true) { //eslint-disable-line eqeqeq
                $('html, body').animate({
                    scrollTop: $('#questionTab').offset().top - 50
                }, 300);
            }
        });
    }

    return function(config) {
        var questionTab = $(config.reviewsTabSelector),
            requiredQuestionTabRole = 'tab';

        if (reviewTab.attr('role') === requiredQuestionTabRole && questionTab.hasClass('active')) {
            processQuestion(config.productQuestionUrl, location.hash === '#question');
        } else {
            questionTab.one('beforeOpen', function() {
                processQuestion(config.productQuestionUrl);
            });
        }

        $(function() {
            $('.product-info-main .question-actions a').click(function(event) {
                var anchor, addQuestionBlock;

                event.preventDefault();
                anchor = $(this).attr('href').replace(/^.*?(#|$)/, '');
                addQuestionBlock = $('#' + anchor);

                if (addQuestionBlock.length) {
                    $('.product.data.items [data-role="content"]').each(function(index) { //eslint-disable-line
                        if (this.id == 'question') { //eslint-disable-line eqeqeq
                            $('.product.data.items').tabs('activate', index);
                        }
                    });
                    $('html, body').animate({
                        scrollTop: addQuestionBlock.offset().top - 50
                    }, 300);
                }

            });
        });
    };
});