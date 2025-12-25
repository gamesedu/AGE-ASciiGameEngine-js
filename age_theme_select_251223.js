//age_theme_select.js
// v251223 - Modified for UDG themes (DATA must be | seperated not comma eg 56|120|16|57|254|60|126|36 )
// v250408a - initial version
//
//
//
// Function to create dropdown and button elements
function createDropdownAndButton() {
    // Create select element
    const selectBox = document.createElement('select');
    selectBox.id = 'theme-select';
    selectBox.addEventListener('change', selectTheme); // Add change event listener

    // Create button element
    const button = document.createElement('button');
    button.textContent = 'Select Theme';
    button.addEventListener('click', selectTheme); // Add click event listener for button

    // Append the select box and button to the body or a specific container
    const container = document.getElementById('theme-container'); // Set your container ID
    if (container) {
        container.appendChild(selectBox);
        container.appendChild(button);
    }
}

// Function to fetch CSV file and populate the dropdown
function fetchThemes() {
    fetch('age_themes.csv')
        .then(response => response.text()) // Get the CSV as text
        .then(data => {
            const lines = data.split('\n'); // Split by new lines
            const selectBox = document.getElementById('theme-select');

            // Clear existing options
            selectBox.innerHTML = '';

            // Add each theme as an option
            lines.forEach((line, index) => {
                if (line) {
                    const columns = line.split(','); // Split by comma
                    const themeName = columns[0]; // Assuming the first column is the theme name
                    const option = document.createElement('option');
                    option.value = index; // Store the line number as the value
                    option.textContent = themeName;
                    selectBox.appendChild(option);
                }
            });
        })
        .catch(error => console.error('Error fetching the CSV file:', error));
}

// Function to autofill the input fields based on selected theme
function selectTheme() {
    const selectBox = document.getElementById('theme-select');
    const selectedIndex = selectBox.value;
    
    fetch('age_themes.csv')
        .then(response => response.text())
        .then(data => {
            const lines = data.split('\n');
            const selectedLine = lines[selectedIndex];

            if (selectedLine) {
                //const columns = selectedLine.split(',');
                //const columns = selectedLine.split(/[,\|]/);
                const columns = selectedLine.split(',');

                // Fill input fields with CSV data
                document.getElementById('player-url').value = columns[1].replace(/\|/g, ',') || '';
                document.getElementById('enemy-url').value = columns[2].replace(/\|/g, ',') || '';
                document.getElementById('enemy2-url').value = columns[3].replace(/\|/g, ',') || '';
                document.getElementById('enemy3-url').value = columns[4].replace(/\|/g, ',') || '';
                document.getElementById('item1-url').value = columns[5].replace(/\|/g, ',') || '';
                document.getElementById('obstacle-url').value = columns[6].replace(/\|/g, ',') || '';
                document.getElementById('goal-url').value = columns[7].replace(/\|/g, ',') || '';
                document.getElementById('gold-url').value = columns[8].replace(/\|/g, ',') || '';
                document.getElementById('wall1-url').value = columns[9].replace(/\|/g, ',') || '';
                document.getElementById('wall2-url').value = columns[10].replace(/\|/g, ',') || '';
            }
        })
        .catch(error => console.error('Error fetching the CSV file:', error));
}

// Load themes on page load
//window.onload = () => {
    createDropdownAndButton(); // Create dropdown and button before fetching themes
    fetchThemes(); // Then fetch themes
//};