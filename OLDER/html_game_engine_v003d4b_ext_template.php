<!DOCTYPE html>
<!--
html_game_engine
v003d4 - import imageURL also
v003d3 - external html template
v003c - 250405 on Iron, img ,import/exportworks. ToDo: in export template no colors
v003b - 250405 initial- seem to work

--> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASCII Game Designer</title>
    <style>
        body { font-family: monospace; background: #f4f4f4; }
        #grid { display: grid; grid-template-columns: repeat(20, 20px); }
        .cell { width: 20px; height: 20px; text-align: center; border: 1px solid #ccc; cursor: pointer; }
        .player { background: lightblue; }
        .enemy { background: lightcoral; }
        .obstacle { background: lightgray; }
        .goal { background: lightgreen; }
        .gold { background: gold; }
        .wall1 { background: darkgray; }
        .wall2 { background: gray; }
        #commands { margin-top: 20px; }
        .legend { margin-top: 20px; }
        .image-inputs { margin-top: 10px; }
        img { width: 100%; height: 100%; }
    </style>
</head>
<body>
    <h1>ASCII Game Designer</h1>
    <div id="grid"></div>
    <div id="commands">
        <button onclick="playGame()">Play</button>
        <button onclick="exportGame()">Export</button>
        <input type="file" id="import-file" accept=".html" />
        <button onclick="importGame()">Import</button>
        <br>
        <span>Current Symbol: <span id="current-symbol">P</span></span>
        <br>
        <label for="symbol-select">Choose a symbol:</label>
        <select id="symbol-select" onchange="changeSymbol()">
            <option value="P">Player (P)</option>
            <option value="E">Enemy (E)</option>
            <option value="#">Obstacle (#)</option>
            <option value="&">Goal (&)</option>
            <option value="$">Gold ($)</option>
            <option value="[">Wall Type 1 ([)</option>
            <option value="]">Wall Type 2 (])</option>
        </select>
    </div>
    <div class="legend">
        <h3>Legend:</h3>
        <div>P = Player</div>
        <div>E = Enemy</div>
        <div># = Obstacle</div>
        <div>& = Goal</div>
        <div>$ = Gold</div>
        <div>[ = Wall Type 1</div>
        <div>] = Wall Type 2</div>
    </div>
    <div class="image-inputs">
        <h3>Image URLs:</h3>
        <label for="player-url">Player (P):</label>
        <input type="text" id="player-url" placeholder="Image URL">
        <br>
        <label for="enemy-url">Enemy (E):</label>
        <input type="text" id="enemy-url" placeholder="Image URL">
        <br>
        <label for="obstacle-url">Obstacle (#):</label>
        <input type="text" id="obstacle-url" placeholder="Image URL">
        <br>
        <label for="goal-url">Goal (&):</label>
        <input type="text" id="goal-url" placeholder="Image URL">
        <br>
        <label for="gold-url">Gold ($):</label>
        <input type="text" id="gold-url" placeholder="Image URL">
        <br>
        <label for="wall1-url">Wall Type 1 ([):</label>
        <input type="text" id="wall1-url" placeholder="Image URL">
        <br>
        <label for="wall2-url">Wall Type 2 (]):</label>
        <input type="text" id="wall2-url" placeholder="Image URL">
        <br>
        Some Image Ideas: <a href=flaticon/index2_tempbrowse.php target=_blank  >flaticon images </a>
    </div>
    <script>
        const gridSize = 20;
        let currentSymbol = 'P';
        let gridArray = Array.from({ length: gridSize }, () => Array(gridSize).fill('.'));
        let playerPosition = null;
        let goldCollected = 0;
        let images = {};

        const gridElement = document.getElementById('grid');

        // Initialize the grid
        function initGrid() {
            gridElement.innerHTML = '';
            for (let row = 0; row < gridSize; row++) {
                for (let col = 0; col < gridSize; col++) {
                    const cell = document.createElement('div');
                    cell.className = 'cell';
                    cell.onclick = () => placeSymbol(row, col);
                    updateCell(row, col, cell);
                    gridElement.appendChild(cell);
                }
            }
            if (playerPosition) {
                updatePlayerCell();
            }
        }

        // Find player position function
        function findPlayerPosition() {
            for (let row = 0; row < gridSize; row++) {
                for (let col = 0; col < gridSize; col++) {
                    if (gridArray[row][col] === 'P') {
                        return { x: col, y: row };
                    }
                }
            }
            return null;
        }

        // Place symbol on the grid
        function placeSymbol(row, col) {
            if (currentSymbol === 'P') {
                if (playerPosition) {
                    gridArray[playerPosition.y][playerPosition.x] = '.';
                }
                playerPosition = { x: col, y: row };
            }
            gridArray[row][col] = currentSymbol;
            initGrid();
        }

        // Update the cell display with image or character
        function updateCell(row, col, cell) {
            const symbol = gridArray[row][col];
            const imgSrc = getSymbolImage(symbol);
            cell.innerHTML = imgSrc ? `<img src="${imgSrc}" alt="${symbol}">` : symbol;
            cell.className = 'cell ' + getClassNameForSymbol(symbol);
        }

        // Get the image URL for a symbol from the input fields
        function getSymbolImage(symbol) {
            switch (symbol) {
                case 'P': return document.getElementById('player-url').value;
                case 'E': return document.getElementById('enemy-url').value;
                case '#': return document.getElementById('obstacle-url').value;
                case '&': return document.getElementById('goal-url').value;
                case '$': return document.getElementById('gold-url').value;
                case '[': return document.getElementById('wall1-url').value;
                case ']': return document.getElementById('wall2-url').value;
                default: return null; // No image, return null for text
            }
        }

        function getClassNameForSymbol(symbol) {
            switch (symbol) {
                case 'P': return 'player';
                case 'E': return 'enemy';
                case '#': return 'obstacle';
                case '&': return 'goal';
                case '$': return 'gold';
                case '[': return 'wall1';
                case ']': return 'wall2';
                default: return '';
            }
        }

        // Update the cell with player image or character
        function updatePlayerCell() {
            const cell = gridElement.children[playerPosition.y * gridSize + playerPosition.x];
            const imgSrc = getSymbolImage('P');
            cell.innerHTML = imgSrc ? `<img src="${imgSrc}" alt="P">` : 'P';
            cell.className = 'cell player';
        }

        // Change current symbol
        function changeSymbol() {
            currentSymbol = document.getElementById('symbol-select').value;
            document.getElementById('current-symbol').innerText = currentSymbol;
        }

        // Move player logic
        function movePlayer(dx, dy) {
            const newX = playerPosition.x + dx;
            const newY = playerPosition.y + dy;

            if (newX >= 0 && newX < gridSize && newY >= 0 && newY < gridSize) {
                const targetCell = gridArray[newY][newX];
                if (targetCell === '.' || targetCell === '&' || targetCell === '$') {
                    if (targetCell === '$') {
                        goldCollected++;
                        console.log("gold=" + goldCollected);
                    }
                    gridArray[playerPosition.y][playerPosition.x] = '.';
                    playerPosition.x = newX;
                    playerPosition.y = newY;
                    gridArray[playerPosition.y][playerPosition.x] = 'P';
                    initGrid();
                    if (targetCell === '&') {
                        alert(`You win! You collected ${goldCollected} gold.`);
                        goldCollected = 0; // Reset gold for a new game
                    }
                }
            }
        }

        // Handle keyboard input for player movement
        document.addEventListener('keydown', (event) => {
            if (playerPosition) {
                switch (event.key) {
                    case 'ArrowUp':
                        movePlayer(0, -1);
                        break;
                    case 'ArrowDown':
                        movePlayer(0, 1);
                        break;
                    case 'ArrowLeft':
                        movePlayer(-1, 0);
                        break;
                    case 'ArrowRight':
                        movePlayer(1, 0);
                        break;
                }
            }
        });

        // Play Game (Basic implementation)
        function playGame() {
            alert("The game has started! Use arrow keys to move, and place your symbols.");
        }

        // Export Game as HTML file
        function exportGame() {
            let imageUrls = {
                'P': document.getElementById('player-url').value,
                'E': document.getElementById('enemy-url').value,
                '#': document.getElementById('obstacle-url').value,
                '&': document.getElementById('goal-url').value,
                '$': document.getElementById('gold-url').value,
                '[': document.getElementById('wall1-url').value,
                ']': document.getElementById('wall2-url').value
            };

            fetch('htmlTemplate.html') // Fetch the external HTML template
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(htmlTemplate => {
                    // Customize the loaded template content
                    htmlTemplate = htmlTemplate.replace(/<!-- gridSize -->/g, gridSize)
                        .replace(/<!-- gridArray -->/g, JSON.stringify(gridArray))
                        .replace(/<!-- images -->/g, JSON.stringify(imageUrls));

                    // Create a blob and download the exported game
                    const blob = new Blob([htmlTemplate], { type: 'text/html' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'exported_game.html';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        // Import Game from the HTML file

        function importGame() {
            const fileInput = document.getElementById('import-file');
            const file = fileInput.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const content = event.target.result;
                    var gridMatch = content.match(/let gridArray = (\[.*?\]);/);
                    var imagesMatch = content.match(/let images = (\{.*?\});/);                    

                    if (gridMatch && imagesMatch) {
                        gridArray = JSON.parse(gridMatch[1]);
                        images = JSON.parse(imagesMatch[1]);

                        // Populate image input fields with imported image URLs
                        document.getElementById('player-url').value = images['P'] || '';
                        document.getElementById('enemy-url').value = images['E'] || '';
                        document.getElementById('obstacle-url').value = images['#'] || '';
                        document.getElementById('goal-url').value = images['&'] || '';
                        document.getElementById('gold-url').value = images['$'] || '';
                        document.getElementById('wall1-url').value = images['['] || '';
                        document.getElementById('wall2-url').value = images[']'] || '';
                        
                        playerPosition = findPlayerPosition(); // Find the new player position
                        goldCollected = 0; // Reset gold for the imported game
                        initGrid(); // Reinitialize the grid with the imported data
                    } else {
                        alert("No valid gridArray or images found in the selected file.");
                    }
                };
                reader.readAsText(file);
            } else {
                alert("Please select a file.");
            }
        }

        // Initialize the grid when the page loads
        window.onload = initGrid;
    </script>
</body>
</html>