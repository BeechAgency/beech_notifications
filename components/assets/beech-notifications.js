//console.log('BEECH NOFITICATIONS LOADED');

// Beech Notification JS
(function() {

    const BEECH_notifications = document.querySelectorAll('.BEECH_notifications');

    if(!BEECH_notifications) return false;
    
    document.addEventListener('DOMContentLoaded', function() {
        
        BEECH_notifications.forEach(notification => {
            const classList = notification.classList;

            if( classList.contains('BEECH_notifications--side-bar') ){
                handleSideBar(notification);
            }
        });
    }); 

    function handleSideBar(notification) {
        const classList = notification.classList;
        const notificationCloseBtn = notification.querySelector('.BEECH_notifications--close');

        if(!handleCookies(notification)) return false;
        
        notificationOpen(notification);

        notificationCloseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            notificationClose(notification);
        });

    };

    function handleCookies(notification, action = 'open') {
        if(!notification) return false;

        const { name : cookieName, days, value : cookieValue } = makeCookieData(notification);

        //console.log('Cookies!');

        if(action === 'open') {
            //console.log('Cookies!: Check if we open');

            const cookieRead = getCookie(cookieName);

            //console.log('Cookies!: Validate cookies', cookieRead, cookieValue, cookieName);

            if( cookieRead === cookieValue ) {
                //console.log('COOKIE THE SAME!!!!!');
                return false;
            } 

            //console.log('Cookies!: Open');

            return true;
        }

        if(action === 'close') {
            //console.log('Cookies!: Close');
            setCookie(cookieName, cookieValue, days);

            return true;
        }

        //console.log('Cookies!: Dunno');
        return false;
    }

    function makeCookieData(notification) {
        const dataset = notification.dataset;

        const type = dataset.beechNotificationType;
        const id = dataset.beechNotificationId;
        const days = dataset.beechNotificationDays;

        //console.log(notification, dataset);

        return { 
            name : `BEECH_notifications-${type}`, 
            value : id,
            days 
        };
    }

    function notificationOpen(notification) {
        setTimeout(() => { 
            notification.classList.add('BEECH__opening');

            setTimeout(() => { 
                notification.classList.add('BEECH__open');
                notification.classList.remove('BEECH__opening');
            }, 1);
        }, 1000);
    }

    function notificationClose(notification) {
        setTimeout(() => { 
            notification.classList.add('BEECH__closing');

            setTimeout(() => { 
                notification.classList.remove('BEECH__open');
                notification.classList.remove('BEECH__closing');
            }, 1000);
        }, 100);

        handleCookies(notification, 'close');
    }

    /* Thank you W3 Schools */
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
      
    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

})();