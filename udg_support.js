/**
 * udg_support.js (<script src="udg_support.js"></script>    )
 *
 * v004e - 251223e
 *
 *
 *
 *
 * NOTE: YOu must use this with the modified UDG Basic tempalte
 *
 * Adds ZX Spectrum UDG support to the HTML Game Engine.
 * - Adds image previews for URL inputs.
 * - Converts UDG data to PNGs for live gameplay.
 * - Injects UDG definitions into the BASIC export.
 */

// --- 1. Helper Function: Convert UDG Data to PNG Base64 ---
function udgToPng(bytes) {
    const canvas = document.createElement('canvas');
    canvas.width = 8;
    canvas.height = 8;
    const ctx = canvas.getContext('2d');

    // ZX Spectrum Colors (Default: Black Ink on White Paper)
    const paperColor = '#FFFFFF'; 
    const inkColor = '#000000';    

    // Draw Paper (Background)
    ctx.fillStyle = paperColor;
    ctx.fillRect(0, 0, 8, 8);

    // Draw Ink (Pixels)
    ctx.fillStyle = inkColor;
    for (let y = 0; y < 8; y++) {
        // Safety check
        if (bytes[y] === undefined) continue;
        
        const byte = bytes[y];
        for (let x = 0; x < 8; x++) {
            // Read bits from left (7) to right (0)
            if ((byte >> (7 - x)) & 1) {
                ctx.fillRect(x, y, 1, 1);
            }
        }
    }
    return canvas.toDataURL('image/png');
}

// --- 2. Helper Function: Check if text is UDG data ---
function parseUdgInput(text) {
    if (!text) return null; // Empty input
    
    // Regex explanation: Look for 8 groups of digits separated by commas
    const parts = text.split(',').map(s => s.trim());

    // Check if we have exactly 8 parts and all are numbers 0-255
    if (parts.length === 8) {
        const allValid = parts.every(part => {
            const num = parseInt(part, 10);
            return !isNaN(num) && num >= 0 && num <= 255;
        });

        if (allValid) {
            // Convert to integers
            return parts.map(Number);
        }
    }
    return null; // Not UDG data
}

// --- 3. Helper Function: Get Image Source (Handles both URLs and UDG) ---
function resolveImageSource(inputText) {
    const udgBytes = parseUdgInput(inputText);
    if (udgBytes) {
        return udgToPng(udgBytes);
    }
    return inputText; // Return original URL
}


// 3.2 - Returns the character that We will define in ZX basic
function getUDGchar(id) {
  const lookupTable = {
    "player-url":   "p", //"player-url": "p",
    "enemy-url":    "e", //"enemy-url": "e",
    "enemy2-url":   "r",
    "enemy3-url":   "t",
    "item1-url":    "i",
    "obstacle-url": "o", //"obstacle-url": "#",
    "goal-url":     "q", //"goal-url": "&",
    "gold-url":     "g", //"gold-url": "$",
    "wall1-url":    "j", //"wall1-url": "[",
    "wall2-url":    "k" //"wall2-url": "]"
  };

  return lookupTable[id] || null; // returns null if id not found
}


