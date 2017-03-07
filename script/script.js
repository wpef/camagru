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
    if (!menu) {
        return false;
    }
    menu.style.display = "block";
};