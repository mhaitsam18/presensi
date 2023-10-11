$(function() {
    $('.newAgamaModalButton').on('click', function(){
        $('#newAgamaModalLabel').html('Add New Faculty');
        $('.modal-footer button[type=submit]').html('Add');
        $('.modal-content form')[0].reset();
        $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/agama');
    });

    $('.updateAgamaModalButton').on('click', function() {
        $('#newAgamaModalLabel').html('Edit Faculty');
        $('.modal-footer button[type=submit]').html('Save');
        $('.modal-content form').attr('action', 'http://localhost/presensi/DataMaster/updateAgama');
        const id = $(this).data('id');
        jQuery.ajax({
            url: 'http://localhost/presensi/DataMaster/getUpdateAgama',
            data: {id : id},
            method: 'post',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#agama').val(data.agama);
            }
        });
    });
});