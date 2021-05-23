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

    var $document = $(document);

    var Scrape = function() {

        // get base group
        var baseGroup = $document.find("#poecBase1Selector > div.choice.med_shadow").text();

        // get base
        var base = $document.find("#poecBase2Selector > div.choice.med_shadow").text();

        // prefixes
        var $prefixesCol = $document.find('div#poecPrefixesCol');

        // suffixes
        var $suffixesCol = $document.find('div#poecSuffixesCol');


        var getItems = function() {

            var get = function() {
                var items = [];
                $document.find("#poecBase3Selector > div.choices > .base:not(.none):visible").each(function(index, $item){
                    items.push($($item).text());
                });
                return items;
            }

            var $itemSelector = $document.find('#poecBase3Selector');
            if (!$itemSelector.hasClass('selecting')) {
                $itemSelector.children('.choice[onclick]').click();
            }

            return get();
        }

        var getColAffixGroups = function($col) {
            var $mgrps = $col.find('.agroup.mgrp');
            if (!$mgrps.length) return;

            // groupName
            var getGroupName = function($mgrp) {
                return $($mgrp).children('.header').children('.label').children('div').text();
            }

            var getAffixData = function($mainAffix, $mgrp) {
                $mainAffix = $($mainAffix);
                // console.log('$mainAffix', $mainAffix);

                // tiers under this main affix.
                var tiers = [];
                $($mgrp).children('.affix[aid="'+ $mainAffix.attr('aid') +'"]:not(.main)').each(function(index, $tier){
                    $tier = $($tier);
                    tiers.push({
                        name: $tier.children('.label').children('div').text(),
                        tier: $tier.children('.right:nth-child(2)').children('div').text(),
                        ilvl: $tier.children('.right:nth-child(3)').children('div').text(),
                    });
                });

                var getName = function() {
                    $mainAffix = $($mainAffix);
                    return $mainAffix.children('.label').children('div').contents().filter(function() {
                        return this.nodeType == Node.TEXT_NODE;
                    }).text();

                    if ($mainAffix.children('.mvico:first-child').length) {
                        return $mainAffix.children('.label').children('div').contents().get(1).nodeValue;
                    } else {
                        return $mainAffix.children('.label').children('div').contents().get(0).nodeValue;
                    }
                }

                return {
                    name: getName($mainAffix),
                    coeAffixID: $mainAffix.attr('aid'),
                    aModGrp: $mainAffix.attr('amodgrp'),
                    // numberOfTiers: $mainAffix.attr('untier'),
                    tiers: tiers
                }

            }

            var getAffixes = function($mgrp) {
                var $mainAffixes = $($mgrp).children('.affix.main');

                var affixesData = [];
                $mainAffixes.each(function(index, $mainAffix){
                    affixesData.push(getAffixData($mainAffix, $mgrp));
                });
                return affixesData;
            }

            // loop through each affix group
            // groups are Base affixes, Influences affixes, Veiled affixes, Essense affixes, etc.
            var groups = [];

            $mgrps.each(function(index, $mgrp) {
                groups.push({
                    groupName: getGroupName($mgrp),
                    affixes: getAffixes($mgrp)
                });

            });
            return groups;
        };

        return {
            scrape: function() {
                return {
                    baseGroup: baseGroup,
                    base: base,
                    items: getItems(),
                    prefixes: getColAffixGroups($prefixesCol),
                    suffixes: getColAffixGroups($suffixesCol),
                }
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
            var data = Scrape().scrape();
            console.log('data', data);
        });
    }

    $(document).ready(addButton);

})(window, document, jQuery);