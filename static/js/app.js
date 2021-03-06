requirejs.config({
    "paths" : {
        "bootstrap"       : "lib/vendor/bootstrap",
        "bootstrap-select": "lib/vendor/bootstrap-select",
        "bootstrap-switch": "lib/vendor/bootstrap-switch",
        "jasny-bootstrap" : "lib/vendor/jasny-bootstrap",
        "domReady"        : "lib/vendor/domReady",
        "jquery"          : "lib/vendor/jquery",
        "loading-overlay" : "lib/vendor/loading-overlay",
        "lodash"          : "lib/vendor/lodash",
        "require"         : "lib/vendor/require",
        "chatManager"     : "lib/chatManager",
        "room"            : "lib/room",
        "roomManager"     : "lib/roomManager",
        "user"            : "lib/user",
        "userManager"     : "lib/userManager",
        "client"          : "lib/client",
        "clientManager"   : "lib/clientManager",
        "formManager"     : "lib/formManager",
        "websocketManager": "lib/websocketManager",
        "iframeManager"   : "lib/iframeManager",
        "notification"    : "lib/notification",
        "navigation"      : "lib/navigation"
    },
    "shim"  : {
        "bootstrap"        : {
            "deps": ['jquery']
        },
        "bootstrap-select" : {
            "deps": ['bootstrap']
        },
        "bootstrap-switch" : {
            "deps": ['bootstrap']
        },
        "jasny-bootstrap"  : {
            "deps": ['jquery', 'bootstrap']
        },
        "loading-overlay"  : {
            "deps": ['jquery']
        }
    },
    "config": {
        "navigation"      : {
            "landingPage" : "chat",
            "urlPrefix"   : "#!",
            "selectors"   : {
                "page"       : ".page",
                "pageLink"   : ".page-link",
                "currentPage": ".current-page"
            }
        },
        "iframeManager"   : {
            "resizeInterval": 2000,
            "selectors"     : {
                "kibanaIframe"         : "#kibana-iframe",
                "iframeWidthContainer" : "body",
                "iframeHeightContainer": ".content"
            }
        },
        "websocketManager": {
            "serverUrl"   : "ws://127.0.0.1:5000",
            "serviceName" : "websocketService",
            "waitInterval": 1000
        },
        "userManager"     : {
            "selectors": {
                "modals": {
                    "connect": "#connectUserModal"
                }
            }
        },
        "clientManager"   : {
            "serviceName"            : "clientService",
            "locationRefreshInterval": 15000,
            "locationTimeout"        : 30000
        },
        "roomManager"     : {
            "serviceName": "roomService",
            "selectors"  : {
                "global"             : {
                    "rooms"         : "#rooms",
                    "room"          : ".room",
                    "roomName"      : ".room-name",
                    "roomContents"  : ".room-contents",
                    "roomChat"      : ".chat",
                    "roomSample"    : "#room-sample",
                    "roomHeader"    : ".header",
                    "roomClose"     : ".close-room",
                    "roomMinimize"  : ".minimize",
                    "roomFullScreen": ".fullScreen"
                },
                "roomConnect"        : {
                    "div"         : ".connect-room",
                    "name"        : ".room-name",
                    "publicRooms" : '.public',
                    "privateRooms": '.private',
                    "pseudonym"   : ".pseudonym",
                    "password"    : ".room-password",
                    "connect"     : ".connect"
                },
                "roomCreation"       : {
                    "div"     : ".create-room",
                    "name"    : ".room-name",
                    "type"    : ".room-type",
                    "password": ".room-password",
                    "maxUsers": ".room-max-users",
                    "create"  : ".create"
                },
                "roomAction"         : {
                    "loadHistoric"  : ".load-historic",
                    "kickUser"      : ".kick-user",
                    "showUsers"     : ".users",
                    "administration": ".admin"
                },
                "administrationPanel": {
                    "modal"            : ".chat-admin",
                    "modalSample"      : "#chat-admin-sample",
                    "trSample"         : ".sample",
                    "usersList"        : ".users-list",
                    "roomName"         : ".room-name",
                    "kick"             : ".kick",
                    "ban"              : ".ban",
                    "rights"           : ".right",
                    "pseudonym"        : ".user-pseudonym",
                    "toggleRights"     : ".toggle-rights",
                    "bannedList"       : ".banned-list",
                    "ip"               : ".ip",
                    "pseudonymBanned"  : ".pseudonym-banned",
                    "pseudonymAdmin"   : ".pseudonym-admin",
                    "reason"           : ".reason",
                    "date"             : ".date",
                    "inputRoomPassword": ".room-password",
                    "inputRoomName"    : ".room-name"
                },
                "alertInputsChoice"  : {
                    "div"   : "#alert-input-choice",
                    "submit": ".send"
                }
            }
        },
        "chatManager"     : {
            "serviceName"  : "chatService",
            "maxUsers"     : 15,
            "animationTime": 500,
            "selectors"    : {
                "global"             : {
                    "room"          : ".room",
                    "chat"          : ".chat",
                    "messagesUnread": ".messages-unread"
                },
                "chatSend"           : {
                    "div"      : ".send-action",
                    "message"  : ".message",
                    "receivers": ".receivers",
                    "usersList": ".users-list",
                    "send"     : ".send"
                },
                "chatAction"         : {
                    "loadHistoric"  : ".load-historic"
                },
                "chatText"           : {
                    "message"  : ".message",
                    "pseudonym": ".pseudonym",
                    "date"     : ".date",
                    "text"     : ".text"
                }
            },
            "commands"     : {
                "pm": /^\/pm '([^']*)' (.*)/
            }
        },
        "notification"    : {
            "alert"       : {
                "divId"          : "#alert-container",
                "dismissClass"   : ".dismiss",
                "defaultDuration": 2,
                "queue"          : []
            },
            "popup"       : {
                "divId"          : "#popup-container",
                "dismissClass"   : ".dismiss",
                "defaultDuration": 6,
                "queue"          : []
            },
            "notification": {
                "divId"          : "#notification-container",
                "dismissClass"   : ".dismiss",
                "defaultDuration": 4,
                "queue"          : []
            },
            "serviceName" : "notificationService",
            "defaultType" : "alert",
            "defaultLevel": "info"
        }
    }
});

requirejs(['main']);
