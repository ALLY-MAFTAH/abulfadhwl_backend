/* Abul Fadhwl admin — helpers: toasts, confirm dialog, CSRF fetch. */
(function () {
  var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

  function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }

  function toast(msg, type) {
    var box = document.getElementById('af-toasts');
    if (!box) { box = document.createElement('div'); box.id = 'af-toasts'; document.body.appendChild(box); }
    var t = document.createElement('div');
    t.className = 'af-toast ' + (type || 'ok');
    t.innerHTML = '<i class="fas ' + (type === 'err' ? 'fa-exclamation-circle' : 'fa-check-circle') + '"></i><span>' + esc(msg) + '</span>';
    box.appendChild(t);
    setTimeout(function () { t.style.opacity = 0; t.style.transition = 'opacity .3s'; setTimeout(function () { t.remove(); }, 320); }, type === 'err' ? 5200 : 2800);
  }

  function confirmBox(opts) {
    return new Promise(function (resolve) {
      var o = document.createElement('div');
      o.className = 'af-confirm-bg';
      o.innerHTML = '<div class="af-confirm">' +
        '<h3>' + esc(opts.title || 'Una uhakika?') + '</h3>' +
        '<p>' + esc(opts.text || '') + '</p>' +
        '<div class="row-b"><button type="button" class="pbtn pbtn-ghost" data-r="0">Ghairi</button>' +
        '<button type="button" class="pbtn ' + (opts.danger ? 'pbtn-danger' : 'pbtn-gold') + '" data-r="1">' + esc(opts.ok || 'Ndiyo') + '</button></div></div>';
      document.body.appendChild(o);
      function done(v) { o.remove(); resolve(v); }
      o.addEventListener('click', function (e) { var r = e.target.closest('[data-r]'); if (r) done(r.dataset.r === '1'); else if (e.target === o) done(false); });
    });
  }

  function api(url, method, body) {
    var opt = { method: method || 'POST', headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' };
    if (body) { opt.headers['Content-Type'] = 'application/json'; opt.body = JSON.stringify(body); }
    return fetch(url, opt).then(function (r) {
      return r.json().catch(function () { return {}; }).then(function (j) {
        if (!r.ok || j.ok === false) throw new Error(j.error || j.message || 'Hitilafu imetokea (' + r.status + ')');
        return j;
      });
    });
  }

  // Native confirm() on legacy delete links/buttons -> styled dialog
  document.addEventListener('click', function (e) {
    var el = e.target.closest('a[onclick*="confirm("], button[onclick*="confirm("]');
    if (!el || el.dataset.afOk) return;
    var m = (el.getAttribute('onclick') || '').match(/confirm\((['"])([\s\S]*?)\1\)/);
    if (!m) return;
    e.preventDefault(); e.stopImmediatePropagation();
    var del = /delet|futa/i.test(m[2]);
    confirmBox({ title: del ? 'Futa hii?' : 'Una uhakika?', text: m[2], ok: del ? 'Futa' : 'Ndiyo', danger: del }).then(function (y) {
      if (!y) return;
      if (el.tagName === 'A') { location.href = el.href; }
      else { el.dataset.afOk = 1; el.click(); }
    });
  }, true);

  window.AF = { toast: toast, confirm: confirmBox, api: api, esc: esc, csrf: csrf };
})();

/* Show/hide password button on every password field */
(function () {
  var EYE = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
  var OFF = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.9 10.9 0 0 1 12 20C5 20 1 12 1 12a18.5 18.5 0 0 1 5.06-5.94M9.9 4.24A9.1 9.1 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19M14.12 14.12a3 3 0 1 1-4.24-4.24"/><path d="M1 1l22 22"/></svg>';
  function wrap(inp) {
    if (inp.dataset.pwEye) return;
    inp.dataset.pwEye = '1';
    var box = document.createElement('div');
    box.className = 'pw-wrap';
    inp.parentNode.insertBefore(box, inp);
    box.appendChild(inp);
    var b = document.createElement('button');
    b.type = 'button';
    b.className = 'pw-eye';
    b.setAttribute('aria-label', 'Show password');
    b.innerHTML = EYE;
    b.addEventListener('click', function () {
      var show = inp.type === 'password';
      inp.type = show ? 'text' : 'password';
      b.innerHTML = show ? OFF : EYE;
      b.classList.toggle('on', show);
    });
    box.appendChild(b);
  }
  function scan() {
    document.querySelectorAll('input[type="password"]').forEach(wrap);
  }
  document.addEventListener('DOMContentLoaded', scan);
  new MutationObserver(scan).observe(document.documentElement, { childList: true, subtree: true });
})();
