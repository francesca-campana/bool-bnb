{{-- filtra in base ai km --}}
<div class="form-group filters">
  <label>Raggio</label>
  <input name="rad" type="number" class="ap-input my-number" id="form-rad" placeholder="Raggio in km" value="{{request()->input('rad')}}" />
</div>

<hr>

{{-- Filtro per informazioni appartamenti --}}
<div class="row rbb">
  <div class="col-6 form-group filters">
    <label>Numero minimo camere</label>
    <input id="form-minRooms" class="ap-input my-number" name="minRooms" type="number" placeholder="Camere" value="{{request()->input('minRooms')}}">
  </div>
  <div class="col-6 form-group filters">
    <label>Numero minimo letti</label>
    <input id="form-minBeds" class="ap-input my-number" name="minBeds" type="number" placeholder="Letti" value="{{request()->input('minBeds')}}">
    </div>
  <div class="col-6 form-group filters">
    <label>Numero minimo bagni</label>
    <input id="form-minBaths" class="ap-input my-number" name="minBaths" type="number" placeholder="Bagni" value="{{request()->input('minBaths')}}">
  </div>
</div>

<hr>

{{-- Filtro per servizi --}}
<div class="form-group filters justify-content-between">
  <h4 class="title-services">Servizi</h4>
  <div class="checkboxes row">
      @foreach ($services as $service)
        <div class="col-4 d-flex align-items-start">
          <input class="checkbox" type="checkbox" name="services[]" value="{{$service->id}}">
          <label class="ml-2">{{$service->name}}</label>
        </div>
      @endforeach
  </div>
</div>

<button id="btn-search" class="btn-index-search" type="button"><i class="search-icon fas fa-search"></i>Cerca</button>
