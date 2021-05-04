#include <GL/glut.h>
#include <GL\freeglut.h>
#include<math.h>
#include<cmath>
#include <time.h>
#include <math.h>


/*
Team 9

1- Zeyad Khaled - 73833
2- Hosam mahmoud - 73610
3- Khaled El Sayed - 73766
4- Ahmed Taha - 73759

*/


double xv[]{ 140 , 80 ,92,128,68,63 , 152,158,93,127 ,107,90,126,67, 97,85,95,82 };
double yv[]{ -170 ,-138 , -147 ,-130 , -119,-118 ,-140,-122,-150,-137 ,-152,-145 ,-159 ,-90 ,-125,-127 };

double xv2[]{ 140 - 200 , 80 - 200 ,92 - 200,128 - 200,68 - 200,63 - 200 , 152 - 200,158 - 200,93 - 200,127 - 200 ,107 - 200,90 - 200,126 - 200,67 - 200, 97 - 200,85 - 200,95 - 200,82 - 200 };
double yv2[]{ -170 ,-138 , -147 ,-130 , -119,-118 ,-140,-122,-150,-137 ,-152,-145 ,-159 ,-90 ,-125,-127 };

double xv3[]{ 140 , 80 ,92,128,68,63 , 152,158,93,127 ,107,90,126,67, 97,85,95,82 };
double yv3[]{ -170 + 200 + 30 ,-138 + 200 + 30 , -147 + 200 + 30 ,-130 + 200 + 30 , -119 + 200 + 30,-118 + 200 + 30 ,-140 + 200 + 30,-122 + 200 + 30,-150 + 200 + 30,-137 + 200 + 30 ,-152 + 200 + 30 ,-145 + 200 + 30 ,-159 + 200 + 30 ,-90 + 200 + 30 ,-125 + 200 + 30,-127 + 200 + 30 };

double xv4[]{ 140 - 200 , 80 - 200 ,92 - 200,128 - 200,68 - 200,63 - 200 , 152 - 200,158 - 200,93 - 200,127 - 200 ,107 - 200,90 - 200,126 - 200,67 - 200, 97 - 200,85 - 200,95 - 200,82 - 200 };
double yv4[]{ -170 + 200 ,-138 + 200 , -147 + 200 ,-130 + 200 , -119 + 200,-118 + 200 ,-140 + 200,-122 + 200,-150 + 200,-137 + 200 ,-152 + 200,-145 + 200 ,-159 + 200 ,-90 + 200 ,-125 + 200,-127 + 200 };

float stepX[] = { 0, 0.08 };
float stepY[] = { 0.085,  0.08 };

const double long M_PI = 3.141592653589793238462643383279502884197169399375105820974944592307816406286;
double car4Radius = 25;   // radius
double car4angel[2] = { 0 };    // angle (from 0 to Math.PI * 2)
int car4PathRadius = 360 * 25 * 2;


double circleVx[15]{ 110, 110, 110, 110, 110, 110, 110, 110, 110, 110, 110, 110, 110 , 110, 110 };
double circleVy[15]{ 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10 , 10, 10 };
int ballsDelay[15] = { 0 };
double r = 25;   // radius
double a[15] = { 0 };    // angle (from 0 to Math.PI * 2)
double r2, a2;
int pathRadius = 3600 * 1.1 / 2;
int delayX = 140;
int nsize = 15;