// --- 4. NEW: Helper Function to generate BASIC UDG DATA lines ---
function getUdgBasicLines() {
    // The list of input IDs to check, in the order we want to export them
    const inputIds = [
        'player-url', 
        'enemy-url', 
        'enemy2-url', 
        'enemy3-url', 
        'item1-url', 
        'obstacle-url', 
        'goal-url', 
        'gold-url', 
        'wall1-url', 
        'wall2-url'
    ];

    const lines = [];
    // Map data usually ends at 340 (20 lines * 10 steps starting at 150).
    // We start our UDG definitions at 341.
    let lineNumber = 341;

    inputIds.forEach(id => {
        const inputElement = document.getElementById(id);
        
        // Only generate a line if the input exists and contains valid UDG data
        if (inputElement) {
            const udgBytes = parseUdgInput(inputElement.value);
            if (udgBytes) {
                const dataString = udgBytes.join(',');
                // Format: 341 DATA ... : REM player-url
                //lines.push(`${lineNumber} DATA ${dataString} : REM ${id}`);  //OK ORIGINAL 
                //lines.push(`${lineNumber} DATA ${dataString} : REM ${id}`);
                udgdefineline=`${lineNumber} RESTORE ${lineNumber}:FOR c = 0 TO 7: READ n : POKE USR (`+'"'+getUDGchar(id)+'"'+`) + c, n : NEXT c : DATA ${dataString} :LET ${getUDGchar(id)}defined=1 : REM ${id}` ;
                //udgdefineline=`${lineNumber} RESTORE ${lineNumber}:DATA ${dataString} : REM ${id}` ;
                lines.push(udgdefineline);

                lineNumber++;
            }
        }
    });

    return lines.join('\n');
}

// --- 5. Initialization & Event Listeners ---
document.addEventListener('DOMContentLoaded', () => {
    
    // A. Find all inputs inside the .image-inputs container
    const inputs = document.querySelectorAll('.image-inputs input[type="text"]');

    inputs.forEach(input => {
        // Create a preview image element
        const previewImg = document.createElement('img');
        previewImg.alt = "Preview";
        previewImg.style.height = "32px"; 
        previewImg.style.width = "32px";
        previewImg.style.verticalAlign = "middle";
        previewImg.style.border = "1px solid #ccc";
        previewImg.style.marginLeft = "5px";
        previewImg.style.imageRendering = "pixelated"; 
        
        // Insert the preview after the input
        input.parentNode.insertBefore(previewImg, input.nextSibling);
        // Add a line break
        const spacer = document.createElement("br");
        input.parentNode.insertBefore(spacer, previewImg.nextSibling);

        // Add Event Listener for live preview
        const updatePreview = () => {
            const src = resolveImageSource(input.value);
            previewImg.src = src || "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"; 
        };

        updatePreview();
        input.addEventListener('input', updatePreview);
    });

    // B. Override getSymbolImage for Runtime Gameplay
    if (window.getSymbolImage) {
        const originalGetSymbolImage = window.getSymbolImage;

        window.getSymbolImage = function(symbol) {
            // Determine which input ID corresponds to the symbol
            let inputId = '';
            switch (symbol) {
                case 'P': inputId = 'player-url'; break;
                case 'E': inputId = 'enemy-url'; break;
                case 'E2': inputId = 'enemy2-url'; break;
                case 'E3': inputId = 'enemy3-url'; break;
                case 'I1': inputId = 'item1-url'; break;
                case '#': inputId = 'obstacle-url'; break;
                case '&': inputId = 'goal-url'; break;
                case '$': inputId = 'gold-url'; break;
                case '[': inputId = 'wall1-url'; break;
                case ']': inputId = 'wall2-url'; break;
                default: return originalGetSymbolImage(symbol);
            }

            const inputElement = document.getElementById(inputId);
            if (!inputElement) return originalGetSymbolImage(symbol);

            const rawValue = inputElement.value;
            const finalSrc = resolveImageSource(rawValue);

            // If it wasn't UDG data, just return the original result
            if (finalSrc === rawValue) {
                return originalGetSymbolImage(symbol);
            }
            
            return finalSrc;
        };
    }

    // C. Override convertToBasicData for EXPORT functionality
    // We intercept the export process to append our custom UDG DATA lines.
    if (window.convertToBasicData) {
        const originalConvertToBasicData = window.convertToBasicData;

        window.convertToBasicData = function(gridArray, gridSize) {
            // 1. Get the standard map data (lines 150 - 340)
            let basicCode = originalConvertToBasicData(gridArray, gridSize);

            // 2. Get our generated UDG data (lines 341+)
            const udgCode = getUdgBasicLines();

            // 3. Append UDG code if any exists
            if (udgCode) {
                basicCode += "\n" + udgCode;
            }

            return basicCode;
        };
    }
});