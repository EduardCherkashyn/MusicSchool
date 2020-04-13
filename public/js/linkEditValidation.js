$('body').ready(function(){
    $(document).on('input', '.edit', function(){
        function matchYoutubeUrl(url) {
            var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
            if(url.match(p)){
                return url.match(p)[1];
            }
            return false;
        }
        if(matchYoutubeUrl($(this).val())){
            $('button.edit').prop('disabled', false);
        }
        else {
            $('button.edit').prop('disabled', true);
        }
    });
});
