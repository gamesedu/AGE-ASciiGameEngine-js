10 REM 3D MAZE CONVERTER - FIXED FOR ZXBASIC (1-based arrays)
20 REM Based on original map data
30 BORDER 0: PAPER 0: INK 7: CLS 
40 LET gridSize=20
50 DIM m$(gridSize,gridSize,1)
60 REM Pre-calculate SIN/COS tables (Indices 1 to 629)
70 DIM s(629): DIM c(629)
80 FOR i=1 TO 629
90 LET s(i)=SIN ((i-1)/100): LET c(i)=COS ((i-1)/100)
100 NEXT i
110 LET px=13.5: LET py=19.5: REM Player Position
120 LET pr=13: LET pc=19: REM Player Grid
130 LET pa=1.5: REM Player Angle (radians)
140 LET score=0
150 REM Load map row by row
160 RESTORE 220: FOR i=1 TO gridSize
170   FOR j=1 TO gridSize
180     READ r$ 
190     LET m$(i,j)=r$ 
200   NEXT j
210 NEXT i
220 DATA "[","[","[","[","[","[","[","[","[","[","[","[","[","[","[","[","[","[","[","["
230 DATA "[","&",".",".","[",".",".",".",".",".",".",".",".",".","[",".",".",".",".","["
240 DATA "[","$","$","$","[",".",".",".",".",".",".",".",".",".","[",".",".","$","$","["
250 DATA "[","$","$","$","[",".",".",".",".",".",".",".",".",".","[","R",".","$","$","["
260 DATA "[","$","$","$","T","E",".",".",".",".",".",".",".","E",".","R",".","$","$","["
270 DATA "[","[","[","[","[","#","#","#","#",".","#","#","#","#","[",".",".",".","$","["
280 DATA "[",".",".",".",".","#","#","#","#",".","#","#","#","#","[",".",".",".","$","["
290 DATA "[",".",".",".",".","#","#","#","#",".",".","R",".",".","[","[","[","[","[","["
300 DATA "[",".",".",".",".","#","#","#","#","#","#","#","#",".","#","#","#","#","#","["
310 DATA "[",".",".",".",".",".",".",".","$",".",".",".",".","E",".",".",".",".",".","["
320 DATA "[",".",".",".",".","R",".",".",".",".",".",".",".",".",".",".",".",".",".","["
330 DATA "[",".",".",".",".",".",".",".",".",".","$",".","$",".","$",".",".",".",".","["
340 DATA "[","[","[","[","[",".",".","$",".",".",".",".",".",".",".",".",".","$","P","]"
350 DATA "[",".",".","T",".","E",".",".",".",".",".",".",".",".",".",".",".",".",".","["
360 DATA "[",".","E",".","[",".","E",".",".",".",".",".","E",".",".",".",".",".",".","["
370 DATA "[",".",".",".","[",".",".",".",".",".",".",".",".",".",".","[","[","[","E","["
380 DATA "]","$","$","$","[",".",".",".",".",".",".",".",".",".",".","[","E","E","E","["
390 DATA "]","]","]","]","]","[","[","[","]",".",".","E",".",".",".","[","E","E","E","["
400 DATA "[","$","$","E","E","$","E","E",".","T",".",".",".",".",".","[","$","$","$","["
410 DATA "[","[","[","[","[","[","[","[","[","[","[","[","[","[","[","[","[","[","[","["
420 LET m$(pr,pc)="."
430 REM Main Game Loop
440 CLS 
450 GOSUB 1000: REM Draw 3D View
460 PRINT AT 21,0;"SCORE: ";score;"     "
470 PRINT AT 22,0;"A/D:Turn  W/S:Move"
480 LET k$=INKEY$ 
490 IF k$="" THEN GO TO 480
500 IF k$="a" OR k$="A" THEN LET pa=pa-0.15: GO TO 440
510 IF k$="d" OR k$="D" THEN LET pa=pa+0.15: GO TO 440
520 REM Normalize Angle 0 to 6.28
530 LET normAngle=pa-INT (pa/6.28318)*6.28318
540 IF normAngle<0 THEN LET normAngle=normAngle+6.28318
550 REM Calculate movement index (1 to 629)
560 LET idx=INT (normAngle*100)+1
570 LET dx=c(idx)*0.3: LET dy=s(idx)*0.3
580 IF k$="w" OR k$="W" THEN GOSUB 700
590 IF k$="s" OR k$="S" THEN LET dx=-dx: LET dy=-dy: GOSUB 700
600 GO TO 440
610 CLS : PRINT AT 10,10;"*** YOU WIN! ***": PRINT AT 12,12;"SCORE: ";score: PRINT AT 15,10;"PRESS ANY KEY": PAUSE 0: STOP
700 REM Movement
710 LET nx=px+dx: LET ny=py+dy
720 LET nr=INT nx: LET nc=INT ny
730 IF nr<1 OR nr>gridSize OR nc<1 OR nc>gridSize THEN RETURN
740 LET c$=m$(nr,nc)
750 IF c$="[" OR c$="]" OR c$="#" THEN RETURN
760 LET px=nx: LET py=ny: LET pr=nr: LET pc=nc
770 IF c$="I" THEN LET score=score+2: LET m$(nr,nc)=".": RETURN
780 IF c$="$" OR c$="E" OR c$="R" OR c$="T" OR c$="&" THEN LET score=score+1: LET m$(nr,nc)=".": GO TO 810
790 RETURN
800 IF c$="&" THEN GO TO 610
810 RETURN
1000 REM 3D RENDERER
1010 FOR i=-15 TO 15 STEP 2
1020   LET ra=pa+i*0.04
1030   LET ra=ra-INT (ra/6.28318)*6.28318
1040   IF ra<0 THEN LET ra=ra+6.28318
1050   LET ri=INT (ra*100)+1: REM Index 1 to 629
1060   LET rx=px: LET ry=py
1070   LET sx=c(ri)*0.15: LET sy=s(ri)*0.15
1080   LET dist=0
1090   FOR s=1 TO 40
1100     LET rx=rx+sx: LET ry=ry+sy
1110     LET dist=dist+0.15
1120     LET mx=INT rx: LET my=INT ry
1130     IF mx<1 OR mx>gridSize OR my<1 OR my>gridSize THEN LET h$=" ": GO TO 1160
1140     LET h$=m$(mx,my)
1150     IF h$="[" OR h$="]" OR h$="#" THEN GO TO 1160
1160   NEXT s
1170   LET ca=i*0.04: LET dist=dist*COS ca
1180   IF dist=0 THEN LET dist=0.01
1190   LET wh=100/dist
1200   LET y1=88-wh/2: LET y2=88+wh/2
1210   LET xScreen=128+i*8
1220   IF h$="#" THEN INK 6
1230   IF h$="[" OR h$="]" THEN INK 2
1240   IF h$=" " THEN INK 0
1250   IF y1<0 THEN LET y1=0
1260   IF y2>175 THEN LET y2=175
1270   DRAW xScreen,y1: DRAW xScreen,y2
1280 NEXT i
1290 INK 7
1300 RETURN