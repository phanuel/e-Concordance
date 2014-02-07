$(document).ready(function() {
    if (countUrlSegments() == 8) {
        var author_id = getLastUrlSegment();

        if (author_id) {
            var author_scroll = $("#author" + parseInt(author_id)).parent().prevAll("tr").eq(5).get(); // scrolling to 5 lines before the line we are looking for, so that the line is not completely on top
            var element_scroll = (author_scroll < 1) ? ".push:first" : author_scroll; // for the first 1 verses, scrolling to the top of the page (just in case the user refreshes the page from the bottom)

            $(element_scroll).ScrollTo();

            $("#author" + author_id).parent("tr").children("td").effect("highlight", {}, 2000);
        }
    }
});