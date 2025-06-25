class BeechNotifications {
  constructor() {
    document.addEventListener("DOMContentLoaded", () => this.init());
  }

  init() {
    console.log("Beech Notifications v1.5.3");

    this.notificationsContainer = document.querySelector(
      ".BEECH_notifications"
    );

    if (!this.notificationsContainer || !BEECH_notifications_data) return;

    this.renderNotifications();
  }

  renderNotifications() {
    let delayMultiplier = 0;

    BEECH_notifications_data.forEach((notification) => {
      const type = notification.type;
      if (!type) return;

      const template = document.getElementById(`BEECH_notifications--${type}`);
      if (!template) return;

      const templateClone = template.content.cloneNode(true);
      this.populateNotification(templateClone, notification);

      // Determine where to append
      let appendTarget = this.notificationsContainer;
      if (type === "right_corner" || type === "right_corner_alt") {
        appendTarget = this.getOrCreateRightWrapper();
      }

      // Append to DOM first
      appendTarget.appendChild(templateClone);

      // Get actual DOM element
      const newNotification = appendTarget.querySelector(
        `[data-beech-notification-id='${notification.ID}']`
      );
      if (!newNotification) return;

      // Apply additional classes
      if (notification.hide_image || !notification.image)
        newNotification.classList.add("BN--no-image");
      if (notification.hide_title)
        newNotification.classList.add("BN--no-title");

      this.handleNotificationClickEvents(newNotification);

      setTimeout(() => {
        this.handleNotification(newNotification);
      }, delayMultiplier * 500);

      delayMultiplier++;
    });
  }

  populateNotification(fragment, notification) {
    fragment.querySelector(".BEECH_notifications--title").textContent =
      notification.title;
    fragment.querySelector(".BEECH_notifications--content").innerHTML =
      notification.content;
    fragment
      .querySelector(".BEECH_notification")
      .setAttribute("data-beech-notification-id", notification.ID);
    fragment
      .querySelector(".BEECH_notification")
      .setAttribute(
        "data-beech-notification-title",
        this.escapeAttribute(notification.title)
      );
    fragment
      .querySelector(".BEECH_notification")
      .setAttribute(
        "data-beech-notification-cta",
        this.escapeAttribute(notification.cta_text)
      );
    fragment
      .querySelector(".BEECH_notifications--image")
      .setAttribute("src", !notification.image ? "" : notification.image);

    // Update links
    fragment.querySelectorAll(".BEECH_notifications--link").forEach((link) => {
      link.setAttribute("href", notification.cta_link);
    });

    const button = fragment.querySelector(".BEECH_notifications--button");
    if (button) {
      button.setAttribute("href", notification.cta_link);
      button.textContent = notification.cta_text;
    }
  }

  getOrCreateRightWrapper() {
    let wrapper = this.notificationsContainer.querySelector(
      ".BEECH_notifications--right-wrapper"
    );
    if (!wrapper) {
      wrapper = document.createElement("div");
      wrapper.className = "BEECH_notifications--right-wrapper";
      this.notificationsContainer.appendChild(wrapper);
    }
    return wrapper;
  }

  handleNotification(notification) {
    if (!this.handleCookies(notification)) return;
    this.notificationOpen(notification);

    const closeBtn = notification.querySelector(".BEECH_notifications--close");
    if (closeBtn) {
      closeBtn.addEventListener("click", (e) => {
        e.preventDefault();
        this.notificationClose(notification);
      });
    }
  }

  handleCookies(notification, action = "open") {
    if (!notification) return false;

    const {
      name: cookieName,
      id: notificationId,
      days,
    } = this.makeCookieData(notification);
    const cookieRead = this.getCookie(cookieName);
    const cookieIds = cookieRead ? cookieRead.split(",") : [];
    const newCookieValue = [notificationId, ...cookieIds];

    if (action === "open" && cookieIds.includes(notificationId)) return false;
    if (action === "close")
      this.setCookie(cookieName, newCookieValue.join(","), days);

    return true;
  }

  makeCookieData(notification) {
    return {
      name: "BEECH_notifications",
      id: notification.dataset.beechNotificationId,
      days: notification.dataset.beechNotificationDays || 7,
    };
  }

  notificationOpen(notification) {
    const dataset = notification.dataset;
    const type = dataset.beechNotificationType;
    const id = dataset.beechNotificationId;
    const title = dataset.beechNotificationTitle;
    const cta = dataset.beechNotificationCta;

    this.trackEvent("notification_open", {
      notification_type: type,
      notification_id: id || "Unknown",
      notification_title: title || "",
      notification_cta: cta || "",
    });

    if (type === "popup") {
      notification.querySelector("dialog")?.showModal();
    }

    setTimeout(() => {
      notification.classList.add("BEECH__opening");
      setTimeout(() => {
        notification.classList.add("BEECH__open");
        notification.classList.remove("BEECH__opening");
      }, 25);
    }, 1000);
  }

  notificationClose(notification, suppressEvent = false) {
    const dataset = notification.dataset;
    const type = dataset.beechNotificationType;
    const id = dataset.beechNotificationId;
    const title = dataset.beechNotificationTitle;
    const cta = dataset.beechNotificationCta;

    if(!suppressEvent) {
      this.trackEvent("notification_close", {
        notification_type: type,
        notification_id: id || "Unknown",
        notification_title: title || "",
        notification_cta: cta || "",
      });
    }

    setTimeout(() => {
      notification.classList.add("BEECH__closing");
      setTimeout(() => {
        notification.classList.remove("BEECH__open", "BEECH__closing");
        notification.remove();
      }, 1000);
    }, 100);

    this.handleCookies(notification, "close");
  }

  notificationClick(notification) {
    const dataset = notification.dataset;
    const type = dataset.beechNotificationType;
    const id = dataset.beechNotificationId;
    const title = dataset.beechNotificationTitle;
    const cta = dataset.beechNotificationCta;

    this.trackEvent("notification_click", {
      notification_type: type,
      notification_id: id || "Unknown",
      notification_title: title || "",
      notification_cta: cta || "",
    });
  }

  handleNotificationClickEvents(notification) {
    const button = notification.querySelector(".BEECH_notifications--button");

    button.addEventListener("click", (e) => {
      e.preventDefault();
      const link = e.currentTarget;
      const url = link.href;
      console.log("Delaying the inevitablery", url);

      this.notificationClick(notification);
      this.notificationClose(notification, true);

      // Delay the redirect
      setTimeout(() => {
        window.location.href = url;
      }, 250);
    });
  }

  setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value}; expires=${d.toUTCString()}; path=/`;
  }

  getCookie(name) {
    return document.cookie.split(";").reduce((acc, cookie) => {
      const [key, val] = cookie.split("=");
      return key.trim() === name ? val : acc;
    }, "");
  }

  trackEvent(eventName, eventParams = {}) {
    //console.log("Tracking event:", eventName, eventParams);
    if (typeof gtag !== "undefined") {
      //console.log("GA4");
      // Send event to Google Analytics 4 (GA4)
      gtag("event", eventName, eventParams);
    } else if (window.dataLayer) {
      //console.log("GTM");
      // Send event to Google Tag Manager (GTM)
      window.dataLayer.push({
        event: eventName,
        eventModel: eventParams
      });
    } else {
      //console.warn("GTM or GA is not available");
    }
  }

  escapeAttribute(value) {
    return value
      .replace(/&/g, "&amp;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#39;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;");
  }
}

new BeechNotifications();
