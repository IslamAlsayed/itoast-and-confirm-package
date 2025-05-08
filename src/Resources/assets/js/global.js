export let totalAnimationTime = 0;
export let root = document.documentElement;

export function parseIToastTime(time) {
    if (!time) return 0;
    const match = time.match(/^(\d+(\.\d+)?)([smh])?$/i);

    if (match) {
        const value = parseFloat(match[1]);
        const unit = match[3]?.toLowerCase() ?? "s";

        switch (unit) {
            case "h":
                return value * 60 * 60 * 1000;
            case "m":
                return value * 60 * 1000;
            default:
                return value * 1000;
        }
    }
    return 0;
}

export function resetItoastTimes() {
    root.style.setProperty("--itoast-move", configItoast.move);
    root.style.setProperty("--itoast-enter-time", configItoast.enter_time);
    root.style.setProperty(
        "--itoast-visible-time",
        parseIToastTime(configItoast.visible_time)
    );
    root.style.setProperty("--itoast-exit-time", configItoast.exit_time);
    root.style.setProperty(
        "--itoast-start-delay-time",
        configItoast.start_delay_time
    );
}

export function setItoastTimes(itoast) {
    const baseVisibleTime = parseIToastTime(configItoast.visible_time);
    const enterTime = parseIToastTime(configItoast.enter_time);
    const exitTime = parseIToastTime(configItoast.exit_time);
    const startDelayTime = parseIToastTime(configItoast.start_delay_time);

    const rawDuration = itoast.dataset.duration ?? null;
    const customDuration = parseIToastTime(rawDuration);

    const visibleTime = baseVisibleTime + customDuration;

    totalAnimationTime = startDelayTime + enterTime + exitTime + visibleTime;

    itoast.style.setProperty("--itoast-visible-time", `${visibleTime}ms`);
}

export function shouldAutoRemove(itoast) {
    if (configItoast.move != "enable") return false;
    if (itoast.classList.contains("no_move")) return false;
    if (itoast.classList.contains("forever")) return false;
    if (itoast.classList.contains("pin")) return false;
    if (itoast.classList.contains("confirm-forever")) return false;
    return true;
}

export function itoastShake() {
    let itoastInners = document.querySelectorAll(".itoasts .itoast-inner");

    itoastInners.forEach((inner) => {
        if (inner.querySelector(".itoast.confirm-forever")) {
            if (!document.querySelector(".layer")) {
                let layer = document.createElement("div");
                layer.className = "layer";
                document.body.appendChild(layer);

                layer.addEventListener("click", () => {
                    let _inner = inner.querySelector(".itoast");
                    if (!_inner) return;

                    if (inner.dataset.shaking == "true") return;

                    inner.dataset.shaking = "true";

                    let class_shake = _inner.classList.contains("right")
                        ? "itoast-right-shake"
                        : "itoast-top-shake";

                    inner.classList.remove(class_shake);
                    void inner.offsetWidth;
                    inner.classList.add(class_shake);

                    setTimeout(() => {
                        inner.classList.remove(class_shake);
                        inner.dataset.shaking = "false";
                    }, 700);
                });
            }
        }
    });
}

const toastTimeouts = new Map();
const toastStartTimes = new Map();
const toastPausedTimes = new Map();
const toastPauseStart = new Map();

export function removeToast(_itoastInner) {
    if (!_itoastInner || !_itoastInner.parentNode) return;

    _itoastInner.remove();
    toastTimeouts.delete(_itoastInner);
    toastStartTimes.delete(_itoastInner);
    toastPausedTimes.delete(_itoastInner);
    toastPauseStart.delete(_itoastInner);

    setTimeout(() => {
        const parent = document.querySelector(".itoasts");
        if (parent && parent.children.length == 0) {
            parent.remove();
        }
    }, 125);

    const hasConfirm = document.querySelector(".itoasts .confirm-forever");
    if (!hasConfirm) {
        document.querySelector(".layer")?.remove();
    }
}

