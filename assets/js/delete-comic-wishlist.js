function removeFromWishList(userId, comicId){
    bootbox.confirm({
        message: "<p class='text-dark'>¿Seguro que quieres eliminarlo de la lista de deseos?</p>",
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
            console.log('Se ha eliminado de la lista de deseos con éxito: ' + result);
            if(result){
                $.ajax({
                    url: "/comicWebStore/user/wishlist/remove",
                    type: "POST",
                    dataType: "json",
                    data: {
                        "comicId":comicId,
                        "userId":userId,
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

