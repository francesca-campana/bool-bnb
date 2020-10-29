@extends('layouts.app')

@section('title')
  Bool b&b Cerca
@endsection

@section('content')
<section id="search-results">
  <div class="container-fluid">
    <div class="row">
      {{-- Risultati ricerca --}}
      <div class="col-xl-7 col-lg-7 col-md-12">
        <h2 class="heading">Appartamenti nell'area selezionata della mappa</h2>
        <p id="counter"></p>
        <div id="filters-container">
          <form action="{{ route('search') }}" class="form-search-apartment">
            {{-- viene incluso il file che cerca gli appartamenti in base alle città e gli indirizzi --}}
            @include('partials.search-partials.search-city_address')
            <div id="filters-drop" class="card">
              <div class="card-body">
                {{-- viene incluso il file che cerca gli appartamenti filtrandoli --}}
                @include('partials.search-partials.filters')
              </div>
            </div>
          </form>
          <div id="btn-slide"class="text-center">
            <i id="angle" class="fas fa-angle-down"></i>
          </div>
        </div>

        @if (!$sponsoredApartments->isEmpty())
          <div class="heading">
            <h2>Appartamenti in evidenza</h2>
          </div>
          <div class="row sponsored-apartments d-flex">

            @foreach ($sponsoredApartments as $sponsoredApartment)
              <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-sx-6 single-apartment" lat="{{ $sponsoredApartment->latitude }}" lng="{{ $sponsoredApartment->longitude }}">
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

                </div>
              </div>
            @endforeach
          </div>
        @endif


        <div class="handlebars-container">
          <h2 class="heading">Risultati appartamenti</h2>
          <div>
            <div  class="row search-results-container">
              <div id="handlebars-apartments" class="col-12 img-container">

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-5 col-lg-5 col-md-12">
        {{-- Mappa --}}
        <div id="map-search"></div>
      </div>

      {{-- TEMPLATE HANDLEBARS --}}
        <script id="entry-template" type="text/x-handlebars-template">
          <div class="single-apartment card" lat="@{{ latitude }}" lng="@{{ longitude }}">
            @if (Auth::check())
              <a href="admin/apartments/@{{id}}" class="btn-blue">
              @else
              <a href="apartments/@{{id}}" class="btn-blue">
            @endif
                <div class="apartment-image card-body">
                  <div class="dark-filter"></div>
                  <img class="apartment-image" src="@{{ image }}" alt="">
                </div>
              </a>

            <div class="card-body text title-container">
              <h5 class="card-title">@{{title}}</h5>
              <p class="guests">@{{guests}} ospiti · @{{rooms}} Stanze · @{{beds}} letti · @{{baths}} bagni</p>
              <p class="icone services"> @{{{ services }}}</p>
              <p class="description"> @{{{ description }}}</p>
            </div>
          </div>
        </script>

    </div>
  </div>
</section>
@endsection
