if(Laravel.user){
    console.log(`App.User.${Laravel.user}`)
    Echo.private(`App.User.${Laravel.user}`)
        .notification(notification => {
            console.log(notification)
        });
}