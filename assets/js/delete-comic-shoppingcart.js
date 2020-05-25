function removeFromShoppingCart(userId, comicId){
    bootbox.confirm({
        message: "<p class='text-dark'>¿Seguro que quieres eliminarlo del carrito?</p>",
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
            console.log('Se ha eliminado del carrito con éxito: ' + result);
            if(result){
                $.ajax({
                    url: "/comicWebStore/user/shoppingcart/remove",
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

