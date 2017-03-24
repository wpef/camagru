var hide_mess = function (mess) {
    mess.setAttribute("style", "display:none");
};

var select_stick = function (stick) {
    var old = document.getElementById("selected");
    if (old) {
        old.removeAttribute("id");
    }
    stick.setAttribute("id", "selected");
};

var disp_menu = function (event) {
    var menu = document.getElementById("account_menu");
    if (menu.style.display == "block")
        menu.style.display = "none";
    else
        menu.style.display = "block";
};

var timeAgo = function (date) {

    var seconds = Math.floor((new Date() - date) / 1000);

    var interval = Math.floor(seconds / 31536000);

    if (interval > 1) {
        return interval + " years";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + " months";
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + " days";
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + " hours";
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + " minutes";
    }
    return Math.floor(seconds) + " seconds";
};