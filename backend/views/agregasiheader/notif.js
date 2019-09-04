var socket = io.connect('http://192.168.100.194:3000');
socket.on('notif', function(data) {
    $("#notifikasi").text( data.name );
    //$.pjax.reload({container: "#progress-bar"});
    //$("#btn-progress").click();
});

$('#kode_kemas').val('');
$('#kode_kemas').focus();
$('#kode_kemas').keypress(function(e) {
    var key = e.which || e.ctrlKey;
    if(key == 13) {
        $('#frm-input').click(function () {
            $('#detail-form').on('beforeSubmit',function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var kode = $('#kode_kemas').val();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: form.serialize(),
                    success: function (response) {
                        $('#kode_kemas').val("");
                        $("#btn-progress").click();
                    },
                });
                socket.emit('notif', { name: kode });
                return false;
            });
        });
    }
});

//$('#btn-progress').on('click', function(){
//    
//});