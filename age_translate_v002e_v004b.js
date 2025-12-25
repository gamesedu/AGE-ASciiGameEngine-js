/*
	//v002e_v004b Added check for client language to check if we have Greek/El language
    //v002d_v004b ?lang=gr for greek  & Translation is set from age_translate script static (dynamic had issues) 
    //v002c_v004b seem to work Translate test 
*/

let translate_lang="en"; //"en", "gr"
document.addEventListener("DOMContentLoaded", function() {
	const translations = {
	    "gr": {
	        TITLE_PLACEHOLDER: "A.G.E. Ascii Game Engine",
	        GAME_TITLE_LABEL_PLACEHOLDER: "Τίτλος Παιχνιδιού",        
	        PLAY_BUTTON_PLACEHOLDER: "Παίξε",
	        EXPORT_BUTTON_PLACEHOLDER: "Εξαγωγή",
	        IMPORT_BUTTON_PLACEHOLDER: "Εισαγωγή",
	        CURRENT_SYMBOL_TEXT_PLACEHOLDER: "Τρέχων Συμβολισμός",
	        CHOOSE_SYMBOL_LABEL_PLACEHOLDER: "Επιλέξτε ένα σύμβολο",
	        PLAYER_LABEL_PLACEHOLDER: "Παίκτης",
	        ENEMY_LABEL_PLACEHOLDER: "Εχθρός",
	        ENEMY2_LABEL_PLACEHOLDER: "Εχθρός 2",
	        ENEMY3_LABEL_PLACEHOLDER: "Εχθρός 3",
	        ITEM1_LABEL_PLACEHOLDER: "Αντικείμενο 1",
	        OBSTACLE_LABEL_PLACEHOLDER: "Εμπόδιο",
	        GOAL_LABEL_PLACEHOLDER: "Στόχος",
	        END_GAME_SYMBOL_PLACEHOLDER: "Τέλος παιχνιδιού",
	        GOLD_LABEL_PLACEHOLDER: "Χρυσός",
	        WALL1_LABEL_PLACEHOLDER: "Τύπος Τοίχου 1",
	        WALL2_LABEL_PLACEHOLDER: "Τύπος Τοίχου 2",
	        EMPTY_SQUARE_LABEL_PLACEHOLDER: "Κενό Τετράγωνο",
	        DEFAULT_GAME_TITLE_PLACEHOLDER: "MyGameTitle",
	        LEGEND_HEADING_PLACEHOLDER: "Σύμβολα",
	        IMAGE_URLS_HEADING_PLACEHOLDER: "URL Εικόνων",
	        IMAGE_URL_PLACEHOLDER: "URL Εικόνας",
	        SOME_IMAGE_IDEAS_PLACEHOLDER: "Μερικές Ιδέες Εικόνας",
	        FLATICON_IMAGES_PLACEHOLDER: "εικόνες flaticon",
	        PASTE_IMAGE_URL_PLACEHOLDER: "επικολλήστε το URL της εικόνας",
	        SEARCH_FOR_MORE_IMAGES_PLACEHOLDER: "Αναζητήστε περισσότερες εικόνες στο διαδίκτυο",
	        VISIT_BUTTON_PLACEHOLDER: "Επίσκεψη",
	        WIN_MESSAGE_PLACEHOLDER: "Κέρδισες! Συγκέντρωσες {GOLD_COLLECTED} χρυσό.",
	        NEW_TAB_ERROR_MESSAGE_PLACEHOLDER: "Δεν μπορέσαμε να ανοίξουμε τη νέα καρτέλα. Ελέγξτε τις ρυθμίσεις του προγράμματος περιήγησης.",
	        NO_VALID_FILES_MESSAGE_PLACEHOLDER: "Δεν βρέθηκε έγκυρο gridArray ή images στο επιλεγμένο αρχείο.",
	        SELECT_FILE_MESSAGE_PLACEHOLDER: "Παρακαλώ επιλέξτε ένα αρχείο.",
	        SOME_DEMOS_PLACEHOLDER: "Ορισμένα Demo",
	    },
	    "en": {
	        TITLE_PLACEHOLDER: "A.G.E. Ascii Game Engine",
	        GAME_TITLE_LABEL_PLACEHOLDER: "Game Title",        
	        PLAY_BUTTON_PLACEHOLDER: "Play",
	        EXPORT_BUTTON_PLACEHOLDER: "Export",
	        IMPORT_BUTTON_PLACEHOLDER: "Import",
	        CURRENT_SYMBOL_TEXT_PLACEHOLDER: "Current Symbol",
	        CHOOSE_SYMBOL_LABEL_PLACEHOLDER: "Choose a Symbol",
	        PLAYER_LABEL_PLACEHOLDER: "Player",
	        ENEMY_LABEL_PLACEHOLDER: "Enemy",
	        ENEMY2_LABEL_PLACEHOLDER: "Enemy 2",
	        ENEMY3_LABEL_PLACEHOLDER: "Enemy 3",
	        ITEM1_LABEL_PLACEHOLDER: "Item 1",
	        OBSTACLE_LABEL_PLACEHOLDER: "Obstacle",
	        GOAL_LABEL_PLACEHOLDER: "Goal",
	        END_GAME_SYMBOL_PLACEHOLDER: "End Game",
	        GOLD_LABEL_PLACEHOLDER: "Gold",
	        WALL1_LABEL_PLACEHOLDER: "Wall Type 1",
	        WALL2_LABEL_PLACEHOLDER: "Wall Type 2",
	        EMPTY_SQUARE_LABEL_PLACEHOLDER: "Empty Square",
	        DEFAULT_GAME_TITLE_PLACEHOLDER: "MyGameTitle",
	        LEGEND_HEADING_PLACEHOLDER: "Symbols",
	        IMAGE_URLS_HEADING_PLACEHOLDER: "Image URLs",
	        IMAGE_URL_PLACEHOLDER: "Image URL",
	        SOME_IMAGE_IDEAS_PLACEHOLDER: "Some Image Ideas",
	        FLATICON_IMAGES_PLACEHOLDER: "flaticon images",
	        PASTE_IMAGE_URL_PLACEHOLDER: "paste the image URL",
	        SEARCH_FOR_MORE_IMAGES_PLACEHOLDER: "Search for more images online",
	        VISIT_BUTTON_PLACEHOLDER: "Visit",
	        WIN_MESSAGE_PLACEHOLDER: "You won! You collected {GOLD_COLLECTED} gold.",
	        NEW_TAB_ERROR_MESSAGE_PLACEHOLDER: "We couldn't open the new tab. Please check your browser settings.",
	        NO_VALID_FILES_MESSAGE_PLACEHOLDER: "No valid gridArray or images found in the selected file.",
	        SELECT_FILE_MESSAGE_PLACEHOLDER: "Please select a file.",
	        SOME_DEMOS_PLACEHOLDER: "Some Demos",
	    }
	};
	translations["el"]=translations["gr"];

	//++++++++++++++Select language+++++++++++++++++
    // Get the current URL
    const currentUrl = window.location.href;
    const url = new URL(currentUrl);
    // Use URLSearchParams to get the parameter value
    const params = new URLSearchParams(url.search);

    let currentTranslations = translations["en"]; // Default to Greek/English


    // Get client's preferred language
	const clientLanguage = navigator.language || navigator.languages[0]; // Get the primary language
	console.log(`Client's preferred language: ${clientLanguage}`);

	// Example of how to use both checks
	if (!params.has('lang')) {

	    console.log(`Using client's language as fallback: ${clientLanguage}`);
	} else if (params.has('lang')){
	    console.log(`Using specified language from URL: lang=`+params.get('lang'));
	}
	if(clientLanguage=="el") { 	translate_lang="gr"; console.log ("clientLanguage =GREEK");	}



    // Check if `lang` parameter exists and get its value
    if (params.has('lang')) {
        const langValue = params.get('lang');
        if (langValue=="gr")
        	{ currentTranslations = translations["gr"];
        	  translate_lang="gr";
        	}
        else translate_lang="en";
        console.log('Language parameter value (langValue):', langValue);
    } else {
        console.log('Language parameter is not present in the URL.');
    }
    //---------------Select language-------------------
    

	


    if (translate_lang=="gr") currentTranslations = translations["gr"];
    //let originalHtml = document.body.innerHTML;
    //console.log(document.body.innerHTML);
    const replaceText = (placeholder, replacement) => {
        const elements = document.querySelectorAll("*");
        elements.forEach(el => {
            // Replace text nodes
            if (el.childNodes.length) {
                el.childNodes.forEach(node => {
                    if (node.nodeType === Node.TEXT_NODE && node.nodeValue.includes(placeholder)) {
                        node.nodeValue = node.nodeValue.replace(new RegExp(placeholder, 'g'), replacement);
                    }
                });
            }
            // Replace attributes of <input> elements
            if (el.tagName === "INPUT") {
                if (el.placeholder.includes(placeholder)) {
                    el.placeholder = el.placeholder.replace(new RegExp(placeholder, 'g'), replacement);
                }
                if (el.value.includes(placeholder)) {
                    el.value = el.value.replace(new RegExp(placeholder, 'g'), replacement);
                }
            }
        });
    };

    const updateTranslations = () => {
        console.log("updateTranslations");
        //console.log(currentTranslations);
        // Reset HTML to its original state
        
        // Clear previous translations
        for (const placeholder in currentTranslations) {
            if (currentTranslations.hasOwnProperty(placeholder)) {
                replaceText("{" + placeholder + "}", currentTranslations[placeholder]);
            }
        }
        //document.body.innerHTML = tempHtml;
    };

    /*
    // Create a language selector programmatically
    const languageSelector = document.createElement("select");
    languageSelector.id = "language-selector";
    const optionGreek = document.createElement("option");
    optionGreek.value = "gr";
    optionGreek.textContent = "GUI στα Ελληνικά";
    const optionEnglish = document.createElement("option");
    optionEnglish.value = "en";
    optionEnglish.textContent = "GUI in English";
    
    languageSelector.appendChild(optionGreek);
    languageSelector.appendChild(optionEnglish);
    
    document.body.insertBefore(languageSelector, document.body.lastChild); // Insert the selector at the top of the body

    languageSelector.addEventListener('change', (event) => {
        
        selectedLang = event.target.value;
        console.log("event:"+selectedLang);
        currentTranslations = selectedLang === "gr" ? translations["gr"] : translations["en"];
        updateTranslations();
    });
    */

    updateTranslations(); // Initial call to set translations
});