function fetchVehicleData() {
    $.ajax({
        url: "fetch_vehicles.php",
        method: "GET",
        success: function (data) {
            const container = document.getElementById("vehicles-container");
            container.innerHTML = ""; // Clear previous data
            data.forEach(vehicle => {
                const status = vehicle.status.toLowerCase();
                const elapsed = Math.floor((new Date() - new Date(vehicle.last_update)) / 60000);
                
                let className = "run";
                if (status === "stop" && elapsed >= 3) {
                    className = "stop";
                } else if (status === "park" && elapsed > 3) {
                    className = "park";
                }

                const vehicleDiv = document.createElement("div");
                vehicleDiv.className = `vehicle ${className}`;
                vehicleDiv.innerText = `ID: ${vehicle.vehicle_id}\nStatus: ${vehicle.status}`;
                container.appendChild(vehicleDiv);
            });
        },
        error: function () {
            console.error("Failed to fetch vehicle data. Please check the backend or network.");
        }
    });
}

// Refresh data every 5 seconds
setInterval(fetchVehicleData, 5000);