export function userActive(itoastInner, itoast, totalAnimationTime, fast = 0) {
    let itoastActions = itoast.querySelectorAll(".itoast-action");

    if (itoastActions.length) {
        itoastActions.forEach((actions) => {
            actions?.addEventListener("click", () => {
                setTimeout(() => removeToast(itoastInner), 125);
            });
        });
    }

    if (shouldAutoRemove(itoast)) {
        const startTime = Date.now();
        toastStartTimes.set(itoastInner, startTime);
        toastPausedTimes.set(itoastInner, 0);

        const id = setTimeout(() => {
            removeToast(itoastInner);
        }, totalAnimationTime - fast);

        toastTimeouts.set(itoastInner, id);
    }

    itoast.addEventListener("mouseenter", () => {
        const id = toastTimeouts.get(itoastInner);
        if (id) {
            clearTimeout(id);
            toastTimeouts.delete(itoastInner);
            toastPauseStart.set(itoastInner, Date.now());
        }
    });

    itoast.addEventListener("mouseleave", () => {
        if (shouldAutoRemove(itoast) && !toastTimeouts.has(itoastInner)) {
            const pauseStart = toastPauseStart.get(itoastInner);
            const pausedTime = toastPausedTimes.get(itoastInner) || 0;
            const now = Date.now();
            const newPausedTime = pausedTime + (now - pauseStart);
            toastPausedTimes.set(itoastInner, newPausedTime);

            const startTime = toastStartTimes.get(itoastInner);
            const elapsed = now - startTime - newPausedTime;
            const remaining = totalAnimationTime - fast - elapsed;

            if (remaining > 0) {
                const id = setTimeout(() => {
                    removeToast(itoastInner);
                }, remaining);
                toastTimeouts.set(itoastInner, id);
            } else {
                removeToast(itoastInner);
            }
        }
    });
}

export function isEmoji(char) {
    const emojiRegex =
        /[\u{1F600}-\u{1F64F}|\u{1F300}-\u{1F5FF}|\u{1F680}-\u{1F6FF}|\u{2600}-\u{26FF}|\u{2700}-\u{27BF}|\u{1F900}-\u{1F9FF}|\u{1FA70}-\u{1FAFF}]/u;
    return emojiRegex.test(char);
}

function getOrCreateItoasts() {
    let container = document.querySelector(".itoasts");
    if (!container) {
        container = document.createElement("div");
        container.className = "itoasts";
        document.body.prepend(container);
    }
    return container;
}

function createIcon(type, emoji, icon) {
    let iconElement;

    if (emoji) {
        iconElement = document.createElement("div");
        iconElement.classList.add("itoast-icon", "emoji");
        iconElement.style.fontSize = "20px";
        iconElement.textContent = emoji;
    } else {
        iconElement = document.createElement("i");
        iconElement.classList.add("itoast-icon", "fas");

        if (icon) {
            icon.split(" ").forEach((_class) => {
                iconElement.classList.add(_class);
            });
        } else {
            switch (type) {
                case "success":
                    iconElement.classList.add("fa-circle-check");
                    break;
                case "error":
                    iconElement.classList.add("fa-circle-xmark");
                    break;
                case "warn":
                    iconElement.classList.add("fa-triangle-exclamation");
                    break;
                case "info":
                    iconElement.classList.add("fa-circle-exclamation");
                    break;
            }
        }
    }

    return iconElement;
}

function createItoastText(title, message, actions = null, confirm = null) {
    const itoastText = document.createElement("div");
    itoastText.className = "itoast-text";

    const text = document.createElement("div");
    text.className = "text";

    if (title) {
        const titleElement = document.createElement("strong");
        titleElement.textContent = title;
        text.appendChild(titleElement);
    }

    const messageElement = document.createElement("p");
    messageElement.textContent = message;
    text.appendChild(messageElement);

    itoastText.appendChild(text);
    if (actions) itoastText.appendChild(actions);
    if (confirm) itoastText.appendChild(confirm);

    return itoastText;
}

function createCloseButton(itoastElement) {
    const close = document.createElement("div");
    close.className = "itoast-closed";

    const icon = document.createElement("i");
    icon.className = "fas fa-xmark";
    close.appendChild(icon);

    icon.addEventListener("click", () => {
        const itoastInner = itoastElement.parentElement;
        removeToast(itoastInner);
    });

    return close;
}

