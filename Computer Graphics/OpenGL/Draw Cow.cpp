#include <GL/freeglut.h>
#include <iostream>
using namespace std;




void displayPoint()
{
	glClearColor(1,1,1,1);
	glClear(GL_COLOR_BUFFER_BIT);

	glColor3f(1, 0, 0.8);
	glLineWidth(5);

	glBegin(GL_LINE_STRIP);
	glVertex2f(5 ,10 );
	glVertex2f(15 , 10); 
	glVertex2f(15, 0);
	glVertex2f(40, 0);
	glVertex2f(40, 25);
	glVertex2f(15, 25);
	glVertex2f(15, 15);
	glVertex2f(5, 15);
	glVertex2f(5, 35);
	glVertex2f(-100, 35);
	glVertex2f(-124, 60);
	glVertex2f(-100, 30);
	glVertex2f(-100, -25);
	glVertex2f(-75, -25);
	glVertex2f(-75, -60);
	glVertex2f(-70, -60);
	glVertex2f(-70, -25);
	glVertex2f(-35, -25);
	glVertex2f(-35, -60);
	glVertex2f(-30, -60);
	glVertex2f(-30, -25);
	glVertex2f(5, -25);
	glVertex2f(5, 10);
	glEnd();

	glEnable(GL_POINT_SIZE);
	glPointSize(5);

	glBegin(GL_POINTS);
	glColor3f(1, 0, 0);
	glVertex2f(35, 20);
	glVertex2f(20, 20);
	glEnd();

	glBegin(GL_TRIANGLES);
	glVertex2f(23, 10);
	glVertex2f(33, 10);
	glVertex2f(28, 5);
	glEnd();

	glFlush();
}



int main(int argc, char**argv) {

	glutInit(&argc, argv);
	glutInitWindowPosition(188, 127);
	glutInitWindowSize(500, 500);
	glutCreateWindow("point");
	glutDisplayFunc(displayPoint);
	gluOrtho2D(-150, 150, -150, 150);

	glutMainLoop();
	return 0;
}
