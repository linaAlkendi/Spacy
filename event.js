document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('EventForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var year = document.getElementById('year').value;

        // Validate year to be positive numbers
        if (!(/^\d+$/.test(year))) {
            alert("Year must be a positive number.");
            return;
        }

        var encodedData = 'year=' + encodeURIComponent(year);

        fetch('Events.php', {
            method: 'POST',
            body: encodedData, // Send URL-encoded data
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok. Status Code: ' + response.status);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('eventsTable').innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('eventsTable').innerHTML = 'Error loading the data: ' + error.message;
        });
    });

});
