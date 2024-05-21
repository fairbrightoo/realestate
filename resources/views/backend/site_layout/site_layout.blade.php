@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <style>
    #map {
      height: 600px;
    }
  </style>

<div class="page-content">
  <div id="map"></div>

  <div id="plotModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Plot Information</h2>
      <p>Plot Number: <span id="plotNumber"></span></p>
      <p>Status: <span id="plotStatus"></span></p>
      <button id="payButton">Proceed to Payment</button>
    </div>
  </div>

  <script>
    const plotData = [
      { id: 1, coords: [{ lat: 8.989318333264551, lng: 7.6115524455879395 }, { lat: 8.989276973291757, lng: 7.611425343135532 }, { lat: 8.989539771344825, lng: 7.61136621453288 }, { lat: 8.989583715804006, lng: 7.611495262686182 }], status: 'sold' },
      { id: 2, coords: [{ lat: 8.98925278, lng: 7.61170000 }, { lat: 8.98931389, lng: 7.61187500 },  { lat: 8.98917778, lng: 7.61189167 }, { lat: 8.98907222, lng: 7.61169167 }], status: 'reserved' },
      { id: 3, coords: [{ lat: 8.98935833, lng: 7.61164167 }, { lat: 8.98958611, lng: 7.61159444 }, { lat: 8.98961389, lng: 7.61173333 }, { lat: 8.98937500, lng: 7.61175833 }], status: 'processing' },
      //{ id: 4, coords: [{ lat: 9.065363, lng: 7.484817 }, { lat: 9.065359, lng: 7.484730 }, { lat: 9.065301, lng: 7.484735 }, { lat: 9.065305, lng: 7.484823 }], status: 'processing' },
      // Add more plots here as needed
      //{ id: 1, coords: [{ lat: 9.066166, lng: 7.485071 }, { lat: 9.066380, lng: 7.485552 }, { lat: 9.065961, lng: 7.486130 }, { lat: 9.065699, lng: 7.485619 }], status: 'sold' },
      // Continue adding plots up to 20
    ];

    function initMap() {
      const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 8.989318333264551, lng: 7.6115524455879395 },
        // center: { lat: 9.065991, lng: 7.485850 },
        zoom: 18
      });

      plotData.forEach(plot => {
        const plotPolygon = new google.maps.Polygon({
          paths: plot.coords,
          strokeColor: '#000000',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: getStatusColor(plot.status),
          fillOpacity: 0.6,
          clickable: true
        });

        plotPolygon.setMap(map);

        google.maps.event.addListener(plotPolygon, 'click', function() {
          openModal(plot);
        });
      });
    }

    function openModal(plot) {
      const modal = document.getElementById('plotModal');
      const plotNumberElement = document.getElementById('plotNumber');
      const plotStatusElement = document.getElementById('plotStatus');
      const payButton = document.getElementById('payButton');

      plotNumberElement.textContent = plot.id;
      plotStatusElement.textContent = plot.status;

      if (plot.status === 'available' || plot.status === 'reserved') {
        payButton.style.display = 'block';
      } else {
        payButton.style.display = 'none';
      }

      modal.style.display = 'block';

      const closeButton = document.getElementsByClassName('close')[0];
      closeButton.onclick = function() {
        modal.style.display = 'none';
      };

      window.onclick = function(event) {
        if (event.target === modal) {
          modal.style.display = 'none';
        }
      };
    }

    function getStatusColor(status) {
      switch (status) {
        case 'available':
          return '#00FF00';
        case 'sold':
          return '#FF0000';
        case 'reserved':
          return '#FFFF00';
        case 'processing':
          return '#FFA500';
        default:
          return '#FFFFFF';
      }
    }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcpsQJ3rUvTn1S1-zEDrlA7g_QicgcexQ&callback=initMap" async defer></script>
</div>
@endsection
