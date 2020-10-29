@extends('layouts.app')
@section('content')
  <section id="guests-show" class="show">
    <div class="container">
      <div class="row show-container">

        @if ($logged_user->id === $apartment->user->id)
          <div class="col-12">
            <h2 class="welcome">Ciao {{$logged_user->name }}
              @if (!($endSponsors->isEmpty()) && $logged_user->id === $apartment->user->id)
                  l'appartamento è sponsorizzato
                  <i class="fas fa-info-circle info"></i>
              @endif
              <ol class="d-none">
                @foreach ($endSponsors as $sponsor)
                  <li>Scade il: {{$sponsor}}</li>
                @endforeach
              </ol>
            </h2>
          </div>
        @endif

        <div class="col-lg-6 col-md-12 single-apartment" lat="{{ $apartment->latitude }}" lng="{{ $apartment->longitude }}">

          <div class="apartment-image">
            <img src="{{ $apartment->image }}" alt="{{ $apartment->title }}">
          </div>
          <p><small class="text-muted">Autore: {{ $apartment->user->name }} - Creato il: {{ $apartment->created_at->format('d/m/y') }}</small></p>
          <div class=" justify-content-between single-apartment d-none" lat="{{ $apartment->latitude }}" lng="{{ $apartment->longitude }}">
            <div>
              <h2 id="title" class="card-title">{{ $apartment->title }}</h2>
              <h4>{{ $apartment->address }}, {{ $apartment->city }}, {{ $apartment->zip }}</h4>
            </div>
            @if ($logged_user->id === $apartment->user->id)
              <div class="btn-adm">
                <a class="btn-add_app" href="{{ route('admin.statistics', $apartment) }}"><i class="fas fa-chart-line"></i> Statistiche</a>
                <a class="btn-add_app" href="{{ route('admin.payment', $apartment) }}">Sponsorizza</a>
              </div>
          @endif
          </div>
        </div>
        <div class="col-lg-6 col-md-12 map-position">
          <div class="col-12 apartment-map">
            <div class="mb-2">
              <div class="card-body">
                <h3>Mappa appartamento</h3>
                <div id="map-show"></div>
              </div>
            </div>
            <script>
              (function() {

                var title = document.getElementById('title').innerText;

                var latlng = {
                  lat: document.querySelector('.single-apartment').getAttribute("lat"),
                  lng: document.querySelector('.single-apartment').getAttribute("lng")
                };

                var map = L.map('map-show', {
                  scrollWheelZoom: false,
                  zoomControl: false,
                  keyboard: false,
                  dragging: false,
                  boxZoom: false,
                  doubleClickZoom: false,
                  tap: false,
                  touchZoom: false,
                });

                var osmLayer = new L.TileLayer(
                  'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    minZoom: 12,
                    maxZoom: 18,
                    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
                  }
                );

                map.setView(new L.LatLng(latlng.lat, latlng.lng), 17);

                map.addLayer(osmLayer);

                var marker = L.marker([latlng.lat, latlng.lng])
                .addTo(map)
                .bindPopup(title);

              })();
            </script>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 apartment-informations">
          <div class="description mb-2">
            <div class="card-body">
              <div class=" justify-content-between single-apartment" lat="{{ $apartment->latitude }}" lng="{{ $apartment->longitude }}">
                <div>
                  <h2 id="title" class="card-title">{{ $apartment->title }}</h2>
                  <h4>{{ $apartment->address }}, {{ $apartment->city }}, {{ $apartment->zip }}</h4>
                </div>
                @if ($logged_user->id === $apartment->user->id)
                  <div class="btn-adm">
                    <a class="btn-add_app" href="{{ route('admin.statistics', $apartment) }}"><i class="fas fa-chart-line"></i> Statistiche</a>
                    <a class="btn-add_app" href="{{ route('admin.payment', $apartment) }}">Sponsorizza</a>
                  </div>
              @endif
              </div>
              <ul class="info">
                <li>Stanze: {{ $apartment->rooms }} |</li>
                <li> Bagni: {{ $apartment->baths }} |</li>
                <li> Letti: {{ $apartment->beds }} |</li>
                <li> Ospiti: {{ $apartment->guests}} |</li>
                <li> Dimensione: {{ $apartment->mqs }} mq</li>
              </ul>
              <p>{{ $apartment->description }}</p>
              <div class="services-list mb-2">

                @if ($apartment->services->isEmpty())
                  <p>Non ci sono servizi</p>
                @else
                  <ul>
                    @foreach ($apartment->services as $service)
                      <li>
                        @if ($service->name == 'Wifi')
                          <i class="fas fa-wifi"></i>
                        @elseif ($service->name == 'Parcheggio')
                            <i class="fas fa-parking"></i>
                          @elseif ($service->name == 'Animali ammessi')
                              <i class="fas fa-dog"></i>
                            @elseif ($service->name == 'Aria condizionata')
                              <i class="fas fa-fan"></i>
                            @elseif ($service->name == 'Servizio lavanderia')
                              <i class="fas fa-washer"></i>
                            @elseif ($service->name == 'Tv')
                              <i class="fas fa-tv"></i>
                            @elseif ($service->name == 'Cucina')
                              <i class="fas fa-utensils"></i>
                            @elseif ($service->name == 'Breakfast')
                              <i class="far fa-coffee"></i>
                            @elseif ($service->name == 'Piscina')
                              <i class="fas fa-swimming-pool"></i>
                        @endif
                        {{$service->name}}</li>
                    @endforeach
                  </ul>
                @endif
              </div>
            </div>
          </div>

        </div>
        <div class="col-lg-6 col-md-12 apartment-email">
          <div class="message-form mb-2">
            <div class="card-body">
              @if ($logged_user->id === $apartment->user->id)
                <div class="link-adm">
                  <a href="{{route('admin.received-emails') }}"><p>Vai ai tuoi messaggi</p></a>
                  <hr>
                  <a href="{{route('admin.user-apartments') }}"><p>Vai ai tuoi appartamenti</p></a>
                </div>

              @else
              <h3>Scrivi al proprietario</h3>
              <form class="email-form" action="{{route('send-email', $apartment)}}" method="post">
                @csrf
                @method('POST')
                <div>
                  <input type="text" name="userMail" value="{{$logged_user->email}}" readonly placeholder="Email">
                </div>
                <div>
                  <textarea name="bodyMessage" rows="8" cols="46" placeholder="Scrivi un messaggio"></textarea>
                </div>
                <div>
                  <input type="submit" name="" value="Invia">
                </div>
              </form>
            @endif
            </div>
          </div>
          @if (session('success'))
            <div id="success_message" class="message ">
              {{session('success')}}
            </div>
          @endif
        </div>
        <div class="col-12 apartment-admin-function">
          {{-- <a class="btn btn-primary" href="{{ route('admin.apartments.index')}}"> Torna alla lista appartamenti</a> --}}
          @if ($logged_user->id === $apartment->user->id)
            <ul class="button">
              <li><a class="btn btn-add_app " href="{{ route('admin.apartments.edit', $apartment) }}"> Modifica Appartamento</a></li>
              <li>
                <form  action="{{ route('admin.apartments.destroy', $apartment) }}" method="post">
                  @csrf
                  @method('DELETE')
                  <input class="btn btn-add_app delete" type="submit" value="Elimina">
                </form>
              </li>
            </ul>
          @endif
        </div>
        <div class="col-md-12 map-query">

          <div class="col-12 apartment-map">
            <div class="mb-2">
              <div class="card-body">
                <h3>Mappa appartamento</h3>
                <div id="map-show-query"></div>
              </div>
            </div>
            <script>
              (function() {

                var title = document.getElementById('title').innerText;

                var latlng = {
                  lat: document.querySelector('.single-apartment').getAttribute("lat"),
                  lng: document.querySelector('.single-apartment').getAttribute("lng")
                };

                var map = L.map('map-show-query', {
                  scrollWheelZoom: false,
                  zoomControl: false,
                  keyboard: false,
                  dragging: false,
                  boxZoom: false,
                  doubleClickZoom: false,
                  tap: false,
                  touchZoom: false,
                });

                var osmLayer = new L.TileLayer(
                  'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    minZoom: 12,
                    maxZoom: 18,
                    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
                  }
                );

                map.setView(new L.LatLng(latlng.lat, latlng.lng), 17);

                map.addLayer(osmLayer);

                var marker = L.marker([latlng.lat, latlng.lng])
                .addTo(map)
                .bindPopup(title);

              })();
            </script>
          </div>

        </div>



      </div>
    </div>
  </section>
@endsection
