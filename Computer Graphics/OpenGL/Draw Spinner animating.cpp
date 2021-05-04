#pragma comment(lib, "freeglut.lib")
#include<GL/freeglut.h>
#include <iostream>
#include<cmath>
#include <time.h>
#include <math.h>

using namespace std;

double xV[20] = {0};
double yV[20] = {0};
int ballsDelay[10] = {0};
const double long M_PI = 3.141592653589793238462643383279502884197169399375105820974944592307816406286;
double r = 25;   // radius
double a[10] = {0};    // angle (from 0 to Math.PI * 2)
double r2, a2;
int pathRadius = 3600*1.5;
int delayX = 25;
int nsize =  pathRadius * 0.00166666667 + 1;
bool stop = false, c = false;
int maxC = 0, minC = 0;



void DisplayColorfulShape()
{
	glClearColor(0, 0, 0, 0);
	glEnable(GL_POINT_SIZE_GRANULARITY);
	glEnable(GL_POINT_SIZE_RANGE);
	glPointSize(80);
	glEnable(GL_POINT_SMOOTH);
	glClear(GL_COLOR_BUFFER_BIT);
	glBegin(GL_POINTS);
	glColor3f(1, 0, 0);
	for (int i = 0; i < nsize; i++) {
		int randNum1 = round(rand() % 2);
		int randNum2 = round(rand() % 2);
		int randNum3 = round(rand() % 2);
		glColor3f(randNum1, randNum2, randNum3);
		glVertex2d(xV[i], yV[i]);
		glScalef(2, 1, 1);
	}
	
	glEnd();

	
		xV[0] += (r * cos(a[0])) / 1000; // division to slow down motion :D 
		yV[0] += (r * sin(a[0])) / 1000;
		a[0] = fmod((a[0] + M_PI / (pathRadius)), (M_PI * 2)); // angel controls radius of circular path

		// Delay progress
		for (int i = 0; i < nsize - 1; i++) {
			if (xV[i] > delayX) {
				ballsDelay[i+1] = 1;
			}
		}


		for (int i = 0; i < nsize; i++) {
			if (ballsDelay[i]) {
				xV[i] += (r * cos(a[i])) / 1000; // division to slow down motion :D 
				yV[i] += (r * sin(a[i])) / 1000;
				a[i] = fmod((a[i] + M_PI / (pathRadius)), (M_PI * 2));
			}
		}

		
	glFlush();
	glutPostRedisplay();

}
void Keyboard(unsigned char key, int x, int y)
{


}

void leftRIGHT(int key, int x, int y)
{

}

int main(int argc, char**argv)
{
	//srand(time(NULL));
	glutInit(&argc, argv);
	glutInitWindowPosition(100, 100);
	glutInitWindowSize(700, 700);
	glutCreateWindow("Draw a colorful shape");
	gluOrtho2D(-100, 100, -100, 100);///set x axix y axix
	glutDisplayFunc(DisplayColorfulShape);
	glutKeyboardFunc(Keyboard);
	glutSpecialFunc(leftRIGHT);
	glutMainLoop();
	return 0;
}