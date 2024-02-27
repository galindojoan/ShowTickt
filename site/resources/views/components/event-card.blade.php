<!-- resources/views/components/event-card.blade.php -->

<div class="event-card">
    <div class="event-details">
        <h1>{{ $esdeveniment->nom }}</h1>
        @if ($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->data !== null)
            <h3>{{ $esdeveniment->sesions->first()->data }}</h3>
        @else
            <h3>No hay sesiones</h3>
        @endif
        <h4>{{ $esdeveniment->recinte->lloc }}</h4>
        @if ($esdeveniment->sesions->isNotEmpty() && $esdeveniment->sesions->first()->entrades->isNotEmpty())
            <h2>{{ $esdeveniment->sesions->first()->entrades->first()->preu }} €</h2>
        @else
            <h2>Entradas Agotadas</h2>
        @endif
    </div>
    @if ($esdeveniment->imatge->isNotEmpty())
        <?php
        $imagePath = Storage::url('public/images/' . $esdeveniment->imatge->first()->imatge);
        $imageFullPath = storage_path('app/public/images/' . $esdeveniment->imatge->first()->imatge);
        $lastModified = filemtime($imageFullPath);
        $lastModifiedTime = gmdate('D, d M Y H:i:s', $lastModified) . ' GMT';
        $expirationTime = gmdate('D, d M Y H:i:s', strtotime('+2 months')) . ' GMT';
        
        // Configura les capçaleres de control de la memòria cau
        header("Last-Modified: $lastModifiedTime");
        header("Expires: $expirationTime");
        header('Cache-Control: public, max-age=15552000');
        
        
        ?>
        <img src="{{ $imagePath }}" alt="Imatge de l'esdeveniment" loading="lazy"
            cache-control="public, max-age=15552000">
    @else
        <img src="https://via.placeholder.com/640x480.png/00dd22?text=imagenEvento" alt="Imatge de l'esdeveniment"
            loading="lazy">
    @endif
</div>