function createConfirmButtons(onconfirm, onconfirmLink, oncancel) {
    const confirmActions = document.createElement("div");
    confirmActions.className = "itoast-actions";

    const a = document.createElement("a");
    a.classList.add("itoast-action", "onconfirm");
    a.href = onconfirmLink;
    a.classList.add(isEmoji(onconfirm) ? "emoji" : "text");
    a.textContent = onconfirm;

    const p = document.createElement("p");
    p.classList.add("itoast-action", "oncancel");
    p.classList.add(isEmoji(oncancel) ? "emoji" : "text");
    p.textContent = oncancel;

    confirmActions.appendChild(a);
    confirmActions.appendChild(p);

    if (typeof onConfirmCallback == "function") {
        a.addEventListener("click", (e) => {
            e.preventDefault();
            onConfirmCallback();
            removeItoast(itoast);
        });
    }

    return confirmActions;
}

function createActionsButtons(actions) {
    const _actions = document.createElement("div");
    _actions.className = "itoast-actions";

    if (actions) {
        actions.forEach((action) => {
            const a = document.createElement("a");
            a.classList.add("itoast-action");
            a.href = action.url;
            if (action.target) a.target = action.target;
            a.classList.add(isEmoji(action.label) ? "emoji" : "text");
            a.textContent = action.label;
            _actions.appendChild(a);
        });
    }

    return _actions;
}

export function pushItoast({
    type,
    title,
    message,
    duration,
    emoji,
    icon,
    pin,
    actions,
}) {
    if (!type || !message) return;

    const itoasts = getOrCreateItoasts();

    root.style.setProperty("--itoast-start-delay-time", `0s`);

    const itoastInner = document.createElement("div");
    itoastInner.className = "itoast-inner";

    const itoast = document.createElement("div");
    itoast.className = `itoast itoast-${type} top`;

    if (configItoast.move != "enable" || pin == "pin") {
        const pin = document.createElement("i");
        pin.className = "itoast-icon pin fas fa-thumbtack";

        itoast.classList.add("no_move", "pin");
        itoast.appendChild(pin);
    }

    if (duration) {
        itoast.setAttribute("data-duration", duration);
    }

    itoast.appendChild(createIcon(type, emoji, icon));
    let __actions = createActionsButtons(actions);

    itoast.appendChild(createItoastText(title, message, __actions));
    itoast.appendChild(createCloseButton(itoast));

    itoastInner.appendChild(itoast);
    itoasts.appendChild(itoastInner);

    itoastShake(itoast);

    // Set timeout for auto-dismiss
    setItoastTimes(itoast);
    userActive(itoastInner, itoast, totalAnimationTime, 1000);
}

export function pushItoastConfirm({
    type,
    title,
    message,
    duration,
    emoji,
    icon,
    pin,
    onconfirm,
    onconfirmLink,
    oncancel,
    actions,
}) {
    if (!type || !message) return;

    const itoasts = getOrCreateItoasts();

    root.style.setProperty("--itoast-start-delay-time", `0s`);

    const itoastInner = document.createElement("div");
    itoastInner.className = "itoast-inner";

    const itoast = document.createElement("div");
    itoast.classList.add("itoast", `itoast-${type}`, "top", "confirm-forever");

    if (
        configItoast.move != "enable" ||
        pin == "pin" ||
        itoast.classList.contains("confirm-forever")
    ) {
        const pin = document.createElement("i");
        pin.className = "itoast-icon pin fas fa-thumbtack";

        itoast.classList.add("no_move", "pin");
        itoast.appendChild(pin);
    }

    if (duration) {
        itoast.setAttribute("data-duration", duration);
    }

    itoast.appendChild(createIcon(type, emoji, icon));
    let __actions = createActionsButtons(actions);
    let __confirm = createConfirmButtons(onconfirm, onconfirmLink, oncancel);

    itoast.appendChild(createItoastText(title, message, __actions, __confirm));
    itoast.appendChild(createCloseButton(itoast));

    itoastInner.appendChild(itoast);
    itoasts.appendChild(itoastInner);

    itoastShake(itoast);

    // Set timeout for auto-dismiss
    setItoastTimes(itoast);
    userActive(itoastInner, itoast, totalAnimationTime, 1000);
}
