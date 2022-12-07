'use strict';

function generateData(name, phone = null, email = null, ipData = {}) {
  const { hostname, pathname } = window.location;
  const url = `${hostname}${pathname}`;
  const action_source = `${window.location.origin}${window.location.pathname}`;
  let data = {
    google_id: readCookie('_ga'),
    name: name,
    phone: phone,
    email: email,
    product_name: window.productName,
    product_id: window.productId,
    Potential_Category: 'Course',
    Projects: 'GoIT',
    Course: window.productId,
    website: 'marathon',
    logURL: url,
    leadFormat: window.leadFormat || 'marathon',
    leadActionSource: action_source,
    leadUserAgent: window.navigator.userAgent,
    leadFBP: getCookie('_fbp'),
    leadFBC: getCookie('_fbc'),
    leadIP: ipData.ip || '',
    leadapi: "MarLeadAPI",
  };
  return ensureUtmData(data);
}
function ensureUtmData(data) {
  data.utm_source = getCookie('utm_source');
  data.utm_medium = getCookie('utm_medium');
  data.utm_term = getCookie('utm_term');
  data.utm_campaign = getCookie('utm_campaign');
  data.utm_content = getCookie('utm_content');

  return data;
}
function send(data) {
  return fetch(themeVar.CRM, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  });
}
function getCookie(name) {
  var nameEQ = name + '=';
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}
function readCookie(name) {
  let nameEQ = name + '=';
  let ca = document.cookie.split(';');
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) === 0) {
      let cidLong = c.substring(nameEQ.length, c.length);
      let tmp = cidLong.split('.');
      return tmp[2] + '.' + tmp[3];
    }
  }
  return null;
}
function submit(name, phone = null, email = null, ipData = {}) {
  let data = generateData(name, phone, email, ipData);

  return send(data);
}
export default {
  submit,
  generateData,
};
