require('./bootstrap');

// viene incluso jquery
var $ = require( "jquery" );

// viene incluso handlebars
var Handlebars = require("handlebars");

// viene incluso chart.js
var Chart = require('chart.js');

$(document).ready(function() {

  // al click compare la tendina dei filtri
  $('#btn-slide').click(function() {
    $('#filters-drop').slideToggle();

    if ($('#angle').hasClass('fa-angle-up')) {
      $('#angle').removeClass('fa-angle-up');
      $('#angle').addClass('fa-angle-down');
    } else {
      $('#angle').removeClass('fa-angle-down');
      $('#angle').addClass('fa-angle-up');
    }

    if ($('#btn-filter-page').hasClass('d-none')) {
      $('#btn-filter-page').removeClass('d-none');
      $('#btn-filter-page').addClass('d-block');
    } else {
      $('#btn-filter-page').removeClass('d-block');
      $('#btn-filter-page').addClass('d-none');
    }

  });

  // al click compare la data di sponsorizzazione
  $('.info').click(function(){
    $('ol').slideToggle();
    if ($('ol').hasClass('d-none')) {
      $('ol').addClass('d-block');
        $('ol').removeClass('d-none');
    }else {
        $('ol').addClass('d-none');
          $('ol').removeClass('d-block');
    }

  });
});

