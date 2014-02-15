$(document).ready(function() {
    $("#goto_song_submit").click(function(e) {
        e.preventDefault();
        var song_number = $("#goto_song_value").val();

        if (song_number) {
            var song_scroll = $("#song" + parseInt(song_number)).get();
            $(song_scroll).ScrollTo();

            $("#song" + song_number).effect("highlight", {}, 2000);
        }
    });
});