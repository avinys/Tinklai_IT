function fetchMunicipalities(regionId) {
        const municipalityDropdown = document.getElementById('municipality');
        
        // Clear the current municipality options and set the loading message
        municipalityDropdown.innerHTML = '<option value="">Įkeliama...</option>';

        // Ensure regionId is valid before making the request
        if (regionId === "") {
            municipalityDropdown.innerHTML = '<option value="">Pasirinkite savivaldybę</option>';
            return;
        }

        // Fetch the municipalities for the selected region
        fetch(`index.php?page=fetch-municipalities&region=${regionId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Clear loading message
                municipalityDropdown.innerHTML = '<option value="">Pasirinkite savivaldybę</option>';
                
                // Populate municipalities dropdown
                data.forEach(municipality => {
                    const option = document.createElement('option');
                    option.value = municipality.id;
                    option.textContent = municipality.name;
                    municipalityDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching municipalities:', error);
                municipalityDropdown.innerHTML = '<option value="">Nepavyko įkelti savivaldybių</option>';
            });
    }