// funzione ricerca appartamenti
  (function() {

    // autocomplete ricerca città
    var placesAutocomplete = places({
      container: document.querySelector("#form-city"),
      templates: {
        value: function(suggestion) {
          return suggestion.name;
        }
      }
    }).configure({
      type: [
        "city",
        "address"
      ]
    });

    // autocompleta la città, e lo zip inserendo nell'input l'indirizzo nell'edit e nel create
    if (document.URL.includes("edit") ||  document.URL.includes("create")) {
      var placesAutocomplete = places({
        container: document.querySelector("#form-address"),
        templates: {
          value: function(suggestion) {
            return suggestion.name;
          }
        }
      }).configure({
        type: "address"
      });

      // otteniamo i dati che immettiamo nelle input e le autocompleta
      placesAutocomplete.on("change", function resultSelected(e) {
        document.querySelector("#form-city").value = e.suggestion.city || "";
        document.querySelector("#form-zip").value =
          e.suggestion.postcode || "";
        document.querySelector("#form-lat").value =
          e.suggestion.latlng.lat || "";
        document.querySelector("#form-lng").value =
          e.suggestion.latlng.lng || "";
      });
    }

    // se ci troviamo nella pagina search al click parte una chiamata ajax
    // che aggiorna i risultati senza ricaricare la pagina
    if (document.URL.includes("search")) {

      $('#btn-search').click(function () {

        // rimuove i marker e il cerchio
        map.eachLayer((layer) => {
          layer.remove();
        });

        // variabili che leggono il valore delle input se ci troviamo nel search
        var latitude = document.querySelector("#form-lat").value;
        var longitude = document.querySelector("#form-lng").value;
        var radius = document.querySelector("#form-rad").value;
        var minRooms = document.querySelector("#form-minRooms").value;
        var minBeds = document.querySelector("#form-minBeds").value;
        var minBaths = document.querySelector("#form-minBaths").value;
        var city = document.querySelector("#form-city").value;

        var servicesArray = []
        // otteniamo il valore della checkbox e con un ciclo le pushamo dentro l'array vuoto servicesArray
        var services = document.querySelectorAll("input[type=checkbox]:checked");
        for (var i = 0; i < services.length; i++) {
          servicesArray.push(services[i].value)
        }

        // se il raggio è vuoto o minore di uno o non è un numero assegna un valore di default di 20 km
        if (radius == '' || radius < 1 || isNaN(radius)) {
          radius = 20
        }

        // viene richiamata la funzione ajax
        ajaxMarkers(city,latitude,longitude,radius,minRooms,minBeds,minBaths,servicesArray);

        // variabile cerchio e valore raggio aggiunto alla mappa in base a latitudine e longitudine
        var circle = L.circle([latitude, longitude], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius * 1000
        }).addTo(map);

        // vine inpostato lo zoom in base alla dimensione del raggio
        var customZoom
        if (radius <= 1) {
          customZoom = 15
        } else if (radius >= 2 && radius < 5) {
          customZoom = 14
        } else if (radius >= 5 && radius < 10) {
          customZoom = 13
        } else if (radius >= 10 && radius < 20) {
          customZoom = 12
        } else if (radius >= 20 && radius < 40) {
          customZoom = 11
        } else if (radius >= 40 && radius < 60) {
          customZoom = 10
        } else if (radius >= 60 && radius < 100) {
          customZoom = 9
        } else if (radius >= 100 && radius < 150) {
          customZoom = 8
        } else {
          customZoom = 7
        }

        // viee visulizzata la mappa in base alla latitudine, alla longitudine e viene anche impostato lo zoom
        map.setView(new L.LatLng(latitude, longitude), customZoom);

        // crea un layer alla mappa
        map.addLayer(osmLayer);

        // richiama le funzioni di interazione
        placesAutocomplete.on('cursorchanged', handleOnCursorchanged);
        placesAutocomplete.on('clear', handleOnClear);
        placesAutocomplete.on('change', handleOnChange);

      })

      // variabili che leggono il valore delle input se ci troviamo nell'index
      var latitude = document.querySelector("#form-lat").value;
      var longitude = document.querySelector("#form-lng").value;
      var radius = document.querySelector("#form-rad").value;
      var minRooms = document.querySelector("#form-minRooms").value;
      var minBeds = document.querySelector("#form-minBeds").value;
      var minBaths = document.querySelector("#form-minBaths").value;
      var city = document.querySelector("#form-city").value;

      // se il raggio è vuoto o minore di uno o non è un numero assegna un valore di default di 20 km
      if (radius == '' || radius < 1 || isNaN(radius)) {
        radius = 20
      }

      ajaxMarkers(city,latitude,longitude);

      // classe mappa nell'html
      var map = L.map('map-search', {
        scrollWheelZoom: true,
        zoomControl: true
      });

      // layer mappa con zoom e crediti
      var osmLayer = new L.TileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
          minZoom: 1,
          maxZoom: 19,
          attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }
      );

      // array dei marker
      var markers = [];

      // variabile cerchio che viene creato quando effettuiamo la ricerca nell'index
      var circle = L.circle([latitude, longitude], {
          color: 'red',
          fillColor: '#f03',
          fillOpacity: 0.5,
          radius: radius * 1000
      }).addTo(map);

      // vine inpostato lo zoom in base alla dimensione del raggio
      var customZoom
      if (radius <= 5) {
        customZoom = 14
      } else if (radius >= 5 && radius < 10) {
        customZoom = 13
      } else if (radius >= 10 && radius < 20) {
        customZoom = 12
      } else if (radius >= 20 && radius < 40) {
        customZoom = 11
      } else if (radius >= 40 && radius < 60) {
        customZoom = 10
      } else if (radius >= 60 && radius < 100) {
        customZoom = 9
      } else if (radius >= 100 && radius < 150) {
        customZoom = 8
      } else {
        customZoom = 7
      }

      // viee visulizzata la mappa in base alla latitudine, alla longitudine e viene anche impostato lo zoom
      map.setView(new L.LatLng(latitude, longitude), customZoom);

      map.addLayer(osmLayer);

      // richiama le funzioni di interazione
      placesAutocomplete.on('cursorchanged', handleOnCursorchanged);
      placesAutocomplete.on('clear', handleOnClear);
      placesAutocomplete.on('change', handleOnChange);
    }

    // otteniamo i dati della città e autocompleta latitudine e longitudine
    placesAutocomplete.on("change", function resultSelected(e) {
      document.querySelector("#form-lat").value =
        e.suggestion.latlng.lat || "";
      document.querySelector("#form-lng").value =
        e.suggestion.latlng.lng || "";
    });

// --------------------------------------------------------------------------------------
///////////////////////////////// SEZIONE FUNZIONI //////////////////////////////////////
// --------------------------------------------------------------------------------------

