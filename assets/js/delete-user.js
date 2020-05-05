function deleteUser(id){
    bootbox.confirm({
        message: "¿Seguro que quieres borrar al usuario?",
        buttons: {
            confirm: {
                label: 'Sí',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            console.log('El usuario ha sido borrado con éxito: ' + result);
            if(result){
                $.ajax({
                    url: "/comicWebStore/admin/users/delete",
                    type: "POST",
                    dataType: "json",
                    data: {
                        "id":id
                    },
                    async: true,
                    success: function(){
                        location.reload();
                    },
                    error: function (data) {
                        console.log(data);
                        bootbox.alert("ERROR");
                    }
                });
            }
        }
    });
}