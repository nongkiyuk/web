@extends('layouts.master')

@section('content')
<div class="col-md-6">
    @include('includes.flash-message')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Notification</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="{{ route('notification.index') }}" method="POST" enctype="multipart/form-data">
            <div class="box-body">
                <div class="alert alert-success" id="permited" style="display:none">Permission Granted</div>
                <div class="alert alert-danger" id="notpermited" style="display:block">
                    Unable to get permission to notify.
                    <p class="btn btn-primary" onclick=tryagain()>Try Again</p>
                </div>
                
                @csrf
               <div class="form-group">
                    <label for="title">Title </label>
                    <input type="text" class="form-control" id="title" placeholder="title" name="title" required>
                    <label for="body">Body </label>
                    <textarea type="text" class="form-control" id="body" name="body" required>

                    </textarea>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<!-- Firebase App is always required and must be first -->
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-app.js"></script>

<!-- Add additional services that you want to use -->
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-functions.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "{{ env('FIREBASE_API_KEY') }}",
    authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
    databaseURL: "{{ env('FIREBASE_DATABASE_URL') }}",
    projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
    storageBucket: "{{ env('FIREBASE_STORAGE') }}",
    messagingSenderId: "{{ env('FIREBASE_SENDERID') }}"
  };
  firebase.initializeApp(config);
  
  // Retrieve Firebase Messaging object.
  const messaging = firebase.messaging();
  messaging.requestPermission().then(function() {
    console.log('Notification permission granted.');
    // TODO(developer): Retrieve an Instance ID token for use with FCM.
    messaging.getToken().then(function(currentToken) {
    if (currentToken) {
      sendTokenToServer(currentToken);
      updateUIForPushEnabled(currentToken);
    } else {
      // Show permission request.
      console.log('No Instance ID token available. Request permission to generate one.');
      // Show permission UI.
      updateUIForPushPermissionRequired();
      setTokenSentToServer(false);
    }
    }).catch(function(err) {
       console.log('An error occurred while retrieving token. ', err);
       showToken('Error retrieving Instance ID token. ', err);
       setTokenSentToServer(false);
    });
  }).catch(function(err) {
    console.log('Unable to get permission to notify.', err);
  });

  function showToken(token, err){
      console.log(token + ' - ' + err)
  }
  function sendTokenToServer(currentToken) {
    if (!isTokenSentToServer()) {
      console.log('Sending token to server...');
      // TODO(developer): Send the current token to your server.
      setTokenSentToServer(true);
    } else {
      console.log('Token already sent to server so won\'t send it again ' +
          'unless it changes');
    }
  }
  function isTokenSentToServer() {
    return window.localStorage.getItem('sentToServer') === '1';
  }
  function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
  }

  messaging.onMessage(function(payload) {
    console.log('Message received. ', payload);
    notification = payload.notification;
    notifyMe(notification.title, '', notification.body, notification.click_action)
  });

  function updateUIForPushEnabled(currentToken) {
    document.getElementById('permited').style.display = 'block'
    document.getElementById('notpermited').style.display = 'none'
    setTimeout(function(){
        document.getElementById('permited').style.display = 'none'
    }, 3000)
    showToken(currentToken);
  }

  function notifyMe(title, icon, body, action) {
    if (Notification.permission !== "granted")
      Notification.requestPermission();
    else {
      var notification = new Notification(title, {
        icon: icon,
        body: body,
      });

      notification.onclick = function () {
        window.open(action);      
      };
    }
    
    

  }

  function tryagain(){
    messaging.requestPermission().then(function() {
      console.log('Notification permission granted.');
      // TODO(developer): Retrieve an Instance ID token for use with FCM.
      messaging.getToken().then(function(currentToken) {
        if (currentToken) {
            sendTokenToServer(currentToken);
            updateUIForPushEnabled(currentToken);
        } else {
            // Show permission request.
            console.log('No Instance ID token available. Request permission to generate one.');
            // Show permission UI.
            updateUIForPushPermissionRequired();
            setTokenSentToServer(false);
        }
      }).catch(function(err) {
       console.log('An error occurred while retrieving token. ', err);
       showToken('Error retrieving Instance ID token. ', err);
       setTokenSentToServer(false);
      });
    }).catch(function(err) {
      console.log('Unable to get permission to notify.', err);
      alert('You Block The Notification')
    });
  }
</script>
@endsection