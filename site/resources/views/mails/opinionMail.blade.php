<body style="justify-content: center;
align-items: center; 
font-family: 'Nunito', sans-serif;
font-size: 12px;
max-width: 100vw;
margin: 15px;">
    <p>Buenas tardes{{$user->name}}, </p>
    <p>Esperamos que hayas tenido una experiencia increible en el evento {{$event->nom}}.</p>
    <p>Si desea puede dejar una opinión para hacernos saber como se lo ha pasado en este evento.</p>
    <a href="{{$urlOpinion}}">Click aqui para dejar su comentario.</a><br><br>
    <p>Muchas gracias por confiar en nosotros en este evento, y esperamos volver a verle.</p>
    <p>Saludos, <strong>ShowTickt</strong></p>
</body>