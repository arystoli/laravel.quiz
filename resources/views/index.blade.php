<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rooms</title>
</head>
<body>


<p>
    <input type="text" id="userToken" style="width: 100%;">
</p>

<button id="createRoom">Create Room</button>
<p id="createRoomResponse"></p>

<input id="roomId" type="text">
<button id="joinRoom">Join Room</button>


<input id="roomIdQuestion" type="text">
<button id="getQuestion">Get Question</button>


<button id="sendResult">Send Result</button>

<input id="roomIdLeave" type="text">
<button id="leaveRoom">Leave Room</button>
<br>
<input id="roomIdStart" type="text">
<button id="startQuiz">Start Quiz</button>


<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>


<script>

    $(document).ready(function () {



        var socket = io(':6560');

//        socket.open().emit('newUser',{
//            'message' : 'new connection'
//        });



        socket.on('message', function (data) {
            console.log(data);
        });

        socket.on('errors', function (data) {
            console.warn(data);
        });

        socket.on('RoomChanges',function (data) {
            console.log(data);
        });

        socket.on('SendQuestion',function (data) {
            console.log(data);
        });

        socket.on('SendIntermediateResults',function (data) {
            console.log(data);
        });


        $('#createRoom').on('click', function(){
            var token = $('#userToken').val();
            $.ajax({
                url: "/room/create",
                type: "POST",
                data : {
                    is_public : 1
                },
                beforeSend: function(xhr){xhr.setRequestHeader('Authorization', 'Bearer '+token);},
                success: function (data) {
                    $('#createRoomResponse').append(data.message)
                }
            })
        });
        $('#joinRoom').on('click', function(){
            var id = $('#roomId').val();
            var token = $('#userToken').val();

            var data = {
                'room' : id,
                'user' : token
            };

            socket.emit('joinRoom',data)
        });

        $('#getQuestion').on('click', function(){
            var id = $('#roomIdQuestion').val();
            var token = $('#userToken').val();

            var data = {
                'room' : id,
                'user' : token
            };

            socket.emit('getQuestion',data)
        });


        $('#startQuiz').on('click', function(){
            var id = $('#roomIdStart').val();
            var token = $('#userToken').val();

            var data = {
                'room' : id,
                'user' : token,
                'lang' : 1,
                'stepsCount' : 4
            };

            socket.emit('startQuiz',data)
        });


        $('#sendResult').on('click', function(){
            var id = $('#roomIdQuestion').val();
            var token = $('#userToken').val();

            var data = {
                'room' : 5,
                'user' : token,
                'step' : 1,
                'question' : 1,
                'answer' : 2,
                'time' : 10
            };

            socket.emit('sendResult',data)
        });



        $('#leaveRoom').on('click', function(){
            var id = $('#roomIdLeave').val();

            $.ajax({
                url: "/quiz/get_question/" + id,
                type: "GET"
            })
        });

    });


</script>
</body>
</html>