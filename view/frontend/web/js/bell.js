/**
 * Copyright © Coditron Technologies All rights reserved.
 * See COPYING.txt for license details.
 * http://www.coditron.com | contact@coditron.com
 */

require(['jquery', 'mage/url'], function($, urlBuilder) {
    function toggleBellDropdown() {
        var dropdown = $("#bellDropdown");
        if (dropdown.css("display") === "block") {
            dropdown.css("display", "none");
        } else {
            dropdown.css("display", "block");
            loadNotifications();
        }
    }

    function loadNotifications() {
        $.ajax({
            url: urlBuilder.build('coditronnotifications/front/getnotification'),
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var notificationContent = $("#notification-content");
                notificationContent.empty();

                if (data.success) {
                    var notifications = data.notifications;

                    if (notifications.length > 0) {
                        $.each(notifications, function(index, notification) {
                            notificationContent.append('<a href="#" data-id="' + notification.notificationsend_id + '" class="notification-link">' + notification.message + '</a>');
                        });
                    } else {
                        $("#no-notifications").show();
                    }
                } else {
                    notificationContent.append('<a href="#">' + data.message + '</a>');
                }
            }
        });
    }

    function updateNotificationStatus(notificationId) {
        $.ajax({
            url: urlBuilder.build('coditronnotifications/front/updatestatus'),
            type: 'POST',
            data: { notificationsend_id: notificationId },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    // Optionally, you can update the UI or notify the user
                    // console.log('Notification status updated.');
                } else {
                    // console.error(data.message);
                }
                location.reload();
            }
        });
    }

    $(document).ready(function() {
        $(".bell-icon-img").on('click', toggleBellDropdown);

        $(document).on('click', '.notification-link', function() {
            var notificationId = $(this).data('id');
            updateNotificationStatus(notificationId);
        });

        // Close the dropdown if the user clicks outside of it
        $(window).on('click', function(event) {
            if (!$(event.target).closest('.bell-icon').length) {
                $("#bellDropdown").css("display", "none");
            }
        });
    });
});
