$(document).ready(function() {
    if (countUrlSegments() == 9) {
        var melody_id = getLastUrlSegment();

        if (melody_id) {
            var melody_scroll = $("#melody" + parseInt(melody_id)).parent().prevAll("tr").eq(5).get(); // scrolling to 5 lines before the line we are looking for, so that the line is not completely on top
            var element_scroll = (melody_scroll < 1) ? ".push:first" : melody_scroll; // for the first 1 verses, scrolling to the top of the page (just in case the user refreshes the page from the bottom)

            $(element_scroll).ScrollTo();

            $("#melody" + melody_id).parent("tr").children("td").effect("highlight", {}, 2000);
        }
    }
});