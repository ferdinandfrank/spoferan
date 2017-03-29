window.getParameterByName = function(name, url) {
    if (!url) {
        url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
};

window.toSnakeCase = function(string) {
    let s = string.replace(/[^\w\s]/g, "");
    s = s.replace(/\s+/g, " ");
    return s.toLowerCase().split(' ').join('_');
};
