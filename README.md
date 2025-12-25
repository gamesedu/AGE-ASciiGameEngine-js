# AGE-ASciiGameEngine-js
ASCII Game Engine - Very simple Ascii maze generatior. Exports Standalone 2d,3d htmls and ZX Spectrum BASIC code.

<h1>AGE : ASCII Game Engine</h1>
<p><br></p>
<hr>
<h2>Introduction</h2>
<hr>
<p>AGE is a minimal game engine that I made because I wanted something extremely light and suitable for very small ages. I used bitsy in the past and it&nbsp;is very good. I just wanted something simpler.&nbsp;</p>
<p>So, A.G.E. was born.&nbsp;&nbsp;</p>
<hr>
<h2>Instructions</h2>
<hr>
<p>Put the files html_game_engine.html and htmlTemplate.html to your root of your server.</p>
<p>If you wish, rename the html_game_engine.html to index.html.&nbsp;</p>
<p>You must open with your browser <strong>myserver.com/html_game_engine.html</strong>.&nbsp;</p>
<p>The template file is used when you export the game.</p>
<p>In the main grid you select a symbol from the drop down menu.&nbsp;</p>
<p>Symbols are eg Player "p", Enemy "E" , End goal "&" , Gold "G" and Wall "W" etc.</p>
<p>You place the symbols in the grid and you create the game area.</p>
<hr>
<h2>Image URLs</h2>
<hr>
<p>You can you can visit from the drop down a site with free icons (like flaticon.com).</p>
<p>When you find the image you like right click on it and select "Copy Image adress". Paste this URL to the textbox you want.</p>
<p>Select the grid and you will see that the symbol is now replaced by the image.</p>
<p>I suggest you use images/icons URLs that have size 32,64 or 128pixels.</p>
<p>ZX Spectrum BASIC export: instead of image URL you can enter UDG data for an 8x8bit sprite (ZX Spectrum). For example entering 56,120,16,57,254,60,126,36 is a girl icon . In the exported BASIC file you will get UDG code. In 2d and 3d tempaltes you will get a black image or the defaulr ascii character.</p>
<p><br></p>
<p>*Note*: <strong>No image is stored in the game file. </strong>The game file just stores URLs. If you don't want to rely in external sites you could use/download the images you want and store them in a subfolder. You can then modify all the URLs to point to your subfolder (eg img/pirateship.png).</p>
<p></p>
<hr>
<h2>Export Game</h2>
<hr>
<p>When you are happy with the game press export or export3d. A html file will be saved in your computer.</p>
<p>You can drag and drop that game in your browser to play it.</p>
<p>The exported file can be used stand alone.&nbsp;</p>
<hr>
<h2>Export Game - ZX Spectrum BASIC</h2>
<hr>
<p>This will export a ZX Spectrum BASIC source file. File will contain DATA entries for generating the UDG (User Defined Graphics) that you entered.&nbsp; Sample entries for entering (instead of URLs) :&nbsp; 56,120,16,57,254,60,126,36 (girl) and 7,7,7,7,255,124,56,56 (toilet).&nbsp;0,0,0,124,188,124,60,60 (coffee mug) and&nbsp;97,102,102,255,66,66,66,66 (table).&nbsp;In 2d and 3d tempaltes you will get a black image or the defaulr ascii character.</p>
<hr>
<h2>Import Game</h2>
<hr>
<p>-You can import any game that was made with this engine. The import function searches only for specific parts inside the game file. This means that you can use your own modified template file as long as you keep these parts intact. At this point the parts used are the grid map and the image sources.&nbsp;</p>
<p>-To get started you can try to import and modify one of the demos.&nbsp;</p>
<p>-You can also import/export a game to update it to the latest template version.</p>
<hr>
<h2>Project Goals:</h2>
<hr>
<ul><li>Goal of the game is to use this for a class lesson.&nbsp;</li><li>If you want something more complex ,try bitsy.&nbsp;</li><li>If you find something simpler and usable leave a comment and I will have a look.</li><li>I wanted it to run in a very old browser (that is used to run native flash/swf educational games). usually I test this in an old&nbsp;Chromium v61 browser.</li><li>The script does not need a server to run but CORS policies restrict it.&nbsp;</li></ul>
<hr>
<h2>Why name it ASCII Game Engine?</h2>
<hr>
<p><strong>Why ASCII Game Engine?</strong>&nbsp;</p>
<p>ASCII : The engine uses ASCII characters and symbols as its foundation, which was the initial idea behind it. The images are simply replacements for those symbols.&nbsp;</p>
<p>Engine: Technically, it's not really an engine; it's more of a designer. However, the initials "AGD" were already taken (by the ZX Spectrum Arcade Game Designer).&nbsp;</p>
<p>So if you don't like the name, feel free to focus on the middle part: "Game." It definitely has something to do with gaming! :)<span></span></p>
<hr>
<h2>Know issues</h2>
<p>
</p>
<p>To refresh the template images you must click inside the grid. Then the images will get updated.</p>
<hr>
<hr>
<h2>To DO:</h2>
<hr>
<p>-Add item as requirement to handle enemy or to bypass obstacle (eg sword for monster or key for door). Nothing complex.</p>
<p>-Add translation (this is a priority since the goal is to be used in a school class ). {Translation is done and working. Just need to decide if I will keep text placeholders or switch (back) to plain english text in the main template.}</p>
<p>-Maybe custom grid size (or not squared).Or maybe add 2-3 hidden rooms near the 20x20 grid&nbsp;. These could be inside of house,cave etc.</p>
<p>-I could use an API to select icons directly from the drop box without visiting another page and copy/paste the URL but I don't know if it is practical + I don't like external dependecies.</p>
<p>-Associate text with grid coordnates. This will help storytelling,give clues etc.&nbsp;(This will be done by adding a placeholder in the templateFile for gridText.).</p>
<p>-Win condition option: Collect only one end game item or all&nbsp;(or specific number).</p>
<p>- Per grid tile : Background color or bg&nbsp;image&nbsp;<br></p>
<p>- Dynamic&nbsp;external&nbsp;JS&nbsp;script&nbsp;loading-&nbsp;load&nbsp;the&nbsp;script&nbsp;only&nbsp;if&nbsp;file&nbsp;exists (simple plug-in system)</p>
<p>- Add template for generating games forvarious&nbsp; retro machines (eg export ZX Spectrum Basic code). This is a side project which will be quite easy (I think).</p>
<p>- ZX Spectrum BASIC template. Seems to work - UDG implemented</p>
<hr>
<h2>Credits:</h2>
<hr>
<p>Icons used are from <strong>flaticon.com</strong>. No file is stored in the game file. Only the URLs are saved.</p>



# Icons
Some icons were saved locally here because AGE game was designed to be used in a local computer lab environment. The icons saved are from flaticon.com.
Note in itch.io the icons are removed.