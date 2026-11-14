/**
 * Kalalayaa Admissions Client Engine
 *
 * Handles campus-directed admissions form submissions to the WordPress REST API,
 * presents toast notifications, and dispatches counselor WhatsApp deep links.
 *
 * @package Kalalayaa
 * @author  CharNithi Software Crafts
 */
(function () {
  'use strict';

  window.kalalayaaHandleAdmissionsSubmit = function (e) {
    e.preventDefault();

    var form = e.target;
    var submitBtn = form.querySelector('.m-campus-inquiry__submit');
    var parentName = form.querySelector('[name="parent_name"]');
    var phone = form.querySelector('[name="phone"]');
    var childName = form.querySelector('[name="child_name"]');
    var childAge = form.querySelector('[name="child_age"]');
    var email = form.querySelector('[name="email"]');
    var campusId = form.querySelector('[name="campus_id"]');
    var program = form.querySelector('[name="program"]');
    var notes = form.querySelector('[name="notes"]');

    if (!parentName || !phone || !childName || !childAge) return;

    if (!parentName.value.trim() || !phone.value.trim() || !childName.value.trim() || !childAge.value) {
      showToast('Please fill in all required fields (Parent Name, Mobile, Child Name, Age).', 'error');
      return;
    }

    var payload = {
      parent_name: parentName.value.trim(),
      phone: phone.value.trim(),
      child_name: childName.value.trim(),
      child_age: childAge.value,
      email: email ? email.value.trim() : '',
      campus_id: campusId ? campusId.value : 'kk-nagar',
      program: program ? program.value.trim() : '',
      notes: notes ? notes.value.trim() : ''
    };

    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = 'Submitting Application...';
    }

    var config = window.kalalayaaConfig || {};
    var restUrl = config.restUrl || '/wp-json/kalalayaa/v1/';

    fetch(restUrl + 'inquire', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': config.restNonce || ''
      },
      body: JSON.stringify(payload)
    })
      .then(function (res) {
        return res.json();
      })
      .then(function (data) {
        if (data.success) {
          var firstName = payload.parent_name.split(' ')[0];
          showToast(
            'Thank you, ' + firstName + '! ' + data.counselor + ' has received your application for ' + data.campus + '. Ref: ' + data.inquiry_id,
            'success'
          );
          form.reset();

          if (data.whatsapp_link) {
            setTimeout(function () {
              window.open(
                data.whatsapp_link +
                  '?text=' +
                  encodeURIComponent(
                    'Hello ' + data.counselor + '! I just submitted an inquiry for my child ' + payload.child_name + ' (Ref: ' + data.inquiry_id + '). Looking forward to visiting ' + data.campus + '!'
                  ),
                '_blank'
              );
            }, 1800);
          }
        } else {
          showToast(data.message || 'Unable to submit application. Please call admissions directly.', 'error');
        }
      })
      .catch(function () {
        showToast('Network connection error. Please call +91 94431 82910 directly.', 'error');
      })
      .finally(function () {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Submit Admissions Inquiry →';
        }
      });
  };

  function showToast(message, type) {
    var existing = document.querySelector('.m-toast');
    if (existing) existing.remove();

    var toast = document.createElement('div');
    toast.className = 'm-toast m-toast--' + type;
    toast.setAttribute('role', 'alert');
    toast.textContent = message;
    document.body.appendChild(toast);

    requestAnimationFrame(function () {
      toast.classList.add('is-visible');
    });

    setTimeout(function () {
      toast.classList.remove('is-visible');
      setTimeout(function () {
        toast.remove();
      }, 350);
    }, 6000);
  }
})();
