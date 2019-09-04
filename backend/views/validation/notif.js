$('#kemas').val('');
$('#kemas').focus();
$('#kemas').keypress(function(e) {
    var key = e.which || e.ctrlKey;
    if (key == 13) {
        $('#frm-input').click(function() {
            $('#validation-form').on('beforeSubmit', function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                
                var kode = $('#kemas').val();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: {kode : kode},
//                    data: form.serialize(),
                    success: function (data) {
                        console.log(data.valid);
                        if (data.valid == 'gagal') {
                            $.notify({
                                message: "<strong>"+data.valid+"</strong>",
                            }, {
                                type: 'danger',
                                placement: {
                                    from: "bottom",
                                    align: "right"
                                },
                            });
                        } else if(data.valid == 'benar') {
                            $.notifyClose();
                        };
                        $('#kemas').val('');
                        //$('#btn-alert').click();
                    },
                    error: function (response) {
                        alert('Error yes');
                    },
                });
                return false;
            });
        });
    }
});
