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
      o.style.cssText = 'position:fixed;inset:0;z-index:2100;display:grid;place-items:center;background:rgba(3,6,15,.72);backdrop-filter:blur(4px);padding:16px';
      o.innerHTML = '<div style="width:min(420px,100%);background:linear-gradient(180deg,#131f4c,#0d173a);border:1px solid rgba(255,255,255,.16);border-radius:22px;padding:24px;box-shadow:0 40px 90px -30px #000;color:#eaf0ff">' +
        '<h3 style="margin:0 0 8px;font-size:18px">' + esc(opts.title || 'Una uhakika?') + '</h3>' +
        '<p style="margin:0 0 20px;color:#94a3cf">' + esc(opts.text || '') + '</p>' +
        '<div style="display:flex;gap:10px;justify-content:flex-end"><button type="button" class="pbtn pbtn-ghost" data-r="0">Ghairi</button>' +
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

  window.AF = { toast: toast, confirm: confirmBox, api: api, esc: esc, csrf: csrf };
})();
