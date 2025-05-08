import {
  totalAnimationTime,
  resetItoastTimes,
  itoastShake,
  setItoastTimes,
  userActive,
  pushItoast,
  pushItoastConfirm,
} from "./global.js";

document.addEventListener("DOMContentLoaded", function () {
  resetItoastTimes();
});

document.querySelectorAll(".itoast-inner").forEach((inner) => {
  const itoast = inner.querySelector(".itoast");
  itoastShake(itoast);
  setItoastTimes(itoast);
  userActive(inner, itoast, totalAnimationTime, 0);
});

document.addEventListener("click", function (e) {
  const toastBtn = e.target.closest(".push-itoast-btn");
  const confirmBtn = e.target.closest(".push-confirm-btn");
  if (!toastBtn || !confirmBtn) return;

  if (toastBtn) {
    const type =
      toastBtn.dataset.type ||
      toastBtn.dataset.theme ||
      configItoast.default_theme;
    const title = toastBtn.dataset.title || type;
    const message =
      toastBtn.dataset.message || configItoast.default_message || null;
    const duration = toastBtn.dataset.duration || null;
    const pin = toastBtn.dataset.pin || null;
    const emoji = toastBtn.dataset.emoji || null;
    const icon = toastBtn.dataset.icon || null;
    const actions = toastBtn.dataset.actions || null;

    pushItoast({
      type: type,
      title: title,
      message: message,
      duration: duration,
      emoji: emoji,
      icon: icon,
      pin: pin,
      actions: JSON.parse(actions) || null,
    });
  }

  if (confirmBtn) {
    e.preventDefault();

    const isForm = confirmBtn.tagName === "FORM";

    const type =
      confirmBtn.dataset.type ||
      confirmBtn.dataset.theme ||
      configItoast.default_theme;
    const title =
      confirmBtn.dataset.title || configItoast.default_confirm_title || type;
    const message =
      confirmBtn.dataset.message ||
      configItoast.default_confirm_message ||
      null;
    const pin = confirmBtn.dataset.pin || null;
    const emoji = confirmBtn.dataset.emoji || null;
    const icon = confirmBtn.dataset.icon || null;
    const onconfirm =
      confirmBtn.dataset.onconfirm ||
      configItoast.default_onconfirm_text ||
      "Yes";
    const onconfirmLink = confirmBtn.dataset.onconfirmlink || "#";
    const oncancel =
      confirmBtn.dataset.oncancel || configItoast.default_oncancel_text || "No";
    const actions = confirmBtn.dataset.actions || null;

    const proceed = () => {
      if (isForm) {
        confirmBtn.submit();
      } else {
        // Trigger native click if it's just a button (e.g., inside a form)
        confirmBtn.dispatchEvent(
          new Event("confirmed-click", { bubbles: true })
        );
      }
    };

    pushItoastConfirm({
      type: type,
      title: title,
      message: message,
      pin: pin,
      emoji: emoji,
      icon: icon,
      onconfirm: onconfirm,
      onconfirmLink: onconfirmLink,
      oncancel: oncancel,
      actions: JSON.parse(actions) || null,
      onConfirmCallback: proceed,
    });
  }
});
