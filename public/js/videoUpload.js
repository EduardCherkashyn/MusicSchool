$(document).on('click', 'button.ajax', function(){
    function matchYoutubeUrl(url) {
        var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        if(url.match(p)){
            return url.match(p)[1];
        }
        return false;
    }
    if(matchYoutubeUrl($('#input'+this.id).val())){
        that = $(this);
        link = $("#input"+this.id).val();
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
                $('#ajax-results'+ lesson).append('<iframe class="d-block w-100 videos mt-3 mb-3" id="uploaded" frameborder="0" src="'+data.output+'" height="475px"></iframe>');
                if($('#ajax-results'+ lesson).children('iframe').length > 2){
                    $('#videoUpload'+ lesson).hide();
                }else{
                    $('#input'+lesson).val("");
                }
            },
            error: function () {
                alert('Такое видео уже существует!!')
            }});
        return false;
    }
    else {
        alert('Введите верную ютуб ссылку!')
    }
});

