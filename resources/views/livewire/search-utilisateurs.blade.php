<div style="width: 50%;">
     <section class="form-search">
            <form action="" class="search">
                <i class='bx bx-search'></i>
                <input type="text"  wire:model.live.debounce.300ms="search" placeholder="Recherche...">
            </form>
            <form action="" >
                <label for="nom">Recherche par :</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="nom">
                <label for="categorie">Categorie :</label>
                <input type="text" wire:model.live.debounce.300ms="category" placeholder="- aucun -">
            </form>
        </section>

    
    <section class="sec-accueil" style="width: 100%;">
        @forelse ($utilisateurs as $collab)
        <section class="carte-accueil"> 
            <div class="img">
                <img src="{{ asset('storage/img/' . ($collab->photo ?? 'default.jpg')) }}" alt="Photo de {{ $collab->name }}" class="img-pers">
            </div>
            <div class="fonction">
                <span>{{ $collab->categorie }} </span> 
            </div>
            <div class="items">
                <div class="p">
                    <p>{{ $collab->surname }} {{ $collab->name }}</p> 
                    <p>{{ $collab->city }}, {{ $collab->country }}</p>
                </div>
                
                <div class="social-icons">
                    <div>
                        <a href="mailto:{{ $collab->email }}"><i class='bx bxs-envelope'></i></a>
                        <span>{{ $collab->email }}</span>
                    </div>
                    <div>
                        <a href="tel:{{ $collab->phone }}"><i class='bx bxs-phone-call'></i></a>
                        <span>{{ $collab->phone }}</span>
                    </div>
                    <div>
                        <a href="#"><i class='bx bxs-cake'></i></a> 
                        <span>Anniversaire : {{ \Carbon\Carbon::parse($collab->birthdate)->format('d F') }}</span>
                    </div>
                </div>
                  @if ($isAdminView)
                <div class="action">
                    <a href="{{ route('modifier', $collab->id) }}"><button class="btn btn-edit">Modifier</button></a>
                    <form action="{{ route('destroy', $collab->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">Supprimer</button>
                    </form>
                </div>
                @endif
            </div>
        </section>
        @empty
            <p>Aucun collaborateur trouvé pour votre recherche.</p>
        @endforelse
    </section>
</div>