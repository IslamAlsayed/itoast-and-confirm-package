import { pushItoast, pushItoastConfirm } from "./global.js";

const form = document.querySelector("#custom-toast-form");
const itoastType = form.querySelector("#itoastType");
const emoji = form.querySelector("#emoji");
const icon = form.querySelector("#icon");
const checkbox = form.querySelector(".checkbox");

function toggleConfirmFields(show = false) {
    ["confirm-text", "confirm-link", "cancel-text"].forEach((id) => {
        const el = form.querySelector(`#${id}`)?.parentElement;
        if (el) el.style.display = show ? "block" : "none";
    });

    checkbox.style.display = show ? "none" : "flex";
}

itoastType?.addEventListener("change", () => {
    toggleConfirmFields(itoastType.value == "confirm");
});

function handleEmojiIconDisable() {
    if (emoji.value) {
        icon.setAttribute("disabled", true);
    } else {
        icon.removeAttribute("disabled");
    }

    if (icon.value) {
        emoji.setAttribute("disabled", true);
    } else {
        emoji.removeAttribute("disabled");
    }
}

emoji.addEventListener("keyup", handleEmojiIconDisable);
icon.addEventListener("keyup", handleEmojiIconDisable);

form.addEventListener("submit", (e) => {
    e.preventDefault();

    const data = Object.fromEntries(new FormData(form));
    let actions = null;

    try {
        actions = data.actions ? JSON.parse(data.actions) : null;
    } catch (err) {
        return alert("Invalid JSON in actions field");
    }

    const common = {
        type: data.theme || configItoast.default_theme,
        title: data.title || data.theme || configItoast.default_theme,
        message: data.message || configItoast.default_message || null,
        duration: data.duration || null,
        emoji: data.emoji || null,
        icon: data.icon || null,
        pin: data.pin,
        actions,
    };

    if (data.itoastType == "itoast") {
        pushItoast(common);
    } else {
        pushItoastConfirm({
            ...common,
            onconfirm: data.confirmText,
            onconfirmLink: data.confirmLink,
            oncancel: data.cancelText,
        });
    }
});
