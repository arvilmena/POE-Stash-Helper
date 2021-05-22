// ==UserScript==
// @name         CraftOfExile.com Mod scraper
// @namespace    http://tampermonkey.net/
// @version      0.1
// @description  try to take over the world!
// @author       You
// @match        https://www.craftofexile.com/*
// @icon         https://www.google.com/s2/favicons?domain=craftofexile.com
// @grant        GM_addStyle
// @run-at       document-idle
// ==/UserScript==

(function(window, document, $, undefined) {

    'use strict';

    var Scrape = function() {

        // get base group
        var baseGroup = $("#poecBase1Selector > div.choice.med_shadow").text();

        // get base
        var base = $("#poecBase2Selector > div.choice.med_shadow").text();

        // prefixes
        var $prefixesCol = $('div#poecPrefixesCol');

        // suffixes
        var $suffixesCol = $('div#poecSuffixesCol');


        var getColAffixGroups = function($col) {
            var $mgrps = $col.find('.agroup.mgrp');
            if (!$mgrps.length) return;

            // groupName
            var getGroupName = function($mgrp) {
                return $mgrp.find('& > .header > .label > div').text();
            }

            var getAffixes = function($mgrp) {
                return [];
            }

            $mgrps.forEach(function($mgrp) {

                return {
                    groupName: getGroupName($mgrp),
                    affixes: getAffixes($mgrp)
                }

            });
        };

        return {
            run: function() {
                console.log('baseGroup', baseGroup);
                console.log('base', base);
                console.log('$prefixesCol', $prefixesCol);
                console.log('$suffixesCol', $suffixesCol);
            }
        }
    }

    // add button;
    var addButton = function() {
        var r = $('<input type="button" value="SCRAPE"/>');
        r.css({
            position: "fixed",
            top: 0,
            right: 0,
            zIndex: 9999999
        });
        $("body").append(r);

        r.click(function() {
            Scrape().run();
        });
    }

    $(document).ready(addButton);

})(window, document, jQuery);