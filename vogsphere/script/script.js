window.onload = function () {

    var img = document.querySelectorAll("section.image img");
    var date = document.querySelectorAll(".pic_date");

    if (img)
    {
        var height = 0;
        for (i = 0; i < img.length; i++)
        {
            if (img[i].height > height)
                height = img[i].height;
        }

        for (i = 0; i < img.length; i++)
        {
            if (img[i].height < height)
                img[i].style.paddingTop = ((height - img[i].height) /2) + "px";
        }
    }
    
    if (date) {
        for (i = 0; i < date.length; i++)
            date[i].innerHTML = timeAgo(date[i].innerHTML);
    }
}

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
    var epoch = new Date(date).valueOf() / 1000; 
    var secs = ((new Date()).getTime() / 1000) - epoch;
    Math.floor(secs);
    var minutes = secs / 60;
    secs = Math.floor(secs % 60);
    if (minutes < 1) {
        return secs + (secs > 1 ? ' seconds ago' : ' second ago');
    }
    var hours = minutes / 60;
    minutes = Math.floor(minutes % 60);
    if (hours < 1) {
        return minutes + (minutes > 1 ? ' minutes ago' : ' minute ago');
    }
    var days = hours / 24;
    hours = Math.floor(hours % 24);
    if (days < 1) {
        return hours + (hours > 1 ? ' hours ago' : ' hour ago');
    }
    var weeks = days / 7;
    days = Math.floor(days % 7);
    if (weeks < 1) {
        return days + (days > 1 ? ' days ago' : ' day ago');
    }
    var months = weeks / 4.35;
    weeks = Math.floor(weeks % 4.35);
    if (months < 1) {
        return weeks + (weeks > 1 ? ' weeks ago' : ' week ago');
    }
    var years = months / 12;
    months = Math.floor(months % 12);
    if (years < 1) {
        return months + (months > 1 ? ' months ago' : ' month ago');
    }
    years = Math.floor(years);
    return years + (years > 1 ? ' years ago' : ' years ago');
};