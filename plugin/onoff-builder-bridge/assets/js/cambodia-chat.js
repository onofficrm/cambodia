(function () {
  'use strict';

  var cfg = window.__CAMBODIA_CHAT__ || {};
  var SITE_KEY = cfg.siteKey || '';
  var IFRAME_ID = cfg.iframeId || (SITE_KEY ? 'chat-icrm-widget-' + SITE_KEY.replace(/[^a-zA-Z0-9_-]/g, '') : '');
  var ORIGIN = cfg.origin || 'https://chat.icrm.co.kr';

  function getChatIframe() {
    if (IFRAME_ID) {
      return document.getElementById(IFRAME_ID);
    }
    return document.querySelector('iframe[id^="chat-icrm-widget-"]');
  }

  function openChat() {
    var iframe = getChatIframe();
    if (!iframe) {
      return false;
    }

    try {
      if (iframe.contentWindow) {
        iframe.contentWindow.postMessage({ type: 'chat_icrm_open' }, ORIGIN);
      }
    } catch (e) {
      /* ignore */
    }

    var src = iframe.getAttribute('src') || '';
    if (src.indexOf('open=1') === -1) {
      var join = src.indexOf('?') >= 0 ? '&' : '?';
      iframe.src = src + join + 'open=1&open_ts=' + Date.now();
    }

    iframe.style.zIndex = '2147483647';
    iframe.style.pointerEvents = 'auto';
    return true;
  }

  window.onoffOpenChat = openChat;

  function isChatTrigger(el) {
    if (!el || !el.closest) {
      return null;
    }
    return el.closest('[data-onoff-chat], [data-onlycebu-chat], a[href="#contact"]');
  }

  document.addEventListener(
    'click',
    function (e) {
      var trigger = isChatTrigger(e.target);
      if (!trigger) {
        return;
      }
      e.preventDefault();
      openChat();
    },
    true
  );

  document.addEventListener('DOMContentLoaded', function () {
    var iframe = getChatIframe();
    if (iframe) {
      iframe.style.zIndex = '2147483647';
    }
  });
})();
