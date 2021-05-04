#include <GL/freeglut.h>
#include <iostream>
using namespace std;


void displayPoint()
{
	glClearColor(1,1,1,1);
	glClear(GL_COLOR_BUFFER_BIT);

	glColor3f(1, 0, 0.8);
	glLineWidth(7);
	// Triangle: width: 30px; transform: rotate(45deg);
	glBegin(GL_LINES);
	glVertex2f(0, 0);
	glVertex2f(21.21, 21.21);
	glVertex2f(21.21, 21.21);
	glVertex2f(-10.6, 31.81);
	glVertex2f(-10.6, 31.81);
	glVertex2d(0, 0);
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
