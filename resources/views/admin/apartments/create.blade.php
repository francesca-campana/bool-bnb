@extends('layouts.app')

@section('title')
  Bool b&b create
@endsection

@section('content')
<section id="create">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1 class="title_form"> Crea il tuo appartamento</h1>


        {{-- Validazione form --}}
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="create_form">
          <form action="{{route('admin.apartments.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div>
              <label>Titolo appartamento</label>
              <input type="text" name="title" value="{{old('title')}}" placeholder="Titolo appartamento">
            </div>

            <div>
              <label>Descrizione appartamento</label>
              <textarea name="description" rows="8" cols="80" placeholder="Description">{{old('description')}}</textarea>
            </div>

            <div>
              <label>Numero stanze</label>
              <input type="number" name="rooms" value="{{old('rooms')}}" placeholder="Numero stanze">
            </div>

            <div>
              <label>Numero bagni</label>
              <input type="number" name="baths" value="{{old('baths')}}" placeholder="Numero bagni">
            </div>

            <div>
              <label>Numero letti</label>
              <input type="number" name="beds" value="{{old('beds')}}" placeholder="Numero letti">
            </div>

            <div>
              <label>Numero ospiti</label>
              <input type="number" name="guests" value="{{old('guests')}}" placeholder="Numero ospiti">
            </div>

            <div>
              <label>Metratura in mq</label>
              <input type="number" name="mqs" value="{{old('mqs')}}" placeholder="Metratura in mq">
            </div>

            <div class="form-group">
              <label for="form-address">Indirizzo*</label>
              <input value="{{old('address')}}" name="address" type="search" class="form-control" id="form-address" placeholder="Inserisci l'indirizzo del tuo appartamento" />
            </div>
            <div class="form-group">
              <label for="form-city">Città*</label>
              <input value="{{old('city')}}" name="city" type="text" class="form-control" id="form-city" placeholder="City" />
            </div>
            <div class="form-group">
              <label for="form-zip">CAP/ZIP*</label>
              <input value="{{old('zip')}}" name="zip" type="text" class="form-control" id="form-zip" placeholder="ZIP code" />
            </div>
            <div class="split" style="display: none">
              <div class="form-group">
                <label for="form-lat">Latitude</label>
                <input value="{{old('latitude')}}" name="latitude" type="text" class="form-control" id="form-lat" placeholder="Latitude" />
              </div>
              <div class="form-group">
                <label for="form-lng">Longitude</label>
                <input value="{{old('longitude')}}" name="longitude" type="text" class="form-control" id="form-lng" placeholder="Longitude" />
              </div>
            </div>

            <div class="checkboxes">
              <span>Servizi aggiuntivi</span>
              @foreach ($services as $service)
                <div>
                  <input class="single-check" type="checkbox" name="services[]" value="{{$service->id}}">
                  <label>{{$service->name}}</label>
                </div>
              @endforeach
            </div>

            <div class="">
              <label>Inserisci immagine</label>
              <input type="file" name="image_path" accept="image/*">
            </div>

            <input class="save-btn" type="submit" value="Salva">

          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