void CAR()
{
	glClearColor(0, 0, 0, 0);
	glClear(GL_COLOR_BUFFER_BIT);
	glColor3f(1, 1, 1);
	glLineWidth(4);
	glBegin(GL_LINES);
	glVertex2f(-200, 0);
	glVertex2f(200, 0);
	glVertex2f(0, -200);
	glVertex2f(0, 200);
	glEnd();

	float r = 6, r2 = 18;
	double PI = 22 / 7;
	double circle = 2 * PI;

	//CAR 1 -------------------------------------------------------------------------------------------------------------
	glBegin(GL_LINE_LOOP);


	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv[0] + sin(i)  *r * 0.7;
		double newy = yv[0] + cos(i) *r;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv[0] + sin(i) * r2 * 0.7;
		double newy = yv[0] + cos(i) * r2;
		glVertex2f(newx, newy);
	}
	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv[1] + sin(i) * r * 0.7;
		double newy = yv[0] + cos(i) * r;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv[1] + sin(i) * r2 * 0.7;
		double newy = yv[0] + cos(i) * r2;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[2], yv[0]);
	glVertex2f(xv[3], yv[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[4], yv[0]);
	glVertex2f(xv[5], yv[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[5], yv[0]);
	glVertex2f(xv[5], yv[1]);
	glEnd();


	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[6], yv[0]);
	glVertex2f(xv[7], yv[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[7], yv[0]);
	glVertex2f(xv[7], yv[2]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[8], yv[0]);
	glVertex2f(xv[8], yv[3]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[9], yv[0]);
	glVertex2f(xv[9], yv[4]);
	glEnd();

	glBegin(GL_LINE_STRIP);

	for (float i = PI / 2; i <= PI * 1.5; i += PI / 200)
	{
		double newx = xv[10] + sin(i) * 16 * 1.2;
		double newy = yv[5] + cos(i) * 16;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[5], yv[6]);
	glVertex2f(xv[11], yv[7]);
	glEnd();


	glBegin(GL_LINE_STRIP);
	for (float i = 0; i <= PI / 2; i += PI / 200)
	{
		double newx = xv[12] + sin(i) * 32 * 1;
		double newy = yv[8] + cos(i) * 32;
		glVertex2f(newx, newy);
	}
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[13], yv[9]);
	glVertex2f(xv[13], yv[0]);
	glEnd();


	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[5], yv[11]);
	glVertex2f(xv[13], yv[11]);
	glEnd();

	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[5], yv[10]);
	glVertex2f(xv[13], yv[10]);
	glEnd();

	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[5], yv[12]);
	glVertex2f(xv[13], yv[12]);
	glEnd();


	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[14], yv[13]);
	glVertex2f(xv[15], yv[14]);
	glEnd();

	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[16], yv[13]);
	glVertex2f(xv[17], yv[15]);
	glEnd();

	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv[16], yv[13]);
	glVertex2f(xv[14], yv[13]);
	glEnd();






	//CAR 2 -------------------------------------------------------------------------------------------------------------

	glLineWidth(4);
	glBegin(GL_LINE_LOOP);


	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv2[0] + sin(i) * r * 0.7;
		double newy = yv2[0] + cos(i) * r;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv2[0] + sin(i) * r2 * 0.7;
		double newy = yv2[0] + cos(i) * r2;
		glVertex2f(newx, newy);
	}
	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv2[1] + sin(i) * r * 0.7;
		double newy = yv2[0] + cos(i) * r;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv2[1] + sin(i) * r2 * 0.7;
		double newy = yv2[0] + cos(i) * r2;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[2], yv2[0]);
	glVertex2f(xv2[3], yv2[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[4], yv2[0]);
	glVertex2f(xv2[5], yv2[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[5], yv2[0]);
	glVertex2f(xv2[5], yv2[1]);
	glEnd();


	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[6], yv2[0]);
	glVertex2f(xv2[7], yv2[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[7], yv2[0]);
	glVertex2f(xv2[7], yv2[2]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[8], yv2[0]);
	glVertex2f(xv2[8], yv2[3]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[9], yv2[0]);
	glVertex2f(xv2[9], yv2[4]);
	glEnd();

	glBegin(GL_LINE_STRIP);

	for (float i = PI / 2; i <= PI * 1.5; i += PI / 200)
	{
		double newx = xv2[10] + sin(i) * 16 * 1.2;
		double newy = yv2[5] + cos(i) * 16;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[5], yv2[6]);
	glVertex2f(xv2[11], yv2[7]);
	glEnd();


	glBegin(GL_LINE_STRIP);
	for (float i = 0; i <= PI / 2; i += PI / 200)
	{
		double newx = xv2[12] + sin(i) * 32 * 1;
		double newy = yv2[8] + cos(i) * 32;
		glVertex2f(newx, newy);
	}
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[13], yv2[9]);
	glVertex2f(xv2[13], yv2[0]);
	glEnd();


	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[5], yv2[11]);
	glVertex2f(xv2[13], yv2[11]);
	glEnd();

	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[5], yv2[10]);
	glVertex2f(xv2[13], yv2[10]);
	glEnd();

	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[5], yv2[12]);
	glVertex2f(xv2[13], yv2[12]);
	glEnd();


	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[14], yv2[13]);
	glVertex2f(xv2[15], yv2[14]);
	glEnd();

	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[16], yv2[13]);
	glVertex2f(xv2[17], yv2[15]);
	glEnd();

	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv2[16], yv2[13]);
	glVertex2f(xv2[14], yv2[13]);
	glEnd();

	//CAR 3  -----------------------------------------------------------------------------------------------------------

	glLineWidth(4);
	glBegin(GL_LINE_LOOP);


	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv3[0] + sin(i) * r * 0.7;
		double newy = yv3[0] + cos(i) * r;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv3[0] + sin(i) * r2 * 0.7;
		double newy = yv3[0] + cos(i) * r2;
		glVertex2f(newx, newy);
	}
	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv3[1] + sin(i) * r * 0.7;
		double newy = yv3[0] + cos(i) * r;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv3[1] + sin(i) * r2 * 0.7;
		double newy = yv3[0] + cos(i) * r2;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[2], yv3[0]);
	glVertex2f(xv3[3], yv3[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[4], yv3[0]);
	glVertex2f(xv3[5], yv3[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[5], yv3[0]);
	glVertex2f(xv3[5], yv3[1]);
	glEnd();


	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[6], yv3[0]);
	glVertex2f(xv3[7], yv3[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[7], yv3[0]);
	glVertex2f(xv3[7], yv3[2]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[8], yv3[0]);
	glVertex2f(xv3[8], yv3[3]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[9], yv3[0]);
	glVertex2f(xv3[9], yv3[4]);
	glEnd();

	glBegin(GL_LINE_STRIP);

	for (float i = PI / 2; i <= PI * 1.5; i += PI / 200)
	{
		double newx = xv3[10] + sin(i) * 16 * 1.2;
		double newy = yv3[5] + cos(i) * 16;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[5], yv3[6]);
	glVertex2f(xv3[11], yv3[7]);
	glEnd();


	glBegin(GL_LINE_STRIP);
	for (float i = 0; i <= PI / 2; i += PI / 200)
	{
		double newx = xv3[12] + sin(i) * 32 * 1;
		double newy = yv3[8] + cos(i) * 32;
		glVertex2f(newx, newy);
	}
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[13], yv3[9]);
	glVertex2f(xv3[13], yv3[0]);
	glEnd();


	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[5], yv3[11]);
	glVertex2f(xv3[13], yv3[11]);
	glEnd();

	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[5], yv3[10]);
	glVertex2f(xv3[13], yv3[10]);
	glEnd();

	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[5], yv3[12]);
	glVertex2f(xv3[13], yv3[12]);
	glEnd();


	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[14], yv3[13]);
	glVertex2f(xv3[15], yv3[14]);
	glEnd();

	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[16], yv3[13]);
	glVertex2f(xv3[17], yv3[15]);
	glEnd();

	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv3[16], yv3[13]);
	glVertex2f(xv3[14], yv3[13]);
	glEnd();


	//CAR 4 -------------------------------------------------------------------------------------------------------------
	glLineWidth(4);
	glBegin(GL_LINE_LOOP);


	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv4[0] + sin(i) * r * 0.7;
		double newy = yv4[0] + cos(i) * r;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv4[0] + sin(i) * r2 * 0.7;
		double newy = yv4[0] + cos(i) * r2;
		glVertex2f(newx, newy);
	}
	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv4[1] + sin(i) * r * 0.7;
		double newy = yv4[0] + cos(i) * r;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);

	for (float i = 0; i <= circle; i += PI / 200)
	{
		double newx = xv4[1] + sin(i) * r2 * 0.7;
		double newy = yv4[0] + cos(i) * r2;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[2], yv4[0]);
	glVertex2f(xv4[3], yv4[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[4], yv4[0]);
	glVertex2f(xv4[5], yv4[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[5], yv4[0]);
	glVertex2f(xv4[5], yv4[1]);
	glEnd();


	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[6], yv4[0]);
	glVertex2f(xv4[7], yv4[0]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[7], yv4[0]);
	glVertex2f(xv4[7], yv4[2]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[8], yv4[0]);
	glVertex2f(xv4[8], yv4[3]);
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[9], yv4[0]);
	glVertex2f(xv4[9], yv4[4]);
	glEnd();

	glBegin(GL_LINE_STRIP);

	for (float i = PI / 2; i <= PI * 1.5; i += PI / 200)
	{
		double newx = xv4[10] + sin(i) * 16 * 1.2;
		double newy = yv4[5] + cos(i) * 16;
		glVertex2f(newx, newy);
	}

	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[5], yv4[6]);
	glVertex2f(xv4[11], yv4[7]);
	glEnd();


	glBegin(GL_LINE_STRIP);
	for (float i = 0; i <= PI / 2; i += PI / 200)
	{
		double newx = xv4[12] + sin(i) * 32 * 1;
		double newy = yv4[8] + cos(i) * 32;
		glVertex2f(newx, newy);
	}
	glEnd();

	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[13], yv4[9]);
	glVertex2f(xv4[13], yv4[0]);
	glEnd();


	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[5], yv4[11]);
	glVertex2f(xv4[13], yv4[11]);
	glEnd();

	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[5], yv4[10]);
	glVertex2f(xv4[13], yv4[10]);
	glEnd();

	glLineWidth(3);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[5], yv4[12]);
	glVertex2f(xv4[13], yv4[12]);
	glEnd();


	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[14], yv4[13]);
	glVertex2f(xv4[15], yv4[14]);
	glEnd();

	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[16], yv4[13]);
	glVertex2f(xv4[17], yv4[15]);
	glEnd();

	glLineWidth(2);
	glBegin(GL_LINE_LOOP);
	glVertex2f(xv4[16], yv4[13]);
	glVertex2f(xv4[14], yv4[13]);
	glEnd();

	// Circles
	glPointSize(33);
	glEnable(GL_POINT_SMOOTH);
	glBegin(GL_POINTS);
	glColor3f(1, 0, 0);
	for (int i = 0; i < nsize; i++) {
		int randNum1 = round(rand() % 2);
		int randNum2 = round(rand() % 2);
		int randNum3 = round(rand() % 2);
		glColor3f(randNum1, randNum2, randNum3);
		glVertex2d(circleVx[i], circleVy[i]);
	}

	glEnd();

	glFlush();

	//______________________________________ ANIMATION __________________________

	// Car 1 (Y-axis)
	for (int i = 0; i < 16; i++) {
		yv[i] = yv[i] - stepY[0];
		if (yv[i] < -200 || yv[i] > 0) {
			stepY[0] = -stepY[0];
		}
	}

	// Car2 (X-axis)
	for (int i = 0; i < 18; i++) {
		xv2[i] = xv2[i] - stepX[1];
		if (xv2[i] < -200 || xv2[i] > 0) {
			stepX[1] = -stepX[1];
		}
	}

	// Car2 (Y-axis)
	for (int i = 0; i < 16; i++) {
		yv2[i] = yv2[i] - stepY[1];
		if (yv2[i] < -200 || yv2[i] > 0) {
			stepY[1] = -stepY[1];
		}
	}

	// Car4 circular (X-axis)
	for (int i = 0; i < 18; i++) {
		xv4[i] += (car4Radius * cos(car4angel[0])) / 200; // division to slow down motion :D 
		car4angel[0] = fmod((car4angel[0] + M_PI / (car4PathRadius)), (M_PI * 2)); // angel controls radius of circular path
	}
	// Car4 circular (Y-axis)
	for (int i = 0; i < 16; i++) {
		yv4[i] += (car4Radius * sin(car4angel[1])) / 200;
		car4angel[1] = fmod((car4angel[1] + M_PI / (car4PathRadius)), (M_PI * 2));
	}

	// Balls animation
	circleVx[0] += (r * cos(a[0])) / 50;
	circleVy[0] += (r * sin(a[0])) / 50;
	a[0] = fmod((a[0] + M_PI / (pathRadius)), (M_PI * 2));

	// Delay progress
	for (int i = 0; i < nsize - 1; i++) {
		if (circleVx[i] > delayX) {
			ballsDelay[i + 1] = 1;
		}
	}
	// Animate the rest of balls
	for (int i = 0; i < nsize; i++) {
		if (ballsDelay[i]) {
			circleVx[i] += (r * cos(a[i])) / 50;
			circleVy[i] += (r * sin(a[i])) / 50;
			a[i] = fmod((a[i] + M_PI / (pathRadius)), (M_PI * 2));
		}
	}



	glutPostRedisplay();
}


int main(int argc, char** argv)
{
	glutInit(&argc, argv);
	glutInitWindowPosition(100, 0);
	glutInitWindowSize(1080, 720);
	glutCreateWindow("Team9");
	gluOrtho2D(-200, 200, -200, 200);
	glutDisplayFunc(CAR);
	glutMainLoop();
}