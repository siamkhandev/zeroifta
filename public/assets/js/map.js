document.addEventListener('DOMContentLoaded', () => {
    const mapElement = document.getElementById('map');

    // Default center of the map
    const mapCenter = { lat: 37.7749, lng: -122.4194 }; // Replace with your desired center
    const map = new google.maps.Map(mapElement, {
        zoom: 10,
        center: mapCenter,
    });

    // Fetch FTP data and add markers
    axios.get('/api/fetch-ftp-coordinates') // Replace with the correct API endpoint
        .then(response => {
            const data = response.data;

            if (Array.isArray(data) && data.length) {
                data.forEach(record => {
                    const { ftp_lat, ftp_lng, price } = record;

                    const marker = new google.maps.Marker({
                        position: { lat: parseFloat(ftp_lat), lng: parseFloat(ftp_lng) },
                        map: map,
                        title: `Price: $${price}`,
                    });

                    // Add info window for additional details
                    const infoWindow = new google.maps.InfoWindow({
                        content: `<strong>Fuel Price:</strong> $${price}`,
                    });

                    marker.addListener('mouseover', () => infoWindow.open(map, marker));
                    marker.addListener('mouseout', () => infoWindow.close());
                });
            } else {
                console.error('No matching records found.');
            }
        })
        .catch(error => {
            console.error('Error fetching FTP coordinates:', error);
        });
});