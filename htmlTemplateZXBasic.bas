1 REM <pre>
10 REM Simple Collector Game for ZX Spectrum -
11 REM BASIC Template version v007f2-251223f CollisionDetection
20 REM Uses DIM g$(20,20) - proper 2D character array
30 REM WASD to move, collect E R T & $ I 2 3
40 LET gridSize=<!-- gridSize --> 
50 DIM g$(gridSize,gridSize,1)
60 LET score=0
65 LET pdefined=0 :LET  edefined=0 :LET  rdefined=0 :LET  tdefined=0 :LET  idefined=0 :LET  qdefined=0 :LET  gdefined=0 :LET  jdefined=0 :LET  kdefined=0: REM define UDG status vars
70 LET pr=13: LET pc=19: REM Player start position (1-based)
80 REM Load map row by row into 2D array
90  FOR i=1 TO gridSize
110   FOR j=1 TO gridSize
115     READ r$
120     LET g$(i,j)=r$
130   NEXT j
140 NEXT i
<!-- gridArray -->
359 REM Clear starting position
360 LET g$(pr,pc)="."
370 REM Initial draw - map centred (columns 6-25)
380 CLS 
381 GOSUB 7000: REM Replace P E R T with UDGs 
390 FOR i=1 TO gridSize
400   FOR j=1 TO gridSize
410     PRINT AT i-1,5+j;g$(i,j);
420   NEXT j
430 NEXT i
440 PRINT AT pr-1,5+pc;"P":IF pdefined=1 THEN PRINT AT pr-1,5+pc;CHR$(47 + CODE "p")
450 PRINT AT 21,0;"SCORE: ";score;"     "
460 REM Main game loop
470 LET k$=INKEY$
480 IF k$="" THEN GO TO 470
490 LET dr=0: LET dc=0
500 IF k$="W" OR k$="w" THEN LET dr=-1
510 IF k$="S" OR k$="s" THEN LET dr=1
520 IF k$="A" OR k$="a" THEN LET dc=-1
530 IF k$="D" OR k$="d" THEN LET dc=1
540 IF dr=0 AND dc=0 THEN GO TO 470
550 LET nr=pr+dr: LET nc=pc+dc
560 IF nr<1 OR nr>gridSize OR nc<1 OR nc>gridSize THEN GO TO 470
570 LET c$=g$(nr,nc)
580 IF c$="[" OR c$="]" OR c$=CHR$(47 + CODE "j") OR c$=CHR$(47 + CODE "k") OR c$="#" OR c$=CHR$(47 + CODE "o") THEN GO TO 470
585 IF c$="I" OR c$=CHR$(47 + CODE "i") THEN LET score=score+2: LET g$(nr,nc)=".": PRINT AT nr-1,5+nc;".": PRINT AT 21,0;"SCORE: ";score;"     ": GO TO 650
590 IF c$="&" OR c$=CHR$(47 + CODE "q") OR c$="$" OR c$=CHR$(47 + CODE "g") OR c$="E" OR c$=CHR$(47 + CODE "e") OR c$="R" OR c$=CHR$(47 + CODE "r") OR c$="T" OR c$=CHR$(47 + CODE "t") THEN LET score=score+1: LET g$(nr,nc)=".": PRINT AT nr-1,5+nc;".": PRINT AT 21,0;"SCORE: ";score;"     "
600 IF c$="&" OR c$=CHR$(47 + CODE "q") THEN GO TO 900
650 REM Erase old player
660 PRINT AT pr-1,5+pc;"."
670 LET pr=nr: LET pc=nc
680 PRINT AT pr-1,5+pc;"P":IF pdefined=1 THEN PRINT AT pr-1,5+pc;CHR$(47 + CODE "p")
690 GO TO 470
900 REM Win!
910 CLS 
920 PRINT AT 10,6;"*** YOU WIN! ***"
930 PRINT AT 12,6;" SCORE: ";score
940 PRINT AT 15,8;"PRESS ANY KEY"
950 PAUSE 0
960 LET score=0
970 LET pr=13: LET pc=19
980 RESTORE 150
990 GO TO 80
1000 STOP
7000 REM Replace Characters with their UDG
7100 FOR i=1 TO gridSize
7110   FOR j=1 TO gridSize
7120     IF pdefined=1 THEN IF g$(i,j)="P" THEN LET g$(i,j)=CHR$(47 + CODE "p")
7130     IF edefined=1 THEN IF g$(i,j)="E" THEN LET g$(i,j)=CHR$(47 + CODE "e")
7140     IF rdefined=1 THEN IF g$(i,j)="R" THEN LET g$(i,j)=CHR$(47 + CODE "r")
7150     IF tdefined=1 THEN IF g$(i,j)="T" THEN LET g$(i,j)=CHR$(47 + CODE "t")
7160     IF idefined=1 THEN IF g$(i,j)="I" THEN LET g$(i,j)=CHR$(47 + CODE "i")
7170     IF idefined=1 THEN IF g$(i,j)="#" THEN LET g$(i,j)=CHR$(47 + CODE "o")
7180     IF qdefined=1 THEN IF g$(i,j)="&" THEN LET g$(i,j)=CHR$(47 + CODE "q")
7190     IF gdefined=1 THEN IF g$(i,j)="$" THEN LET g$(i,j)=CHR$(47 + CODE "g")
7200     IF jdefined=1 THEN IF g$(i,j)="[" THEN LET g$(i,j)=CHR$(47 + CODE "j")
7210     IF kdefined=1 THEN IF g$(i,j)="]" THEN LET g$(i,j)=CHR$(47 + CODE "k")
7300   NEXT j
7310 NEXT i
7500 RETURN 
9999 REM </pre>
