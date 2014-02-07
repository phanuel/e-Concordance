$(document).ready(function() {
    if (countUrlSegments() == 9) {
        var verse = getLastUrlSegment();

        if (verse) {
            var verse_scroll = parseInt(verse) - 1; // scrolling to 1 verse before the verse we are looking for, so that the verse is not completely on top
            var element_scroll = (verse_scroll < 1) ? ".push:first" : "#verse" + verse_scroll; // for the first 1 verses, scrolling to the top of the page (just in case the user refreshes the page from the bottom)

            $(element_scroll).ScrollTo();

            $("#verse" + verse).parent("tr").children("td").effect("highlight", {}, 2000);
        }
    }
    
    $("#goto_song_submit").click(function(e) {
        e.preventDefault();
        var song_number = $("#goto_song_value").val();
        
        var url = document.URL;
        segments = url.split("/");
        segments.splice(segments.indexOf("read") + 2, 2); // removing the song number and the verse number
        
        window.location = segments.join("/") + "/" + song_number;
    });
});