window.getParameterByName = function (name, url) {
    if (!url) {
        url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
};

window.toSnakeCase = function (string) {
    let s = string.replace(/[^\w\s]/g, "");
    s = s.replace(/\s+/g, " ");
    return s.toLowerCase().split(' ').join('_');
};

window.getObjectByValue = function (arr, property, value) {
    for (let i = 0, iLen = arr.length; i < iLen; i++) {
        if (arr[i][property] === value) {
            return arr[i];
        }
    }

    return null;
};

window.formatMoney = function(cents){
    cents = parseFloat(cents) ? cents : 0.0;
    // place to two decimals then split off dollars and cents
    let components = (cents / 100).toFixed(2).toString().split(".");
    let decimal    = components[1];
    let dollars    = components[0] || "";
    let mod, remainder;
    let stringReverse = function(str){
        return str.split("").reverse().join("");
    };

    // do we need to worry about commas?
    if (dollars.length > 3){
        // since the commas are counted 3 characters from the
        // *right* we need to do some reversing
        dollars = stringReverse(dollars);

        // the match method used leaves off digits mod 3, so
        // we need to calculate what those omissions will be
        remainder = (mod = dollars.length % 3) ? stringReverse(dollars.slice(mod * -1)) + "," : "";

        // split every three characters, add commas, then add
        // omissions introduced by 'match' remainder back on
        dollars = remainder + stringReverse(dollars.match(/.../g).join(","));
    }

    // put it all together
    return [dollars, decimal].join(".");
};