// --------------------------------------------------------------------------------------
      // funzione ajax che ricerca gli appartamenti in base ai filtri
      function ajaxMarkers(city,latitude, longitude, radius, minRooms, minBeds, minBaths, servicesArray) {

        $.ajax({
          method: 'GET',
          url: 'search',
          data: {
            city: city,
            lat: latitude,
            lng: longitude,
            rad: radius,
            minRooms: minRooms,
            minBeds: minBeds,
            minBaths: minBaths,
            services: servicesArray,
          },
          complete : function(){
            // restituisce un nuovo url ogni volta che facciamo una ricerca
            var newurl = this.url
            history.pushState({}, null, newurl);

            console.log(newurl)
          },

          success: function(result){
            // la pagina diventa vuota
            $('#handlebars-apartments').html('')

            // variabili handlebars
            var source = document.getElementById("entry-template").innerHTML;
            var template = Handlebars.compile(source);

            // contiamo i risultati ottenuti
            var counter = $('#counter')
            counter.text(result.length + ' Risultati per ' + city)

            // ciclo che appende i risultati nella pagina search
            for (var i = 0; i < result.length; i++) {
              var singleResult = result[i]
              console.log(result);
              // icona marker personalizzata
              var houseIcon = L.icon({
                iconUrl: 'images/house.png',
                iconSize: [60, 60],
              });
              var allServices = singleResult.services;
              var listServices = [];
              for (var j = 0; j < allServices.length; j++) {
                var singleService = allServices[j];
                var serviceIco;
                if (singleService.name == 'Wifi') {
                  serviceIco = '<i class="fas fa-wifi"></i>'
                }else if (singleService.name == 'Parcheggio') {
                  serviceIco = '<i class="fas fa-parking"></i>'
                }else if (singleService.name == 'Animali ammessi') {
                  serviceIco = '<i class="fas fa-dog"></i>'
                }else if (singleService.name == 'Aria condizionata') {
                  serviceIco = '<i class="fas fa-fan"></i>'
                }else if (singleService.name == 'Servizio lavanderia') {
                  serviceIco = '<i class="fas fa-washer"></i>'
                }else if (singleService.name == 'Tv') {
                  serviceIco = '<i class="fas fa-tv"></i>'
                }else if (singleService.name == 'Cucina') {
                  serviceIco = '<i class="fas fa-utensils"></i>'
                }else if (singleService.name == 'Breakfast') {
                  serviceIco = '<i class="far fa-coffee"></i>'
                }else if (singleService.name == 'Piscina') {
                  serviceIco = '<i class="fas fa-swimming-pool"></i>'
                }

                listServices.push(serviceIco);
                var servizi = listServices.join(' ');
              }

              // console.log(singleResult);
              // var context = servizi
              // var html = template(context);
              // $('p.card-body').append(html)
              //
              // console.log(listServices);

              L.marker([singleResult.latitude, singleResult.longitude]/*, {icon: houseIcon}*/).addTo(map)
              .bindPopup(singleResult.title)

              var context = {
                title: singleResult.title,
                image: singleResult.image,
                guests: singleResult.guests,
                rooms: singleResult.rooms,
                baths: singleResult.baths,
                beds: singleResult.beds,
                latitude: singleResult.latitude,
                id: singleResult.id,
                description: singleResult.description,
                longitude: singleResult.longitude,
                services: servizi
              }
              // var context = singleResult;
              var html = template(context);

              $('#handlebars-apartments').append(html);
            }

          },

          error: function(XMLHttpRequest, textStatus, errorThrown)
            { alert(errorThrown); },
        });
      }
// --------------------------------------------------------------------------------------
    function handleOnChange(e) {
      markers
        .forEach(function(marker, markerIndex) {
          if (markerIndex === e.suggestionIndex) {
            markers = [marker];
            marker.setOpacity(1);
            findBestZoom();
          } else {
            removeMarker(marker);
          }
        });
    }

    function handleOnSuggestions(e) {
      markers.forEach(removeMarker);
      markers = [];

      if (e.suggestions.length === 0) {
        map.setView(new L.LatLng(latitude, longitude), 7);
        return;
      }

      e.suggestions.forEach(addMarker);
      findBestZoom();
    }

    function handleOnClear() {
      map.setView(new L.LatLng(latitude, longitude), 15);
      markers.forEach(removeMarker);
    }

    function handleOnCursorchanged(e) {
      markers
        .forEach(function(marker, markerIndex) {
          if (markerIndex === e.suggestionIndex) {
            marker.setOpacity(1);
            marker.setZIndexOffset(1000);
          } else {
            marker.setZIndexOffset(0);
            marker.setOpacity(0.5);
          }
        });
    }

    function addMarker(suggestion) {
      var marker = L.marker(suggestion.latlng, {opacity: .3});
      marker.addTo(map);
      markers.push(marker);
    }

    function removeMarker(marker) {
      map.removeLayer(marker);
    }

    function findBestZoom() {
      var featureGroup = L.featureGroup(markers);
      map.fitBounds(featureGroup.getBounds().pad(0.5), {animate: false});
    }

  })();
