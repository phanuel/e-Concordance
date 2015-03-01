function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}

function countUrlSegments() {
    var url = document.URL;
    segments = url.split("/");
    
    if (window.location.hostname == "www.e-concordance.org" || window.location.hostname == "e-concordance.org") {
        return segments.length + 1;
    }else {
        return segments.length;
    }
}

function getLastUrlSegment() {
    var url = document.URL;
    segments = url.split("/");
    return segments[segments.length - 1];
}