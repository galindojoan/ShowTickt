<body style="justify-content: center;
align-items: center; 
font-family: 'Nunito', sans-serif;
font-size: 12px;
max-width: 100vw;
margin: 15px;">
    <p><b>Buenas tardes {{$name}},</b></p>
    <p>Hemos recibido tu petición para cambiar tu contraseña. </p>
    <p>Entra en el siguiente link para cambiarla (Recuerda que tan solo tienes {{env('MAIL_TIME_LIMIT')}} minutos desde que se envio este mail):</p> <br>
    <p>{{$url}}</p> <br><br>
    <p>Saludos, ShowTickt</p>
</body>
