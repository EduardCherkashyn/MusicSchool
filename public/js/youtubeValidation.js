$('body').ready(function(){
    $('.ajax').prop('disabled', true);
    $(document).on('input', '#video_link', function(){
        function matchYoutubeUrl(url) {
            var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
            if(url.match(p)){
                return url.match(p)[1];
            }
            return false;
        }
        if(matchYoutubeUrl($("#video_link").val())){
            $('.ajax').prop('disabled', false);
        }
        else {
            $('.ajax').prop('disabled', true);
        }
    });
});
