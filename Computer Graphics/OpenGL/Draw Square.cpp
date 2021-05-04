#include <GL/freeglut.h>
#include <iostream>
using namespace std;


void displayPoint()
{
	glClearColor(1,1,1,1);
	glClear(GL_COLOR_BUFFER_BIT);

	glColor3f(1, 0, 0.8);
	glLineWidth(7);

	glBegin(GL_LINE_LOOP);
	glVertex2f(0, 0);
	glVertex2f(30, 0);
	glVertex2f(30, 0);
	glVertex2f(30, 30);
	glVertex2f(30, 30);
	glVertex2f(0, 30);
	glEnd();

	glFlush();
}



int main(int argc, char**argv) {

	glutInit(&argc, argv);
	glutInitWindowPosition(188, 127);
	glutInitWindowSize(500, 500);
	glutCreateWindow("point");
	glutDisplayFunc(displayPoint);
	gluOrtho2D(-50, 50, -50, 50);

	glutMainLoop();
	return 0;
}
