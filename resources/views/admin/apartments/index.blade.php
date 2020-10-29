@extends('layouts.app')

@section('title')
  Bool b&b
@endsection

@section('content')

<!-- SEZIONE INPUT DI RICERCA -->
  <section class="input-search" id="input-search-admin">
    <div class="container-fluid">
      <div class="row">
        <!-- JUMBOTRON -->
        <div class="col jumbo-col">
            <div class="d-flex jumbo">
              <div class="jumbo-title">
                <h1>Riscopri l'Italia</h1>
                <h3>Cambia quadro. Scopri alloggi nelle vicinanze <br>tutti da vivere, per lavoro o svago.</h3>
              </div>
              <form action="{{ route('search') }}" class="form-search-apartment d-flex">
                {{-- viene incluso il file che cerca gli appartamenti in base alle città e gli indirizzi --}}
                @include('partials.search-partials.search-city_address')
              </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SEZIONE LISTA APPARTAMENTI -->
  <section class="apartments-admin" id="apartments-admin">
    <div class="container-fluid">

      @if (!$sponsoredApartments->isEmpty())
        <!-- Appartamenti in evidenza -->
        <h2 class="heading text-center"><span>Appartamenti in evidenza</span></h2>
        <div class="card-sponsored mb-5">
          <div class="row apartments sponsored-apartments d-flex justify-content-center">

            @foreach ($sponsoredApartments as $sponsoredApartment)
              <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 single-apartment" lat="{{ $sponsoredApartment->latitude }}" lng="{{ $sponsoredApartment->longitude }}">
                <div class="img-container card">
                  <div class="sponsor-index">
                    <h2>Sponsorizzato</h2>
                  </div>
                  <img class="apartment-image" src="{{ $sponsoredApartment->image }}" alt="Immagine appartamento">
                  <div class="title-container">
                    <h5>{{ $sponsoredApartment->title }}</h5>
                      <p class="guests">{{$sponsoredApartment->guests}} ospiti · {{$sponsoredApartment->mqs}} mq · {{$sponsoredApartment->rooms}} stanze · {{$sponsoredApartment->baths}} letti </p>
                    <p class="services">
                       @foreach ($sponsoredApartment->services as $service)

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
                          {{-- {{$service->name}} --}}
                      @endforeach
                    </p>
                    <p>{{ $sponsoredApartment->description }}</p>
                  </div>
                <div class="admin-function">
                  <div class="btn-flex">
                    <a class="btn btn-add_app" href="{{ route('admin.apartments.show', $sponsoredApartment)}}">Show</a>
                  </div>
                  @if ($logged_user->id === $sponsoredApartment->user->id)
                    <div class="btn-edit">
                      <a class="btn btn-add_app " href="{{ route('admin.apartments.edit', $sponsoredApartment) }}">Modifica</a>
                    </div>

                    <div class="btn-delete">
                      <form  action="{{ route('admin.apartments.destroy', $sponsoredApartment) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input class="btn btn-add_app delete" type="submit" value="Elimina">
                      </form>
                    </div>
                  @endif
                </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

    </div>
  </section>
@endsection
