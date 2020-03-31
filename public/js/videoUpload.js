$(document).on('click', 'button.ajax', function(){
    function matchYoutubeUrl(url) {
        var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        if(url.match(p)){
            return url.match(p)[1];
        }
        return false;
    }
    if(matchYoutubeUrl($('#input').val())){
        that = $(this);
        link = $('#input').val();
        lesson = this.id;
        $.ajax({
            url:'/video_upload',
            type: "POST",
            dataType: "json",
            data: {
                "data": link,
                "id":lesson
            },
            async: true,
            success: function (data)
            {
                console.log(data);
                $('div#ajax-results').html('<iframe class="d-block w-100 videos mt-3 mb-3" id="uploaded" frameborder="0" src="'+data.output+'" height="475px"></iframe>');
                $('div#videoUpload').hide();
            },
            error: function () {
                alert('Такое видео уже существует!!')
            }});
        return false;
    }
    else {
        alert('Enter a valid youtube url!')
    }
});
