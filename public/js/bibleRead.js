$(document).ready(function() {
    if (countUrlSegments() == 9) {
        var verse = getLastUrlSegment();

        if (verse) {
            var verse_scroll = parseInt(verse) - 5; // scrolling to 5 verses before the verse we are looking for, so that the verse is not completely on top
            var element_scroll = (verse_scroll < 1) ? ".push:first" : "#verse" + verse_scroll; // for the first 5 verses, scrolling to the top of the page (just in case the user refreshes the page from the bottom)

            $(element_scroll).ScrollTo();

            $("#verse" + verse).parent("tr").children("td").effect("highlight", {}, 2000);
        }
    }
});