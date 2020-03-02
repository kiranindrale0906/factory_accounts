// Initialize Firebase
firebase.initializeApp(firebaseConfig);


const messaging = firebase.messaging();
messaging.requestPermission()
    .then(function() {
        return messaging.getToken();
    })
    .then(function(token) {
        var url =base_url+'user_device_token/user_device_token/store';
        var formData = new FormData();
        formData.append('user_device_token[device_token]',token);
        formData.append('user_device_token[device_type]','web');
       ajax_post_request(url, formData);
    })
    .catch(function(err) {
        console.log(err);
        console.log('Permission denied');
    });