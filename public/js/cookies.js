// Function to set a cookie
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// Function to get a cookie
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Function to check cookie consent
function checkCookieConsent() {
    var consent = getCookie("cookieConsent");
    if (!consent) {
        document.getElementById("cookieConsent").style.display = "block";
    }
}

// Event listener for accepting cookies
document.getElementById("acceptCookies").addEventListener("click", function() {
    setCookie("cookieConsent", "accepted", 365);
    document.getElementById("cookieConsent").style.display = "none";
});

// Event listener for declining cookies
document.getElementById("declineCookies").addEventListener("click", function() {
    setCookie("cookieConsent", "declined", 365);
    document.getElementById("cookieConsent").style.display = "none";
});

// Check for cookie consent on page load
document.addEventListener("DOMContentLoaded", function() {
    checkCookieConsent();
});
