$(document).ready(function(){
    $('form').on('submit', function(event){
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '',
            data: formData,
            success: function(response){
                var data = JSON.parse(response);
                if(data.status == 'success'){
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            }
        });
    });
});