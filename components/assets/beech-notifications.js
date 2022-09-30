console.log('BEECH NOFITICATIONS LOADED');

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

        notificationOpen(notification);

        notificationCloseBtn.addEventListener('click', function() {
            notificationClose(notification);
        });

    };

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
    }

})();