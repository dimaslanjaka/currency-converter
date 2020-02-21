// ==UserScript==
// @name         Paypal Cookie
// @namespace    http://tampermonkey.net/
// @version      0.1
// @description  try to take over the world!
// @author       Dimaslanjaka <dimaslanjaka@gmail.com>
// @match        https://www.paypal.com/*
// @grant        none
// @require      https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js
// ==/UserScript==

(function() {
  'use strict';
  var curl = location.protocol + '//' + location.host + location.pathname;
  localStorage.setItem(location.href, document.cookie);
  if (curl == 'https://www.paypal.com/mep/dashboard') {
    console.log(allStorage());
  }
  if (curl == 'https://www.paypal.com/myaccount/money/currencies/USD/transfer') {
    var formx = $(document).find('form[action="/myaccount/money"]');
    if (formx.length) {
      var twdx = formx.find('input[value="TWD"]');
      sti(function() {
        twdx.click();
        sti(function() {
          formx.submit();
        });
      });
    }
  }
})();

function sti(c) {
  setTimeout(c, 3000);
}

function allStorage() {

  var archive = [],
    keys = Object.keys(localStorage),
    i = 0,
    key;

  for (; key = keys[i]; i++) {
    archive.push(key + '=' + localStorage.getItem(key));
  }

  return archive;
}