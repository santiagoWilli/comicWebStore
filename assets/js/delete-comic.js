function deleteComic(id){
    bootbox.confirm({
        message: "¿Seguro que quieres borrar cómic?",
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
            console.log('El cómic ha sido borrado con éxito: ' + result);
            if(result){
                $.ajax({
                    url: "/comicWebStore/comics/delete",
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